<?php

/**
 * @since 1.0
 * @class FLWooProductDescriptionModule
 */
class FLWooProductDescriptionModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Description', 'fl-theme-builder' ),
			'description'     => __( 'Displays the description for the current product.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'WooCommerce', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-description/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-description/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooProductDescriptionModule', array(
	'general' => array(
		'title'    => __( 'General', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'description_type' => array(
						'type'    => 'select',
						'label'   => __( 'Type', 'fl-theme-builder' ),
						'default' => 'short',
						'options' => array(
							'short' => __( 'Short Description', 'fl-theme-builder' ),
							'full'  => __( 'Full Description', 'fl-theme-builder' ),
						),
					),
				),
			),
		),
	),
) );
