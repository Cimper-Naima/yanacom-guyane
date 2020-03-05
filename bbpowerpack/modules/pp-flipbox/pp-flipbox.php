<?php

/**
 * @class PPFlipBoxModule
 */
class PPFlipBoxModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Flip Box', 'bb-powerpack'),
            'description'   => __('Addon to display flip box.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-flipbox/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-flipbox/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
		$this->add_css( BB_POWERPACK()->fa_css );
    }

	public function filter_settings( $settings, $helper )
	{
		// Handle front title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'front_title_font'	=> array(
				'type'			=> 'font'
			),
			'front_title_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'front_title_typography' );

		// Handle front text's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'front_text_font'	=> array(
				'type'			=> 'font'
			),
			'front_text_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'front_text_typography' );

		// Handle old link, link_target fields.
		$settings = PP_Module_Fields::handle_link_field( $settings, array(
			'link'			=> array(
				'type'			=> 'link'
			),
			'link_target'	=> array(
				'type'			=> 'target'
			),
		), 'link' );

		// Handle link old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'link_padding', 'padding', 'link_padding' );

		// Handle back title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'back_title_font'	=> array(
				'type'			=> 'font'
			),
			'back_title_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'back_title_typography' );

		// Handle back text's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'back_text_font'	=> array(
				'type'			=> 'font'
			),
			'back_text_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'back_text_typography' );
		
		// Handle link text's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'link_font'	=> array(
				'type'			=> 'font'
			),
			'link_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'link_typography' );

		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPFlipBoxModule', array(
	'general'      => array( // Tab
		'title'         => __('General', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'type'      => array(
                'title'     => __('Icon Type', 'bb-powerpack'),
                'fields'    => array(
                    'icon_type'      => array(
                        'type'      => 'select',
                        'label'     => __('Type', 'bb-powerpack'),
                        'default'   => 'icon',
                        'options'   => array(
                            'none'      => __('None', 'bb-powerpack'),
                            'icon'      => __('Icon', 'bb-powerpack'),
                            'image'      => __('Image', 'bb-powerpack'),
                        ),
                        'toggle'        => array(
                            'icon'      => array(
                                'fields'        => array('icon_select', 'icon_font_size', 'icon_width'),
								'sections'		=> array('icon_colors'),
                                'tabs'      => array('icon_styles')
                            ),
                            'image'      => array(
                                'fields'        => array('image_select', 'image_width'),
                                'tabs'      => array('icon_styles')
                            ),
                        ),
                    ),
                    'icon_select'       => array(
                        'type'      => 'icon',
                        'label'     => __('Icon', 'bb-powerpack'),
                    ),
                    'image_select'       => array(
                        'type'      => 'photo',
                        'label'     => __('Image Icon', 'bb-powerpack'),
                        'connections'   => array( 'photo' ),
                    ),
                ),
            ),
            'flip_type'     => array(
                'title'     => __('Flip Type', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'flip_type'     => array(
                        'type'      => 'select',
                        'label'     => __('Flip Type', 'bb-powerpack'),
                        'default'     => 'left',
                        'options'   => array(
                            'left'  => __('Flip horizontally from left', 'bb-powerpack'),
                            'right'  => __('Flip horizontally from right', 'bb-powerpack'),
                            'top'  => __('Flip vertically from top', 'bb-powerpack'),
                            'bottom'  => __('Flip vertically from bottom', 'bb-powerpack'),
                        ),
                    ),
                    'flip_duration'     => array(
                        'type'      => 'text',
                        'label'     => __('Flip Duration', 'bb-powerpack'),
                        'size'      => '5',
                        'maxlength' => '4',
                        'description'   => __('ms', 'bb-powerpack'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-flipbox',
                            'property'  => 'transition-duration'
                        )
                    ),
                ),
            ),
            'box_setting'     => array(
                'title'     => __('Box Styling', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'box_border_style'     => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Border Style', 'bb-powerpack'),
                        'default'     => 'none',
                        'options'   => array(
                            'none'  => __('None', 'bb-powerpack'),
                            'solid'  => __('Solid', 'bb-powerpack'),
                            'dashed' => __('Dashed', 'bb-powerpack'),
                            'dotted'  => __('Dotted', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'solid'     => array(
                                'fields'    => array('box_border_width')
                            ),
                            'dashed'     => array(
                                'fields'    => array('box_border_width')
                            ),
                            'dotted'     => array(
                                'fields'    => array('box_border_width')
                            )
                        ),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-flipbox',
                            'property'  => 'border-style'
                        ),
                    ),
                    'box_border_width'     => array(
                        'type'      => 'unit',
                        'label'     => __('Border Width', 'bb-powerpack'),
                        'default'   => 1,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-flipbox',
                            'property'  => 'border-width',
                            'unit'      => 'px'
                        ),
                    ),
                    'top_padding'   => array(
                        'type'      => 'unit',
                        'label'     => __('Top/Bottom Padding', 'bb-powerpack'),
                        'default'   => '20',
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'   => array(
                            'type'  => 'css',
                            'rules'     => array(
                                array(
                                    'selector'  => '.pp-flipbox',
                                    'property'  => 'padding-top',
                                    'unit'      => 'px'
                                ),
                                array(
                                    'selector'  => '.pp-flipbox',
                                    'property'  => 'padding-bottom',
                                    'unit'      => 'px'
                                ),
                            ),
                        ),
                    ),
                    'side_padding'   => array(
                        'type'      => 'unit',
                        'label'     => __('Left/Right Padding', 'bb-powerpack'),
                        'default'   => '20',
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'   => array(
                            'type'  => 'css',
                            'rules'     => array(
                                array(
                                    'selector'  => '.pp-flipbox',
                                    'property'  => 'padding-left',
                                    'unit'      => 'px'
                                ),
                                array(
                                    'selector'  => '.pp-flipbox',
                                    'property'  => 'padding-right',
                                    'unit'      => 'px'
                                ),
                            ),
                        ),
                    ),
                    'box_height'    => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Box Height', 'bb-powerpack'),
                        'default'       => 'auto',
                        'options'       => array(
                            'auto'          => __('Auto', 'bb-powerpack'),
                            'custom'        => __('Custom', 'bb-powerpack')
                        ),
                        'toggle'        => array(
                            'custom'        => array(
                                'fields'        => array('box_height_custom')
                            )
                        )
                    ),
                    'box_height_custom' => array(
                        'type'              => 'unit',
                        'label'             => __('Box Height Custom', 'bb-powerpack'),
                        'default'           => '',
                        'units'       		=> array( 'px' ),
						'slider'			=> true,
                    )
                ),
            ),
		)
	),
    'content_front'       => array(
        'title'     => __('Front Content', 'bb-powerpack'),
        'sections'  => array(
            'content_front'     => array(
                'title'             => __('Front Content', 'bb-powerpack'),
                'fields'            => array(
                    'front_title'       => array(
                        'label'             => __('Title', 'bb-powerpack'),
                        'type'              => 'text',
                        'default'           => __('Front Title', 'bb-powerpack'),
                        'connections'       => array( 'string', 'html', 'url' ),
                        'preview'           => array(
                            'type'              => 'text',
                            'selector'          => '.pp-flipbox-front .pp-flipbox-title h3'
                        )
                    ),
                    'front_description'     => array(
                        'type'                  => 'editor',
                        'label'                 => '',
                        'default'               => __('Front Description', 'bb-powerpack'),
                        'connections'           => array( 'string', 'html', 'url' ),
                        'preview'               => array(
                            'type'                  => 'text',
                            'selector'              => '.pp-flipbox-front .pp-flipbox-description'
                        )
                    ),
                ),
            ),
            'front_style'     => array(
                'title'     => __('Box Style', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'front_background'    => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-front',
                            'property'      => 'background',
                        )
					),
                    'front_border_color'    => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-front',
                            'property'      => 'border-color',
                        )
					),
                )
            ),
            'front_typography'      => array(
                'title'                 => __('Typography', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'                => array(
                    'front_title_tag'   => array(
                        'type'              => 'select',
                        'label'             => __('HTML Tag', 'bb-powerpack'),
                        'default'           => 'h3',
                        'options'           => array(
                            'h1'                => 'H1',
                            'h2'                => 'H2',
                            'h3'                => 'H3',
                            'h4'                => 'H4',
                            'h5'                => 'H5',
                            'h6'                => 'H6',
                        )
                    ),
					'front_title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Title Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-flipbox-front .pp-flipbox-title h3',
						),
					),
                    'front_title_color' => array(
						'type'          => 'color',
						'label'         => __('Title Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-front .pp-flipbox-title h3',
                            'property'      => 'color',
                        )
					),
					'front_title_margin'       => array(
						'type'              => 'pp-multitext',
						'label'             => __('Title Margin', 'bb-powerpack'),
						'description'       => 'px',
						'default'           => array(
							'top'               => 0,
							'bottom'            => 0,
						),
						'options'           => array(
							'top'               => array(
								'placeholder'       => __('Top', 'bb-powerpack'),
								'tooltip'           => __('Top', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-up',
								'preview'           => array(
									'selector'          => '.pp-flipbox-front .pp-flipbox-title h3',
									'property'          => 'margin-top',
									'unit'              => 'px'
								),
							),
							'bottom'            => array(
								'placeholder'       => __('Bottom', 'bb-powerpack'),
								'tooltip'           => __('Bottom', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-down',
								'preview'           => array(
									'selector'          => '.pp-flipbox-front .pp-flipbox-title h3',
									'property'          => 'margin-bottom',
									'unit'              => 'px'
								),
							),
						)
					),
                    'front_text_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Description Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-flipbox-front .pp-flipbox-description',
						),
					),
                    'front_text_color'    => array(
						'type'          => 'color',
						'label'         => __('Description Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-front .pp-flipbox-description',
                            'property'      => 'color',
                        )
					),
					'front_text_margin'       => array(
						'type'              => 'pp-multitext',
						'label'             => __('Description Margin', 'bb-powerpack'),
						'description'       => 'px',
						'default'           => array(
							'top'               => 0,
							'bottom'            => 0,
						),
						'options'           => array(
							'top'               => array(
								'placeholder'       => __('Top', 'bb-powerpack'),
								'tooltip'           => __('Top', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-up',
								'preview'           => array(
									'selector'          => '.pp-flipbox-front .pp-flipbox-description',
									'property'          => 'margin-top',
									'unit'              => 'px'
								),
							),
							'bottom'            => array(
								'placeholder'       => __('Bottom', 'bb-powerpack'),
								'tooltip'           => __('Bottom', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-down',
								'preview'           => array(
									'selector'          => '.pp-flipbox-front .pp-flipbox-description',
									'property'          => 'margin-bottom',
									'unit'              => 'px'
								),
							),
						)
					),
                ),
            )

        ),
    ),
    'content_back'      => array( // Tab
		'title'         => __('Back Content', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'content_back'     => array(
                'title'     => __('Back Content', 'bb-powerpack'),
                'fields'    => array(
                    'back_title'     => array(
                        'label'     => __('Title', 'bb-powerpack'),
                        'type'      => 'text',
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'       => array(
                            'type'          => 'text',
                            'selector'      => '.pp-flipbox-back .pp-flipbox-title h3'
                        )
                    ),
                    'back_description'     => array(
                        'type'      => 'editor',
                        'label'     => '',
                        'default'     => '',
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'       => array(
                            'type'          => 'text',
                            'selector'      => '.pp-flipbox-back .pp-flipbox-description'
                        )
                    ),
                ),
            ),
            'link_type'     => array(
                'title'     => __('Link', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'link_type'     => array(
                        'type'      => 'select',
                        'label'     => __('Link Type', 'bb-powerpack'),
                        'default'     => 'none',
                        'options'   => array(
                            'none'  	=> __('None', 'bb-powerpack'),
                            'custom'  	=> __('Button', 'bb-powerpack'),
                            'box'  		=> __('Box', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'custom'     => array(
                                'fields'    => array('link_text', 'link_color', 'link_color_hover', 'link_background', 'link_background_hover', 'link_font', 'link_font_size', 'link', 'link_target', 'link_padding')
                            ),
							'box'		=> array(
								'fields'	=> array('link', 'link_target')
							)
                        )
                    ),
                    'link_text'     => array(
                        'type'      => 'text',
                        'label'         => __('Text', 'bb-powerpack'),
                        'default'       => __('Know More', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'       => array(
                            'type'      => 'text',
                            'selector'  => '.pp-more-link'
                        ),
                    ),
                    'link'  => array(
						'type'          => 'link',
						'label'         => __('Link', 'bb-powerpack'),
						'placeholder'   => 'http://www.example.com',
						'show_target'	=> true,
						'connections'   => array( 'url' ),
						'preview'       => array(
							'type'          => 'none'
						)
					),
                    'link_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Text Color', 'bb-powerpack'),
                        'default'   => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-more-link',
                            'property'  => 'color'
                        ),
                    ),
                    'link_color_hover'    => array(
                        'type'      => 'color',
                        'label'     => __('Text Hover Color', 'bb-powerpack'),
                        'default'   => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-more-link:hover',
                            'property'  => 'color'
                        ),
                    ),
                    'link_background'    => array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-powerpack'),
                        'default'   => '',
                        'show_reset'    => true,
						'show_alpa'		=> true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-more-link',
                            'property'  => 'background'
                        ),
                    ),
                    'link_background_hover'    => array(
                        'type'      => 'color',
                        'label'     => __('Background Color Hover', 'bb-powerpack'),
                        'default'   => '',
                        'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-more-link:hover',
                            'property'  => 'background'
                        ),
                    ),
					'link_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-more-link',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                ),
            ),
            'back_style'     => array(
                'title'     => __('Box Style', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'back_background'    => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-back',
                            'property'      => 'background',
                        )
					),
                    'back_border_color'    => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-back',
                            'property'      => 'border-color',
                        )
					),
                )
            ),
            'back_typography'       => array(
                'title'                 => __('Typography', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'                => array(
                    'back_title_tag'   => array(
                        'type'              => 'select',
                        'label'             => __('HTML Tag', 'bb-powerpack'),
                        'default'           => 'h3',
                        'options'           => array(
                            'h1'                => 'H1',
                            'h2'                => 'H2',
                            'h3'                => 'H3',
                            'h4'                => 'H4',
                            'h5'                => 'H5',
                            'h6'                => 'H6',
                        )
                    ),
                   'back_title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Title Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-flipbox-back .pp-flipbox-title h3',
						),
					),
                    'back_title_color'    => array(
						'type'          => 'color',
						'label'         => __('Title Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-back .pp-flipbox-title h3',
                            'property'      => 'color',
                        )
					),
					'back_title_margin'       => array(
						'type'              => 'pp-multitext',
						'label'             => __('Title Margin', 'bb-powerpack'),
						'description'       => 'px',
						'default'           => array(
							'top'               => 0,
							'bottom'            => 0,
						),
						'options'           => array(
							'top'               => array(
								'placeholder'       => __('Top', 'bb-powerpack'),
								'tooltip'           => __('Top', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-up',
								'preview'           => array(
									'selector'          => '.pp-flipbox-back .pp-flipbox-title h3',
									'property'          => 'margin-top',
									'unit'              => 'px'
								),
							),
							'bottom'            => array(
								'placeholder'       => __('Bottom', 'bb-powerpack'),
								'tooltip'           => __('Bottom', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-down',
								'preview'           => array(
									'selector'          => '.pp-flipbox-back .pp-flipbox-title h3',
									'property'          => 'margin-bottom',
									'unit'              => 'px'
								),
							),
						)
					),
                    'back_text_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Description Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-flipbox-back .pp-flipbox-description',
						),
					),
                    'back_text_color'    => array(
						'type'          => 'color',
						'label'         => __('Description Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-back .pp-flipbox-description',
                            'property'      => 'color',
                        )
					),
					'back_text_margin'       => array(
						'type'              => 'pp-multitext',
						'label'             => __('Description Margin', 'bb-powerpack'),
						'description'       => 'px',
						'default'           => array(
							'top'               => 0,
							'bottom'            => 0,
						),
						'options'           => array(
							'top'               => array(
								'placeholder'       => __('Top', 'bb-powerpack'),
								'tooltip'           => __('Top', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-up',
								'preview'           => array(
									'selector'          => '.pp-flipbox-back .pp-flipbox-description',
									'property'          => 'margin-top',
									'unit'              => 'px'
								),
							),
							'bottom'            => array(
								'placeholder'       => __('Bottom', 'bb-powerpack'),
								'tooltip'           => __('Bottom', 'bb-powerpack'),
								'icon'              => 'fa-long-arrow-down',
								'preview'           => array(
									'selector'          => '.pp-flipbox-back .pp-flipbox-description',
									'property'          => 'margin-bottom',
									'unit'              => 'px'
								),
							),
						)
					),
                    'link_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Link Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-more-link',
						),
					),
                ),
            ),
		)
	),
    'icon_styles'   => array(
        'title'     => __('Icon Style', 'bb-powerpack'),
        'sections'  => array(
            'icon_sizes'   => array(
                'title'     => __('Sizes', 'bb-powerpack'),
                'fields'    => array(
                    'icon_font_size'    => array(
						'type'          => 'unit',
						'label'         => __('Icon Size', 'bb-powerpack'),
						'units'   		=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.pp-flipbox-icon-inner span.pp-icon',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-icon-inner span.pp-icon:before',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                        )
					),
                    'icon_width'    => array(
                        'type'          => 'unit',
                        'default'       => '0',
						'label'         => __('Icon Box Size', 'bb-powerpack'),
                        'units'   		=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'           => array(
                                array(
                                    'selector'      => '.pp-flipbox-icon-inner',
                                    'property'     => 'width',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-icon-inner',
                                    'property'     => 'height',
                                    'unit'          => 'px'
                                ),
                            ),
                        )
                    ),
                    'image_width'    => array(
						'type'          => 'unit',
                        'default'     	=> '100',
						'label'         => __('Icon Size', 'bb-powerpack'),
						'units'   		=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'           => array(
                                array(
                                    'selector'      => '.pp-flipbox-image img',
                                    'property'     => 'width',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-image img',
                                    'property'     => 'height',
                                    'unit'          => 'px'
                                ),
                            ),
                        )
					),
                )
            ),
            'icon_colors'   => array(
                'title'         => __('Colors', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'        => array(
                    'icon_color'    => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-icon-inner',
                            'property'      => 'color',
                        )
					),
                    'icon_color_hover'    => array(
						'type'          => 'color',
						'label'         => __('Color Hover', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-icon:hover-inner',
                            'property'      => 'color',
                        )
					),
                    'icon_background'    => array(
						'type'          => 'color',
						'label'         => __('Background', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-icon-inner',
                            'property'      => 'background',
                        )
					),
                    'icon_background_hover'    => array(
						'type'          => 'color',
						'label'         => __('Background Hover', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-flipbox-icon-inner:hover',
                            'property'      => 'background',
                        )
					),
                )
            ),
            'icon_border'   => array(
                'title'         => __('Border', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'        => array(
                    'show_border'   => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Show Border', 'bb-powerpack'),
                        'default'   => 'no',
                        'options'   => array(
                            'no'    => __('No', 'bb-powerpack'),
                            'yes'    => __('Yes', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    => array('icon_border_width', 'icon_border_color', 'icon_border_color_hover', 'icon_box_size')
                            )
                        ),
                    ),
                    'icon_border_width'    => array(
						'type'          => 'unit',
						'label'         => __('Border Width', 'bb-powerpack'),
						'default'       => 1,
                        'units'   		=> array( 'px' ),
						'slider'		=> true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.pp-flipbox-icon',
                                    'property'      => 'border-width',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-image img',
                                    'property'      => 'border-width',
                                    'unit'          => 'px'
                                ),
                            ),
                        )
					),
                    'icon_border_color'    => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.pp-flipbox-icon',
                                    'property'      => 'border-color',
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-image img',
                                    'property'      => 'border-color',
                                ),
                            ),
                        )
					),
                    'icon_border_color_hover'    => array(
						'type'          => 'color',
						'label'         => __('Border Color Hover', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.pp-flipbox-icon:hover',
                                    'property'      => 'border-color',
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-image img:hover',
                                    'property'      => 'border-color',
                                ),
                            ),
                        )
					),
                    'icon_box_size'     => array(
                        'type'          => 'unit',
                        'default'     	=> '0',
                        'label'         => __('Inside Spacing', 'bb-powerpack'),
						'units'		   	=> array( 'px' ),
						'slider'		=> true,
                        'help'      	=> __('The space between icon and the border', 'bb-powerpack'),
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'           => array(
                                array(
                                    'selector'      => '.pp-flipbox-image img',
                                    'property'     => 'padding',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-icon',
                                    'property'     => 'padding',
                                    'unit'          => 'px'
                                ),
                            ),
                        )
                    ),
                    'icon_border_radius'    => array(
						'type'          => 'unit',
						'label'         => __('Round Corners', 'bb-powerpack'),
						'default'       => 0,
                        'units'   		=> array( 'px' ),
						'slider'		=> true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.pp-flipbox-icon',
                                    'property'      => 'border-radius',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-icon-inner',
                                    'property'      => 'border-radius',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-flipbox-image img',
                                    'property'      => 'border-radius',
                                    'unit'          => 'px'
                                ),
                            ),
                        )
					),
                ),
            ),
        ),
    )
));
