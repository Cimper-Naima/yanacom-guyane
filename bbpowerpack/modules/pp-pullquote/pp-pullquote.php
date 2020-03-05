<?php

/**
 * @class PPQuoteModule
 */
class PPQuoteModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Pullquote', 'bb-powerpack'),
            'description'   => __('Addon to display quote.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'content' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-pullquote/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-pullquote/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
		));
		
		$this->add_css( BB_POWERPACK()->fa_css );
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPQuoteModule', array(
	'general'      => array( // Tab
		'title'         => __('General', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'pullquote_section' => array(
                'title'     => '',
                'fields'    => array(
                    'show_pullquote_icon'   => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Display Icon', 'bb-powerpack'),
                        'default'   => 'no',
                        'options'   => array(
                            'yes'    => __('Yes', 'bb-powerpack'),
                            'no'    => __('No', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    => array('pullquote_icon'),
                                'sections'    => array('pullquote_icon_styles'),
                            ),
                        )
                    ),
                    'pullquote_icon'    => array(
                        'type'      => 'icon',
                        'label'     => __('Icon', 'bb-powerpack'),
                    ),
                    'pullquote_content'   => array(
                        'type'  => 'textarea',
                        'label' => __('Quote', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'   => array(
                            'type'  => 'text',
                            'selector'  => '.pp-pullquote-content p'
                        ),
                    ),
                    'pullquote_title'   => array(
                        'type'  => 'text',
                        'label' => __('Name', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'   => array(
                            'type'  => 'text',
                            'selector'  => '.pp-pullquote-title h4'
                        ),
                    ),
                    'pullquote_alignment'   => array(
                        'type'  => 'pp-switch',
                        'label' => __('Alignment', 'bb-powerpack'),
                        'default'   => 'none',
                        'options'   => array(
                            'left'    => __('Left', 'bb-powerpack'),
                            'none'    => __('Center', 'bb-powerpack'),
                            'right'    => __('Right', 'bb-powerpack'),
                        ),
                    ),
                    'pullquote_width'   => array(
                        'type'      => 'text',
                        'label'     => __('Quote Width', 'bb-powerpack'),
                        'description'  => 'px',
                        'maxlength'     => 4,
                        'size'      => 5,
                        'default'   => 300,
                        'preview'   => array(
                            'selector'  => '.pp-quote-wrap .pp-pullquote-wrapper',
                            'property'  => 'max-width',
                            'unit'      => 'px'
                        ),
                    ),
                ),
            ),
		)
	),
    'styles'      => array( // Tab
		'title'         => __('Style', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
            'quote_styles'        => array(
                'title'     => __('Quote', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'quote_background'      => array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-pullquote-wrapper',
                            'property'  => 'background'
                        ),
                    ),
                    'quote_text_alignment'  => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Text Alignment', 'bb-powerpack'),
                        'default'   => 'center',
                        'options'   => array(
                            'left'    => __('Left', 'bb-powerpack'),
                            'center'    => __('Center', 'bb-powerpack'),
                            'right'    => __('Right', 'bb-powerpack'),
                        ),
                    ),
                    'quote_border_style'      => array(
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
                            'solid'     => array(
                                'fields'    => array('quote_border_width', 'quote_border_color'),
                            ),
                            'dotted'     => array(
                                'fields'    => array('quote_border_width', 'quote_border_color'),
                            ),
                            'dashed'     => array(
                                'fields'    => array('quote_border_width', 'quote_border_color'),
                            ),
                        ),
                    ),
                    'quote_border_width'    => array(
                        'type'      => 'pp-multitext',
                        'label'     => __('Border Width', 'bb-powerpack'),
                        'description'   => 'px',
                        'default'   => array(
                            'quote_border_top_width'    => 0,
                            'quote_border_bottom_width'    => 0,
                            'quote_border_left_width'    => 0,
                            'quote_border_right_width'    => 0,
                        ),
                        'options'   => array(
                            'quote_border_top_width'  => array(
                                'placeholder'       => __('Top', 'bb-powerpack'),
                                'maxlength'         => 3,
                                'icon'              => 'fa-long-arrow-up',
                                'tooltip'           => __('Top', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'border-top-width',
                                    'unit'          => 'px'
                                ),
                            ),
                            'quote_border_bottom_width'  => array(
                                'placeholder'       => __('Bottom', 'bb-powerpack'),
                                'maxlength'         => 3,
                                'icon'              => 'fa-long-arrow-down',
                                'tooltip'           => __('Bottom', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'border-bottom-width',
                                    'unit'          => 'px'
                                ),
                            ),
                            'quote_border_left_width'  => array(
                                'placeholder'       => __('Left', 'bb-powerpack'),
                                'maxlength'         => 3,
                                'icon'              => 'fa-long-arrow-left',
                                'tooltip'           => __('Left', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'border-left-width',
                                    'unit'          => 'px'
                                ),
                            ),
                            'quote_border_right_width'  => array(
                                'placeholder'       => __('Right', 'bb-powerpack'),
                                'maxlength'         => 3,
                                'icon'              => 'fa-long-arrow-right',
                                'tooltip'           => __('Right', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'border-right-width',
                                    'unit'          => 'px'
                                ),
                            ),
                        ),
                    ),
                    'quote_border_color'    => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-pullquote-wrapper',
                            'property'      => 'border-color',
                        )
					),
                    'quote_border_radius'    => array(
						'type'          => 'text',
                        'default'       => '0',
                        'maxlength'     => '3',
                        'size'          => '5',
						'label'         => __('Round Corners', 'bb-powerpack'),
                        'description'   => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-pullquote-wrapper',
                            'property'      => 'border-radius',
                            'unit'          => 'px'
                        )
					),
                    'quote_padding'     => array(
                        'type'      => 'pp-multitext',
                        'label'     => __('Padding', 'bb-powerpack'),
                        'description'   => 'px',
                        'default'       => array(
                            'quote_top_padding'     => 10,
                            'quote_bottom_padding'     => 10,
                            'quote_left_padding'     => 10,
                            'quote_right_padding'     => 10,
                        ),
                        'options'   => array(
                            'quote_top_padding'     => array(
                                'placeholder'       => __('Top', 'bb-powerpack'),
                                'maxlength'           => 3,
                                'icon'              => 'fa-long-arrow-up',
                                'tooltip'           => __('Top', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'padding-top',
                                    'unit'          => 'px'
                                ),
                            ),
                            'quote_bottom_padding'     => array(
                                'placeholder'       => __('Bottom', 'bb-powerpack'),
                                'maxlength'           => 3,
                                'icon'              => 'fa-long-arrow-down',
                                'tooltip'           => __('Bottom', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'padding-bottom',
                                    'unit'          => 'px'
                                ),
                            ),
                            'quote_left_padding'     => array(
                                'placeholder'       => __('Left', 'bb-powerpack'),
                                'maxlength'           => 3,
                                'icon'              => 'fa-long-arrow-left',
                                'tooltip'           => __('Left', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'padding-left',
                                    'unit'          => 'px'
                                ),
                            ),
                            'quote_right_padding'     => array(
                                'placeholder'       => __('Right', 'bb-powerpack'),
                                'maxlength'           => 3,
                                'icon'              => 'fa-long-arrow-right',
                                'tooltip'           => __('Right', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper',
                                    'property'      => 'padding-right',
                                    'unit'          => 'px'
                                ),
                            ),
                        ),
                    ),
				),
            ),
            'pullquote_icon_styles'     => array(
                'title'     => __('Icon', 'bb-powerpack'),
                'fields'    => array(
                    'icon_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-icon .pp-icon',
                            'property'  => 'color'
                        ),
                    ),
                    'icon_font_size'    => array(
                        'type'      => 'text',
                        'label'     => __('Size', 'bb-powerpack'),
                        'size'      => 5,
                        'maxlength' => 3,
                        'default'   => 16,
                        'description'   => 'px',
                        'preview'   => array(
                            'type'  => 'css',
                            'rules' => array(
                                array(
                                    'selector'  => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-icon .pp-icon',
                                    'property'  => 'font-size',
                                    'unit'  => 'px'
                                ),
                                array(
                                    'selector'  => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-icon .pp-icon:before',
                                    'property'  => 'font-size',
                                    'unit'  => 'px'
                                ),
                            )
                        ),
                    ),
                ),
            ),
		)
	),
    'typography'    => array(
        'title'     => __('Typography', 'bb-powerpack'),
        'sections'  => array(
            'title_typography'        => array(
                'title'     => __('Title', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'title_font'          => array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-powerpack'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4',
                            'property'      => 'font-family'
                        )
                    ),
                    'title_font_size'    => array(
						'type'          => 'pp-multitext',
						'label'         => __('Font Size', 'bb-powerpack'),
                        'default'       => array(
                            'title_font_size_desktop'   => 24,
                            'title_font_size_tablet'   => '',
                            'title_font_size_mobile'   => '',
                        ),
                        'options'       => array(
                            'title_font_size_desktop'   => array(
                                'placeholder'           => __('Desktop', 'bb-powerpack'),
                                'icon'                  => 'fa-desktop',
                                'tooltip'               => __('Desktop', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                            'title_font_size_tablet'   => array(
                                'placeholder'           => __('Tablet', 'bb-powerpack'),
                                'icon'                  => 'fa-tablet',
                                'tooltip'               => __('Tablet', 'bb-powerpack')
                            ),
                            'title_font_size_mobile'   => array(
                                'placeholder'           => __('Mobile', 'bb-powerpack'),
                                'icon'                  => 'fa-mobile',
                                'tooltip'               => __('Mobile', 'bb-powerpack')
                            ),
                        ),
					),
                    'title_line_height'    => array(
						'type'          => 'pp-multitext',
						'label'         => __('Line Height', 'bb-powerpack'),
                        'default'       => array(
                            'title_line_height_desktop'   => 1.6,
                            'title_line_height_tablet'   => '',
                            'title_line_height_mobile'   => '',
                        ),
                        'options'       => array(
                            'title_line_height_desktop'   => array(
                                'placeholder'           => __('Desktop', 'bb-powerpack'),
                                'icon'                  => 'fa-desktop',
                                'tooltip'               => __('Desktop', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4',
                                    'property'      => 'line-height',
                                ),
                            ),
                            'title_line_height_tablet'   => array(
                                'placeholder'           => __('Tablet', 'bb-powerpack'),
                                'icon'                  => 'fa-tablet',
                                'tooltip'               => __('Tablet', 'bb-powerpack')
                            ),
                            'title_line_height_mobile'   => array(
                                'placeholder'           => __('Mobile', 'bb-powerpack'),
                                'icon'                  => 'fa-mobile',
                                'tooltip'               => __('Mobile', 'bb-powerpack')
                            ),
                        ),
					),
                    'title_color'    => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4',
                            'property'      => 'color',
                        )
					),
				)
            ),
            'text_typography'        => array(
                'title'     => __('Text', 'bb-powerpack'),
                'fields'        => array( // Section Fields
                    'text_font'          => array(
						'type'          => 'font',
						'default'		=> array(
							'family'		=> 'Default',
							'weight'		=> 300
						),
						'label'         => __('Font', 'bb-powerpack'),
						'preview'         => array(
							'type'            => 'font',
                            'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p',
                            'property'      => 'font-family'
						)
					),
                    'text_font_size'    => array(
						'type'          => 'pp-multitext',
						'label'         => __('Font Size', 'bb-powerpack'),
                        'default'       => array(
                            'text_font_size_desktop'   => 18,
                            'text_font_size_tablet'   => '',
                            'text_font_size_mobile'   => '',
                        ),
                        'options'       => array(
                            'text_font_size_desktop'   => array(
                                'placeholder'           => __('Desktop', 'bb-powerpack'),
                                'icon'                  => 'fa-desktop',
                                'tooltip'               => __('Desktop', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                            'text_font_size_tablet'   => array(
                                'placeholder'           => __('Tablet', 'bb-powerpack'),
                                'icon'                  => 'fa-tablet',
                                'tooltip'               => __('Tablet', 'bb-powerpack')
                            ),
                            'text_font_size_mobile'   => array(
                                'placeholder'           => __('Mobile', 'bb-powerpack'),
                                'icon'                  => 'fa-mobile',
                                'tooltip'               => __('Mobile', 'bb-powerpack')
                            ),
                        ),
					),
                    'text_line_height'    => array(
						'type'          => 'pp-multitext',
						'label'         => __('Line Height', 'bb-powerpack'),
                        'default'       => array(
                            'text_line_height_desktop'   => 1.6,
                            'text_line_height_tablet'   => '',
                            'text_line_height_mobile'   => '',
                        ),
                        'options'       => array(
                            'text_line_height_desktop'   => array(
                                'placeholder'           => __('Desktop', 'bb-powerpack'),
                                'icon'                  => 'fa-desktop',
                                'tooltip'               => __('Desktop', 'bb-powerpack'),
                                'preview'           => array(
                                    'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p',
                                    'property'      => 'line-height',
                                ),
                            ),
                            'text_line_height_tablet'   => array(
                                'placeholder'           => __('Tablet', 'bb-powerpack'),
                                'icon'                  => 'fa-tablet',
                                'tooltip'               => __('Tablet', 'bb-powerpack')
                            ),
                            'text_line_height_mobile'   => array(
                                'placeholder'           => __('Mobile', 'bb-powerpack'),
                                'icon'                  => 'fa-mobile',
                                'tooltip'               => __('Mobile', 'bb-powerpack')
                            ),
                        ),
					),
                    'content_color'    => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p',
                            'property'      => 'color',
                        )
					),
                ),
            ),
        ),
    ),
));
