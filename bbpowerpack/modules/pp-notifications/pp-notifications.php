<?php

/**
 * @class PPNotificationsModule
 */
class PPNotificationsModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Alert Box', 'bb-powerpack'),
            'description'   => __('Addon to display notifications.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'lead_gen' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-notifications/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-notifications/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

		$this->add_css( BB_POWERPACK()->fa_css );
    }

	public function filter_settings( $settings, $helper )
	{
		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'box_border_type'	=> array(
				'type'				=> 'style'
			),
			'box_border_width'	=> array(
				'type'				=> 'width'
			),
			'box_border_color'	=> array(
				'type'				=> 'color'
			),
			'box_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'box_border' );

		// Handle box old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'box_padding', 'padding', 'box_padding', array(
			'top'		=> 'box_top_padding',
			'bottom'	=> 'box_top_padding',
			'left'		=> 'box_left_padding',
			'right'		=> 'box_right_padding'	
		) );

		// Handle text's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'text_font'	=> array(
				'type'			=> 'font'
			),
			'text_size'	=> array(
				'type'			=> 'font_size',
				'keys'			=> array(
					'desktop'		=> 'text_size_desktop',
					'tablet'		=> 'text_size_tablet',
					'mobile'		=> 'text_size_mobile'
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

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPNotificationsModule', array(
	'general'      => array( // Tab
		'title'         => __('General', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'notifications'      => array(
                'title'     => '',
                'fields'    => array(
                    'notification_icon' => array(
                        'type'      => 'icon',
                        'label'     => __('Icon', 'bb-powerpack'),
                    ),
                    'notification_content'  => array(
                        'type'  => 'textarea',
                        'label' => __('Content', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'   => array(
                            'type'  => 'text',
                            'selector'  => '.pp-notification-content p'
                        ),
                    ),
                ),
            ),
		)
	),
    'styles'    => array(
        'title' => __('Style', 'bb-powerpack'),
        'sections'  => array(
            'box_styling'   => array(
                'title'     => __('Box Styling', 'bb-powerpack'),
                'fields'    => array(
                    'box_background'    => array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-powerpack'),
                        'default'   => 'dddddd',
                        'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => 'div.pp-notification-wrapper',
                            'property'  => 'background-color'
                        ),
                    ),
					'box_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-notification-wrapper',
                            'property'  	=> 'border',
                        ),
					),
					'box_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-notification-wrapper',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                ),
            ),
            'icon_styling'  => array(
                'title' => __('Icon Styling', 'bb-powerpack'),
                'fields'    => array(
                    'icon_size'     => array(
                        'type'      => 'unit',
                        'label'     => __('Size', 'bb-powerpack'),
                        'default'   => 16,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-notification-wrapper .pp-notification-inner .pp-notification-icon span.pp-icon',
                            'property'  => 'font-size',
                            'unit'      => 'px'
                        ),
                    ),
                    'icon_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
                        'show_reset'    => true,
						'default'   => '000000',
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-notification-wrapper .pp-notification-inner .pp-notification-icon span.pp-icon',
                            'property'  => 'color'
                        ),
                    ),
                ),
            ),
        ),
    ),
    'typography'        => array(
        'title'         => __('Typography', 'bb-powerpack'),
        'sections'      => array(
            'typography'    => array(
                'title'     => '',
                'fields'    => array(
					'text_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-notification-wrapper .pp-notification-inner .pp-notification-content p',
						),
					),
                    'text_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
                        'show_reset'    => true,
						'default'       => '000000',
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-notification-wrapper .pp-notification-inner .pp-notification-content p',
                            'property'  => 'color'
                        ),
                    ),
                ),
            ),
        ),
    ),
));
