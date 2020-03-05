<?php

/**
 * @class PPContactFormModule
 */
class PPContactFormModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Contact Form', 'bb-powerpack'),
            'description'   => __('Advanced module for Contact Form.', 'bb-powerpack'),
			'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'form_style' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-contact-form/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-contact-form/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
		));

		add_action('wp_ajax_pp_send_email', array($this, 'send_mail'));
        add_action('wp_ajax_nopriv_pp_send_email', array($this, 'send_mail'));
        add_filter( 'script_loader_tag', array( $this, 'add_async_attribute' ), 10, 2 );
    }
    
    /**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts() {
		$settings = $this->settings;
		if ( isset( $settings->recaptcha_toggle ) && 'show' == $settings->recaptcha_toggle
			&& isset( $settings->recaptcha_site_key ) && ! empty( $settings->recaptcha_site_key )
			) {

			$site_lang = substr( get_locale(), 0, 2 );
			$post_id    = FLBuilderModel::get_post_id();

			$this->add_js(
				'g-recaptcha',
				'https://www.google.com/recaptcha/api.js?onload=onLoadFLReCaptcha&render=explicit&hl=' . $site_lang,
				array( 'fl-builder-layout-' . $post_id ),
				'2.0',
				true
			);
		}
	}

	/**
	 * @method  add_async_attribute for the enqueued `g-recaptcha` script
	 * @param string $tag    Script tag
	 * @param string $handle Registered script handle
	 */
	public function add_async_attribute( $tag, $handle ) {
		if ( ('g-recaptcha' !== $handle) || ('g-recaptcha' === $handle && strpos( $tag, 'g-recaptcha-api' ) !== false ) ) {
			return $tag;
		}

		return str_replace( ' src', ' id="g-recaptcha-api" async="async" defer="defer" src', $tag );
	}

	/**
	 * Connects Beaver Themer field connections before sending mail
	 * as those won't be connected during a wp_ajax call.
	 *
	 * @method connect_field_connections_before_send
	 */
	public function connect_field_connections_before_send() {
		if ( class_exists( 'FLPageData' ) && isset( $_REQUEST['layout_id'] ) ) {

			$posts = query_posts( array(
				'p' => absint( $_REQUEST['layout_id'] ),
				'post_type' => 'any',
			) );

			if ( count( $posts ) ) {
				global $post;
				$post = $posts[0];
				setup_postdata( $post );
				FLPageData::init_properties();
			}
		}
	}

	/**
	 * @method send_mail
	 */
	public function send_mail() {

	    // Try to connect Themer connections before sending.
		self::connect_field_connections_before_send();

		// Get the contact form post data
    	$node_id			= isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
    	$template_id    	= isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
        $template_node_id   = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;
        $recaptcha_response	= isset( $_POST['recaptcha_response'] ) ? $_POST['recaptcha_response'] : false;

		$subject 			= (isset($_POST['subject']) ? $_POST['subject'] : __('Contact Form Submission', 'bb-powerpack'));
		$admin_email 		= get_option('admin_email');
		$site_name 			= get_option( 'blogname' );

		if ( $site_name ) {
			$site_name = apply_filters( 'pp_contact_form_from_name', html_entity_decode( $site_name ) );
		}

		$response = array(
			'error' 	=> true,
			'message' 	=> __( 'Message failed. Please try again.', 'bb-powerpack' ),
		);

		if ( $node_id ) {

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

			if ( isset($settings->mailto_email) && !empty($settings->mailto_email) ) {
				$mailto   = $settings->mailto_email;
			} else {
				$mailto   = $mailto;
			}

			if ( isset( $settings->subject_toggle ) && ( 'hide' == $settings->subject_toggle ) && isset( $settings->subject_hidden ) && ! empty( $settings->subject_hidden ) ) {
				$subject   = $settings->subject_hidden;
			}

			// Validate reCAPTCHA if enabled
			if ( isset( $settings->recaptcha_toggle ) && 'show' == $settings->recaptcha_toggle && $recaptcha_response ) {
				if ( ! empty( $settings->recaptcha_secret_key ) && ! empty( $settings->recaptcha_site_key ) ) {
					if ( version_compare( phpversion(), '5.3', '>=' ) ) {
						include FLBuilderModel::$modules['pp-contact-form']->dir . 'includes/validate-recaptcha.php';
					} else {
						$response['error'] = false;
					}
				} else {
					$response = array(
						'error' => true,
						'message' => __( 'Your reCAPTCHA Site or Secret Key is missing!', 'bb-powerpack' ),
					);
				}
			} else {
				$response['error'] = false;
			}

			$pp_contact_from_email = (isset($_POST['email']) ? sanitize_email($_POST['email']) : null);
			$pp_contact_from_name = (isset($_POST['name']) ? $_POST['name'] : '');

			$headers = array(
				'From: ' . $site_name . ' <' . $admin_email . '>',
				  'Reply-To: ' . $pp_contact_from_name . ' <' . $pp_contact_from_email . '>',
			);

			// Build the email
			$template = "";

			if ( isset( $_POST['name'] ) ) {  $template .= "Name: $_POST[name] \r\n";
			}
			if ( isset( $_POST['email'] ) ) { $template .= "Email: $_POST[email] \r\n";
			}
			if ( isset( $_POST['phone'] ) ) { $template .= "Phone: $_POST[phone] \r\n";
			}

			$msg = '';

			if ( isset( $settings->message_toggle ) && 'show' == $settings->message_toggle ) {
				$msg = isset( $_POST['message'] ) ? stripslashes( $_POST['message'] ) : '';
			}

			$template .= __('Message', 'bb-powerpack') . ": \r\n" . $msg;

			// Double check the mailto email is proper and no validation error found, then send.
			if ( $mailto && false === $response['error'] ) {
				
				$subject = esc_html( do_shortcode( $subject ) );
				$mailto  = esc_html( do_shortcode( $mailto ) );

				/**
				 * Before sending with wp_mail()
				 * @see pp_contact_form_before_send
				 */
				do_action( 'pp_contact_form_before_send', $mailto, $subject, $template, $headers, $settings );
				$result = wp_mail( $mailto, $subject, $template, $headers );

				/**
				 * After sending with wp_mail()
				 * @see pp_contact_form_after_send
				 */
				do_action( 'pp_contact_form_after_send', $mailto, $subject, $template, $headers, $settings, $result );
				$response['message'] = __( 'Sent!', 'bb-powerpack' );
				$response['error'] = false;
			}

			wp_send_json( $response );
		}
	}

	public function filter_settings( $settings, $helper ) {
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
			'form_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'     	=> ( isset( $settings->form_shadow_display ) && 'yes' == $settings->form_shadow_display ),
			),
			'form_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'     	=> ( isset( $settings->form_shadow_display ) && 'yes' == $settings->form_shadow_display ),
				'opacity'			=> isset( $settings->form_shadow_opacity ) ? ( $settings->form_shadow_opacity / 100 ) : 1,
			),
		), 'form_border_group' );

		// Handle Form old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'form_padding', 'padding', 'form_padding' );

		// Handle Input old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'input_field_padding', 'padding', 'input_field_padding' );

		// Handle Button old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'button_padding', 'padding', 'button_padding' );

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
				'type'			=> 'text_transform',
			),
			'input_field_text_alignment'	=> array(
				'type'			=> 'text_align',
			),
		), 'input_typography' );

		// Handle Checkbox's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'checkbox_font_size_custom'	=> array(
				'type'          => 'font_size',
				'condition'     => ( isset( $settings->checkbox_font_size ) && 'custom' == $settings->checkbox_font_size )
			),
			'checkbox_text_transform'	=> array(
				'type'			=> 'text_transform',
			),
		), 'checkbox_typography' );

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

		// Handle Label old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'label_font_size', 'responsive', 'label_font_size' );

		// Handle Validation Error old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'validation_error_font_size', 'responsive', 'validation_error_font_size' );

		// Handle Success Message old Font field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'success_message_font_size', 'responsive', 'success_message_font_size' );

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
FLBuilder::register_module('PPContactFormModule', array(
	'general'       => array(
		'title'         => __('General', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'mailto_email'     => array(
						'type'          => 'text',
						'label'         => __('Send To Email', 'bb-powerpack'),
						'default'       => '',
						'placeholder'   => __('example@mail.com', 'bb-powerpack'),
						'help'          => __('The contact form will send to this e-mail. Defaults to the admin email.', 'bb-powerpack'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'form_layout'   => array(
                        'type'          => 'select',
                        'label'         => __('Layout', 'bb-powerpack'),
                        'default'       => 'stacked',
                        'options'       => array(
                            'stacked'      => __('Stacked', 'bb-powerpack'),
                            'inline'     => __('Inline', 'bb-powerpack'),
							'stacked-inline'     => __('Stacked + Inline', 'bb-powerpack'),
                        ),
                    ),
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
                                'fields'  => array('custom_title', 'custom_description', 'title_tag'),
                            ),
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
						'connections'   	=> array('string', 'html'),
                        'preview'           => array(
                            'type'          => 'text',
                            'selector'      => '.pp-form-description'
                        )
                    ),
				)
			),
			'form_fields'	=> array(
				'title'			=> __('Fields', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'name_toggle'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Name Field', 'bb-powerpack'),
						'default'       => 'show',
						'options'       => array(
							'show'      => __('Show', 'bb-powerpack'),
							'hide'      => __('Hide', 'bb-powerpack'),
						)
					),
					'email_toggle'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Email Field', 'bb-powerpack'),
						'default'       => 'show',
						'options'       => array(
							'show'      => __('Show', 'bb-powerpack'),
							'hide'      => __('Hide', 'bb-powerpack'),
						)
					),
					'phone_toggle'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Phone Field', 'bb-powerpack'),
						'default'       => 'hide',
						'options'       => array(
							'show'      => __('Show', 'bb-powerpack'),
							'hide'      => __('Hide', 'bb-powerpack'),
						)
					),
					'subject_toggle'	=> array(
						'type'		  		=> 'pp-switch',
						'label'		  		=> __( 'Subject Field', 'bb-powerpack' ),
						'default'		  	=> 'hide',
						'options'		  	=> array(
							'show'	   			=> __( 'Show', 'bb-powerpack' ),
							'hide'	   			=> __( 'Hide', 'bb-powerpack' ),
						),
						'toggle'			=> array(
							'hide'				=> array(
								'fields'			=> array( 'subject_hidden' ),
							),
						),
					),
					'subject_hidden'	=> array(
						'type'		  		=> 'text',
						'label'		  		=> __( 'Email Subject', 'bb-powerpack' ),
						'default'			=> __( 'Contact Form Submission', 'bb-powerpack' ),
						'connections'		=> array( 'string' ),
						'help'				=> __( 'You can choose the subject of the email. Defaults to Contact Form Submission.', 'bb-powerpack' ),
					),
					'message_toggle'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Message Field', 'bb-powerpack'),
						'default'       => 'show',
						'options'       => array(
							'show'      => __('Show', 'bb-powerpack'),
							'hide'      => __('Hide', 'bb-powerpack'),
						)
					),
					'checkbox_toggle'	=> array(
						'type'          => 'pp-switch',
						'label'         => __('Custom Checkbox Field', 'bb-powerpack'),
						'default'       => 'hide',
						'options'       => array(
							'show'      => __('Show', 'bb-powerpack'),
							'hide'      => __('Hide', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'show'			=> array(
								'fields'		=> array('checked_default', 'checkbox_label')
							)
						)
					),
					'checked_default'	=> array(
						'type'          => 'pp-switch',
						'label'         => __('Checked by default', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'      		=> __('Yes', 'bb-powerpack'),
							'no'      		=> __('No', 'bb-powerpack'),
						),
					),
				)
			),
			'custom_labels'	=> array(
				'title'			=> __('Custom Labels', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'display_labels'   => array(
                        'type'         => 'pp-switch',
                        'label'        => __('Labels', 'bb-powerpack'),
                        'default'      => 'block',
                        'options'      => array(
                            'block'    => __('Show', 'bb-powerpack'),
                            'none'     => __('Hide', 'bb-powerpack'),
                        ),
                    ),
					'name_label'	=> array(
						'type'			=> 'text',
						'label'			=> __('Name', 'bb-powerpack'),
						'default'		=> _x( 'Name', 'Contact form Name field label.', 'bb-powerpack' ),
						'connections'	=> array( 'string' )
					),
					'email_label'	=> array(
						'type'			=> 'text',
						'label'			=> __('Email', 'bb-powerpack'),
						'default'		=> _x( 'Email', 'Contact form Email field label.', 'bb-powerpack' ),
						'connections'	=> array( 'string' )
					),
					'phone_label'	=> array(
						'type'			=> 'text',
						'label'			=> __('Phone', 'bb-powerpack'),
						'default'		=> _x( 'Phone', 'Contact form Phone field label.', 'bb-powerpack' ),
						'connections'	=> array( 'string' )
					),
					'subject_label'	=> array(
						'type'			=> 'text',
						'label'			=> __('Subject', 'bb-powerpack'),
						'default'		=> _x( 'Subject', 'Contact form Subject field label.', 'bb-powerpack' ),
						'connections'	=> array( 'string' )
					),
					'message_label'	=> array(
						'type'			=> 'text',
						'label'			=> __('Message', 'bb-powerpack'),
						'default'		=> _x( 'Your Message', 'Contact form Message field label.', 'bb-powerpack' ),
						'connections'	=> array( 'string' )
					),
					'checkbox_label'	=> array(
						'type'			=> 'text',
						'label'			=> __('Custom Checkbox Field', 'bb-powerpack'),
						'default'		=> _x( 'I accept the Terms & Conditions', 'Contact form custom checkbox label.', 'bb-powerpack' ),
						'connections'	=> array( 'string' )
					)
				)
			),
			'success'       => array(
				'title'         => __( 'Success', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'success_action' => array(
						'type'          => 'select',
						'label'         => __( 'Success Action', 'bb-powerpack' ),
						'options'       => array(
							'none'          => __( 'None', 'bb-powerpack' ),
							'show_message'  => __( 'Show Message', 'bb-powerpack' ),
							'redirect'      => __( 'Redirect', 'bb-powerpack' )
						),
						'toggle'        => array(
							'show_message'       => array(
								'fields'        => array( 'success_message' ),
								'sections'		=> array('form_success_styling', 'form_success_typography')
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
						'default'       => __( 'Thanks for your message! We’ll be in touch soon.', 'bb-powerpack' ),
						'connections'	=> array( 'string', 'html' ),
						'preview'       => array(
							'type'             => 'none'
						)
					),
					'success_url'  => array(
						'type'          => 'link',
						'label'         => __( 'Success URL', 'bb-powerpack' ),
						'show_target'	=> true,
						'show_nofollow'	=> true,
						'connections'	=> array( 'url' ),
						'preview'       => array(
							'type'             => 'none'
						)
					)
				)
			)
		)
	),
	'form_style'	=> array(
		'title'	=> __('Style', 'bb-powerpack'),
		'sections'	=> array(
			'form_bg_setting'	=> array(
				'title'	=> __('Form Background', 'bb-powerpack'),
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
	                    'default'       => '',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
	                    'preview'       => array(
	                        'type'      => 'css',
	                        'selector'  => '.pp-contact-form',
	                        'property'  => 'background-color'
	                    )
	                ),
	                'form_bg_image'     => array(
	                	'type'          => 'photo',
	                    'label'         => __('Background Image', 'bb-powerpack'),
	                    'default'       => '',
	                    'preview'       => array(
	                        'type'      => 'css',
	                        'selector'  => '.pp-contact-form',
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
				)
			),
			'form_border_setting'      => array( // Section
				'title'         => __('Form Border', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'form_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border Style', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-contact-form',
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
                            'selector'			=> '.pp-contact-form',
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
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.pp-contact-form .pp-form-title',
                                    'property'  => 'margin-top',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.pp-contact-form .pp-form-title',
                                    'property'  => 'margin-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    )
                )
            ),
            'description_style' => array( // Section
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
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.pp-contact-form .pp-form-description',
                                    'property'  => 'margin-top',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.pp-contact-form .pp-form-description',
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
                            'selector'              => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
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
                            'selector'          => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
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
                            'selector'          => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                            'property'          => 'border-color'
                        )
                    ),
                    'input_field_border_width'    => array(
                        'type'                    => 'unit',
                        'label'                   => __('Border Width', 'bb-powerpack'),
                        'units'  	  	          => array('px'),
                        'slider'                  => true,
                        'default'                 => '1',
                        'preview'                 => array(
                            'type'                => 'css',
                            'rules'                 => array(
                                array(
                                    'selector'            => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                                    'property'            => 'border-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                                    'property'            => 'border-top-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                                    'property'            => 'border-bottom-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                                    'property'            => 'border-left-width',
                                    'unit'                => 'px',
                                ),
                                array(
                                    'selector'            => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
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
                            'selector'            => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
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
                            'selector'          => '.pp-contact-form textarea:focus, .pp-contact-form input[type=text]:focus, .pp-contact-form input[type=tel]:focus, .pp-contact-form input[type=email]:focus',
                            'property'          => 'border-color'
                        )
                    ),
                )
            ),
            'input_size_style'      => array( // Section
				'title'         => __('Size & Alignment', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'input_field_height'    => array(
                        'type'                    => 'unit',
                        'label'                   => __('Input Height', 'bb-powerpack'),
                        'units'		              => array('px'),
                        'slider'                  => true,
                        'default'                 => '32',
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
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
                            'selector'            => '.pp-contact-form textarea',
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
                        'units'		               => array('px'),
                        'slider'                   => true,
                        'default'                  => '2',
                        'preview'                  => array(
                            'type'                 => 'css',
                            'selector'             => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                            'property'             => 'border-radius',
                            'unit'                 => 'px'
                        )
                    ),
                    'input_field_box_shadow'   => array(
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
                    'input_shadow_color'      => array(
                        'type'          => 'color',
                        'label'         => __('Shadow Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
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
                            'selector'			=> '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
                    'input_field_margin'    => array(
                        'type'              => 'unit',
                        'label'             => __('Margin Bottom', 'bb-powerpack'),
                        'units'		        => array('px'),
                        'slider'            => true,
                        'default'           => '10',
                        'preview'           => array(
                            'type'          => 'css',
                            'selector'      => '.pp-contact-form .pp-input-group',
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
                        'default'               => '',
						'show_reset'            => true,
						'connections'			=> array('color'),
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.pp-contact-form input[type=text]::-webkit-input-placeholder, .pp-contact-form input[type=tel]::-webkit-input-placeholder, .pp-contact-form input[type=email]::-webkit-input-placeholder, .pp-contact-form textarea::-webkit-input-placeholder',
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
					'btn_text'      => array(
						'type'          => 'text',
						'label'         => __( 'Text', 'bb-powerpack' ),
						'default'       => __( 'Send', 'bb-powerpack' )
					),
					'btn_icon'      => array(
						'type'          => 'icon',
						'label'         => __( 'Icon', 'bb-powerpack' ),
						'show_remove'   => true
					),
					'btn_icon_position' => array(
						'type'          => 'pp-switch',
						'label'         => __('Icon Position', 'bb-powerpack'),
						'default'       => 'after',
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
				'title'         => __( 'Button Colors', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'btn_bg_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'btn_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'btn_text_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'btn_text_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Hover Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					)
				)
			),
			'btn_style'     => array(
				'title'         => __( 'Button Style', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'btn_style'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Style', 'bb-powerpack' ),
						'default'       => 'flat',
						'options'       => array(
							'flat'          => __( 'Flat', 'bb-powerpack' ),
							'gradient'      => __( 'Gradient', 'bb-powerpack' ),
							'transparent'   => __( 'Transparent', 'bb-powerpack' )
						),
						'toggle'        => array(
							'flat'			=> array(
								'fields'		=> array( 'btn_border_width', 'btn_border_color', 'btn_border_hover_color' )
							),
							'gradient'		=> array(
								'fields'		=> array( 'btn_border_width', 'btn_border_color', 'btn_border_hover_color' )
							),
							'transparent'   => array(
								'fields'        => array( 'btn_bg_opacity', 'btn_bg_hover_opacity', 'btn_border_size' )
							)
						)
					),
					'btn_bg_opacity' => array(
						'type'          => 'unit',
						'label'         => __( 'Background Opacity', 'bb-powerpack' ),
						'default'       => '0',
						'units'		    => array('%'),
						'slider'        => true,
					),
					'btn_bg_hover_opacity' => array(
						'type'          => 'unit',
						'label'         => __('Background Hover Opacity', 'bb-powerpack'),
						'default'       => '0',
						'units'		    => array('%'),
						'slider'        => true,
					),
					'btn_button_transition' => array(
						'type'          => 'pp-switch',
						'label'         => __('Transition', 'bb-powerpack'),
						'default'       => 'disable',
						'options'       => array(
							'enable'         => __('Enabled', 'bb-powerpack'),
							'disable'        => __('Disabled', 'bb-powerpack'),
						)
					)
				)
			),
			'btn_border'	=> array(
				'title'			=> __('Border', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'btn_border_size' => array(
						'type'          => 'unit',
						'label'         => __( 'Border Width', 'bb-powerpack' ),
						'default'       => '2',
						'units'		    => array('px'),
						'slider'        => true,
					),
					'btn_border_width' => array( 
						'type'          => 'unit',
						'label'         => __( 'Border Width', 'bb-powerpack' ),
						'default'       => '',
						'units'		    => array('px'),
						'slider'        => true,
					),
					'btn_border_style' => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Border Style', 'bb-powerpack' ),
						'default'       => 'solid',
						'options'		=> array(
							'dashed'		=> __('Dashed', 'bb-powerpack'),
							'dotted'		=> __('Dotted', 'bb-powerpack'),
							'solid'			=> __('Solid', 'bb-powerpack'),
						)
					),
					'btn_border_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Border Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'	=> array('color'),
					),
					'btn_border_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Border Hover Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'	=> array('color'),
					),
				)
			),
			'btn_structure' => array(
				'title'         => __( 'Button Structure', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'btn_width'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Width', 'bb-powerpack'),
						'default'       => 'auto',
						'options'       => array(
							'auto'          => _x( 'Auto', 'Width.', 'bb-powerpack' ),
							'full'          => __('Full Width', 'bb-powerpack')
						)
					),
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
                        'preview'			=> array(
                            'type'				=> 'css',
                            'selector'			=> '.pp-contact-form a.fl-button',
                            'property'			=> 'padding',
                            'unit'				=> 'px'
                        ),
                        'responsive'		=> true,
					),
					'button_margin'   => array(
						'type'          => 'unit',
						'label'         => __( 'Margin Top', 'bb-powerpack' ),
						'default'       => '10',
						'slider'     	=> true,
						'units'			=> array('px'),
					),
					'btn_border_radius' => array(
						'type'          => 'unit',
						'label'         => __( 'Round Corners', 'bb-powerpack' ),
						'default'       => '4',
						'slider'     	=> true,
						'units'			=> array('px'),
					)
				)
			)
		)
	),
	'form_messages_setting' => array(
        'title' => __('Messages', 'bb-powerpack'),
        'sections'  => array(
			'form_messages'	=> array(
				'title'			=> '',
				'fields'		=> array(
					'error_message'	=> array(
						'type'		=> 'text',
						'label'		=> __( 'Error Message', 'bb-powerpack' ),
						'default'	=> __( 'Message failed. Please try again.', 'bb-powerpack' ),
						'preview'	=> array(
							'type'		=> 'text',
							'selector'	=> '.pp-send-error',
						),
					),
				),
			),
			'form_error_styling'    => array( // Section
                'title'             => __('Errors', 'bb-powerpack'), // Section Title
                'fields'            => array( // Section Fields
                    'validation_message_color'    => array(
                        'type'                    => 'color',
                        'label'                   => __('Error Field Message Color', 'bb-powerpack'),
						'default'                 => 'dd4420',
						'connections'				=> array('color'),
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.pp-contact-form .pp-contact-error',
                            'property'            => 'color'
                        )
                    ),
					'validation_field_border_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Error Field Border Color', 'bb-powerpack'),
                        'default'                      => 'dd4420',
						'show_reset'                   => true,
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.pp-contact-form .pp-error textarea, .pp-contact-form .pp-error input[type=text], .pp-contact-form .pp-error input[type=tel], .pp-contact-form .pp-error input[type=email]',
                            'property'                 => 'border-color'
                        )
                    ),
                )
            ),
			'form_success_styling'    => array( // Section
				'title'         => __('Success Message', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'        => array( // Section Fields
                    'success_message_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Color', 'bb-powerpack'),
						'default'                      => '29bb41',
						'connections'					=> array('color'),
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.pp-contact-form .pp-success-msg',
                            'property'                 => 'color'
                        )
                    ),
                )
            ),
		)
	),
	'form_typography'       => array( // Tab
        'title'         => __('Typography', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
			'title_typography'       => array( // Section
                'title'         => __('Title', 'bb-powerpack'), // Section Title
				'fields'        => array( // Section Fields
					'title_tag'		=> array(
						'type'			=> 'select',
						'label'			=> __('HTML Tag', 'bb-powerpack'),
						'default'		=> 'h3',
						'options'		=> array(
							'h1'			=> 'H1',
							'h2'			=> 'H2',
							'h3'			=> 'H3',
							'h4'			=> 'H4',
							'h5'			=> 'H5',
							'h6'			=> 'H6'
						),
					),
					'title_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-contact-form .pp-form-title',
						),
					),
                    'title_color'       => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-contact-form .pp-form-title',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'description_typography'    => array(
				'title' 	=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'description_typography'	=> array(
						'type'        	   => 'typography',
						'label'       	   => __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   => true,
						'preview'          => array(
							'type'         		=> 'css',
							'selector' 		    => '.pp-contact-form .pp-form-description',
						),
					),
                    'description_color' => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-contact-form .pp-form-description',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
			'label_typography'       => array( // Section
				'title'         => __('Label', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
                    'label_font_family' => array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-powerpack'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.pp-contact-form label'
                        )
                    ),
					'label_size'    		=> array(
                        'type'                      => 'pp-switch',
                        'label'                     => __('Font Size', 'bb-powerpack'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-powerpack'),
                            'custom'                => __('Custom', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('label_font_size')
							)
						)
					),
					'label_font_size'		=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'		=> '.pp-contact-form label',
							'property'		=> 'font-size',
							'unit'			=> 'px'
						),
						'responsive'	=> true,
					),
                    'label_text_transform'	=> array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-powerpack'),
                        'default'                   => '',
                        'options'                   => array(
                            ''							=> __('Default', 'bb-powerpack'),
                            'none'                  	=> __('None', 'bb-powerpack'),
                            'lowercase'                	=> __('lowercase', 'bb-powerpack'),
                            'uppercase'                 => __('UPPERCASE', 'bb-powerpack'),
                        )
                    ),
                    'form_label_color'  	=> array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-powerpack'),
                        'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.pp-contact-form label',
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
							'selector' 		    => '.pp-contact-form textarea, .pp-contact-form input[type=text], .pp-contact-form input[type=tel], .pp-contact-form input[type=email]',
						),
					),
                )
			),
			'checkbox_typography'	=> array(
				'title'					=> __('Checkbox', 'bb-powerpack'),
				'collapsed'				=> true,
				'fields'				=> array(
					'checkbox_typography'	=> array(
						'type'					=> 'typography',
						'label'       	   		=> __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   		=> true,
						'preview'          		=> array(
							'type'         			=> 'css',
							'selector' 		    	=> '.pp-contact-form .pp-checkbox label',
						),
					),
                    'checkbox_color'			=> array(
                        'type'          	=> 'color',
                        'label'         	=> __('Color', 'bb-powerpack'),
                        'default'       	=> '',
						'show_reset'    	=> true,
						'connections'		=> array('color'),
                        'preview'       	=> array(
                            'type'      		=> 'css',
                            'selector'  		=> '.pp-contact-form .pp-checkbox label',
                            'property'  		=> 'color'
                        )
                    ),
				)
			),
			'button_typography'			=> array( // Section
				'title'         => __('Button', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
				'fields'        => array( // Section Fields
					'button_typography'	=> array(
						'type'				=> 'typography',
						'label'       	   	=> __( 'Typography', 'bb-powerpack' ),
						'responsive'  	   	=> true,
						'preview'          	=> array(
							'type'         		=> 'css',
							'selector' 		   	=> '.pp-contact-form a.fl-button',
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
					'validation_error_font_size'    => array(
						'type'			=> 'unit',
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'		=> '.pp-contact-form .pp-contact-error',
							'property'		=> 'font-size',
							'unit'			=> 'px'
						),
						'responsive'	=> true,
					),
                )
            ),
			'form_success_typography'	=> array( // Section
				'title'             => __('Success Message', 'bb-powerpack'), // Section Title
				'collapsed'		=> true,
                'fields'            => array( // Section Fields
					'success_message_size'    	=> array(
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
					'success_message_font_size'	=> array(
						'type'			=> 'unit',
						'label'         => __('Custom Font Size', 'bb-powerpack'),
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'selector'		=> '.pp-contact-form .pp-success-msg',
							'property'		=> 'font-size',
							'unit'			=> 'px'
						),
						'responsive'	=> true,
					),
                )
            ),
		)
    ),
    'reCAPTCHA'	=> array(
		'title'		  => __( 'reCAPTCHA', 'bb-powerpack' ),
		'sections'	  => array(
			'recaptcha_general' => array(
				'title'			=> '',
				'fields'		=> array(
					'recaptcha_toggle' => array(
						'type' 			=> 'pp-switch',
						'label' 		=> 'reCAPTCHA Field',
						'default'		  => 'hide',
						'options'		  => array(
							'show'	   => __( 'Show', 'bb-powerpack' ),
							'hide'	   => __( 'Hide', 'bb-powerpack' ),
						),
						'toggle' 		=> array(
							'show'        => array(
								'fields' 	=> array( 'recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_validate_type', 'recaptcha_theme' ),
							),
						),
						'help' 			=> __( 'If you want to show this field, please provide valid Site and Secret Keys.', 'bb-powerpack' ),
					),
					'recaptcha_site_key'		=> array(
						'type'			=> 'text',
						'label' 		=> __( 'Site Key', 'bb-powerpack' ),
						'default'		  => '',
						'preview'		  => array(
							'type'		   => 'none',
						),
					),
					'recaptcha_secret_key'	=> array(
						'type'			=> 'text',
						'label' 		=> __( 'Secret Key', 'bb-powerpack' ),
						'default'		  => '',
						'preview'		  => array(
							'type'		   => 'none',
						),
					),
					'recaptcha_validate_type' => array(
						'type'          		=> 'select',
						'label'         		=> __( 'Validate Type', 'bb-powerpack' ),
						'default'       		=> 'normal',
						'options'       		=> array(
							'normal'  				=> __( '"I\'m not a robot" checkbox', 'bb-powerpack' ),
							'invisible'     		=> __( 'Invisible', 'bb-powerpack' ),
						),
						'help' 					=> __( 'Validate users with checkbox or in the background.<br />Note: Checkbox and Invisible types use seperate API keys.', 'bb-powerpack' ),
						'preview'      		 	=> array(
							'type'          		=> 'none',
						),
					),
					'recaptcha_theme'   => array(
						'type'          	=> 'pp-switch',
						'label'         	=> __( 'Theme', 'bb-powerpack' ),
						'default'       	=> 'light',
						'options'       	=> array(
							'light'  			=> __( 'Light', 'bb-powerpack' ),
							'dark'     			=> __( 'Dark', 'bb-powerpack' ),
						),
						'preview'      		 	=> array(
							'type'          		=> 'none',
						),
					),
				),
			),
		),
		'description'	  => sprintf( __( 'Please register keys for your website at the <a%s>Google Admin Console</a>.', 'bb-powerpack' ), ' href="https://www.google.com/recaptcha/admin" target="_blank"' ),
	),
));
