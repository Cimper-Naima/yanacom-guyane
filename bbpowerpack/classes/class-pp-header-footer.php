<?php
/**
 * Handles logic for the site Header / Footer.
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
 * BB_PowerPack_Header_Footer
 */
final class BB_PowerPack_Header_Footer {
	/**
	 * Settings tab constant.
	 */
	const SETTINGS_TAB = 'header_footer';

	/**
	 * Holds an array of posts.
	 *
	 * @var array $templates
	 * @since 2.7.1
	 */
	static private $templates = array();

	/**
	 * Holds the post ID for header.
	 *
	 * @var int $header
	 * @since 2.7.1
	 */
	static public $header;

	/**
	 * Holds the post ID for footer.
	 *
	 * @var int $footer
	 * @since 2.7.1
	 */
	static public $footer;

	/**
	 * Initialize hooks.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function init() {
		add_filter( 'pp_admin_settings_tabs', 	__CLASS__ . '::render_settings_tab', 10, 1 );
		add_action( 'pp_admin_settings_save', 	__CLASS__ . '::save_settings' );

		add_action( 'after_setup_theme', __CLASS__ . '::load' );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::render_css' );
		add_filter( 'fl_builder_render_js', __CLASS__ . '::render_js' );
		add_action( 'template_redirect', __CLASS__ . '::disable_content_rendering' );
	}

	/**
	 * Render settings tab.
	 *
	 * Adds Header/Footer tab in PowerPack admin settings.
	 *
	 * @since 2.7.1
	 * @param array $tabs Array of existing settings tabs.
	 */
	static public function render_settings_tab( $tabs ) {
		$tabs[ self::SETTINGS_TAB ] = array(
			'title'				=> esc_html__( 'Header / Footer', 'bb-powerpack' ),
			'show'				=> ! is_network_admin() && ! BB_PowerPack_Admin_Settings::get_option( 'ppwl_hide_header_footer_tab' ),
			'cap'				=> ! is_network_admin() ? 'manage_options' : 'manage_network_plugins',
			'file'				=> BB_POWERPACK_DIR . 'includes/admin-settings-header-footer.php',
			'priority'			=> 325,
		);

		return $tabs;
	}

	/**
	 * Save settings.
	 *
	 * Saves setting fields value in options.
	 *
	 * @since 2.7.1
	 */
	static public function save_settings() {
		if ( ! isset( $_POST['bb_powerpack_header_footer_page'] ) ) {
			return;
		}

		$header = isset( $_POST['bb_powerpack_header_footer_template_header'] ) ? sanitize_text_field( wp_unslash( $_POST['bb_powerpack_header_footer_template_header'] ) ) : '';
		$footer = isset( $_POST['bb_powerpack_header_footer_template_footer'] ) ? sanitize_text_field( wp_unslash( $_POST['bb_powerpack_header_footer_template_footer'] ) ) : '';

		update_option( 'bb_powerpack_header_footer_template_header', $header );
		update_option( 'bb_powerpack_header_footer_template_footer', $footer );

		if ( isset( $_POST['bb_powerpack_header_footer_fixed_header'] ) ) {
			update_option( 'bb_powerpack_header_footer_fixed_header', 1 );
		} else {
			delete_option( 'bb_powerpack_header_footer_fixed_header' );
		}

		if ( isset( $_POST['bb_powerpack_header_footer_shrink_header'] ) ) {
			update_option( 'bb_powerpack_header_footer_shrink_header', 1 );
		} else {
			delete_option( 'bb_powerpack_header_footer_shrink_header' );
		}

		if ( isset( $_POST['bb_powerpack_header_footer_overlay_header'] ) ) {
			update_option( 'bb_powerpack_header_footer_overlay_header', 1 );
		} else {
			delete_option( 'bb_powerpack_header_footer_overlay_header' );
		}

		if ( isset( $_POST['bb_powerpack_header_footer_overlay_header_bg'] ) ) {
			update_option( 'bb_powerpack_header_footer_overlay_header_bg', sanitize_text_field( wp_unslash( $_POST['bb_powerpack_header_footer_overlay_header_bg'] ) ) );
		}

		// Clear BB's assets cache.
		if ( class_exists( 'FLBuilderModel' ) && method_exists( 'FLBuilderModel', 'delete_asset_cache_for_all_posts' ) ) {
			FLBuilderModel::delete_asset_cache_for_all_posts();
		}
	}

	/**
	 * Add CSS classes to the body tag.
	 *
	 * Fired by `body_class` filter.
	 *
	 * @since 2.7.1
	 *
	 * @param array $classes An array of body classes.
	 *
	 * @return array An array of body classes.
	 */
	static public function body_class( $classes ) {
		$classes[] = 'bb-powerpack-header-footer';

		return $classes;
	}

	/**
	 * Get templates.
	 *
	 * Get all pages and BB's templates.
	 *
	 * @since 2.7.1
	 */
	static public function get_templates() {
		if ( ! empty( self::$templates ) ) {
			return self::$templates;
		}

		$args = array(
			'post_type' 		=> 'page',
			'post_status'		=> 'publish',
			'orderby' 			=> 'title',
			'order' 			=> 'ASC',
			'posts_per_page' 	=> '-1',
		);

		$pages = get_posts( $args );

		$args['post_type'] = 'fl-builder-template';

		$args['tax_query'] = array(
			array(
				'taxonomy'		=> 'fl-builder-template-type',
				'field'			=> 'slug',
				'terms'			=> array(
					'layout',
					'row',
				),
			),
		);

		$templates = get_posts( $args );

		self::$templates = array(
			'pages'		=> $pages,
			'templates'	=> $templates,
		);

		return self::$templates;
	}

	/**
	 * Get templates HTML.
	 *
	 * Get all pages and BB's templates and build options for select field.
	 *
	 * @since 2.7.1
	 * @param string $selected Selected template for the field.
	 */
	static public function get_templates_html( $selected = '' ) {
		$templates = self::get_templates();

		$options = '<option value="">' . esc_html__( 'Default', 'bb-powerpack' ) . '</option>';

		foreach ( $templates as $type => $data ) {
			if ( ! count( $data ) ) {
				continue;
			}

			$label = '';

			if ( 'pages' === $type ) {
				$label = esc_html__( 'Pages', 'bb-powerpack' );
			}
			if ( 'templates' === $type ) {
				$label = esc_html__( 'Builder Templates', 'bb-powerpack' );
			}

			$options .= '<optgroup label="' . $label . '">';

			foreach ( $data as $post ) {
				$options .= '<option value="' . $post->ID . '" ' . selected( $selected, $post->ID ) . '>' . $post->post_title . '</option>';
			}

			$options .= '</optgroup>';
		}

		return $options;
	}

	/**
	 * Returns the slug for supported theme.
	 *
	 * @since 2.7.1
	 * @return mixed
	 */
	static public function get_theme_support_slug() {
		$slug = false;

		if ( defined( 'FL_THEME_VERSION' ) ) {
			$slug = 'bb-theme';
		} elseif ( defined( 'ASTRA_THEME_VERSION' ) ) {
			$slug = 'astra';
		} elseif ( function_exists( 'genesis' ) ) {
			$slug = 'genesis';
		} elseif ( defined( 'GENERATE_VERSION' ) ) {
			$slug = 'generatepress';
		} elseif ( function_exists( 'storefront_is_woocommerce_activated' ) ) {
			$slug = 'storefront';
		}

		return $slug;
	}

	/**
	 * Loads theme support if we have a supported theme.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function load() {
		self::$header = get_option( 'bb_powerpack_header_footer_template_header' );
		self::$footer = get_option( 'bb_powerpack_header_footer_template_footer' );

		// Remove option if header template has deleted.
		if ( ! empty( self::$header ) && 'publish' != get_post_status( self::$header ) ) {
			delete_option( 'bb_powerpack_header_footer_template_header' );
		}
		// Remove option if footer template has deleted.
		if ( ! empty( self::$footer ) && 'publish' != get_post_status( self::$footer ) ) {
			delete_option( 'bb_powerpack_header_footer_template_footer' );
		}

		if ( empty( self::$header ) && empty( self::$footer ) ) {
			return;
		}

		$slug = self::get_theme_support_slug();

		add_filter( 'body_class', __CLASS__ . '::body_class' );

		if ( $slug ) {
			if ( is_callable( 'FLBuilder::render_content_by_id' ) ) {
				require_once BB_POWERPACK_DIR . "classes/theme-support/class-pp-theme-support-$slug.php";
			}
		}
	}

	/**
	 * Renders the CSS for header/footer and adds
	 * it to the cached builder CSS layout file.
	 *
	 * @param string $css	CSS of nodes.
	 * @since 2.7.1
	 * @return string
	 */
	static public function render_css( $css ) {
		if ( ! is_callable( 'FLBuilderModel::get_post_id' ) ) {
			return $css;
		}

		if ( FLBuilderModel::get_post_id() === self::$header ) {
			$css .= file_get_contents( BB_POWERPACK_DIR . 'assets/css/header-layout.css' );
		}

		return $css;
	}

	/**
	 * Renders the JS for header/footer and adds
	 * it to the cached builder JS layout file.
	 *
	 * @param string $js	JS of nodes.
	 * @since 2.7.1
	 * @return string
	 */
	static public function render_js( $js ) {
		if ( ! is_callable( 'FLBuilderModel::get_post_id' ) ) {
			return $js;
		}

		if ( FLBuilderModel::get_post_id() === self::$header ) {
			$js .= file_get_contents( BB_POWERPACK_DIR . 'assets/js/header-layout.js' );
		}

		return $js;
	}

	/**
	 * Renders the header for the current page.
	 * Used by theme support classes.
	 *
	 * @param mixed $tag	HTML tag for header.
	 * @since 2.7.1
	 * @return void
	 */
	static public function render_header( $tag = null ) {
		$tag 		= ! $tag ? 'header' : $tag;
		$id 		= self::$header;
		$is_fixed 	= get_option( 'bb_powerpack_header_footer_fixed_header' );
		$is_shrink 	= get_option( 'bb_powerpack_header_footer_shrink_header' );
		$is_overlay = get_option( 'bb_powerpack_header_footer_overlay_header' );
		$overlay_bg = get_option( 'bb_powerpack_header_footer_overlay_header_bg', 'default' );

		do_action( 'pp_header_footer_before_render_header', $id );

		// Enqueue jQyery throttle.
		wp_enqueue_script( 'jquery-throttle' );

		// Enqueue imagesloaded.
		wp_enqueue_script( 'imagesloaded' );

		// Enqueue styles and scripts for this post.
		if ( is_callable( 'FLBuilder::enqueue_layout_styles_scripts_by_id' ) ) {
			FLBuilder::enqueue_layout_styles_scripts_by_id( $id );
		}

		// Print the styles if we are outside of the head tag.
		if ( did_action( 'wp_enqueue_scripts' ) && ! doing_filter( 'wp_enqueue_scripts' ) ) {
			wp_print_styles();
		}

		FLBuilder::render_content_by_id( $id, $tag, array(
			'itemscope'       => 'itemscope',
			'itemtype'        => 'http://schema.org/WPHeader',
			'data-type'       => 'header',
			'data-sticky'     => $is_fixed ? '1' : '0',
			'data-shrink'     => $is_shrink ? '1' : '0',
			'data-overlay'    => $is_overlay ? '1' : '0',
			'data-overlay-bg' => $overlay_bg,
		) );

		do_action( 'pp_header_footer_after_render_header', $id );
	}

	/**
	 * Renders the footer for the current page.
	 * Used by theme support classes.
	 *
	 * @param mixed $tag	HTML tag for footer.
	 * @since 2.7.1
	 * @return void
	 */
	static public function render_footer( $tag = null ) {
		$tag = ! $tag ? 'footer' : $tag;
		$id = self::$footer;

		// Enqueue styles and scripts for this post.
		if ( is_callable( 'FLBuilder::enqueue_layout_styles_scripts_by_id' ) ) {
			FLBuilder::enqueue_layout_styles_scripts_by_id( $id );
		}

		// Print the styles if we are outside of the head tag.
		if ( did_action( 'wp_enqueue_scripts' ) && ! doing_filter( 'wp_enqueue_scripts' ) ) {
			wp_print_styles();
		}

		do_action( 'pp_header_footer_before_render_footer', $id );

		FLBuilder::render_content_by_id( $id, $tag, array(
			'itemscope'       => 'itemscope',
			'itemtype'        => 'http://schema.org/WPFooter',
			'data-type'       => 'footer',
		) );

		do_action( 'pp_header_footer_after_render_footer', $id );
	}

	/**
	 * Disables builder content rendering for headers
	 * and footers since those are edited in place.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function disable_content_rendering() {
		global $post;

		if ( is_object( $post ) ) {
			$header = get_option( 'bb_powerpack_header_footer_template_header' );
			$footer = get_option( 'bb_powerpack_header_footer_template_footer' );
			$has_header = $post->ID === $header;
			$has_footer = $post->ID === $footer;

			if ( $has_header || $has_footer ) {
				remove_filter( 'the_content', 'FLBuilder::render_content' );
				add_filter( 'the_content', __CLASS__ . '::override_the_content' );
			}
		}
	}

	/**
	 * Overrides the default editor content for headers
	 * and footers since those are edited in place.
	 *
	 * @param string $content	Post content.
	 * @since 2.7.1
	 * @return string
	 */
	static public function override_the_content( $content ) {
		return '<div style="padding: 200px 100px; text-align:center; opacity:0.5;">' . __( 'Content Area', 'bb-powerpack' ) . '</div>';
	}
}

// Initialize the class.
BB_PowerPack_Header_Footer::init();
