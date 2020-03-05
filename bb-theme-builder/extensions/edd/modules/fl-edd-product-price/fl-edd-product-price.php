<?php

/**
 * @since 1.1
 * @class FLEDDProductPriceModule
 */
class FLEDDProductPriceModule extends FLBuilderModule {

	/**
	 * @since 1.1
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Price', 'fl-theme-builder' ),
			'description'     => __( 'Displays the price for the current product.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'Easy Digital Downloads', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/edd/modules/fl-edd-product-price/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/edd/modules/fl-edd-product-price/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLEDDProductPriceModule', array(
	'general' => array(
		'title'    => __( 'Style', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'align'      => array(
						'type'    => 'select',
						'label'   => __( 'Alignment', 'fl-theme-builder' ),
						'default' => 'left',
						'options' => array(
							'left'   => __( 'Left', 'fl-theme-builder' ),
							'center' => __( 'Center', 'fl-theme-builder' ),
							'right'  => __( 'Right', 'fl-theme-builder' ),
						),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content',
							'property' => 'text-align',
						),
					),
					'font_size'  => array(
						'type'        => 'text',
						'label'       => __( 'Font Size', 'fl-theme-builder' ),
						'default'     => '',
						'size'        => '5',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.fl-module-content',
							'property' => 'font-size',
							'unit'     => 'px',
						),
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .edd_price',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
