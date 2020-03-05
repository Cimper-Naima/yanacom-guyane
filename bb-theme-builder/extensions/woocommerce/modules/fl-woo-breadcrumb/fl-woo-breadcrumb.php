<?php

/**
 * @since 1.0
 * @class FLWooBreadcrumbModule
 */
class FLWooBreadcrumbModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Breadcrumb', 'fl-theme-builder' ),
			'description'     => __( 'Displays the WooCommerce breadcrumb for the current page.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'WooCommerce', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-breadcrumb/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-breadcrumb/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( array( 'singular', 'archive' ) ),
		));
	}
}

FLBuilder::register_module( 'FLWooBreadcrumbModule', array(
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
							'selector' => '.woocommerce-breadcrumb',
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
							'selector' => '.woocommerce-breadcrumb',
							'property' => 'font-size',
							'unit'     => 'px',
						),
					),
					'link_color' => array(
						'type'       => 'color',
						'label'      => __( 'Link Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.woocommerce-breadcrumb a',
							'property' => 'color',
						),
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.woocommerce-breadcrumb',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
