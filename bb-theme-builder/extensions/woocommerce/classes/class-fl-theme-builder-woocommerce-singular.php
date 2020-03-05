<?php

/**
 * WooCommerce singular support for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderWooCommerceSingular {

	/**
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Filters
		add_filter( 'fl_builder_render_css', __CLASS__ . '::render_css', 10, 4 );
		add_filter( 'body_class', __CLASS__ . '::body_class' );
		add_filter( 'fl_theme_builder_before_render_content', __CLASS__ . '::before_render_content' );
		add_filter( 'fl_builder_content_classes', __CLASS__ . '::content_class' );
		add_filter( 'fl_theme_builder_after_render_content', __CLASS__ . '::after_render_content' );
	}

	/**
	 * Renders custom CSS for singular WooCommerce pages.
	 *
	 * @since 1.0
	 * @param string $css
	 * @param array  $nodes
	 * @param object $settings
	 * @param bool   $global
	 * @return string
	 */
	static public function render_css( $css, $nodes, $settings, $global ) {
		if ( $global && 'product' == get_post_type() ) {
			$css .= file_get_contents( FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'css/fl-theme-builder-woocommerce-singular.css' );
		}

		return $css;
	}

	/**
	 * Adds the WooCommerce body classes to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.0
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {
		global $post;

		if ( is_singular() && 'fl-theme-layout' == get_post_type() ) {

			$locations   = FLThemeBuilderRulesLocation::get_saved( $post->ID );
			$locations[] = FLThemeBuilderRulesLocation::get_preview_location( $post->ID );
			$is_woo      = false;

			foreach ( $locations as $location ) {

				if ( strstr( $location, 'post:product' ) ) {
					$is_woo = true;
					break;
				} elseif ( strstr( $location, 'archive:product' ) ) {
					$is_woo = true;
					break;
				} elseif ( strstr( $location, 'taxonomy:product_cat' ) ) {
					$is_woo = true;
					break;
				} elseif ( strstr( $location, 'taxonomy:product_tag' ) ) {
					$is_woo = true;
					break;
				}
			}

			if ( $is_woo ) {
				$classes[] = 'woocommerce';
				$classes[] = 'woocommerce-page';
			}
		}

		return $classes;
	}

	/**
	 * Prints notices before a Woo layout and fires the
	 * before single product action.
	 *
	 * @since 1.0
	 * @param string $layout_id
	 * @return void
	 */
	static public function before_render_content( $layout_id ) {
		global $wp_the_query;

		if ( is_object( $wp_the_query->post ) && 'product' == $wp_the_query->post->post_type ) {

			if ( function_exists( 'wc_print_notices' ) ) {

				ob_start();
				wc_print_notices();
				$notices = ob_get_clean();

				if ( ! empty( $notices ) ) {
					echo '<div class="fl-theme-builder-woo-notices fl-row fl-row-fixed-width">';
					echo $notices;
					echo '</div>';
				}
			}
			if ( function_exists( 'is_product' ) && is_product() ) {
				do_action( 'woocommerce_before_single_product' );
			}
		}
	}

	/**
	 * Adds the WooCommerce content class to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.0
	 * @param string $classes
	 * @return string
	 */
	static public function content_class( $classes ) {
		if ( is_singular() && 'product' == get_post_type() ) {
			$classes .= ' product';
		}

		return $classes;
	}

	/**
	 * Fires the after single product action.
	 *
	 * @since 1.0
	 * @param string $layout_id
	 * @return void
	 */
	static public function after_render_content( $layout_id ) {
		global $wp_the_query, $woocommerce;

		if ( is_object( $wp_the_query->post ) && 'product' == $wp_the_query->post->post_type ) {

			add_action( 'woocommerce_after_single_product', array( $woocommerce->structured_data, 'generate_product_data' ) );
			do_action( 'woocommerce_after_single_product' );

		}
	}
}

FLThemeBuilderWooCommerceSingular::init();
