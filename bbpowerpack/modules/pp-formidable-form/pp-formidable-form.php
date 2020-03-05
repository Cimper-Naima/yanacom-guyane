<?php

/**
 * @class PPFormidableFormModule
 */
class PPFormidableFormModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Formidable Form', 'bb-powerpack'),
            'description'   => __('A module for Formidable Form.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'form_style' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-formidable-form/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-formidable-form/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }

    public static function formidable_titles()
    {
        $options = array( '' => __('None', 'bb-powerpack') );

        if( class_exists('FrmForm') ) {
            $forms = FrmForm::get_published_forms( array(), 999, 'exclude' );
            if ( count( $forms ) ) {
                foreach ( $forms as $form )
                $options[$form->id] = $form->name;
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
		// Handle Form Background opacity + color field.
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
            $colorInput = $settings->input_field_bg_color;

            if ( ! empty( $colorInput ) ) {
                $colorInput = pp_hex2rgba( pp_get_color_value( $colorInput ), $opacity );
                $settings->input_field_bg_color = $colorInput;
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
				'condition'     	=> ( isset( $settings->form_shadow_display ) && 'yes' == $settings->form_shadow_display ),
			),
			'form_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'opacity'			=> isset( $settings->form_shadow_opacity ) ? ( $settings->form_shadow_opacity / 100 ) : 1,
			),
		), 'form_border_group' );
		// Handle Form old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'form_padding', 'padding', 'form_padding' );
		// Handle section_field_padding old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'section_field_padding', 'padding', 'section_field_padding' );
		// Handle input_field_padding old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_field_padding', 'padding', 'input_field_padding' );
		// Handle button_padding old padding field.
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
		// Handle Label old Font field.
		if ( 'custom' == $settings->input_desc_size ){
			$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_desc_font_size', 'responsive', 'input_desc_font_size' );
		}

		// Handle Label old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_desc_line_height', 'responsive', 'input_desc_line_height' );

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
		// Handle Section Field's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'section_field_font_family'	=> array(
				'type'			=> 'font'
			),
			'section_field_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->section_field_size ) && 'custom' == $settings->section_field_size )
			),
		), 'section_field_typography' );
		// Handle Validation Error old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'validation_error_font_size', 'responsive', 'validation_error_font_size' );

		// Handle Success Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'success_message_font_size', 'responsive', 'success_message_font_size' );

		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPFormidableFormModule', array(
    'form'					=> array( // Tab
        'title'         => __('General', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'select_form'       => array( // Section
                'title'         => __('Form', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'form_desc'     => array(
                        'type'          => '',
                        'description'   => __('Formidable Forms Module enables you to override the default form style that has been set in the Formidable Forms settings.', 'bb-powerpack'),
                    ),
                    'select_form_field' => array(
                        'type'          => 'select',
                        'label'         => __('Select Form', 'bb-powerpack'),
                        'default'       => '',
						'options'       => PPFormidableFormModule::formidable_titles(),
						'connections'	=> array('string')
                    ),
                )
            ),
            'form_general_settings' => array(
                'title' => __('Settings', 'bb-powerpack'),
                'description'   => __('Formidable Forms Module enables you to override the default form style that has been set in the Formidable Forms settings.', 'bb-powerpack'),
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
                            ),
                            'no'    => array(
                                'fields'    => array('title_field', 'description_field')
                            )
                        )
                    ),
                    'title_field'   => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Title', 'bb-powerpack'),
                        'default'       => 'true',
                        'options'       => array(
                            'true'      => __('Show', 'bb-powerpack'),
                            'false'     => __('Hide', 'bb-powerpack'),
                        ),
                    ),
                    'custom_title'      => array(
                        'type'          => 'text',
                        'label'         => __('Custom Title', 'bb-powerpack'),
                        'default'       => '',
                        'description'   => '',
						'preview'       => array(
                            'type'      => 'text',
                            'selector'  => '.pp-form-title'
                        )
                    ),
                    'description_field' => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Description', 'bb-powerpack'),
                        'default'       => 'true',
                        'options'       => array(
                            'true'      => __('Show', 'bb-powerpack'),
                            'false'     => __('Hide', 'bb-powerpack'),
                        ),
                    ),
                    'custom_description'    => array(
                        'type'              => 'textarea',
                        'label'             => __('Custom Description', 'bb-powerpack'),
                        'default'           => '',
                        'placeholder'       => '',
                        'rows'              => '6',
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
    'style'					=> array( // Tab
        'title'         => __('Style', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'form_bg_setting'		=> array( // Section
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
                                'fields'    => array('form_bg_image','form_bg_size','form_bg_repeat', 'form_bg_overlay', 'form_bg_overlay_opacity')
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
                            'selector'  => '.pp-ff-content',
                            'property'  => 'background-color'
                        )
                    ),
                    'form_bg_image'     => array(
                 	   'type'           => 'photo',
                        'label'         => __('Background Image', 'bb-powerpack'),
                        'default'       => '',
						'show_remove'	=> true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content',
                            'property'  => 'background-image'
                        )
                    ),
                    'form_bg_size'      => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Background Size', 'bb-powerpack'),
                        'default'       => 'cover',
                        'options'       => array(
                            'contain'   => __('Contain', 'bb-powerpack'),
                            'cover'     => __('Cover', 'bb-powerpack'),
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
						'connections'	=> array('color'),
                        'show_reset'    => true,
                        'show_alpha'    => true,
                    ),
                )
            ),
            'form_border_setting'	=> array( // Section
				'title'         => __('Form Border', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'form_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-ff-content',
						),
					),
                )
            ),
            'form_corners_padding'	=> array( // Section
				'title'         => __('Size & Padding', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'form_max_width' 	=> array(
                        'type'          => 'unit',
                        'label'         => __('Max Width', 'bb-powerpack'),
                        'units'		    => array('%'),
                        'slider'        => true,
                        'default'       => 100,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content',
                            'property'  => 'max-width',
                            'unit'      => '%'
                        )
					),
					'form_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-ff-content',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
            'section_field_setting'	=> array( // Section
				'title' 	=> __('Section Field', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'section_field_bg_color'     => array(
                        'type'          => 'color',
                        'label'         => __('Background Color', 'bb-powerpack'),
                        'default'       => '',
                        'show_reset'    => true,
						'show_alpha'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
                            'property'  => 'background-color'
                        )
                    ),
                    'section_field_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Color', 'bb-powerpack'),
						'default'               => '444444',
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3, .pp-ff-content .frm_forms .frm_icon_font',
                            'property'          => 'color'
                        )
                    ),
                    'section_field_border_style'	=> array(
                        'type'          => 'pp-switch',
                        'label'         => __('Border Style', 'bb-powerpack'),
                        'default'       => 'none',
                        'options'		=> array(
                            'none'		=> __('None', 'bb-powerpack'),
                            'solid'		=> __('Solid', 'bb-powerpack'),
                       		'dashed'	=> __('Dashed', 'bb-powerpack'),
                       		'dotted'	=> __('Dotted', 'bb-powerpack'),
                        ),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
                            'property'  => 'border-style'
                        ),
                        'toggle'    => array(
                            'solid' => array(
                                'fields'    => array('section_field_border_width', 'section_field_border_color')
                            ),
                            'dashed' => array(
                                'fields'    => array('section_field_border_width', 'section_field_border_color')
                            ),
                            'dotted' => array(
                                'fields'    => array('section_field_border_width', 'section_field_border_color')
                            )
                        )
                    ),
                    'section_field_border_width'	=> array(
                        'type'          => 'unit',
                        'label'         => __('Border Width', 'bb-powerpack'),
                        'units'		    => array( 'px' ),
                        'slider'        => true,
                        'default'       => 2,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
                            'property'  => 'border-width',
                            'unit'      => 'px'
                        )
                    ),
                    'section_field_border_color'	=> array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-powerpack'),
                        'default'       => 'ffffff',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
                            'property'  => 'border-color'
                        )
                    ),
                    'section_field_border_position'	=> array(
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
                    ),
                    'section_field_margin'			=> array(
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
                                    'selector'  => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
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
                                    'selector'  => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
					),
					'section_field_padding'			=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
            'title_style'			=> array( // Section
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
                                    'selector'  => '.pp-ff-content .frm_forms h3.frm_form_title, .pp-ff-content .pp-form-title',
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
                                    'selector'  => '.pp-ff-content .frm_forms h3.frm_form_title, .pp-ff-content .pp-form-title',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    )
                )
            ),
            'description_style'		=> array( // Section
				'title' 	=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
                    'description_margin' 	=> array(
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
                                    'selector'  => '.pp-ff-content .frm_forms .frm_form_title + div.frm_description p, .pp-ff-content .pp-form-description',
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
                                    'selector'  => '.pp-ff-content .frm_forms .frm_form_title + div.frm_description p, .pp-ff-content .pp-form-description',
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
    'input_style_t'			=> array(
        'title' => __('Inputs', 'bb-powerpack'),
        'sections'  => array(
            'input_colors_setting'      => array( // Section
                'title'         => __('Colors', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'input_field_text_color'    => array(
                        'type'                  => 'color',
                        'label'                 => __('Text Color', 'bb-powerpack'),
						'default'               => '333333',
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'                  => 'css',
                            'selector'              => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea',
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
                            'selector'          => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea, .pp-ff-content .frm_forms .frm_dropzone',
                            'property'          => 'background-color'
                        )
                    ),
                )
            ),
            'input_border_setting'      => array( // Section
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
                            'selector'          => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea',
                            'property'          => 'border-color'
                        )
                    ),
                    'input_field_border_width'    => array(
                        'type'                    => 'unit',
                        'label'                   => __('Border Width', 'bb-powerpack'),
                        'units'		              => array('px'),
                        'slider'                  => true,
                        'default'                 => '1',
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
                            'selector'            => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea',
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
                            'selector'          => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]):focus, .pp-ff-content .frm_forms .form-field select:focus, .pp-ff-content .frm_forms .form-field textarea:focus',
                            'property'          => 'border-color'
                        )
                    ),
                )
            ),
            'input_style'      => array( // Section
				'title'         => __('Size & Alignment', 'bb-powerpack'), // Section Title
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
                            'selector'            => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select',
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
                            'selector'            => '.pp-ff-content .frm_forms .form-field textarea',
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
                    'input_field_border_radius'	=> array(
                        'type'                     => 'unit',
                        'label'                    => __('Round Corners', 'bb-powerpack'),
                        'units'                    => array('px'),
                        'slider'                   => true,
                        'default'                  => '2',
                        'preview'                  => array(
                            'type'                 => 'css',
                            'selector'             => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea',
                            'property'             => 'border-radius',
                            'unit'                 => 'px'
                        )
                    ),
                    'input_field_box_shadow'	=> array(
                        'type'                 => 'pp-switch',
                        'label'                => __('Box Shadow', 'bb-powerpack'),
                        'default'              => 'yes',
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
                    'input_shadow_color'		=> array(
                        'type'          => 'color',
                        'label'         => __('Shadow Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea',
                            'property'  => 'box-shadow'
                        ),
                    ),
                    'input_shadow_direction'	=> array(
                        'type'      => 'select',
                        'label'     => __('Shadow Direction', 'bb-powerpack'),
                        'default'   => 'out',
                        'options'   => array(
                            'out'   => __('Outside', 'bb-powerpack'),
                            'inset'   => __('Inside', 'bb-powerpack'),
                        ),
					),
					'input_field_padding'		=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .pp-ff-content .frm_forms .form-field select, .pp-ff-content .frm_forms .form-field textarea',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                    'input_field_margin'		=> array(
                        'type'              => 'unit',
                        'label'             => __('Margin Bottom', 'bb-powerpack'),
                        'units'			    => array('px'),
                        'slider'            => true,
                        'default'           => '10',
                        'preview'           => array(
                            'type'          => 'css',
                            'selector'      => '.pp-ff-content .frm_forms .form-field',
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
                            'selector'          => '.pp-ff-content .frm_forms .form-field input::-webkit-input-placeholder, .pp-ff-content .frm_forms .form-field select::-webkit-input-placeholder, .pp-ff-content .frm_forms .form-field textarea::-webkit-input-placeholder',
                            'property'          => 'color'
                        )
                    ),
                )
            ),
        )
    ),
    'button_style'    		=> array(
        'title' => __('Button', 'bb-powerpack'),
        'sections'  => array(
            'button_colors_setting'		=> array( // Section
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
					'button_bg_color_hover'		=> array(
						'type'		=> 'color',
						'label'		=> __('Background Hover Color', 'bb-powerpack'),
						'default'	=> '000000',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
                )
            ),
            'button_border_setting'		=> array( // Section
				'title'			=> __('Border', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'button_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-ff-content .frm_forms input[type=submit], .pp-ff-content .frm_forms input[type=button], .pp-ff-content .frm_forms input[type=reset], .pp-ff-content .frm_forms .frm_submit button',
						),
					),
                )
            ),
            'button_alignment_setting'	=> array( // Section
				'title'			=> __('Size & Alignment', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
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
                                'fields'    => array('button_alignment')
                            )
                        )
                    ),
                    'button_alignment'  => array(
                        'type'          => 'align',
                        'label'         => __('Button Alignment', 'bb-powerpack'),
                        'default'       => 'left',
                    ),
                )
            ),
            'button_settings'			=> array( // Section
				'title'             => __('Padding', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
				'fields'            => array( // Section Fields
					'button_padding'		=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-ff-content .frm_forms input[type=submit], .pp-ff-content .frm_forms input[type=button], .pp-ff-content .frm_forms input[type=reset], .pp-ff-content .frm_forms .frm_submit button',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
        )
    ),
    'form_messages_setting' => array(
        'title' => __('Messages', 'bb-powerpack'),
        'sections'  => array(
            'form_error_styling'    => array( // Section
                'title'             => __('Errors', 'bb-powerpack'), // Section Title
                'fields'            => array( // Section Fields
                    'validation_error'  => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Validation Error', 'bb-powerpack'),
                        'default'       => 'block',
                        'options'       => array(
                            'block'     => __('Show', 'bb-powerpack'),
                            'none'      => __('Hide', 'bb-powerpack'),
                        ),
                        'toggle' => array(
                            'block' => array(
                                'fields'    => array('validation_error_bg_color', 'validation_error_border_color', 'validation_error_color', 'validation_error_font_size'),
                                'sections'  => array('errors_typography')
                            )
                        )
                    ),
                    'validation_error_bg_color'		=> array(
                        'type'                         => 'color',
                        'label'                        => __('Error Background Color', 'bb-powerpack'),
                        'default'                      => 'f2dede',
                        'show_reset'                   => true,
						'show_alpha'                   => true,
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.frm_forms .frm_error_style',
                            'property'                 => 'background-color'
                        )
                    ),
                    'validation_error_color'		=> array(
                        'type'                  => 'color',
                        'label'                 => __('Error Description Color', 'bb-powerpack'),
						'default'               => 'b94a4b',
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.frm_forms .frm_error_style',
                            'property'          => 'color'
                        )
                    ),
					'validation_error_border_color'	=> array(
                        'type'                         => 'color',
                        'label'                        => __('Error Border Color', 'bb-powerpack'),
                        'default'                      => 'ebccd1',
						'show_reset'                   => true,
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.frm_forms .frm_error_style',
                            'property'                 => 'border-color'
                        )
                    ),
					'validation_message'			=> array(
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
                    'validation_message_color'		=> array(
                        'type'                    => 'color',
                        'label'                   => __('Error Field Message Color', 'bb-powerpack'),
						'default'                 => '790000',
						'connections'				=> array('color'),
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.frm_forms .frm_error',
                            'property'            => 'color'
                        )
                    ),
                )
            ),
            'form_success_styling'    => array( // Section
				'title'             => __('Success Message', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
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
                            'selector'                 => '.frm_forms .frm_message',
                            'property'                 => 'background-color'
                        )
                    ),
                    'success_message_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Color', 'bb-powerpack'),
						'default'                      => '468847',
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.frm_forms .frm_message',
                            'property'                 => 'color'
                        )
                    ),
					'success_message_border_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Border Color', 'bb-powerpack'),
                        'default'                      => 'd6e9c6',
						'show_reset'                   => true,
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.frm_forms .frm_message',
                            'property'                 => 'border-color'
                        )
                    ),
                )
            ),
        )
    ),
    'form_typography'       => array(
        'title'         => __('Typography', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'title_typography'			=> array( // Section
                'title'         => __('Title', 'bb-powerpack'), // Section Title
				'fields'        => array( // Section Fields
					'title_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-ff-content .frm_forms h3.frm_form_title, .pp-ff-content .pp-form-title'
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
                            'selector'  => '.pp-ff-content .frm_forms h3.frm_form_title, .pp-ff-content .pp-form-title',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'description_typography'	=> array(
				'title' 	=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'description_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-ff-content .frm_forms .frm_form_title + div.frm_description p, .pp-ff-content .pp-form-description',
						),
					),
                    'description_color' => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '333333',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-ff-content .frm_forms .frm_form_title + div.frm_description p, .pp-ff-content .pp-form-description',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'label_typography'			=> array( // Section
				'title'         => __('Label', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'label_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-ff-content .frm_forms label.frm_primary_label, 
													.pp-ff-content .frm_forms .form-field.frm_third div.frm_description,
													.pp-ff-content .frm_forms label,
													.pp-ff-content .frm_forms .frm_form_field.frm_html_container'
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
                            'selector'  => '.pp-ff-content .frm_forms label.frm_primary_label, .pp-ff-content .frm_forms .form-field.frm_third div.frm_description, .pp-ff-content .frm_forms label, .pp-ff-content .frm_forms .frm_form_field.frm_html_container',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'input_typography'			=> array( // Section
				'title'         => __('Input', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array(
					'input_typography'			=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-ff-content .frm_forms .form-field input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]),
													.pp-ff-content .frm_forms .form-field select,
													.pp-ff-content .frm_forms .form-field textarea',
						),
					),
                    'input_desc_size'    		=> array(
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
						'responsive'	=> true,
					),
					'input_desc_line_height'	=> array(
						'type'			=> 'unit',
						'label'         => __('Description Line Height', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-ff-content .frm_forms .form-field input + .frm_description',
							'property'      => 'line-height'
						),
						'responsive'	=> true,
					),
                    'input_desc_color'  		=> array(
                        'type'                  => 'color',
                        'label'                 => __('Description Color', 'bb-powerpack'),
						'default'               => '000000',
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-ff-content .frm_forms .form-field input + .frm_description',
                            'property'          => 'color'
                        )
                    ),
                )
            ),
            'button_typography'			=> array( // Section
				'title'         => __('Button', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array(
					'button_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-ff-content .frm_forms input[type=submit], .pp-ff-content .frm_forms input[type=button], .pp-ff-content .frm_forms input[type=reset], .pp-ff-content .frm_forms .frm_submit button'
						),
					),
                )
            ),
            'section_field_typography'	=> array( // Section
				'title'         => __('Section Field', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array(
					'section_field_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-ff-content .frm_forms .frm-show-form  .frm_section_heading h3'
						),
					),
                )
            ),
            'errors_typography'			=> array( // Section
				'title'         => __('Error', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'validation_error_size'    => array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Description Font Size', 'bb-powerpack'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-powerpack'),
                            'custom'                => __('Custom', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('validation_error_font_size')
							)
						)
					),
					'validation_error_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Description Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.frm_forms .frm_error_style',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
                )
            ),
            'form_success_styling'		=> array( // Section
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
							'selector'      => '.frm_forms .frm_message',
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
