<?php

/**
 * @class FLIconGroupModule
 */
class PPSocialIconsModule extends FLBuilderModule {

	public $_enabled_icons = '';

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Social Icons', 'bb-powerpack'),
			'description'   	=> __('Display a group of linked social icons.', 'bb-powerpack'),
			'group'         	=> pp_get_modules_group(),
            'category'			=> pp_get_modules_cat( 'content' ),
            'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-social-icons/',
            'url'           	=> BB_POWERPACK_URL . 'modules/pp-social-icons/',
			'editor_export' 	=> true,
			'partial_refresh'	=> true,
		));

		$this->_enabled_icons = FLBuilderModel::get_enabled_icons();
		
		$this->add_css( BB_POWERPACK()->fa_css );
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle old link, link_target, link_nofollow fields.
		$settings = PP_Module_Fields::handle_link_field( $settings, array(
			'link'			=> array(
				'type'			=> 'link'
			),
			'link_target'	=> array(
				'type'			=> 'target'
			),
		), 'link' );

		return $settings;
	}

	static public function get_labels()
	{
		$labels = array(
			'custom'		=> __('Custom Icon', 'bb-powerpack'),
			'fa-envelope'	=> __('Email', 'bb-powerpack'),
			'fa-facebook'	=> __('Facebook', 'bb-powerpack'),
			'fa-twitter'	=> __('Twitter', 'bb-powerpack'),
			'fa-google-plus'=> __('Google Plus', 'bb-powerpack'),
			'fa-youtube'	=> __('YouTube', 'bb-powerpack'),
			'fa-linkedin'	=> __('LinkedIn', 'bb-powerpack'),
			'fa-pinterest-p'=> __('Pinterest', 'bb-powerpack'),
			'fa-instagram'	=> __('Instagram', 'bb-powerpack'),
			'fa-dribbble'	=> __('Dribbble', 'bb-powerpack'),
			'fa-flickr'		=> __('Flickr', 'bb-powerpack'),
			'fa-github-alt'	=> __('GitHub', 'bb-powerpack'),
			'fa-rss'		=> __('RSS', 'bb-powerpack'),
			'fa-vimeo'		=> __('Vimeo', 'bb-powerpack'),
		);

		return $labels;
	}

	/**
	 * Returns button link rel based on settings
	 * @since 2.6.9
	 */
	public function get_rel( $target, $nofollow = 'no' ) {
		$rel = array();
		if ( '_blank' == $target ) {
			$rel[] = 'noopener';
		}
		if ( 'yes' == $nofollow ) {
			$rel[] = 'nofollow';
		}
		$rel = implode( ' ', $rel );
		if ( $rel ) {
			$rel = ' rel="' . $rel . '" ';
		}
		return $rel;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPSocialIconsModule', array(
	'icons'         => array(
		'title'         => __('Icons', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'icons'         => array(
						'type'          => 'form',
						'label'         => __('Icon', 'bb-powerpack'),
						'form'          => 'social_icon_form', // ID from registered form below
						'preview_text'  => 'icon', // Name of a field to use for the preview text
						'multiple'      => true,
					)
				)
			)
		)
	),
	'style'         => array( // Tab
		'title'         => __('Style', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
			'colors'        => array( // Section
				'title'         => __('Colors', 'bb-powerpack'), // Section Title
				'fields'        => array( // Section Fields
					'color'         => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'hover_color' => array(
						'type'          => 'color',
						'label'         => __('Hover Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'bg_color'      => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Background Hover Color', 'bb-powerpack'),
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
				)
			),
			'structure'     => array( // Section
				'title'         => __('Structure', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
				'fields'        => array( // Section Fields
					'size'          => array(
						'type'          => 'unit',
						'label'         => __('Size', 'bb-powerpack'),
                        'default'       => '30',
						'units'   		=> array('px'),
						'slider'		=> true,
						'responsive'	=> true
					),
					'box_size'		=> array(
						'type'          => 'unit',
						'label'         => __('Box Size', 'bb-powerpack'),
                        'default'       => '60',
						'units'   		=> array('px'),
						'slider'		=> true,
						'responsive'	=> true
					),
					'spacing'       => array(
						'type'          => 'unit',
						'label'         => __('Spacing', 'bb-powerpack'),
                        'default'       => '10',
						'units'   		=> array('px'),
						'slider'		=> true,
						'responsive'	=> true
					),
					'border_width'	=> array(
						'type'          => 'unit',
						'label'         => __('Border', 'bb-powerpack'),
                        'default'       => '0',
						'units'   		=> array('px'),
						'slider'		=> true,
					),
					'border_color'  => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'border_hover_color'  => array(
						'type'          => 'color',
						'label'         => __('Border Hover Color', 'bb-powerpack'),
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'radius'		=> array(
						'type'          => 'unit',
						'label'         => __('Round Corners', 'bb-powerpack'),
                        'default'       => '100',
						'units'   		=> array('px'),
						'slider'		=> true,
					),
					'direction'		=> array(
						'type'          => 'pp-switch',
						'label'         => __('Layout', 'bb-powerpack'),
						'default'       => 'horizontal',
						'options'       => array(
							'horizontal'    => __('Horizontal', 'bb-powerpack'),
							'vertical'      => __('Vertical', 'bb-powerpack'),
						)
					),
					'align'         => array(
						'type'          => 'align',
						'label'         => __('Desktop Alignment', 'bb-powerpack'),
						'default'       => 'left',
					),
				)
			),
			'responsive'	=> array(
				'title'			=> __('Responsive', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'		=> array(
					'breakpoint'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Breakpoint', 'bb-powerpack'),
						'default'		=> 768,
						'units'   		=> array('px'),
						'slider'		=> true,
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'responsive_align' => array(
						'type'          => 'align',
						'label'         => __('Alignment', 'bb-powerpack'),
						'default'       => 'center',
					)
				)
			)
		)
	)
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('social_icon_form', array(
	'title' => __('Add Icon', 'bb-powerpack'),
	'tabs'  => array(
		'general'       => array( // Tab
			'title'         => __('General', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
				'general'       => array( // Section
					'title'         => '', // Section Title
					'fields'        => array( // Section Fields
						'icon'          => array(
							'type'          => 'select',
							'label'         => __('Icon', 'bb-powerpack'),
							'default'		=> '',
							'options'		=> PPSocialIconsModule::get_labels(),
							'toggle'		=> array(
								'custom'		=> array(
									'fields'		=> array('icon_custom', 'icon_custom_title')
								)
							)
						),
						'icon_custom'	=> array(
							'type'			=> 'icon',
							'label'         => __('Custom Icon', 'bb-powerpack'),
						),
						'icon_custom_title'	=> array(
							'type'				=> 'text',
							'label'				=> __('Custom Title', 'bb-powerpack'),
							'default'			=> '',
							'help'				=> __('Add custom title for HTML "title" attribute.', 'bb-powerpack')
						),
						'link'  => array(
							'type'          => 'link',
							'label'         => __('Link', 'bb-powerpack'),
							'placeholder'   => 'http://www.example.com',
							'show_target'	=> true,
							'show_nofollow'	=> true,
							'connections'   => array( 'url' ),
							'preview'       => array(
								'type'          => 'none'
							)
						),
					)
				)
			)
		),
		'style'         => array( // Tab
			'title'         => __('Style', 'bb-powerpack'), // Tab title
			'sections'      => array( // Tab Sections
				'colors'        => array( // Section
					'title'         => __('Colors', 'bb-powerpack'), // Section Title
					'fields'        => array( // Section Fields
						'color'         => array(
							'type'          => 'color',
							'label'         => __('Color', 'bb-powerpack'),
							'show_reset'    => true,
							'connections'	=> array('color'),
						),
						'hover_color' => array(
							'type'          => 'color',
							'label'         => __('Hover Color', 'bb-powerpack'),
							'show_reset'    => true,
							'connections'	=> array('color'),
							'preview'       => array(
								'type'          => 'none'
							)
						),
						'bg_color'      => array(
							'type'          => 'color',
							'label'         => __('Background Color', 'bb-powerpack'),
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
						),
						'bg_hover_color' => array(
							'type'          => 'color',
							'label'         => __('Background Hover Color', 'bb-powerpack'),
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array('color'),
							'preview'       => array(
								'type'          => 'none'
							)
						)
					)
				),
				'border'	=> array(
					'title'		=> __('Border', 'bb-powerpack'),
					'collapsed'			=> true,
					'fields'	=> array(
						'border_width'	=> array(
							'type'          => 'unit',
							'label'         => __('Border', 'bb-powerpack'),
							'default'       => '0',
							'units'   		=> array('px'),
							'slider'		=> true,
						),
						'border_color'  => array(
							'type'          => 'color',
							'label'         => __('Border Color', 'bb-powerpack'),
							'show_reset'    => true,
							'connections'	=> array('color'),
						),
						'border_hover_color'  => array(
							'type'          => 'color',
							'label'         => __('Border Hover Color', 'bb-powerpack'),
							'show_reset'    => true,
							'connections'	=> array('color'),
						),
					)
				)
			)
		)
	)
));
