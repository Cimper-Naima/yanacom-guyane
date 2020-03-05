<?php

/**
 * @since 1.0
 * @class FLWooRelatedProductsModule
 */
class FLWooRelatedProductsModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Related Products', 'fl-theme-builder' ),
			'description'     => __( 'Displays related products for the current product.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'WooCommerce', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-related-products/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-related-products/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooRelatedProductsModule', array() );
