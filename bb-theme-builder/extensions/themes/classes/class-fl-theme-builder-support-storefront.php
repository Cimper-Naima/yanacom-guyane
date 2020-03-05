<?php

/**
 * Built-in support for the Storefront theme.
 *
 * @since 1.0.1
 */
final class FLThemeBuilderSupportStorefront {

	/**
	 * Setup support for the theme.
	 *
	 * @since 1.0.1
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
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
		add_action( 'fl_builder_posts_module_before_posts', __CLASS__ . '::posts_module_before_posts', 8, 2 );
		add_action( 'fl_builder_posts_module_after_posts', __CLASS__ . '::posts_module_after_posts', 8, 2 );
	}

	/**
	 * Registers hooks for theme parts.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	static public function register_part_hooks() {
		return array(
			array(
				'label' => __( 'General', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_before_site' => __( 'Before Site', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Header', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_before_header' => __( 'Before Header', 'fl-theme-builder' ),
					'storefront_header'        => __( 'Header', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Homepage', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_homepage' => __( 'Homepage', 'fl-theme-builder' ),
					'storefront_homepage_before_product_categories' => __( 'Before Product Categories', 'fl-theme-builder' ),
					'storefront_homepage_after_product_categories_title' => __( 'After Product Categories Title', 'fl-theme-builder' ),
					'storefront_homepage_after_product_categories' => __( 'After Product Categories', 'fl-theme-builder' ),
					'storefront_homepage_before_recent_products' => __( 'Before Recent Products', 'fl-theme-builder' ),
					'storefront_homepage_after_recent_products_title' => __( 'After Recent Products Title', 'fl-theme-builder' ),
					'storefront_homepage_after_recent_products' => __( 'After Recent Products', 'fl-theme-builder' ),
					'storefront_homepage_before_featured_products' => __( 'Before Featured Products', 'fl-theme-builder' ),
					'storefront_homepage_after_featured_products_title' => __( 'After Featured Products Title', 'fl-theme-builder' ),
					'storefront_homepage_after_featured_products' => __( 'After Featured Products', 'fl-theme-builder' ),
					'storefront_homepage_before_popular_products' => __( 'Before Popular Products', 'fl-theme-builder' ),
					'storefront_homepage_after_popular_products_title' => __( 'After Popular Products Title', 'fl-theme-builder' ),
					'storefront_homepage_after_popular_products' => __( 'After Popular Products', 'fl-theme-builder' ),
					'storefront_homepage_before_on_sale_products' => __( 'Before On Sale Products', 'fl-theme-builder' ),
					'storefront_homepage_after_on_sale_products_title' => __( 'After On Sale Products Title', 'fl-theme-builder' ),
					'storefront_homepage_after_on_sale_products' => __( 'After On Sale Products', 'fl-theme-builder' ),
					'storefront_homepage_before_best_selling_products' => __( 'Before Best Selling Products', 'fl-theme-builder' ),
					'storefront_homepage_after_best_selling_products_title' => __( 'After Best Selling Products Title', 'fl-theme-builder' ),
					'storefront_homepage_after_best_selling_products' => __( 'After Best Selling Products', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Content', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_before_content' => __( 'Before Content', 'fl-theme-builder' ),
					'storefront_content_top'    => __( 'Content Top', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Footer', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_before_footer' => __( 'Before Footer', 'fl-theme-builder' ),
					'storefront_footer'        => __( 'Footer', 'fl-theme-builder' ),
					'storefront_after_footer'  => __( 'After Footer', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Sidebar', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_sidebar' => __( 'Sidebar', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Posts', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_single_post_before' => __( 'Before Post', 'fl-theme-builder' ),
					'storefront_single_post_top'    => __( 'Post Top', 'fl-theme-builder' ),
					'storefront_single_post'        => __( 'Post', 'fl-theme-builder' ),
					'storefront_single_post_bottom' => __( 'Post Bottom', 'fl-theme-builder' ),
					'storefront_single_post_after'  => __( 'After Post', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Pages', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_page_before' => __( 'Before Page', 'fl-theme-builder' ),
					'storefront_page'        => __( 'Page', 'fl-theme-builder' ),
					'storefront_page_after'  => __( 'After Page', 'fl-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Archives', 'fl-theme-builder' ),
				'hooks' => array(
					'storefront_loop_before'         => __( 'Before Loop', 'fl-theme-builder' ),
					'storefront_loop_after'          => __( 'After Loop', 'fl-theme-builder' ),
					'storefront_post_content_before' => __( 'Post Content Before', 'fl-theme-builder' ),
					'storefront_post_content_after'  => __( 'Post Content After', 'fl-theme-builder' ),
				),
			),
		);
	}

	/**
	 * Setup headers and footers.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	static public function setup_headers_and_footers() {
		$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

		if ( ! empty( $header_ids ) ) {
			remove_all_actions( 'storefront_header' );
			add_action( 'storefront_header', function() {
				FLThemeBuilderLayoutRenderer::render_header( 'div' );
			} );
		}
		if ( ! empty( $footer_ids ) ) {
			remove_all_actions( 'storefront_footer' );
			add_action( 'storefront_footer', function() {
				FLThemeBuilderLayoutRenderer::render_footer( 'div' );
			} );
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
	 * Enqueues css or js assets for theme support.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	static public function enqueue_scripts() {

		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( count( $layouts ) ) {
			wp_enqueue_style( 'fl-theme-builder-storefront', FL_THEME_BUILDER_THEMES_URL . 'css/storefront.css', array(), FL_THEME_BUILDER_VERSION );
		}
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
			$classes[] = 'fl-theme-builder-full-width';
		}
		if ( 'fl-theme-layout' == get_post_type() ) {
			$classes[] = 'single-product';
		}

		return $classes;
	}

	/**
	 * Hook before the posts module.
	 *
	 * @since 1.2.1
	 * @param array $settings
	 * @return void
	 */
	static public function posts_module_before_posts( $settings, $query = null ) {
		remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
	}

	/**
	 * Hook after the posts module.
	 *
	 * @since 1.2.1
	 * @param array $settings
	 * @return void
	 */
	static public function posts_module_after_posts( $settings, $query = null ) {
		if ( is_object( $query ) && isset( $query->query_vars['post_type'] ) && 'product' == $query->query_vars['post_type'] ) {
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );
		}
	}

}

FLThemeBuilderSupportStorefront::init();
