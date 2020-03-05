<?php

/**
 * @class PPImageScrollModule
 */
class PPImageScrollModule extends FLBuilderModule {

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
				'name'            => __( 'Image Scroll', 'bb-powerpack' ),
				'description'     => __( 'Upload a photo or display one from the media library and .', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'creative' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-image-scroll/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-image-scroll/',
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
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPImageScrollModule',
	array(
		'general' => array(
			'title'    => __( 'General', 'bb-powerpack' ),
			'sections' => array(
				'general'        => array(
					'title'  => __( 'Image', 'bb-powerpack' ),
					'fields' => array(
						'photo_source' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Image Source', 'bb-powerpack' ),
							'default' => 'library',
							'options' => array(
								'library' => __( 'Media Library', 'bb-powerpack' ),
								'url'     => __( 'URL', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'library' => array(
									'fields' => array( 'photo' ),
								),
								'url'     => array(
									'fields' => array( 'photo_url' ),
								),
							),
						),
						'photo'        => array(
							'type'        => 'photo',
							'label'       => __( 'Image', 'bb-powerpack' ),
							'connections' => array( 'photo' ),
						),
						'photo_url'    => array(
							'type'        => 'text',
							'label'       => __( 'Image URL', 'bb-powerpack' ),
							'placeholder' => __( 'http://www.example.com/my-photo.jpg', 'bb-powerpack' ),
						),
						'photo_height' => array(
							'type'       => 'unit',
							'label'      => __( 'Image Height', 'bb-powerpack' ),
							'default'    => '250',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'link'         => array(
							'type'          => 'link',
							'label'         => __( 'Link', 'bb-powerpack' ),
							'placeholder'   => 'http://www.example.com',
							'show_target'   => true,
							'show_nofollow' => true,
							'connections'   => array( 'url' ),
							'preview'       => array(
								'type' => 'none',
							),
						),
					),
				),
				'image_control'  => array(
					'title'     => __( 'Settings', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'img_trigger'  => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Trigger on', 'bb-powerpack' ),
							'default' => 'hover',
							'options' => array(
								'hover'  => __( 'Hover', 'bb-powerpack' ),
								'scroll' => __( 'Mouse Scroll', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'hover' => array(
									'fields' => array( 'scroll_speed', 'reverse_dir' ),
								),
							),
						),
						'scroll_speed' => array(
							'type'    => 'unit',
							'label'   => __( 'Scroll Speed', 'bb-powerpack' ),
							'slider'  => true,
							'default' => '3',
						),
						'scroll_dir'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Scroll Direction', 'bb-powerpack' ),
							'default' => 'Vertical',
							'options' => array(
								'horizontal' => __( 'Horizontal', 'bb-powerpack' ),
								'vertical'   => __( 'Vertical', 'bb-powerpack' ),
							),
						),
						'reverse_dir'  => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Reverse Direction', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
				'image_overlay'  => array(
					'title'     => __( 'Image Overlay', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'image_overlay' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Image Overlay', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'sections' => array( 'overlay_enable', 'overlay_style', 'icon_style' ),
								),
							),
						),
					),
				),
				'overlay_enable' => array(
					'title'     => __( 'Overlay Settings', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'overlay_type'    => array(
							'type'    => 'select',
							'label'   => __( 'Overlay Type', 'bb-powerpack' ),
							'default' => 'iocn',
							'options' => array(
								'icon'      => __( 'Icon', 'bb-powerpack' ),
								'text'      => __( 'Text', 'bb-powerpack' ),
								'icon_text' => __( 'Icon + Text', 'bb-powerpack' ),
								'image'     => __( 'Image', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'icon'      => array(
									'fields' => array( 'overlay_icon', 'icon_size' ),
								),
								'text'      => array(
									'fields' => array( 'overlay_text', 'icon_typography' ),
								),
								'icon_text' => array(
									'fields' => array( 'overlay_icon', 'overlay_text', 'icon_position', 'icon_size', 'icon_typography', 'space_icon_text' ),
								),
								'image'     => array(
									'fields' => array( 'overlay_image', 'icon_size' ),
								),
							),
						),
						'overlay_icon'    => array(
							'type'        => 'icon',
							'label'       => __( 'Icon', 'bb-powerpack' ),
							'show_remove' => true,
						),
						'overlay_text'    => array(
							'type'  => 'text',
							'label' => __( 'Text', 'bb-powerpack' ),
						),
						'overlay_image'   => array(
							'type'        => 'photo',
							'label'       => __( 'Image Icon', 'bb-powerpack' ),
							'show_remove' => true,
							'connections' => array( 'photo' ),
						),
						'icon_position'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Icon Position', 'bb-powerpack' ),
							'default' => 'before',
							'options' => array(
								'before' => __( 'Before', 'bb-powerpack' ),
								'after'  => __( 'After', 'bb-powerpack' ),
								'above'  => __( 'Above', 'bb-powerpack' ),
								'below'  => __( 'Below', 'bb-powerpack' ),
							),
						),
						'space_icon_text' => array(
							'type'    => 'unit',
							'label'   => __( 'Space b/w Icon & Text', 'bb-powerpack' ),
							'default' => 10,
							'units'   => array( 'px' ),
							'slider'  => true,
						),
					),
				),
			),
		),
		'style'   => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'image_style'   => array(
					'title'  => __( 'Image Style', 'bb-powerpack' ),
					'fields' => array(
						'image_border' => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-image-scroll-wrap',
							),
						),
					),
				),
				'overlay_style' => array(
					'title'     => __( 'Overlay Style', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'overlay_color' => array(
							'type'        => 'color',
							'label'       => __( 'Overlay Color', 'bb-powerpack' ),
							'default'     => 'rgba(0,0,0,0.5)',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-image-scroll-overlay',
								'property' => 'background-color',
							),
						),
					),
				),
				'icon_style'    => array(
					'title'     => __( 'Icon/Text Style', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'icon_size'       => array(
							'type'    => 'unit',
							'label'   => __( 'Size', 'bb-powerpack' ),
							'default' => '18',
							'units'   => array( 'px' ),
							'slider'  => true,
						),
						'icon_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Color' ),
							'default'     => '000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-overlay-content',
								'property' => 'color',
							),
						),
						'icon_bg_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'default'     => 'a0a0a0',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-overlay-content',
								'property' => 'background-color',
							),
						),
						'icon_border'     => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-overlay-content',
							),
						),
						'icon_padding'    => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => 10,
							'slider'     => true,
							'responsive' => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-overlay-content',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'icon_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-overlay-content .pp-overlay-text',
							),
						),
					),
				),
			),
		),
	)
);
