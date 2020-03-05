<?php

/**
 * @class PPLogosGridModule
 */
class PPLogosGridModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'              => __('Logo Grid & Carousel', 'bb-powerpack'),
            'description'       => __('A module for Logo Grid & Carousel.', 'bb-powerpack'),
            'group'             => pp_get_modules_group(),
            'category'		    => pp_get_modules_cat( 'creative' ),
            'dir'               => BB_POWERPACK_DIR . 'modules/pp-logos-grid/',
            'url'               => BB_POWERPACK_URL . 'modules/pp-logos-grid/',
            'editor_export'     => true, // Defaults to true and can be omitted.
            'enabled'           => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

		$this->add_css( BB_POWERPACK()->fa_css );
        $this->add_css('jquery-bxslider');
		$this->add_js('jquery-bxslider');
		$this->add_js('imagesloaded');
    }

	public function filter_settings( $settings, $helper )
	{
		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'logo_grid_title_font'	=> array(
				'type'			=> 'font'
			),
			'logo_grid_title_font_size'	=> array(
				'type'			=> 'font_size',
			),
		), 'title_typography' );

		// Handle old logo grid border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'logo_grid_border_style'	=> array(
				'type'				=> 'style'
			),
			'logo_grid_border_width'	=> array(
				'type'				=> 'width'
			),
			'logo_grid_border_color'	=> array(
				'type'				=> 'color'
			),
			'logo_grid_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'logo_grid_border' );

		// Handle old arrow border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'logo_grid_arrow_border_style'	=> array(
				'type'				=> 'style'
			),
			'logo_grid_arrow_border_width'	=> array(
				'type'				=> 'width'
			),
			'logo_grid_arrow_border_color'	=> array(
				'type'				=> 'color'
			),
			'logo_grid_arrow_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'logo_grid_arrow' );

		if ( isset( $settings->logos_grid_columns_desktop ) ) {
			$settings->logos_grid_columns = $settings->logos_grid_columns_desktop;
			unset( $settings->logos_grid_columns_desktop );
		}
		if ( isset( $settings->logos_grid_columns_tablet ) ) {
			$settings->logos_grid_columns_medium = $settings->logos_grid_columns_tablet;
			unset( $settings->logos_grid_columns_tablet );
		}
		if ( isset( $settings->logos_grid_columns_mobile ) ) {
			$settings->logos_grid_columns_responsive = $settings->logos_grid_columns_mobile;
			unset( $settings->logos_grid_columns_mobile );
		}

		return $settings;
	}

	/**
	 * Returns button link rel based on settings
	 * @since 2.6.10
	 */
	public function get_rel() {
		$rel = array();
		if ( '_blank' == $this->settings->upload_logo_link_target ) {
			$rel[] = 'noopener';
		}
		
		$rel = implode( ' ', $rel );
		if ( $rel ) {
			$rel = ' rel="' . $rel . '" ';
		}
		return $rel;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPLogosGridModule', array(
    'logos_grid_general'       => array( // Tab
        'title'         => __('General', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'logos_content'       => array( // Section
                'title'        => '', // Section Title
                'fields'       => array( // Section Fields
                    'logos_layout'    => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Layout', 'bb-powerpack'),
                        'default'       => 'grid',
                        'options'       => array(
                            'grid'          => __('Grid', 'bb-powerpack'),
                            'carousel'      => __('Carousel', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'grid' => array(
                                'fields'    => array('logos_grid_spacing'),
                                'sections'  => array('logos_grid_count')
                            ),
                            'carousel' => array(
                                'fields'    => array('logo_carousel_width', 'logo_carousel_minimum_grid', 'logo_carousel_maximum_grid', 'logos_carousel_spacing'),
                                'sections'  => array('logo_carousel_arrow_style', 'logo_carousel_dot_style'),
                                'tabs'      => array('logos_slider_tab')
                            )
                        )
                    ),
                    'logos_grid_spacing'   => array(
                        'type'          => 'unit',
                        'label'         => __('Gutter', 'bb-powerpack'),
                        'default'       => 5,
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-logos-content .pp-logo',
                            'property'  => 'margin-right',
                            'unit'      => 'px'
                        )
                    ),
                    'logos_carousel_spacing'   => array(
                        'type'          => 'unit',
                        'label'         => __('Gutter', 'bb-powerpack'),
                        'default'       => '20',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-logos-content .pp-logo',
                            'property'  => 'margin-right',
                            'unit'      => 'px'
                        )
                    ),
                    'upload_logo_show_title'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Logo Title', 'bb-powerpack'),
						'default'       => 'block',
						'options'       => array(
                            'block'             => __('Yes', 'bb-powerpack'),
							'none'             => __('No', 'bb-powerpack'),
						)
					),
                    'upload_logo_link_target'   => array(
                        'type'          => 'select',
                        'label'         => __('Link Target', 'bb-powerpack'),
                        'default'       => '_self',
                        'options'       => array(
                            '_self'         => __('Same Window', 'bb-powerpack'),
                            '_blank'        => __('New Window', 'bb-powerpack')
                        ),
                        'preview'         => array(
                            'type'            => 'none'
                        )
                    ),
                    'equal_height'  => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Equal Height', 'bb-powerpack'),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'           => __('Yes', 'bb-powerpack'),
                            'no'            => __('No', 'bb-powerpack')
                        ),
                        'preview'       => array(
                            'type'          => 'none'
						),
					),
					'custom_height'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Custom Height', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array('px'),
						'slider'		=> true,
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-logos-content .pp-logo',
							'property'		=> 'height',
							'unit'			=> 'px'
						)
					)
                )
            ),
            'logos_grid_count'       => array( // Section
                'title'        => __('Number of logos in a row', 'bb-powerpack'), // Section Title
                'fields'       => array( // Section Fields
                    'logos_grid_columns'   => array(
                        'type'          => 'unit',
                        'label' 		=> __('Number of Columns', 'bb-powerpack'),
                        'slider'        => true,
						'default'		=> '6',		
						'responsive' => array(
							'placeholder' => array(
								'default' => '6',
								'medium' => '4',
								'responsive' => '2',
							),
						),
                    ),
                )
            )
        )
    ),
    'logos_grid_content' => array( // Tab
        'title'         => __('Logos', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'logos_upload_content'    => array( // Section
                'title'        => '', // Section Title
                'fields'       => array( // Section Fields
                    'logos_grid'     => array(
						'type'          => 'form',
						'label'         => __('Logo', 'bb-powerpack'),
						'form'          => 'logos_grid_form', // ID from registered form below
						'preview_text'  => 'upload_logo_title', // Name of a field to use for the preview text
						'multiple'      => true
					),
                )
            ),
        )
    ),
    'logos_slider_tab'      => array( // Tab
		'title'         => __('Carousel', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'logo_slider'       => array( // Section
				'title'         => __('Carousel Settings', 'bb-powerpack'), // Section Title
				'fields'        => array( // Section Fields
                    'logo_carousel_width'   => array(
                        'type'          => 'unit',
                        'label'         => __('Slide Width', 'bb-powerpack'),
                        'units'	   		=> array( 'px' ),
						'slider'		=> true,
                        'default'       => '250',
                    ),
                    'logo_carousel_minimum_grid'   => array(
                        'type'          => 'unit',
                        'label'         => __('Number of Items', 'bb-powerpack'),
						'default'       => '4',
						'responsive'	=> true
					),
					'logo_carousel_move_slide'	=> array(
						'type'			=> 'text',
						'label'			=> __('Move Items', 'bb-powerpack'),
						'default'		=> '',
						'size'			=> '5'
					),
					'logo_slider_auto_play'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Auto Play', 'bb-powerpack'),
						'default'       => '1',
						'options'       => array(
                            '1'             => __('Yes', 'bb-powerpack'),
							'0'             => __('No', 'bb-powerpack'),
						)
					),
                    'logo_slider_pause_hover'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Pause on Hover', 'bb-powerpack'),
						'default'       => 'false',
						'options'       => array(
							'false'             => __('No', 'bb-powerpack'),
                            'true'             => __('Yes', 'bb-powerpack'),
						)
					),
					'logo_slider_pause'         => array(
						'type'          => 'text',
						'label'         => __('Delay', 'bb-powerpack'),
						'default'       => '4',
						'maxlength'     => '4',
						'size'			=> 5,
						'description'   => _x( 'seconds', 'Value unit for form field of time in seconds. Such as: "5 seconds"', 'bb-powerpack' )
					),
					'logo_slider_transition'    => array(
						'type'          => 'pp-switch',
						'label'         => __('Transition', 'bb-powerpack'),
						'default'       => 'horizontal',
						'options'       => array(
							'horizontal'    => _x( 'Slide', 'Transition type.', 'bb-powerpack' ),
							'fade'          => __( 'Fade', 'bb-powerpack' )
						),
                        'toggle'        => array(
                            'horizontal'    => array(
                                'fields'        => array('logo_carousel_width')
                            )
                        )
					),
					'logo_slider_speed'         => array(
						'type'          => 'text',
						'label'         => __('Transition Speed', 'bb-powerpack'),
						'default'       => '0.5',
						'size'			=> 5,
						'description'   => _x( 'seconds', 'Value unit for form field of time in seconds. Such as: "5 seconds"', 'bb-powerpack' )
					),
                    'logo_slider_arrows'       => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Navigation Arrows', 'bb-powerpack'),
						'default'       => '0',
						'options'       => array(
                            '1'             => __('Yes', 'bb-powerpack'),
							'0'             => __('No', 'bb-powerpack'),
						),
                        'toggle'        => array(
							'1'         => array(
								'sections'        => array('logo_carousel_arrow_style')
							)
						)
					),
                    'logo_slider_dots'       => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Navigation Dots', 'bb-powerpack'),
						'default'       => '0',
						'options'       => array(
                            '1'             => __('Yes', 'bb-powerpack'),
							'0'             => __('No', 'bb-powerpack'),
						),
                        'toggle'        => array(
							'1'         => array(
								'sections'        => array('logo_carousel_dot_style')
							)
						)
					),
				)
			),
        )
    ),
    'style'       => array( // Tab
        'title'         => __('Style', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'logo_grid_general_style'   => array( // Section
                'title' => __('Logo Container', 'bb-powerpack'), // Section Title
                'fields' => array( // Section Fields
                    'logo_grid_bg_color'    => array(
                        'type'         => 'color',
                        'label'        => __('Background Color', 'bb-powerpack'),
                        'default'      => '',
						'show_reset'   => true,
						'connections'	=> array('color'),
                        'preview'      => array(
                            'type'     => 'css',
                            'selector' => '.pp-logos-content .pp-logo',
                            'property' => 'background-color'
                        )
                    ),
                    'logo_grid_bg_hover'    => array(
                        'type'         => 'color',
                        'label'        => __('Background Color Hover', 'bb-powerpack'),
                        'default'      => '',
						'show_reset'   => true,
						'connections'	=> array('color'),
                        'preview'      => array(
                            'type'     => 'css',
                            'selector' => '.pp-logos-content .pp-logo:hover',
                            'property' => 'background-color'
                        )
                    ),
                    'field_separator_1' => array(
                        'type'              => 'pp-separator',
                        'color'             => 'eeeeee'
                    ),
					'logo_grid_opacity' => array(
                        'type'              => 'text',
                        'label'             => __('Opacity', 'bb-powerpack'),
                        'description'       => '%',
                        'default'           => 100,
                        'size'              => 3,
                        'class'             => 'pp-logo-grid-input input-small'
                    ),
                    'logo_grid_opacity_hover' => array(
                        'type'              => 'text',
                        'label'             => __('Opacity On Hover', 'bb-powerpack'),
                        'description'       => '%',
                        'default'           => 100,
                        'size'              => 3,
                        'class'             => 'pp-logo-grid-input input-small'
                    ),
                    'field_separator_2' => array(
                        'type'              => 'pp-separator',
                        'color'             => 'eeeeee'
                    ),
                    'logo_grid_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-logos-content .pp-logo',
                            'property'  	=> 'border',
                        ),
					),
                    'field_separator_3' => array(
                        'type'              => 'pp-separator',
                        'color'             => 'eeeeee'
                    ),
                    'logo_grid_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-logos-content .pp-logo',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                )
            ),
            'logo_grid_logo_style'   => array( // Section
                'title' => __('Logo', 'bb-powerpack'), // Section Title
                'fields' => array( // Section Fields
                    'logo_grid_grayscale'       => array(
						'type'          => 'pp-switch',
						'label'         => __('Logo Color', 'bb-powerpack'),
						'default'       => 'original',
						'options'       => array(
							'original'             => __('Original', 'bb-powerpack'),
							'grayscale'             => __('Greyscale', 'bb-powerpack')
						),
					),
                    'logo_grid_grayscale_hover'       => array(
						'type'          => 'pp-switch',
						'label'         => __('On Hover', 'bb-powerpack'),
						'default'       => 'original',
						'options'       => array(
							'original'             => __('Original', 'bb-powerpack'),
							'grayscale'            => __('Greyscale', 'bb-powerpack')
						),
					),
                    'logo_grid_logo_border_style'     => array(
                        'type'      => 'select',
                        'label'     => __('Border Style', 'bb-powerpack'),
                        'default'     => 'none',
                        'options'       => array(
							'none'          => __('None', 'bb-powerpack'),
							'solid'          => __('Solid', 'bb-powerpack'),
							'dashed'          => __('Dashed', 'bb-powerpack'),
							'dotted'          => __('Dotted', 'bb-powerpack'),
							'double'          => __('Double', 'bb-powerpack'),
						),
						'toggle'   => array(
							'solid'    => array(
								'fields'   => array('logo_grid_logo_border_width', 'logo_grid_logo_border_color', 'logo_grid_logo_border_hover')
							),
							'dashed'    => array(
								'fields'   => array('logo_grid_logo_border_width', 'logo_grid_logo_border_color', 'logo_grid_logo_border_hover')
							),
							'dotted'    => array(
								'fields'   => array('logo_grid_logo_border_width', 'logo_grid_logo_border_color', 'logo_grid_logo_border_hover')
							),
							'double'    => array(
								'fields'   => array('logo_grid_logo_border_width', 'logo_grid_logo_border_color', 'logo_grid_logo_border_hover')
							)
						)
                    ),
                    'logo_grid_logo_border_width'   => array(
                        'type'          => 'unit',
                        'label'         => __('Border Width', 'bb-powerpack'),
                        'default'       => '1',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .pp-logo img',
                            'property'        => 'border-width',
                            'unit'            => 'px'
                        )
                    ),
                    'logo_grid_logo_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .pp-logo img',
                            'property'        => 'border-color',
                        )
                    ),
                    'logo_grid_logo_border_hover'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color Hover', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .pp-logo:hover img',
                            'property'        => 'border-color',
                        )
                    ),
                    'logo_grid_logo_border_radius'   => array(
                        'type'          => 'unit',
                        'label'         => __('Round Corners', 'bb-powerpack'),
                        'default'       => '0',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .pp-logo img',
                            'property'        => 'border-radius',
                            'unit'            => 'px'
                        )
                    ),
                    'logo_grid_size'    => array(
                        'type'              => 'unit',
                        'label'             => __('Custom Size', 'bb-powerpack'),
                        'default'           => '',
						'units'				=> array( 'px' ),
						'slider'			=> true,
                        'preview'           => array(
                            'type'              => 'css',
                            'selector'          => '.pp-logos-content .pp-logo img',
                            'property'          => 'height',
                            'unit'              => 'px'
                        ),
                        'help'              => __('Leave blank for default size.', 'bb-powerpack')
                    )
                )
            ),
            'logo_carousel_arrow_style'   => array( // Section
                'title' => 'Carousel Navigation Arrow', // Section Title
                'fields' => array( // Section Fields
                    'logo_slider_arrow_bg_color'       => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => '000000',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-logos-content .fa',
							'property'      => 'background-color'
						)
					),
                    'logo_slider_arrow_color'       => array(
						'type'          => 'color',
						'label'         => __('Arrow Color', 'bb-powerpack'),
						'default'       => 'ffffff',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-logos-content .fa',
							'property'      => 'color'
						)
					),
                    'logo_slider_arrow_color_hover'       => array(
						'type'          => 'color',
						'label'         => __('Arrow Color Hover', 'bb-powerpack'),
						'default'       => '999999',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-logos-content .fa:hover',
							'property'      => 'color'
						)
					),
                    'logo_slider_arrow_bg_hover'  => array(
						'type'          => 'color',
						'label'         => __('Background Color Hover', 'bb-powerpack'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-logos-content .fa:hover',
							'property'      => 'background-color'
						)
					),
                    'logo_grid_arrow_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Arrow Size', 'bb-powerpack'),
                        'default'       => '16',
						'units'			=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .fa',
                            'property'        => 'font-size',
                            'unit'            => 'px'
                        )
                    ),
					'logo_grid_arrow'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-logos-content .fa',
                            'property'  	=> 'border',
                        ),
					),
                    'logo_grid_arrow_border_hover'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color Hover', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .fa:hover',
                            'property'        => 'border-color',
                        )
                    ),
                   'logo_grid_arrow_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-logos-content .fa, .pp-logos-content .fa:hover',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                )
            ),
            'logo_carousel_dot_style'   => array( // Section
                'title' => __( 'Carousel Navigation Dots', 'bb-powerpack' ), // Section Title
                'fields' => array( // Section Fields
                    'logo_grid_dot_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => 'f5f5f5',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
                            'selector'        => '.pp-logos-content .bx-wrapper .bx-pager.bx-default-pager a',
                            'property'        => 'background',
						)
					),
                    'logo_grid_dot_bg_hover'      => array(
						'type'          => 'color',
						'label'         => __('Active Dot Color', 'bb-powerpack'),
						'default'       => '999999',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
                            'type'          => 'css',
                            'selector'        => '.pp-logos-content .bx-wrapper .bx-pager.bx-default-pager a:active',
                            'property'        => 'background',
						)
					),
                    'logo_grid_dot_width'   => array(
                        'type'          => 'unit',
                        'label'         => __('Dot Size', 'bb-powerpack'),
                        'default'       => '14',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'         => array(
                            'type'            => 'css',
                            'rules'           => array(
                               array(
                                   'selector'        => '.pp-logos-content .bx-pager.bx-default-pager a',
                                   'property'        => 'width',
                                   'unit'            => 'px'
                               ),
                               array(
                                   'selector'        => '.pp-logos-content .bx-pager.bx-default-pager a',
                                   'property'        => 'height',
                                   'unit'            => 'px'
                               ),
                           ),
                        )
                    ),
                    'logo_grid_dot_border_radius'   => array(
                        'type'          => 'unit',
                        'label'         => __('Round Corners', 'bb-powerpack'),
                        'default'       => '100',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .bx-pager.bx-default-pager a',
                            'property'        => 'border-radius',
                            'unit'            => 'px'
                        )
                    ),
                )
            )
        )
    ),
    'typography'    => array(
        'title'         => __('Typography', 'bb-powerpack'),
        'sections'      => array(
            'logo_grid_title_style'   => array( // Section
                'title' => __('Title', 'bb-powerpack'), // Section Title
                'fields' => array( // Section Fields
                    'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-logos-content .pp-logo div.title-wrapper p.logo-title',
						),
					),
                    'logo_grid_title_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .pp-logo div.title-wrapper p.logo-title',
                            'property'        => 'color'
                        )
                    ),
                    'logo_grid_title_hover'    => array(
                        'type'          => 'color',
                        'label'         => __('Color Hover', 'bb-powerpack'),
                        'default'       => '666666',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-logos-content .pp-logo:hover div.title-wrapper p.logo-title',
                            'property'        => 'color'
                        )
                    ),
                    'logo_grid_title_top_margin'   => array(
                        'type'          => 'unit',
                        'label'         => __('Top Margin', 'bb-powerpack'),
                        'default'       => '10',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-logos-content .pp-logo div.title-wrapper p.logo-title',
                            'property'  => 'margin-top',
                            'unit'      => 'px'
                        )
                    ),
                    'logo_grid_title_bottom_margin'   => array(
                        'type'          => 'unit',
                        'label'         => __('Bottom Margin', 'bb-powerpack'),
                        'default'       => '10',
						'units'			=> array( 'px' ),
						'slider'		=> true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-logos-content .pp-logo div.title-wrapper p.logo-title',
                            'property'  => 'margin-bottom',
                            'unit'      => 'px'
                        )
                    ),
                )
            ),
        )
    )
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('logos_grid_form', array(
	'title' => __('Add Logo', 'bb-powerpack'),
	'tabs'  => array(
		'general'      => array( // Tab
			'title'         => __('General', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
				'general'       => array( // Section
					'title'         => '', // Section Title
					'fields'        => array( // Section Fields
						'upload_logo_grid'  => array(
							'type'          => 'photo',
                            'label'         => __('Upload', 'bb-powerpack'),
                            'connections'   => array( 'photo' ),
						),
                        'upload_logo_title'   => array(
                            'type'          => 'text',
                            'label'         => __('Title', 'bb-powerpack'),
                            'connections'   => array( 'string', 'html', 'url' ),
                            'preview'         => array(
                                'type'            => 'text',
                                'selector'        => '.pp-logos-content .pp-logo div.title-wrapper p.logo-title',
                            )
                        ),
                        'upload_logo_link'          => array(
                            'type'          => 'link',
                            'label'         => __('Link', 'bb-powerpack'),
                            'connections'   => array( 'url' ),
                            'preview'       => array(
                                'type'      => 'none'
                            )
                        ),
					)
				)
			)
		)
	)
));
