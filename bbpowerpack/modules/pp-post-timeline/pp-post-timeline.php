<?php

/**
 * @class PPPostTimelineModule
 */
class PPPostTimelineModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          	=> __('Post Timeline', 'bb-powerpack'),
            'description'   	=> __('Display posts in timeline format.', 'bb-powerpack'),
            'group'         	=> pp_get_modules_group(),
            'category'			=> pp_get_modules_cat( 'creative' ),
            'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-post-timeline/',
            'url'           	=> BB_POWERPACK_URL . 'modules/pp-post-timeline/',
            'editor_export' 	=> true, // Defaults to true and can be omitted.
            'enabled'       	=> true, // Defaults to true and can be omitted.
			'partial_refresh'   => true,
        ));

		$this->add_css( BB_POWERPACK()->fa_css );
		$this->add_js( 'imagesloaded' );
		$this->add_css( 'jquery-slick' );
		$this->add_css( 'jquery-slick-theme' );
		$this->add_js( 'jquery-slick' );

		add_action( 'wp_ajax_get_post_tax', array( $this, 'pp_get_post_taxonomies' ) );
		add_action( 'wp_ajax_nopriv_get_post_tax', array( $this, 'pp_get_post_taxonomies' ) );
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'title_font'	=> array(
				'type'			=> 'font'
			),
			'title_font_size'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'title_font_size',
					'tablet'		=> 'title_font_size_medium',
					'mobile'		=> 'title_font_size_responsive'
				)
			),
			'title_line_height'	=> array(
				'type'			=> 'line_height',
				'keys'			=> array(
					'desktop'		=> 'title_line_height',
					'tablet'		=> 'title_line_height_medium',
					'mobile'		=> 'title_line_height_responsive'
				)
			),
			'title_text_transform'		=> array(
				'type'			=> 'text_transform'
			)
		), 'title_typography' ); 

		// Handle meta's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'meta_font'	=> array(
				'type'			=> 'font'
			),
			'meta_font_size'	=> array(
				'type'			=> 'font_size',
			),
			'meta_line_height'	=> array(
				'type'			=> 'line_height',
			),
			'meta_text_transform'		=> array(
				'type'			=> 'text_transform'
			)
		), 'meta_typography' );

		// Handle text's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'text_font'	=> array(
				'type'			=> 'font'
			),
			'text_font_size'	=> array(
				'type'			=> 'font_size',
			),
			'text_line_height'	=> array(
				'type'			=> 'line_height',
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
			'button_text_transform'		=> array(
				'type'			=> 'text_transform'
			)
		), 'button_typography' );

		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'post_timeline_border_type'	=> array(
				'type'				=> 'style'
			),
			'post_timeline_border_width'	=> array(
				'type'				=> 'width'
			),
			'post_timeline_border_color'	=> array(
				'type'				=> 'color'
			),
			'post_timeline_border_radius'	=> array(
				'type'				=> 'radius'
			),
			'box_shadow_options'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->post_timeline_box_shadow ) && 'yes' == $settings->post_timeline_box_shadow ),
				'keys'				=> array(
					'horizontal'		=> 'box_shadow_h',
					'vertical'			=> 'box_shadow_v',
					'blur'				=> 'box_shadow_blur',
					'spread'			=> 'box_shadow_spread'
				)
			),
			'post_timeline_box_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->post_timeline_box_shadow ) && 'yes' == $settings->post_timeline_box_shadow ),
				'opacity'			=> isset( $settings->post_timeline_box_shadow_opacity ) ? $settings->post_timeline_box_shadow_opacity : 1
			),
		), 'post_timeline_border' );

		// Handle old button border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'post_timeline_button_border_type'	=> array(
				'type'				=> 'style'
			),
			'post_timeline_button_border_width'	=> array(
				'type'				=> 'width'
			),
			'post_timeline_button_border_color'	=> array(
				'type'				=> 'color'
			),
			'post_timeline_button_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'post_timeline_button_border' );

		// Handle old arrow border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'arrow_border_style'	=> array(
				'type'				=> 'style'
			),
			'arrow_border_width'	=> array(
				'type'				=> 'width'
			),
			'arrow_border_color'	=> array(
				'type'				=> 'color'
			),
			'arrow_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'arrow_border' );

		return $settings;
	}
	
	/**
     * Get taxonomies
     */
    public function pp_get_post_taxonomies() {
        $options = array( 'none' => __('None', 'bb-powerpack') );
		$slug = isset( $_POST['post_type_slug'] ) ? $_POST['post_type_slug'] : '';
		$taxonomies = FLBuilderLoop::taxonomies($slug);
		$html = '';
		$html .= '<option value="none">'. __('None', 'bb-powerpack') .'</option>';
		foreach($taxonomies as $tax_slug => $tax) {
			$html .= '<option value="'.$tax_slug.'">'.$tax->label.'</option>';
			$options[$tax_slug] = $tax->label;
		}

        echo $html; die();
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPPostTimelineModule', array(
	'general'      => array( // Tab
		'title'         => __('Structure', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
			'general'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'post_timeline_layout'    => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Layout', 'bb-powerpack'),
                        'default'   => 'vertical',
                        'options'   => array(
                            'horizontal' 	=> __('Horizontal', 'bb-powerpack'),
                            'vertical' 		=> __('Vertical', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'vertical'	=> array(
								'fields'	=> array('post_timeline_ver_direction')
							),
							'horizontal'	=> array(
								'tabs'		=> array('horizontal_timeline'),
								'fields'	=> array('slide_columns')
							)
						)
                    ),
					'post_timeline_ver_direction'    => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Direction', 'bb-powerpack'),
                        'default'   => 'alternate',
                        'options'   => array(
                            'left' 		=> __('Left Side', 'bb-powerpack'),
                            'right' 	=> __('Right Side', 'bb-powerpack'),
                            'alternate' => __('Alternative', 'bb-powerpack'),
                        ),
                    ),
					'slide_columns'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Number of Columns', 'bb-powerpack'),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' 		=> '3',
								'medium' 		=> '',
								'responsive'	=> '',
							),
						),
					),
					'posts_per_page'	=> array(
						'type'				=> 'text',
						'label'				=> __('Number of Posts', 'bb-powerpack'),
						'default'			=> '-1',
						'size'				=> '5',
						'help'				=> __('Use -1 for all posts.', 'bb-powerpack')
					)
				)
			),
			'post_timeline_icon'  => array(
				'title'     => __('Icon Settings'),
				'fields'    => array(
					'post_timeline_icon'     => array(
						'type'  => 'icon',
						'label' => __('Icon', 'bb-powerpack'),
						'show_remove'	=> true,
					),
				),
			),
		)
	),
	'horizontal_timeline'      => array(
		'title'         => __('Slider', 'bb-powerpack'),
		'sections'      => array(
			'slider_general'       => array(
				'title'         => '',
				'fields'        => array(
					'auto_play'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Auto Play', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'          => __('Yes', 'bb-powerpack'),
							'no'         => __('No', 'bb-powerpack'),
						)
					),
					'stop_on_hover'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Stop On Hover', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'          => __('Yes', 'bb-powerpack'),
							'no'         => __('No', 'bb-powerpack'),
						)
					),
					'lazy_load'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Lazy Load', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'          => __('Yes', 'bb-powerpack'),
							'no'         => __('No', 'bb-powerpack'),
						)
					),
					'transition_speed' => array(
						'type'          => 'text',
						'label'         => __('Transition Speed', 'bb-powerpack'),
						'default'       => '300',
						'size'          => '5',
						'description'   => _x( 'ms', 'Value unit for form field of time in seconds. Such as: "5 seconds"', 'bb-powerpack' )
					),
				)
			),
			'controls'       => array(
				'title'         => __('Controls', 'bb-powerpack'),
				'collpased'	=> true,
				'fields'        => array(
					'slider_pagination'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Navigation Dots?', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'       	=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'yes'	=> array(
								'sections'	=> array('dot_style')
							)
						)
					),
					'slider_navigation'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Navigation Arrows?', 'bb-powerpack'),
						'default'       => 'yes',
						'options'       => array(
							'yes'        	=> __('Yes', 'bb-powerpack'),
							'no'            => __('No', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array( 'arrow_style' )
							)
						)
					),
				)
			),
			'arrow_style'   => array( // Section
                'title' => __('Navigation Arrow', 'bb-powerpack'), // Section Title
				'collpased'	=> true,
                'fields' => array( // Section Fields
					'arrow_font_size'   => array(
						'type'          => 'unit',
						'label'         => __('Arrow Size', 'bb-powerpack'),
						'default'       => '15',
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'preview'         => array(
							'type'            => 'css',
							'rules'			=> array(
								array(
									'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow',
									'property'        => 'width',
									'unit'            => 'px'
								),
								array(
									'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow',
									'property'        => 'height',
									'unit'            => 'px'
								),
								array(
									'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow, .pp-post-timeline-slide-navigation span.slick-arrow:before',
									'property'        => 'font-size',
									'unit'            => 'px'
								)
							)
						)
					),
					'arrow_color'       => array(
						'type'      	=> 'color',
                        'label'     	=> __('Arrow Color', 'bb-powerpack'),
						'show_reset' 	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
						'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow, .pp-post-timeline-slide-navigation span.slick-arrow:before',
                            'property'        => 'color',
                        )
					),
					'arrow_hover'       => array(
						'type'      	=> 'color',
                        'label'     	=> __('Arrow Hover Color', 'bb-powerpack'),
						'show_reset' 	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
						'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow:hover, .pp-post-timeline-slide-navigation span.slick-arrow:hover:before',
                            'property'        => 'color',
                        )
					),
                    'arrow_bg_color'       => array(
						'type'      	=> 'color',
                        'label'     	=> __('Background Color', 'bb-powerpack'),
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
						'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow',
                            'property'        => 'background-color',
                        )
					),
                    'arrow_bg_hover'       => array(
						'type'      	=> 'color',
                        'label'     	=> __('Background Hover Color', 'bb-powerpack'),
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
						'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-post-timeline-slide-navigation span.slick-arrow:hover',
                            'property'        => 'background-color',
                        )
					),
                    'arrow_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-post-timeline-slide-navigation span.slick-arrow',
                            'property'  	=> 'border',
                        ),
					),
					'arrow_horizontal_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Horizontal Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '10',
								'medium' => '',
								'responsive' => '',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-slide-navigation span.slick-arrow',
									'property'		=>	'padding-left',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-slide-navigation span.slick-arrow',
									'property'		=>	'padding-right',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
					'arrow_vertical_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Vertical Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '5',
								'medium' => '',
								'responsive' => '',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-slide-navigation span.slick-arrow',
									'property'		=>	'padding-top',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-slide-navigation span.slick-arrow',
									'property'		=>	'padding-bottom',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
                )
            ),
            'dot_style'   => array( // Section
                'title' => __('Dots', 'bb-powerpack'), // Section Title
				'collpased'	=> true,
                'fields' => array( // Section Fields
                    'dot_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => '666666',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
                            'selector'        => '.pp-post-timeline .slick-dots li button:before',
                            'property'        => 'color',
						)
					),
                    'dot_bg_hover'      => array(
						'type'          => 'color',
						'label'         => __('Active Color', 'bb-powerpack'),
						'default'       => '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
                            'type'          => 'css',
                            'selector'        => '.pp-post-timeline .slick-dots li button:hover:before, .pp-post-timeline .slick-dots li.slick-active button:before',
                            'property'        => 'color',
						)
					),
                    'dot_width'   => array(
                        'type'          => 'unit',
                        'label'         => __('Size', 'bb-powerpack'),
                        'default'       => '10',
						'units'			=> array( 'px' ),
                        'slider'        => true,
                        'preview'         => array(
                            'type'            => 'css',
                            'rules'           => array(
                               array(
                                   'selector'        => '.pp-post-timeline .slick-dots li, .pp-post-timeline .slick-dots li button, .pp-post-timeline .slick-dots li button:before',
                                   'property'        => 'width',
                                   'unit'            => 'px'
                               ),
                               array(
                                   'selector'        => '.pp-post-timeline .slick-dots li, .pp-post-timeline .slick-dots li button, .pp-post-timeline .slick-dots li button:before',
                                   'property'        => 'height',
                                   'unit'            => 'px'
                               ),
                               array(
                                   'selector'        => '.pp-post-timeline .slick-dots li button:before',
                                   'property'        => 'font-size',
                                   'unit'            => 'px'
                               ),
                           ),
                        )
                    ),
                )
            )
		)
	),
	'content'   => array( // Tab
		'title'         => __('Content', 'bb-powerpack'),
		'file'          => BB_POWERPACK_DIR . 'modules/pp-post-timeline/includes/loop-settings.php',
	),
    'styles'    => array(
        'title'     => __('Connector', 'bb-powerpack'),
        'sections'  => array(
            'general_setting'   => array(
                'title'     => __('Connector Style', 'bb-powerpack'),
                'fields'    => array(
                    'post_timeline_line_style'    => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Connector Type', 'bb-powerpack'),
                        'default'   => 'solid',
                        'options'   => array(
                            'solid' => __('Solid', 'bb-powerpack'),
                            'dashed' => __('Dashed', 'bb-powerpack'),
                            'dotted' => __('Dotted', 'bb-powerpack'),
                        ),
						'preview'   	=> array(
                            'type'  	=> 'css',
                            'rules' 	=> array(
                                array(
                                    'selector'  => '.pp-post-timeline-content-wrapper:before',
                                    'property'  => 'border-right-style',
                                ),
                                array(
                                    'selector'  => '.pp-post-timeline.horizontal .pp-post-timeline-content-wrapper:before',
                                    'property'  => 'border-top-style',
                                ),
                            )
                        ),
                    ),
                    'post_timeline_line_width'   => array(
                        'type'      => 'unit',
                        'label'     => __('Width', 'bb-powerpack'),
                        'default'   => 1,
                        'units'			=> array( 'px' ),
                        'slider'        => true,
                        'preview'   => array(
                            'type'  => 'css',
							'rules' 	=> array(
                                array(
                                    'selector'  => '.pp-post-timeline-content-wrapper:before',
                                    'property'  => 'border-right-width',
									'unit'		=> 'px'
                                ),
                                array(
                                    'selector'  => '.pp-post-timeline.horizontal .pp-post-timeline-content-wrapper:before',
                                    'property'  => 'border-top-width',
									'unit'		=> 'px'
                                ),
                            )
                        ),
                    ),
                    'post_timeline_line_color'   => array(
                        'type'      	=> 'color',
                        'label'     	=> __('Color', 'bb-powerpack'),
                        'show_reset'    => true,
						'default'  		=> '000000',
						'connections'	=> array('color'),
                        'preview'   	=> array(
                            'type'  	=> 'css',
                            'rules' 	=> array(
                                array(
                                    'selector'  => '.pp-post-timeline-content-wrapper:before',
                                    'property'  => 'border-right-color',
                                ),
                                array(
                                    'selector'  => '.pp-post-timeline-content-wrapper:after',
                                    'property'  => 'border-color',
                                ),
                                array(
                                    'selector'  => '.pp-post-timeline.horizontal .pp-post-timeline-content-wrapper:before',
                                    'property'  => 'border-top-color',
                                ),
                            )
                        ),
                    ),
                ),
            ),
        ),
    ),
    'style'       => array(
        'title' => __('Style', 'bb-powerpack'),
        'sections'  => array(
			'box_styling'   => array(
				'title' => __('Box', 'bb-powerpack'),
				'fields'    => array(
					'post_timeline_background'   => array(
						'type'  => 'color',
						'label' => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content',
							'property'		=>	'background-color',
						)
					),
					'post_timeline_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content',
                            'property'  	=> 'border',
                        ),
					),
				),
			),
            'header_style' => array(
                'title' => __('Header', 'bb-powerpack'),
				'collpased'	=> true,
                'fields'    => array(
					'title_horizontal_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Horizontal Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '20',
								'medium' => '',
								'responsive' => '',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
									'property'		=>	'padding-left',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
									'property'		=>	'padding-right',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
					'title_vertical_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Vertical Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '20',
								'medium' => '',
								'responsive' => '',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
									'property'		=>	'padding-top',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
									'property'		=>	'padding-bottom',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
					'title_bg_color'    => array(
						'type'  => 'color',
						'label' => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
							'property'		=>	'background-color',
						)
					),
					'title_text_color'    => array(
						'type'  => 'color',
						'label' => __('Text Color', 'bb-powerpack'),
						'show_reset'    => true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title, .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title a',
							'property'		=>	'color',
						)
					),
					'title_border'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Border Width', 'bb-powerpack'),
						'default'		=> 0,
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
							'property'		=>	'border-width',
							'unit'			=> 	'px'
						)
					),
					'title_border_color' => array(
						'type'				=> 'color',
						'label'				=> __('Border Color', 'bb-powerpack'),
						'show_reset'		=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper',
							'property'		=>	'border-color',
						)
					),
					'meta_text_color'    => array(
						'type'  => 'color',
						'label' => __('Meta Text Color', 'bb-powerpack'),
						'show_reset'    => true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta',
							'property'		=>	'color',
						)
					),
					'meta_link_color'    => array(
						'type'  => 'color',
						'label' => __('Meta Link Color', 'bb-powerpack'),
						'show_reset'    => true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta a',
							'property'		=>	'color',
						)
					),
					'meta_link_hover'    => array(
						'type'  => 'color',
						'label' => __('Meta Link Hover Color', 'bb-powerpack'),
						'show_reset'    => true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta a:hover',
							'property'		=>	'color',
						)
					),
                ),
            ),
            'content' => array(
                'title' => __('Content', 'bb-powerpack'),
				'collpased'	=> true,
                'fields'    => array(
					'content_color'    => array(
						'type'      => 'color',
						'label'     => __('Text Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper',
							'property'		=>	'color',
						)
					),
					'content_horizontal_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Horizontal Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '20',
								'medium' => '',
								'responsive' => '',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper',
									'property'		=>	'padding-left',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper',
									'property'		=>	'padding-right',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
					'content_vertical_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Vertical Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '20',
								'medium' => '20',
								'responsive' => '20',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper',
									'property'		=>	'padding-top',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper',
									'property'		=>	'padding-bottom',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
                ),
            ),
            'icon'  => array(
                'title' => __('Icon', 'bb-powerpack'),
				'collpased'	=> true,
                'fields'    => array(
                    'icon_size' => array(
                        'type'  		=> 'unit',
                        'label' 		=> __('Size', 'bb-powerpack'),
                        'default'   	=> 20,
                        'units'			=> array( 'px' ),
                        'slider'        => true,
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-icon .pp-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-timeline-icon',
							'property'		=>	'font-size',
							'unit'			=> 	'px'
						)
                    ),
                    'icon_padding'  => array(
                        'type'      	=> 'unit',
                        'label'     	=> __('Padding', 'bb-powerpack'),
                        'default'   	=> 15,
                        'units'			=> array( 'px' ),
                        'slider'        => true,
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'padding',
							'unit'			=> 	'px'
						)
                    ),
					'icon_bg_color'    => array(
						'type'  => 'color',
						'label' => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'background-color',
						)
					),
					'icon_text_color'    => array(
						'type'  => 'color',
						'label' => __('Icon Color', 'bb-powerpack'),
						'show_reset'    => true,
						'default'       => '',
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'color',
						)
					),
					'icon_border_style'  => array(
						'type'      => 'pp-switch',
						'label'     => __('Border Style', 'bb-powerpack'),
						'default'   => 'none',
						'options'   => array(
							'none'  => __('None', 'bb-powerpack'),
							'solid'  => __('Solid', 'bb-powerpack'),
							'dashed'  => __('Dashed', 'bb-powerpack'),
							'dotted'  => __('Dotted', 'bb-powerpack'),
						),
						'toggle'    => array(
							'solid' => array(
								'fields'    => array('icon_border_color', 'icon_border_width'),
							),
							'dashed' => array(
								'fields'    => array('icon_border_color', 'icon_border_width'),
							),
							'dotted' => array(
								'fields'    => array('icon_border_color', 'icon_border_width'),
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'border-style',
						)
					),
					'icon_border_width' => array(
						'type'  => 'unit',
						'label' => __('Border Width', 'bb-powerpack'),
						'default'   => 0,
						'units'   	=> array( 'px' ),
						'slider'	=> true,
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'border-width',
							'unit'			=> 	'px'
						)
					),
					'icon_border_color' => array(
						'type'      => 'color',
						'label'     => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'border-color'
						)
					),
					'icon_border_radius'    => array(
						'type'      => 'unit',
						'label'     => __('Round Corners', 'bb-powerpack'),
						'default'   => 0,
						'units'   	=> array( 'px' ),
						'slider'	=> true,
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon, .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon',
							'property'		=>	'border-radius',
							'unit'			=> 'px'
						)
					),
                ),
            ),
			'button_style'	=> array(
				'title'		=> __('Button', 'bb-powerpack'),
				'collpased'	=> true,
				'fields'	=> array(
					'post_timeline_button_bg_color'  => array(
						'type'      => 'color',
						'label'     => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
							'property'		=>	'background-color'
						)
					),
					'post_timeline_button_bg_hover'  => array(
						'type'      => 'color',
						'label'     => __('Background Hover Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button:hover',
							'property'		=>	'background-color'
						)
					),
					'post_timeline_button_text_color'  => array(
						'type'      => 'color',
						'label'     => __('Text Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
							'property'		=>	'color'
						)
					),
					'post_timeline_button_text_hover'  => array(
						'type'      => 'color',
						'label'     => __('Text Hover Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button:hover',
							'property'		=>	'color'
						)
					),
					'post_timeline_button_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
                            'property'  	=> 'border',
                        ),
					),
					'button_horizontal_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Horizontal Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '10',
								'medium' => '10',
								'responsive' => '10',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
									'property'		=>	'padding-left',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
									'property'		=>	'padding-right',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
					'button_vertical_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Vertical Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '10',
								'medium' => '10',
								'responsive' => '10',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'rules'			=> array(
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
									'property'		=>	'padding-top',
									'unit'			=> 	'px'
								),
								array(
									'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
									'property'		=>	'padding-bottom',
									'unit'			=> 	'px'
								)
							)
						)
                    ),
					'button_top_margin'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Margin Top', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '0',
								'medium' => '0',
								'responsive' => '0',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-read-more',
							'property'		=>	'margin-top',
							'unit'			=> 	'px'
						)
                    ),
					'button_bottom_margin'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Margin Bottom', 'bb-powerpack'),
						'units'			=> array( 'px' ),
                        'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '0',
								'medium' => '0',
								'responsive' => '0',
							),
						),
						'preview'         => array(
							'type'          => 	'css',
							'selector'      => 	'.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-read-more',
							'property'		=>	'margin-bottom',
							'unit'			=> 	'px'
						)
                    ),
				)
			)
        ),
    ),
    'typography'    => array(
        'title'     => __('Typography', 'bb-powerpack'),
        'sections'  => array(
            'title_typography'    => array(
                'title'     => __('Title', 'bb-powerpack'),
                'fields'  => array(
					'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title',
						),
					),
                ),
            ),
			'meta_typography'    => array(
                'title'     => __('Meta', 'bb-powerpack'),
				'collpased'	=> true,
                'fields'  => array(
					'meta_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta',
						),
					),
                ),
            ),
            'text_typography'   => array(
                'title'     => __('Text', 'bb-powerpack'),
				'collpased'	=> true,
                'fields'    => array(
					'text_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper',
						),
					),
                ),
            ),
            'button_typography' => array(
                'title'     => __('Button', 'bb-powerpack'),
				'collpased'	=> true,
                'fields'    => array(
					'button_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.p.pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button',
						),
					),
                ),
            ),
        ),
    ),
));
