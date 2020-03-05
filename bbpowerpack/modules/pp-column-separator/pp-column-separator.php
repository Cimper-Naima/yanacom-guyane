<?php

/**
 * @class PPColumnSeparatorModule
 */
class PPColumnSeparatorModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Column Separator', 'bb-powerpack'),
            'description'   => __('Addon to add separators to the column.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-column-separator/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-column-separator/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true,
        ));

		$this->add_css(BB_POWERPACK()->fa_css);
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPColumnSeparatorModule', array(
	'general'      => array( // Tab
		'title'         => __('Separator', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'separator'      => array(
                'title'     => '',
                'fields'    => array(
                    'separator_type'    => array(
                        'type'      => 'select',
                        'label'     => __('Type', 'bb-powerpack'),
                        'default'   => 'none',
                        'options'   => array(
                            'none'  => __('None', 'bb-powerpack'),
                            'triangle'  => __('Big Triangle', 'bb-powerpack'),
                            'big_triangle_left'  => __('Big Triangle Side Left', 'bb-powerpack'),
                            'big_triangle_right'  => __('Big Triangle Side Right', 'bb-powerpack'),
                            'triangle_left_side'  => __('Triangle Side Left', 'bb-powerpack'),
                            'triangle_right_side'  => __('Triangle Side Right', 'bb-powerpack'),
                            'triangle_shadow'  => __('Big Triangle with Shadow', 'bb-powerpack'),
                            'triangle_left'  => __('Big Triangle Left', 'bb-powerpack'),
                            'triangle_right'  => __('Big Triangle Right', 'bb-powerpack'),
                            'triangle_small'  => __('Small Triangle', 'bb-powerpack'),
                            'tilt_left'  => __('Tilt Left', 'bb-powerpack'),
                            'tilt_right'  => __('Tilt Right', 'bb-powerpack'),
                            'curve'  => __('Curve', 'bb-powerpack'),
                            'zigzag'    => __('ZigZag', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'triangle'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'big_triangle_left'   => array(
                                'fields'    => array('separator_color', 'separator_height')
                            ),
                            'big_triangle_right'   => array(
                                'fields'    => array('separator_color', 'separator_height')
                            ),
                            'triangle_left_side'   => array(
                                'fields'    => array('separator_color', 'separator_height')
                            ),
                            'triangle_right_side'   => array(
                                'fields'    => array('separator_color', 'separator_height')
                            ),
                            'triangle_shadow'   => array(
                                'fields'    => array('separator_color', 'separator_shadow_color', 'separator_position', 'separator_height')
                            ),
                            'triangle_left'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'triangle_right'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'triangle_small'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'tilt_left'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'tilt_right'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'curve'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            ),
                            'zigzag'   => array(
                                'fields'    => array('separator_color', 'separator_position', 'separator_height')
                            )
                        ),
                    ),
                    'separator_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'		=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'rules'     => array(
                                array(
                                    'selector'  => '.pp-column-separator svg',
                                    'property'  => 'fill'
                                ),
                                array(
                                    'selector'  => '.pp-column-separator .pp-large-triangle-shadow .pp-main-color',
                                    'property'  => 'fill'
                                ),
                            ),
                        ),
                    ),
                    'separator_shadow_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Shadow Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'		=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'rules'     => array(
                                array(
                                    'selector'  => '.pp-column-separator .pp-large-triangle-shadow .pp-shadow-color',
                                    'property'  => 'fill'
                                ),
                            ),
                        ),
                    ),
                    'separator_position'    => array(
                        'type'      => 'select',
                        'label'     => __('Position', 'bb-powerpack'),
                        'default'   => 'top',
                        'options'   => array(
                            'top'   => __('Top', 'bb-powerpack'),
                            'bottom'   => __('Bottom', 'bb-powerpack'),
                        ),
                    ),
                    'separator_height'    => array(
                        'type'      => 'text',
                        'label'     => __('Height', 'bb-powerpack'),
                        'size'      => '5',
                        'maxlength'     => '3',
                        'default'       => '100',
                        'description'   => 'px',
                        'preview'       => array(
                            'type'      => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.pp-column-separator .pp-zigzag:after',
                                    'property'      => 'height',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-column-separator svg.pp-side-triangle',
                                    'property'      => 'width',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-column-separator .pp-zigzag:before',
                                    'property'      => 'height',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'  => '.pp-column-separator .pp-zigzag:before',
                                    'property'  => 'top',
                                    'unit'          => 'px'
                                ),
                            ),
                        ),
                    ),
                ),
            ),
		)
	),
));
