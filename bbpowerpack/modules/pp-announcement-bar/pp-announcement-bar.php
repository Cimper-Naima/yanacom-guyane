<?php

/**
 * @class PPAnnouncementBarModule
 */
class PPAnnouncementBarModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Announcement Bar', 'bb-powerpack'),
            'description'   => __('Addon to add announement bar to the page.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'lead_gen' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-announcement-bar/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-announcement-bar/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
		));
	}
	
	public function enqueue_scripts() {
		$this->add_js( 'jquery-cookie' );
	}
	public function filter_settings( $settings, $helper ) {

		// Handle old Anouncement button background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'announcement_button_backgrounds', array(
			'primary'	=> 'announcement_button_bg_default',
			'secondary'	=> 'announcement_button_bg_hover',
		) );
		// Handle old Anouncement Link color background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'announcement_link_color', array(
			'primary'	=> 'announcement_link_color_default',
			'secondary'	=> 'announcement_link_color_hover',
		) );

		// Handle old Announcement Button border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'announcement_button_border_type'	=> array(
				'type'				=> 'style',
			),
			'announcement_button_border_width'	=> array(
				'type'				=> 'width',
			),
			'announcement_button_border_color'	=> array(
				'type'				=> 'color',
			),
			'announcement_button_border_radius'	=> array(
				'type'				=> 'radius',
			),
		), 'announcement_button_border_group' );
		// Handle Announcement Button old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'announcement_button_padding', 'padding', 'announcement_button_padding', array(
			'top'		=> 'announcement_button_top_padding',
			'bottom'	=> 'announcement_button_bottom_padding',
			'left'		=> 'announcement_button_left_padding',
			'right'		=> 'announcement_button_right_padding',
		) );
		// Handle Announcement Text font's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'announcement_text_font'	=> array(
				'type'			=> 'font'
			),
			'announcement_text_font_size'	=> array(
				'type'          => 'font_size',
				'keys'			=> array(
					'desktop'		=> 'announcement_text_font_size_desktop',
					'tablet'		=> 'announcement_text_font_size_tablet',
					'mobile'		=> 'announcement_text_font_size_mobile',
				)
			),
			'announcement_text_line_height'	=> array(
				'type'			=> 'line_height',
				'keys'			=> array(
					'desktop'		=> 'announcement_text_line_height_desktop',
					'tablet'		=> 'announcement_text_line_height_tablet',
					'mobile'		=> 'announcement_text_line_height_mobile',
				)
			),
		), 'announcement_text_typography' );

		// Handle Announcement Link font's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'announcement_link_font'	=> array(
				'type'			=> 'font'
			),
			'announcement_link_font_size'	=> array(
				'type'          => 'font_size',
			),
		), 'announcement_link_typography' );

		// Handle Link field.
		$settings = PP_Module_Fields::handle_link_field( $settings, array(
			'announcement_link_url'	=> array(
				'type'	=> 'link'
			),
		), 'announcement_link' );

		return $settings;
	}

	/**
	 * Returns button link rel based on settings
	 * @since 2.6.9
	 */
	public function get_rel() {
		$rel = array();
		if ( '_blank' == $this->settings->announcement_link_target ) {
			$rel[] = 'noopener';
		}
		if ( isset( $this->settings->announcement_link_nofollow ) && 'yes' == $this->settings->announcement_link_nofollow ) {
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
FLBuilder::register_module('PPAnnouncementBarModule', array(
	'general'      => array( // Tab
		'title'         => __('General', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'announcement_bar_position' => array(
                'title'     => '',
                'fields'    => array(
                    'announcement_bar_position' => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Bar Position', 'bb-powerpack'),
                        'default'   => 'top',
                        'options'   => array(
                            'top'       => __('Top', 'bb-powerpack'),
                            'bottom'    => __('Bottom', 'bb-powerpack')
                        ),
                    ),
                ),
            ),
            'general'      => array(
                'title'         => __('Content', 'bb-powerpack'),
                'fields'        => array(
                    'announcement_icon' => array(
                        'type'  => 'icon',
                        'label' => __('Icon', 'bb-powerpack'),
                        'show_remove'    => true
                    ),
                    'announcement_content'  => array(
                        'type'      => 'textarea',
                        'label'     => __('Content', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'   => array(
                            'type'  => 'text',
                            'selector'  => '.pp-announcement-bar-content p'
                        ),
                    ),
                    'announcement_link_type'    => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Link Type', 'bb-powerpack'),
                        'default'   => 'link',
                        'options'   => array(
                            'link'  => __('Link', 'bb-powerpack'),
                            'button'  => __('Button', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'link'      => array(
                                'fields'    => array('announcement_link_hover_color'),
                            ),
                            'button'    => array(
                                'sections'  => array('announcement_button_styling'),
                            )
                        )
                    ),
                    'announcement_link_text'    => array(
                        'type'      => 'text',
                        'label'     => __('Link Text', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'   => array(
                            'type'  => 'text',
                            'selector'  => '.pp-announcement-bar-link a'
                        )
                    ),
                    'announcement_link'     => array(
                        'type'      	=> 'link',
                        'label'     	=> __('Link', 'bb-powerpack'),
						'connections'   => array( 'url' ),
						'show_target'	=> true,
						'show_nofollow'	=> true,
                    ),
                ),
			),
			'cookie'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'display_after'	=> array(
						'type'			=> 'text',
						'label'			=> __('Display After', 'bb-powerpack'),
						'default'		=> '',
						'description'	=> __('day(s)', 'bb-powerpack'),
						'size'			=> 5,
						'connections'	=> array('string')
					)
				)
			)
		)
	),
    'style'     => array(
        'title' => __('Style', 'bb-powerpack'),	
        'sections'  => array(
            'announcement_settings'		=> array(
                'title' => __('General', 'bb-powerpack'),
                'fields'    => array(
                    'announcement_text_align'		=> array(
                        'type'      => 'pp-switch',
                        'label'     => __('Content Alignment', 'bb-powerpack'),
                        'default'   => 'center',
                        'options'   => array(
                            'left'    => __('Left', 'bb-powerpack'),
                            'center'    => __('Center', 'bb-powerpack'),
                        ),
                    ),
                    'announcement_bar_height'		=> array(
                        'type'      => 'unit',
                        'label'     => __('Bar Height', 'bb-powerpack'),
                        'slider'	=> true,
                        'units'		=> array('px'),
                        'default'   => 80,
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-wrap',
                            'property'  => 'height',
                            'unit'      => 'px'
                        )
                    ),
                    'announcement_bar_background'	=> array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-powerpack'),
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-wrap',
                            'property'  => 'background',
                        )
                    ),
                    'announcement_bar_border_type'	=> array(
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
                                'fields'    => array('announcement_bar_border_width', 'announcement_bar_border_color'),
                            ),
                            'dashed' => array(
                                'fields'    => array('announcement_bar_border_width', 'announcement_bar_border_color'),
                            ),
                            'dotted' => array(
                                'fields'    => array('announcement_bar_border_width', 'announcement_bar_border_color'),
                            ),
                        ),
                    ),
                    'announcement_bar_border_width'	=> array(
                        'type'      => 'unit',
                        'label'     => __('Border Width', 'bb-powerpack'),
                        'slider'	=> true,
                        'units'		=> array('px'),
                        'default'   => 1,
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-wrap',
                            'property'  => 'border',
                            'unit'      => 'px'
                        ),
                    ),
                    'announcement_bar_border_color'	=> array(
                        'type'      => 'color',
                        'label'     => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-wrap',
                            'property'  => 'border-color'
                        )
                    ),
                ),
            ),
            'announcement_icon_styling'	=> array(
				'title'     => __('Icon', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'announcement_icon_size'    => array(
                        'type'      => 'unit',
                        'label'     => __('Size', 'bb-powerpack'),
                        'slider'	=> true,
                        'units'		=> array('px'),
                        'default'   => 16,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-announcement-bar-icon .pp-icon',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),
                    'announcement_icon_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-icon .pp-icon',
                            'property'  => 'color'
                        ),
                    ),
                ),
            ),
            'announcement_box_shadow'   => array(
				'title'     => __('Box Shadow', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'announcement_box_shadow'			=> array(
                        'type'      => 'pp-switch',
                        'label'     => __('Display Box Shadow?', 'bb-powerpack'),
                        'default'   => 'no',
                        'options'   => array(
                            'yes'    => __('Yes', 'bb-powerpack'),
                            'no'    => __('No', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    => array('announcement_box_shadow_options', 'announcement_box_shadow_color', 'announcement_box_shadow_opacity'),
                            ),
                        ),
                    ),
                    'announcement_box_shadow_options'	=> array(
                        'type'      => 'pp-multitext',
                        'label'     => __('Box Shadow', 'bb-powerpack'),
                        'default'   => array(
                            'announcement_box_shadow_h' => 0,
                            'announcement_box_shadow_v' => 0,
                            'announcement_box_shadow_blur' => 10,
                            'announcement_box_shadow_spread' => 0,
                        ),
                        'options'   => array(
                            'announcement_box_shadow_h'     => array(
                                'placeholder'       => __('Horizontal', 'bb-powerpack'),
                                'icon'              => 'fa-arrows-h',
                                'maxlength'         => 2,
                                'tooltip'           => __('Horizontal', 'bb-powerpack')
                            ),
                            'announcement_box_shadow_v'     => array(
                                'placeholder'       => __('Vertical', 'bb-powerpack'),
                                'icon'              => 'fa-arrows-v',
                                'maxlength'         => 2,
                                'tooltip'           => __('Vertical', 'bb-powerpack')
                            ),
                            'announcement_box_shadow_blur'     => array(
                                'placeholder'       => __('Blur', 'bb-powerpack'),
                                'icon'              => 'fa-circle-o',
                                'maxlength'         => 2,
                                'tooltip'           => __('Blur', 'bb-powerpack')
                            ),
                            'announcement_box_shadow_spread'     => array(
                                'placeholder'       => __('Spread', 'bb-powerpack'),
                                'icon'              => 'fa-paint-brush',
                                'maxlength'         => 2,
                                'tooltip'           => __('Spread', 'bb-powerpack')
                            ),
                        ),
                    ),
                    'announcement_box_shadow_color'		=> array(
                        'type'              => 'color',
                        'label'             => __('Color', 'bb-powerpack'),
						'default'           => '000000',
						'connections'	=> array('color'),
                    ),
                    'announcement_box_shadow_opacity'	=> array(
                        'type'              => 'text',
                        'label'             => __('Opacity', 'bb-powerpack'),
                        'class'             => 'input-small',
                        'default'           => 0.5,
                    ),
                ),
            ),
            'announcement_close_button_styling' => array(
				'title'     => __('Close Button', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'announcement_close_color'  => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-wrap .pp-announcement-bar-close-button .pp-close-button',
                            'property'  => 'color'
                        ),
                    ),
                    'close_size'    => array(
                        'type'      => 'unit',
                        'label'     => __('Size', 'bb-powerpack'),
                        'slider'	=> true,
                        'units'		=> array('px'),
                        'default'   => 16,
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-announcement-bar-wrap .pp-announcement-bar-close-button .pp-close-button',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        )
                    ),

                ),
            ),
            'announcement_button_styling'   => array(
				'title'     => __('Button', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'announcement_button_bg_default'	=> array(
						'type'		=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> 'dddddd',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      	=> 'css',
                            'selector'  	=> '.pp-announcement-bar-link a',
                            'property'  	=> 'background'
                        ),
					),
					'announcement_button_bg_hover'		=> array(
						'type'			=> 'color',
						'label'			=> __('Background Hover Color', 'bb-powerpack'),
						'default'		=> '333333',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'announcement_button_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-announcement-bar-link a',
						),
					),
					'announcement_button_padding'		=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-announcement-bar-wrap .pp-announcement-bar-link a',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
        )
    ),
    'announcement_typography'   => array(
        'title'     => __('Typography', 'bb-powerpack'),
        'sections'  => array(
            'announcement_text_typography'  => array(
                'title' => __('Content', 'bb-powerpack'),
                'fields'    => array(
					'announcement_text_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-announcement-bar-wrap .pp-announcement-bar-content p',
						),
					),
                    'announcement_text_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-announcement-bar-content p',
                            'property'  => 'color'
                        ),
                    ),
                ),
            ),
            'announcement_link_typography'  => array(
                'title'     => __('Link/Button', 'bb-powerpack'),
                'fields'    => array(
					'announcement_link_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-announcement-bar-link a'
						),
					),
					'announcement_link_color_default'	=> array(
						'type'		=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '333333',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
					'announcement_link_color_hover'		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Hover Color', 'bb-powerpack'),
						'default'		=> 'dddddd',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
                ),
            ),
        ),
    ),
));
