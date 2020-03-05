<?php

/**
 * @since 1.1
 * @class FLEDDProductTitleModule
 */
class FLEDDProductTitleModule extends FLBuilderModule {

	/**
	 * @since 1.1
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Title', 'fl-theme-builder' ),
			'description'     => __( 'Displays the title for the current product.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'Easy Digital Downloads', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/edd/modules/fl-edd-product-title/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/edd/modules/fl-edd-product-title/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLEDDProductTitleModule', array(
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
					'font'       => array(
						'type'    => 'font',
						'default' => array(
							'family' => 'Default',
							'weight' => 300,
						),
						'label'   => __( 'Font', 'fl-builder' ),
						'preview' => array(
							'type'     => 'font',
							'selector' => '.fl-module-content .edd_download_title',
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
							'selector' => '.fl-module-content .edd_download_title',
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
							'selector' => '.fl-module-content .edd_download_title, .fl-module-content .edd_download_title a',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
