<?php

/**
 * @class PPSmartButtonModule
 */
class PPSmartButtonModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Smart Button', 'bb-powerpack'),
			'description'   	=> __('A simple call to action button.', 'bb-powerpack'),
			'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'content' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-smart-button/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-smart-button/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
		));
	}

	/**
	 * Ensure backwards compatibility with old settings.
	 *
	 * @since 2.6.8
	 * @param object $settings A module settings object.
	 * @param object $helper A settings compatibility helper.
	 * @return object
	 */
	public function filter_settings( $settings, $helper ) {
		// Handle old link nofollow settings.
		if ( isset( $settings->link_no_follow ) ) {
			$settings->link_nofollow = $settings->link_no_follow;
			unset( $settings->link_no_follow );
		} else {
			$settings->link_nofollow = 'no';
		}

		// Handle old background color settings
		if ( isset( $settings->bg_color ) && is_array( $settings->bg_color ) ) {
			$bg_color_primary = $settings->bg_color['primary'];
			$bg_color_secondary = $settings->bg_color['secondary'];

			$settings->bg_color = $bg_color_primary;
			$settings->bg_hover_color = $bg_color_secondary;
		}

		// - Transparent style.
		if ( $settings->style == 'transparent' ) {
			$settings->bg_color = 'rgba(255, 255, 255, 0)';
			$settings->style = 'flat';
			$settings->button_effect = 'none';
			if ( isset( $settings->bg_color_transparent ) ) {
				$settings->bg_hover_color = $settings->bg_color_transparent;
				if ( empty( $settings->bg_hover_color ) ) {
					$settings->bg_hover_color = $settings->bg_color;
				}
				unset( $settings->bg_color_transparent );
			}
		}

		// - Gradient style.
		if ( isset( $settings->bg_color_gradient ) && is_array( $settings->bg_color_gradient ) ) {
			$settings->bg_color_primary = $settings->bg_color_gradient['primary'];
			$settings->bg_color_secondary = $settings->bg_color_gradient['secondary'];

			unset( $settings->bg_color_gradient );
		}

		// Handle old text color settings.
		if ( isset( $settings->text_color ) && is_array( $settings->text_color ) ) {
			$text_color_primary = $settings->text_color['primary'];
			$text_color_secondary = $settings->text_color['secondary'];

			$settings->text_color = $text_color_primary;
			$settings->text_hover_color = $text_color_secondary;
		}

		// Handle old padding settings.
		if ( isset( $settings->padding ) && is_array( $settings->padding ) ) {
			$padding = $settings->padding;
			unset( $settings->padding );
			$settings->padding_top = isset( $padding['top'] ) ? $padding['top'] : '';
			$settings->padding_right = isset( $padding['right'] ) ? $padding['right'] : '';
			$settings->padding_bottom = isset( $padding['bottom'] ) ? $padding['bottom'] : '';
			$settings->padding_left = isset( $padding['left'] ) ? $padding['left'] : '';
		}

		// Handle old responsive align settings.
		if ( isset( $settings->responsive_align ) ) {
			$settings->align_medium = $settings->align;
			$settings->align_responsive = $settings->responsive_align;
			unset( $settings->responsive_align );
		}

		// Handle old border and box-shadow settings.
		if ( ! isset( $settings->border ) || empty( $settings->border ) ) {
			$border = array();

			if ( isset( $settings->border_type ) && isset( $settings->border_size ) && isset( $settings->border_color ) ) {
				$border['style'] = $settings->border_type;
				$border['width'] = array(
					'top' 		=> $settings->border_size,
					'right' 	=> $settings->border_size,
					'bottom' 	=> $settings->border_size,
					'left' 		=> $settings->border_size,
				);
				$border['color'] = ( is_array( $settings->border_color ) && isset( $settings->border_color['primary'] ) ) ? $settings->border_color['primary'] : '';
			}
			
			if ( isset( $settings->border_color ) ) {
				$settings->border_hover_color = ( is_array( $settings->border_color ) && isset( $settings->border_color['secondary'] ) ) ? $settings->border_color['secondary'] : '';
			}

			unset( $settings->border_type );
			unset( $settings->border_size );
			unset( $settings->border_color );

			// border-radius.
			if ( isset( $settings->border_radius ) ) {
				$border['radius'] = array(
					'top_left'		=> $settings->border_radius,
					'top_right'		=> $settings->border_radius,
					'bottom_left'	=> $settings->border_radius,
					'bottom_right'	=> $settings->border_radius,
				);

				unset( $settings->border_radius );
			}

			// box-shadow.
			if ( isset( $settings->button_shadow ) && 'yes' == $settings->button_shadow ) {
				$border['shadow'] = array(
					'color'			=> '',
					'horizontal'	=> '',
					'vertical'		=> '',
					'blur'			=> '',
					'spread'		=> '',
				);
				
				if ( isset( $settings->box_shadow_color ) ) {
					if ( ! empty( $settings->box_shadow_color ) ) {
						$opacity = 1;

						if ( isset( $settings->box_shadow_opacity ) ) {
							if ( ! empty( $settings->box_shadow_opacity ) ) {
								$opacity = $settings->box_shadow_opacity;
							}
							unset( $settings->box_shadow_opacity );
						}

						$border['shadow']['color'] = pp_hex2rgba( $settings->box_shadow_color, $opacity );
					}
					unset( $settings->box_shadow_color );
				}

				if ( isset( $settings->box_shadow ) && is_array( $settings->box_shadow ) ) {
					$border['shadow']['horizontal'] = $settings->box_shadow['horizontal'];
					$border['shadow']['vertical'] 	= $settings->box_shadow['vertical'];
					$border['shadow']['blur'] 		= $settings->box_shadow['blur'];
					$border['shadow']['spread'] 	= $settings->box_shadow['spread'];

					unset( $settings->box_shadow );
				}
			}

			$settings->border = $border;
		}

		// Handle old typography settings.
		if ( isset( $settings->font ) ) {
			$typography = array();
			$typography_medium = array();
			$typography_responsive = array();

			// - font family.
			$typography['font_family'] = $settings->font['family'];
			$typography['font_weight'] = $settings->font['weight'];

			// - font size.
			if ( isset( $settings->font_size ) && is_array( $settings->font_size ) ) {
				$typography['font_size'] = array(
					'length'	=> $settings->font_size['desktop'],
					'unit'		=> 'px'
				);
				$typography_medium['font_size'] = array(
					'length'	=> $settings->font_size['tablet'],
					'unit'		=> 'px'
				);
				$typography_responsive['font_size'] = array(
					'length'	=> $settings->font_size['mobile'],
					'unit'		=> 'px'
				);
			}

			// - line height.
			if ( isset( $settings->line_height ) && is_array( $settings->line_height ) ) {
				$typography['line_height'] = array(
					'length'	=> $settings->line_height['desktop'],
					'unit'		=> ''
				);
				$typography_medium['line_height'] = array(
					'length'	=> $settings->line_height['tablet'],
					'unit'		=> ''
				);
				$typography_responsive['line_height'] = array(
					'length'	=> $settings->line_height['mobile'],
					'unit'		=> ''
				);
			}

			// - letter spacing.
			if ( isset( $settings->letter_spacing ) ) {
				$typography['letter_spacing'] = array(
					'length'	=> $settings->letter_spacing,
					'unit'		=> 'px'
				);
			}

			$settings->typography = $typography;
			$settings->typography_medium = $typography_medium;
			$settings->typography_responsive = $typography_responsive;

			unset( $settings->font );
			unset( $settings->font_size );
			unset( $settings->line_height );
		}

		// Return the filtered settings.
		return $settings;
	}

	/**
	 * @method update
	 */
	public function update( $settings )
	{
		// Remove the old three_d setting.
		if ( isset( $settings->three_d ) ) {
			unset( $settings->three_d );
		}

		return $settings;
	}

	/**
	 * @method get_classname
	 */
	public function get_classname()
	{
		$classname = 'pp-button-wrap';

		if(!empty($this->settings->width)) {
			$classname .= ' pp-button-width-' . $this->settings->width;
		}
		if(!empty($this->settings->icon)) {
			$classname .= ' pp-button-has-icon';
		}

		return $classname;
	}

	/**
	 * Returns button link rel based on settings
	 * @since 2.6.8
	 */
	public function get_rel() {
		$rel = array();
		if ( '_blank' == $this->settings->link_target ) {
			$rel[] = 'noopener';
		}
		if ( isset( $this->settings->link_nofollow ) && 'yes' == $this->settings->link_nofollow ) {
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
FLBuilder::register_module('PPSmartButtonModule', array(
	'general'       => array(
		'title'         => __('General', 'bb-powerpack'),
		'sections'      => array(
			'style'         => array(
				'title'         => __('Button Type', 'bb-powerpack'),
				'fields'        => array(
					'style'         => array(
						'type'          => 'pp-switch',
						'label'         => __('Type', 'bb-powerpack'),
						'default'       => 'flat',
						'options'       => array(
							'flat'          => __('Flat', 'bb-powerpack'),
							'gradient'      => __('Gradient', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'flat'		=> array(
								'fields'	=> array('bg_color', 'bg_hover_color'),
								'sections'	=> array('effets'),
							),
							'gradient'		=> array(
								'fields'	=> array('bg_color_primary', 'bg_color_secondary', 'gradient_hover'),
							),
						),
					),
				)
			),
			'general'       => array(
				'title'         => __('Content', 'bb-powerpack'),
				'fields'        => array(
					'text'          => array(
						'type'          => 'text',
						'label'         => __('Text', 'bb-powerpack'),
						'default'       => __('Click Here', 'bb-powerpack'),
						'connections'   => array( 'string' ),
						'preview'         => array(
							'type'            => 'text',
							'selector'        => '.pp-button-text'
						)
					),
					'display_icon'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Display Icon', 'bb-powerpack'),
						'default'	=> 'no',
						'options'	=> array(
							'yes'	=> __('Yes', 'bb-powerpack'),
							'no'	=> __('No', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'yes'		=> array(
								'fields'	=> array('icon', 'icon_size', 'icon_position')
							),
						),
						'preview'	=> array(
							'type'		=> 'none'
						)
					),
					'icon'          => array(
						'type'          => 'icon',
						'label'         => __('Icon', 'bb-powerpack'),
						'show_remove'   => true
					),
					'icon_size'		=> array(
						'type'          => 'unit',
						'label'         => __('Icon Size', 'bb-powerpack'),
						'default'		=> 16,
						'units'			=> array('px'),
						'slider'		=> true,
						'responsive'	=> true,
						'preview'		=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-button .pp-button-icon',
							'property'	=> 'font-size',
							'unit'		=> 'px'
						)
					),
					'icon_position' => array(
						'type'          => 'pp-switch',
						'label'         => __('Icon Position', 'bb-powerpack'),
						'default'       => 'before',
						'options'       => array(
							'before'        => __('Before Text', 'bb-powerpack'),
							'after'         => __('After Text', 'bb-powerpack')
						)
					)
				)
			),
			'link'          => array(
				'title'         => __('Link', 'bb-powerpack'),
				'fields'        => array(
					'link'          => array(
						'type'          => 'link',
						'label'         => __('Link', 'bb-powerpack'),
						'placeholder'   => __( 'http://www.example.com', 'bb-powerpack' ),
						'show_target'	=> true,
						'show_nofollow'	=> true,
						'connections'   => array( 'url' ),
						'preview'       => array(
							'type'          => 'none'
						)
					),
				)
			),
			'effets'		=> array(
				'title'		=> __('Transition', 'bb-powerpack'),
				'fields'	=> array(
					'button_effect'   => array(
                        'type'  => 'select',
                        'label' => __('Hover Transition', 'bb-powerpack'),
                        'default'   => 'fade',
                        'options'   => array(
                            'none'  => __('None', 'bb-powerpack'),
                            'fade'  => __('Fade', 'bb-powerpack'),
							'sweep_top'  => __('Sweep To Top', 'bb-powerpack'),
							'sweep_bottom'  => __('Sweep To Bottom', 'bb-powerpack'),
                            'sweep_left'  => __('Sweep To Left', 'bb-powerpack'),
							'sweep_right'  => __('Sweep To Right', 'bb-powerpack'),
							'bounce_top'  => __('Bounce To Top', 'bb-powerpack'),
							'bounce_bottom'  => __('Bounce To Bottom', 'bb-powerpack'),
                            'bounce_left'  => __('Bounce To Left', 'bb-powerpack'),
							'bounce_right'  => __('Bounce To Right', 'bb-powerpack'),
                            'radial_in'  => __('Radial In', 'bb-powerpack'),
							'radial_out'  => __('Radial Out', 'bb-powerpack'),
                            'rectangle_in'  => __('Rectangle In', 'bb-powerpack'),
							'rectangle_out'  => __('Rectangle Out', 'bb-powerpack'),
                            'shutter_in_horizontal'  => __('Shutter In Horizontal', 'bb-powerpack'),
                            'shutter_out_horizontal'  => __('Shutter Out Horizontal', 'bb-powerpack'),
                            'shutter_in_vertical'  => __('Shutter In Vertical', 'bb-powerpack'),
                            'shutter_out_vertical'  => __('Shutter Out Vertical', 'bb-powerpack'),
                            'shutter_in_diagonal'  => __('Shutter In Diagonal', 'bb-powerpack'),
							'shutter_out_diagonal'  => __('Shutter Out Diagonal', 'bb-powerpack'),
                        ),
                    ),
                    'button_effect_duration'  => array(
                        'type'  => 'text',
                        'label' => __('Transition Duration', 'bb-powerpack'),
                        'size'  => 5,
                        'maxlength' => 4,
                        'default'   => 500,
                        'description'   => __('ms', 'bb-powerpack'),
                    ),
				),
			),
		)
	),
	'style'         => array(
		'title'         => __('Style', 'bb-powerpack'),
		'sections'      => array(
			'colors'        => array(
				'title'         => __('Colors', 'bb-powerpack'),
				'fields'        => array(
					'bg_color'      => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'		=> 'd6d6d6',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-button-wrap a.pp-button',
							'property'	=> 'background',
						),
					),
					'bg_hover_color'	=> array(
						'type'          => 'color',
						'label'         => __('Background Hover Color', 'bb-powerpack'),
						'default'		=> '333333',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'		=> 'none',
						),
					),
					'bg_color_primary'	=> array(
						'type'          => 'color',
						'label'         => __('Gradient Color Primary', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'bg_color_secondary'	=> array(
						'type'          => 'color',
						'label'         => __('Gradient Color Secondary', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'gradient_hover'	=> array(
						'type'			=> 'select',
						'label'			=> __('Hover Effect', 'bb-powerpack'),
						'default'		=> 'reverse',
						'options'		=> array(
							'reverse'	=> __('Reverse', 'bb-powerpack'),
							'primary'	=> __('Fill Primary', 'bb-powerpack'),
							'secondary'	=> __('Fill Secondary', 'bb-powerpack'),
						)
					),
					'text_color'    => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-button-wrap a.pp-button span',
							'property'	=> 'background',
						),
					),
					'text_hover_color'    => array(
						'type'          => 'color',
						'label'         => __('Text Hover Color', 'bb-powerpack'),
						'default'		=> 'dddddd',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none',
						),
					),
				)
			),
			'formatting'    => array(
				'title'         => __('Structure', 'bb-powerpack'),
				'fields'        => array(
					'width'         => array(
						'type'          => 'pp-switch',
						'label'         => __('Width', 'bb-powerpack'),
						'default'       => 'auto',
						'options'       => array(
							'auto'          => _x( 'Auto', 'Width.', 'bb-powerpack' ),
							'full'          => __('Full Width', 'bb-powerpack'),
							'custom'        => __('Custom', 'bb-powerpack')
						),
						'toggle'        => array(
							'auto'          => array(
								'fields'        => array('align')
							),
							'custom'        => array(
								'fields'        => array('align', 'custom_width')
							)
						)
					),
					'custom_width'  => array(
						'type'          => 'unit',
						'label'         => __('Custom Width', 'bb-powerpack'),
						'default'       => '200',
						'responsive'	=> true,
						'slider'		=> array(
							'px'			=> array(
								'min'			=> 0,
								'max'			=> 1000,
								'step'			=> 10,
							),
						),
						'units'   		=> array('px', 'vw', '%'),
						'preview'		=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-button-wrap a.pp-button',
							'property'	=> 'width',
							'unit'		=> 'px'
						),
					),
					'align'         => array(
						'type'          => 'align',
						'label'         => __('Alignment', 'bb-powerpack'),
						'default'       => 'left',
						'responsive'	=> true
					),
					'padding'       => array(
						'type'          => 'dimension',
						'label'         => __('Padding', 'bb-powerpack'),
						'responsive'	=> true,
						'slider'		=> true,
						'units'   		=> array('px'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-button-wrap a.pp-button',
							'property'		=> 'padding',
							'unit'			=> 'px'
						)
					),
				)
			),
			'border'       => array(
				'title'         => __( 'Border', 'bb-powerpack' ),
				'fields'        => array(
					'border' 		=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'       => array(
							'type'          => 'css',
							'selector'		=> '.pp-button-wrap a.pp-button',
							'important'		=> true,
						),
					),
					'border_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Border Hover Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none',
						),
					),
				),
			),
		)
	),
	'typography'	=> array(
		'title'		=> __('Typography', 'bb-powerpack'),
		'sections'	=> array(
			'text_fonts'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'typography'    => array(
						'type'        	=> 'typography',
						'label'       	=> __( 'Typography', 'bb-powerpack' ),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-button-wrap a.pp-button',
						),
					),
				),
			),
		),
	),
));
