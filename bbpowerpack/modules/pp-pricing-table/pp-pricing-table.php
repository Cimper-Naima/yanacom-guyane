<?php

/**
 * @class PPPricingTableModule
 */
class PPPricingTableModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Pricing Table', 'bb-powerpack'),
			'description'   => __('Addon to display pricing table.', 'bb-powerpack'),
			'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'content' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-pricing-table/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-pricing-table/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
		));

	}

	/**
	 * @method render_button
	 */
	public function render_button($column)
	{
		$btn_settings = array(
			'align'				=> $this->settings->pricing_columns[$column]->btn_align,
			'bg_color'          => $this->settings->pricing_columns[$column]->btn_bg_color,
			'bg_hover_color'    => $this->settings->pricing_columns[$column]->btn_bg_hover_color,
			'bg_opacity'        => $this->settings->pricing_columns[$column]->btn_bg_opacity,
			'border_radius'     => $this->settings->pricing_columns[$column]->btn_border_radius,
			'border_size'       => $this->settings->pricing_columns[$column]->btn_border_size,
			'icon'              => $this->settings->pricing_columns[$column]->btn_icon,
			'icon_position'     => $this->settings->pricing_columns[$column]->btn_icon_position,
			'icon_animation'	=> $this->settings->pricing_columns[$column]->btn_icon_animation,
			'link'              => $this->settings->pricing_columns[$column]->button_url,
			'link_nofollow' 	=> $this->settings->pricing_columns[$column]->btn_link_nofollow,
			'link_target'       => $this->settings->pricing_columns[$column]->btn_link_target,
			'style'             => $this->settings->pricing_columns[$column]->btn_style,
			'text'              => $this->get_shortcode_text( $this->settings->pricing_columns[$column]->button_text ),
			'text_color'        => $this->settings->pricing_columns[$column]->btn_text_color,
			'text_hover_color'  => $this->settings->pricing_columns[$column]->btn_text_hover_color,
			'width'             => $this->settings->pricing_columns[$column]->btn_width,
			'class'				=> 'pp-pricing-package-button'
		);

		if ( 'yes' == $this->settings->dual_pricing ) {
			$btn_settings['link_2'] = $this->settings->pricing_columns[$column]->button_url_2;
		}

		FLBuilder::render_module_html('fl-button', $btn_settings);
	}

	/**
	 * Check if the provided text is shortcode.
	 *
	 * @since 1.3
	 * @param string $text
	 * @return boolean
	 */
	public function is_shortcode( $text )
	{
		if ( empty( $text ) ) {
			return false;
		}
		if ( $text[0] == '[' && $text[strlen($text) - 1] == ']' ) {
			return true;
		}
	}

	/**
	 * Get shortcode content.
	 *
	 * @since 1.3
	 * @param string $text
	 * @return string
	 */
	public function get_shortcode_text( $text )
	{
		if ( $this->is_shortcode( $text ) ) {
			return do_shortcode( $text );
		}

		return $text;
	}

	public function filter_settings( $settings, $helper ) {
		// Handle old Dual Pricing Button border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'dp_button_border'	=> array(
				'type'				=> 'style',
			),
			'dp_button_border_width'	=> array(
				'type'				=> 'width',
			),
			'dp_button_border_color'	=> array(
				'type'				=> 'color',
			),
			'dp_button_radius'	=> array(
				'type'				=> 'radius',
			),
		), 'dp_button_border_group' );

		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'box_border'	=> array(
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
			'box_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->box_shadow_display ) && 'yes' == $settings->box_shadow_display ),
			),
			'box_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->box_shadow_display ) && 'yes' == $settings->box_shadow_display ),
				'opacity'			=> isset( $settings->box_shadow_opacity ) ? $settings->box_shadow_opacity : 1
			),
		), 'box_border_group' );

		// Handle box old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'box_padding', 'padding', 'box_padding' );

		// Handle featured title old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'featured_title_padding', 'padding', 'featured_title_padding' );

		// Handle title old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'title_padding', 'padding', 'title_padding' );

		// Handle price old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'price_padding', 'padding', 'price_padding' );

		// Handle features old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'features_padding', 'padding', 'features_padding' );

		// Handle old highlight box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'hl_box_border'	=> array(
				'type'				=> 'style'
			),
			'hl_box_border_width'	=> array(
				'type'				=> 'width'
			),
			'hl_box_border_color'	=> array(
				'type'				=> 'color'
			),
			'hl_box_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->hl_box_shadow_display ) && 'yes' == $settings->hl_box_shadow_display ),
			),
			'hl_box_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->hl_box_shadow_display ) && 'yes' == $settings->hl_box_shadow_display ),
				'opacity'			=> isset( $settings->hl_box_shadow_opacity ) ? $settings->hl_box_shadow_opacity : 1
			),
		), 'hl_box_border_group' );

		// Handle highlight box old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'hl_box_padding', 'padding', 'hl_box_padding' );

		// Handle featured title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'featured_title_font'	=> array(
				'type'			=> 'font'
			),
			'featured_title_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->featured_title_font_size ) && 'custom' == $settings->featured_title_font_size )
			),
			'featured_title_custom_line_height'	=> array(
				'type'			=> 'line_height',
				'condition'		=> ( isset( $settings->featured_title_line_height ) && 'custom' == $settings->featured_title_line_height )
			),
			'featured_title_text_transform'		=> array(
				'type'			=> 'text_transform'
			),
			'featured_title_letter_spacing'		=> array(
				'type'			=> 'letter_spacing'
			),
			'featured_title_alignment'		=> array(
				'type'			=> 'text_align'
			)
		), 'featured_title_typography' );

		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'title_font'	=> array(
				'type'			=> 'font'
			),
			'title_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->title_font_size ) && 'custom' == $settings->title_font_size )
			),
			'title_custom_line_height'	=> array(
				'type'			=> 'line_height',
				'condition'		=> ( isset( $settings->title_line_height ) && 'custom' == $settings->title_line_height )
			),
			'title_text_transform'		=> array(
				'type'			=> 'text_transform'
			),
			'title_letter_spacing'		=> array(
				'type'			=> 'letter_spacing'
			),
			'title_alignment'		=> array(
				'type'			=> 'text_align'
			)
		), 'title_typography' );

		// Handle price's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'price_font'	=> array(
				'type'			=> 'font'
			),
			'price_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->price_font_size ) && 'custom' == $settings->price_font_size )
			),
			'price_text_transform'		=> array(
				'type'			=> 'text_transform'
			),
		), 'price_typography' );

		// Handle duration old Font Size field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'duration_custom_font_size', 'responsive', 'duration_custom_font_size' );

		// Handle features's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'features_font'	=> array(
				'type'			=> 'font'
			),
			'features_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->features_font_size ) && 'custom' == $settings->features_font_size )
			),
			'features_text_transform'		=> array(
				'type'			=> 'text_transform'
			),
			'features_alignment'		=> array(
				'type'			=> 'text_align'
			)
		), 'features_typography' );

		// Handle button's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'button_font'	=> array(
				'type'			=> 'font'
			),
			'button_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->button_font_size ) && 'custom' == $settings->button_font_size )
			),
			'button_text_transform'		=> array(
				'type'			=> 'text_transform'
			),
		), 'button_typography' );

		for( $i = 0; $i < count( $settings->pricing_columns ); $i++ ) {
			
			if ( ! is_object( $settings->pricing_columns[ $i ] ) ) {
				continue;
			}

			// Handle button old padding field.
			$settings->pricing_columns[ $i ] = PP_Module_Fields::handle_multitext_field( $settings->pricing_columns[ $i ], 'button_padding', 'padding', 'button_padding' );

			// Handle button old margin field.
			$settings->pricing_columns[ $i ] = PP_Module_Fields::handle_multitext_field( $settings->pricing_columns[ $i ], 'button_margin', 'margin', 'button_margin' );

		}

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPPricingTableModule', array(
	'general'	=> array(
		'title'		=> __('General', 'bb-powerpack'),
		'sections'	=> array(
			'structure'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'pricing_table_style' => array(
						'type'          => 'pp-switch',
						'label'         => __('Layout', 'bb-powerpack'),
						'default'       => 'cards',
						'options'       => array(
							'cards'        => __('Cards', 'bb-powerpack'),
							'matrix'         => __('Matrix', 'bb-powerpack')
						),
						'toggle'	=> array(
							'matrix'	=> array(
								'tabs'	=> array('matrix_items')
							)
						),
					),
					'dual_pricing'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Enable Dual Pricing', 'bb-powerpack'),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array('dual_pricing_settings')
							)
						)
					)
				)
			),
			'dual_pricing_settings'	=> array(
				'title'		=> __('Dual Pricing Button', 'bb-powerpack'),
				'fields'	=> array(
					'dp_button_1_text'	=> array(
						'type'			=> 'text',
						'label'			=> __('Button 1 Text', 'bb-powerpack'),
						'connections'	=> array('string', 'html'),
						'preview'	=> array(
							'type'		=> 'text',
							'selector'	=> '.pp-pricing-table .pp-pricing-button-1',
						)
					),
					'dp_button_2_text'				=> array(
						'type'			=> 'text',
						'label'			=> __('Button 2 Text', 'bb-powerpack'),
						'connections'	=> array('string', 'html'),
						'preview'	=> array(
							'type'		=> 'text',
							'selector'	=> '.pp-pricing-table .pp-pricing-button-2',
						)
					),
					'dp_button_alignment'			=> array(
						'type'		=> 'align',
						'label'		=> __('Alignment', 'bb-powerpack'),
						'default'	=> 'center',
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons',
							'property'	=> 'text-align'
						)
					),
					'dp_button_active_bg_color'		=> array(
						'type'			=> 'color',
						'label'			=> __('Active Background Color', 'bb-powerpack'),
						'default'		=> 'f1f1f1',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button.pp-pricing-button-active',
							'property'		=> 'background-color'
						)
					),
					'dp_button_active_text_color'	=> array(
						'type'		=> 'color',
						'label'		=> __('Active Text Color', 'bb-powerpack'),
						'default'	=> '000000',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button.pp-pricing-button-active',
							'property'	=> 'color'
						)
					),
					'dp_button_default_text_color'	=> array(
						'type'		=> 'color',
						'label'		=> __('Default Text Color', 'bb-powerpack'),
						'default'	=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button',
							'property'	=> 'color'
						)
					),
					'dp_button_border_group'				=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
					),
					'dp_button_apply_border'		=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Apply Border to', 'bb-powerpack'),
						'default'	=> 'active',
						'options'	=> array(
							'active'	=> __('Active Button', 'bb-powerpack'),
							'all'		=> __('All Buttons', 'bb-powerpack'),
						)
					),
					'dp_button_font_size'			=> array(
						'type'					=> 'unit',
						'label'					=> __('Font Size', 'bb-powerpack'),
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive' 			=> array(
							'placeholder' 			=> array(
								'default' 				=> '',
								'medium' 				=> '',
								'responsive'			=> '',
							),
						),
						'help'	=> __('Leave blank for default font size.', 'bb-powerpack'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button',
							'property'	=> 'font-size',
							'unit'		=> 'px'
						)
					),
					'dp_button_padding_v'			=> array(
						'type'					=> 'unit',
						'label'					=> __('Padding Top/Bottom', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive' 			=> array(
							'placeholder' 			=> array(
								'default' 				=> '10',
								'medium' 				=> '',
								'responsive'			=> '',
							),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button',
									'property'	=> 'padding-top',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button',
									'property'	=> 'padding-bottom',
									'unit'		=> 'px'
								),
							)
						)
					),
					'dp_button_padding_h'			=> array(
						'type'					=> 'unit',
						'label'					=> __('Padding Left/Right', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive' 			=> array(
							'placeholder' 			=> array(
								'default' 				=> '15',
								'medium' 				=> '',
								'responsive'			=> '',
							),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button',
									'property'	=> 'padding-left',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button',
									'property'	=> 'padding-right',
									'unit'		=> 'px'
								),
							)
						)
					),
					'dp_button_spacing'				=> array(
						'type'					=> 'unit',
						'label'					=> __('Spacing b/w Buttons', 'bb-powerpack'),
						'default'				=> '10',
						'slider'				=> true,
						'responsive' 			=> array(
							'placeholder' 			=> array(
								'default' 				=> '5',
								'medium' 				=> '',
								'responsive'			=> '',
							),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-buttons .pp-pricing-button-1',
							'property'	=> 'margin-right',
							'unit'		=> 'px'
						)
					),
					'dp_button_spacing_bottom'	=> array(
						'type'					=> 'unit',
						'label'					=> __('Spacing Below', 'bb-powerpack'),
						'default'				=> '20',
						'slider'				=> true,
						'responsive' 			=> array(
							'placeholder' 			=> array(
								'default' 				=> '20',
								'medium' 				=> '',
								'responsive'			=> '',
							),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-switch',
							'property'	=> 'margin-bottom',
							'unit'		=> 'px'
						)
					),
				)
			)
		)
	),
	'columns'      => array(
		'title'         => __('Packages', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'pricing_columns'     => array(
						'type'         => 'form',
						'label'        => __('Package', 'bb-powerpack'),
						'form'         => 'pp_pricing_column_form',
						'preview_text' => 'title',
						'multiple'     => true
					),
				)
			)
		)
	),
	'matrix_items'      => array(
		'title'         => __('Items Box', 'bb-powerpack'),
		'sections'      => array(
			'matrix_column'	=> array(
				'title'	=> __( 'Items', 'bb-powerpack' ),
				'fields'	=> array(
					'matrix_items'	=> array(
						'type'          => 'text',
						'label'         => '',
						'placeholder'   => __( 'One feature per line. HTML is okay.', 'bb-powerpack' ),
						'multiple'      => true,
					)
				)
			),
			'general'	=> array(
				'title'	=> __( 'Style', 'bb-powerpack' ),
				'fields'	=> array(
					'matrix_bg'						=> array(
						'type'          	=> 'color',
						'default'       	=> 'f5f5f5',
						'label'         	=> __( 'Box Background Color', 'bb-powerpack' ),
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column',
							'property'			=> 'background-color'
						)
					),
					'matrix_even_features_bg_color'	=> array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Alternate Background Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features li:nth-child(even)',
							'property'		=> 'background-color'
						)
					),
					'matrix_text_color'				=> array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Items Text Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features',
							'property'		=> 'color'
						)
					),
					'matrix_features_border'		=> array(
						'type'      => 'pp-switch',
						'label'     => __('Items Border Style', 'bb-powerpack'),
						'default'   => 'none',
						'options'   => array(
							'none'  => __('None', 'bb-powerpack'),
							'solid'  => __('Solid', 'bb-powerpack'),
							'dashed'  => __('Dashed', 'bb-powerpack'),
							'dotted'  => __('Dotted', 'bb-powerpack'),
						),
						'toggle'    => array(
							'dashed'   => array(
								'fields'    => array('matrix_features_border_width', 'matrix_features_border_color')
							),
							'dotted'   => array(
								'fields'    => array('matrix_features_border_width', 'matrix_features_border_color')
							),
							'solid'   => array(
								'fields'    => array('matrix_features_border_width', 'matrix_features_border_color')
							),
						),
						'preview'           => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-bottom-style',
						)
					),
					'matrix_features_border_width'	=> array(
						'type'              => 'unit',
						'label'             => __('Items Border Width', 'bb-powerpack'),
						'units'				=> array('px'),
						'slider'			=> true,
						'default'           => 1,
						'preview'           => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-bottom-width',
							'unit'		=> 'px'
						)
					),
					'matrix_features_border_color'	=> array(
						'type'      => 'color',
						'label'     => __('Items Border Color', 'bb-powerpack'),
						'show_reset'   => true,
						'default'	=> '',
						'connections'	=> array('color'),
						'preview'              => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-color',
						)
					),
					'matrix_alignment'				=> array(
						'type'		=> 'align',
						'label'		=> __('Items Alignment', 'bb-powerpack'),
						'default'	=> 'left',
					),
				)
			),
		)
	),
	'style'       => array(
		'title'         => __('Style', 'bb-powerpack'),
		'sections'      => array(
			'box_style'       => array(
				'title'         => __( 'Package Column', 'bb-powerpack' ),
				'fields'        => array(
					'box_spacing'   => array(
						'type'          => 'unit',
						'label'         => __('Spacing', 'bb-powerpack'),
						'default'       => '12',
						'units'			=> array('px'),
						'slider'	   	=> true,
						'help'          => __('Use this to add space between pricing table columns.', 'bb-powerpack'),
						'preview'		=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col',
									'property'	=> 'padding-left',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col',
									'property'	=> 'padding-right',
									'unit'		=> 'px'
								),
							)
						)
					),
					'box_bg_color'      => array(
						'type'      => 'color',
						'label'     => __('Background Color', 'bb-powerpack'),
						'default'	=> 'f5f5f5',
						'show_reset'   => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'              => array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column',
							'property'			=> 'background-color',
						)
					),
					'box_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-highlight) .pp-pricing-table-column, .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column ul',
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
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-highlight) .pp-pricing-table-column, .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column ul',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			),
			'featured_title_style'	=> array(
				'title'	=> __( 'Featured Title', 'bb-powerpack' ),
				'fields'	=> array(
					'featured_title_bg_color' => array(
						'type'              => 'color',
						'label'             => __('Background Color', 'bb-powerpack'),
						'default'           => 'cccccc',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'       	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-featured-title',
							'property'	=> 'background-color',
						)
					),
					'featured_title_color' => array(
						'type'              => 'color',
						'label'             => __('Text Color', 'bb-powerpack'),
						'default'           => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-featured-title',
							'property'	=> 'color',
						)
					),
					'featured_title_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-column .pp-pricing-featured-title',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			),
			'title_style'	=> array(
				'title'	=> __( 'Package Title', 'bb-powerpack' ),
				'fields'	=> array(
					'title_position' => array(
						'type'		=> 'pp-switch',
						'label'		=> __('Position', 'bb-powerpack'),
						'default'	=> 'above',
						'options'       => array(
							'above'          => __( 'Above Price', 'bb-powerpack' ),
							'below'         => __( 'Below Price', 'bb-powerpack' ),
						),
					),
					'title_bg_color' => array(
						'type'              => 'color',
						'label'             => __('Background Color', 'bb-powerpack'),
						'default'           => '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight):not(.pp-pricing-table-highlight-title) .pp-pricing-table-column .pp-pricing-table-title',
							'property'	=> 'background-color',
						)
					),
					'title_color' => array(
						'type'              => 'color',
						'label'             => __('Text Color', 'bb-powerpack'),
						'default'           => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight):not(.pp-pricing-table-highlight-title) .pp-pricing-table-column .pp-pricing-table-title',
							'property'	=> 'color',
						)
					),
					'title_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-title',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			),
			'price_style'	=> array(
				'title'	=> __( 'Price', 'bb-powerpack' ),
				'fields'	=> array(
					'price_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight):not(.pp-pricing-table-highlight-price) .pp-pricing-table-column .pp-pricing-table-price',
							'property'		=> 'background-color',
						)
					),
					'price_color'  => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'bb-powerpack'),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight):not(.pp-pricing-table-highlight-price) .pp-pricing-table-column .pp-pricing-table-price',
							'property'		=> 'color',
						)
					),
					'duration_text_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __( 'Duration Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'        => '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight):not(.pp-pricing-table-highlight-price) .pp-pricing-table-column .pp-pricing-table-duration',
							'property'        => 'color',
						),
					),
					'price_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-price',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			),
			'features_style'	=> array(
				'title'	=> __( 'Items', 'bb-powerpack' ),
				'fields'	=> array(
					'features_min_height'   => array(
						'type'          => 'unit',
						'label'         => __('Items Min Height', 'bb-powerpack'),
						'default'       => '0',
						'units'			=> array('px'),
						'slider'		=> true,
						'help'          => __('Use this to normalize the height of your boxes when they have different numbers of items.', 'bb-powerpack'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-column .pp-pricing-table-features',
							'property'		=> 'min-height',
							'unit'			=> 'px'
						)
					),
					'even_features_background'  => array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Alternate Background Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-table-features li:nth-child(even)',
							'property'	=> 'background-color'
						)
					),
					'features_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'        => '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-table-features',
							'property'        => 'color',
						),
					),
					'features_border'    => array(
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
							'dashed'   => array(
								'fields'    => array('features_border_width', 'features_border_color')
							),
							'dotted'   => array(
								'fields'    => array('features_border_width', 'features_border_color')
							),
							'solid'   => array(
								'fields'    => array('features_border_width', 'features_border_color')
							),
						),
						'preview'           => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-bottom-style',
						)
					),
					'features_border_width'   => array(
						'type'              => 'unit',
						'label'             => __('Border Width', 'bb-powerpack'),
						'units'				=> array('px'),
						'slider'			=> true,
						'default'           => 1,
						'preview'           => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-bottom-width',
							'unit'		=> 'px'
						)
					),
					'features_border_color'   => array(
						'type'      => 'color',
						'label'     => __('Border Color', 'bb-powerpack'),
						'show_reset'   => true,
						'default'	=> 'dddddd',
						'connections'	=> array('color'),
						'preview'              => array(
							'type'				=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-color',
						)
					),
					'features_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '15',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix):not(.pp-pricing-table-highlight) .pp-pricing-table-column .pp-pricing-table-features',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			)
		),
	),
	'highlight_box_style'	=> array(
		'title'	=> __( 'Highlight', 'bb-powerpack' ),
		'sections'	=> array(
			'general'	=> array(
				'title'	=> '',
				'fields'	=> array(
					'highlight'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Highlight', 'bb-powerpack'),
						'default'       => 'none',
						'options'       => array(
							'none'       	=> __('None', 'bb-powerpack'),
							'title'       	=> __('Title', 'bb-powerpack'),
							'price'       	=> __('Price', 'bb-powerpack'),
							'package'     	=> __('Package', 'bb-powerpack')
						),
						'toggle'	=> array(
							'title'	=> array(
								'sections'	=> array('hl_title_style'),
								'fields'	=> array('hl_packages')
							),
							'price'	=> array(
								'sections'	=> array('hl_price_style'),
								'fields'	=> array('hl_packages')
							),
							'package'	=> array(
								'sections'	=> array( 'hl_box_style', 'hl_features_style', 'hl_title_style', 'hl_price_style', 'hl_featured_title_style' ),
								'fields'	=> array( 'hl_packages' ),
							)
						)
					),
					'hl_packages'   => array(
						'type'                 => 'select',
						'label'                => __('Highlight Package', 'bb-powerpack'),
						'default'              => 0,
						'options'              => array(
							0	=> __('Package 1', 'bb-powerpack'),
							1	=> __('Package 2', 'bb-powerpack'),
							2	=> __('Package 3', 'bb-powerpack'),
							3	=> __('Package 4', 'bb-powerpack'),
							4	=> __('Package 5', 'bb-powerpack'),
							5	=> __('Package 6', 'bb-powerpack'),
						),
					),
				)
			),
			'hl_box_style' => array(
				'title'	=> __( 'Package', 'bb-powerpack' ),
				'fields'	=> array(
					'hl_box_bg_color'      => array(
						'type'      => 'color',
						'label'     => __('Background Color', 'bb-powerpack'),
						'show_reset'   => true,
						'show_alpha'	=> true,
						'default'		=> 'f3f3f3',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column',
							'property'		=> 'background-color',
						)
					),
					'hl_box_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column',
                            'property'  	=> 'border',
                        ),
					),
					'hl_box_margin_top'	=> array(
						'type'		=> 'unit',
						'label'		=> __('Margin Top', 'bb-powerpack'),
						'units'		=> array( 'px' ),
						'slider'	=> true,
						'default'	=> 0,
						'preview'   => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column',
							'property'	=> 'margin-top',
							'unit'		=> 'px'
						)
					),
					'hl_box_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			),
			'hl_featured_title_style'	=> array(
				'title'	=> __( 'Featured Title', 'bb-powerpack' ),
				'fields'	=> array(
					'hl_featured_title_bg_color' => array(
						'type'              => 'color',
						'label'             => __('Background Color', 'bb-powerpack'),
						'default'           => 'cccccc',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-featured-title',
							'property'	=> 'background-color',
						)
					),
					'hl_featured_title_color'  => array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Text Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-featured-title',
							'property'	=> 'color'
						)
					),
				)
			),
			'hl_title_style'	=> array(
				'title'	=> __( 'Package Title', 'bb-powerpack' ),
				'fields'	=> array(
					'hl_title_bg_color' => array(
						'type'              => 'color',
						'label'             => __('Background Color', 'bb-powerpack'),
						'default'           => 'cccccc',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-title',
									'property'	=> 'background-color',
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-title .pp-pricing-table-column .pp-pricing-table-title',
									'property'	=> 'background-color',
								)
							)
						)
					),
					'hl_title_color'  => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'bb-powerpack'),
						'default'       => '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-title',
									'property'	=> 'color',
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-title .pp-pricing-table-column .pp-pricing-table-title',
									'property'	=> 'color',
								)
							)
						)
					),
				)
			),
			'hl_price_style'	=> array(
				'title'				=> __( 'Price', 'bb-powerpack' ),
				'fields'			=> array(
					'hl_price_bg_color' => array(
						'type'              => 'color',
						'label'             => __('Background Color', 'bb-powerpack'),
						'default'           => 'cccccc',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-price',
									'property'	=> 'background-color',
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-price .pp-pricing-table-column .pp-pricing-table-price',
									'property'	=> 'background-color',
								)
							)
						)
					),
					'hl_price_color'  => array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Text Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'preview'       => array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-price',
									'property'	=> 'color',
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-price .pp-pricing-table-column .pp-pricing-table-price',
									'property'	=> 'color',
								)
							)
						)
					),
					'hl_duration_color'  => array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Duration Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-duration',
									'property'	=> 'color',
								),
								array(
									'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-price .pp-pricing-table-column .pp-pricing-table-duration',
									'property'	=> 'color',
								)
							)
						)
					),
				)
			),
			'hl_features_style'	=> array(
				'title'	=> __( 'Items', 'bb-powerpack' ),
				'fields'	=> array(
					'hl_even_features_bg_color'  => array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Alternate Background Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features li:nth-child(even)',
							'property'	=> 'background-color'
						)
					),
					'hl_features_color'  => array(
						'type'          => 'color',
						'default'       => '',
						'label'         => __('Text Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features',
							'property'	=> 'color'
						)
					),
					'hl_features_border'    => array(
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
							'dashed'   => array(
								'fields'    => array('hl_features_border_width', 'hl_features_border_color')
							),
							'dotted'   => array(
								'fields'    => array('hl_features_border_width', 'hl_features_border_color')
							),
							'solid'   => array(
								'fields'    => array('hl_features_border_width', 'hl_features_border_color')
							),
						),
						'preview'           => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-bottom-style',
						)
					),
					'hl_features_border_width'   => array(
						'type'              => 'unit',
						'label'             => __('Border Width', 'bb-powerpack'),
						'units'      		=> array( 'px' ),
						'slider'            => true,
						'default'           => 1,
						'preview'           => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-bottom-width',
							'unit'		=> 'px'
						)
					),
					'hl_features_border_color'   => array(
						'type'      => 'color',
						'label'     => __('Border Color', 'bb-powerpack'),
						'show_reset'   => true,
						'default'	=> '',
						'connections'	=> array('color'),
						'preview'              => array(
							'type'		=> 'css',
							'selector'	=> '.pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features li',
							'property'	=> 'border-color',
						)
					),
				)
			),
		)
	),
	'typography'	=> array(
		'title'		=> __('Typography', 'bb-powerpack'),
		'sections'	=> array(
			'featured_title_typography'	=> array(
				'title'	=> __( 'Featured Title', 'bb-powerpack' ),
				'fields'	=> array(
					'featured_title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-featured-title',
						),
					),
				)
			),
			'title_typography'	=> array(
				'title'	=> __( 'Package Title', 'bb-powerpack' ),
				'fields'	=> array(
					'title_tag'		=> array(
						'type'		=> 'select',
						'label'		=> __('HTML Tag', 'bb-powerpack'),
						'options'	=> array(
							'h1'	=> 'H1',
							'h2'	=> 'H2',
							'h3'	=> 'H3',
							'h4'	=> 'H4',
							'h5'	=> 'H5',
							'h6'	=> 'H6',
						),
						'default'	=> 'h4',
						'help' 		=> __('Set the HTML tag for title output', 'bb-powerpack'),
					),
					'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-title',
						),
					),
				)
			),
			'price_typography'	=> array(
				'title'	=> __( 'Price', 'bb-powerpack' ),
				'fields'	=> array(
					'price_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-price',
						),
					),
					'duration_font_size' => array(
						'type'		=> 'pp-switch',
						'label'		=> __('Duration Font Size', 'bb-powerpack'),
						'default'	=> 'default',
						'options'       => array(
							'default'          => __('Default', 'bb-powerpack'),
							'custom'         => __('Custom', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('duration_custom_font_size')
							)
						),
					),
					'duration_custom_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Duration Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-duration',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
				)
			),
			'features_typography'	=> array(
				'title'	=> __( 'Items', 'bb-powerpack' ),
				'fields'	=> array(
					'features_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-column .pp-pricing-table-features',
						),
					),
				)
			),
			'button_typography'	=> array(
				'title'	=> __( 'Button', 'bb-powerpack' ),
				'fields'	=> array(
					'button_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-pricing-table .pp-pricing-table-column a.fl-button',
						),
					),
				)
			)
		)
	)
));

FLBuilder::register_settings_form('pp_pricing_column_form', array(
	'title' => __( 'Add Package', 'bb-powerpack' ),
	'tabs'  => array(
		'general'      => array(
			'title'         => __('General', 'bb-powerpack'),
			'sections'      => array(
				'general'	=> array(
					'title'	=> __('Featured Title', 'bb-powerpack'),
					'fields'	=> array(
						'hl_featured_title'          => array(
							'type'          => 'text',
							'label'         => __('Title', 'bb-powerpack'),
							'description'	=> __('Popular, Featured, etc.', 'bb-powerpack'),
							'connections'   => array( 'string', 'html', 'url' ),
						),
					)
				),
				'title'       => array(
					'title'         => __( 'Package Title', 'bb-powerpack' ),
					'fields'        => array(
						'title'          => array(
							'type'          => 'text',
							'label'         => __('Title', 'bb-powerpack'),
							'description'	=> __('Basic, Standard, Pro, etc.', 'bb-powerpack'),
							'connections'   => array( 'string', 'html', 'url' ),
						),
					),
				),
				'price-box'       => array(
					'title'         => __( 'Price Box', 'bb-powerpack' ),
					'fields'        => array(
						'price'          => array(
							'type'          => 'text',
							'label'         => __('Price', 'bb-powerpack'),
							'connections'   => array( 'string', 'html' ),
						),
						'duration'          => array(
							'type'          => 'text',
							'label'         => __('Duration', 'bb-powerpack'),
							'placeholder'   => __( 'per Month', 'bb-powerpack' ),
							'connections'   => array( 'string', 'html' ),
						),
						'price_2'          => array(
							'type'          => 'text',
							'label'         => __('Price 2', 'bb-powerpack'),
							'connections'   => array( 'string', 'html' ),
						),
						'duration_2'          => array(
							'type'          => 'text',
							'label'         => __('Duration 2', 'bb-powerpack'),
							'placeholder'   => __( 'per Year', 'bb-powerpack' ),
							'connections'   => array( 'string', 'html' ),
						),
					)
				),
			)
		),
		'items'	=> array(
			'title'		=> __('Items', 'bb-powerpack'),
			'sections'	=> array(
				'features'       => array(
					'title'         => _x( 'Items', 'items to be displayed in the pricing box.', 'bb-powerpack' ),
					'fields'        => array(
						'features'          => array(
							'type'          => 'text',
							'label'         => '',
							'placeholder'   => __( 'One item per line. HTML is okay.', 'bb-powerpack' ),
							'multiple'      => true
						)
					)
				)
			)
		),
		'button'      => array(
			'title'         => __('Button', 'bb-powerpack'),
			'sections'      => array(
				'default'   => array(
					'title'         => '',
					'fields'        => array(
						'button_text'   => array(
							'type'          => 'text',
							'label'         => __('Button Text', 'bb-powerpack'),
							'default'       => __('Get Started', 'bb-powerpack'),
							'connections'	=> array('string')
						),
						'button_url'    => array(
							'type'          => 'link',
							'label'         => __('Button URL', 'bb-powerpack'),
							'connections'   => array( 'url' ),
						),
						'button_url_2'    => array(
							'type'          => 'link',
							'label'         => __('Button URL 2', 'bb-powerpack'),
							'connections'   => array( 'url' ),
						),
						'btn_link_target'    	=> array(
							'type'          => 'pp-switch',
							'label'         => __('Link Target', 'bb-powerpack'),
							'default'       => '_self',
							'options'       => array(
								'_self'         => __('Same Window', 'bb-powerpack'),
								'_blank'        => __('New Window', 'bb-powerpack')
							),
							'preview'       => array(
								'type'          => 'none'
							)
						),
						'btn_link_nofollow' => array(
							'type'          	=> 'pp-switch',
							'label' 	        => __('Link No Follow', 'bb-powerpack'),
							'default'       => 'no',
							'options' 			=> array(
								'yes' 				=> __('Yes', 'bb-powerpack'),
								'no' 				=> __('No', 'bb-powerpack'),
							),
							'preview'       	=> array(
								'type'          	=> 'none'
							)
						),
						'btn_icon'      => array(
							'type'          => 'icon',
							'label'         => __('Button Icon', 'bb-powerpack'),
							'show_remove'   => true
						),
						'btn_icon_position' => array(
							'type'          => 'pp-switch',
							'label'         => __('Button Icon Position', 'bb-powerpack'),
							'default'       => 'before',
							'options'       => array(
								'before'        => __('Before Text', 'bb-powerpack'),
								'after'         => __('After Text', 'bb-powerpack')
							)
						),
						'btn_icon_animation' => array(
							'type'          => 'select',
							'label'         => __('Icon Visibility', 'bb-powerpack'),
							'default'       => 'disable',
							'options'       => array(
								'disable'        => __('Always Visible', 'bb-powerpack'),
								'enable'         => __('Fade In On Hover', 'bb-powerpack')
							)
						)
					)
				),
				'btn_colors'     => array(
					'title'         => __('Button Colors', 'bb-powerpack'),
					'fields'        => array(
						'btn_bg_color'  => array(
							'type'          => 'color',
							'label'         => __('Background Color', 'bb-powerpack'),
							'default'       => '',
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
						),
						'btn_bg_hover_color' => array(
							'type'          => 'color',
							'label'         => __('Background Hover Color', 'bb-powerpack'),
							'default'       => '',
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
						),
						'btn_text_color' => array(
							'type'          => 'color',
							'label'         => __('Text Color', 'bb-powerpack'),
							'default'       => '',
							'show_reset'    => true,
							'connections'	=> array('color'),
						),
						'btn_text_hover_color' => array(
							'type'          => 'color',
							'label'         => __('Text Hover Color', 'bb-powerpack'),
							'default'       => '',
							'show_reset'    => true,
							'connections'	=> array('color'),
						)
					)
				),
				'btn_style'     => array(
					'title'         => __('Button Style', 'bb-powerpack'),
					'fields'        => array(
						'btn_style'     => array(
							'type'          => 'pp-switch',
							'label'         => __('Style', 'bb-powerpack'),
							'default'       => 'flat',
							'options'       => array(
								'flat'          => __('Flat', 'bb-powerpack'),
								'gradient'      => __('Gradient', 'bb-powerpack'),
								'transparent'   => __('Transparent', 'bb-powerpack')
							),
							'toggle'        => array(
								'transparent'   => array(
									'fields'        => array('btn_bg_opacity', 'btn_bg_hover_opacity', 'btn_border_size')
								)
							)
						),
						'btn_border_size' => array(
							'type'          => 'unit',
							'label'         => __('Border Size', 'bb-powerpack'),
							'default'       => '2',
							'units'   		=> array( 'px' ),
							'slider'        => true,
							'placeholder'   => '0'
						),
						'btn_bg_opacity' => array(
							'type'          => 'text',
							'label'         => __('Background Opacity', 'bb-powerpack'),
							'default'       => '0',
							'description'   => '%',
							'maxlength'     => '3',
							'size'          => '5',
							'placeholder'   => '0'
						),
						'btn_bg_hover_opacity' => array(
							'type'          => 'text',
							'label'         => __('Background Hover Opacity', 'bb-powerpack'),
							'default'       => '0',
							'description'   => '%',
							'maxlength'     => '3',
							'size'          => '5',
							'placeholder'   => '0'
						),
						'btn_button_transition' => array(
							'type'          => 'pp-switch',
							'label'         => __('Transition', 'bb-powerpack'),
							'default'       => 'disable',
							'options'       => array(
								'disable'        => __('Disabled', 'bb-powerpack'),
								'enable'         => __('Enabled', 'bb-powerpack')
							)
						)
					)
				),
				'btn_structure' => array(
					'title'         => __('Button Structure', 'bb-powerpack'),
					'fields'        => array(
						'btn_width'     => array(
							'type'          => 'pp-switch',
							'label'         => __('Width', 'bb-powerpack'),
							'default'       => 'full',
							'options'       => array(
								'auto'          => _x( 'Auto', 'Width.', 'bb-powerpack' ),
								'full'          => __('Full Width', 'bb-powerpack')
							)
						),
						'btn_align'    	=> array(
							'type'          => 'align',
							'label'         => __('Alignment', 'bb-powerpack'),
							'default'       => 'center',
							'preview'       => array(
								'type'          => 'none'
							)
						),
						'button_padding'	=> array(
							'type'				=> 'dimension',
							'label'				=> __('Padding', 'bb-powerpack'),
							'default'			=> '10',
							'units'				=> array('px'),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.pp-pricing-table .pp-pricing-table-column a.fl-button',
								'property'			=> 'padding',
								'unit'				=> 'px'
							)
						),
						'button_margin'	=> array(
							'type'				=> 'dimension',
							'label'				=> __('Margin', 'bb-powerpack'),
							'default'			=> '0',
							'units'				=> array('px'),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.pp-pricing-table .pp-pricing-table-column a.fl-button',
								'property'			=> 'margin',
								'unit'				=> 'px'
							)
						),
						'btn_border_radius' => array(
							'type'          => 'unit',
							'label'         => __('Round Corners', 'bb-powerpack'),
							'default'       => '4',
							'units'			=> array('px'),
							'slider'		=> true,
						)
					)
				)
			)
		),
		'style'      => array(
			'title'         => __('Style', 'bb-powerpack'),
			'sections'      => array(
				'package_style'       => array(
					'title'         => __('Package', 'bb-powerpack'),
					'fields'        => array(
						'margin'        => array(
							'type'          => 'unit',
							'label'         => __('Package Top Margin', 'bb-powerpack'),
							'default'       => '0',
							'units'			=> array('px'),
							'slider'		=> true,
						),
						'package_bg_color'  => array(
							'type'          => 'color',
							'label'         => __('Package Background Color', 'bb-powerpack'),
							'default'       => '',
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
						),
					)
				),
			)
		)
	)
));
