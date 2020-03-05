<?php
/**
 * @class PPHowTo
 */
class PPHowToModule extends FLBuilderModule {

	/**
	 * Constructor function for the module. You must pass the
	 * name, description, dir and url in an array to the parent class.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'How To', 'bb-powerpack' ),
				'description'     => __( 'Addon to display How To.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-how-to/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-how-to/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);
	}
}


/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPHowToModule',
	array(
		'general'        => array(
			'title'    => __( 'General', 'bb-powerpack' ),
			'sections' => array(
				'general'         => array(
					'title'  => 'General',
					'fields' => array(
						'title'         => array(
							'type'  => 'text',
							'label' => __( 'Title', 'bb-powerpack' ),
						),
						'description'   => array(
							'type'        => 'editor',
							'label'       => '',
							'rows'        => 2,
							'connections' => array( 'string', 'html', 'url' ),
						),
						'image'         => array(
							'type'        => 'photo',
							'label'       => __( 'Image', 'bb-powerpack' ),
							'show_remove' => true,
							'connections' => array( 'photo' ),
						),
						'show_advanced' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Advanced Options', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'sections' => array( 'advanced_option', 'advanced_style', 'advanced_typography' ),
								),
							),
						),
					),
				),
				'advanced_option' => array(
					'title'     => __( 'Advanced Options', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'total_time_text'     => array(
							'type'    => 'text',
							'label'   => __( 'Total Time Text', 'bb-powerpack' ),
							'default' => 'Time Needed:',
						),
						'total_time'          => array(
							'type'  => 'unit',
							'label' => __( 'Total Time', 'bb-powerpack' ),
							'units' => array( 'minutes' ),
							'help'  => __( 'How much time this process will take in Minutes.', 'bb-powerpack' ),
						),
						'estimated_cost_text' => array(
							'type'    => 'text',
							'label'   => __( 'Estimated Cost Text', 'bb-powerpack' ),
							'default' => 'Total Cost:',
						),
						'estimated_cost'      => array(
							'type'  => 'unit',
							'label' => __( 'Estimated cost', 'bb-powerpack' ),
							'help'  => __( 'How much Cost of this.', 'bb-powerpack' ),
						),
						'currency_iso_code'   => array(
							'type'        => 'text',
							'label'       => __( 'Currency ISO Code', 'bb-powerpack' ),
							'default'     => 'USD',
							'size'        => 5,
							'description' => __( 'For your country ISO code <a href="https://en.wikipedia.org/wiki/List_of_circulating_currencies" target="_blank" rel="noopener"><b style="color: #0000ff;">Click here</b></a>', 'bb-powerpack' ),
						),
						'add_supply'          => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Add Supply', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'supply_title', 'pp_supply', 'supply_title_color', 'supply_title_margin', 'supply_text_color', 'supply_text_margin', 'supply_title_typography', 'supply_text_typography' ),
								),
							),
						),
						'supply_title'        => array(
							'type'  => 'text',
							'label' => __( 'Supply Title', 'bb-powerpack' ),
						),
						'pp_supply'           => array(
							'type'     => 'text',
							'label'    => __( 'Supply', 'bb-powerpack' ),
							'multiple' => true,
						),
						'add_tool'            => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Add Tools', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'tool_title', 'pp_tool', 'tool_title_color', 'tool_title_margin', 'tool_text_color', 'tool_text_margin', 'tool_title_typography', 'tool_text_typography' ),
								),
							),
						),
						'tool_title'          => array(
							'type'  => 'text',
							'label' => __( 'Tool Title', 'bb-powerpack' ),
						),
						'pp_tool'             => array(
							'type'     => 'text',
							'label'    => __( 'Tool', 'bb-powerpack' ),
							'multiple' => true,
						),
					),
				),
				'step_form'       => array(
					'title'     => __( 'Steps', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'step_section_title' => array(
							'type'  => 'text',
							'label' => __( 'Section Title', 'bb-powerpack' ),
						),
						'step_data'          => array(
							'type'         => 'form',
							'label'        => __( 'Add Steps', 'bb-powerpack' ),
							'form'         => 'pp_how_to_steps',
							'preview_text' => 'step_title',
							'multiple'     => true,
						),
					),
				),
			),
		),
		'style_tab'      => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'box_style'         => array(
					'title'  => __( 'Box Style', 'bb-powerpack' ),
					'fields' => array(
						'box_align'    => array(
							'type'    => 'align',
							'label'   => __( 'Alignment', 'bb-powerpack' ),
							'default' => 'left',
						),
						'box_bg_color' => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'default'     => 'dddddd',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-container',
								'property' => 'background-color',
							),
						),
						'box_padding'  => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-container',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'box_border'   => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-container',
								'property' => 'border',
							),
						),
					),
				),
				'title_style'       => array(
					'title'     => __( 'Title', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'title_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-title',
								'property' => 'color',
							),
						),
						'title_margin' => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-title',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
					),
				),
				'description_style' => array(
					'title'     => __( 'Description', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'description_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-description',
								'property' => 'color',
							),
						),
						'description_margin' => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-description',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
					),
				),
				'image_style'       => array(
					'title'     => __( 'Image', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'image_width'   => array(
							'type'       => 'unit',
							'label'      => __( 'Width', 'bb-powerpack' ),
							'default'    => '',
							'units'      => array( 'px', '%' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-image img',
								'property' => 'width',
							),
						),
						'image_align'   => array(
							'type'    => 'align',
							'label'   => __( 'Alignment', 'bb-powerpack' ),
							'default' => '',
						),
						'image_padding' => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-image',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'image_border'  => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-image img',
								'property' => 'border',
							),
						),
					),
				),
				'advanced_style'    => array(
					'title'     => __( 'Advanced Options', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'total_time_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Total Time Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-total-time',
								'property' => 'color',
							),
						),
						'total_time_margin'     => array(
							'type'       => 'unit',
							'label'      => __( 'Total Time Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-total-time',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'estimated_cost_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Estimated Cost Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-estimated-cost',
								'property' => 'color',
							),
						),
						'estimated_cost_margin' => array(
							'type'       => 'unit',
							'label'      => __( 'Estimated Cost Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-estimated-cost',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'supply_title_color'    => array(
							'type'        => 'color',
							'label'       => __( 'Supply Title Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-supply-title',
								'property' => 'color',
							),
						),
						'supply_title_margin'   => array(
							'type'       => 'unit',
							'label'      => __( 'Supply Title Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-supply-title',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'supply_text_color'     => array(
							'type'        => 'color',
							'label'       => __( 'Supply Text Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-supply',
								'property' => 'color',
							),
						),
						'supply_text_margin'    => array(
							'type'       => 'unit',
							'label'      => __( 'Supply Text Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-supply',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'tool_title_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Tool Title Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-tool-title',
								'property' => 'color',
							),
						),
						'tool_title_margin'     => array(
							'type'       => 'unit',
							'label'      => __( 'Tool Title Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-tool-title',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'tool_text_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Tool Text Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-tool',
								'property' => 'color',
							),
						),
						'tool_text_margin'      => array(
							'type'       => 'unit',
							'label'      => __( 'Tool Text Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-tool',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
					),
				),
				'step_style'        => array(
					'title'     => __( 'Steps', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'step_section_title_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Section Title Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-section-title',
								'property' => 'color',
							),
						),
						'step_section_title_margin' => array(
							'type'       => 'unit',
							'label'      => __( 'Section Title Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-section-title',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'steps_spacing'             => array(
							'type'       => 'unit',
							'label'      => __( 'Steps Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
						'step_image_width'          => array(
							'type'       => 'unit',
							'label'      => __( 'Image Width', 'bb-powerpack' ),
							'default'    => '30',
							'units'      => array( '%' ),
							'slider'     => true,
							'responsive' => true,
						),
						'step_image_spacing'        => array(
							'type'       => 'unit',
							'label'      => __( 'Image Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'step_title_color'          => array(
							'type'        => 'color',
							'label'       => __( 'Step Title Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-title',
								'property' => 'color',
							),
						),
						'step_title_margin'         => array(
							'type'       => 'unit',
							'label'      => __( 'Step Title Margin Bottom', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'step_description_color'    => array(
							'type'        => 'color',
							'label'       => __( 'Step Description Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-description',
								'property' => 'color',
							),
						),
					),
				),
			),
		),
		'typography_tab' => array(
			'title'    => __( 'Typography', 'bb-powerpack' ),
			'sections' => array(
				'title_typography'       => array(
					'title'     => __( 'Title', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'title_tag'				=> array(
							'type'					=> 'select',
							'label'					=> __('HTML Tag', 'bb-powerpack'),
							'default'				=> 'h1',
							'options'				=> array(
								'h1'					=> 'H1',
								'h2'					=> 'H2',
								'h3'					=> 'H3',
								'h4'					=> 'H4',
								'h5'					=> 'H5',
								'h6'					=> 'H6'
							),
						),
						'title_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-title',
							),
						),
					),
				),
				'description_typography' => array(
					'title'     => __( 'Description', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'description_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-description p, .pp-how-to-description a',
							),
						),
					),
				),
				'advanced_typography'    => array(
					'title'     => __( 'Advanced Options', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'total_time_typography'     => array(
							'type'       => 'typography',
							'label'      => __( 'Total Time Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-total-time',
							),
						),
						'estimated_cost_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Estimated Cost Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-estimated-cost',
							),
						),
						'supply_title_tag'				=> array(
							'type'					=> 'select',
							'label'					=> __('Supply Title HTML Tag', 'bb-powerpack'),
							'default'				=> 'h3',
							'options'				=> array(
								'h1'					=> 'H1',
								'h2'					=> 'H2',
								'h3'					=> 'H3',
								'h4'					=> 'H4',
								'h5'					=> 'H5',
								'h6'					=> 'H6'
							),
						),
						'supply_title_typography'   => array(
							'type'       => 'typography',
							'label'      => __( 'Supply Title Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-supply-title',
							),
						),
						'supply_text_typography'    => array(
							'type'       => 'typography',
							'label'      => __( 'Supply Text Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-supply',
							),
						),
						'tool_title_tag'				=> array(
							'type'					=> 'select',
							'label'					=> __('Tool Title HTML Tag', 'bb-powerpack'),
							'default'				=> 'h3',
							'options'				=> array(
								'h1'					=> 'H1',
								'h2'					=> 'H2',
								'h3'					=> 'H3',
								'h4'					=> 'H4',
								'h5'					=> 'H5',
								'h6'					=> 'H6'
							),
						),
						'tool_title_typography'     => array(
							'type'       => 'typography',
							'label'      => __( 'Tool Title Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-tool-title',
							),
						),
						'tool_text_typography'      => array(
							'type'       => 'typography',
							'label'      => __( 'Tool Text Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-tool',
							),
						),
					),
				),
				'step_typography'        => array(
					'title'     => __( 'Steps', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'step_section_title_tag'				=> array(
							'type'					=> 'select',
							'label'					=> __('Step Section Title HTML Tag', 'bb-powerpack'),
							'default'				=> 'h3',
							'options'				=> array(
								'h1'					=> 'H1',
								'h2'					=> 'H2',
								'h3'					=> 'H3',
								'h4'					=> 'H4',
								'h5'					=> 'H5',
								'h6'					=> 'H6'
							),
						),
						'step_section_title_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Section Title Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-section-title',
							),
						),
						'step_title_typography'         => array(
							'type'       => 'typography',
							'label'      => __( 'Step Title Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-title',
							),
						),
						'step_description_typography'   => array(
							'type'       => 'typography',
							'label'      => __( 'Step Description Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-how-to-step-description',
							),
						),
					),
				),
			),
		),
	)
);
/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form(
	'pp_how_to_steps',
	array(
		'title' => __( 'Add Step', 'bb-powerpack' ),
		'tabs'  => array(
			'step_general' => array(
				'title'    => __( 'Step', 'bb-powerpack' ),
				'sections' => array(
					'step_general' => array(
						'title'  => '',
						'fields' => array(
							'step_title'       => array(
								'type'  => 'text',
								'label' => __( 'Title', 'bb-powerpack' ),
							),
							'step_description' => array(
								'type'        => 'editor',
								'label'       => __( 'Description' ),
								'rows'        => 2,
								'connections' => array( 'string', 'html', 'url' ),
							),
							'step_image'       => array(
								'type'        => 'photo',
								'label'       => __( 'Image', 'bb-powerpack' ),
								'show_remove' => true,
								'connections' => array( 'photo' ),
							),
							'step_link'        => array(
								'type'          => 'link',
								'label'         => __( 'Link', 'bb-powerpack' ),
								'connections'   => array( 'url' ),
								'show_target'   => true,
								'show_nofollow' => true,
							),
						),
					),
				),
			),
		),
	)
);
