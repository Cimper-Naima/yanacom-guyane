<?php

/**
 * A module that adds a simple subscribe form to your layout
 * with third party optin integration.
 *
 * @since 1.5.2
 */
class PPSubscribeFormModule extends FLBuilderModule {

	/**
	 * @since 1.5.2
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct( array(
			'name'          	=> __( 'Subscribe Form', 'bb-powerpack' ),
			'description'   	=> __( 'Adds a simple subscribe form to your layout.', 'bb-powerpack' ),
			'group'         	=> pp_get_modules_group(),
            'category'			=> pp_get_modules_cat( 'form_style' ),
            'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-subscribe-form/',
            'url'           	=> BB_POWERPACK_URL . 'modules/pp-subscribe-form/',
			'editor_export' 	=> false,
			'partial_refresh'	=> true,
		));

		add_action( 'wp_ajax_pp_subscribe_form_submit', array( $this, 'submit' ) );
		add_action( 'wp_ajax_nopriv_pp_subscribe_form_submit', array( $this, 'submit' ) );

		$this->add_js( 'jquery-cookie' );
	}

	/**
	 * Called via AJAX to submit the subscribe form.
	 *
	 * @since 1.5.2
	 * @return string The JSON encoded response.
	 */
	public function submit()
	{
		$name       		= isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : false;
		$email      		= isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : false;
		$acceptance      	= isset( $_POST['acceptance'] ) && 1 == $_POST['acceptance'] ? true : false;
		$post_id     		= isset( $_POST['post_id'] ) ? $_POST['post_id'] : false;
		$node_id    		= isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
		$template_id    	= isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
		$template_node_id   = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;
		$result    			= array(
			'action'    		=> false,
			'error'     		=> false,
			'message'   		=> false,
			'url'       		=> false
		);

		if ( $email && $node_id ) {

			// Get the module settings.
			if ( $template_id ) {
				$post_id  = FLBuilderModel::get_node_template_post_id( $template_id );
				$data	  = FLBuilderModel::get_layout_data( 'published', $post_id );
				$settings = $data[ $template_node_id ]->settings;
			}
			else {
				$module   = FLBuilderModel::get_module( $node_id );
				$settings = $module->settings;
			}

			// Validate terms and conditions if enabled
			if ( ( isset( $settings->checkbox_field ) && 'show' == $settings->checkbox_field ) && ! $acceptance ) {
				$result['error'] = __( 'Please check the required field.', 'bb-powerpack' );
			}

			if ( ! $result['error'] ) {
				// Subscribe.
				$instance = FLBuilderServices::get_service_instance( $settings->service );
				$response = $instance->subscribe( $settings, $email, $name );

				// Check for an error from the service.
				if ( $response['error'] ) {
					$result['error'] = $response['error'];
				}
				// Setup the success data.
				else {

					$result['action'] = $settings->success_action;

					if ( 'message' == $settings->success_action ) {
						$result['message']  = $settings->success_message;
					}
					else {
						$result['url']  = $settings->success_url;
					}
				}

				do_action( 'pp_subscribe_form_submission_complete', $response, $settings, $email, $name, $template_id, $post_id );
			}
		}
		else {
			$result['error'] = __( 'There was an error subscribing. Please try again.', 'bb-powerpack' );
		}

		echo json_encode( $result );

		die();
	}

	public function filter_settings( $settings, $helper ) {

		// Handle Box old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'box_padding', 'padding', 'box_padding' );

		// Handle Form old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'form_padding', 'padding', 'form_padding' );

		// Handle Input old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_field_padding', 'padding', 'input_field_padding' );

		// Handle Button old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'button_padding', 'padding', 'button_padding' );

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
				'condition'			=> ( isset( $settings->form_shadow_display ) && 'yes' == $settings->form_shadow_display )
			),
			'form_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'opacity'			=> isset( $settings->form_shadow_opacity ) ? ( $settings->form_shadow_opacity / 100 ) : 1,
				'condition'			=> ( isset( $settings->form_shadow_display ) && 'yes' == $settings->form_shadow_display )
			),
		), 'form_border_group' );

		// Handle old Button border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'button_border_size'	=> array(
				'type'				=> 'width',
			),
			'btn_border_color'	=> array(
				'type'				=> 'color',
			),
			'btn_border_radius'	=> array(
				'type'				=> 'radius',
			),
		), 'button_border_group' );

		// Handle Content's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'content_font_family'	=> array(
				'type'			=> 'font'
			),
			'content_font_size_custom'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->content_font_size ) && 'custom' == $settings->content_font_size )
			),
			'content_line_height_custom'	=> array(
				'type'          => 'line_height',
				'condition'     => ( isset( $settings->content_line_height ) && 'custom' == $settings->content_line_height )
			),
		), 'content_typography' );

		// Handle Input's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'input_font_family'	=> array(
				'type'			=> 'font'
			),
			'input_font_size'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->input_size ) && 'custom' == $settings->input_size )
			),
			'input_text_transform'	=> array(
				'type'          => 'text_transform',
			),
			'input_field_text_alignment'	=> array(
				'type'          => 'text_align',
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
				'type'          => 'text_transform',
			),
		), 'button_typography' );

		// Handle Checkbox old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'checkbox_font_size_custom', 'responsive', 'checkbox_font_size_custom' );

		// Handle Checkbox old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'placeholder_font_size', 'responsive', 'placeholder_font_size' );

		// Handle Validation Error old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'validation_error_font_size', 'responsive', 'validation_error_font_size' );

		// Handle Success Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'success_message_font_size', 'responsive', 'success_message_font_size' );

		// Handle Box Background opacity + color field.
        if ( isset( $settings->box_bg_opacity ) ) {
            $opacity = $settings->box_bg_opacity >= 0 ? $settings->box_bg_opacity : 1;
            $colorBox = $settings->box_bg;

            if ( ! empty( $colorBox ) ) {
                $colorBox = pp_hex2rgba( pp_get_color_value( $colorBox ), $opacity );
                $settings->box_bg = $colorBox;
            }

            unset( $settings->box_bg_opacity );
		}

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

		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'PPSubscribeFormModule', array(
	'general'       => array(
		'title'         => __( 'General', 'bb-powerpack' ),
		'sections'      => array(
			'service'       => array(
				'title'         => '',
				'file'          => FL_BUILDER_DIR . 'includes/service-settings.php',
				'services'      => 'autoresponder'
			),
			'display_type'	=> array(
				'title'			=> '',
				'fields'		=> array(
					'box_type'	=> array(
						'type'			=> 'select',
						'label'			=> __( 'Type', 'bb-powerpack' ),
						'default'		=> 'standard',
						'options'		=> array(
							'standard'		=> __( 'Standard', 'bb-powerpack' ),
							'fixed_bottom'	=> __( 'Fixed at Bottom', 'bb-powerpack' ),
							'slidein'		=> __( 'On-Scroll Slide-In', 'bb-powerpack' ),
							'popup_scroll'	=> __( 'On-Scroll Popup', 'bb-powerpack' ),
							'popup_exit'	=> __( 'Exit-Intent Popup', 'bb-powerpack' ),
							'popup_auto'	=> __( 'Auto-Load Popup', 'bb-powerpack' ),
							'two_step'		=> __( 'Two Step Popup', 'bb-powerpack' ),
							'welcome_gate'	=> __( 'Welcome Gate', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'standard'		=> array(
								'fields'		=> array('show_content', 'form_border_radius')
							),
							'fixed_bottom'	=> array(
								'sections'		=> array('box_content'),
								'fields'		=> array('box_width', 'display_after')
							),
							'slidein'		=> array(
								'sections'		=> array('box_content', 'content_style', 'box_content_typography', 'box_bg_setting'),
								'fields'		=> array('box_scroll', 'slidein_position', 'box_width', 'box_height', 'display_after')
							),
							'popup_scroll'	=> array(
								'sections'		=> array('box_content', 'content_style', 'box_content_typography', 'box_bg_setting', 'box_overlay'),
								'fields'		=> array('box_scroll', 'box_width', 'box_height', 'display_after')
							),
							'popup_exit'	=> array(
								'sections'		=> array('box_content', 'content_style', 'box_content_typography', 'box_bg_setting', 'box_overlay'),
								'fields'		=> array('box_width', 'box_height', 'display_after')
							),
							'popup_auto'	=> array(
								'sections'		=> array('box_content', 'content_style', 'box_content_typography', 'box_bg_setting', 'box_overlay'),
								'fields'		=> array('popup_delay', 'box_width', 'box_height', 'display_after')
							),
							'two_step'		=> array(
								'sections'		=> array('box_content', 'content_style', 'box_content_typography', 'box_bg_setting', 'box_overlay'),
								'fields'		=> array('box_width', 'box_height', 'css_class')
							),
							'welcome_gate'	=> array(
								'sections'		=> array('box_content', 'content_style', 'box_content_typography', 'box_bg_setting'),
								'fields'		=> array('popup_delay', 'box_width', 'box_height', 'display_after')
							)
						),
					),
					'show_content'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Show Content', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack')
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array('box_content', 'box_content_typography')
							)
						)
					),
					'box_scroll'	=> array(
						'type'			=> 'unit',
						'label'			=> __( 'Scroll Percentage', 'bb-powerpack' ),
						'default'		=> 50,
						'slider'		=> true,
						'units'			=> array('%'),
						'preview'       => array(
							'type'             => 'none'
						),
						'help'			=> __( 'It will appear once the user scroll the page to the percentage you added.', 'bb-powerpack' )
					),
					'slidein_position'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Position', 'bb-powerpack' ),
						'default'			=> 'left',
						'options'			=> array(
							'left'				=> __( 'Bottom Left', 'bb-powerpack' ),
							'right'				=> __( 'Bottom Right', 'bb-powerpack' ),
						),
						'preview'       	=> array(
							'type'             => 'none'
						)
					),
					'popup_delay'	=> array(
						'type'			=> 'unit',
						'label'			=> __( 'Delay', 'bb-powerpack' ),
						'default'		=> 1,
						'slider'		=> true,
						'units'			=> array('second(s)'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'box_width'		=> array(
						'type'			=> 'unit',
						'label'			=> __( 'Width', 'bb-powerpack' ),
						'default'		=> 550,
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'       => array(
							'type'          => 'css',
							'selector'		=> '.pp-subscribe-box',
							'property'		=> 'width',
							'unit'			=> 'px'
						)
					),
					'box_height'	=> array(
						'type'			=> 'unit',
						'label'			=> __( 'Height', 'bb-powerpack' ),
						'default'		=> 450,
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'       => array(
							'type'          => 'css',
							'selector'		=> '.pp-subscribe-box',
							'property'		=> 'height',
							'unit'			=> 'px'
						)
					),
					'css_class'	=> array(
						'type'		=> 'pp-css-class',
						'label'		=> __('CSS Class', 'bb-powerpack'),
						'default'	=> 'pp_subscribe_',
						'help'		=> __('Copy this CSS class and paste it to the element you want to trigger the popup clicking on it.', 'bb-powerpack')
					),
					'display_after'    	=> array(
                        'type'              => 'unit',
                        'label'             => __('Cookie Duration', 'bb-powerpack'),
                        'default'           => 1,
						'slider'			=> true,
						'units'				=> array('day(s)'),
                        'help'              => __('If users close the box it will display them again only after the length of the time.', 'bb-powerpack'),
                    )
				)
			),
			'box_content'	=> array(
				'title'         	=> __( 'Content', 'bb-powerpack' ),
				'collapsed'			=> true,
				'fields'        	=> array(
					'box_content' => array(
						'type'          => 'editor',
						'label'         => '',
						'rows'          => 6,
						'default'       => __( 'Place your content here. It will appear above the form.', 'bb-powerpack' ),
						'connections'   => array( 'string', 'html', 'url' ),
						'preview'       => array(
							'type'          => 'text',
							'selector'		=> '.pp-subscribe-content'
						)
					),
				)
			),
			'structure'     => array(
				'title'         => __( 'Form Structure', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'layout'        => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Layout', 'bb-powerpack' ),
						'default'       => 'stacked',
						'options'       => array(
							'stacked'       => __( 'Stacked', 'bb-powerpack' ),
							'inline'        => __( 'Inline', 'bb-powerpack' ),
							'compact'		=> __( 'Compact', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'stacked'	=> array(
								'fields'	=> array('btn_align', 'input_custom_width', 'inputs_space', 'btn_margin')
							),
							'inline'	=> array(
								'fields'	=> array('input_custom_width', 'inputs_space')
							),
							'compact'	=> array(
								'fields'	=> array('btn_margin')
							)
						),
						'hide'	=> array(
							'compact'	=> array(
								'fields'	=> array('input_name_width', 'input_email_width')
							)
						)
					),
					'input_custom_width'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Inputs Width', 'bb-powerpack' ),
						'default'       => 'default',
						'options'       => array(
							'default'          => __( 'Default', 'bb-powerpack' ),
							'custom'          => __( 'Custom', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('input_name_width', 'input_email_width', 'input_button_width')
							)
						)
					),
					'input_name_width' 	=> array(
                        'type'          	=> 'unit',
                        'label'         	=> __('Name Field Width', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array('%'),
                        'default'       	=> '',
                    ),
					'input_email_width'	=> array(
                        'type'          	=> 'unit',
                        'label'         	=> __('Email Field Width', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array('%'),
                        'default'       	=> '',
                    ),
					'input_button_width'=> array(
                        'type'          	=> 'unit',
                        'label'         	=> __('Button Width', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array('%'),
                        'default'       	=> '',

                    ),
					'inputs_space'      => array(
                        'type'          	=> 'unit',
                        'label'         	=> __('Spacing Between Inputs', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array('%'),
                        'default'       	=> 1,
                    ),
					'show_name'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Name Field', 'bb-powerpack' ),
						'default'       => 'show',
						'options'       => array(
							'show'          => __( 'Show', 'bb-powerpack' ),
							'hide'          => __( 'Hide', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'show'			=> array(
								'fields'		=> array('input_name_placeholder')
							)
						)
					),
					'checkbox_field'	=> array(
						'type'          => 'pp-switch',
						'label'         => __( 'Checkbox Field', 'bb-powerpack' ),
						'default'       => 'hide',
						'options'       => array(
							'show'          => __( 'Show', 'bb-powerpack' ),
							'hide'          => __( 'Hide', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'show'			=> array(
								'fields'		=> array('checkbox_field_text')
							)
						)
					),
					'input_name_placeholder' 	=> array(
                        'type'          	=> 'text',
                        'label'         	=> __('Name Field Placeholder Text', 'bb-powerpack'),
                        'description'   	=> '',
                        'default'       	=> __('Name', 'bb-powerpack'),
                    ),
					'input_email_placeholder' 	=> array(
                        'type'          	=> 'text',
                        'label'         	=> __('Email Field Placeholder Text', 'bb-powerpack'),
                        'description'   	=> '',
                        'default'       	=> __('Email Address', 'bb-powerpack'),
					),
					'checkbox_field_text'	=> array(
						'type'					=> 'text',
						'label'					=> __('Checkbox Field Text'),
						'default'				=> __('I accept the Terms & Conditions', 'bb-powerpack')
					)
				),
			),
			'form_footer'	=> array(
				'title'			=> __( 'Footer', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'footer_text' => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'rows'          => 8,
						'default'       => '',
						'preview'       => array(
							'type'			=> 'text',
							'selector'		=> '.pp-subscribe-form .pp-subscribe-form-footer'	

						)
					),
				)
			)
		)
	),
	'success'	=> array(
		'title'		=> __('Success', 'bb-powerpack'),
		'sections'	=> array(
			'success'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'custom_subject'	=> array(
						'type'				=> 'text',
						'label'				=> __('Notification Subject', 'bb-powerpack'),
						'default'			=> '',
						'placeholder'		=> __('Subscribe Form Signup', 'bb-powerpack'),
					),
					'success_action' => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Success Action', 'bb-powerpack' ),
						'default'		=> 'message',
						'options'       => array(
							'message'       => __( 'Message', 'bb-powerpack' ),
							'redirect'      => __( 'Redirect', 'bb-powerpack' )
						),
						'toggle'        => array(
							'message'       => array(
								'sections'		=> array('form_success_typography'),
								'fields'        => array( 'success_message', 'success_message_color' )
							),
							'redirect'      => array(
								'fields'        => array( 'success_url' )
							)
						),
						'preview'       => array(
							'type'             => 'none'
						)
					),
					'success_message' => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'rows'          => 8,
						'default'       => __( 'Thanks for subscribing! Please check your email for further instructions.', 'bb-powerpack' ),
						'connections'   => array( 'string', 'html', 'url' ),
						'preview'       => array(
							'type'             => 'none'
						)
					),
					'success_url'  => array(
						'type'          => 'link',
						'label'         => __( 'Success URL', 'bb-powerpack' ),
						'show_target'	=> true,
						'show_nofollow'	=> true,
						'connections'   => array( 'url' ),
						'preview'       => array(
							'type'             => 'none'
						)
					)
				)
			)
		)
	),
	'subscribe_form_style'	=> array(
		'title'	=> __('Style', 'bb-powerpack'),
		'sections'	=> array(
			'box_bg_setting'	=> array(
				'title'				=> __('Box Style', 'bb-powerpack'),
				'fields'			=> array(
					'box_bg'			=> array(
						'type'          	=> 'color',
	                    'label'         	=> __('Background Color', 'bb-powerpack'),
	                    'default'       	=> 'ffffff',
						'show_reset'    	=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
	                    'preview'       	=> array(
	                        'type'      		=> 'css',
	                        'selector'  		=> '.pp-subscribe-box',
	                        'property'  		=> 'background-color'
	                    )
					),
					'box_border_radius' 	=> array(
                        'type'          => 'unit',
                        'label'         => __('Round Corners', 'bb-powerpack'),
                        'default'       => 2,
						'slider'		=> true,
						'units'	 	    => array('px'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-subscribe-box',
                            'property'  => 'border-radius',
                            'unit'      => 'px'
                        )
					),
					'box_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Content Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-subscribe-content',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
				)
			),
			'box_overlay'	=> array(
				'title'				=> __('Overlay', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'show_overlay'		=> array(
						'type'				=> 'pp-switch',
						'label'				=> __('Show Overlay', 'bb-powerpack'),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __('Yes', 'bb-powerpack'),
							'no'				=> __('No', 'bb-powerpack')
						),
						'toggle'			=> array(
							'yes'				=> array(
								'fields'			=> array('overlay_color', 'overlay_opacity')
							)
						),
						'preview'       	=> array(
	                        'type'      		=> 'none',
	                    )
					),
					'overlay_color'		=> array(
						'type'          	=> 'color',
	                    'label'         	=> __('Color', 'bb-powerpack'),
	                    'default'       	=> '000000',
						'show_reset'    	=> false,
						'connections'		=> array('color'),
	                    'preview'       	=> array(
	                        'type'      		=> 'none',
	                    )
					),
					'overlay_opacity'	=> array(
	                    'type'          	=> 'unit',
	                    'label'             => __('Opacity', 'bb-powerpack'),
	                    'slider'          	=> true,
	                    'units'				=> array('%'),
	                    'default'           => '50',
						'preview'       	=> array(
	                        'type'      		=> 'none',
	                    )
	                ),
				)
			),
			'form_corners_padding'      => array( // Section
				'title'         => __('Form Structure', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
					'form_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
						'default'			=> 15,
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-subscribe-form',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                )
            ),
			'form_bg_setting'	=> array(
				'title'		=> __('Form Background', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
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
	                            'fields'    => array('form_bg_color')
	                        ),
	                        'image' => array(
	                            'fields'    => array('form_bg_image','form_bg_size','form_bg_repeat')
	                        )
	                    )
	                ),
	                'form_bg_color'     => array(
	                    'type'          => 'color',
	                    'label'         => __('Background Color', 'bb-powerpack'),
	                    'default'       => 'ffffff',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
	                    'preview'       => array(
	                        'type'      => 'css',
	                        'selector'  => '.pp-subscribe-form',
	                        'property'  => 'background-color'
	                    )
	                ),
	                'form_bg_image'     => array(
	                	'type'              => 'photo',
	                    'label'         	=> __('Background Image', 'bb-powerpack'),
	                    'default'       	=> '',
	                    'preview'       	=> array(
	                        'type'      		=> 'css',
	                        'selector'  		=> '.pp-subscribe-form',
	                        'property'  		=> 'background-image'
	                    )
	                ),
	                'form_bg_size'      => array(
	                    'type'         		=> 'pp-switch',
	                    'label'         	=> __('Background Size', 'bb-powerpack'),
	                    'default'       	=> 'cover',
	                    'options'       	=> array(
	                        'contain'   		=> __('Contain', 'bb-powerpack'),
	                        'cover'     		=> __('Cover', 'bb-powerpack'),
	                    )
	                ),
	                'form_bg_repeat'    => array(
	                    'type'          	=> 'pp-switch',
	                    'label'         	=> __('Background Repeat', 'bb-powerpack'),
	                    'default'       	=> 'no-repeat',
	                    'options'       	=> array(
	                        'repeat-x'      	=> __('Repeat X', 'bb-powerpack'),
	                        'repeat-y'      	=> __('Repeat Y', 'bb-powerpack'),
	                        'no-repeat'     	=> __('No Repeat', 'bb-powerpack'),
	                    )
	                ),
				)
			),
			'form_border_setting'	=> array( // Section
				'title'         		=> __('Border', 'bb-powerpack'), // Section Title
				'collapsed'				=> true,
				'fields'        		=> array( // Section Fields
					'form_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
					),
                )
            ),
		)
	),
	'input_style'   => array(
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
                            'selector'              => '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
                            'property'              => 'color'
                        )
                    ),
                    'input_field_bg_color'      => array(
                        'type'                  => 'color',
                        'label'                 => __('Background Color', 'bb-powerpack'),
                        'default'               => 'ffffff',
						'show_reset'            => true,
						'show_alpha'			=> true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
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
                            'selector'          => '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
                            'property'          => 'border-color'
                        )
                    ),
					'input_border_width'   => array(
                        'type'          => 'pp-multitext',
						'description'	=> 'px',
						'label'         => __('Border Width', 'bb-powerpack'),
                        'default'       => array(
                            'top'   => 1,
                            'bottom'   => 1,
                            'left'   => 1,
							'right'	=> 1
                        ),
						'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.pp-subscribe-form input[type=text], .pp-subscribe-form input[type=email]',
                                    'property'  => 'border-top-width',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.pp-subscribe-form input[type=text], .pp-subscribe-form input[type=email]',
                                    'property'  => 'border-bottom-width',
                                    'unit'      => 'px'
                                )
                            ),
                            'left' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Left', 'bb-powerpack'),
                                'tooltip'       => __('Left', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-left',
                                'preview'       => array(
                                    'selector'  => '.pp-subscribe-form input[type=text], .pp-subscribe-form input[type=email]',
                                    'property'  => 'border-left-width',
                                    'unit'      => 'px'
                                )
                            ),
                            'right' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Right', 'bb-powerpack'),
                                'tooltip'       => __('Right', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-right',
                                'preview'       => array(
                                    'selector'  => '.pp-subscribe-form input[type=text], .pp-subscribe-form input[type=email]',
                                    'property'  => 'border-right-width',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    ),
                    'input_field_focus_color'      => array(
                        'type'                  => 'color',
                        'label'                 => __('Focus Border Color', 'bb-powerpack'),
                        'default'               => '719ece',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-subscribe-form textarea:focus, .pp-subscribe-form input[type=text]:focus, .pp-subscribe-form input[type=tel]:focus, .pp-subscribe-form input[type=email]:focus',
                            'property'          => 'border-color'
                        )
                    ),
                )
            ),
            'input_general_style'      => array( // Section
				'title'         => __('Structure', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'input_field_border_radius'	=> array(
                        'type'						=> 'unit',
                        'label'						=> __('Round Corners', 'bb-powerpack'),
						'slider'					=> true,
                        'units'						=> array('px'),
                        'default'					=> '2',
                        'preview'					=> array(
                            'type'						=> 'css',
                            'selector'					=> '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
                            'property'					=> 'border-radius',
                            'unit'						=> 'px'
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
                            'selector'  => '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
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
						'default'			=> 10,
                        'preview'			=> array(
                            'type'				=> 'css',
							'selector'  		=> '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
							'property'  		=> 'padding',
							'unit'      		=> 'px'
                        ),
                        'responsive'		=> true,
					),
					'input_height' => array(
						'type'          => 'unit',
						'label'         => __( 'Height', 'bb-powerpack' ),
						'default'       => '38',
						'units'		    => array('px'),
						'slider'     	=> true,
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
                        'default'               => 'dddddd',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-subscribe-form input[type=text]::-webkit-input-placeholder, .pp-subscribe-form input[type=tel]::-webkit-input-placeholder, .pp-subscribe-form input[type=email]::-webkit-input-placeholder, .pp-subscribe-form textarea::-webkit-input-placeholder',
                            'property'          => 'color'
                        )
                    ),
                )
            ),
        )
    ),
	'button'        => array(
		'title'         => __( 'Button', 'bb-powerpack' ),
		'sections'      => array(
			'btn_general'   => array(
				'title'         => '',
				'fields'        => array(
					'btn_text'      		=> array(
						'type'          		=> 'text',
						'label'         		=> __( 'Button Text', 'bb-powerpack' ),
						'default'       		=> __( 'Subscribe!', 'bb-powerpack' )
					),
					'btn_icon'      		=> array(
						'type'          		=> 'icon',
						'label'         		=> __( 'Button Icon', 'bb-powerpack' ),
						'show_remove'   		=> true
					),
					'btn_icon_size'    		=> array(
                        'type'					=> 'unit',
                        'label'					=> __('Icon Size', 'bb-powerpack'),
                        'default'				=> '14',
						'slider'          		=> true,
                        'units'					=> array('px'),
                        'preview'				=> array(
                            'type'                 => 'css',
                            'selector'             => '.pp-subscribe-form a.fl-button .fl-button-icon, .pp-subscribe-form a.fl-button .fl-button-icon:before',
                            'property'             => 'font-size',
                            'unit'                 => 'px'
                        )
                    ),
					'btn_icon_position'		=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Icon Position', 'bb-powerpack'),
						'default'				=> 'before',
						'options'				=> array(
							'before'				=> __('Before Text', 'bb-powerpack'),
							'after'					=> __('After Text', 'bb-powerpack')
						)
					),
					'btn_icon_animation'	=> array(
						'type'          		=> 'select',
						'label'         		=> __('Icon Visibility', 'bb-powerpack'),
						'default'       		=> 'disable',
						'options'       		=> array(
							'disable'        		=> __('Always Visible', 'bb-powerpack'),
							'enable'         		=> __('Fade In On Hover', 'bb-powerpack')
						)
					)
				)
			),
			'btn_colors'     => array(
				'title'         => __( 'Colors', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'btn_bg_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'bb-powerpack' ),
						'default'       => '3074b0',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'btn_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'bb-powerpack' ),
						'default'       => '428bca',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'btn_text_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'bb-powerpack' ),
						'default'       => 'ffffff',
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'btn_text_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Hover Color', 'bb-powerpack' ),
						'default'       => 'ffffff',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					)
				)
			),
			'btn_style'     => array(
				'title'         => __( 'Style', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'btn_style'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Style', 'bb-powerpack' ),
						'default'       => 'flat',
						'options'       => array(
							'flat'          => __( 'Flat', 'bb-powerpack' ),
							'gradient'      => __( 'Gradient', 'bb-powerpack' ),
						),
					),
					'btn_bg_opacity' => array(
						'type'          => 'unit',
						'label'         => __( 'Background Opacity', 'bb-powerpack' ),
						'default'       => '100',
						'units'		    => array('%'),
						'slider'     	=> true,
					),
					'btn_bg_hover_opacity' => array(
						'type'          => 'unit',
						'label'         => __('Background Hover Opacity', 'bb-powerpack'),
						'default'       => '100',
						'units'		    => array('%'),
						'slider'     	=> true,
					),
					'btn_button_transition' => array(
						'type'          => 'pp-switch',
						'label'         => __('Transition', 'bb-powerpack'),
						'default'       => 'disable',
						'options'       => array(
							'enable'         => __('Enable', 'bb-powerpack'),
							'disable'        => __('Disable', 'bb-powerpack'),
						)
					)
				)
			),
			'btn_border_setting'	=> array(
				'title'		=>	__('Border', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'button_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-subscribe-form a.fl-button',
						)
					),
					'btn_border_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Border Hover Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
				)
			),
			'btn_structure' => array(
				'title'         => __( 'Structure', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'btn_align'    	=> array(
						'type'          => 'align',
						'label'         => __('Alignment', 'bb-powerpack'),
						'default'       => 'left',
					),
					'button_padding'	=> array(
                        'type'				=> 'dimension',
                        'label'				=> __('Padding', 'bb-powerpack'),
						'slider'			=> true,
						'units'				=> array( 'px' ),
						'default'			=> 10,
                        'preview'			=> array(
                            'type'				=> 'css',
							'selector'  		=> '.pp-subscribe-form a.fl-button',
							'property'  		=> 'padding',
							'unit'      		=> 'px'
                        ),
                        'responsive'		=> true,
					),
					'btn_margin' => array(
						'type'          => 'unit',
						'label'         => __( 'Margin Top', 'bb-powerpack' ),
						'default'       => '0',
						'units'		    => array('%'),
						'slider'	    => true,
					),
					'btn_height' => array(
						'type'          => 'unit',
						'label'         => __( 'Height', 'bb-powerpack' ),
						'default'       => '38',
						'units'		    => array('px'),
						'slider'	    => true,
					),
				)
			)
		)
	),
	'form_typography'       => array( // Tab
        'title'         => __('Typography', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
			'box_content_typography'       => array( // Section
                'title'         => __('Content', 'bb-powerpack'), // Section Title
				'fields'        => array( // Section Fields
					'content_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-subscribe-content',
						),
					),
					'content_margin'       => array(
                        'type'              => 'pp-multitext',
                        'label'             => __('Margin', 'bb-powerpack'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'               => 0,
                            'bottom'            => 0,
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-powerpack'),
                                'tooltip'           => __('Top', 'bb-powerpack'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.pp-subscribe-content',
                                    'property'          => 'margin-top',
                                    'unit'              => 'px'
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-powerpack'),
                                'tooltip'           => __('Bottom', 'bb-powerpack'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.pp-subscribe-content',
                                    'property'          => 'margin-bottom',
                                    'unit'              => 'px'
                                ),
                            ),
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
							'selector' 		    => '.pp-subscribe-form textarea, .pp-subscribe-form input[type=text], .pp-subscribe-form input[type=tel], .pp-subscribe-form input[type=email]',
						),
					),
                )
			),
			'checkbox_typography'	=> array(
				'title'					=> __('Checkbox', 'bb-powerpack'),
				'collapsed'				=> true,
				'fields'				=> array(
					'checkbox_font_size'	=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Font Size', 'bb-powerpack'),
						'default'				=> 'default',
						'options'				=> array(
							'default'				=> __('Default', 'bb-powerpack'),
							'custom'				=> __('Custom', 'bb-powerpack'),
						),
						'toggle'				=> array(
							'custom'				=> array(
								'fields'				=> array('checkbox_font_size_custom')
							)
						)
					),
					'checkbox_font_size_custom'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
						'selector'      => '.pp-subscribe-form .pp-checkbox-input label',
						'property'      => 'font-size',
						'unit'          => 'px'
						),
						'responsive'	=> true,
					),
					'checkbox_text_color'	=> array(
						'type'					=> 'color',
						'label'					=> __('Checkbox Text Color', 'bb-powerpack'),
						'show_reset'			=> true,
						'connections'			=> array('color'),
						'preview'           	=> array(
							'type'					=> 'css',
							'selector'      		=> '.pp-subscribe-form .pp-checkbox-input label',
							'property'      		=> 'color',
						),
					),
				)
			),
			'placeholder_typography'	=> array(
				'title'	=> __( 'Placeholder', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'placeholder_size'    => array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Font Size', 'bb-powerpack'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-powerpack'),
                            'custom'                => __('Custom', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('placeholder_font_size')
							)
						)
					),
					'placeholder_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-subscribe-form input[type=text]::-webkit-input-placeholder, .pp-subscribe-form input[type=email]::-webkit-input-placeholder',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
					'placeholder_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-powerpack'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-powerpack'),
                            'lowercase'                => __('lowercase', 'bb-powerpack'),
                            'uppercase'                 => __('UPPERCASE', 'bb-powerpack'),
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
							'selector' 		    => '.pp-subscribe-form a.fl-button'
						),
					),
                )
            ),
			'errors_typography'       => array( // Section
				'title'         => __('Error Message', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
					'validation_error_size'    => array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Font Size', 'bb-powerpack'),
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
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'      => '.pp-subscribe-form .pp-form-error-message',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
					'error_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-powerpack'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-powerpack'),
                            'lowercase'                => __('lowercase', 'bb-powerpack'),
                            'uppercase'                 => __('UPPERCASE', 'bb-powerpack'),
                        )
					),
					'validation_message_color'    => array(
                        'type'                    => 'color',
                        'label'                   => __('Color', 'bb-powerpack'),
						'default'                 => 'dd4420',
						'connections'				=> array('color'),
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-subscribe-form .pp-form-error-message',
                            'property'            => 'color'
                        )
                    ),
                )
            ),
			'form_success_typography'    => array( // Section
				'title'             => __('Success Message', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
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
							'selector'      => '.pp-subscribe-form .pp-form-success-message',
							'property'      => 'font-size',
							'unit'          => 'px'
						),
						'responsive'	=> true,
					),
					'success_message_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-powerpack'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-powerpack'),
                            'lowercase'                => __('lowercase', 'bb-powerpack'),
                            'uppercase'                 => __('UPPERCASE', 'bb-powerpack'),
                        )
					),
					'success_message_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Color', 'bb-powerpack'),
						'default'                      => '29bb41',
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.pp-subscribe-form .pp-form-success-message',
                            'property'                 => 'color'
                        )
                    ),
                )
            ),
		),
	),
));
