<?php

/**
 * @class PPAdvancedTabsModule
 */
class PPAdvancedTabsModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Advanced Tabs', 'bb-powerpack'),
			'description'   	=> __('Display a collection of tabbed content.', 'bb-powerpack'),
			'group'         	=> pp_get_modules_group(),
            'category'			=> pp_get_modules_cat( 'content' ),
            'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-advanced-tabs/',
            'url'           	=> BB_POWERPACK_URL . 'modules/pp-advanced-tabs/',
            'editor_export' 	=> true, // Defaults to true and can be omitted.
            'enabled'       	=> true, // Defaults to true and can be omitted.
			'partial_refresh'	=> true,
		));

		$this->add_css(BB_POWERPACK()->fa_css);
	}

	/**
	 * Render content.
	 *
	 * @since 1.4
	 */
	public function render_content( $settings )
	{
		$html = '';

		switch ( $settings->content_type ) {
			case 'content':
				global $wp_embed;
				$html = '<div itemprop="text">';
				$html .= wpautop( $wp_embed->autoembed( $settings->content ) );
				$html .= '</div>';
				break;
			case 'photo':
				$html = '<div itemprop="image">';
				$html .= '<img src="'.$settings->content_photo_src.'" alt="" style="max-width: 100%;" />';
				$html .= '</div>';
				break;
			case 'video':
                global $wp_embed;
                $html = $wp_embed->autoembed( $settings->content_video );
            	break;
			case 'module':
				$html = '[fl_builder_insert_layout id="'.$settings->content_module.'"]';
				break;
			case 'row':
				$html = '[fl_builder_insert_layout id="'.$settings->content_row.'"]';
				break;
			case 'layout':
				$html = '[fl_builder_insert_layout id="'.$settings->content_layout.'"]';
				break;
			default:
				break;
		}

		return $html;
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle old content padding multitext field.
		if ( isset( $settings->content_padding ) && is_array( $settings->content_padding ) ) {
			$settings = PP_Module_Fields::handle_multitext_field( $settings, 'content_padding', 'padding', 'content_padding' );
		}

		// Handle old title typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'tab_label_font'	=> array(
				'type'				=> 'font'
			),
			'tab_label_font_size'	=> array(
				'type'					=> 'font_size',
				'condition'				=> ( isset( $settings->tab_title_size ) && 'custom' == $settings->tab_title_size )
			),
			'tab_label_line_height'	=> array(
				'type'					=> 'line_height'
			),
			'label_text_transform'	=> array(
				'type'					=> 'text_transform'
			),
		), 'label_typography' );

		// Handle old content typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'tab_content_font'	=> array(
				'type'				=> 'font'
			),
			'tab_content_font_size'	=> array(
				'type'					=> 'font_size',
				'condition'				=> ( isset( $settings->tab_content_size ) && 'custom' == $settings->tab_content_size )
			),
			'tab_content_line_height'	=> array(
				'type'						=> 'line_height'
			),
			'content_alignment'			=> array(
				'type'						=> 'text_align'
			),
		), 'content_typography' );

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPAdvancedTabsModule', array(
	'items'         => array(
		'title'         => __('Items', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'items'         => array(
						'type'          => 'form',
						'label'         => __('Item', 'bb-powerpack'),
						'form'          => 'tab_items_form', // ID from registered form below
						'preview_text'  => 'label', // Name of a field to use for the preview text
						'multiple'      => true
					),
				)
			)
		)
	),
	'style'        => array(
		'title'         => __('Style', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => __('General', 'bb-powerpack'),
				'fields'        => array(
					'layout'        => array(
						'type'          => 'select',
						'label'         => __('Layout', 'bb-powerpack'),
						'default'       => 'horizontal',
						'options'       => array(
							'horizontal'    => __('Horizontal', 'bb-powerpack'),
							'vertical'      => __('Vertical', 'bb-powerpack'),
						)
					),
					'tab_style'        => array(
						'type'          => 'select',
						'label'         => __('Select Style', 'bb-powerpack'),
						'default'       => 'default',
						'options'       => array(
							'default'    => __('Basic', 'bb-powerpack'),
							'style-1'    => __('Style 1', 'bb-powerpack'),
							'style-2'    => __('Style 2', 'bb-powerpack'),
							'style-3'    => __('Style 3', 'bb-powerpack'),
							'style-4'    => __('Style 4', 'bb-powerpack'),
							'style-5'    => __('Style 5', 'bb-powerpack'),
							'style-6'    => __('Style 6', 'bb-powerpack'),
							'style-7'    => __('Style 7', 'bb-powerpack'),
							'style-8'    => __('Style 8', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'default'	=> array(
								'fields'	=> array('border_color', 'label_background_color', 'label_background_active_color', 'label_text_color')
							),
							'style-1'	=> array(
								'fields'	=> array('border_color', 'label_background_color', 'label_background_active_color', 'label_text_color', 'content_border_width', 'content_border_color')
							),
							'style-2'	=> array(
								'fields'	=> array('border_color', 'label_background_color', 'label_background_active_color', 'label_text_color', 'content_border_width', 'content_border_color')
							),
							'style-3'	=> array(
								'fields'	=> array('label_background_color', 'label_background_active_color', 'label_text_color', 'content_border_width', 'content_border_color')
							),
							'style-4'	=> array(
								'fields'	=> array('label_background_color', 'label_background_active_color', 'label_text_color', 'content_border_width', 'content_border_color')
							),
							'style-5'	=> array(
								'fields'	=> array('label_background_active_color', 'label_text_color', 'content_border_width', 'content_border_color')
							),
							'style-6'	=> array(
								'fields'	=> array('label_text_color', 'content_border_width', 'content_border_color')
							),
							'style-7'	=> array(
								'fields'	=> array('border_color', 'label_text_color', 'label_text_hover_color', 'content_border_width', 'content_border_color')
							),
							'style-8'	=> array(
								'fields'	=> array('border_color', 'label_background_active_color', 'label_text_color', 'label_margin', 'content_border_width', 'content_border_color')
							),
						)
					),
					'tab_id_prefix'	=> array(
						'type'			=> 'text',
						'label'			=> __('Custom ID Prefix', 'bb-powerpack'),
						'default'		=> '',
						'placeholder'	=> __('mytab', 'bb-powerpack'),
						'help'			=> __('A prefix that will be applied to ID attribute of tabs\'s in HTML. For example, prefix "mytab" will be applied as "mytab-1", "mytab-2" in ID attribute of Tab 1 and Tab 2 respectively. It should only contain dashes, underscores, letters or numbers. No spaces.', 'bb-powerpack')
					),
					'tab_default'	=> array(
						'type'			=> 'text',
						'label'			=> __('Default Active Tab Index', 'bb-powerpack'),
						'default'		=> 1,
						'help'			=> __('Enter the index number of the tab that will be appeared as default active tab on page load.', 'bb-powerpack')
					),
					'responsive_closed'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __('Responsive Closed?', 'bb-powerpack'),
						'default'			=> 'no',
						'options'			=> array(
							'yes'				=> __('Yes', 'bb-powerpack'),
							'no'				=> __('No', 'bb-powerpack')
						)
					)
				)
			),
			'label_style'       => array(
				'title'         => __('Title', 'bb-powerpack'),
				'fields'        => array(
					'label_background_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => 'ffffff',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.pp-tabs .pp-tabs-label:not(.pp-tab-active)',
							'property'	=> 'background-color',
						)
					),
					'label_background_active_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color Active', 'bb-powerpack'),
						'default'       => 'f7f7f7',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'	=> 'css',
							'rules'	=>	array(
								array(
									'selector'	=> '.pp-tabs .pp-tabs-label.pp-tab-active,
									 				.pp-tabs .pp-tabs-label.pp-tab-active:hover,
													.pp-tabs-style-5 .pp-tabs-label .pp-tab-label-inner:after,
													.pp-tabs-style-5 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:after,
													.pp-tabs-style-8 .pp-tabs-label:hover .pp-tab-label-inner:after,
													.pp-tabs-style-8 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:after,
													.pp-tabs-style-8 .pp-tabs-label:hover,
													.pp-tabs-vertical.pp-tabs-style-2 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:after,
													.pp-tabs-style-5 .pp-tabs-panels .pp-tabs-panel-content',
									'property'	=> 'background-color',
								),
								array(
									'selector'	=> '.pp-tabs-style-2 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:after',
									'property'	=> 'border-top-color',
								)
							)
						)
					),
					'label_text_color'    => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'bb-powerpack'),
						'default'       => '666666',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.pp-tabs .pp-tabs-label',
							'property'	=> 'color',
						)
                    ),
					'label_active_text_color'    => array(
						'type'          => 'color',
						'label'         => __('Text Color Active', 'bb-powerpack'),
						'default'       => '333333',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'	=> 'css',
							'rules'	=> array(
								array(
									'selector'	=> '.pp-tabs .pp-tabs-label.pp-tab-active, .pp-tabs .pp-tabs-label.pp-tab-active:hover, .pp-tabs .pp-tabs-label:hover, .pp-tabs-style-5 .pp-tabs-label:hover',
									'property'	=> 'color',
								),
								array(
									'selector'	=> '.pp-tabs-style-3 .pp-tabs-label:after, .pp-tabs-style-4 .pp-tabs-label:before, .pp-tabs-style-6 .pp-tabs-label:last-child:before',
									'property'	=> 'background-color',
								)
							)
						)
                    ),
					'border_color'  => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'default'       => 'eeeeee',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'	=> 'css',
							'rules'	=> array(
								array(
									'selector'	=> '.pp-tabs-style-1 .pp-tabs-labels, .pp-tabs-default .pp-tabs-panels, .pp-tabs-default .pp-tabs-panel',
									'property'	=> 'border-color',
								),
								array(
									'selector'	=> '.pp-tabs-style-1 .pp-tabs-labels, .pp-tabs-style-8 .pp-tabs-label .pp-tab-label-inner:after',
									'property'	=> 'background-color',
								),
								array(
									'selector'	=> '.pp-tabs-style-2 .pp-tabs-labels .pp-tabs-label:first-child:before, .pp-tabs-style-2 .pp-tabs-labels .pp-tabs-label::after',
									'property'	=> 'background',
								),
								array(
									'selector'	=> '.pp-tabs-style-7 .pp-tabs-label .pp-tab-label-inner',
									'property'	=> 'border-bottom-color',
								),
								array(
									'selector'	=> '.pp-tabs-style-7 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:after, .pp-tabs-style-7 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:before',
									'property'	=> 'border-top-color',
								),
								array(
									'selector'	=> '.pp-tabs-vertical.pp-tabs-style-7 .pp-tabs-label .pp-tab-label-inner',
									'property'	=> 'border-right-color',
								),
								array(
									'selector'	=> '.pp-tabs-vertical.pp-tabs-style-7 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:before, .pp-tabs-vertical.pp-tabs-style-7 .pp-tabs-label.pp-tab-active .pp-tab-label-inner:after',
									'property'	=> 'border-left-color',
								)
							)
						)
					),
					'label_margin'   => array(
                        'type'          => 'text',
                        'label'         => __('Space between labels', 'bb-powerpack'),
                        'description'   => 'px',
                        'size'			=> 5,
						'maxlength'		=> 3,
                        'default'       => '15',
                        'preview'       => array(
                            'type'      => 'css',
							'rules'		=> array(
								array(
									'selector'  => '.pp-tabs-horizontal.pp-tabs-style-8 .pp-tabs-label',
									'property'  => 'margin-left',
									'unit'      => 'px'
								),
								array(
									'selector'  => '.pp-tabs-horizontal.pp-tabs-style-8 .pp-tabs-label',
									'property'  => 'margin-right',
									'unit'      => 'px'
								),
							)
                        )
                    ),
				)
			),
			'content_style'       => array(
				'title'         => __('Content', 'bb-powerpack'),
				'fields'        => array(
					'content_bg_type'        => array(
						'type'          => 'pp-switch',
						'label'         => __('Background Type', 'bb-powerpack'),
						'default'       => 'color',
						'options'       => array(
							'color'    		=> __('Color', 'bb-powerpack'),
							'image'    		=> __('Image', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'color'	=> array(
								'fields'	=> array('content_bg_color')
							),
							'image'	=> array(
								'fields'	=> array('content_bg_image', 'content_bg_size', 'content_bg_repeat')
							),
						)
					),
					'content_bg_image'     => array(
						'type'              => 'photo',
						'label'         => __('Background Image', 'bb-powerpack'),
						'default'       => '',
						'show_remove'	=> true,
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '.pp-tabs-panels .pp-tabs-panel-content',
							'property'  => 'background-image'
						)
					),
					'content_bg_size'      => array(
						'type'          => 'pp-switch',
						'label'         => __('Background Size', 'bb-powerpack'),
						'default'       => 'cover',
						'options'       => array(
							'contain'   => __('Contain', 'bb-powerpack'),
							'cover'     => __('Cover', 'bb-powerpack'),
						),
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '.pp-tabs-panels .pp-tabs-panel-content',
							'property'  => 'background-size'
						)
					),
					'content_bg_repeat'    => array(
						'type'          => 'pp-switch',
						'label'         => __('Background Repeat', 'bb-powerpack'),
						'default'       => 'no-repeat',
						'options'       => array(
							'repeat-x'      => __('Repeat X', 'bb-powerpack'),
							'repeat-y'      => __('Repeat Y', 'bb-powerpack'),
							'no-repeat'     => __('No Repeat', 'bb-powerpack'),
						),
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '.pp-tabs-panels .pp-tabs-panel-content',
							'property'  => 'background-repeat'
						)
					),
					'content_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-tabs-panels .pp-tabs-panel-content',
							'property'		=> 'background-color'
						)
					),
					'content_text_color'  => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'bb-powerpack'),
						'default'       => '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-tabs-panels .pp-tabs-panel-content',
							'property'		=> 'color'
						)
					),
					'content_border_width'   => array(
                        'type'      => 'pp-multitext',
                        'label'     => __('Border Width', 'bb-powerpack'),
                        'description'   => 'px',
                        'default'       => array(
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                        ),
                        'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'              => array(
                                    'selector'	=> '.pp-tabs-panels .pp-tabs-panel-content',
                                    'property'	=> 'border-top-width',
                                    'unit'		=> 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'              => array(
                                    'selector'	=> '.pp-tabs-panels .pp-tabs-panel-content',
                                    'property'	=> 'border-bottom-width',
                                    'unit'		=> 'px'
                                )
                            ),
                            'left' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Left', 'bb-powerpack'),
                                'tooltip'       => __('Left', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-left',
                                'preview'              => array(
                                    'selector'	=> '.pp-tabs-panels .pp-tabs-panel-content',
                                    'property'	=> 'border-left-width',
                                    'unit'		=> 'px'
                                )
                            ),
                            'right' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Right', 'bb-powerpack'),
                                'tooltip'       => __('Right', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-right',
                                'preview'              => array(
                                    'selector'	=> '.pp-tabs-panels .pp-tabs-panel-content',
                                    'property'	=> 'border-right-width',
                                    'unit'		=> 'px'
                                )
                            ),
                        )
                    ),
					'content_border_color'  => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'default'       => '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-tabs-panels .pp-tabs-panel-content',
							'property'		=> 'border-color'
						)
					),
					'content_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> 30,
						'units'				=> array('px'),
						'slider'			=> true,
						'preview'           => array(
							'selector'			=> '.pp-tabs-panels .pp-tabs-panel-content',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			)
		)
	),
	'tab_icon_style'	=> array(
		'title'	=>	__('Icon', 'bb-powerpack'),
		'sections'	=> array(
			'icon_style'       => array(
				'title'         => __('General', 'bb-powerpack'),
				'fields'        => array(
					'tab_icon_position'        => array(
						'type'          => 'select',
						'label'         => __('Icon Position', 'bb-powerpack'),
						'default'       => 'left',
						'options'       => array(
							'top'    		=> __('Top', 'bb-powerpack'),
							'bottom'    	=> __('Bottom', 'bb-powerpack'),
							'left'    		=> __('Left', 'bb-powerpack'),
							'right'    		=> __('Right', 'bb-powerpack'),
						),
					),
					'tab_icon_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Size', 'bb-powerpack'),
						'units'			=> array('px'),
						'slider'		=> true,
                        'default'       => '20',
                        'preview'       => array(
                            'type'      => 'css',
							'selector'  => '.pp-tabs-label .pp-tab-icon, .pp-tabs-label .pp-tab-icon:before',
							'property'  => 'font-size',
							'unit'      => 'px'
                        )
					),
					'tab_icon_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'       => array(
                            'type'      => 'css',
							'selector'  => '.pp-tabs-label .pp-tab-icon',
							'property'  => 'color',
                        )
					),
					'tab_icon_color_hover'	=> array(
						'type'				=> 'color',
						'label'				=> __('Hover/Active Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'       => array(
                            'type'      => 'none',
                        )
					),
				)
			),
			'responsive_toggle_icons'	=> array(
				'title'	=> __('Responsive Toggle Icons', 'bb-powerpack'),
				'fields'	=> array(
					'tab_open_icon' => array(
						'type'          => 'icon',
						'label'         => __('Open Icon', 'bb-powerpack'),
						'show_remove'   => true
					),
					'tab_close_icon' => array(
						'type'          => 'icon',
						'label'         => __('Close Icon', 'bb-powerpack'),
						'show_remove'   => true
					),
					'tab_toggle_icon_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Size', 'bb-powerpack'),
                        'units'			=> array('px'),
						'slider'		=> true,
                        'default'       => '16',
                        'preview'       => array(
                            'type'      => 'css',
							'selector'  => '.pp-tabs-panel-label .pp-toggle-icon',
							'property'  => 'font-size',
							'unit'      => 'px'
                        )
                    ),
					'tab_toggle_icon_color'  => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'default'       => '333333',
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.pp-tabs-panel-label .pp-toggle-icon',
							'property'	=> 'color'
						)
					),
				)
			)
		)
	),
	'typography'        => array(
		'title'         => __('Typography', 'bb-powerpack'),
		'sections'      => array(
			'label_typography'	=> array(
				'title'	=> __('Title', 'bb-powerpack'),
				'fields'	=> array(
					'label_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-tabs-labels .pp-tabs-label .pp-tab-title'
						)
					),
				)
			),
			'content_typography'	=> array(
				'title'	=> __('Content', 'bb-powerpack'),
				'fields'	=> array(
					'content_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-tabs-panels .pp-tabs-panel-content'
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
FLBuilder::register_settings_form('tab_items_form', array(
	'title' => __('Add Item', 'bb-powerpack'),
	'tabs'  => array(
		'general'      => array(
			'title'         => __('General', 'bb-powerpack'),
			'sections'      => array(
				'general'       => array(
					'title'         => '',
					'fields'        => array(
						'tab_font_icon' => array(
							'type'          => 'icon',
							'label'         => __('Icon', 'bb-powerpack'),
							'show_remove'   => true
						),
						'label'         => array(
							'type'          => 'text',
							'label'         => __('Title', 'bb-powerpack'),
							'connections'   => array( 'string', 'html', 'url' ),
						),
					)
				),
				'content'       => array(
					'title'         => __('Content', 'bb-powerpack'),
					'fields'        => array(
						'content_type'	=> array(
							'type'			=> 'select',
							'label'			=> __('Type', 'bb-powerpack'),
							'default'		=> 'content',
							'options'		=> array(
								'content'		=> __('Content', 'bb-powerpack'),
								'photo'			=> __('Photo', 'bb-powerpack'),
								'video'			=> __('Video', 'bb-powerpack'),
								'module'		=> __('Saved Module', 'bb-powerpack'),
								'row'			=> __('Saved Row', 'bb-powerpack'),
								'layout'		=> __('Saved Layout', 'bb-powerpack'),
							),
							'toggle'		=> array(
								'content'		=> array(
									'fields'		=> array('content')
								),
								'photo'		=> array(
									'fields'	=> array('content_photo')
								),
								'video'		=> array(
									'fields'	=> array('content_video')
								),
								'module'	=> array(
									'fields'	=> array('content_module')
								),
								'row'		=> array(
									'fields'	=> array('content_row')
								),
								'layout'	=> array(
									'fields'	=> array('content_layout')
								)
							)
						),
						'content'       => array(
							'type'          => 'editor',
							'label'         => '',
							'connections'   => array( 'string', 'html', 'url' ),
						),
						'content_photo'	=> array(
							'type'			=> 'photo',
							'label'			=> __('Photo', 'bb-powerpack'),
							'connections'   => array( 'photo' ),
						),
						'content_video'     => array(
	                        'type'              => 'textarea',
	                        'label'             => __('Embed Code / URL', 'bb-powerpack'),
	                        'rows'              => 6,
							'connections'   	=> array( 'string', 'html', 'url' ),
	                    ),
						'content_module'	=> array(
							'type'				=> 'select',
							'label'				=> __('Saved Module', 'bb-powerpack'),
							'options'			=> array()
						),
						'content_row'		=> array(
							'type'				=> 'select',
							'label'				=> __('Saved Row', 'bb-powerpack'),
							'options'			=> array()
						),
						'content_layout'	=> array(
							'type'				=> 'select',
							'label'				=> __('Saved Layout', 'bb-powerpack'),
							'options'			=> array()
						),
					)
				)
			)
		)
	)
));
