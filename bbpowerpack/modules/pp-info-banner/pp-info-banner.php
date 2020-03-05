<?php

/**
 * @class PPInfoBannerModule
 */
class PPInfoBannerModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Smart Banner', 'bb-powerpack'),
            'description'   => __('A module for creating attractive call to action banners.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'lead_gen' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-info-banner/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-info-banner/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));
    }
	public function filter_settings( $settings, $helper ) {
		// Handle Form Background opacity + color field.
        if ( isset( $settings->form_background_opacity ) ) {
            $opacity = $settings->form_background_opacity >= 0 ? $settings->form_background_opacity : 1;
            $colorForm = $settings->form_bg_color;

            if ( ! empty( $colorForm ) ) {
                $colorForm = pp_hex2rgba( pp_get_color_value( $colorForm ), $opacity );
                $settings->form_bg_color = $colorForm;
            }

            unset( $settings->form_background_opacity );
		}
		// Handle old Button Link fields.
		$settings = PP_Module_Fields::handle_link_field( $settings, array(
			'button_link'	=> array(
				'type'			=> 'link'
			),
			'button_target'	=> array(
				'type'			=> 'target'
			)
		), 'button_link' );

		// Handle old Banner border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'banner_border_type'	=> array(
				'type'				=> 'style',
			),
			'banner_border_width'	=> array(
				'type'				=> 'width',
			),
			'banner_border_color'	=> array(
				'type'				=> 'color',
			),
			'banner_border_radius'	=> array(
				'type'				=> 'radius',
			),
		), 'banner_border_group' );

		// Handle old Banner Button border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'banner_button_border_type'	=> array(
				'type'				=> 'style',
			),
			'banner_button_border_width'	=> array(
				'type'				=> 'width',
			),
			'banner_button_border_color'	=> array(
				'type'				=> 'color',
			),
			'banner_button_border_radius'	=> array(
				'type'				=> 'radius',
			),
		), 'banner_button_border_group' );

		if ( isset( $settings->banner_info_padding ) ) {
			$settings->banner_info_padding_group_top = $settings->banner_info_padding;
			unset($settings->banner_info_padding);
		}
		if ( isset( $settings->banner_info_padding_b ) ) {
			$settings->banner_info_padding_group_bottom = $settings->banner_info_padding_b;
			unset($settings->banner_info_padding_b);
		}
		if ( isset( $settings->banner_info_padding_l ) ) {
			$settings->banner_info_padding_group_left = $settings->banner_info_padding_l;
			unset($settings->banner_info_padding_l);
		}
		if ( isset( $settings->banner_info_padding_r ) ) {
			$settings->banner_info_padding_group_right = $settings->banner_info_padding_r;
			unset($settings->banner_info_padding_r);
		}

		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'banner_title_font'	=> array(
				'type'			=> 'font'
			),
			'banner_title_font_size'	=> array(
				'type'          => 'font_size',
			),
			'banner_title_alignment'	=> array(
				'type'			=> 'text_align',
			),
			'banner_title_line_height'	=> array(
				'type'			=> 'line_height',
			),
			'banner_title_spacing'	=> array(
				'type'			=> 'letter_spacing',
			),
		), 'banner_title_typography' );

		return $settings;
	}

	/**
	 * Returns button link rel based on settings
	 * @since 2.6.9
	 */
	public function get_rel() {
		$rel = array();
		if ( '_blank' == $this->settings->button_link_target ) {
			$rel[] = 'noopener';
		}
		if ( isset( $this->settings->button_link_nofollow ) && 'yes' == $this->settings->button_link_nofollow ) {
			$rel[] = 'nofollow';
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
FLBuilder::register_module('PPInfoBannerModule', array(
    'info_banner_image'			=> array(
        'title'             => __('Image', 'bb-powerpack'),
        'sections'          => array(
            'image_section'     => array( // Section
                'title'             => '', // Section Title
                'fields'            => array( // Section Fields
					'banner_image'     => array(
                        'type'              => 'photo',
                        'label'             => __('Image', 'bb-powerpack'),
                        'default'           => '',
                        'connections'       => array( 'photo' ),
                    ),
                    'banner_image_arrangement'    => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Set as Background', 'bb-powerpack'),
                        'default'       => 'static',
                        'options'       => array(
                            'background'    => __('Yes', 'bb-powerpack'),
                            'static'        => __('No', 'bb-powerpack'),
                        ),
                        'toggle' => array(
                            'background' => array(
                                'sections'  => array('banner_overlay'),
                                'fields'    => array('banner_bg_size', 'banner_bg_repeat', 'banner_bg_position', 'banner_bg_hover_zoom'),
                            ),
                            'static' => array(
                                'fields' => array('banner_image_alignment', 'banner_image_height', 'banner_image_effect', 'banner_image_transition_duration')
                            )
                        )
                    ),
                    'banner_bg_size'      => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Scale', 'bb-powerpack'),
                        'default'       => 'cover',
                        'options'       => array(
                            'contain'   => __('Fit', 'bb-powerpack'),
                            'cover'     => __('Fill', 'bb-powerpack'),
                        )
                    ),
                    'banner_bg_repeat'    => array(
                        'type'          => 'select',
                        'label'         => __('Repeat', 'bb-powerpack'),
                        'default'       => 'no-repeat',
                        'options'       => array(
                            'no-repeat'     => __('None', 'bb-powerpack'),
                            'repeat'        => __('Tile', 'bb-powerpack'),
                            'repeat-x'      => __('Horizontal', 'bb-powerpack'),
                            'repeat-y'      => __('Vertical', 'bb-powerpack'),
                        )
                    ),
                    'banner_bg_position'    => array(
                        'type'              => 'select',
                        'label'             => __('Position', 'bb-powerpack'),
                        'default'           => 'center center',
                        'options'           => array(
                            'left top'          => __('Left Top', 'bb-powerpack'),
                            'left center'       => __('Left Center', 'bb-powerpack'),
                            'left bottom'       => __('Left Bottom', 'bb-powerpack'),
                            'right top'         => __('Right Top', 'bb-powerpack'),
                            'right center'      => __('Right Center', 'bb-powerpack'),
                            'right bottom'      => __('Right Bottom', 'bb-powerpack'),
                            'center top'        => __('Center Top', 'bb-powerpack'),
                            'center center'     => __('Center Center', 'bb-powerpack'),
                            'center bottom'     => __('Center Bottom', 'bb-powerpack'),
                        ),
                    ),
                    'banner_bg_hover_zoom'  => array(
                        'type'                  => 'pp-switch',
                        'label'                 => __('Hover Zoom Effect', 'bb-powerpack'),
                        'default'               => 'enable',
                        'options'               => array(
                            'enable'                => __('Enable', 'bb-powerpack'),
                            'disable'               => __('Disable', 'bb-powerpack')
                        )
                    ),
                    'banner_image_alignment'    => array(
                        'type'          => 'select',
                        'label'         => __('Alignment', 'bb-powerpack'),
                        'default'       => 'top-right',
                        'options'       => array(
                            'top-left'      	=> __('Top Left', 'bb-powerpack'),
                            'top-right'     	=> __('Top Right', 'bb-powerpack'),
                            'top-center'    	=> __('Top Center', 'bb-powerpack'),
							'center-left'      	=> __('Left Center', 'bb-powerpack'),
                            'center-right'     	=> __('Right Center', 'bb-powerpack'),
                            'center'    		=> __('Center', 'bb-powerpack'),
							'bottom-left'      	=> __('Bottom Left', 'bb-powerpack'),
                            'bottom-right'     	=> __('Bottom Right', 'bb-powerpack'),
                            'bottom-center'    	=> __('Bottom Center', 'bb-powerpack'),
                        )
                    ),
					'banner_image_height'   => array(
                        'type'          => 'unit',
                        'label'         => __('Height', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '400',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content img',
                            'property'  => 'height',
                            'unit'      => 'px'
                        )
                    ),
                    'banner_image_effect'    => array(
                        'type'          => 'select',
                        'label'         => __('Animation', 'bb-powerpack'),
                        'default'       => 'zoomIn',
                        'options'       => array(
                            'none'          => __('None', 'bb-powerpack'),
                            'swing'          => __('Swing', 'bb-powerpack'),
                            'pulse'          => __('Pulse', 'bb-powerpack'),
                            'flash'          => __('Flash', 'bb-powerpack'),
                            'fadeIn'          => __('Fade In', 'bb-powerpack'),
                            'fadeInUp'          => __('Fade In Up', 'bb-powerpack'),
                            'fadeInDown'          => __('Fade In Down', 'bb-powerpack'),
                            'fadeInLeft'          => __('Fade In Left', 'bb-powerpack'),
                            'fadeInRight'          => __('Fade In Right', 'bb-powerpack'),
                            'slideInDown'          => __('Slide In Down', 'bb-powerpack'),
                            'slideInUp'          => __('Slide In Up', 'bb-powerpack'),
                            'slideInRight'          => __('Slide In Right', 'bb-powerpack'),
                            'slideInLeft'          => __('Slide In Left', 'bb-powerpack'),
                            'bounceIn'          => __('Bounce In', 'bb-powerpack'),
                            'bounceInDown'          => __('Bounce In Down', 'bb-powerpack'),
                            'bounceInUp'          => __('Bounce In Up', 'bb-powerpack'),
                            'bounceInLeft'          => __('Bounce In Left', 'bb-powerpack'),
                            'bounceInRight'          => __('Bounce In Right', 'bb-powerpack'),
                            'flipInX'          => __('Flip In X', 'bb-powerpack'),
                            'FlipInY'          => __('Flip In Y', 'bb-powerpack'),
                            'lightSpeedIn'          => __('Light Speed In', 'bb-powerpack'),
                            'rotateIn'          => __('Rotate In', 'bb-powerpack'),
                            'rotateInDownLeft'          => __('Rotate In Down Left', 'bb-powerpack'),
                            'rotateInDownRight'          => __('Rotate In Down Right', 'bb-powerpack'),
                            'rotateInUpLeft'          => __('Rotate In Up Left', 'bb-powerpack'),
                            'rotateInUpRight'          => __('Rotate In Up Right', 'bb-powerpack'),
                            'rollIn'          => __('Roll In', 'bb-powerpack'),
                            'zoomIn'          => __('Zoom In', 'bb-powerpack'),
                        )
                    ),
                    'banner_image_transition_duration'   => array(
                        'type'          => 'unit',
                        'label'         => __('Animation Duration', 'bb-powerpack'),
                        'units'			=> array('ms'),
                        'slider'		=> true,
                        'default'       => '1000',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .info-banner-wrap',
                            'property'  => 'width',
                            'unit'      => 'ms'
                        )
                    ),
                )
            ),
            'banner_overlay'    => array(
				'title'             => __('Overlay', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'            => array(
                    'banner_bg_overlay'    => array(
                        'type'          => 'color',
                        'label'         => __('Overlay Color', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .pp-info-banner-bg:before',
                            'property'        => 'background-color'
                        )
                    ),
                    'banner_bg_opacity'   => array(
                        'type'          => 'unit',
                        'label'         => __('Overlay Opacity', 'bb-powerpack'),
                        'description'   => __('between 0 to 1', 'bb-powerpack'),
                        'slider'        => true,
                        'default'       => '0.5',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .pp-info-banner-bg:before',
                            'property'  => 'opacity',
                        )
                    ),
                )
            )
        )
    ),
    'info_banner_tab'			=> array( // Tab
        'title'         => __('Content', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'banner_section'	=> array( // Section
                'title'        => __('Banner Content', 'bb-powerpack'), // Section Title
                'fields'       => array( // Section Fields
                    'banner_title'   => array(
                        'type'          => 'text',
                        'label'         => __('Title', 'bb-powerpack'),
                        'class'         => '',
                        'default'       => '',
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'       => array(
                            'type'      => 'text',
                            'selector'  => '.pp-info-banner-content .banner-title',
                        )
                    ),
					'banner_description'    => array(
                        'type'              => 'textarea',
                        'label'             => __('Description', 'bb-powerpack'),
                        'default'           => '',
                        'placeholder'       => '',
                        'rows'              => '6',
                        'connections'       => array( 'string', 'html', 'url' ),
                        'preview'           => array(
                            'type'          => 'text',
                            'selector'      => '.pp-info-banner-content .banner-description'
                        )
                    ),
                    'banner_info_animation'     => array(
                       'type'      => 'select',
                       'label'     => __('Animation', 'bb-powerpack'),
                       'default'     => 'none',
                       'options'       => array(
                            'none'          => __('None', 'bb-powerpack'),
                            'swing'          => __('Swing', 'bb-powerpack'),
                            'pulse'          => __('Pulse', 'bb-powerpack'),
                            'flash'          => __('Flash', 'bb-powerpack'),
                            'fadeIn'          => __('Fade In', 'bb-powerpack'),
                            'fadeInUp'          => __('Fade In Up', 'bb-powerpack'),
                            'fadeInDown'          => __('Fade In Down', 'bb-powerpack'),
                            'fadeInLeft'          => __('Fade In Left', 'bb-powerpack'),
                            'fadeInRight'          => __('Fade In Right', 'bb-powerpack'),
                            'slideInDown'          => __('Slide In Down', 'bb-powerpack'),
                            'slideInUp'          => __('Slide In Up', 'bb-powerpack'),
                            'slideInRight'          => __('Slide In Right', 'bb-powerpack'),
                            'slideInLeft'          => __('Slide In Left', 'bb-powerpack'),
                            'bounceIn'          => __('Bounce In', 'bb-powerpack'),
                            'bounceInDown'          => __('Bounce In Down', 'bb-powerpack'),
                            'bounceInUp'          => __('Bounce In Up', 'bb-powerpack'),
                            'bounceInLeft'          => __('Bounce In Left', 'bb-powerpack'),
                            'bounceInRight'          => __('Bounce In Right', 'bb-powerpack'),
                            'flipInX'          => __('Flip In X', 'bb-powerpack'),
                            'FlipInY'          => __('Flip In Y', 'bb-powerpack'),
                            'lightSpeedIn'          => __('Light Speed In', 'bb-powerpack'),
                            'rotateIn'          => __('Rotate In', 'bb-powerpack'),
                            'rotateInDownLeft'          => __('Rotate In Down Left', 'bb-powerpack'),
                            'rotateInDownRight'          => __('Rotate In Down Right', 'bb-powerpack'),
                            'rotateInUpLeft'          => __('Rotate In Up Left', 'bb-powerpack'),
                            'rotateInUpRight'          => __('Rotate In Up Right', 'bb-powerpack'),
                            'rollIn'          => __('Roll In', 'bb-powerpack'),
                            'zoomIn'          => __('Zoom In', 'bb-powerpack'),
                        )
					),
					'banner_info_transition_duration' => array(
						'type'          => 'unit',
						'label'         => __('Animation Duration', 'bb-powerpack'),
						'units'			=> array('ms'),
						'slider'		=> true,
						'default'       => '1000',
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '.pp-info-banner-content .info-banner-wrap',
							'property'  => 'width',
							'unit'      => 'ms'
						)
					),
				)
            ),
			'button_section'	=> array( // Section
				'title'			=> __('Link', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'		=> array( // Section Fields
                    'link_type'     => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Link Type', 'bb-powerpack'),
                        'default'       => 'button',
                        'options'       => array(
                            'button'        => __('Button', 'bb-powerpack'),
                            'banner'        => __('Banner', 'bb-powerpack')
                        ),
                        'toggle'        => array(
                            'button'        => array(
                                'fields'        => array('button_text')
                            )
                        )
                    ),
                    'button_text'   => array(
                        'type'          => 'text',
                        'label'         => __('Text', 'bb-powerpack'),
                        'class'         => '',
                        'default'       => '',
                        'connections'   => array('string'),
                        'preview'       => array(
                            'type'      => 'text',
                            'selector'  => '.pp-info-banner-content .banner-button',
                        )
                    ),
					'button_link'	=> array(
						'type'          => 'link',
						'label'         => __('Link', 'bb-powerpack'),
						'connections'   => array( 'url' ),
						'show_target'	=> true,
						'show_nofollow'	=> true,
					),
                )
            ),
        )
    ),
    'style'						=> array(
        'title'         => __('Style', 'bb-powerpack'),
        'sections'      => array(
            'banner_style'      => array(
                'title'         => __('Banner', 'bb-powerpack'),
                'fields'        => array(
                    'banner_bg_color'		=> array(
                        'type'          => 'color',
                        'label'         => __('Background Color', 'bb-powerpack'),
                        'default'       => 'f3f3f3',
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'		=> array(
                            'type'			=> 'css',
                            'selector'		=> '.pp-info-banner-content',
                            'property'		=> 'background-color'
                        )
                    ),
                    'banner_min_height'		=> array(
                        'type'          => 'unit',
                        'label'         => __('Height', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '300',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content',
                            'property'  => 'height',
                            'unit'      => 'px'
                        )
                    ),
					'banner_info_alignment'	=> array(
                        'type'          => 'pp-switch',
                        'label'         => __('Content Alignment', 'bb-powerpack'),
                        'default'       => 'info-left',
                        'options'       => array(
                            'info-left'      => __('Left', 'bb-powerpack'),
                            'info-center'     => __('Center', 'bb-powerpack'),
                            'info-right'      => __('Right', 'bb-powerpack'),
                        )
					),
					'banner_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-info-banner-content',
						),
					),
					'banner_info_padding_group'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px', '%' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-info-banner-content .info-banner-wrap',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
            'banner_title_style'		=> array(
				'title'         => __('Title', 'bb-powerpack'),
				'collapsed'		=> true,
                'fields'        => array(
					'banner_title_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-title',
                            'property'        => 'color'
                        )
                    ),
                    'banner_title_border_type'    => array(
                        'type'          => 'select',
                        'label'         => __('Border', 'bb-powerpack'),
                        'default'       => 'no-border',
                        'options'       => array(
                            'no-border'      => __('None', 'bb-powerpack'),
                            'solid'     => __('Solid', 'bb-powerpack'),
                            'dashed'    => __('Dashed', 'bb-powerpack'),
							'dotted'      => __('Dotted', 'bb-powerpack'),
                            'double'     => __('Double', 'bb-powerpack'),
                        ),
                        'toggle'   => array(
                             'solid'    => array(
                                 'fields'   => array('banner_title_border_color', 'banner_title_border_width', 'banner_title_border_position')
                             ),
                             'dashed'    => array(
                                 'fields'   => array('banner_title_border_color', 'banner_title_border_width', 'banner_title_border_position')
                             ),
                             'dotted'    => array(
                                 'fields'   => array('banner_title_border_color', 'banner_title_border_width', 'banner_title_border_position')
                             ),
                             'double'    => array(
                                 'fields'   => array('banner_title_border_color', 'banner_title_border_width', 'banner_title_border_position')
                             )
                         )
                    ),
                    'banner_title_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-powerpack'),
                        'default'       => 'f3f3f3',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-title',
                            'property'        => 'border-color'
                        )
                    ),
                    'banner_title_border_width'   => array(
                        'type'          => 'unit',
                        'label'         => __('Border Width', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '1',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-title',
                            'property'  => 'border-width',
                            'unit'      => 'px'
                        )
                    ),
                    'banner_title_border_position'    => array(
                        'type'                    => 'select',
                        'label'                   => __('Border Position', 'bb-powerpack'),
                        'default'                 => 'border',
                        'options'				  => array(
                        	'border'			  => __('Default', 'bb-powerpack'),
                        	'border-top'		  => __('Top', 'bb-powerpack'),
                        	'border-bottom'		  => __('Bottom', 'bb-powerpack'),
                        	'border-left'		  => __('Left', 'bb-powerpack'),
                        	'border-right'		  => __('Right', 'bb-powerpack'),
                        ),
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-info-banner-content .banner-title',
                            'property'            => 'border',
                            'unit'                => 'px'
                        )
                    ),
                    'banner_title_margin'   => array(
                        'type'          => 'unit',
                        'label'         => __('Margin Bottom', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '5',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-title',
                            'property'  => 'margin-bottom',
                            'unit'      => 'px'
                        )
					),
					'banner_title_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-info-banner-content .banner-title',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
            'banner_description_style'	=> array(
				'title'         => __('Description', 'bb-powerpack'),
				'collapsed'		=> true,
                'fields'        => array(
					'banner_desc_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
						'default'       => '333333',
						'connections'	=> array('color'),
                        'show_reset'    => true,
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-description',
                            'property'        => 'color'
                        )
                    ),
					'banner_desc_margin'   => array(
                        'type'          => 'unit',
                        'label'         => __('Margin Bottom', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
						'default'       => '10',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-description',
                            'property'  => 'margin-bottom',
                            'unit'      => 'px'
                        )
					),
					'banner_desc_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-info-banner-content .banner-description',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
			'banner_button_style'       => array(
				'title'         => __('Button', 'bb-powerpack'),
				'collapsed'		=> true,
                'fields'        => array(
                    'banner_button_bg_color'		=> array(
                        'type'          => 'color',
                        'label'         => __('Background Color', 'bb-powerpack'),
                        'default'       => 'ffffff',
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-button',
                            'property'        => 'background-color'
                        )
                    ),
                    'banner_button_bg_hover_color'	=> array(
                        'type'          => 'color',
                        'label'         => __('Background Hover Color', 'bb-powerpack'),
                        'default'       => 'ffffff',
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-button:hover',
                            'property'        => 'background-color'
                        )
                    ),
					'banner_button_text_color'		=> array(
                        'type'          => 'color',
                        'label'         => __('Text Color', 'bb-powerpack'),
                        'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-button',
                            'property'        => 'color'
                        )
                    ),
					'banner_button_text_hover'		=> array(
                        'type'          => 'color',
                        'label'         => __('Text Hover Color', 'bb-powerpack'),
                        'default'       => 'cccccc',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-button:hover',
                            'property'        => 'color'
                        )
					),
					'banner_button_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-info-banner-content .banner-button',
						),
					),
                    'banner_button_border_hover'	=> array(
                        'type'          => 'color',
                        'label'         => __('Border Hover Color', 'bb-powerpack'),
                        'default'       => '222222',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-info-banner-content .banner-button:hover',
                            'property'        => 'border-color'
                        )
					),
					'banner_button_padding'			=> array(
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
                )
            )
        )
    ),
    'banner_typography'			=> array(
        'title'             => __('Typography', 'bb-powerpack'),
        'sections'          => array(
            'title_typography'  => array(
                'title'             => __('Title', 'bb-powerpack'),
                'fields'            => array(
					'banner_title_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-info-banner-content .banner-title',
						),
					),
                )
            ),
            'desc_typography'   => array(
				'title'             => __('Description', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'            => array(
                    'banner_desc_font'		=> array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-powerpack'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.pp-info-banner-content .banner-description'
                        )
                    ),
					'banner_desc_font_size'	=> array(
                        'type'          => 'unit',
                        'label'         => __('Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '20',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-description',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),
                )
            ),
            'button_typography' => array(
				'title'             => __('Button', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'            => array(
                    'banner_button_font' => array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-powerpack'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.pp-info-banner-content .banner-button'
                        )
                    ),
					'banner_button_font_size'   => array(
                        'type'          => 'text',
                        'label'         => __('Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '16',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-button',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),
                )
            )
        )
    ),
    'banner_responsive_style'	=> array( // Tab
        'title'         => __('Responsive', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'banner_breakpoint1_style'      => array( // Section
                'title'         => __('Break Point 1 Style', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'banner_bp1'   => array(
                        'type'          => 'unit',
                        'label'         => __('Break Point', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '960',
                    ),
                    'banner_bp1_min_height'   => array(
                        'type'          => 'unit',
                        'label'         => __('Banner Height', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '300',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content',
                            'property'  => 'height',
                            'unit'      => 'px'
                        )
                    ),
                    'banner_bp1_title_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Title Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '34',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-title',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),
                    'banner_bp1_desc_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Description Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '18',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-description',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),
                    'banner_bp1_button_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Button Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '18',
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-info-banner-content .banner-button',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),
                )
            ),
            'banner_breakpoint2_style'      => array( // Section
				'title'         => __('Break Point 2 Style', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'banner_bp2'   => array(
                        'type'          => 'unit',
                        'label'         => __('Break Point', 'bb-powerpack'),
                        'units'			=> array('px'),
						'slider'		=> true,
                        'default'       => '768',
                    ),
                    'banner_bp2_min_height'   => array(
                        'type'          => 'unit',
                        'label'         => __('Banner Height', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '250',
                    ),
                    'banner_bp2_title_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Title Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '30',
                    ),
                    'banner_bp2_desc_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Description Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '16',
                    ),
                    'banner_bp2_button_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __(' Button Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '16',
                    ),
                )
            ),
            'banner_breakpoint3_style'      => array( // Section
				'title'         => __('Break Point 3 Style', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'banner_bp3'   => array(
                        'type'          => 'unit',
                        'label'         => __('Break Point', 'bb-powerpack'),
                        'units'			=> array('px'),
						'slider'		=> true,
                        'default'       => '480',
                    ),
                    'banner_bp3_min_height'   => array(
                        'type'          => 'unit',
                        'label'         => __('Banner Height', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '200',
                    ),
                    'banner_bp3_title_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Title Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '26',
                    ),
                    'banner_bp3_desc_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Description Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '14',
                    ),
                    'banner_bp3_button_font_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Button Font Size', 'bb-powerpack'),
                        'units'			=> array('px'),
                        'slider'		=> true,
                        'default'       => '14',
                    ),
                )
            )
        )
    )
));
