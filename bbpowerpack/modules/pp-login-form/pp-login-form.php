<?php
/**
 * @class PPLoginFormModule
 */
class PPLoginFormModule extends FLBuilderModule {
    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'              => __('Login Form', 'bb-powerpack'),
            'description'       => __('A module for better login form.', 'bb-powerpack'),
            'group'             => pp_get_modules_group(),
            'category'		    => pp_get_modules_cat( 'creative' ),
            'dir'               => BB_POWERPACK_DIR . 'modules/pp-login-form/',
            'url'               => BB_POWERPACK_URL . 'modules/pp-login-form/',
            'editor_export'     => true,
            'enabled'           => true,
            'partial_refresh'   => true,
		));
	}
}

FLBuilder::register_module('PPLoginFormModule', array(
	'general'	=> array(
		'title'		=> __('General', 'bb-powerpack'),
		'sections'	=> array(
			'form_fields'	=> array(
				'title'			=> '',
				'fields'		=> array(
					'show_labels'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Label', 'bb-powerpack'),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __('Show', 'bb-powerpack'),
							'no'			=> __('Hide', 'bb-powerpack')
						),
					)
				)
			),
			'fields_label'	=> array(
				'title'			=> __('Label & Placeholder', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'username_label'	=> array(
						'type'		=> 'text',
						'label'		=> __('Username Label', 'bb-powerpack'),
						'default'	=> __('Username or Email Address', 'bb-powerpack'),
						'connections'	=> array('string')
					),
					'username_placeholder'	=> array(
						'type'		=> 'text',
						'label'		=> __('Username Placeholder', 'bb-powerpack'),
						'default'	=> __('Username or Email Address', 'bb-powerpack'),
						'connections'	=> array('string')
					),
					'password_label'	=> array(
						'type'		=> 'text',
						'label'		=> __('Password Label', 'bb-powerpack'),
						'default'	=> __('Password', 'bb-powerpack'),
						'connections'	=> array('string')
					),
					'password_placeholder'	=> array(
						'type'		=> 'text',
						'label'		=> __('Password Placeholder', 'bb-powerpack'),
						'default'	=> __('Password', 'bb-powerpack'),
						'connections'	=> array('string')
					),
				)
			),
			'button'	=> array(
				'title'		=> __('Button', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'button_text'	=> array(
						'type'			=> 'text',
						'label'			=> __('Text', 'bb-powerpack'),
						'default'		=> __('Log In', 'bb-powerpack'),
						'connections'	=> array('string')
					),
					'button_align'	=> array(
						'type'			=> 'align',
						'label'			=> __('Alignment', 'bb-powerpack'),
						'default'		=> 'left',
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group.pp-field-type-submit, .pp-field-group.pp-field-type-link',
							'property'		=> 'text-align'
						)
					)
				)
			),
			'additional_options'	=> array(
				'title'		=> __('Additional Options', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'redirect_after_login'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Redirect After Login', 'bb-powerpack'),
						'default'	=> 'no',
						'options'	=> array(
							'yes'		=> __('Yes', 'bb-powerpack'),
							'no'		=> __('No', 'bb-powerpack')
						),
						'toggle'	=> array(
							'yes'		=> array(
								'fields'	=> array('redirect_url')
							)
						)
					),
					'redirect_url'	=> array(
						'type'			=> 'text',
						'label'			=> __('Redirect URL', 'bb-powerpack'),
						'description'	=> __('Note: Because of security reasons, you can ONLY use your current domain.', 'bb-powerpack'),
						'connections'	=> array('url', 'string')
					),
					'redirect_after_logout'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Redirect After Logout', 'bb-powerpack'),
						'default'	=> 'no',
						'options'	=> array(
							'yes'		=> __('Yes', 'bb-powerpack'),
							'no'		=> __('No', 'bb-powerpack')
						),
						'toggle'	=> array(
							'yes'		=> array(
								'fields'	=> array('redirect_logout_url')
							)
						)
					),
					'redirect_logout_url'	=> array(
						'type'			=> 'text',
						'label'			=> __('Redirect URL', 'bb-powerpack'),
						'description'	=> __('Note: Because of security reasons, you can ONLY use your current domain.', 'bb-powerpack'),
						'connections'	=> array('url', 'string')
					),
					'show_lost_password'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Show Password Reset Link', 'bb-powerpack'),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack')
						),
						'toggle'		=> array(
							'yes'			=> array(
								'fields'		=> array('lost_password_text')
							)
						)
					),
					'lost_password_text'	=> array(
						'type'		=> 'text',
						'label'		=> __('Text', 'bb-powerpack'),
						'default'	=> __('Lost your password?', 'bb-powerpack'),
						'preview'	=> array(
							'type'		=> 'text',
							'selector'	=> '.pp-field-group .pp-login-lost-password'
						),
						'connections'	=> array('string')
					),
					'show_register'		=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Show Register Link', 'bb-powerpack'),
						'help'			=> __('This option will only be available if the registration is enabled in WP admin general settings.', 'bb-powerpack'),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack')
						),
					),
					'show_remember_me'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Show Remember Me', 'bb-powerpack'),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack')
						),
						'toggle'		=> array(
							'yes'			=> array(
								'fields'		=> array('remember_me_text')
							)
						)
					),
					'remember_me_text'	=> array(
						'type'		=> 'text',
						'label'		=> __('Text', 'bb-powerpack'),
						'default'	=> __('Remember Me', 'bb-powerpack'),
						'preview'	=> array(
							'type'		=> 'text',
							'selector'	=> '.pp-field-group .pp-login-remember-me'
						),
						'connections'	=> array('string')
					),
					'show_logged_in_message'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Show Logged in Message', 'bb-powerpack'),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack')
						)
					)
				)
			)
		)
	),
	'style'		=> array(
		'title'		=> __('Style', 'bb-powerpack'),
		'sections'		=> array(
			'general_style'	=> array(
				'title'			=> __('General', 'bb-powerpack'),
				'fields'		=> array(
					'fields_spacing'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Fields Spacing', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group',
							'property'		=> 'margin-bottom',
							'unit'			=> 'px'
						)
					),
					'links_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Links Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group > a',
							'property'		=> 'color',
						)
					),
					'links_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Links Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
				)
			),
			'form_style'	=> array(
				'title'			=> __('Form', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'form_bg_color'		=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-login-form',
							'property'		=> 'background-color'
						)
					),
					'form_padding'	=> array(
						'type'			=> 'dimension',
						'label'			=> __('Padding', 'bb-powerpack'),
						'default'		=> '',
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-login-form',
							'property'		=> 'padding',
							'unit'			=> 'px'
						)
					),
					'form_border'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-login-form'
						)
					)
				)
			),
			'label_style'	=> array(
				'title'			=> __('Label', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'label_spacing'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Spacing', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group > label',
							'property'		=> 'margin-bottom',
							'unit'			=> 'px'
						)
					),
					'label_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group > label',
							'property'		=> 'color',
						)
					)
				)
			),
			'fields_style'	=> array(
				'title'			=> __('Fields', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'field_text_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--input',
							'property'		=> 'color',
						)
					),
					'field_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--input',
							'property'		=> 'background-color',
						)
					),
					'field_height'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Height', 'bb-powerpack'),
						'default'		=> '',
						'slider'		=> true,
						'responsive'	=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--input',
							'property'		=> 'height',
							'unit'			=> 'px'
						)
					),
					'field_padding'	=> array(
						'type'			=> 'dimension',
						'label'			=> __('Padding', 'bb-powerpack'),
						'default'		=> '',
						'slider'		=> true,
						'responsive'	=> true,
						'units'			=> array('px'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--input',
							'property'		=> 'padding',
							'unit'			=> 'px'
						)
					),
					'field_border'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--input',
						)
					),
					'field_border_focus_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Border Focus Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					)
				)
			),
			'button_style'	=> array(
				'title'			=> __('Button', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'button_text_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--button',
							'property'		=> 'color',
						)
					),
					'button_text_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none',
						)
					),
					'button_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--button',
							'property'		=> 'background-color',
						)
					),
					'button_bg_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none',
						)
					),
					'button_border'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--button',
						)
					),
					'button_border_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Border Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none',
						)
					),
					'button_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '',
						'slider'			=> true,
						'units'				=> array('px'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-field-group .pp-login-form--button',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
					'button_width'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Width', 'bb-powerpack'),
						'default'		=> '',
						'help'			=> __('Leave empty for default width.', 'bb-powerpack'),
						'slider'		=> true,
						'responsive'	=> true,
						'units'			=> array('px', '%'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-field-group .pp-login-form--button',
							'property'		=> 'width',
						)
					)
				)
			)
		)
	),
	'typography'	=> array(
		'title'			=> __('Typography', 'bb-powerpack'),
		'sections'		=> array(
			'label_typography'	=> array(
				'title'				=> __('Label', 'bb-powerpack'),
				'fields'			=> array(
					'label_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-field-group > label',
						)
					),
				)
			),
			'fields_typography'	=> array(
				'title'				=> __('Fields', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'fields_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-field-group .pp-login-form--input',
						)
					),
				)
			),
			'button_typography'	=> array(
				'title'				=> __('Button', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'button_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-field-group .pp-login-form--button',
						)
					),
				)
			),
		)
	)
) );