<?php
/**
 * This module was originally developed by Jonathan Perez
 * and licensed under GPL 2.
 * Author: Jonathan Perez
 * Author URI: http://surefirewebservices.com
 */

/**
 * @class PPRestaurantMenuModule
 */
class PPRestaurantMenuModule extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'              => __('Restaurant / Services Menu', 'bb-powerpack'),
            'description'       => __('Restaurant and Services Menu', 'bb-powerpack'),
            'group'             => pp_get_modules_group(),
            'category'		    => pp_get_modules_cat( 'content' ),
            'dir'               => BB_POWERPACK_DIR . 'modules/pp-restaurant-menu/',
            'url'               => BB_POWERPACK_URL . 'modules/pp-restaurant-menu/',
            'editor_export'     => true,
            'enabled'           => true,
            'partial_refresh'   => true,
        ));
	}

	public function filter_settings( $settings, $helper ) {
		// Handle old Heading border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'heading_border'	=> array(
				'type'				=> 'style',
			),
			'heading_border_width'	=> array(
				'type'				=> 'width',
			),
			'heading_border_color'	=> array(
				'type'				=> 'color',
			),
		), 'heading_border_group' );

		// Handle old Card Border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'card_border'	=> array(
				'type'				=> 'style',
			),
			'card_border_width'	=> array(
				'type'				=> 'width',
			),
			'card_border_color'	=> array(
				'type'				=> 'color',
			),
			'card_radius'	=> array(
				'type'				=> 'radius',
			),
			'card_shadow'	=> array(
				'type'				=> 'shadow',
				'condition'     	=> ( isset( $settings->card_shadow_enable ) && 'yes' == $settings->card_shadow_enable ),
			),
			'card_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'opacity'			=> ( isset( $settings->card_shadow_opacity ) ) ? ( $settings->card_shadow_opacity / 100 ) : 1,
				'condition'     	=> ( isset( $settings->card_shadow_enable ) && 'yes' == $settings->card_shadow_enable ),
			),
		), 'card_border_group' );

		// Handle Card Items old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'card_padding_custom', 'padding', 'card_padding_group' );

		// Handle Card Items old Margin field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'card_margin_custom', 'margin', 'card_margin_group' );

		// Handle Menu Heading old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'menu_heading_font'	=> array(
				'type'			=> 'font'
			),
			'menu_heading_size'	=> array(
				'type'          => 'font_size',
			),
			'menu_heading_align'	=> array(
				'type'          => 'text_align',
			),
		), 'menu_heading_typography' );

		// Handle Items Title old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'items_title_font'	=> array(
				'type'			=> 'font'
			),
			'item_title_size'	=> array(
				'type'          => 'font_size',
			),
			'items_title_font_style'	=> array(
				'type'          => 'font_style',
			),
		), 'items_title_typography' );

		// Handle Items description old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'items_description_font'	=> array(
				'type'			=> 'font'
			),
			'item_description_size'	=> array(
				'type'          => 'font_size',
			),
			'items_description_font_style'	=> array(
				'type'          => 'font_style',
			),
		), 'items_description_typography' );

		// Handle Items Price old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'items_price_font'	=> array(
				'type'			=> 'font'
			),
			'item_color_size'	=> array(
				'type'          => 'font_size',
			),
			'items_price_font_style'	=> array(
				'type'          => 'font_style',
			),
		), 'items_price_typography' );

		for( $i = 0; $i < count( $settings->menu_items ); $i++ ) {
			
			if ( ! is_object( $settings->menu_items[ $i ] ) ) {
				continue;
			}

			// Handle old link, link_target fields.
			$settings->menu_items[ $i ] = PP_Module_Fields::handle_link_field( $settings->menu_items[ $i ], array(
				'menu_items_link'			=> array(
					'type'						=> 'link'
				),
				'menu_items_link_target'	=> array(
					'type'						=> 'target'
				),
			), 'menu_items_link' );
		}

		return $settings;
	}
}

FLBuilder::register_module('PPRestaurantMenuModule', array(
	'restaurant_menu_general'	=> array(
		'title'         => __('General', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
			'heading'       => array(
				'title'         => __('Heading', 'bb-powerpack'), // Section Title
				'fields'        => array( // Section Fields
					'menu_heading'			=> array(
						'type'          => 'text',
						'label'         => __('Heading', 'bb-powerpack'),
						'default'       => __( 'MENU TITLE', 'bb-powerpack' ),
						'connections'   => array( 'string', 'html', 'url' ),
					),
				)
			),
			'item_layouts'  => array(
				'title'         => __( 'Content Layout', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'restaurant_menu_layout'    => array(
						'type'                      => 'pp-switch',
						'label'                     => __('Show Photo and Content', 'bb-powerpack'),
						'options'                   => array(
							'stacked'                   => __( 'Stacked', 'bb-powerpack' ),
							'inline'                    => __( 'Inline', 'bb-powerpack' )
						),
						'default'                   => 'stacked',
						'toggle'                    => array(
							'stacked'                   => array(
								'fields'                    => array('text_alignment')
							),
							'inline'                    => array(
								'fields'                    => array('inline_image_width'),
							)
						)
					),
					'inline_image_width'         => array(
						'type'          => 'unit',
						'label'         => __('Image Width', 'bb-powerpack'),
						'slider'		=> true,
						'default'       => '40',
						'units'			=> array('%'),
					),
					'text_alignment'    => array(
						'type'              => 'pp-switch',
						'label'             => __('Text Alignment', 'bb-powerpack'),
						'options'           => array(
							'left'              => __( 'Left', 'bb-powerpack' ),
							'center'            => __( 'Center', 'bb-powerpack' )
						),
						'default'           => 'left',
					),
					'show_description'    => array(
						'type'              => 'pp-switch',
						'label'             => __('Show Item Description', 'bb-powerpack'),
						'options'           => array(
							'yes'               => __( 'Yes', 'bb-powerpack' ),
							'no'                => __( 'No', 'bb-powerpack' )
						),
						'default'           => 'yes',
					),
					'show_price'    => array(
						'type'              => 'pp-switch',
						'label'             => __('Show Item Price', 'bb-powerpack'),
						'options'           => array(
							'yes'               => __( 'Yes', 'bb-powerpack' ),
							'no'                => __( 'No', 'bb-powerpack' )
						),
						'default'           => 'yes',
						'toggle'        => array(
							'yes'           => array(
								'fields'        => array('currency_symbol')
							)
						)
					),
					'currency_symbol'   => array(
						'type'              => 'text',
						'label'             => __('Currency Symbol', 'bb-powerpack'),
						'default'           => '$',
						'size'              => 5,
					)
				)
			),
			'general'       => array( // Section
				'title'         => __( 'Responsive Columns', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'large_device_columns'     => array(
						'type'          => 'select',
						'label'         => __( 'Large Device', 'bb-powerpack' ),
						'default'       => '2',
						'size'          => '2',
						'options'       => array(
							'1'             => 1,
							'2'             => 2,
							'3'             => 3
						)
					),
					'medium_device_columns'     => array(
						'type'          => 'select',
						'label'         => __( 'Medium Device', 'bb-powerpack' ),
						'default'       => '2',
						'size'          => '2',
						'options'       => array(
							'1'             => 1,
							'2'             => 2,
							'3'             => 3
						)
					),
					'small_device_columns'     => array(
						'type'          => 'select',
						'label'         => __( 'Small Device', 'bb-powerpack' ),
						'default'       => '1',
						'size'          => '2',
						'options'       => array(
							'1'             => 1,
							'2'             => 2,
							'3'             => 3
						)
					)
				)
			)
		)
	),
	'restaurant_menu_item'		=> array(
		'title'         =>  __('Menu Items', 'bb-powerpack'),
		'sections'      => array(
			'menu_item'  => array(
				'title'         => '',
				'fields'        => array(
					'menu_items'     => array(
						'type'          => 'form',
						'label'         => __('Items', 'bb-powerpack'),
						'form'          => 'restaurant_menu_form', // ID from registered form below
						'multiple'      => true,
						'preview_text'  => 'menu_items_title'
					)
				)
			)
		)
	),
	'heading_style'				=> array(
		'title'         =>  __('Heading Style', 'bb-powerpack'),
		'sections'      => array(
			'card_style'  => array(
				'title'         => __('Background', 'bb-powerpack'),
				'fields'        => array(
					'heading_bg_type'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Heading Background', 'bb-powerpack' ),
						'default'       => 'none',
						'options'       => array(
							'none'          => __( 'None', 'bb-powerpack' ),
							'color'         => __( 'Color', 'bb-powerpack' ),
						),
							'toggle'        => array(
							'color'           => array(
								'fields'        => array('heading_bg')
							)
						)
					),
					'heading_bg'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => 'ffffff',
						'show_reset'    => false,
						'show_alpha'    => false,
						'connections'	=> array('color'),
					),
				)
			),
			'heading_border'   => array(
				'title'         => __('Border', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'        => array(
					'heading_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-restaurant-menu-heading',
						),
					),
				)
			),
			'heading_structure' => array(
				'title'             => __('Structure', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'            => array(
					'heading_margin'   => array(
						'type'              => 'pp-multitext',
						'label'             => __('Margin', 'bb-powerpack'),
						'description'       => 'px',
						'default'           => array(
							'top'		        => 30,
							'bottom'	        => 30,
						),
						'options'		=> array(
							'top'		    => array(
								'placeholder'	=> __('Top', 'bb-powerpack'),
								'icon'			=> 'fa-long-arrow-up',
								'tooltip'		=> __('Top', 'bb-powerpack'),
								'preview'		=> array(
									'selector'	=> '.pp-restaurant-menu-heading',
									'property'	=> 'margin-top',
									'unit'		=> 'px'
								),
							),
							'bottom'		=> array(
								'placeholder'	=> __('Bottom', 'bb-powerpack'),
								'icon'			=> 'fa-long-arrow-down',
								'tooltip'		=> __('Bottom', 'bb-powerpack'),
								'preview'		=> array(
									'selector'	=> '.pp-restaurant-menu-heading',
									'property'	=> 'margin-bottom',
									'unit'		=> 'px'
								),
							),
						)
					),
					'heading_padding'   => array(
						'type'              => 'pp-multitext',
						'label'             => __('Padding', 'bb-powerpack'),
						'description'       => 'px',
						'default'           => array(
							'top'		        => 0,
							'bottom'	        => 0,
						),
						'options'		=> array(
							'top'		    => array(
								'placeholder'	=> __('Top', 'bb-powerpack'),
								'icon'			=> 'fa-long-arrow-up',
								'tooltip'		=> __('Top', 'bb-powerpack'),
								'preview'		=> array(
									'selector'	=> '.pp-restaurant-menu-heading',
									'property'	=> 'padding-top',
									'unit'		=> 'px'
								),
							),
							'bottom'		=> array(
								'placeholder'	=> __('Bottom', 'bb-powerpack'),
								'icon'			=> 'fa-long-arrow-down',
								'tooltip'		=> __('Bottom', 'bb-powerpack'),
								'preview'		=> array(
									'selector'	=> '.pp-restaurant-menu-heading',
									'property'	=> 'padding-bottom',
									'unit'		=> 'px'
								),
							),
						)
					),
				)
			)
		)
	),
	'restaurant_menu_style'		=> array(
		'title'         =>  __('Items Style', 'bb-powerpack'),
		'sections'      => array(
			'card_tabindex'	=> array(
				'title'			=> '',
				'fields'		=> array(
					'card_tabindex'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Enable Tab Index', 'bb-powerpack'),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'yes'		=> array(
								'fields'	=> array('card_custom_tabindex'),
							)
						)
					),
					'card_custom_tabindex'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Custom Tab Index', 'bb-powerpack'),
						'default'		=> '',
						'responsive'	=> false,
						'help'			=> __('Leave blank for default tabindex i.e. 0', 'bb-powerpack')
					)
				)
			),
			'card_style'  => array(
				'title'         => __('Background', 'bb-powerpack'),
				'fields'        => array(
					'card_bg_type'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Item Background', 'bb-powerpack' ),
						'default'       => 'none',
						'options'       => array(
							'none'          => __( 'None', 'bb-powerpack' ),
							'color'         => __( 'Color', 'bb-powerpack' ),
						),
							'toggle'        => array(
							'color'           => array(
								'fields'        => array('card_bg')
							)
						)
					),
					'card_bg'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'show_reset'    => false,
						'show_alpha'    => false,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-menu-item',
							'property'      => 'background-color',
						)
					),
				)
			),
			'card_border'   => array(
				'title'         => __('Border', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'        => array(
					'card_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-menu-item',
						),
					),
				)
			),
			'card_structure'    => array(
				'title'             => __('Structure', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'            => array(
					'card_padding_group'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-restaurant-menu-item, .pp-restaurant-menu-item-inline',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
					'card_margin_group'		=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Margin', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-restaurant-menu-item, .pp-restaurant-menu-item-inline',
                            'property'			=> 'margin',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
				)
			),
		)
	),
	'typography'				=> array(
		'title'         => __( 'Typography', 'bb-powerpack' ),
		'sections'      => array(
			'menu_heading'  				=> array(
				'title'         => __( 'Heading', 'bb-powerpack' ),
				'fields'        => array(
					'menu_heading_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-restaurant-menu-heading',
						),
					),
					'menu_heading_color'     => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
				)
			),
			'menu_item_style'  				=> array(
				'title'         => __('Items Title', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'        => array(
					'items_title_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-restaurant-menu-item-title'
						),
					),
					'menu_title_color'     => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'property'      => 'color',
							'selector'      => '.pp-restaurant-menu-item-title',
						)
					),
				)
			),
			'menu_description_item_style'	=> array(
				'title'         => __('Items Description', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'        => array(
					'items_description_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-restaurant-menu-item-description',
						),
					),
					'menu_description_color'     => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'property'      => 'color',
							'selector'      => '.pp-restaurant-menu-item-description'
						)
					),
				)
			),
			'menu_item_price_style'  		=> array(
				'title'         => __('Items Price', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'        => array(
					'items_price_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-restaurant-menu-item-price'
						),
					),
					'menu_price_color'  => array(
						'type'              => 'color',
						'label'             => __('Color', 'bb-powerpack'),
						'default'           => 'aaaaaa',
						'show_reset'        => true,
						'connections'	=> array('color'),
						'preview'           => array(
							'type'              => 'css',
							'property'          => 'color',
							'selector'          => '.pp-restaurant-menu-item-price'
						)
					),
				)
			)
		)
	)
) );
FLBuilder::register_settings_form('restaurant_menu_form', array(
    'title' => __('Add Items', 'bb-powerpack'),
    'tabs'  => array(
        'general'      => array( // Tab
            'title'         => __('General', 'bb-powerpack'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields
                        'restaurant_select_images'	=> array(
							'type'          => 'select',
							'label'         => __('Item Photo', 'bb-powerpack'),
							'default'       => 'none',
							'options'       => array(
								'yes'           => __( 'Yes', 'bb-powerpack' ),
								'none'          => __( 'No', 'bb-powerpack' ),
                            ),
                            'toggle'        => array(
                                'yes'           => array(
                                    'fields'        => array('menu_item_images')
                                )
                            )
                        ),
                        'menu_item_images'			=> array(
                           'type'          => 'photo',
                           'label'         => __('Select Photo', 'bb-powerpack'),
                           'connections'   => array( 'photo' ),
                        ),
                        'menu_items_title'			=> array(
                            'type'          => 'text',
                            'label'         => __('Title', 'bb-powerpack'),
                            'default'       => __('Menu Item', 'bb-powerpack'),
                            'connections'   => array( 'string', 'html', 'url' ),
                        ),
                        'menu_items_link'			=> array(
                            'type'          => 'link',
                            'label'         => __('Link To', 'bb-powerpack'),
                            'default'       => '',
							'connections'   => array( 'url' ),
							'show_target'	=> true,
							'show_nofollow'	=> true,
						),
                        'menu_item_description'		=> array(
                           'type'          => 'text',
                           'label'         => __('Item Description', 'bb-powerpack'),
                           'default'       => __('Lorem Ipsum is simply dummy text', 'bb-powerpack'),
                           'connections'   => array( 'string', 'html', 'url' ),
                       ),
                       'menu_items_price'			=> array(
                           'type'          => 'text',
                           'label'         => __('Price', 'bb-powerpack'),
                           'size'          =>'8',
						   'default'       => '9.99',
						   'connections'	=> array('string')
                       ),
                       'menu_items_unit'			=> array(
                           'type'               => 'text',
                           'label'              => __('Unit', 'bb-powerpack'),
						   'help'               => __('For example, per person, pint, or lb etc.', 'bb-powerpack'),
						   'connections'		=> array('string')
                       ),
                    )
                )
            )
        )
    )
));
