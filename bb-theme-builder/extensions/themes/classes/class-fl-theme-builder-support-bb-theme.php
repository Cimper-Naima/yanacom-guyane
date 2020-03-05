<?php

/**
 * Built-in support for the Beaver Builder theme.
 *
 * @since 1.0
 */
final class FLThemeBuilderSupportBBTheme {

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
				'label' => __( 'Page', 'fl-theme-builder' ),
				'hooks' => array(
					'fl_page_open'  => __( 'Page Open', 'fl-theme-builder' ),
					'fl_page_close' => __( 'Page Close', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Header', 'fl-theme-builder' ),
				'hooks' => array(
					'fl_before_header' => __( 'Before Header', 'fl-theme-builder' ),
					'fl_after_header'  => __( 'After Header', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Content', 'fl-theme-builder' ),
				'hooks' => array(
					'fl_before_content' => __( 'Before Content', 'fl-theme-builder' ),
					'fl_content_open'   => __( 'Content Open', 'fl-theme-builder' ),
					'fl_content_close'  => __( 'Content Close', 'fl-theme-builder' ),
					'fl_after_content'  => __( 'After Content', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Footer', 'fl-theme-builder' ),
				'hooks' => array(
					'fl_before_footer'         => __( 'Before Footer', 'fl-theme-builder' ),
					'fl_before_footer_widgets' => __( 'Before Footer Widgets', 'fl-theme-builder' ),
					'fl_after_footer_widgets'  => __( 'After Footer Widgets', 'fl-theme-builder' ),
					'fl_after_footer'          => __( 'After Footer', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Posts', 'fl-theme-builder' ),
				'hooks' => array(
					'fl_before_post'            => __( 'Before Post', 'fl-theme-builder' ),
					'fl_before_post_content'    => __( 'Before Post Content', 'fl-theme-builder' ),
					'fl_post_top_meta_open'     => __( 'Post Top Meta Open', 'fl-theme-builder' ),
					'fl_post_top_meta_close'    => __( 'Post Top Meta Close', 'fl-theme-builder' ),
					'fl_after_post_content'     => __( 'After Post Content', 'fl-theme-builder' ),
					'fl_post_bottom_meta_open'  => __( 'Post Bottom Meta Open', 'fl-theme-builder' ),
					'fl_post_bottom_meta_close' => __( 'Post Bottom Meta Close', 'fl-theme-builder' ),
					'fl_after_post'             => __( 'After Post', 'fl-theme-builder' ),
					'fl_comments_open'          => __( 'Comments Open', 'fl-theme-builder' ),
					'fl_comments_close'         => __( 'Comments Close', 'fl-theme-builder' ),
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

		if ( 'tpl-no-header-footer.php' == get_page_template_slug() && ! is_search() ) {
			return;
		}

		$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

		if ( ! empty( $header_ids ) ) {
			add_filter( 'fl_topbar_enabled', '__return_false' );
			add_filter( 'fl_fixed_header_enabled', '__return_false' );
			add_filter( 'fl_header_enabled', '__return_false' );
			add_action( 'fl_before_header', 'FLThemeBuilderLayoutRenderer::render_header', 999 );
		}
		if ( ! empty( $footer_ids ) ) {
			add_filter( 'fl_footer_enabled', '__return_false' );
			add_action( 'fl_after_content', __CLASS__ . '::render_footer', 11 );
		}
	}

	/**
	 * Renders a custom footer for the BB theme. We do this
	 * here so the footer actions can still fire.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_footer() {
		do_action( 'fl_before_footer_widgets' );
		do_action( 'fl_before_footer' );
		FLThemeBuilderLayoutRenderer::render_footer();
		do_action( 'fl_after_footer_widgets' );
		do_action( 'fl_after_footer' );
	}
}

FLThemeBuilderSupportBBTheme::init();
