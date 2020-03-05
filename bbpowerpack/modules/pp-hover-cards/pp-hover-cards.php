<?php

/**
 * @class PPHoverCardsModule
 */
class PPHoverCardsModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Hover Cards', 'bb-powerpack'),
            'description'   => __('Addon to display hover cards.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-hover-cards/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-hover-cards/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

        $this->add_css( 'hover-cards-settings-style', $this->url . 'css/settings.css' );
    }

	public function filter_settings( $settings, $helper )
	{	
		// Handle Success Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'hover_card_height_f', 'responsive', 'hover_card_height', array(
			'desktop'	=>  'hover_card_height',
			'tablet'	=> 	'hover_card_height_tablet',
			'mobile'	=> 	'hover_card_height_mobile'
		) );

		// Handle Success Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'hover_card_column_width', 'responsive', 'hover_card_columns', array(
			'desktop'	=>  'hover_card_columns_desktop',
			'tablet'	=> 	'hover_card_columns_tablet',
			'mobile'	=> 	'hover_card_columns_mobile'
		) );

		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'hover_card_title_font'	=> array(
				'type'			=> 'font'
			),
			'hover_card_title_font_size_f'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'hover_card_title_font_size',
					'tablet'		=> 'hover_card_title_font_size_tablet',
					'mobile'		=> 'hover_card_title_font_size_mobile'
				)
			),
			'hover_card_title_line_height_f'	=> array(
				'type'			=> 'line_height',
				'keys'			=> array(
					'desktop'		=> 'hover_card_title_line_height',
					'tablet'		=> 'hover_card_title_line_height_tablet',
					'mobile'		=> 'hover_card_title_line_height_mobile'
				)
			),
		), 'card_title_typography' );

		// Handle description's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'hover_card_description_font'	=> array(
				'type'			=> 'font'
			),
			'hover_card_description_font_size_f'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'hover_card_description_font_size',
					'tablet'		=> 'hover_card_description_font_size_tablet',
					'mobile'		=> 'hover_card_description_font_size_mobile'
				)
			),
			'hover_card_description_line_height_f'	=> array(
				'type'			=> 'line_height',
				'keys'			=> array(
					'desktop'		=> 'hover_card_description_line_height',
					'tablet'		=> 'hover_card_description_line_height_tablet',
					'mobile'		=> 'hover_card_description_line_height_mobile'
				)
			),
		), 'card_description_typography' );

		// Handle button's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'button_font'	=> array(
				'type'			=> 'font'
			),
			'button_font_size_f'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'button_font_size',
					'tablet'		=> 'hover_card_button_font_size_tablet',
					'mobile'		=> 'hover_card_button_font_size_mobile'
				)
			),
		), 'button_typography' );

		for( $i = 0; $i < count( $settings->card_content ); $i++ ) {
			
			if ( ! is_object( $settings->card_content[ $i ] ) ) {
				continue;
			}

			// Handle old link, link_target fields.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_link_field( $settings->card_content[ $i ], array(
				'button_link'			=> array(
					'type'			=> 'link'
				),
				'link_target'	=> array(
					'type'			=> 'target'
				),
			), 'button_link' );

			// Handle old box border and radius fields.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_border_field( $settings->card_content[ $i ], array(
				'hover_card_box_border'	=> array(
					'type'				=> 'style'
				),
				'hover_card_box_border_width'	=> array(
					'type'				=> 'width'
				),
				'hover_card_box_border_color'	=> array(
					'type'				=> 'color',
				),
				'hover_card_box_border_radius'	=> array(
					'type'				=> 'radius'
				),
			), 'card_box_border' );

			// Handle box border opacity + color field.
			if ( isset( $settings->card_content[ $i ]->hover_card_box_border_opacity ) ) {
				$opacity = $settings->card_content[ $i ]->hover_card_box_border_opacity >= 0 ? $settings->card_content[ $i ]->hover_card_box_border_opacity : 1;
				$color = $settings->card_content[ $i ]->card_box_border['color'];

				if ( ! empty( $color ) ) {
					$color = pp_hex2rgba( pp_get_color_value( $color ), $opacity );
					$settings->card_content[ $i ]->card_box_border['color'] = $color;
				}

				unset( $settings->card_content[ $i ]->hover_card_box_border_opacity );
			}

			// Handle box old padding field.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_multitext_field( $settings->card_content[ $i ], 'hover_card_box_padding', 'padding', 'hover_card_box_padding' );
			
			// Handle button old padding field.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_multitext_field( $settings->card_content[ $i ], 'button_padding', 'padding', 'button_padding' );

			// Handle old button border dual color - hover
			if ( isset( $settings->card_content[ $i ]->button_border_color ) ) {
				$settings->card_content[ $i ]->button_border_hover_color = $settings->card_content[ $i ]->button_border_color->secondary;
			}

			// Handle old button border and radius fields.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_border_field( $settings->card_content[ $i ], array(
				'button_border'	=> array(
					'type'				=> 'style'
				),
				'button_border_width'	=> array(
					'type'				=> 'width'
				),
				'button_border_radius'	=> array(
					'type'				=> 'radius'
				),
				'button_border_color'	=> array(
					'type'					=> 'color',
					'value'					=> ( isset( $settings->card_content[ $i ]->button_border_color ) ) ? $settings->card_content[ $i ]->button_border_color->primary : ''
				)
			), 'button_border_group' );

			// Handle old button text & hover dual color field.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_dual_color_field( $settings->card_content[ $i ], 'button_color', array(
				'primary'	=> 'button_text_color',
				'secondary'	=> 'button_text_hover'
			) );

			// Handle old button background & hover dual color field.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_dual_color_field( $settings->card_content[ $i ], 'button_background', array(
				'primary'	=> 'button_bg_color',
				'secondary'	=> 'button_bg_hover'
			) );

		}
	
		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPHoverCardsModule', array(
    'general'   => array(
        'title'     => __('General', 'bb-powerpack'),
        'sections'  => array(
            'style_type'     => array(
                'title'     => '',
                'fields'    => array(
                    'style_type'     => array(
                        'type'      => 'select',
                        'label'     => __('Select Style', 'bb-powerpack'),
                        'default'     => 'powerpack-style',
                        'options'   => array(
                            'powerpack-style'  => __('Style 0', 'bb-powerpack'),
                            'style-1'  => __('Style 1', 'bb-powerpack'),
                            'style-2'  => __('Style 2', 'bb-powerpack'),
                            'style-3'  => __('Style 3', 'bb-powerpack'),
                            'style-4'  => __('Style 4', 'bb-powerpack'),
                            'style-5'  => __('Style 5', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'powerpack-style'   => array(
                                'fields'    => array('hover_card_image_select', 'hover_card_icon_color', 'hover_card_icon_color_h', 'hover_card_icon_size'),
                                'sections'    => array('hover_card_image_section'),
                            ),
                            'style-1'   => array(),
                            'style-2'   => array(),
                            'style-3'   => array(),
                            'style-4'   => array(),
                            'style-5'   => array()
                        )
                    ),
                    'hover_card_spacing'   => array(
                        'type'          => 'unit',
                        'label'         => __('Gutter/Spacing', 'bb-powerpack'),
                        'units'   		=> array( '%' ),
                        'slider'      	=> true,
                        'default'       => '1',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-hover-card-container',
                            'property'  => 'margin-right',
                            'unit'      => '%'
                        )
                    ),
					'hover_card_height'	=> array(
						'type'						=> 'unit',
						'label'						=> __('Height', 'bb-powerpack'),
						'default'					=> 300,
						'slider'					=> true,
						'responsive'				=> true,
						'preview'       			=> array(
							'type'						=> 'css',
							'selector'        			=> '.pp-hover-card-container',
							'property'        			=> 'height',
						),
					),
                ),
            ),
            'hover_card_count'       => array( // Section
                'title'        => __('Number of Cards in a row', 'bb-powerpack'), // Section Title
                'fields'       => array( // Section Fields
					'hover_card_columns'	=> array(
						'type'						=> 'unit',
						'label'						=> __('Cards', 'bb-powerpack'),
						'slider'					=> true,
						'responsive'				=> array(
							'default' => array(
								'default'    => '3',
								'medium'     => '2',
								'responsive' => '1',
							),
						),
					),
                )
            )
        ),
    ),
    'hover_card_content'      => array( // Tab
		'title'         => __('Content', 'bb-powerpack'), // Tab title
		'sections'      => array(
            'hover_card_content' => array(
                'title'     => '',
                'fields'    => array(
                    'card_content'   => array(
                        'type'      => 'form',
                        'label'     => __('Hover Card', 'bb-powerpack'),
                        'form'      => 'pp_hover_card_form',
                        'preview_text'  => 'title',
                        'multiple'  => true
                    ),
                ),
            ),
		)
	),
    'style'     => array(
        'title'     => __('Style', 'bb-powerpack'),
        'sections'      => array(
            'title_styles'     => array(
                'title'     => __('Title', 'bb-powerpack'),
                'fields'    => array(
                    'hover_card_title_margin' 	=> array(
                    	'type' 			=> 'pp-multitext',
                    	'label' 		=> __('Margin', 'bb-powerpack'),
                        'description'   => 'px',
                        'default'       => array(
                            'hover_card_title_margin_top' => 10,
                            'hover_card_title_margin_bottom' => 10,
                        ),
                    	'options' 		=> array(
                    		'hover_card_title_margin_top' => array(
                                'maxlength' => 3,
                                'placeholder'   =>  __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-up',
                                'preview'   => array(
                                    'selector'  => '.pp-hover-card-container .pp-hover-card-title h3',
                                    'property'  => 'margin-top',
                                    'unit'      => 'px'
                                )
                    		),
                            'hover_card_title_margin_bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   =>  __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-down',
                                'preview'   => array(
                                    'selector'  => '.pp-hover-card-container .pp-hover-card-title h3',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                    		),
                    	)
                    )
                )
            ),
            'description_styles'     => array(
                'title'     => __('Description', 'bb-powerpack'),
                'fields'    => array(
                    'hover_card_description_margin' 	=> array(
                    	'type' 			=> 'pp-multitext',
                    	'label' 		=> __('Margin', 'bb-powerpack'),
                        'description'   => 'px',
                        'default'       => array(
                            'hover_card_description_margin_top' => 10,
                            'hover_card_description_margin_bottom' => 10,
                        ),
                    	'options' 		=> array(
                    		'hover_card_description_margin_top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-up',
                                'preview'   => array(
                                    'selector'  => '.pp-hover-card-container .pp-hover-card-description',
                                    'property'  => 'margin-top',
                                    'unit'      => 'px'
                                )
                    		),
                            'hover_card_description_margin_bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-down',
                                'preview'   => array(
                                    'selector'  => '.pp-hover-card-container .pp-hover-card-description',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                    		),
                    	)
                    )
                )
            ),
        ),
    ),
    'typography'   => array(
        'title'     => __('Typography', 'bb-powerpack'),
        'sections'  => array(
            'hover_card_title_typography'  => array(
                'title' => __('Title', 'bb-powerpack'),
                'fields'    => array(
                    'hover_card_title_tag'  => array(
                        'type'      => 'select',
                        'label'     => __('HTML Tag', 'bb-powerpack'),
                        'default'   => 'h3',
                        'options'   => array(
                            'h1'        => 'H1',
                            'h2'        => 'H2',
                            'h3'        => 'H3',
                            'h4'        => 'H4',
                            'h5'        => 'H5',
                            'h6'        => 'H6',
                        )
                    ),
					'card_title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-hover-card-container .pp-hover-card-title h3',
						),
					),
                ),
            ),
            'hover_card_description_typography'  => array(
                'title' => __('Description', 'bb-powerpack'),
                'fields'    => array(
					'card_description_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-hover-card-container .pp-hover-card-description',
						),
					),
                ),
            ),
            'button_typography'  => array(
                'title' => __('Button', 'bb-powerpack'),
                'fields'    => array(
					'button_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-hover-card .pp-hover-card-inner .pp-more-link',
						),
					),
                ),
            ),
        ),
    ),
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('pp_hover_card_form', array(
	'title' => __('Add Hover Card', 'bb-powerpack'),
	'tabs'  => array(
		'general'      => array( // Tab
			'title'         => __('General', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
                'background_type_section'   => array(
                    'title' => '',
                    'fields'    => array(
                        'hover_card_bg_type' => array(
                            'type'      => 'pp-switch',
                            'label'     => __('Background Type', 'bb-powerpack'),
                            'default'   => 'color',
                            'options'   => array(
                                'color' => __('Color', 'bb-powerpack'),
                                'image' => __('Image', 'bb-powerpack'),
                            ),
                            'toggle'    => array(
                                'color' => array(
                                    'fields'    => array('hover_card_bg_color'),
                                ),
                                'image' => array(
                                    'fields'    => array('hover_card_box_image'),
                                    'sections'  => array('hover_card_overlay_s')
                                ),
                            ),
                        ),
                        'hover_card_bg_color'    => array(
                            'type'      => 'color',
                            'label'     => __('Color', 'bb-powerpack'),
                            'default'   => 'f5f5f5',
							'show_reset'    => true,
							'connections'	=> array('color'),
                            'preview'   => array(
                                'type'  => 'css',
                                'selector'  => '.pp-hover-card-container',
                                'property'  => 'background'
                            ),
                        ),
                        'hover_card_box_image'     => array(
                            'type'      => 'photo',
                            'label'     => __('Image', 'bb-powerpack'),
                            'connections'   => array( 'photo' ),
                        ),
                    )
                ),
                'hover_card_image_section'          => array(
                    'title'      => '',
                    'fields'     => array(
                        'hover_card_image_select'       => array(
                            'type'          => 'pp-switch',
    						'label'         => __('Icon Source', 'bb-powerpack'),
                            'default'       => 'hover_card_font_icon_select',
    						'options'       => array(
    							'hover_card_font_icon_select'   => __('Icon', 'bb-powerpack'),
    							'hover_card_custom_icon_select' => __('Image', 'bb-powerpack')
    						),
                            'toggle' => array(
                                'hover_card_font_icon_select' => array(
                                    'fields'    => array('hover_card_font_icon', 'hover_card_icon_size', 'hover_card_icon_color', 'hover_card_icon_color_h'),
                                ),
                                'hover_card_custom_icon_select' => array(
                                    'fields'    => array('hover_card_custom_icon', 'hover_card_icon_size'),
                                )
                            )
    					),
                        'hover_card_font_icon' => array(
    						'type'          => 'icon',
    						'label'         => __('Icon', 'bb-powerpack'),
                            'show_remove'   => true
    					),
                        'hover_card_custom_icon'     => array(
                            'type'              => 'photo',
                            'label'         => __('Image', 'bb-powerpack'),
                            'show_remove'   => true,
                            'connections'   => array( 'photo' )
                        ),
                    ),
                ),
                'title'          => array(
                    'title'      => __('Title', 'bb-powerpack'),
                    'fields'     => array(
                        'title'     => array(
                            'type'          => 'text',
                            'label'         => '',
                            'connections'   => array( 'string', 'html', 'url' ),
                        ),
                    ),
                ),
                'content'       => array( // Section
					'title'         => __('Content', 'bb-powerpack'), // Section Title
					'fields'        => array( // Section Fields
						'hover_content'          => array(
							'type'          => 'editor',
							'label'         => '',
                            'connections'   => array( 'string', 'html', 'url' ),
						)
					)
				),
                'button'     => array(
                    'title'     => '',
                    'fields'    => array(
                        'hover_card_link_type'     => array(
                            'type'      => 'pp-switch',
                            'label'     => __('Link Type', 'bb-powerpack'),
                            'default'   => 'no',
                            'options'   => array(
                                'no'    => __('No Link', 'bb-powerpack'),
                                'box'    => __('Entire Box', 'bb-powerpack'),
                                'button'    => __('Button', 'bb-powerpack'),
                            ),
                            'toggle'    => array(
                                'box'   => array(
                                    'fields'    => array('button_link'),
                                ),
                                'button'   => array(
                                    'fields'    => array('button_text', 'button_link'),
                                    'tabs'      => array('button_style')
                                ),
                            ),
                        ),
                        'button_text'   => array(
                            'type'      => 'text',
                            'label'     => __('Button Text', 'bb-powerpack'),
                            'preview'   => array(
                                'type'  => 'text',
                                'selector'  => '.pp-hover-card .pp-more-link'
                            ),
                        ),
                        'button_link'  => array(
							'type'          => 'link',
							'label'         => __('Link', 'bb-powerpack'),
							'placeholder'   => 'http://www.example.com',
							'show_target'	=> true,
							'connections'   => array( 'url' ),
							'preview'       => array(
								'type'          => 'none'
							)
						),
                    ),
                ),
			)
		),
        'styles'    => array(
            'title' => __('Style', 'bb-powerpack'),
            'sections'  => array(
                'static_content_Styling'     => array(
                    'title'     => 'Box',
                    'fields'    => array(
						'card_box_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-powerpack' ),
							'responsive'	=> true,
						),
						'hover_card_box_padding'	=> array(
							'type'				=> 'dimension',
							'label'				=> __('Padding', 'bb-powerpack'),
							'default'			=> '20',
							'units'				=> array('px'),
							'slider'			=> true,
							'responsive'		=> true,
						),
                    ),
                ),
                'hover_card_overlay_s'    => array(
                    'title' => __('Overlay On Hover', 'bb-powerpack'),
                    'fields'    => array(
                        'hover_card_overlay'     => array(
                            'type'      => 'color',
                            'label'     => __('Color', 'bb-powerpack'),
							'show_reset'   => true,
							'connections'	=> array('color'),
                        ),
                        'hover_card_overlay_opacity' => array(
                            'type'  => 'text',
                            'label' => __('Opacity', 'bb-powerpack'),
                            'size'  => 5,
                            'default'   => 1,
                            'description'   => __('between 0 to 1', 'bb-powerpack'),
                        ),
                    )
                ),
                'hover_card_icon_style'    => array(
                    'title'     => __('Icon', 'bb-powerpack'),
                    'fields'    => array(
                        'hover_card_icon_size'    => array(
                            'type'          => 'unit',
                            'default'       => '70',
                            'label'         => __('Size', 'bb-powerpack'),
                            'units'   		=> array( 'px' ),
							'slider'		=> true,
							'responsive'	=> true
                        ),
                        'hover_card_icon_color'   => array(
                            'type'      => 'color',
                            'label'     => __('Color', 'bb-powerpack'),
							'default'   => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'hover_card_icon_color_h'   => array(
                            'type'      => 'color',
                            'label'     => __('Color Hover', 'bb-powerpack'),
							'default'   => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
                        ),
                    )
                ),
                'title_style'    => array(
                    'title'     => __('Title', 'bb-powerpack'),
                    'fields'    => array(
                        'hover_card_title_color'       => array(
                            'type'          => 'color',
                            'label'         => __('Color', 'bb-powerpack'),
							'default'       => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'hover_card_title_color_h'       => array(
                            'type'          => 'color',
                            'label'         => __('Color Hover', 'bb-powerpack'),
							'default'       => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
                        ),
                    ),
                ),
                'description_style'    => array(
                    'title'     => __('Description', 'bb-powerpack'),
                    'fields'    => array(
                        'hover_card_description_color'       => array(
                            'type'          => 'color',
                            'label'         => __('Color', 'bb-powerpack'),
							'default'       => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'hover_card_description_color_h'       => array(
                            'type'          => 'color',
                            'label'         => __('Color Hover', 'bb-powerpack'),
							'default'       => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
                        ),
                    ),
                ),
            ),
        ),
        'button_style'    => array(
            'title' => __('Button', 'bb-powerpack'),
            'sections'  => array(
                'button_styles'     => array(
                    'title'     => '',
                    'fields'    => array(
                        'button_width'   => array(
                            'type'      	=> 'unit',
                            'label'     	=> __('Width', 'bb-powerpack'),
                            'default'   	=> 100,
                            'units'   		=> array( 'px' ),
							'slider'		=> true,
							'responsive'	=> true
                        ),
						'button_text_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Text Color', 'bb-powerpack' ),
							'default'		=> '000000',
							'connections'	=> array('color'),
						),
						'button_text_hover'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Text Hover Color', 'bb-powerpack' ),
							'default'		=> '000000',
							'connections'	=> array('color'),
						),
						'button_bg_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Background Color', 'bb-powerpack' ),
							'default'		=> 'ffffff',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
						),
						'button_bg_hover'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Background Hover Color', 'bb-powerpack' ),
							'default'		=> 'ffffff',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
						),
                        'button_border_group'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-powerpack' ),
							'responsive'	=> true,
						),
						// 'button_border_color'   => array(
                        //     'type'      => 'pp-color',
                        //     'label'     => __('Border Color', 'bb-powerpack'),
                        //     'show_reset' => true,
                        //     'default'   => array(
                        //         'primary'	=> '',
                        //         'secondary'	=> ''
                        //     ),
                        //     'options'	=> array(
                        //         'primary'	=> __('Default', 'bb-powerpack'),
                        //         'secondary' => __('Hover', 'bb-powerpack')
                        //     )
                        // ),
						'button_border_hover_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Border Hover Color', 'bb-powerpack' ),
							'default'		=> '',
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
                        'button_padding'	=> array(
							'type'				=> 'dimension',
							'label'				=> __('Padding', 'bb-powerpack'),
							'default'			=> '10',
							'units'				=> array('px'),
							'slider'			=> true,
							'responsive'		=> true,
						),
                    ),
                ),
            )
    	)
    ),
));
