<?php

/**
 * @class PPHotspotModule
 */
class PPHotspotModule extends FLBuilderModule {

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
				'name'            => __( 'Hotspot', 'bb-powerpack' ),
				'description'     => __( 'Upload a photo or display one from the media library.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'creative' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-hotspot/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-hotspot/',
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
		$this->add_js( 'jquery-waypoints' );
		$this->add_js( 'tooltipster' );
		$this->add_css( 'tooltipster' );
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPHotspotModule',
	array(
		'general'      => array(
			'title'    => __( 'General', 'bb-powerpack' ),
			'sections' => array(
				'general' => array(
					'title'  => '',
					'fields' => array(
						'photo_source' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Photo Source', 'bb-powerpack' ),
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
									'fields'   => array( 'photo_url', 'caption' ),
									'sections' => array( 'caption_section' ),
								),
							),
						),
						'photo'        => array(
							'type'        => 'photo',
							'label'       => __( 'Photo', 'bb-powerpack' ),
							'connections' => array( 'photo' ),
						),
						'photo_url'    => array(
							'type'        => 'text',
							'label'       => __( 'Photo URL', 'bb-powerpack' ),
							'placeholder' => __( 'http://www.example.com/my-photo.jpg', 'bb-powerpack' ),
						),
						'photo_size'   => array(
							'type'       => 'unit',
							'label'      => __( 'Custom Photo Size', 'bb-powerpack' ),
							'default'    => '',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-image-container .pp-hotspot-image',
								'property' => 'width',
								'unit'     => 'px',
							),
						),
					),
				),
			),
		),
		'marker'       => array(
			'title'    => __( 'Markers & Tooltips', 'bb-powerpack' ),
			'sections' => array(
				'markers_contents' => array(
					'title'  => __( 'Marker', 'bb-powerpack' ),
					'fields' => array(
						'markers_content' => array(
							'type'         => 'form',
							'label'        => __( 'Marker', 'bb-powerpack' ),
							'form'         => 'pp_marker_form',
							'preview_text' => 'marker_title',
							'multiple'     => true,
						),
					),
				),
				'tooltip'          => array(
					'title'  => 'Tooltip',
					'fields' => array(
						'tooltip'         => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Enable Tooltip', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields'   => array( '' ),
									'sections' => array( 'tooltip_general', 'tooltip_style', 'button_style' ),
									'tabs'     => array( 'hotspot_tour' ),
								),
								'no'  => array(
									'fields' => array( 'add_marker_link' ),
								),
							),
						),
						'add_marker_link' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Add Link on Marker', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
				'tooltip_general'  => array(
					'title'  => 'Tooltip Settings',
					'fields' => array(
						'tooltip_position'   => array(
							'type'    => 'select',
							'label'   => __( 'Tooltip Position', 'bb-powerpack' ),
							'default' => 'top',
							'options' => array(
								'top'    => __( 'Top', 'bb-powerpack' ),
								'bottom' => __( 'Bottom', 'bb-powerpack' ),
								'left'   => __( 'Left', 'bb-powerpack' ),
								'right'  => __( 'Right', 'bb-powerpack' ),
							),
						),
						'tooltip_trigger'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Trigger on', 'bb-powerpack' ),
							'default' => 'hover',
							'options' => array(
								'hover' => __( 'Hover', 'bb-powerpack' ),
								'click' => __( 'Click', 'bb-powerpack' ),
							),
						),
						'tooltip_arrow'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Tooltip Arrow', 'bb-powerpack' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-powerpack' ),
								'hide' => __( 'Hide', 'bb-powerpack' ),
							),
						),
						'tooltip_animation'  => array(
							'label'   => __( 'Animation Type', 'bb-powerpack' ),
							'type'    => 'select',
							'default' => 'fade',
							'options' => array(
								'none'  => __( 'None', 'bb-powerpack' ),
								'fade'  => __( 'Fade', 'bb-powerpack' ),
								'grow'  => __( 'Grow', 'bb-powerpack' ),
								'swing' => __( 'Swing', 'bb-powerpack' ),
								'slide' => __( 'Slide', 'bb-powerpack' ),
								'fall'  => __( 'Fall', 'bb-powerpack' ),
							),
						),
						'animation_duration' => array(
							'type'    => 'unit',
							'label'   => __( 'Animation Duration' ),
							'default' => 350,
							'units'   => array( 'ms' ),
							'slider'  => true,
						),
						'tooltip_distance'   => array(
							'type'    => 'unit',
							'label'   => __( 'Distance From Marker' ),
							'default' => 10,
							'units'   => array( 'px' ),
							'slider'  => true,
						),
						'tooltip_max_width'  => array(
							'type'    => 'unit',
							'label'   => __( 'Tooltip Max Width' ),
							'default' => 300,
							'units'   => array( 'px' ),
							'slider'  => true,
						),
						'tooltip_zindex'     => array(
							'type'    => 'unit',
							'label'   => __( 'Z-Index' ),
							'default' => 99,
							'slider'  => true,
						),
					),
				),
			),
		),
		'hotspot_tour' => array(
			'title'    => __( 'Hotspot Tour', 'bb-powerpack' ),
			'sections' => array(
				'hotspot_tour'    => array(
					'title'  => 'Hotspot Tour',
					'fields' => array(
						'enable_tour' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Enable Tour', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields'   => array( 'hide_tour_tablet', 'hide_tour_mobile', 'repeat_tour', 'autoplay_tour', 'launch_tour', 'non_active_marker' ),
									'sections' => array( 'hotspot_general', 'pre_next_text', 'button_style' ),
								),
							),
						),
						'hide_tour_tablet' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Hide Tour on Tablet', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'hide_tour_mobile' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Hide Tour on Mobile', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
				'hotspot_general' => array(
					'title'  => 'Hotspot Settings',
					'fields' => array(
						'repeat_tour'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Repeat Tour', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'end_text', 'tooltip_end_color' ),
								),
							),
						),
						'autoplay_tour'     => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Autoplay Tour', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'tooltip_interval' ),
								),
							),
						),
						'tooltip_interval'  => array(
							'type'    => 'unit',
							'label'   => __( 'Interval between Tooltips', 'bb-powerpack' ),
							'units'   => array( 'ms' ),
							'slider'  => true,
							'default' => '2000',
						),
						'launch_tour'       => array(
							'type'    => 'select',
							'label'   => __( 'Launch Tour', 'bb-powerpack' ),
							'default' => 'on_scroll',
							'options' => array(
								'button_click' => __( 'On Button Click', 'bb-powerpack' ),
								'on_scroll'    => __( 'On Page Scroll', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'button_click' => array(
									'fields'   => array( 'overlay_button' ),
									'sections' => array( 'button_style' ),
								),
							),
						),
						'overlay_button'    => array(
							'type'    => 'text',
							'label'   => __( 'Hotspot Tour Button Text', 'bb-powerpack' ),
							'default' => __( 'Start Tour', 'bb-powerpack' ),
						),
						'non_active_marker' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Hide Non-Active Markers', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
				'pre_next_text'   => array(
					'title'     => 'Previous / Next',
					'collapsed' => true,
					'fields'    => array(
						'navigation_type' => array(
							'type'    => 'select',
							'label'   => __( 'Navigation Type', 'bb-powerpack' ),
							'default' => 'icon_text',
							'options' => array(
								'icon'      => __( 'Icon', 'bb-powerpack' ),
								'text'      => __( 'Text', 'bb-powerpack' ),
								'icon_text' => __( 'Icon + Text', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'icon'      => array(
									'fields' => array( 'pre_icon', 'next_icon' ),
								),
								'text'      => array(
									'fields' => array( 'pre_text', 'next_text' ),
								),
								'icon_text' => array(
									'fields' => array( 'pre_icon', 'next_icon', 'pre_text', 'next_text' ),
								),
							),
						),
						'pre_icon'        => array(
							'type'    => 'icon',
							'label'   => __( 'Previous Icon', 'bb_powerpack' ),
							'default' => 'fas fa-angle-double-left',
						),
						'pre_text'        => array(
							'type'    => 'text',
							'label'   => __( 'Previous Text', 'bb_powerpack' ),
							'default' => 'Previous',
						),
						'next_icon'       => array(
							'type'    => 'icon',
							'label'   => __( 'Next Icon', 'bb_powerpack' ),
							'default' => 'fas fa-angle-double-right',
						),
						'next_text'       => array(
							'type'    => 'text',
							'label'   => __( 'Next Text', 'bb_powerpack' ),
							'default' => 'Next',
						),
						'end_text'        => array(
							'type'    => 'text',
							'label'   => __( 'End Tour Text', 'bb_powerpack' ),
							'default' => 'End Tour',
						),
					),
				),
			),
		),
		'style'        => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'image_style'   => array(
					'title'  => 'Image',
					'fields' => array(
						'img_opacity' => array(
							'type'    => 'unit',
							'label'   => __( 'Image Opacity', 'bb-powerpack' ),
							'slider'  => true,
							'default' => 1,
						),
						'img_border'  => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-image-container .pp-hotspot-image',
							),
						),
					),
				),
				'marker_style'  => array(
					'title'     => 'Marker',
					'collapsed' => true,
					'fields'    => array(
						'admin_title_preview'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Enable Admin Title Preview', 'bb-powerpack' ),
							'help'    => __( 'This title will only appear in editor mode.', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'marker_ripple_effect'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Ripple Effect', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'common_marker_size'     => array(
							'type'       => 'unit',
							'label'      => __( 'Marker Size', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'marker_img_size'        => array(
							'type'       => 'unit',
							'label'      => __( 'Marker Image Size', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'marker_bg_size'         => array(
							'type'       => 'unit',
							'label'      => __( 'Background Size', 'bb-powerpack' ),
							'default'    => '40',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'common_marker_color'    => array(
							'type'        => 'color',
							'label'       => __( 'Marker Color', 'bb-powerpack' ),
							'default'     => '000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'common_marker_bg_color' => array(
							'type'        => 'color',
							'label'       => __( 'Marker Background Color', 'bb-powerpack' ),
							'default'     => 'a0a0a0',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'marker_border'          => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-marker',
							),
						),
					),
				),
				'button_style'  => array(
					'title'     => __( 'Hotspot Tour Button', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'overlay_color'             => array(
							'type'       => 'color',
							'label'      => __( 'Overlay Color', 'bb-powerpack' ),
							'default'    => '',
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-overlay',
								'property' => 'background-color',
							),
						),
						'button_color'              => array(
							'type'        => 'color',
							'label'       => __( 'Text Color', 'bb-powerpack' ),
							'default'     => 'ffffff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-overlay-button',
								'property' => 'color',
							),
						),
						'button_color_hover'        => array(
							'type'        => 'color',
							'label'       => __( 'Text Color on Hover', 'bb-powerpack' ),
							'default'     => '000000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'button_bg_color'           => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'default'     => '428bca',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-overlay-button',
								'property' => 'background-color',
							),
						),
						'button_bg_color_hover'     => array(
							'type'        => 'color',
							'label'       => __( 'Background Color on Hover', 'bb-powerpack' ),
							'default'     => 'ffffff',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'button_border'             => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-overlay-button',
							),
						),
						'button_border_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Border Color on Hover', 'bb-powerpack' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'button_padding'            => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => 10,
							'slider'     => true,
							'responsive' => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-overlay-button',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'button_typography'         => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-hotspot-overlay-button',
							),
						),
					),
				),
				'tooltip_style' => array(
					'title'     => 'Tooltip',
					'collapsed' => true,
					'fields'    => array(
						'tooltip_preview'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Enable First Tooltip Preview', 'bb-powerpack' ),
							'help'    => __( 'This will display first Tooltip in editor mode only.', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'tooltip_text_color' => array(
							'type'        => 'color',
							'label'       => __( 'Text Color', 'bb-powerpack' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'tooltip_bg_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'default'     => '000',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
						),
						'tooltip_padding'    => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => 10,
							'slider'     => true,
							'responsive' => true,
							'units'      => array( 'px' ),
						),
						'tooltip_corners'    => array(
							'type'    => 'unit',
							'label'   => __( 'Corners', 'bb-powerpack' ),
							'default' => 20,
							'slider'  => true,
							'units'   => array( 'px' ),
						),
						'tooltip_pre_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Previous Button Color', 'bb-powerpack' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'tooltip_nxt_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Next Button Color', 'bb-powerpack' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'tooltip_end_color'  => array(
							'type'        => 'color',
							'label'       => __( 'End Tour Button Color', 'bb-powerpack' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'tooltip_typography' => array(
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

FLBuilder::register_settings_form(
	'pp_marker_form',
	array(
		'title' => __( 'Marker Content', 'bb-powerpack' ),
		'tabs'  => array(
			'marker_general'  => array(
				'title'    => __( 'General', 'bb-powerpack' ),
				'sections' => array(
					'marker_general' => array(
						'title'  => 'General',
						'fields' => array(
							'marker_title'               => array(
								'type'        => 'text',
								'label'       => __( 'Admin Title', 'bb-powerpack' ),
								'connections' => array( 'string' ),
								'help'        => __( 'This title will only appear in editor mode.', 'bb-powerpack' ),
							),
							'marker_type'                => array(
								'type'    => 'select',
								'label'   => __( 'Marker Type', 'bb-powerpack' ),
								'default' => 'icon',
								'options' => array(
									'icon'  => __( 'Icon', 'bb-powerpack' ),
									'image' => __( 'Images', 'bb-powerpack' ),
									'text'  => __( 'Text', 'bb-powerpack' ),
								),
								'toggle'  => array(
									'image' => array(
										'fields' => array( 'marker_image' ),
									),
									'icon'  => array(
										'fields' => array( 'marker_icon' ),
									),
									'text'  => array(
										'fields' => array( 'marker_text', 'marker_text_typography' ),
									),
								),
							),
							'marker_image'               => array(
								'type'        => 'photo',
								'show_remove' => true,
								'label'       => __( 'Image Source', 'bb-powerpack' ),
								'connections' => array( 'photo' ),
							),
							'marker_icon'                => array(
								'type'    => 'icon',
								'label'   => __( 'Icon', 'bb-powerpack' ),
								'default' => 'dashicons dashicons-before dashicons-marker',
							),
							'marker_text'                => array(
								'type'        => 'text',
								'label'       => __( 'Text', 'bb-powerpack' ),
								'connections' => array( 'string' ),
							),
							'marker_position_horizontal' => array(
								'type'    => 'unit',
								'label'   => __( 'Marker Horizontal Position', 'bb-powerpack' ),
								'default' => '20',
								'units'   => array( '%' ),
								'slider'  => true,
							),
							'marker_position_vertical'   => array(
								'type'    => 'unit',
								'label'   => __( 'Marker Vertical Position', 'bb-powerpack' ),
								'default' => '20',
								'units'   => array( '%' ),
								'slider'  => true,
							),
							'marker_link'                => array(
								'type'          => 'link',
								'label'         => __( 'Link', 'bb-powerpack' ),
								'connections'   => array( 'url' ),
								'show_target'   => true,
								'show_nofollow' => true,
								'description'   => __( '<p style="background: #3786fd;color: #fff;padding: 10px;">This Link only work, when Tooltip Disabled.</p>', 'bb-powerpack' ),
							),
							'marker_color'               => array(
								'type'        => 'color',
								'label'       => __( 'Marker Color', 'bb-powerpack' ),
								'show_reset'  => true,
								'connections' => array( 'color' ),
							),
							'marker_bg_color'            => array(
								'type'        => 'color',
								'label'       => __( 'Marker Background Color', 'bb-powerpack' ),
								'show_reset'  => true,
								'show_alpha'  => true,
								'connections' => array( 'color' ),
							),
							'marker_border_single_color' => array(
								'type'        => 'color',
								'label'       => __( 'Marker Border Color', 'bb-powerpack' ),
								'show_reset'  => true,
								'connections' => array( 'color' ),
							),
							'marker_text_typography'     => array(
								'type'       => 'typography',
								'label'      => __( 'Marker Text Typography', 'bb-powerpack' ),
								'responsive' => true,
								'preview'    => array(
									'type'     => 'css',
									'selector' => '.pp-hotspot-overlay-button',
								),
							),
						),
					),
				),
			),
			'tooltip_general' => array(
				'title'    => __( 'Marker Content', 'bb-powerpack' ),
				'sections' => array(
					'tooltip_content' => array(
						'title'  => 'Content',
						'fields' => array(
							'tooltip_content' => array(
								'type'        => 'editor',
								'label'       => __( 'Content', 'bb-powerpack' ),
								'default'     => 'This is Tootlip',
								'connections' => array( 'html', 'string' ),
							),
						),
					),
				),
			),
		),
	)
);
