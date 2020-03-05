<?php

/**
 * @class PPHoverCardsModuleNew
 */
class PPHoverCardsModuleNew extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Hover Cards 2', 'bb-powerpack'),
            'description'   => __('Addon to display hover cards.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-hover-cards-2/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-hover-cards-2/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

        $this->add_css( 'hover-cards-2-settings-style', $this->url . 'css/settings.css' );
    }
	public function filter_settings( $settings, $helper ) {

		// Handle hover card title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'hover_card_title_font'			=> array(
				'type'			=> 'font'
			),
			'hover_card_title_font_size'	=> array(
				'type'          => 'font_size',
			),
			'hover_card_title_line_height'	=> array(
				'type'			=> 'line_height',
			),
		), 'hover_card_title_typography' );
		// Handle hover card description's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'hover_card_description_font'		=> array(
				'type'			=> 'font'
			),
			'hover_card_description_font_size'	=> array(
				'type'          => 'font_size',
			),
			'hover_card_description_line_height' => array(
				'type'			=> 'line_height',
			),
		), 'hover_card_description_typography' );

		// Repeater Fields
		for( $i = 0; $i < count( $settings->card_content ); $i++ ) {
			
			if ( ! is_object( $settings->card_content[ $i ] ) ) {
				continue;
			}
			// Handle old Link fields
			$settings->card_content[ $i ] = PP_Module_Fields::handle_link_field( $settings->card_content[ $i ], array(
				'box_link'			=> array(
					'type'			=> 'link',
					'condition'		=> ( isset( $settings->card_content[ $i ]->hover_card_link_type ) && 'box' == $settings->card_content[ $i ]->hover_card_link_type ),
				),
				'link_target'	=> array(
					'type'			=> 'target',
					'condition'		=> ( isset( $settings->card_content[ $i ]->hover_card_link_type ) && 'box' == $settings->card_content[ $i ]->hover_card_link_type ),
				),
			), 'box_link' );

			// Handle old Hover Card Box border and radius fields.
			$box_border_color = '';
			if ( isset( $settings->card_content[ $i ]->hover_card_box_border_color ) ) {
				$box_border_color = $settings->card_content[ $i ]->hover_card_box_border_color;
				$opacity = 1;
				if ( isset( $settings->card_content[ $i ]->hover_card_box_border_opacity ) ) {
					$opacity = $settings->card_content[ $i ]->hover_card_box_border_opacity;
					unset($settings->card_content[ $i ]->hover_card_box_border_opacity);
				}
				$box_border_color = pp_hex2rgba( $box_border_color, $opacity );
			}

			$settings->card_content[ $i ] = PP_Module_Fields::handle_border_field( $settings->card_content[ $i ], array(
				'hover_card_box_border'	=> array(
					'type'				=> 'style'
				),
				'hover_card_box_border_width'	=> array(
					'type'				=> 'width'
				),
				'hover_card_box_border_color'	=> array(
					'type'				=> 'color',
					'value'				=> $box_border_color
				),
				'hover_card_box_border_radius'	=> array(
					'type'				=> 'radius'
				),
			), 'hover_card_box_border_group' );
			// Handle Hover Card Box old padding field.
			$settings->card_content[ $i ] = PP_Module_Fields::handle_multitext_field( $settings->card_content[ $i ], 'hover_card_box_padding', 'padding', 'hover_card_box_padding' );

		}

		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPHoverCardsModuleNew', array(
    'general'				=> array(
        'title'     => __('General', 'bb-powerpack'),
        'sections'  => array(
            'style_type'		=> array(
                'title'         => '',
                'fields'        => array(
                    'style_type'    => array(
                        'type'      => 'select',
                        'label'     => __('Select Style', 'bb-powerpack'),
                        'default'   => 'powerpack-style',
                        'options'   => array(
                            'powerpack-style'  => __('Style 0', 'bb-powerpack'),
                            'style-1'   => __('Style 1', 'bb-powerpack'),
                            'style-2'   => __('Style 2', 'bb-powerpack'),
                            'style-3'   => __('Style 3', 'bb-powerpack'),
                            'style-4'   => __('Style 4', 'bb-powerpack'),
                            'style-5'   => __('Style 5', 'bb-powerpack'),
                            'style-6'   => __('Style 6', 'bb-powerpack'),
                            'style-7'   => __('Style 7', 'bb-powerpack'),
                            'style-8'   => __('Style 8', 'bb-powerpack'),
                            'style-9'   => __('Style 9', 'bb-powerpack'),
                            'style-10'  => __('Style 10', 'bb-powerpack'),
                            'style-11'  => __('Style 11', 'bb-powerpack'),
                            'style-12'  => __('Style 12', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'powerpack-style'   => array(
                                'fields'            => array('hover_card_image_select', 'hover_card_icon_color', 'hover_card_icon_size'),
                                'sections'          => array('hover_card_image_section'),
                            ),
                        )
                    ),
                    'hover_card_spacing'    => array(
                        'type'                  => 'unit',
                        'label'                 => __('Gutter/Spacing', 'bb-powerpack'),
                        'units'					=> array('%'),
                        'slider'				=> true,
                        'default'               => 1,
                        'preview'               => array(
                            'type'                  => 'css',
                            'selector'              => '.pp-hover-card',
                            'property'              => 'margin-right',
                            'unit'                  => '%'
                        )
                    ),
                    'hover_card_height' => array(
                    	'type'              => 'pp-multitext',
                        'label' 		    => __('Minimum Height', 'bb-powerpack'),
                        'description'       => 'px',
                        'default'           => array(
                            'desktop'           => 300,
                            'tablet'            => '',
                            'mobile'            => ''
                        ),
                    	'options'  => array(
                    		'desktop' => array(
                                'maxlength'     => 3,
                    			'icon'		    => 'fa-desktop',
                                'placeholder'   => __('Desktop', 'bb-powerpack'),
                                'tooltip'       => __('Desktop', 'bb-powerpack'),
                                'preview'       => array(
                                    'selector'      => '.pp-hover-card',
                                    'property'      => 'min-height',
                                    'unit'          => 'px'
                                )
                    		),
                            'tablet' => array(
                                'maxlength' => 3,
                    			'icon'		=> 'fa-tablet',
                                'placeholder'   => __('Tablet', 'bb-powerpack'),
                                'tooltip'       => __('Tablet', 'bb-powerpack'),
                    		),
                            'mobile' => array(
                                'maxlength' => 3,
                    			'icon'		=> 'fa-mobile',
                                'placeholder'   => __('Mobile', 'bb-powerpack'),
                                'tooltip'       => __('Mobile', 'bb-powerpack'),
                    		),
                    	)
                    ),
                    'hover_card_max_height' => array(
                    	'type'              => 'pp-multitext',
                        'label' 		    => __('Maximum Height (optional)', 'bb-powerpack'),
                        'description'       => 'px',
                        'default'           => array(
                            'desktop'           => '',
                            'tablet'            => '',
                            'mobile'            => ''
                        ),
                    	'options'  => array(
                    		'desktop' => array(
                                'maxlength'     => 3,
                    			'icon'		    => 'fa-desktop',
                                'placeholder'   => __('Desktop', 'bb-powerpack'),
                                'tooltip'       => __('Desktop', 'bb-powerpack'),
                                'preview'       => array(
                                    'selector'      => '.pp-hover-card',
                                    'property'      => 'max-height',
                                    'unit'          => 'px'
                                )
                    		),
                            'tablet' => array(
                                'maxlength' => 3,
                    			'icon'		=> 'fa-tablet',
                                'placeholder'   => __('Tablet', 'bb-powerpack'),
                                'tooltip'       => __('Tablet', 'bb-powerpack'),
                    		),
                            'mobile' => array(
                                'maxlength' => 3,
                    			'icon'		=> 'fa-mobile',
                                'placeholder'   => __('Mobile', 'bb-powerpack'),
                                'tooltip'       => __('Mobile', 'bb-powerpack'),
                    		),
                    	)
                    ),
                    'hover_card_max_width' => array(
                    	'type'              => 'pp-multitext',
                        'label' 		    => __('Maximum Width (optional)', 'bb-powerpack'),
                        'description'       => 'px',
                        'default'           => array(
                            'desktop'           => '',
                            'tablet'            => '',
                            'mobile'            => ''
                        ),
                    	'options'  => array(
                    		'desktop' => array(
                                'maxlength'     => 3,
                    			'icon'		    => 'fa-desktop',
                                'placeholder'   => __('Desktop', 'bb-powerpack'),
                                'tooltip'       => __('Desktop', 'bb-powerpack'),
                                'preview'       => array(
                                    'selector'      => '.pp-hover-card',
                                    'property'      => 'max-width',
                                    'unit'          => 'px'
                                )
                    		),
                            'tablet' => array(
                                'maxlength' => 3,
                    			'icon'		=> 'fa-tablet',
                                'placeholder'   => __('Tablet', 'bb-powerpack'),
                                'tooltip'       => __('Tablet', 'bb-powerpack'),
                    		),
                            'mobile' => array(
                                'maxlength' => 3,
                    			'icon'		=> 'fa-mobile',
                                'placeholder'   => __('Mobile', 'bb-powerpack'),
                                'tooltip'       => __('Mobile', 'bb-powerpack'),
                    		),
                    	)
                    ),
                    'hover_card_img_width'  => array(
                        'type'                  => 'pp-switch',
                        'label'                 => __('Image Maximum Width', 'bb-powerpack'),
                        'default'               => '100',
                        'options'               => array(
                            '100'                   => __('100%', 'bb-powerpack'),
                            'none'                  => __('None', 'bb-powerpack')
                        )
                    )
                ),
            ),
            'hover_card_count'	=> array(
				'title'				=> __('Number of Cards in a row', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'			=> array( // Section Fields
                    'hover_card_column_width' 	=> array(
                    	'type' 			=> 'pp-multitext',
                    	'label' 		=> __('Cards', 'bb-powerpack'),
                        'default'       => array(
                            'desktop' => 4,
                            'tablet' => 2,
                            'mobile' => 1
                        ),
                    	'options' 		=> array(
                    		'desktop' => array(
                                'maxlength'     => 3,
                    			'icon'		    => 'fa-desktop',
                                'placeholder'   => __('Desktop', 'bb-powerpack'),
                                'tooltip'       => __('Desktop', 'bb-powerpack'),
                    		),
                            'tablet' => array(
                                'maxlength'     => 3,
                    			'icon'		    => 'fa-tablet',
                                'placeholder'   => __('Tablet', 'bb-powerpack'),
                                'tooltip'       => __('Tablet', 'bb-powerpack'),
                    		),
                    		'mobile' => array(
                                'maxlength'     => 3,
                    			'icon'		    => 'fa-mobile',
                                'placeholder'   => __('Mobile', 'bb-powerpack'),
                                'tooltip'       => __('Mobile', 'bb-powerpack'),
                    		),
                    	)
                    )
                )
            )
        ),
    ),
    'hover_card_content'	=> array( // Tab
		'title'         => __('Cards', 'bb-powerpack'), // Tab title
		'sections'      => array(
            'hover_card_content' => array(
                'title'     => '',
                'fields'    => array(
                    'card_content'   => array(
                        'type'      => 'form',
                        'label'     => __('Hover Card', 'bb-powerpack'),
                        'form'      => 'pp_hover_card_2_form',
                        'preview_text'  => 'title',
                        'multiple'  => true
                    ),
                ),
            ),
		)
	),
    'typography'			=> array(
        'title'     => __('Typography', 'bb-powerpack'),
        'sections'  => array(
            'hover_card_title_typography'  => array(
                'title' 	=> __('Title', 'bb-powerpack'),
                'fields'    => array(
					'hover_card_title_tag'	=> array(
						'type'		=> 'select',
						'label'		=> __('HTML Tag', 'bb-powerpack'),
						'default'	=> 'h2',
						'options'	=> array(
							'h1'		=> 'h1',
							'h2'		=> 'h2',
							'h3'		=> 'h3',
							'h4'		=> 'h4',
							'h5'		=> 'h5',
							'h6'		=> 'h6',
							'div'		=> 'div',
							'p'			=> 'p'
						)
					),
					'hover_card_title_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-hover-card .pp-hover-card-title-wrap .pp-hover-card-title',
						),
					),
                ),
            ),
            'hover_card_description_typography'  => array(
				'title' 	=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'hover_card_description_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-hover-card .pp-hover-card-description .pp-hover-card-description-inner'
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
FLBuilder::register_settings_form('pp_hover_card_2_form', array(
	'title' => __('Add Hover Card', 'bb-powerpack'),
	'tabs'  => array(
		'general'      => array( // Tab
			'title'         => __('General', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
                'hover_card_image_section'	=> array(
                    'title'      => '',
                    'fields'     => array(
                        'hover_card_image_select'   => array(
                            'type'                      => 'pp-switch',
    						'label'                     => __('Icon Source', 'bb-powerpack'),
                            'default'                   => 'icon',
    						'options'                   => array(
    							'icon'                      => __('Icon', 'bb-powerpack'),
    							'image'                     => __('Image', 'bb-powerpack')
    						),
                            'toggle' => array(
                                'icon' => array(
                                    'fields'    => array('hover_card_font_icon', 'hover_card_icon_size', 'hover_card_icon_color'),
                                ),
                                'image' => array(
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
                            'connections'   => array( 'photo' ),
                        ),
                    ),
                ),
                'title'						=> array(
					'title'      => __('Title', 'bb-powerpack'),
					'collapsed'	=> true,
                    'fields'     => array(
                        'title'         => array(
                            'type'          => 'text',
                            'label'         => '',
                            'connections'   => array( 'string', 'html', 'url' ),
                        ),
                    ),
                ),
                'content'					=> array( // Section
					'title'         => __('Content', 'bb-powerpack'),
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'hover_content' => array(
							'type'          => 'editor',
							'label'         => '',
                            'media_buttons' => false,
                            'rows'          => 10,
                            'connections'   => array( 'string', 'html', 'url' ),
						)
					)
				),
                'button'					=> array(
					'title'     => 'Link',
					'collapsed'	=> true,
                    'fields'    => array(
                        'hover_card_link_type'	=> array(
                            'type'      => 'pp-switch',
                            'label'     => __('Link Type', 'bb-powerpack'),
                            'default'   => 'no',
                            'options'   => array(
                                'no'        => __('No Link', 'bb-powerpack'),
                                'box'       => __('Entire Box', 'bb-powerpack'),
                            ),
                            'toggle'    => array(
                                'box'   => array(
                                    'fields'    => array('box_link'),
                                ),
                            ),
                        ),
                        'box_link'   => array(
                            'type'      => 'link',
                            'label'			=> __('Link', 'bb-powerpack'),
                            'placeholder'   => 'http://www.example.com',
							'connections'   => array( 'url' ),
							'show_target'	=> true,
							'show_nofollow'	=> true,
                        ),
                    ),
                ),
			)
		),
        'styles'    => array(
            'title' => __('Style', 'bb-powerpack'),
            'sections'  => array(
                'content_styling'     => array(
                    'title'     => __('Box', 'bb-powerpack'),
                    'fields'    => array(
                        'hover_card_bg_type' => array(
                            'type'      => 'pp-switch',
                            'label'     => __('Background Type', 'bb-powerpack'),
                            'default'   => 'color',
                            'options'   => array(
                                'color'     => __('Color', 'bb-powerpack'),
                                'image'     => __('Image', 'bb-powerpack'),
                            ),
                            'toggle'    => array(
                                'color' => array(
                                    'fields'    => array('hover_card_bg_color', 'hover_card_bg_hover'),
                                ),
                                'image' => array(
                                    'fields'    => array('hover_card_box_image'),
                                    'sections'  => array('hover_card_overlay_s')
                                ),
                            ),
                        ),
                        'hover_card_bg_color'    => array(
                            'type'      => 'color',
                            'label'     => __('Background Color', 'bb-powerpack'),
                            'default'   => 'f5f5f5',
                            'show_reset'    => true,
							'show_alpha'    => true,
							'connections'	=> array('color'),
                            'preview'   => array(
                                'type'  => 'css',
                                'selector'  => '.pp-hover-card',
                                'property'  => 'background'
                            ),
                        ),
                        'hover_card_bg_hover'    => array(
                            'type'      => 'color',
                            'label'     => __('Background Hover Color', 'bb-powerpack'),
                            'default'   => '',
                            'show_reset'    => true,
							'show_alpha'    => true,
							'connections'	=> array('color'),
                            'preview'   => array(
                                'type'  => 'none',
                            ),
                        ),
                        'hover_card_box_image'     => array(
                            'type'      	=> 'photo',
							'label'     	=> __('Background Image', 'bb-powerpack'),
							'connections'   => array( 'photo' ),
						),
						'hover_card_box_border_group'	=> array(
							'type'					=> 'border',
							'label'					=> __('Border Style', 'bb-powerpack'),
							'responsive'			=> true,
						),
						'hover_card_box_padding'			=> array(
							'type'				=> 'dimension',
							'label'				=> __('Padding', 'bb-powerpack'),
							'slider'			=> true,
							'units'				=> array( 'px' ),
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.pp-info-banner-content .banner-button',
								'property'			=> 'padding',
								'unit'				=> 'px'
							),
							'responsive'		=> true,
						),
                    ),
                ),
                'hover_card_overlay_s'    => array(
					'title' => __('Overlay On Hover', 'bb-powerpack'),
					'collapsed'	=> true,
                    'fields'    => array(
                        'hover_card_overlay'     => array(
                            'type'         => 'color',
                            'label'        => __('Color', 'bb-powerpack'),
							'show_reset'   => true,
							'connections'	=> array('color'),
                        ),
                        'hover_card_overlay_opacity' => array(
                            'type'      => 'text',
                            'label'     => __('Opacity', 'bb-powerpack'),
                            'size'      => 5,
                            'default'       => 1,
                            'description'   => __('between 0 to 1', 'bb-powerpack'),
                        ),
                    )
                ),
                'hover_card_icon_style'    => array(
					'title'     => __('Icon', 'bb-powerpack'),
					'collapsed'	=> true,
                    'fields'    => array(
                        'hover_card_icon_size'    => array(
                            'type'          => 'unit',
                            'slider'		=> true,
                            'units'			=> array('px'),
                            'default'       => '70',
                            'label'         => __('Size', 'bb-powerpack'),
                        ),
                        'hover_card_icon_color'   => array(
                            'type'      => 'color',
                            'label'     => __('Color', 'bb-powerpack'),
							'default'   => '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
                        ),
                    )
                ),
                'title_style'    => array(
					'title'     => __('Title', 'bb-powerpack'),
					'collapsed'	=> true,
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
					'collapsed'	=> true,
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
    ),
));
