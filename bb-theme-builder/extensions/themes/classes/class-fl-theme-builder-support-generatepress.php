<?php

/**
 * Built-in support for the GeneratePress theme.
 *
 * @since 1.0
 */
final class FLThemeBuilderSupportGeneratePress {

	/**
	 * Setup support for the theme.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );

		add_filter( 'fl_theme_builder_part_hooks', __CLASS__ . '::register_part_hooks' );
		add_filter( 'theme_fl-theme-layout_templates', __CLASS__ . '::register_php_templates' );
		add_filter( 'body_class', __CLASS__ . '::body_class' );

		add_action( 'wp', __CLASS__ . '::setup_headers_and_footers' );
	}

	/**
	 * Registers hooks for theme parts.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_part_hooks() {
		return array(
			array(
				'label' => __( 'Header', 'fl-theme-builder' ),
				'hooks' => array(
					'generate_before_header'         => __( 'Before Header', 'fl-theme-builder' ),
					'generate_before_header_content' => __( 'Before Header Content', 'fl-theme-builder' ),
					'generate_after_header_content'  => __( 'After Header Content', 'fl-theme-builder' ),
					'generate_after_header'          => __( 'After Header', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Content', 'fl-theme-builder' ),
				'hooks' => array(
					'generate_before_main_content' => __( 'Before Main Content', 'fl-theme-builder' ),
					'generate_before_content'      => __( 'Before Content', 'fl-theme-builder' ),
					'generate_after_content'       => __( 'After Content', 'fl-theme-builder' ),
					'generate_after_main_content'  => __( 'After Main Content', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Footer', 'fl-theme-builder' ),
				'hooks' => array(
					'generate_before_footer'         => __( 'Before Footer', 'fl-theme-builder' ),
					'generate_before_footer_content' => __( 'Before Footer Content', 'fl-theme-builder' ),
					'generate_after_footer_widgets'  => __( 'After Footer Widgets', 'fl-theme-builder' ),
					'generate_after_footer_content'  => __( 'After Footer Content', 'fl-theme-builder' ),
					'wp_footer'                      => __( 'After Footer', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Sidebar', 'fl-theme-builder' ),
				'hooks' => array(
					'generate_before_right_sidebar_content' => __( 'Before Right Sidebar Content', 'fl-theme-builder' ),
					'generate_after_right_sidebar_content' => __( 'After Right Sidebar Content', 'fl-theme-builder' ),
					'generate_before_left_sidebar_content' => __( 'Before Left Sidebar Content', 'fl-theme-builder' ),
					'generate_after_left_sidebar_content'  => __( 'After Left Sidebar Content', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Posts', 'fl-theme-builder' ),
				'hooks' => array(
					'generate_before_entry_title'  => __( 'Before Title', 'fl-theme-builder' ),
					'generate_after_entry_title'   => __( 'After Title', 'fl-theme-builder' ),
					'generate_after_entry_header'  => __( 'After Title Header', 'fl-theme-builder' ),
					'generate_after_entry_content' => __( 'After Post Content', 'fl-theme-builder' ),
				),
			),
		);
	}

	/**
	 * Setup headers and footers.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function setup_headers_and_footers() {
		$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

		if ( ! empty( $header_ids ) ) {
			remove_action( 'generate_header', 'generate_construct_header' );
			remove_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
			add_action( 'generate_header', 'FLThemeBuilderLayoutRenderer::render_header' );
		}
		if ( ! empty( $footer_ids ) ) {
			remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
			remove_action( 'generate_footer', 'generate_construct_footer' );
			add_action( 'generate_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
		}
	}

	/**
	 * Registers custom PHP templates for theme layouts.
	 *
	 * @since 1.0.1
	 * @param array $templates
	 * @return array
	 */
	static public function register_php_templates( $templates ) {

		if ( FLThemeBuilderLayoutData::current_post_is( array( 'singular', 'archive', '404' ) ) ) {
			$templates = array_merge( $templates, array(
				'fl-theme-layout-full-width.php' => __( 'Full Width', 'fl-theme-builder' ),
			) );
		}

		return $templates;
	}

	/**
	 * Sets the full width body class if the full width page
	 * template has been selected for this theme layout.
	 *
	 * @since 1.0.1
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {

		$ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

		if ( ! empty( $ids ) && 'fl-theme-layout-full-width.php' == get_page_template_slug( $ids[0] ) ) {
			$classes[] = 'full-width-content';
		}

		return $classes;
	}
}

FLThemeBuilderSupportGeneratePress::init();
