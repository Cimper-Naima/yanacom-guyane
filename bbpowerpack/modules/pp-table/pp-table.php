<?php

/**
 * @class PPTableModule
 */
class PPTableModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Table', 'bb-powerpack'),
            'description'   => __('A module for table.', 'bb-powerpack'),
			'group'			=> pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'content' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-table/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-table/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh' => true,
        ));

        $this->add_css( 'tablesaw' );
		$this->add_js( 'tablesaw' );
	}
	
	public function filter_settings( $settings, $helper ) {
		// Header old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'header_padding', 'padding', 'header_padding' );
		// Rows old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'rows_padding', 'padding', 'rows_padding' );

		// Handle Header's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'header_font'	=> array(
				'type'			=> 'font'
			),
			'header_custom_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->header_font_size ) && 'custom' == $settings->header_font_size )
			),
			'header_text_alignment'	=> array(
				'type'			=> 'text_align',
			),
			'header_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'header_typography' );
		// Handle Row's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'row_font'	=> array(
				'type'			=> 'font'
			),
			'row_custom_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->row_font_size ) && 'custom' == $settings->row_font_size )
			),
			'rows_text_alignment'	=> array(
				'type'			=> 'text_align',
			),
			'rows_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'row_typography' );
		
		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPTableModule', array(
	'general'		=> array(
		'title'			=> __('General', 'bb-powerpack'),
		'sections'		=> array(
			'general'		=> array(
				'title'			=> '',
				'fields'		=> array(
					'source'		=> array(
						'type'			=> 'select',
						'label'			=> __('Source', 'bb-powerpack'),
						'default'		=> 'manual',
						'options'		=> array(
							'manual'		=> __('Manual', 'bb-powerpack'),
							'csv_import'	=> __('CSV Import', 'bb-powerpack')
						),
						'toggle'		=> array(
							'manual'		=> array(
								'tabs'			=> array('header', 'row')
							),
							'csv_import'	=> array(
								'fields'		=> array('csv_import', 'first_row_header')
							)
						)
					),
					'csv_import'	=> array(
						'type'			=> 'pp-file',
						'label'			=> __('Upload CSV', 'bb-powerpack'),
						'default'		=> '',
						'accept'		=> '.csv',
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'first_row_header'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Make first row as Header?', 'bb-powerpack' ),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack' ),
							'no'				=> __( 'No', 'bb-powerpack' ),
						),
					),
				)
			),
			'sort'       	=> array(
                'title'         => __('Sortable Table', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'sortable'     => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Sort', 'bb-powerpack'),
                        'default'       => 'data-tablesaw-sortable data-tablesaw-sortable-switch',
                        'options'       => array(
                            'data-tablesaw-sortable data-tablesaw-sortable-switch'	=> __('Yes', 'bb-powerpack'),
                            ''    => __('No', 'bb-powerpack'),
                        ),
                    ),
                )
            ),
            'scroll'       => array(
                'title'         => __('Scrollable Table', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'scrollable'     => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Scroll', 'bb-powerpack'),
                        'default'       => 'swipe',
                        'options'       => array(
                            'swipe'     => __('Yes', 'bb-powerpack'),
                            'stack'     => __('No', 'bb-powerpack')
                        ),
                        'toggle'        => array(
                            'swipe'         => array(
                                'fields'        => array('custom_breakpoint')
                            )
                        ),
                        'help'         => __('This will disable stacking and enable swipe/scroll when below the breakpoint', 'bb-powerpack'),
                    ),
                    'custom_breakpoint' => array(
                        'type'              => 'unit',
                        'label'             => __('Define Custom Breakpoint', 'bb-powerpack'),
                        'default'           => '',
                        'slider'            => true,
                        'help'              => __('Devices equal or below the defined screen width will have this feature.', 'bb-powerpack')
                    )
                )
            ),
		)
	),
	'header'		=> array(
        'title'         => __('Table Headers', 'bb-powerpack'),
        'sections'      => array(
            'headers'       => array(
                'title'         => __('Column Headers', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'header'     => array(
                        'type'          => 'text',
                        'label'         => __('Header', 'bb-powerpack'),
                        'multiple'       => true,
                    ),
                )
            ),
        )
    ),
	'row'			=> array(
        'title'         => __('Table Rows', 'bb-powerpack'),
        'sections'      => array(
            'Cells'       => array(
                'title'         => __('Row Cells', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'rows'     => array(
                        'type'          => 'form',
                        'label'        => __('Row', 'bb-powerpack'),
                        'form'          => 'pp_content_table_row',
                        'preview_text'  => 'label',
                        'multiple'      => true
                    ),
                )
            ),

        )
    ),
	'style'			=> array(
		'title'	=> __( 'Style', 'bb-powerpack' ),
		'sections'	=> array(
			'header_style'	=> array(
				'title'	=> __('Header', 'bb-powerpack'),
				'fields'	=> array(
					'header_background'			=> array(
                        'type'          => 'color',
                        'default'          => '404040',
                        'label'         => __('Background Color', 'bb-powerpack'),
                        'help'          => __('Change the table header background color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content thead',
							'property'	=> 'background'
						)
                    ),
                    'header_border'				=> array(
                        'type'          => 'color',
                        'default'       => 'ffffff',
                        'label'         => __('Border Color', 'bb-powerpack'),
                        'help'          => __('Change the table header border color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-table-content thead tr:first-child th',
							'property'		=> 'border-right-color'
						)
                    ),
					'header_vertical_alignment'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Vertical Alignment', 'bb-powerpack'),
						'default'	=> 'middle',
						'options'       => array(
							'top'          => __('Top', 'bb-powerpack'),
							'middle'         => __('Center', 'bb-powerpack'),
							'bottom'         => __('Bottom', 'bb-powerpack'),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content thead tr th',
							'property'	=> 'vertical-align'
						)
					),
					'header_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-table-content thead tr th,
													.pp-table-content.tablesaw-sortable th.tablesaw-sortable-head,
													.pp-table-content.tablesaw-sortable tr:first-child th.tablesaw-sortable-head',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
				)
			),
			'row_style'	=> array(
				'title'		=> __( 'Rows', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'rows_background'     => array(
                        'type'          => 'color',
                        'default'          => 'ffffff',
                        'label'         => __('Background Color', 'bb-powerpack'),
                        'help'          => __('Change the table row background color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content tbody tr',
							'property'	=> 'background'
						)
                    ),
                    'rows_even_background'     => array(
                        'type'          => 'color',
                        'default'          => 'ffffff',
                        'label'         => __('Even Rows Background Color', 'bb-powerpack'),
                        'help'          => __('Change the tables even rows background color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content .even',
							'property'	=> 'background'
						)
                    ),
                    'rows_odd_background'     => array(
                        'type'          => 'color',
                        'default'          => 'ffffff',
                        'label'         => __('Odd Rows Background Color', 'bb-powerpack'),
                        'help'          => __('Change the tables odd rows background color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content .odd',
							'property'	=> 'background'
						)
                    ),
					'rows_vertical_alignment' => array(
						'type'		=> 'pp-switch',
						'label'		=> __('Vertical Alignment', 'bb-powerpack'),
						'default'	=> 'middle',
						'options'       => array(
							'top'          => __('Top', 'bb-powerpack'),
							'middle'         => __('Center', 'bb-powerpack'),
							'bottom'         => __('Bottom', 'bb-powerpack'),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content tbody tr td',
							'property'	=> 'vertical-align'
						)
					),
					'rows_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-table-content tbody tr td',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
				)
			),
			'cells_style'	=> array(
				'title'		=> __('Cell', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'cells_border' => array(
						'type'		=> 'pp-switch',
						'label'		=> __('Border', 'bb-powerpack'),
						'default'	=> 'default',
						'options'       => array(
							'default'          	=> __('Default', 'bb-powerpack'),
							'horizontal'        => __('Horizontal', 'bb-powerpack'),
							'vertical'         	=> __('Vertical', 'bb-powerpack'),
						),
					),
					'rows_border'     => array(
                        'type'          => 'color',
                        'default'       => 'efefef',
                        'label'         => __('Border Color', 'bb-powerpack'),
                        'help'          => __('Change the table row border color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-table-content tbody',
									'property'	=> 'border-top-color'
								),
								array(
									'selector'	=> '.pp-table-content tbody tr',
									'property'	=> 'border-bottom-color'
								),
								array(
									'selector'	=> '.pp-table-content tbody, .pp-table-content tbody tr td',
									'property'	=> 'border-left-color'
								),
								array(
									'selector'	=> '.pp-table-content tbody',
									'property'	=> 'border-right-color'
								),
							)
						)
                    ),
				)
			)
		)
	),
	'typography'	=> array(
		'title'	=> __('Typography', 'bb-powerpack'),
		'sections'	=> array(
			'header_typography'	=> array(
				'title'	=>	__('Header', 'bb-powerpack'),
				'fields'	=> array(
					'header_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-table-content thead tr th,
													.pp-table-content.tablesaw-sortable th.tablesaw-sortable-head,
													.pp-table-content.tablesaw-sortable tr:first-child th.tablesaw-sortable-head',
						),
					),
                    'header_font_color'     => array(
                        'type'          => 'color',
                        'default'       => 'ffffff',
						'label'         => __('Text Color', 'bb-powerpack'),
						'connections'	=> array('color'),
                        'help'          => __('Change the table header font color', 'bb-powerpack'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content thead tr th,
											.pp-table-content.tablesaw-sortable th.tablesaw-sortable-head,
											.pp-table-content.tablesaw-sortable tr:first-child th.tablesaw-sortable-head',
							'property'	=> 'color',
						)
                    ),
				)
			),
			'rows_typography'	=> array(
				'title'		=> __('Rows', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'row_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-table-content tbody tr td'
						),
					),
                    'rows_font_color'     => array(
                        'type'          => 'color',
                        'default'       => '',
                        'label'         => __('Text Color', 'bb-powerpack'),
                        'help'          => __('Change the table row text color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content tbody tr td',
							'property'	=> 'color'
						)
                    ),
                    'rows_font_even'     => array(
                        'type'          => 'color',
                        'default'       => '',
                        'label'         => __('Even Rows Text Color', 'bb-powerpack'),
                        'help'          => __('Change the tables even rows text color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content .even td',
							'property'	=> 'color'
						)
					),
                    'rows_font_odd'     => array(
                        'type'          => 'color',
                        'default'       => '',
						'label'         => __('Odd Rows Text Color', 'bb-powerpack'),
						'connections'	=> array('color'),
                        'help'          => __('Change the tables odd rows text color', 'bb-powerpack'),
						'show_reset'	=> true,
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-table-content .odd td',
							'property'	=> 'color'
						)
                    ),
				)
			)

		)
	)
));

FLBuilder::register_settings_form('pp_content_table_row', array(
	'title' => __('Row Settings', 'bb-powerpack'),
	'tabs'  => array(
        'general'	=> array( // Tab
			'title'         => __('Content', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
				'general'       => array(
					'title'     => '',
					'fields'    => array(
						'label'         => array(
							'type'          => 'text',
							'label'         => __('Row Label', 'bb-powerpack'),
							'help'          => __('A label to identify this panel on the Custom Panel tab.', 'bb-powerpack'),
							'connections'	=> array('string')
						),
                        'cell'         => array(
							'type'          => 'textarea',
							'label'         => __('Cell', 'bb-powerpack'),
                            'multiple'      => true,
						),
					)
				),

			)
		),
	)
));
