<?php
/**
 * Plugin Name: PowerPack for Beaver Builder
 * Plugin URI: https://wpbeaveraddons.com
 * Description: A set of custom, creative, unique modules for Beaver Builder to speed up your web design and development process.
 * Version: 2.7.7.6
 * Author: IdeaBox Creations
 * Author URI: https://ideaboxcreations.com
 * Copyright: (c) 2016 IdeaBox Creations
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bb-powerpack
 * Domain Path: /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class BB_PowerPack {
	/**
	 * Holds the class object.
	 *
	 * @since 1.1.4
	 * @var object
	 */
	public static $instance;

	/**
	 * Holds the upload dir path.
	 *
	 * @since 1.1.8
	 * @var array
	 */
	public static $upload_dir;

	/**
	 * Holds error messages.
	 *
	 * @since 1.1.8
	 * @var array
	 */
	public static $errors;

	/**
	 * Holds FontAwesome CSS class.
	 *
	 * @since 2.1
	 * @var string
	 */
	public $fa_css = '';

	/**
	 * Primary class constructor.
	 *
	 * @since 1.1.4
	 */
	public function __construct() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$lite_dirname   = 'powerpack-addon-for-beaver-builder';
		$lite_active    = is_plugin_active( $lite_dirname . '/bb-powerpack-lite.php' );
		$plugin_dirname = basename( dirname( dirname( __FILE__ ) ) );

		if ( class_exists( 'BB_PowerPack_Lite' ) || ( $plugin_dirname != $lite_dirname && $lite_active ) ) {
			add_action( 'admin_init', array( $this, 'deactivate_lite' ) );
			return;
		}

		self::$errors = array();

		$this->define_constants();

		/* Classes */
		require_once 'classes/class-pp-post-helper.php';
		require_once 'classes/class-pp-ajax.php';
		require_once 'classes/class-admin-settings.php';
		require_once 'classes/class-pp-templates-library.php';
		require_once 'classes/class-pp-header-footer.php';
		require_once 'classes/class-pp-maintenance-mode.php';
		require_once 'classes/class-media-fields.php';
		require_once 'classes/class-wpml-compatibility.php';
		require_once 'classes/class-pp-taxonomy-thumbnail.php';

		/* Includes */
		require_once 'includes/helper-functions.php';
		require_once 'includes/updater/update-config.php';

		/* WP CLI Commands */
		if ( defined( 'WP_CLI' ) ) {
			require_once 'classes/class-pp-wpcli-command.php';
		}

		/* Hooks */
		$this->init_hooks();
		$this->reset_hide_plugin();

		self::$upload_dir = pp_get_upload_dir();
	}

	/**
	 * Auto deactivate PowerPack Lite.
	 *
	 * @since 1.1.7
	 */
	public function deactivate_lite() {
		deactivate_plugins( 'bb-powerpack-lite/bb-powerpack-lite.php' );
	}

	/**
	 * Define PowerPack constants.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	private function define_constants() {
		define( 'BB_POWERPACK_VER', '2.7.7.6' );
		define( 'BB_POWERPACK_DIR', plugin_dir_path( __FILE__ ) );
		define( 'BB_POWERPACK_URL', plugins_url( '/', __FILE__ ) );
		define( 'BB_POWERPACK_PATH', plugin_basename( __FILE__ ) );
		define( 'BB_POWERPACK_CAT', $this->register_wl_cat() );
	}

	/**
	 * Initializes actions and filters.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'init', array( $this, 'load_modules' ) );
		add_action( 'plugins_loaded', array( $this, 'loader' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 9999 );
		add_action( 'wp_head', array( $this, 'render_scripts' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'network_admin_notices', array( $this, 'admin_notices' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Load language files.
	 *
	 * @since 1.1.4
	 * @return void
	 */

	public function load_textdomain() {
		load_plugin_textdomain( 'bb-powerpack', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Include modules.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_modules() {
		if ( ! class_exists( 'FLBuilder' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
			add_action( 'network_admin_notices', array( $this, 'admin_notices' ) );
			return;
		} else {
			$enabled_icons = FLBuilderModel::get_enabled_icons();

			if ( in_array( 'font-awesome-5-solid', $enabled_icons )
				|| in_array( 'font-awesome-5-regular', $enabled_icons )
				|| in_array( 'font-awesome-5-brands', $enabled_icons ) ) {
					$this->fa_css = 'font-awesome-5';
			} else {
				$this->fa_css = 'font-awesome';
			}

			// Fields
			require_once 'classes/class-module-fields.php';

			$load_modules_in_admin = apply_filters( 'pp_load_modules_in_admin', true );

			if ( $load_modules_in_admin ) {
				require_once 'includes/modules.php';
			} elseif ( ! is_admin() ) {
				require_once 'includes/modules.php';
			}
		}
	}

	/**
	 * Include row and column setting extendor.
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function loader() {
		if ( ! is_admin() && class_exists( 'FLBuilder' ) ) {

			// Panel functions
			require_once 'includes/panel-functions.php';

			$extensions = BB_PowerPack_Admin_Settings::get_enabled_extensions();

			/* Extend row settings */
			if ( isset( $extensions['row'] ) && count( $extensions['row'] ) > 0 ) {
				require_once 'includes/row.php';
			}

			/* Extend column settings */
			if ( isset( $extensions['col'] ) && count( $extensions['col'] ) > 0 ) {
				require_once 'includes/column.php';
			}
		}

		require_once 'classes/class-pp-module.php';

		$this->load_textdomain();
	}

	/**
	 * Register the styles and scripts.
	 *
	 * @since 2.5.0
	 * @return void
	 */
	public function register_scripts() {
		wp_register_style( 'pp-animate', BB_POWERPACK_URL . 'assets/css/animate.min.css', array(), '3.5.1' );
		wp_register_style( 'pp-jquery-fancybox', BB_POWERPACK_URL . 'assets/css/jquery.fancybox.min.css', array(), '3.3.5' );
		wp_register_style( 'jquery-justifiedgallery', BB_POWERPACK_URL . 'assets/css/justifiedGallery.min.css', array(), '3.7.0' );
		wp_register_style( 'jquery-swiper', BB_POWERPACK_URL . 'assets/css/swiper.min.css', array(), '4.4.6' );
		wp_register_style( 'owl-carousel', BB_POWERPACK_URL . 'assets/css/owl.carousel.css', array(), BB_POWERPACK_VER );
		wp_register_style( 'owl-carousel-theme', BB_POWERPACK_URL . 'assets/css/owl.theme.css', array( 'owl-carousel' ), BB_POWERPACK_VER );
		wp_register_style( 'jquery-slick', BB_POWERPACK_URL . 'assets/css/slick.css', array(), '1.6.0' );
		wp_register_style( 'jquery-slick-theme', BB_POWERPACK_URL . 'assets/css/slick-theme.css', array( 'jquery-slick' ), '1.6.0' );
		wp_register_style( 'tablesaw', BB_POWERPACK_URL . 'assets/css/tablesaw.css', array(), '2.0.1' );
		wp_register_style( 'twentytwenty', BB_POWERPACK_URL . 'assets/css/twentytwenty.css', array() );
		wp_register_style( 'tooltipster', BB_POWERPACK_URL . 'assets/css/tooltipster.bundle.min.css', array() );

		wp_register_script( 'pp-facebook-sdk', pp_get_fb_sdk_url(), array(), '2.12', true );
		wp_register_script( 'pp-twitter-widgets', BB_POWERPACK_URL . 'assets/js/twitter-widgets.js', array(), BB_POWERPACK_VER, true );
		wp_register_script( 'instafeed', BB_POWERPACK_URL . 'assets/js/instafeed.min.js', array( 'jquery' ), BB_POWERPACK_VER, true );
		wp_register_script( 'jquery-instagramfeed', BB_POWERPACK_URL . 'assets/js/jquery.instagramFeed.js', array( 'jquery' ), '1.2.0', true );
		wp_register_script( 'jquery-isotope', BB_POWERPACK_URL . 'assets/js/isotope.pkgd.min.js', array( 'jquery' ), '3.0.1', true );
		wp_register_script( 'jquery-colorbox', BB_POWERPACK_URL . 'assets/js/jquery.colorbox.js', array( 'jquery' ), '1.6.3', true );
		wp_register_script( 'jquery-cookie', BB_POWERPACK_URL . 'assets/js/jquery.cookie.min.js', array( 'jquery' ), '1.4.1' );
		wp_register_script( 'pp-jquery-plugin', BB_POWERPACK_URL . 'assets/js/jquery.plugin.js', array( 'jquery' ), BB_POWERPACK_VER, true );
		wp_register_script( 'pp-jquery-countdown', BB_POWERPACK_URL . 'assets/js/jquery.countdown.js', array( 'jquery', 'pp-jquery-plugin' ), '2.0.2', true );
		wp_register_script( 'pp-jquery-fancybox', BB_POWERPACK_URL . 'assets/js/jquery.fancybox.min.js', array( 'jquery' ), '3.3.5', true );
		wp_register_script( 'jquery-justifiedgallery', BB_POWERPACK_URL . 'assets/js/jquery.justifiedGallery.min.js', array( 'jquery' ), '3.7.0', true );
		wp_register_script( 'jquery-swiper', BB_POWERPACK_URL . 'assets/js/swiper.jquery.min.js', array( 'jquery' ), '4.4.6', true );
		wp_register_script( 'jquery-slick', BB_POWERPACK_URL . 'assets/js/slick.min.js', array( 'jquery' ), '1.6.0', true );
		wp_register_script( 'modernizr-custom', BB_POWERPACK_URL . 'assets/js/modernizr.custom.53451.js', array(), '3.6.0', true );
		wp_register_script( 'owl-carousel', BB_POWERPACK_URL . 'assets/js/owl.carousel.min.js', array( 'jquery' ), BB_POWERPACK_VER, true );
		wp_register_script( 'tablesaw', BB_POWERPACK_URL . 'assets/js/tablesaw.js', array( 'jquery' ), '2.0.1', true );
		wp_register_script( 'twentytwenty', BB_POWERPACK_URL . 'assets/js/jquery.twentytwenty.js', array( 'jquery' ), '', true );
		wp_register_script( 'jquery-event-move', BB_POWERPACK_URL . 'assets/js/jquery.event.move.js', array( 'jquery' ), '2.0.0', true );
		wp_register_script( 'tooltipster', BB_POWERPACK_URL . 'assets/js/tooltipster.main.js', array( 'jquery' ), '', true );
		wp_register_script( 'pp-jquery-carousel', BB_POWERPACK_URL . 'assets/js/jquery-carousel.js', array( 'jquery' ), '', true );
	}

	/**
	 * Custom scripts.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_scripts() {
		wp_enqueue_style( 'pp-animate' );
		if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
			wp_enqueue_style( 'pp-fields-style', BB_POWERPACK_URL . 'assets/css/fields.css', array(), BB_POWERPACK_VER );
			wp_enqueue_script( 'pp-fields-script', BB_POWERPACK_URL . 'assets/js/fields.js', array( 'jquery' ), BB_POWERPACK_VER, true );
			wp_enqueue_style( 'pp-panel-style', BB_POWERPACK_URL . 'assets/css/panel.css', array(), BB_POWERPACK_VER );
			wp_enqueue_script( 'pp-panel-script', BB_POWERPACK_URL . 'assets/js/panel.js', array( 'jquery' ), BB_POWERPACK_VER, true );
		}
	}

	/**
	 * Custom inline scripts.
	 *
	 * @since 1.3
	 * @return void
	 */
	public function render_scripts() {
		$app_id = pp_get_fb_app_id();

		if ( $app_id ) {
			printf( '<meta property="fb:app_id" content="%s" />', esc_attr( $app_id ) );
		}

		if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
		?>
		<style>
		form[class*="fl-builder-pp-"] .fl-lightbox-header h1:before {
			content: "<?php echo pp_get_admin_label(); ?> " !important;
			position: relative;
			display: inline-block;
			margin-right: 5px;
		}
		</style>
		<?php
		}
		if ( pp_get_google_api_url() ) {
			?>
			<!-- Google Map API URL -->
			<script src="<?php echo pp_get_google_api_url(); ?>" type="text/javascript"></script>
			<?php
		}
	}

	/**
	 * Admin notices.
	 *
	 * @since 1.1.1
	 * @return void
	 */
	public function admin_notices() {
		if ( ! is_admin() ) {
			return;
		} elseif ( ! is_user_logged_in() ) {
			return;
		} elseif ( ! current_user_can( 'update_core' ) ) {
			return;
		}

		if ( isset( $_GET['sl_activation'] ) && isset( $_GET['message'] ) ) {
			// uncomment below line to check license activation errors
			// self::$errors[] = $_GET['message'];
		}

		if ( ! class_exists( 'FLBuilder' ) ) {
			$bb_lite = '<a href="https://wordpress.org/plugins/beaver-builder-lite-version/" target="_blank">Beaver Builder Lite</a>';
			$bb_pro = '<a href="https://www.wpbeaverbuilder.com/pricing/" target="_blank">Beaver Builder Pro / Agency</a>';
			// translators: %1$s for Beaver Builder Lite link and %2$s for Beaver Builder Pro link.
			self::$errors[] = sprintf( esc_html__( 'Please install and activate %1$s or %2$s to use PowerPack add-on.', 'bb-powerpack' ), $bb_lite, $bb_pro );
		}

		if ( defined( 'FL_BUILDER_VERSION' ) && version_compare( FL_BUILDER_VERSION, '2.2.0', '<' ) ) {
			self::$errors[] = esc_html__( 'It seems Beaver Builder plugin is out dated. PowerPack requires Beaver Builder 2.2 or higher.', 'bb-powerpack' );
		}

		if ( count( self::$errors ) ) {
			foreach ( self::$errors as $key => $msg ) {
				?>
				<div class="notice notice-error">
					<p><?php echo $msg; ?></p>
				</div>
				<?php
			}
		}
	}

	/**
	 * Add CSS class to body.
	 *
	 * @since 1.1.1
	 * @param array $classes	Array of body CSS classes.
	 * @return array $classes	Array of body CSS classes.
	 */
	public function body_class( $classes ) {
		if ( class_exists( 'FLBuilder' ) && class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
			$classes[] = 'bb-powerpack';
			if ( function_exists( 'pp_panel_search' ) && pp_panel_search() == 1 ) {
				$classes[] = 'bb-powerpack-search-enabled';
			}
			if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
				$classes[] = 'bb-powerpack-ui';
			}
		}

		return $classes;
	}

	/**
	 * Register white label category
	 *
	 * @since 1.0.1
	 * @return string $ppwl
	 */
	public function register_wl_cat() {
		$ppwl = ( is_multisite() ) ? get_site_option( 'ppwl_builder_label' ) : get_option( 'ppwl_builder_label' );

		if ( '' == $ppwl || false == $ppwl ) {
			$ppwl = esc_html__( 'PowerPack Modules', 'bb-powerpack' );
		}

		return $ppwl;
	}

	public function reset_hide_plugin() {
		if ( ! is_admin() ) {
			return;
		}

		if ( isset( $_GET['pp_reset_wl_plugin'] ) ) {
			delete_option( 'ppwl_hide_plugin' );
			delete_site_option( 'ppwl_hide_plugin' );
		}
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @return object The BB_PowerPack object.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof BB_PowerPack ) ) {
			self::$instance = new BB_PowerPack();
		}

		return self::$instance;
	}

}

// Load the PowerPack class.
function BB_POWERPACK() { // @codingStandardsIgnoreLine.
	return BB_PowerPack::get_instance();
}

BB_POWERPACK();

/**
 * Enable white labeling setting form after re-activating the plugin
 *
 * @since 1.0.1
 * @return void
 */
function bb_powerpack_plugin_activation() {
	delete_option( 'ppwl_hide_form' );
	delete_option( 'ppwl_hide_plugin' );
	if ( get_option( 'bb_powerpack_templates_reset' ) != 1 ) {
		delete_option( 'bb_powerpack_override_ms' );
		update_option( 'bb_powerpack_templates', array( 'disabled' ) );
		update_option( 'bb_powerpack_page_templates', array( 'disabled' ) );
		update_option( 'bb_powerpack_templates_reset', 1 );
	}
	if ( is_network_admin() ) {
		delete_site_option( 'ppwl_hide_form' );
		delete_site_option( 'ppwl_hide_plugin' );
		if ( get_site_option( 'bb_powerpack_templates_reset' ) != 1 ) {
			delete_site_option( 'bb_powerpack_override_ms' );
			update_site_option( 'bb_powerpack_templates', array( 'disabled' ) );
			update_site_option( 'bb_powerpack_page_templates', array( 'disabled' ) );
			update_site_option( 'bb_powerpack_templates_reset', 1 );
		}
	}
}
register_activation_hook( __FILE__, 'bb_powerpack_plugin_activation' );
