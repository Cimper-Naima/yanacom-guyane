<?php
/**
 * Handles logic for the maintenance mode.
 *
 * @package BB_PowerPack
 * @since 2.6.10
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BB_PowerPack_Maintenance_Mode.
 */
final class BB_PowerPack_Maintenance_Mode {
	/**
	 * Holds the value of setting field Template.
	 *
	 * @var $template
	 * @since 2.6.10
	 * @access protected
	 */
	static protected $template = '';

	/**
	 * Settings Tab constant.
	 */
	const SETTINGS_TAB = 'maintenance_mode';

	/**
	 * Initializing PowerPack maintenance mode.
	 *
	 * @since 2.6.10
	 */
	static public function init() {
		add_filter( 'pp_admin_settings_tabs', 	__CLASS__ . '::render_settings_tab', 10, 1 );
		add_action( 'pp_admin_settings_save', 	__CLASS__ . '::save_settings' );

		self::$template = get_option( 'bb_powerpack_maintenance_mode_template' );

		if ( ! self::is_enabled() ) {
			return;
		}

		add_action( 'admin_bar_menu', 	__CLASS__ . '::add_menu_in_admin_bar', 300 );
		add_action( 'admin_head', 		__CLASS__ . '::print_style' );
		add_action( 'wp_head', 			__CLASS__ . '::print_style' );
		add_action( 'wp', 				__CLASS__ . '::setup_maintenance_mode' );
	}

	/**
	 * Is enabled.
	 *
	 * Check if maintenance mode is enabled or not.
	 *
	 * @since 2.6.10
	 *
	 * @return boolean true or false
	 */
	static public function is_enabled() {
		return 'yes' === get_option( 'bb_powerpack_maintenance_mode_enable', 'no' ) && ! empty( self::$template );
	}

	/**
	 * Body class.
	 *
	 * Add "Maintenance Mode" CSS classes to the body tag.
	 *
	 * Fired by `body_class` filter.
	 *
	 * @since 2.6.10
	 *
	 * @param array $classes An array of body classes.
	 *
	 * @return array An array of body classes.
	 */
	static public function body_class( $classes ) {
		$classes[] = 'bb-powerpack-maintenance-mode';

		return $classes;
	}

	/**
	 * Setup Maintenance Mode.
	 *
	 * Conditionally check and setup the maintenance mode.
	 *
	 * @since 2.6.10
	 */
	static public function setup_maintenance_mode() {
		$access = get_option( 'bb_powerpack_maintenance_mode_access' );

		if ( 'logged_in' === $access && is_user_logged_in() ) {
			return;
		}

		if ( 'custom' === $access ) {
			$access_roles = get_option( 'bb_powerpack_maintenance_mode_access_roles', array() );
			$user 		= wp_get_current_user();
			$user_roles = $user->roles;

			if ( is_multisite() && is_super_admin() ) {
				$user_roles[] = 'super_admin';
			}

			$compare_roles = array_intersect( $user_roles, $access_roles );

			if ( ! empty( $compare_roles ) ) {
				return;
			}
		}

		// Remove Beaver Themer header and footer layouts.
		add_filter( 'fl_theme_builder_current_page_layouts', __CLASS__ . '::remove_themer_layouts', 10, 1 );

		// Remove BB theme's header / footer.
		add_filter( 'fl_topbar_enabled', '__return_false' );
		add_filter( 'fl_fixed_header_enabled', '__return_false' );
		add_filter( 'fl_header_enabled', '__return_false' );
		add_filter( 'fl_footer_enabled', '__return_false' );

		// Remove Astra header / footer / post nav markup.
		remove_action( 'astra_header', 'astra_header_markup' );
		remove_action( 'astra_footer', 'astra_footer_markup' );
		remove_action( 'astra_entry_after', 'astra_single_post_navigation_markup' );

		// Remove Page Builder Framework theme's header / footer.
		remove_action( 'wpbf_header', 'wpbf_do_header' );
		remove_action( 'wpbf_footer', 'wpbf_do_footer' );
		remove_action( 'wpbf_before_footer', 'wpbf_custom_footer' );

		// Remove GeneratePress header / footer.
		remove_action( 'generate_header', 'generate_construct_header' );
		remove_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
		remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
		remove_action( 'generate_footer', 'generate_construct_footer' );

		// Remove Genesis header / footer.
		remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
		remove_action( 'genesis_header', 'genesis_do_header' );
		remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
		remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
		remove_action( 'genesis_footer', 'genesis_do_footer' );
		remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

		// Remove Storefront theme's header / footer.
		remove_all_actions( 'storefront_header' );
		remove_all_actions( 'storefront_footer' );

		// Custom action to hook any configuration before render.
		do_action( 'pp_maintenance_mode_before_render' );

		// Priority = 11 that is *after* WP default filter `redirect_canonical` in order to avoid redirection loop.
		add_action( 'template_redirect', __CLASS__ . '::template_redirect', 11 );
	}

	/**
	 * Remove themer layout.
	 *
	 * Remove Beaver Themer's header and footer layouts from the page.
	 *
	 * Fired by 'fl_theme_builder_current_page_layouts' filter.
	 *
	 * @since 2.6.10
	 *
	 * @param array $layouts An array of Beaver Themer layouts.
	 *
	 * @return array $layouts
	 */
	static public function remove_themer_layouts( $layouts ) {
		if ( isset( $layouts['header'] ) ) {
			unset( $layouts['header'] );
		}
		if ( isset( $layouts['footer'] ) ) {
			unset( $layouts['footer'] );
		}

		return $layouts;
	}

	/**
	 * Template redirect.
	 *
	 * Redirect to the "Maintenance Mode" template.
	 *
	 * Fired by `template_redirect` action.
	 *
	 * @since 2.6.10
	 */
	static public function template_redirect() {
		add_filter( 'body_class', __CLASS__ . '::body_class' );

		if ( 'maintenance' === get_option( 'bb_powerpack_maintenance_mode_type' ) ) {
			$protocol = wp_get_server_protocol();
			header( "$protocol 503 Service Unavailable", true, 503 );
			header( 'Content-Type: text/html; charset=utf-8' );
			header( 'Retry-After: 600' );
		}

		// @codingStandardsIgnoreStart
		$GLOBALS['post'] = get_post( self::$template );

		// Set the template as `$wp_query->current_object` for `wp_title` and etc.
		query_posts( array(
			'p' => self::$template,
			'post_type' => 'page',
		) );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Get templates.
	 *
	 * Get all layout templates and create options for select field.
	 *
	 * @since 2.6.10
	 * @param string $selected Selected template for the field.
	 */
	static public function get_templates( $selected = '' ) {
		$args = array(
			'post_type' 		=> 'page',
			'post_status'		=> 'publish',
			'orderby' 			=> 'title',
			'order' 			=> 'ASC',
			'posts_per_page' 	=> '-1',
		);

		$posts = get_posts( $args );

		$options = '<option value="">' . __( '-- Select --', 'bb-powerpack' ) . '</option>';

		if ( count( $posts ) ) {
			foreach ( $posts as $post ) {
				$options .= '<option value="' . $post->ID . '" ' . selected( $selected, $post->ID ) . '>' . $post->post_title . '</option>';
			}
		} else {
			$options = '<option value="" disabled>' . __( 'No templates found!', 'bb-powerpack' ) . '</option>';
		}

		return $options;
	}

	/**
	 * Add menu in admin bar.
	 *
	 * Adds "Maintenance Mode" items to the WordPress admin bar.
	 *
	 * Fired by `admin_bar_menu` filter.
	 *
	 * @since 2.6.10
	 *
	 * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance, passed by reference.
	 */
	static public function add_menu_in_admin_bar( WP_Admin_Bar $wp_admin_bar ) {
		if ( ! self::is_enabled() ) {
			return;
		}

		$wp_admin_bar->add_node( array(
			'id'	=> 'bb-powerpack-maintenance-on',
			'title'	=> __( 'Maintenance Mode ON', 'bb-powerpack' ),
			'href'	=> BB_PowerPack_Admin_Settings::get_form_action( '&tab=' . self::SETTINGS_TAB ),
		) );
	}

	/**
	 * Print style.
	 *
	 * Adds custom CSS to the HEAD html tag. The CSS that emphasise the maintenance
	 * mode with red colors.
	 *
	 * Fired by `admin_head` and `wp_head` filters.
	 *
	 * @since 2.6.10
	 */
	static public function print_style() {
		?>
		<style>#wp-admin-bar-bb-powerpack-maintenance-on > a { background-color: #F44336; }
			#wp-admin-bar-bb-powerpack-maintenance-on > .ab-item:before { content: "\f160"; top: 2px; }</style>
		<?php
	}

	/**
	 * Render settings tab.
	 *
	 * Adds Maintenance Mode tab in PowerPack admin settings.
	 *
	 * @since 2.6.10
	 * @param array $tabs Array of existing settings tabs.
	 */
	static public function render_settings_tab( $tabs ) {
		$tabs[ self::SETTINGS_TAB ] = array(
			'title'				=> esc_html__( 'Maintenance Mode', 'bb-powerpack' ),
			'show'				=> ! is_network_admin() && ! BB_PowerPack_Admin_Settings::get_option( 'ppwl_hide_maintenance_tab' ),
			'cap'				=> ! is_network_admin() ? 'manage_options' : 'manage_network_plugins',
			'file'				=> BB_POWERPACK_DIR . 'includes/admin-settings-maintenance-mode.php',
			'priority'			=> 350,
		);

		return $tabs;
	}

	/**
	 * Save settings.
	 *
	 * Saves setting fields value in options.
	 *
	 * @since 2.6.10
	 */
	static public function save_settings() {
		if ( ! isset( $_POST['bb_powerpack_maintenance_mode_enable'] ) ) {
			return;
		}

		$enable = sanitize_text_field( $_POST['bb_powerpack_maintenance_mode_enable'] );
		$type 	= sanitize_text_field( $_POST['bb_powerpack_maintenance_mode_type'] );
		$access = sanitize_text_field( $_POST['bb_powerpack_maintenance_mode_access'] );
		$roles 	= array();
		$template 	= isset( $_POST['bb_powerpack_maintenance_mode_template'] ) ? sanitize_text_field( $_POST['bb_powerpack_maintenance_mode_template'] ) : '';

		if ( isset( $_POST['bb_powerpack_maintenance_mode_access_roles'] ) && ! empty( $_POST['bb_powerpack_maintenance_mode_access_roles'] ) ) {
			foreach ( $_POST['bb_powerpack_maintenance_mode_access_roles'] as $role ) {
				$roles[] = sanitize_text_field( $role );
			}
		}

		update_option( 'bb_powerpack_maintenance_mode_enable', $enable );
		update_option( 'bb_powerpack_maintenance_mode_type', $type );
		update_option( 'bb_powerpack_maintenance_mode_access', $access );
		update_option( 'bb_powerpack_maintenance_mode_access_roles', $roles );
		update_option( 'bb_powerpack_maintenance_mode_template', $template );

		// Clear BB's assets cache.
		if ( class_exists( 'FLBuilderModel' ) && method_exists( 'FLBuilderModel', 'delete_asset_cache_for_all_posts' ) ) {
			FLBuilderModel::delete_asset_cache_for_all_posts();
		}
	}
}

// Initialize the class.
BB_PowerPack_Maintenance_Mode::init();
