<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Support for the GeneratePress theme.
 *
 * @since 2.7.1
 */
final class BB_PowerPack_Header_Footer_Generate_Press {
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
		if ( ! empty( BB_PowerPack_Header_Footer::$header ) ) {
			remove_action( 'generate_header', 'generate_construct_header' );
			remove_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
			add_action( 'generate_header', __CLASS__ . '::render_header' );
		}
		if ( ! empty( BB_PowerPack_Header_Footer::$footer ) ) {
			remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
			remove_action( 'generate_footer', 'generate_construct_footer' );
			add_action( 'generate_footer', __CLASS__ . '::render_footer' );
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
		BB_PowerPack_Header_Footer::render_footer();
	}
}

BB_PowerPack_Header_Footer_Generate_Press::init();