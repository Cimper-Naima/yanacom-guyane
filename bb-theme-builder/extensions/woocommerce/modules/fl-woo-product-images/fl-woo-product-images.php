<?php

/**
 * @since 1.0
 * @class FLWooProductImagesModule
 */
class FLWooProductImagesModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Images', 'fl-theme-builder' ),
			'description'     => __( 'Displays a gallery of images for the current product.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'WooCommerce', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-images/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-images/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooProductImagesModule', array(
	'general' => array(
		'title'    => __( 'General', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'sale_flash' => array(
						'type'    => 'select',
						'label'   => __( 'Sale Flash', 'fl-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Show', 'fl-theme-builder' ),
							'0' => __( 'Hide', 'fl-theme-builder' ),
						),
					),
				),
			),
		),
	),
) );
