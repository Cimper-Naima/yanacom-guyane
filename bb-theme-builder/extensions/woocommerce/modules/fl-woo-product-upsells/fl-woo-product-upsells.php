<?php

/**
 * @since 1.0
 * @class FLWooProductUpsellsModule
 */
class FLWooProductUpsellsModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Upsells', 'fl-theme-builder' ),
			'description'     => __( 'Displays upsells for the current product.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'WooCommerce', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-upsells/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-upsells/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooProductUpsellsModule', array() );
