<?php
/**
 * @class PPSearchFormModule
 */
class PPSearchFormModule extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'              => __('Search Form', 'bb-powerpack'),
            'description'       => __('A module for better search form.', 'bb-powerpack'),
            'group'             => pp_get_modules_group(),
            'category'		    => pp_get_modules_cat( 'content' ),
            'dir'               => BB_POWERPACK_DIR . 'modules/pp-search-form/',
            'url'               => BB_POWERPACK_URL . 'modules/pp-search-form/',
            'editor_export'     => true,
            'enabled'           => true,
            'partial_refresh'   => true,
        ));
	}

	public function render_input_attrs() {
		$attrs = array(
			'placeholder'	=> $this->settings->placeholder,
			'class' 		=> 'pp-search-form__input',
			'type' 			=> 'search',
			'name' 			=> 's',
			'title' 		=> __( 'Search', 'bb-powerpack' ),
			'value' 		=> get_search_query(),
		);

		$attr_str = '';

		foreach ( $attrs as $key => $value ) {
			$attr_str .= ' ' . $key . '="' . $value . '"';
		}

		echo $attr_str;
	}
}

FLBuilder::register_module('PPSearchFormModule', array(
	'general'		=> array(
		'title'			=> __('General', 'bb-powerpack'),
		'sections'		=> array(
			'general'		=> array(
				'title'			=> '',
				'fields'		=> array(
					'style'			=> array(
						'type'			=> 'select',
						'label'			=> __('Layout', 'bb-powerpack'),
						'default'		=> 'classic',
						'options'		=> array(
							'classic'		=> __('Classic', 'bb-powerpack'),
							'minimal'		=> __('Minimal', 'bb-powerpack'),
							'full_screen'	=> __('Full Screen', 'bb-powerpack')
						),
						'toggle'		=> array(
							'classic'		=> array(
								'sections'		=> array('size', 'button', 'button_style', 'button_typography'),
							),
							'minimal'		=> array(
								'fields'		=> array('size', 'input_icon_size')
							),
							'full_screen'	=> array(
								'sections'		=> array('toggle_size', 'toggle', 'toggle_style', 'overlay')
							)
						)
					),
					'placeholder'	=> array(
						'type'			=> 'text',
						'label'			=> __('Placeholder', 'bb-powerpack'),
						'default'		=> __('Search', 'bb-powerpack'),
						'connections'	=> array('string'),
					),
					'toggle_size'		=> array(
						'type'			=> 'unit',
						'label'			=> __('Toggle Size', 'bb-powerpack'),
						'default'		=> '50',
						'slider'		=> true,
					),
					'size'			=> array(
						'type'			=> 'unit',
						'label'			=> __('Form Height', 'bb-powerpack'),
						'default'		=> '50',
						'slider'		=> true,
					),
				)
			),
			'button'	=> array(
				'title'		=> __('Button', 'bb-powerpack'),
				'fields'	=> array(
					'button_type'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Type', 'bb-powerpack'),
						'default'		=> 'icon',
						'options'		=> array(
							'icon'			=> __('Icon', 'bb-powerpack'),
							'text'			=> __('Text', 'bb-powerpack')
						),
						'toggle'		=> array(
							'icon'			=> array(
								'fields'		=> array('icon', 'icon_size')
							),
							'text'			=> array(
								'sections'		=> array('button_typography'),
								'fields'		=> array('button_text')
							)
						)
					),
					'icon'			=> array(
						'type'			=> 'icon',
						'label'			=> __('Icon', 'bb-powerpack'),
						'default'		=> 'fa fa-search',
						'show_remove'	=> true
					),
					'button_text'	=> array(
						'type'			=> 'text',
						'label'			=> __('Text', 'bb-powerpack'),
						'default'		=> __('Search', 'bb-powerpack'),
						'connections'	=> array('string'),
						'preview'		=> array(
							'type'			=> 'text',
							'selector'		=> '.pp-search-form--button-type-text .pp-search-form__submit'
						)
					)
				)
			),
			'toggle'	=> array(
				'title'		=> __('Toggle', 'bb-powerpack'),
				'fields'	=> array(
					'toggle_icon'	=> array(
						'type'			=> 'icon',
						'label'			=> __('Icon', 'bb-powerpack'),
						'default'		=> 'fa fa-search',
						'show_remove'	=> true
					),
					'toggle_align'	=> array(
						'type'			=> 'align',
						'label'			=> __('Alignment', 'bb-powerpack'),
						'default'		=> 'center',
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form--style-full_screen .pp-search-form',
							'property'		=> 'text-align'
						)
					),
				)
			)
		)
	),
	'style'		=> array(
		'title'		=> __('Style', 'bb-powerpack'),
		'sections'	=> array(
			'input_style'	=> array(
				'title'		=> __('Input', 'bb-powerpack'),
				'fields'	=> array(
					'input_icon_size'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Icon Size', 'bb-powerpack'),
						'default'		=> '',
						'slider'		=> true,
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form__icon i',
							'property'		=> 'font-size',
							'unit'			=> 'px'
						)
					),
					'input_height'		=> array(
						'type'			=> 'unit',
						'label'			=> __('Input Height', 'bb-powerpack'),
						'default'		=> '50',
						'slider'		=> true,
						'responsive'	=> true,
					),
					'input_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form-wrap:not(.pp-search-form--style-full_screen) .pp-search-form__container:not(.pp-search-form--lightbox)',
							'property'		=> 'background-color'
						)
					),
					'input_focus_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Focus Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form-wrap:not(.pp-search-form--style-full_screen) .pp-search-form--focus .pp-search-form__container:not(.pp-search-form--lightbox)',
							'property'		=> 'background-color'
						)
					),
					'input_placeholder_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Placeholder Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none',
						)
					),
					'input_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form__input',
							'property'		=> 'color'
						)
					),
					'input_focus_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Focus Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form__input:focus',
							'property'		=> 'color'
						)
					),
					'input_border'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border & Shadow', 'bb-powerpack'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form__container:not(.pp-search-form--lightbox)'
						)
					),
					'input_focus_border_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Border Focus Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form--focus .pp-search-form__container:not(.pp-search-form--lightbox)',
							'property'		=> 'border-color'
						)
					)
				)
			),
			'button_style'	=> array(
				'title'			=> __('Button', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'button_bg_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'property'			=> 'background-color',
							'selector'			=> '.pp-search-form__submit'
						)
					),
					'button_bg_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Hover Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'property'			=> 'background-color',
							'selector'			=> '.pp-search-form__submit:hover'
						)
					),
					'button_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text/Icon Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'property'		=> 'color',
							'selector'		=> '.pp-search-form__submit'
						)
					),
					'button_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text/Icon Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'property'		=> 'color',
							'selector'		=> '.pp-search-form__submit:hover'
						)
					),
					'icon_size'		=> array(
						'type'			=> 'unit',
						'label'			=> __('Icon Size', 'bb-powerpack'),
						'default'		=> '16',
						'slider'		=> true,
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form--button-type-icon .pp-search-form__submit',
							'property'		=> 'font-size',
							'unit'			=> 'px'
						)
					),
					'button_width'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Width', 'bb-powerpack'),
						'default'		=> '1',
						'slider'		=> array(
							'min'			=> '1',
							'max'			=> '10',
							'step'			=> '.1'
						),
						'responsive'	=> true,
					)
				)
			),
			'toggle_style'		=> array(
				'title'				=> __('Toggle', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'toggle_icon_bg_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-search-form__toggle i',
							'property'			=> 'background-color'
						)
					),
					'toggle_icon_bg_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Hover Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-search-form__toggle:hover i',
							'property'			=> 'background-color'
						)
					),
					'toggle_icon_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-search-form__toggle i',
							'property'			=> 'color'
						)
					),
					'toggle_icon_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Hover Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-search-form__toggle:hover i',
							'property'			=> 'color'
						)
					),
					'toggle_icon_size'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Icon Size', 'bb-powerpack'),
						'default'		=> '',
						'slider'		=> true,
					),
					'toggle_icon_border_width'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Border Width', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form__toggle i',
							'property'		=> 'border-width',
							'unit'			=> 'px'
						)
					),
					'toggle_icon_radius'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Radius', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-search-form__toggle i',
							'property'		=> 'border-radius',
							'unit'			=> 'px'
						)
					),
				)
			),
			'overlay'		=> array(
				'title'			=> __('Overlay', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'overlay_bg_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-search-form--style-full_screen .pp-search-form__container',
							'property'			=> 'background-color'
						)
					)
				)
			)
		)
	),
	'typography'	=> array(
		'title'			=> __('Typography', 'bb-powerpack'),
		'sections'		=> array(
			'input_typography'	=> array(
				'title'				=> __('Input', 'bb-powerpack'),
				'fields'			=> array(
					'input_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> 'input[type="search"].pp-search-form__input'
						)
					)
				)
			),
			'button_typography'	=> array(
				'title'				=> __('Button', 'bb-powerpack'),
				'fields'			=> array(
					'button_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'typography',
							'selector'			=> '.pp-search-form--button-type-text .pp-search-form__submit'
						)
					)
				)
			)
		)
	)
));