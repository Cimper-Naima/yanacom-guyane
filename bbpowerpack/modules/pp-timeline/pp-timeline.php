<?php

/**
 * @class PPTimelineModule
 */
class PPTimelineModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Timeline', 'bb-powerpack'),
            'description'   => __('Addon to display content in timeline format.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-timeline/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-timeline/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

		$this->add_css( BB_POWERPACK()->fa_css );
    }

	public function filter_settings( $settings, $helper )
	{
	
		for( $i = 0; $i < count( $settings->timeline ); $i++ ) {
			
			if ( ! is_object( $settings->timeline[ $i ] ) ) {
				continue;
			}

			// Handle old link, link_target fields.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_link_field( $settings->timeline[ $i ], array(
				'button_link'			=> array(
					'type'			=> 'link'
				),
				'button_target'	=> array(
					'type'			=> 'target'
				),
			), 'button_link' );

			// Handle old icon border and radius fields.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_border_field( $settings->timeline[ $i ], array(
				'icon_border_style'	=> array(
					'type'				=> 'style'
				),
				'icon_border_width'	=> array(
					'type'				=> 'width'
				),
				'icon_border_color'	=> array(
					'type'				=> 'color'
				),
				'icon_border_radius'	=> array(
					'type'				=> 'radius'
				),
			), 'icon_border' );

			// Handle old icon background & text dual color field.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_dual_color_field( $settings->timeline[ $i ], 'icon_color', array(
				'primary'	=> 'icon_text_color',
				'secondary'	=> 'icon_background_color'
			) );

			// Handle old title background & text dual color field.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_dual_color_field( $settings->timeline[ $i ], 'title_color', array(
				'primary'	=> 'title_text_color',
				'secondary'	=> 'title_background_color'
			) );

			// Handle old box border and radius fields.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_border_field( $settings->timeline[ $i ], array(
				'timeline_box_border_type'	=> array(
					'type'				=> 'style'
				),
				'timeline_box_border_width'	=> array(
					'type'				=> 'width'
				),
				'timeline_box_border_color'	=> array(
					'type'				=> 'color'
				),
				'timeline_box_border_radius'	=> array(
					'type'				=> 'radius'
				),
				'box_shadow_options'		=> array(
					'type'				=> 'shadow',
					'condition'			=> ( isset( $settings->timeline[ $i ]->timeline_box_shadow ) && 'yes' == $settings->timeline[ $i ]->timeline_box_shadow ),
					'keys'				=> array(
						'horizontal'		=> 'box_shadow_h',
						'vertical'			=> 'box_shadow_v',
						'blur'				=> 'box_shadow_blur',
						'spread'			=> 'box_shadow_spread'
					)
				),
				'timeline_box_shadow_color'	=> array(
					'type'				=> 'shadow_color',
					'condition'			=> ( isset( $settings->timeline[ $i ]->timeline_box_shadow ) && 'yes' == $settings->timeline[ $i ]->timeline_box_shadow ),
					'opacity'			=> isset( $settings->timeline[ $i ]->timeline_box_shadow_opacity ) ? $settings->timeline[ $i ]->timeline_box_shadow_opacity : 1
				),
			), 'timeline_box_border' );

			// Handle old button text & hover dual color field.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_dual_color_field( $settings->timeline[ $i ], 'timeline_button_color', array(
				'primary'	=> 'timeline_button_text_color',
				'secondary'	=> 'timeline_button_text_hover'
			) );

			// Handle old button text & hover dual color field.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_dual_color_field( $settings->timeline[ $i ], 'timeline_button_background', array(
				'primary'	=> 'timeline_button_background_color',
				'secondary'	=> 'timeline_button_background_hover'
			) );

			// Handle old button border and radius fields.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_border_field( $settings->timeline[ $i ], array(
				'timeline_button_border_type'	=> array(
					'type'				=> 'style'
				),
				'timeline_button_border_width'	=> array(
					'type'				=> 'width'
				),
				'timeline_button_border_color'	=> array(
					'type'				=> 'color'
				),
				'timeline_button_border_radius'	=> array(
					'type'				=> 'radius'
				),
			), 'timeline_button_border' );

			// Handle button old padding field.
			$settings->timeline[ $i ] = PP_Module_Fields::handle_multitext_field( $settings->timeline[ $i ], 'button_padding', 'padding', 'button_padding', array(
				'top'		=> 'button_top_padding',
				'bottom'	=> 'button_bottom_padding',
				'left'		=> 'button_left_padding',
				'right'		=> 'button_right_padding'
			) );
		
		}

		// Handle title old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'title_padding', 'padding', 'title_padding' );

		// Handle description old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'content_padding', 'padding', 'content_padding' );

		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'title_font'	=> array(
				'type'			=> 'font'
			),
			'title_font_size'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'title_font_size_desktop',
					'tablet'		=> 'title_font_size_tablet',
					'mobile'		=> 'title_font_size_mobile'
				)
			),
			'title_line_height'	=> array(
				'type'			=> 'line_height',
				'keys'			=> array(
					'desktop'		=> 'title_line_height_desktop',
					'tablet'		=> 'title_line_height_tablet',
					'mobile'		=> 'title_line_height_mobile'
				)
			),
		), 'title_typography' );

		// Handle text's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'text_font'	=> array(
				'type'			=> 'font'
			),
			'text_font_size'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'text_font_size_desktop',
					'tablet'		=> 'text_font_size_tablet',
					'mobile'		=> 'text_font_size_mobile'
				)
			),
			'text_line_height'	=> array(
				'type'			=> 'line_height',
				'keys'			=> array(
					'desktop'		=> 'text_line_height_desktop',
					'tablet'		=> 'text_line_height_tablet',
					'mobile'		=> 'text_line_height_mobile'
				)
			),
		), 'text_typography' );

		// Handle button's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'button_font'	=> array(
				'type'			=> 'font'
			),
			'button_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'button_typography' );

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPTimelineModule', array(
	'general'      => array( // Tab
		'title'         => __('Content', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'general'      => array(
                'title'     => '',
                'fields'    => array(
                    'timeline'  => array(
                        'type'  => 'form',
                        'label' => __('Item', 'bb-powerpack'),
                        'form'  => 'pp_timeline_form',
                        'preview_text'  => 'title',
                        'multiple'      => true
                    ),
                ),
            ),
		)
	),
    'styles'    => array(
        'title'     => __('Connector', 'bb-powerpack'),
        'sections'  => array(
            'general_setting'   => array(
                'title'     => __('Connector Styling', 'bb-powerpack'),
                'fields'    => array(
                    'timeline_line_style'    => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Connector Type', 'bb-powerpack'),
                        'default'   => 'solid',
                        'options'   => array(
                            'solid' => __('Solid', 'bb-powerpack'),
                            'dashed' => __('Dashed', 'bb-powerpack'),
                            'dotted' => __('Dotted', 'bb-powerpack'),
                        ),
                    ),
                    'timeline_line_width'   => array(
                        'type'      => 'unit',
                        'label'     => __('Width', 'bb-powerpack'),
                        'default'   => 1,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'   => array(
                            'type'  	=> 'css',
                            'selector'  => '.pp-timeline-content-wrapper:before',
                            'property'  => 'border-right-width',
                            'unit'      => 'px'
                        ),
                    ),
                    'timeline_line_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
                        'show_reset'    => true,
						'default'   => '000000',
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'rules' => array(
                                array(
                                    'selector'  => '.pp-timeline-content-wrapper:before',
                                    'property'  => 'border-right-color',
                                ),
                                array(
                                    'selector'  => '.pp-timeline-content-wrapper:after',
                                    'property'  => 'border-color',
                                ),
                            )
                        ),
                    ),
                ),
            ),
        ),
    ),
    'box'       => array(
        'title' => __('Box', 'bb-powerpack'),
        'sections'  => array(
            'title' => array(
                'title' => __('Title', 'bb-powerpack'),
                'fields'    => array(
                    'title_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '20',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-title',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                ),
            ),
            'content' => array(
                'title' => __('Content', 'bb-powerpack'),
                'fields'    => array(
					'content_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '20',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-text-wrapper',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                ),
            ),
            'icon'  => array(
                'title' => __('Icon', 'bb-powerpack'),
                'fields'    => array(
                    'icon_size' => array(
                        'type'  	=> 'unit',
                        'label' 	=> __('Size', 'bb-powerpack'),
                        'default'   => 20,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
						'responsive'	=> true,
                        'preview'   => array(
                            'type'  	=> 'css',
                            'selector'  => '.pp-timeline-icon .pp-icon',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        ),
                    ),
                    'icon_padding'  => array(
                        'type'      => 'unit',
                        'label'     => __('Padding', 'bb-powerpack'),
                        'default'   => 15,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
						'responsive'	=> true,
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-timeline-icon',
                            'property'  => 'padding',
                            'unit'      => 'px'
                        ),
                    ),
                ),
            ),
        ),
    ),
    'typography'    => array(
        'title'     => __('Typography', 'bb-powerpack'),
        'sections'  => array(
            'title_typography'    => array(
                'title'     => __('Title', 'bb-powerpack'),
                'fields'  => array(
					'title_html_tag'      => array(
                        'type'          => 'select',
                        'label'         => __('HTML Tag', 'bb-powerpack'),
                        'default'       => 'p',
                        'options'       => array(
                            'h1'            => 'h1',
                            'h2'            => 'h2',
                            'h3'            => 'h3',
                            'h4'            => 'h4',
                            'h5'            => 'h5',
                            'p'            	=> 'p',
                            'div'           => 'div',
                        )
                    ),
					'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-title',
						),
					),
                ),
            ),
            'text_typography'   => array(
                'title'     => __('Text', 'bb-powerpack'),
                'fields'    => array(
					'text_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-text p',
						),
					),
                ),
            ),
            'button_typography' => array(
                'title'     => __('Button', 'bb-powerpack'),
                'fields'    => array(
					'button_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content a',
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
FLBuilder::register_settings_form('pp_timeline_form', array(
	'title' => __('Add Item', 'bb-powerpack'),
	'tabs'  => array(
		'general'      => array( // Tab
			'title'         => __('General', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
                'title'          => array(
                    'title'      => __('Title', 'bb-powerpack'),
                    'fields'     => array(
                        'title'     => array(
                            'type'          => 'text',
                            'label'         => '',
                            'connections'   => array( 'string', 'html' ),
                        ),
                    ),
                ),
                'content'       => array( // Section
					'title'         => __('Content', 'bb-powerpack'), // Section Title
					'fields'        => array( // Section Fields
						'content'          => array(
							'type'          => 'editor',
							'label'         => '',
                            'connections'   => array( 'string', 'html', 'url' ),
						)
					)
				),
                'button'    => array(
                    'title' => __('Button', 'bb-powerpack'),
                    'fields'    => array(
                        'button_text'   => array(
                            'type'  => 'text',
                            'label' => __('Text', 'bb-powerpack'),
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
        'icon_tab'  => array(
            'title' => __('Icon', 'bb-powerpack'),
            'sections'  => array(
                'timeline_icon'  => array(
                    'title'     => '',
                    'fields'    => array(
                        'timeline_icon'     => array(
                            'type'  => 'icon',
                            'label' => __('Icon', 'bb-powerpack'),
                            'show_remove'   => true
                        ),
                    ),
                ),
                'icon_styling'  => array(
                    'title' => '',
                    'fields'    => array(
						'icon_text_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Text Color', 'bb-powerpack' ),
							'default'		=> '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'icon_background_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Background Color', 'bb-powerpack' ),
							'default'		=> 'ffffff',
							'show_alpha'	=> true,
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'icon_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-powerpack' ),
							'responsive'	=> true,
						),
                    )
                ),
            ),
        ),
        'box_tab'   => array(
            'title' => __('Title + Box', 'bb-powerpack'),
            'sections'  => array(
                'title_styling'   => array(
                    'title' => __('Title Styling', 'bb-powerpack'),
                    'fields'    => array(
						'title_text_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Text Color', 'bb-powerpack' ),
							'default'		=> '000000',
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'title_background_color'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Background Color', 'bb-powerpack' ),
							'default'		=> 'ffffff',
							'show_alpha'	=> true,
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'title_border'	=> array(
							'type'			=> 'unit',
							'label'			=> __('Border Width', 'bb-powerpack'),
							'default'		=> 0,
							'units'			=> array( 'px' ),
							'slider'		=> true
						),
						'title_border_color' => array(
							'type'				=> 'color',
							'label'				=> __('Border Color', 'bb-powerpack'),
							'show_reset'		=> true,
							'connections'	=> array('color'),
						)
                    ),
                ),
                'text_styling'  => array(
                    'title'     => __('Content Styling', 'bb-powerpack'),
                    'fields'    => array(
                        'text_color'    => array(
                            'type'      => 'color',
                            'label'     => __('Text Color', 'bb-powerpack'),
							'show_reset'    => true,
							'connections'	=> array('color'),
                        ),
                    ),
                ),
                'box_styling'   => array(
                    'title' => __('Box Styling', 'bb-powerpack'),
                    'fields'    => array(
                        'timeline_box_background'   => array(
                            'type'  => 'color',
                            'label' => __('Background Color', 'bb-powerpack'),
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
                        ),
                        'timeline_box_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-powerpack' ),
							'responsive'	=> true,
						),
                    ),
                ),
            ),
        ),
        'button_tab'    => array(
            'title'     => __('Button', 'bb-powerpack'),
            'sections'  => array(
                'button_styling'   => array(
                    'title' => '',
                    'fields'    => array(
						'timeline_button_text_color'	=> array(
							'type'		=> 'color',
							'label' => __('Text Color', 'bb-powerpack'),
							'default'	=> '333333',
							'connections'	=> array('color'),
						),
						'timeline_button_text_hover'	=> array(
							'type'		=> 'color',
							'label' => __('Text Hover Color', 'bb-powerpack'),
							'default'	=> 'dddddd',
							'connections'	=> array('color'),
						),
						'timeline_button_background_color'	=> array(
							'type'		=> 'color',
							'label' => __('Background Color', 'bb-powerpack'),
							'default'	=> 'dddddd',
							'show_alpha'	=> true,
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
						'timeline_button_background_hover'	=> array(
							'type'		=> 'color',
							'label' => __('Background Hover Color', 'bb-powerpack'),
							'default'	=> '333333',
							'show_alpha'	=> true,
							'show_reset'	=> true,
							'connections'	=> array('color'),
						),
                        'timeline_button_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-powerpack' ),
							'responsive'	=> true,
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
            ),
        ),
	)
));
