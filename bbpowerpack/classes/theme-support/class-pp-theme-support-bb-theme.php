<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Support for the Beaver Builder theme.
 *
 * @since 2.7.1
 */
final class BB_PowerPack_Header_Footer_BB_Theme {
	/**
	 * Setup support for the theme.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function init()
	{
		add_action( 'wp', __CLASS__ . '::setup_headers_and_footers' );
	}

	/**
	 * Setup headers and footers.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function setup_headers_and_footers()
	{
		if ( 'tpl-no-header-footer.php' == get_page_template_slug() && ! is_search() ) {
			return;
		}

		if ( ! empty( BB_PowerPack_Header_Footer::$header ) ) {
			add_filter( 'fl_topbar_enabled', '__return_false' );
			add_filter( 'fl_fixed_header_enabled', '__return_false' );
			add_filter( 'fl_header_enabled', '__return_false' );
			add_action( 'fl_before_header', __CLASS__ . '::render_header', 999 );
		}
		if ( ! empty( BB_PowerPack_Header_Footer::$footer ) ) {
			add_filter( 'fl_footer_enabled', '__return_false' );
			add_action( 'fl_after_content', __CLASS__ . '::render_footer', 11 );
		}
	}

	/**
	 * Renders the header for the current page.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function render_header()
	{
		BB_PowerPack_Header_Footer::render_header();
	}

	/**
	 * Renders the footer for the current page.
	 *
	 * @since 2.7.1
	 * @return void
	 */
	static public function render_footer()
	{
		do_action( 'fl_before_footer_widgets' );
		do_action( 'fl_before_footer' );

		BB_PowerPack_Header_Footer::render_footer();

		do_action( 'fl_after_footer_widgets' );
		do_action( 'fl_after_footer' );
	}
}

BB_PowerPack_Header_Footer_BB_Theme::init();