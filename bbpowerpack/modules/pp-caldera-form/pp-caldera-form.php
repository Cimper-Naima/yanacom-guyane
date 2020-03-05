<?php

/**
 * @class PPCalderaFormModule
 */
class PPCalderaFormModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Caldera Form', 'bb-powerpack'),
            'description'   => __('A module for Caldera Form.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'form_style' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-caldera-form/',
			'url'           => BB_POWERPACK_URL . 'modules/pp-caldera-form/',
			'partial_refresh' => true,
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }

    /**
     * Get Caldera form titles.
     */
    public static function caldera_form_titles()
    {
		$options = array( '' => __('None', 'bb-powerpack') );
		
		if ( is_admin() ) {
			return $options;
		}

        if ( class_exists('Caldera_Forms_Forms') ) {
            $forms = Caldera_Forms_Forms::get_forms( true );
            if ( count( $forms ) ) {
                foreach ( $forms as $form_id => $form ) {
                    $options[$form_id] = $form['name'];
                }
            }
        }

        return $options;
	}

	public function filter_settings( $settings, $helper ) {

		// Handle Form Background opacity + color field.
        if ( isset( $settings->form_background_opacity ) ) {
            $opacity = $settings->form_background_opacity >= 0 ? $settings->form_background_opacity : 1;
            $colorForm = $settings->form_bg_color;

            if ( ! empty( $colorForm ) ) {
                $colorForm = pp_hex2rgba( pp_get_color_value( $colorForm ), $opacity );
                $settings->form_bg_color = $colorForm;
            }

            unset( $settings->form_background_opacity );
		}
		// Handle Form Background Overlay opacity + color field.
        if ( isset( $settings->form_bg_overlay_opacity ) ) {
            $opacity = $settings->form_bg_overlay_opacity >= 0 ? $settings->form_bg_overlay_opacity : 1;
            $colorForm = $settings->form_bg_overlay;

            if ( ! empty( $colorForm ) ) {
                $colorForm = pp_hex2rgba( pp_get_color_value( $colorForm ), $opacity );
                $settings->form_bg_overlay = $colorForm;
            }

            unset( $settings->form_bg_overlay_opacity );
		}
		// Handle Input Background opacity + color field.
        if ( isset( $settings->input_field_background_opacity ) ) {
            $opacity = $settings->input_field_background_opacity >= 0 ? $settings->input_field_background_opacity : 1;
            $colorForm = $settings->input_field_bg_color;

            if ( ! empty( $colorForm ) ) {
                $colorForm = pp_hex2rgba( pp_get_color_value( $colorForm ), $opacity );
                $settings->input_field_bg_color = $colorForm;
            }

            unset( $settings->input_field_background_opacity );
		}
		// Handle old Form border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'form_border_style'	=> array(
				'type'				=> 'style',
			),
			'form_border_width'	=> array(
				'type'				=> 'width',
			),
			'form_border_color'	=> array(
				'type'				=> 'color',
			),
			'form_border_radius'	=> array(
				'type'				=> 'radius',
			),
			'form_shadow'	=> array(
				'type'				=> 'shadow',
				'condition'     	=> ( isset( $settings->form_shadow_display ) && 'yes' == $settings->form_shadow_display )
			),
			'form_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'opacity'			=> isset( $settings->form_shadow_opacity ) ? ( $settings->form_shadow_opacity / 100 ) : 1,
			),
		), 'form_border_group' );
		// Handle old File border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'file_border_style'	=> array(
				'type'				=> 'style',
			),
			'file_border_width'	=> array(
				'type'				=> 'width',
			),
			'file_border_color'	=> array(
				'type'				=> 'color',
			),
		), 'file_border_group' );
		// Handle old Button border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'button_border_width'	=> array(
				'type'				=> 'width',
			),
			'button_border_color'	=> array(
				'type'				=> 'color',
			),
			'button_border_radius'	=> array(
				'type'				=> 'radius',
			),
		), 'button_border_group' );

		// Handle Form old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'form_padding', 'padding', 'form_padding' );

		// Handle Input old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_field_padding', 'padding', 'input_field_padding' );

		// Handle Button old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'button_padding', 'padding', 'button_padding' );

		// Handle old button text dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'button_text_color', array(
			'primary'	=> 'button_text_color_default',
			'secondary'	=> 'button_text_color_hover'
		) );

		// Handle old button background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'button_bg_color', array(
			'primary'	=> 'button_bg_color_default',
			'secondary'	=> 'button_bg_color_hover',
			'opacity'	=> 'button_background_opacity'
		) );

		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'title_font_family'	=> array(
				'type'			=> 'font'
			),
			'title_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->title_size ) && 'custom' == $settings->title_size )
			),
			'title_alignment'	=> array(
				'type'			=> 'text_align',
			),
			'title_line_height'	=> array(
				'type'			=> 'line_height',
			),
			'title_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'title_typography' );

		// Handle description's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'description_font_family'	=> array(
				'type'			=> 'font'
			),
			'description_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->description_size ) && 'custom' == $settings->description_size )
			),
			'description_alignment'	=> array(
				'type'			=> 'text_align',
			),
			'description_line_height'	=> array(
				'type'			=> 'line_height',
			),
			'description_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'description_typography' );

		// Handle label's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'label_font_family'	=> array(
				'type'			=> 'font'
			),
			'label_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->label_size ) && 'custom' == $settings->label_size )
			),
			'label_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'label_typography' );

		// Handle Input's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'input_font_family'	=> array(
				'type'			=> 'font'
			),
			'input_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->input_size ) && 'custom' == $settings->input_size )
			),
			'input_field_text_alignment'	=> array(
				'type'			=> 'text_align',
			),
			'input_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'input_typography' );
		// Handle Button's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'button_font_family'	=> array(
				'type'			=> 'font'
			),
			'button_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->button_size ) && 'custom' == $settings->button_size )
			),
			'button_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'button_typography' );
		// Handle Input Desc Font Size old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_desc_font_size', 'responsive', 'input_desc_font_size' );
		// Handle Input Desc Line Height old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_desc_line_height', 'responsive', 'input_desc_line_height' );

		// Handle Validation Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'validation_message_font_size', 'responsive', 'validation_message_font_size' );

		// Handle Success Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'success_message_font_size', 'responsive', 'success_message_font_size' );

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPCalderaFormModule', array(
    'form'				=> array( // Tab
        'title'         => __('General', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'select_form'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'select_form_field' => array(
                        'type'          => 'select',
                        'label'         => __('Select Form', 'bb-powerpack'),
                        'default'       => '',
						'options'       => PPCalderaFormModule::caldera_form_titles(),
						'connections'	=> array('string')
                    ),
                )
            ),
            'form_general_setting'  => array(
                'title' => __('Settings', 'bb-powerpack'),
                'fields'    => array(
                    'form_custom_title_desc'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Custom Title & Description', 'bb-powerpack'),
                        'default'       => 'no',
                        'options'       => array(
                            'yes'      => __('Yes', 'bb-powerpack'),
                            'no'     => __('No', 'bb-powerpack'),
                        ),
                        'toggle' => array(
                            'yes'      => array(
                                'fields'  => array('custom_title', 'custom_description'),
                                'sections'  => array('title_style', 'description_style', 'title_typography', 'description_typography')
                            )
                        )
                    ),
                    'custom_title'      => array(
                        'type'          => 'text',
                        'label'         => __('Custom Title', 'bb-powerpack'),
                        'default'       => '',
                        'description'   => '',
                        'connections'   => array('string'),
						'preview'       => array(
                            'type'      => 'text',
                            'selector'  => '.pp-form-title'
                        )
                    ),
                    'custom_description'    => array(
                        'type'              => 'textarea',
                        'label'             => __('Custom Description', 'bb-powerpack'),
                        'default'           => '',
                        'placeholder'       => '',
                        'rows'              => '6',
                        'connections'   => array('string', 'html'),
                        'preview'           => array(
                            'type'          => 'text',
                            'selector'      => '.pp-form-description'
                        )
                    ),
                    'display_labels'   => array(
                        'type'         => 'pp-switch',
                        'label'        => __('Labels', 'bb-powerpack'),
                        'default'      => 'block',
                        'options'      => array(
                            'block'    => __('Show', 'bb-powerpack'),
                            'none'     => __('Hide', 'bb-powerpack'),
                        ),
                    ),
                )
            )
        )
    ),
    'style'				=> array( // Tab
        'title'         => __('Style', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'form_background'      => array( // Section
                'title'         => __('Form Background', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'form_bg_type'      => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Background Type', 'bb-powerpack'),
                        'default'       => 'color',
                        'options'       => array(
                            'color'   => __('Color', 'bb-powerpack'),
                            'image'     => __('Image', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'color' => array(
                                'fields'    => array('form_bg_color','form_background_opacity')
                            ),
                            'image' => array(
                                'fields'    => array('form_bg_image','form_bg_size','form_bg_repeat', 'form_bg_overlay' )
                            )
                        )
                    ),
                    'form_bg_color'     => array(
                        'type'          => 'color',
                        'label'         => __('Background Color', 'bb-powerpack'),
                        'default'       => 'ffffff',
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-caldera-form-content',
                            'property'  => 'background-color'
                        )
                    ),
                    'form_bg_image'     => array(
                        'type'              => 'photo',
                        'label'             => __('Background Image', 'bb-powerpack'),
                        'default'           => '',
						'show_remove'		=> true,
                        'preview'           => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content',
                            'property'          => 'background-image'
                        )
                    ),
                    'form_bg_size'      => array(
                        'type'              => 'pp-switch',
                        'label'             => __('Background Size', 'bb-powerpack'),
                        'default'           => 'cover',
                        'options'           => array(
                            'contain'           => __('Contain', 'bb-powerpack'),
                            'cover'             => __('Cover', 'bb-powerpack'),
                        )
                    ),
                    'form_bg_repeat'    => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Background Repeat', 'bb-powerpack'),
                        'default'       => 'no-repeat',
                        'options'       => array(
                            'repeat-x'      => __('Repeat X', 'bb-powerpack'),
                            'repeat-y'      => __('Repeat Y', 'bb-powerpack'),
                            'no-repeat'     => __('No Repeat', 'bb-powerpack'),
                        )
                    ),
					'form_bg_overlay'     => array(
                        'type'          => 'color',
                        'label'         => __('Background Overlay Color', 'bb-powerpack'),
                        'default'       => '000000',
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                    ),
                )
            ),
            'form_border_settings'      => array( // Section
				'title'         => __('Form Border', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'form_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-caldera-form-content',
						),
					),
                )
            ),
            'form_corners_padding'      => array( // Section
				'title'         => __('Padding', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'form_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-caldera-form-content',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
            'title_style' => array( // Section
				'title' 	=> __('Title', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'title_margin' 	=> array(
                        'type' 			=> 'pp-multitext',
                        'label' 		=> __('Margin', 'bb-powerpack'),
                        'description'   => __( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-powerpack' ),
                        'default'       => array(
                            'top' => 10,
                            'bottom' => 10,
                        ),
                        'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   =>  __('Top', 'bb-powerpack'),
                                'tooltip'       => 'Top',
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.pp-caldera-form-content .pp-form-title',
                                    'property'  => 'margin-top',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   =>  __('Bottom', 'bb-powerpack'),
                                'tooltip'       => 'Bottom',
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.pp-caldera-form-content .pp-form-title',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    ),
                )
            ),
            'description_style' => array( // Section
				'title' 	=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'description_margin' 	=> array(
                        'type' 			=> 'pp-multitext',
                        'label' 		=> __('Margin', 'bb-powerpack'),
                        'description'   => __( 'px', 'Value unit for margin. Such as: "14 px"', 'bb-powerpack' ),
                        'default'       => array(
                            'top' => 10,
                            'bottom' => 10,
                        ),
                        'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   =>  __('Top', 'bb-powerpack'),
                                'tooltip'       => 'Top',
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.pp-caldera-form-content .pp-form-description',
                                    'property'  => 'margin-top',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   =>  __('Bottom', 'bb-powerpack'),
                                'tooltip'       => 'Bottom',
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.pp-caldera-form-content .pp-form-description',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    )
                )
            ),
        )
    ),
    'input_style_t'		=> array(
        'title' => __('Inputs', 'bb-powerpack'),
        'sections'  => array(
            'input_field_colors'      => array( // Section
                'title'         => __('Colors', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'input_field_text_color'    => array(
                        'type'                  => 'color',
                        'label'                 => __('Text Color', 'bb-powerpack'),
						'default'               => '333333',
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'                  => 'css',
                            'selector'              => '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'              => 'color'
                        )
                    ),
                    'input_field_bg_color'      => array(
                        'type'                  => 'color',
                        'label'                 => __('Background Color', 'bb-powerpack'),
                        'default'               => 'ffffff',
                        'show_reset'            => true,
						'show_alpha'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'          => 'background-color'
                        )
                    ),
                )
            ),
            'input_border_settings'      => array( // Section
				'title'         => __('Border', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'input_field_border_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Border Color', 'bb-powerpack'),
                        'default'               => 'eeeeee',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'          => 'border-color'
                        )
                    ),
                    'input_field_border_width'    => array(
                        'type'                    => 'unit',
                        'label'                   => __('Border Width', 'bb-powerpack'),
                        'slider'				  => true,
                        'units'					  => array('px'),
                        'default'                 => '1',
                        'preview'                 => array(
                            'type'                => 'css',
                            'rules'                 => array(
                                array(
                                    'selector'            => '.pp-caldera-form-content .caldera-grid .form-control',
                                    'property'            => 'border-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-caldera-form-content .caldera-grid .form-control',
                                    'property'            => 'border-top-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-caldera-form-content .caldera-grid .form-control',
                                    'property'            => 'border-bottom-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-caldera-form-content .caldera-grid .form-control',
                                    'property'            => 'border-left-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-caldera-form-content .caldera-grid .form-control',
                                    'property'            => 'border-right-width',
                                    'unit'                => 'px',
                                )
                            )
                        )
                    ),
                    'input_field_border_position'    => array(
                        'type'                    => 'select',
                        'label'                   => __('Border Position', 'bb-powerpack'),
                        'default'                 => 'border',
                        'options'				  => array(
                        	'border'			  => __('Default', 'bb-powerpack'),
                        	'border-top'		  => __('Top', 'bb-powerpack'),
                        	'border-bottom'		  => __('Bottom', 'bb-powerpack'),
                        	'border-left'		  => __('Left', 'bb-powerpack'),
                        	'border-right'		  => __('Right', 'bb-powerpack'),
                        ),
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'            => 'border',
                            'unit'                => 'px'
                        )
                    ),
                    'input_field_focus_color'      => array(
                        'type'                  => 'color',
                        'label'                 => __('Focus Border Color', 'bb-powerpack'),
                        'default'               => '719ece',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid .form-control:focus',
                            'property'          => 'border-color'
                        )
                    ),
                )
            ),
            'input_size_alignment'      => array( // Section
				'title'         => __('Size', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'input_field_width'     => array(
                        'type'              => 'pp-switch',
                        'label'             => __('Full Width', 'bb-powerpack'),
                        'default'           => 'false',
                        'options'           => array(
                            'true'          => __('Yes', 'bb-powerpack'),
                            'false'         => __('No', 'bb-powerpack'),
                        )
                    ),
                    'input_field_height'    => array(
                        'type'                    => 'unit',
                        'label'                   => __('Input Height', 'bb-powerpack'),
                        'units'		              => array('px'),
                        'slider'                  => true,
                        'default'                 => '32',
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-caldera-form-content .caldera-grid input.form-control, .pp-caldera-form-content .caldera-grid select.form-control',
                            'property'            => 'height',
                            'unit'                => 'px',
                        )
                    ),
                    'input_textarea_height'    => array(
                        'type'                    => 'unit',
                        'label'                   => __('Textarea Height', 'bb-powerpack'),
                        'units'		              => array('px'),
                        'slider'                  => true,
                        'default'                 => '140',
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-caldera-form-content .caldera-grid textarea.form-control',
                            'property'            => 'height',
                            'unit'                => 'px',
                        )
                    ),
                )
            ),
            'input_general_style'      => array( // Section
				'title'         => __('General', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'input_field_border_radius'    => array(
                        'type'                     => 'unit',
                        'label'                    => __('Round Corners', 'bb-powerpack'),
                        'units'                    => array('px'),
                        'slider'                   => true,
                        'default'                  => '2',
                        'preview'                  => array(
                            'type'                 => 'css',
                            'selector'             => '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'             => 'border-radius',
                            'unit'                 => 'px'
                        )
                    ),
                    'input_field_box_shadow'   => array(
                        'type'                 => 'pp-switch',
                        'label'                => __('Box Shadow', 'bb-powerpack'),
                        'default'              => 'no',
                        'options'              => array(
                            'yes'          => __('Show', 'bb-powerpack'),
                            'no'             => __('Hide', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    => array('input_shadow_color', 'input_shadow_direction')
                            )
                        )
                    ),
                    'input_shadow_color'      => array(
                        'type'          => 'color',
                        'label'         => __('Shadow Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'  => 'box-shadow'
                        ),
                    ),
                    'input_shadow_direction'  => array(
                        'type'      => 'select',
                        'label'     => __('Shadow Direction', 'bb-powerpack'),
                        'default'   => 'out',
                        'options'   => array(
                            'out'   => __('Outside', 'bb-powerpack'),
                            'inset'   => __('Inside', 'bb-powerpack'),
                        ),
					),
					'input_field_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-caldera-form-content .caldera-grid .form-control',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                    'input_field_margin'    => array(
                        'type'              => 'unit',
                        'label'             => __('Margin Bottom', 'bb-powerpack'),
                        'units'             => array('px'),
                        'slider'            => true,
                        'default'           => '10',
                        'preview'           => array(
                            'type'          => 'css',
                            'selector'      => '.pp-caldera-form-content .caldera-grid .single > div',
                            'property'      => 'margin-bottom',
                            'unit'          => 'px'
                        )
                    ),
                )
            ),
            'placeholder_style'      => array( // Section
				'title'         => __('Placeholder', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'input_placeholder_display' 	=> array(
                        'type'          => 'pp-switch',
                        'label'         => __('Show Placeholder', 'bb-powerpack'),
                        'default'       => 'block',
                        'options'		=> array(
                       		'block'	=> __('Yes', 'bb-powerpack'),
                       		'none'	=> __('No', 'bb-powerpack'),
                        ),
                        'toggle' => array(
                            'block' => array(
                                'fields' => array('input_placeholder_color')
                            )
                        )
                    ),
                    'input_placeholder_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Color', 'bb-powerpack'),
                        'default'               => 'eeeeee',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid .form-control::-webkit-input-placeholder',
                            'property'          => 'color'
                        )
                    ),
                )
            ),
            'file_upload_style' => array(
                'title' => __('File Upload', 'bb-powerpack'),
                'fields'    => array(
                    'file_bg_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Background Color', 'bb-powerpack'),
                        'default'               => '',
                        'show_reset'            => true,
						'show_alpha'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid input[type=file]',
                            'property'          => 'background-color'
                        )
                    ),
                    'file_text_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Color', 'bb-powerpack'),
                        'default'               => '',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid input[type=file]',
                            'property'          => 'color'
                        )
					),
					'file_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-caldera-form-content .caldera-grid input[type=file]',
						),
					),
                    'file_horizontal_padding'      => array(
                        'type'          => 'unit',
                        'label'         => __('Horizontal Padding', 'bb-powerpack'),
                        'units'		    => array('px'),
                        'slider'        => true,
                        'default'       => '',
                        'preview'       => array(
                            'type'      => 'css',
                            'rules'     => array(
                                array(
                                    'selector'  => '.pp-caldera-form-content .caldera-grid input[type=file]',
                                    'property'  => 'padding-left',
                                    'unit'      => 'px'
                                ),
                                array(
                                    'selector'  => '.pp-caldera-form-content .caldera-grid input[type=file]',
                                    'property'  => 'padding-right',
                                    'unit'      => 'px'
                                ),
                            )
                        )
                    ),
                    'file_vertical_padding'      => array(
                        'type'          => 'unit',
                        'label'         => __('Vertical Padding', 'bb-powerpack'),
                        'units'		    => array('px'),
                        'slider'        => true,
                        'default'       => '',
                        'preview'       => array(
                            'type'      => 'css',
                            'rules'     => array(
                                array(
                                    'selector'  => '.pp-caldera-form-content .caldera-grid input[type=file]',
                                    'property'  => 'padding-top',
                                    'unit'      => 'px'
                                ),
                                array(
                                    'selector'  => '.pp-caldera-form-content .caldera-grid input[type=file]',
                                    'property'  => 'padding-bottom',
                                    'unit'      => 'px'
                                ),
                            )
                        )
                    ),
                )
            )
        )
    ),
    'button_style'		=> array(
        'title' => __('Button', 'bb-powerpack'),
        'sections'  => array(
            'button_colors' => array(
                'title'             => __('Colors', 'bb-powerpack'), // Section Title
				'fields'            => array( // Section Fields
					'button_text_color_default'	=> array(
						'type'		=> 'color',
						'label'		=> __('Text Color', 'bb-powerpack'),
						'default'	=> 'fffffff',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
					'button_text_color_hover'	=> array(
						'type'		=> 'color',
						'label'		=> __('Text Hover Color', 'bb-powerpack'),
						'default'	=> 'eeeeee',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
					'button_bg_color_default'	=> array(
						'type'		=> 'color',
						'label'		=> __('Background Color', 'bb-powerpack'),
						'default'	=> '333333',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'button_bg_color_hover'	=> array(
						'type'		=> 'color',
						'label'		=> __('Background Hover Color', 'bb-powerpack'),
						'default'	=> '000000',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
                )
            ),
            'button_border_settings'   => array(
				'title'             => __('Border', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
				'fields'            => array( // Section Fields
					'button_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-caldera-form-content .caldera-grid input[type=submit]',
						),
					),
                )
            ),
            'button_size_settings'   => array(
				'title'             => __('Size & Alignment', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
                'fields'            => array( // Section Fields
                    'button_width'  => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Full Width', 'bb-powerpack'),
                        'default'   => 'false',
                        'options'   => array(
                            'true'  => __('Yes', 'bb-powerpack'),
                            'false' => __('No', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'false' => array(
                                'fields'    => array( 'button_alignment')
                            )
                        )
                    ),
                    'button_alignment'  => array(
                        'type'          => 'align',
                        'label'         => __('Button Alignment', 'bb-powerpack'),
                        'default'       => 'left',
                        'preview'            => array(
                            'type'           => 'css',
                            'selector'       => '.pp-caldera-form-content .caldera-grid input[type=submit]',
                            'property'       => 'float'
                        )
                    ),
                )
            ),
            'button_corners_padding'       => array( // Section
				'title'             => __('Corners & Padding', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
				'fields'            => array( // Section Fields
					'button_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-caldera-form-content .caldera-grid input[type=submit]',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
        )
    ),
    'Messages_style'	=> array(
        'title' => __('Messages', 'bb-powerpack'),
        'sections'  => array(
            'form_error_styling'    => array( // Section
                'title'             => __('Errors', 'bb-powerpack'), // Section Title
                'fields'            => array( // Section Fields
					'validation_message'   => array(
                        'type'             => 'pp-switch',
                        'label'            => __('Error Field Message', 'bb-powerpack'),
                        'default'          => 'block',
                        'options'          => array(
                            'block'        => __('Show', 'bb-powerpack'),
                            'none'         => __('Hide', 'bb-powerpack'),
                        ),
                        'toggle'    => array(
                            'block' => array(
                                'fields'    => array('validation_message_color'),
                                'sections'  => array('errors_typography')
                            )
                        )
                    ),
                    'validation_message_color'    => array(
                        'type'                    => 'color',
                        'label'                   => __('Color', 'bb-powerpack'),
						'default'                 => 'dd4b39',
						'connections'			=> array('color'),
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-caldera-form-content .caldera-grid .form-group .has-error .help-block',
                            'property'            => 'color'
                        )
                    ),
                )
            ),
            'form_success_styling'    => array( // Section
                'title'             => __('Success Message', 'bb-powerpack'), // Section Title
                'fields'            => array( // Section Fields
                    'success_message_bg_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Background Color', 'bb-powerpack'),
                        'default'                      => 'dff0d8',
                        'show_reset'                   => true,
						'show_alpha'                   => true,
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.pp-caldera-form-content .caldera-grid .alert-success',
                            'property'                 => 'background-color'
                        )
                    ),
                    'success_message_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Color', 'bb-powerpack'),
						'default'                      => '3c763d',
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.pp-caldera-form-content .caldera-grid .alert-success',
                            'property'                 => 'color'
                        )
                    ),
					'success_message_border_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Border Color', 'bb-powerpack'),
                        'default'                      => 'a3d48e',
						'show_reset'                   => true,
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.pp-caldera-form-content .caldera-grid .alert-success',
                            'property'                 => 'border-color'
                        )
                    ),
                )
            ),
        )
    ),
    'form_typography'	=> array( // Tab
        'title'         => __('Typography', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'title_typography'       => array( // Section
                'title'         => __('Title', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
					'title_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-caldera-form-content .pp-form-title',
						),
					),
                    'title_color'       => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-caldera-form-content .pp-form-title',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'description_typography' => array(
				'title' 	=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'description_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-caldera-form-content .pp-form-description'
						),
					),
                    'description_color' => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
						'default'       => '333333',
						'connections'	=> array('color'),
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-caldera-form-content .pp-form-description',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'label_typography'       => array(
				'title'         => __('Label', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'label_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-caldera-form-content .caldera-grid .form-group > label,
													.pp-caldera-form-content .caldera-grid .form-group label,
													.pp-caldera-form-content .caldera-grid',
						),
					),
                    'form_label_color'  => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-caldera-form-content .caldera-grid .form-group > label, .pp-caldera-form-content .caldera-grid .form-group label, .pp-caldera-form-content .caldera-grid',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'input_typography'       => array( // Section
				'title'         => __('Input', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'input_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-caldera-form-content .caldera-grid .form-control',
						),
					),
                    'input_desc_size'		=> array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Description Font Size', 'bb-powerpack'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-powerpack'),
                            'custom'                => __('Custom', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('input_desc_font_size')
							)
						)
					),
					'input_desc_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Description Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-caldera-form-content .caldera-grid .form-group .help-block',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
					'input_desc_line_height'		=> array(
						'type'			=> 'unit',
						'label'         => __('Description Line Height', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-caldera-form-content .caldera-grid .form-group .help-block',
							'property'      => 'line-height'
						),
						'responsive'	=> true,
					),
                    'input_desc_color'		=> array(
                        'type'                  => 'color',
                        'label'                 => __('Description Color', 'bb-powerpack'),
						'default'               => '000000',
						'connections'			=> array('color'),
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-caldera-form-content .caldera-grid .form-group .help-block',
                            'property'          => 'color'
                        )
                    ),
                )
            ),
            'button_typography'       => array( // Section
				'title'         => __('Button', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'button_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-caldera-form-content .caldera-grid input[type=submit]'
						),
					),
                )
            ),
            'errors_typography'       => array( // Section
				'title'         => __('Error', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'validation_message_size'    => array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Field Message Font Size', 'bb-powerpack'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-powerpack'),
                            'custom'                => __('Custom', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('validation_message_font_size')
							)
						)
					),
					'validation_message_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Field Messsage Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-caldera-form-content .caldera-grid .form-group .has-error .help-block',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
                )
            ),
            'form_success_styling'    => array( // Section
				'title'             => __('Success Message', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
                'fields'            => array( // Section Fields
                    'success_message_size'    => array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Font Size', 'bb-powerpack'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-powerpack'),
                            'custom'                => __('Custom', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('success_message_font_size')
							)
						)
					),
					'success_message_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-caldera-form-content .caldera-grid .alert-success',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
                )
            ),
        )
    )
));
