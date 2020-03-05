<?php

/**
 * @class PPImageComparisonModule
 */
class PPImageComparisonModule extends FLBuilderModule {

	/**
	 * @property $data
	 */
	public $data = null;

	/**
	 * @property $_editor
	 * @protected
	 */
	protected $_editor = null;

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Image Comparison', 'bb-powerpack' ),
				'description'     => __( 'Comparison of Two Images.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'creative' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-image-comparison/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-image-comparison/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts() {
		$this->add_js( 'imagesloaded' );
		$this->add_js( 'jquery-event-move' );
		$this->add_js( 'twentytwenty' );
		$this->add_css( 'twentytwenty' );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPImageComparisonModule',
	array(
		'general'      => array(
			'title'    => __( 'General', 'bb-powerpack' ),
			'sections' => array(
				'before_image' => array(
					'title'  => __( 'Before Image', 'bb-powerpack' ),
					'fields' => array(
						'before_img_label' => array(
							'type'        => 'text',
							'label'       => __( 'Before Image Label', 'bb-powerpack' ),
							'default'     => 'Before',
							'connections' => array( 'string', 'html' ),
						),
						'before_img'       => array(
							'type'        => 'photo',
							'label'       => __( 'Image', 'bb-powerpack' ),
							'show_remove' => true,
							'connections' => array( 'photo' ),
						),
					),
				),
				'after_image'  => array(
					'title'     => __( 'After Image', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'after_img_label' => array(
							'type'        => 'text',
							'label'       => __( 'After Image Label', 'bb-powerpack' ),
							'default'     => 'After',
							'connections' => array( 'string', 'html' ),
						),
						'after_img'       => array(
							'type'        => 'photo',
							'label'       => __( 'Image', 'bb-powerpack' ),
							'show_remove' => true,
							'connections' => array( 'photo' ),
						),
					),
				),
			),
		),
		'img_settings' => array(
			'title'    => __( 'Settings', 'bb-powerpack' ),
			'sections' => array(
				'image_control' => array(
					'title'  => '',
					'fields' => array(
						'visible_ratio'   => array(
							'type'    => 'unit',
							'label'   => __( 'Visible Ratio', 'bb-powerpack' ),
							'default' => '0.5',
							'slider'  => true,
						),
						'img_orientation' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Orientation', 'bb-powerpack' ),
							'default' => 'horizontal',
							'options' => array(
								'horizontal' => __( 'Horizontal', 'bb-powerpack' ),
								'vertical'   => __( 'Vertical', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'horizontal' => array(
									'fields' => array( 'before_positon_h', 'after_positon_h' ),
								),
								'vertical'   => array(
									'fields' => array( 'before_positon_v', 'after_positon_v' ),
								),
							),
						),
						'move_slider'     => array(
							'type'    => 'select',
							'label'   => __( 'Move Slider', 'bb-powerpack' ),
							'default' => 'horizontal',
							'options' => array(
								'drag'        => __( 'Drag', 'bb-powerpack' ),
								'mouse_move'  => __( 'Mouse Move', 'bb-powerpack' ),
								'mouse_click' => __( 'Mouse Click', 'bb-powerpack' ),
							),
						),
						'display_label'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Display Before/After label', 'bb-powerpack' ),
							'default' => 'always',
							'options' => array(
								'always' => __( 'Always', 'bb-powerpack' ),
								'hover'  => __( 'on Hover', 'bb-powerpack' ),
							),
						),
						'img_max_height'  => array(
							'type'    => 'unit',
							'label'   => __( 'Max Height', 'bb-powerpack' ),
							'default' => '300',
							'slider'  => true,
							'units'   => array( 'px' ),
						),
					),
				),
			),
		),
		'style'        => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'overlay_style' => array(
					'title'  => __( 'Overlay Color', 'bb-powerpack' ),
					'fields' => array(
						'overlay_bg_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Overlay Background Color' ),
							'default'     => 'rgba(0,0,0,0.5)',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'overlay_bg_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Overlay Hover Background Color' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
					),
				),
				'handle_style'  => array(
					'title'     => __( 'Handle', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'icon_color'          => array(
							'type'        => 'color',
							'label'       => __( 'Icon Color' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'icon_color_hover'    => array(
							'type'        => 'color',
							'label'       => __( 'Icon Hover Color' ),
							'default'     => '000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'icon_bg_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Icon Background Color' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'icon_bg_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Icon Hover Background Color' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'icon_border'         => array(
							'type'       => 'border',
							'label'      => __( 'Icon Border Style', 'bb-powerpack' ),
							'responsive' => true,
						),
						'icon_border_color_h' => array(
							'type'        => 'color',
							'label'       => __( 'Border Hover Color' ),
							'default'     => '000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
					),
				),
				'divider_style' => array(
					'title'     => __( 'Divider', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'divider_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Color' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'divider_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Color on Hover' ),
							'default'     => '000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'divider_width'       => array(
							'type'       => 'unit',
							'label'      => __( 'Width', 'bb-powerpack' ),
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
					),
				),
				'before_label'  => array(
					'title'     => __( 'Before Label', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'before_positon_v' => array(
							'type'       => 'align',
							'label'      => __( 'Position', 'bb-powerpack' ),
							'default'    => 'center',
							'responsive' => true,
						),
						'before_positon_h' => array(
							'type'       => 'pp-switch',
							'label'      => __( 'Position', 'bb-powerpack' ),
							'default'    => 'center',
							'responsive' => true,
							'options'    => array(
								'top'    => __( 'Top', 'bb-powerpack' ),
								'center' => __( 'Center', 'bb-powerpack' ),
								'bottom' => __( 'Bottom', 'bb-powerpack' ),
							),
						),
						'before_align'     => array(
							'type'       => 'unit',
							'label'      => __( 'Align', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'before_color'     => array(
							'type'        => 'color',
							'label'       => __( 'Text Color' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'before_bg_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Background Color' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'before_border'    => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.twentytwenty-before-label:before',
							),
						),
						'before_padding'   => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.twentytwenty-before-label:before',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
					),
				),
				'after_label'   => array(
					'title'     => __( 'After Label', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'after_positon_v' => array(
							'type'       => 'align',
							'label'      => __( 'Position', 'bb-powerpack' ),
							'default'    => 'center',
							'responsive' => true,
						),
						'after_positon_h' => array(
							'type'       => 'pp-switch',
							'label'      => __( 'Position', 'bb-powerpack' ),
							'default'    => 'center',
							'responsive' => true,
							'options'    => array(
								'top'    => __( 'Top', 'bb-powerpack' ),
								'center' => __( 'Center', 'bb-powerpack' ),
								'bottom' => __( 'Bottom', 'bb-powerpack' ),
							),
						),
						'after_align'     => array(
							'type'       => 'unit',
							'label'      => __( 'Align', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'after_color'     => array(
							'type'        => 'color',
							'label'       => __( 'Text Color' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'after_bg_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Background Color' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'after_border'    => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.twentytwenty-after-label:before',
							),
						),
						'after_padding'   => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.twentytwenty-after-label:before',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
					),
				),
				'label_typo'    => array(
					'title'     => __( 'Label Typography', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'label_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
						),
					),
				),
			),
		),
	)
);
