<?php

/**
 * @class PPDotNavModule
 */
class PPDotNavModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Dot / One Page Navigation', 'bb-powerpack'),
            'description'   => __('A beautiful one page dot navigation.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-dotnav/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-dotnav/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }

    public function get_dot_html()
    {
        if('' == trim($this->settings->row_ids)) {
            return;
        }

        $row_ids = preg_split('/\r\n|\n|\r/', trim($this->settings->row_ids));
        $html = '';
        $count = 0;
        $prev = '';

        foreach($row_ids as $row_id){
            $count++;
            $row    = explode(':', $row_id);
            $id     = isset($row[0]) ? trim($row[0]) : '';
            $title  = isset($row[1]) ? trim($row[1]) : '';
            $last   = (count($row_ids) == $count) ? 'pp-last' : '';

            $html .= '<li class="pp-dot '.$last.'">';
            $html .= '<a href="#" data-row-id="'.$id.'" data-prev-row-id="'.$prev.'">';
            $html .= '<span class="pp-dot-circle"></span>';
            if('enable' == $this->settings->dot_label && '' != $title) {
                $html .= '<span class="pp-label">'.$title.'</span>';
            }
            $html .= '</a>';
            $html .= '</li>';

            $prev = $id;
        }

        return $html;
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPDotNavModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'row_ids'       => array(
                        'type'          => 'textarea',
                        'label'         => __('Row IDs', 'bb-powerpack'),
                        'default'       => '',
                        'placeholder'   => __('row_id : your title', 'bb-powerpack'),
                        'rows'          => '6',
                        'help'          => __('Enter the combination of id and title of each row in new line. Please use the following format - row_id : your title. Row IDs must be unique.', 'bb-powerpack')
                    ),
                    'top_offset'   => array(
                        'type'          => 'unit',
                        'label'         => __('Row Top Offset', 'bb-powerpack'),
                        'default'       => 0,
                        'units'   		=> array( 'px' ),
                        'help'          => __('If your theme uses a sticky header, then please enter the header height in px (numbers only) to avoid overlapping of row content.', 'bb-powerpack')
                    ),
                    'scroll_speed'   => array(
                        'type'          => 'text',
                        'label'         => __('Scroll Speed', 'bb-powerpack'),
                        'default'       => 500,
                        'description'   => 'ms',
                        'class'         => 'input-small'
                    ),
                    'scroll_wheel'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Scroll Wheel', 'bb-powerpack'),
                        'default'       => 'disable',
                        'options'       => array(
                            'enable'        => __('Enable', 'bb-powerpack'),
                            'disable'       => __('Disable', 'bb-powerpack')
                        ),
                        'toggle'        => array(
                            'enable'        => array(
                                'fields'        => array('scroll_touch')
                            )
                        ),
                        'preview'       => array(
                            'type'          => 'none'
                        ),
                        'help'          => __('By enabling this option, mouse wheel will be used to navigate from one row to another.', 'bb-powerpack')
                    ),
                    'scroll_touch'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Touch Swipe', 'bb-powerpack'),
                        'default'       => 'enable',
                        'options'       => array(
                            'enable'        => __('Enable', 'bb-powerpack'),
                            'disable'       => __('Disable', 'bb-powerpack')
                        ),
                        'preview'       => array(
                            'type'          => 'none'
                        ),
                        'help'          => __('By enabling this option, touch swipe will be used to navigate from one row to another in mobile devices.', 'bb-powerpack')
                    ),
                    'scroll_keys'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Scroll Keys', 'bb-powerpack'),
                        'default'       => 'disable',
                        'options'       => array(
                            'enable'        => __('Enable', 'bb-powerpack'),
                            'disable'       => __('Disable', 'bb-powerpack')
                        ),
                        'preview'       => array(
                            'type'          => 'none'
                        ),
                        'help'          => __('By enabling this option, UP and DOWN arrow keys will be used to navigate from one row to another.', 'bb-powerpack')
                    ),
                    'dot_label'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Labels', 'bb-powerpack'),
                        'default'       => 'enable',
                        'options'       => array(
                            'enable'        => __('Enable', 'bb-powerpack'),
                            'disable'       => __('Disable', 'bb-powerpack')
                        ),
                        'preview'       => array(
                            'type'          => 'none'
                        ),
                        'help'          => __('Enable this option to display labels on hover for the dots.', 'bb-powerpack')
                    )
                )
            )
        )
    ),
    'style'       => array( // Tab
        'title'         => __('Style', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'dot_style'     => array( // Section
                'title'         => __('Dot', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'dot_position'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Position', 'bb-powerpack'),
                        'default'       => 'right',
                        'options'       => array(
                            'left'          => __('Left', 'bb-powerpack'),
                            'right'         => __('Right', 'bb-powerpack')
                        )
                    ),
                    'dot_color'      => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '',
                        'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-dotnav .pp-dot .pp-dot-circle',
                            'property'      => 'background-color'
                        )
                    ),
                    'dot_color_hover' => array(
                        'type'          => 'color',
                        'label'         => __('Color Hover', 'bb-powerpack'),
                        'default'       => 'ffffff',
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                    ),
                    'dot_color_active' => array(
                        'type'          => 'color',
                        'label'         => __('Color Active', 'bb-powerpack'),
                        'default'       => 'ffffff',
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-dotnav .pp-dot.active .pp-dot-circle',
                            'property'      => 'background-color'
                        )
                    ),
                    'dot_border_width'  => array(
                        'type'              => 'unit',
                        'label'             => __('Border Width', 'bb-powerpack'),
                        'default'           => 1,
                        'units'       		=> array( 'px' ),
                        'slider'             => true,
                        'preview'           => array(
                            'type'              => 'css',
                            'selector'          => '.pp-dotnav .pp-dot .pp-dot-circle',
                            'property'          => 'border-width',
                            'unit'              => 'px'
                        )
                    ),
                    'dot_border_color'  => array(
                        'type'              => 'color',
                        'label'             => __('Border Color', 'bb-powerpack'),
                        'default'           => 'f4f4f4',
						'show_reset'        => true,
						'connections'		=> array('color'),
                        'preview'           => array(
                            'type'              => 'css',
                            'selector'          => '.pp-dotnav .pp-dot .pp-dot-circle',
                            'property'          => 'border-color'
                        )
                    ),
                    'dot_border_color_hover'  => array(
                        'type'              => 'color',
                        'label'             => __('Border Color Hover', 'bb-powerpack'),
                        'default'           => 'f4f4f4',
						'show_reset'        => true,
						'connections'		=> array('color'),
                    ),
                    'dot_border_color_active'  => array(
                        'type'              => 'color',
                        'label'             => __('Border Color Active', 'bb-powerpack'),
                        'default'           => 'f4f4f4',
						'show_reset'        => true,
						'connections'		=> array('color'),
                        'preview'           => array(
                            'type'              => 'css',
                            'selector'          => '.pp-dotnav .pp-dot.active .pp-dot-circle',
                            'property'          => 'border-color'
                        )
                    ),
                    'dot_size'   => array(
                        'type'          => 'unit',
                        'label'         => __('Size', 'bb-powerpack'),
                        'default'       => 14,
                        'units'       	=> array( 'px' ),
                        'slider'        => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'         => array(
                                array(
                                    'selector'      => '.pp-dotnav .pp-dot .pp-dot-circle',
                                    'property'      => 'width',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-dotnav .pp-dot .pp-dot-circle',
                                    'property'      => 'height',
                                    'unit'          => 'px'
                                )
                            )
                        )
                    ),
                    'dot_margin'    => array(
                        'type'          => 'unit',
                        'label'         => __('Margin', 'bb-powerpack'),
                        'default'       => 12,
                        'units'       	=> array( 'px' ),
                        'slider'        => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'         => array(
                                array(
                                    'selector'      => '.pp-dotnav .pp-dot',
                                    'property'      => 'margin-top',
                                    'unit'          => 'px'
                                ),
                                array(
                                    'selector'      => '.pp-dotnav .pp-dot',
                                    'property'      => 'margin-bottom',
                                    'unit'          => 'px'
                                )
                            )
                        )
                    ),
                    'dot_hide_on'    => array(
                        'type'          => 'unit',
                        'label'         => __('Hide on breakpoint', 'bb-powerpack'),
                        'default'       => 768,
                        'units'       		=> array( 'px' ),
                        'slider'             => true,
                    )
                )
            ),
            'dot_label_style' => array( // Section
                'title'         => __('Labels', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'dot_label_color'   => array(
                        'type'              => 'color',
                        'label'             => __('Background Color', 'bb-powerpack'),
                        'default'           => 'ffffff',
                        'show_reset'        => true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
                    ),
                    'dot_label_text'    => array(
                        'type'              => 'color',
                        'label'             => __('Text Color', 'bb-powerpack'),
						'default'           => '444444',
						'connections'		=> array('color'),
                    )
                )
            )
        )
    )
));
