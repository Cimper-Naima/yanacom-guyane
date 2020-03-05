<?php

/**
 * @class PPAnimatedHeadlines2Module
 */
class PPAnimatedHeadlinesModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Animated Headlines', 'bb-powerpack'),
			'description'   => __('Awesome Animated Headlines module.', 'bb-powerpack'),
			'group'         => pp_get_modules_group(),
			'category'      => pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-animated-headlines/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-animated-headlines/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
		));
	}
	
	public function update( $settings )
	{
		$rotating_text 		= $settings->rotating_text;
		$highlighted_text 	= $settings->highlighted_text;

		$settings->rotating_text 	= htmlspecialchars( $rotating_text );
		$settings->highlighted_text = htmlspecialchars( $highlighted_text );

		return $settings;
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle old headline typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'font_family'	=> array(
				'type'			=> 'font'
			),
			'font_size_custom'	=> array(
				'type'				=> 'font_size',
				'condition'			=> ( isset( $settings->font_size ) && 'custom' == $settings->font_size )
			),
			'line_height_custom'	=> array(
				'type'					=> 'line_height',
				'condition'				=> ( isset( $settings->line_height ) && 'custom' == $settings->line_height )
			),
		), 'headline_typography' );

		// Handle old animated text typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'animated_font_family'		=> array(
				'type'						=> 'font'
			),
			'animated_font_size_custom'	=> array(
				'type'						=> 'font_size',
				'condition'					=> ( isset( $settings->animated_font_size ) && 'custom' == $settings->animated_font_size )
			),
			'animated_line_height_custom'	=> array(
				'type'							=> 'line_height',
				'condition'						=> ( isset( $settings->animated_line_height ) && 'custom' == $settings->animated_line_height )
			),
		), 'animated_typography' );
		
		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPAnimatedHeadlinesModule', array(
	'general'       => array(
		'title'         => __('General', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'headline_style'	=> array(
						'type'			=> 'select',
						'label'			=> __('Style', 'bb-powerpack'),
						'default'		=> 'highlight',
						'options'		=> array(
							'highlight'		=> __('Highlighted', 'bb-powerpack'),
							'rotate'		=> __('Rotating', 'bb-powerpack')
						),
						'toggle'		=> array(
							'highlight'		=> array(
								'tabs'			=> array('style'),
								'fields'		=> array('headline_shape', 'highlighted_text', 'loop')
							),
							'rotate'		=> array(
								'fields'		=> array('rotating_text', 'animation_type')
							)
						)
					),
					'headline_shape'	=> array(
						'type'				=> 'select',
						'label'				=> __('Shape', 'bb-powerpack'),
						'default'			=> 'circle',
						'options'			=> array(
							'circle'			=> __('Circle', 'bb-powerpack'),
							'curly'				=> __('Curly', 'bb-powerpack'),
							'strikethrough'		=> __('Strikethrough', 'bb-powerpack'),
							'underline'			=> __('Underline', 'bb-powerpack'),
							'underline_zigzag'	=> __('Underline Zigzag', 'bb-powerpack'),
						)
					),
					'animation_type'	=> array(
						'type'				=> 'select',
						'label'				=> __('Animation', 'bb-powerpack'),
						'default'			=> 'typing',
						'options'			=> array(
							'typing' 			=> __('Typing', 'bb-powerpack'),
							'clip' 				=> __('Clip', 'bb-powerpack'),
							'flip' 				=> __('Flip', 'bb-powerpack'),
							'swirl' 			=> __('Swirl', 'bb-powerpack'),
							'blinds' 			=> __('Blinds', 'bb-powerpack'),
							'drop-in' 			=> __('Drop-in', 'bb-powerpack'),
							'wave' 				=> __('Wave', 'bb-powerpack'),
							'slide' 			=> __('Slide', 'bb-powerpack'),
							'slide-down' 		=> __('Slide Down', 'bb-powerpack'),
						),
						'toggle'			=> array(
							'typing'			=> array(
								'fields'			=> array('animated_selection_bg_color', 'animated_selection_color')
							)
						)
					),
					'before_text'  	=> array(
						'type'          => 'text',
						'label'         => __('Before Text', 'bb-powerpack'),
						'default'       => __('This is', 'bb-powerpack'),
						'help'			=> __('Text placed before animated text.', 'bb-powerpack'),
						'connections'   => array( 'string', 'html', 'url' ),
					),
					'highlighted_text'	=> array(
						'type'				=> 'text',
						'label'				=> __('Highlighted Text', 'bb-powerpack'),
						'default'			=> __('Awesome', 'bb-powerpack'),
						'connections'   	=> array( 'string', 'html', 'url' ),
					),
					'rotating_text'	=> array(
						'type'          => 'textarea',
						'label'         => __('Rotating Text', 'bb-powerpack'),
						'default'       => __("Awesome\nCreative\nRotating", 'bb-powerpack'),
						'rows'          => '5',
						'help'			=> __('Text with animated effects. You can add multiple text by adding each on a new line.', 'bb-powerpack'),
						'connections'   => array( 'string', 'html', 'url' ),
					),
					'after_text'	=> array(
						'type'           => 'text',
						'label'          => __('After Text', 'bb-powerpack'),
						'default'        => __('Headline!', 'bb-powerpack'),
						'help'			 => __('Text placed at the end of animated text.', 'bb-powerpack'),
						'connections'   => array( 'string', 'html', 'url' ),
					),
					'alignment'     => array(
						'type'          => 'align',
						'label'         => __('Alignment', 'bb-powerpack'),
						'default'       => 'left',
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.pp-headline',
							'property'        => 'text-align'
						),
					),
					'loop'		=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Loop', 'bb-powerpack'),
						'default'	=> 'yes',
						'options'	=> array(
							'yes'		=> __('Yes', 'bb-powerpack'),
							'no'		=> __('No', 'bb-powerpack')
						)
					)
				)
			),
		)
	),
	'style'		=> array(
		'title'		=> __('Style', 'bb-powerpack'),
		'sections'	=> array(
			'shape_style'	=> array(
				'title'			=> __('Shape', 'bb-powerpack'),
				'fields'		=> array(
					'shape_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-headline-dynamic-wrapper path',
							'property'        => 'stroke'
						),
					),
					'shape_width'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Width', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-headline-dynamic-wrapper path',
							'property'        => 'stroke-width'
						),
					)
				)
			)
		)
	),
	'typography'	=> array(
		'title'			=> __('Typography', 'bb-powerpack'),
		'sections'		=> array(
			'text_tag'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'headline_tag'   => array(
		                'type'          => 'select',
		                'label'         => __('Title Tag', 'bb-powerpack'),
		                'default'       => 'h3',
		                'options'       => array(
		                	'h1'	  	=> __('H1', 'bb-powerpack'),
		                    'h2'      	=> __('H2', 'bb-powerpack'),
		                    'h3'      	=> __('H3', 'bb-powerpack'),
		                    'h4'      	=> __('H4', 'bb-powerpack'),
		                    'h5'      	=> __('H5', 'bb-powerpack'),
							'h6'      	=> __('H6', 'bb-powerpack'),
							'div'		=> 'div',
							'p'			=> 'p'
		                )
		            ),
				)
			),
			'headline_typography' => array(
				'title' 			=> __('Headline Text', 'bb-powerpack' ),
                'fields'   			=> array(
					'headline_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
                            'selector'		=> '.pp-headline'
						)
					),
                    'color'        	=> array(
                        'type'       	=> 'color',
                        'label'      	=> __('Color', 'bb-powerpack'),
                        'default'    	=> '',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                    	'preview'		=> array(
                            'type'			=> 'css',
                            'selector'		=> '.pp-headline',
                            'property'		=> 'color'
                    	),
                    ),
                )
            ),
			'animated_text_typography' => array(
				'title' => __('Animating Text', 'bb-powerpack' ),
                'fields'    => array(
					'animated_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
                            'selector'		=> '.pp-headline-dynamic-wrapper'
						)
					),
                    'animated_color'        => array(
                        'type'       => 'color',
                        'label'      => __('Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
                    	'preview'	=> array(
                            'type'		=> 'css',
                            'selector'	=> '.pp-headline-dynamic-wrapper',
                            'property'	=> 'color'
                    	),
					),
					'animated_selection_bg_color' => array(
                        'type'       	=> 'color',
                        'label'      	=> __('Selection Background Color', 'bb-powerpack'),
                        'default'    	=> '',
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                    	'preview'		=> array(
                            'type'			=> 'css',
                            'selector'		=> '.pp-headline-animation-type-typing .pp-headline-dynamic-wrapper.pp-headline-typing-selected',
                            'property'		=> 'background-color'
						),
						'help'			=> __('Leave this field empty for default color.', 'bb-powerpack')
					),
					'animated_selection_color' => array(
                        'type'       	=> 'color',
                        'label'      	=> __('Selection Text Color', 'bb-powerpack'),
                        'default'    	=> '',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                    	'preview'		=> array(
                            'type'			=> 'css',
                            'selector'		=> '.pp-headline-animation-type-typing .pp-headline-dynamic-wrapper.pp-headline-typing-selected .pp-headline-dynamic-text',
                            'property'		=> 'color'
						),
						'help'			=> __('Leave this field empty for default color.', 'bb-powerpack')
                    ),
                )
            ),
		)
	)
));
