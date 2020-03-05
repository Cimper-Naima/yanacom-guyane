<?php

/**
 * @class PPGoogleMapModule
 */
class PPGoogleMapModule extends FLBuilderModule {

	/**
	 * Constructor function for the module. You must pass the
	 * name, description, dir and url in an array to the parent class.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'          => __( 'Google Map', 'bb-powerpack' ),
				'description'   => __( 'A module for Display Google Map.', 'bb-powerpack' ),
				'group'         => pp_get_modules_group(),
				'category'      => pp_get_modules_cat( 'creative' ),
				'dir'           => BB_POWERPACK_DIR . 'modules/pp-google-map/',
				'url'           => BB_POWERPACK_URL . 'modules/pp-google-map/',
				'editor_export' => true,
				'enabled'       => true,
			)
		);
	}

	public function update( $settings ) {
		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPGoogleMapModule',
	array(
		'form'      => array(
			'title'    => __( 'Locations', 'bb-powerpack' ),
			'sections' => array(
				'address_form' => array(
					'title'  => 'Locations',
					'fields' => array(
						'pp_gmap_addresses' => array(
							'type'         => 'form',
							'label'        => __( 'Location', 'bb-powerpack' ),
							'form'         => 'pp_google_map_addresses',
							'preview_text' => 'map_name',
							'multiple'     => true,
						),
					),
				),
			),
		),
		'settings'  => array(
			'title'    => __( 'Settings', 'bb-powerpack' ),
			'sections' => array(
				'gen_control' => array(
					'title'  => '',
					'fields' => array(
						'zoom_type'        => array(
							'type'    => 'select',
							'label'   => __( 'Zoom Type', 'bb-powerpack' ),
							'default' => 'auto',
							'options' => array(
								'auto'   => 'Auto',
								'custom' => 'Custom',
							),
							'toggle'  => array(
								'custom' => array(
									'fields' => array( 'map_zoom' ),
								),
							),
						),
						'map_zoom'         => array(
							'type'    => 'select',
							'label'   => __( 'Map Zoom', 'bb-powerpack' ),
							'default' => '12',
							'options' => array(
								'1'  => __( '1', 'bb-powerpack' ),
								'2'  => __( '2', 'bb-powerpack' ),
								'3'  => __( '3', 'bb-powerpack' ),
								'4'  => __( '4', 'bb-powerpack' ),
								'5'  => __( '5', 'bb-powerpack' ),
								'6'  => __( '6', 'bb-powerpack' ),
								'7'  => __( '7', 'bb-powerpack' ),
								'8'  => __( '8', 'bb-powerpack' ),
								'9'  => __( '9', 'bb-powerpack' ),
								'10' => __( '10', 'bb-powerpack' ),
								'11' => __( '11', 'bb-powerpack' ),
								'12' => __( '12', 'bb-powerpack' ),
								'13' => __( '13', 'bb-powerpack' ),
								'14' => __( '14', 'bb-powerpack' ),
								'15' => __( '15', 'bb-powerpack' ),
								'16' => __( '16', 'bb-powerpack' ),
								'17' => __( '17', 'bb-powerpack' ),
								'18' => __( '18', 'bb-powerpack' ),
								'19' => __( '19', 'bb-powerpack' ),
								'20' => __( '20', 'bb-powerpack' ),
							),
						),
						'scroll_zoom'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Disable map zoom on Mouse Wheel Scroll', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
						'dragging'         => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Disable Dragging on Mobile', 'bb-powerpack' ),
							'default' => 'false',
							'options' => array(
								'false' => __( 'Yes', 'bb-powerpack' ),
								'true'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'marker_animation' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Marker Animation', 'bb-powerpack' ),
							'default' => 'drop',
							'options' => array(
								''       => __( 'None', 'bb-powerpack' ),
								'drop'   => __( 'Drop', 'bb-powerpack' ),
								'bounce' => __( 'Bounce', 'bb-powerpack' ),
							),
						),
					),
				),
				'control'     => array(
					'title'     => __( 'Controls', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'street_view'        => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Street view control', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'map_type_control'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Map type control', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'zoom'               => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Zoom control', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'fullscreen_control' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Full Screen control', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'hide_tooltip'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Tooltips on Click', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
			),
		),
		'map_style' => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'general'    => array(
					'title'  => '',
					'fields' => array(
						'map_width'      => array(
							'type'       => 'unit',
							'label'      => __( 'Width', 'bb-powerpack' ),
							'default'    => '100',
							'slider'     => array(
								'%'  => array(
									'min' => 0,
									'max' => 100,
								),
								'px' => array(
									'min' => 0,
									'max' => 1000,
								),
							),
							'units'      => array( '%', 'px' ),
							'responsive' => true,
						),
						'map_height'     => array(
							'type'       => 'unit',
							'label'      => __( 'Height', 'bb-powerpack' ),
							'default'    => '400',
							'slider'     => array(
								'px' => array(
									'min'  => 0,
									'max'  => 1000,
									'step' => 10,
								),
							),
							'units'      => array( 'px' ),
							'responsive' => true,
						),
						'map_type'       => array(
							'type'    => 'select',
							'label'   => __( 'Map View', 'bb-powerpack' ),
							'default' => 'roadmap',
							'options' => array(
								'roadmap'   => __( 'Roadmap', 'bb-powerpack' ),
								'satellite' => __( 'Satellite', 'bb-powerpack' ),
								'hybrid'    => __( 'Hybrid', 'bb-powerpack' ),
								'terrain'   => __( 'Terrain', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'roadmap' => array(
									'fields' => array( 'map_skin' ),
								),
								'hybrid'  => array(
									'fields' => array( 'map_skin' ),
								),
								'terrain' => array(
									'fields' => array( 'map_skin' ),
								),
							),
						),
						'map_skin'       => array(
							'type'    => 'select',
							'label'   => __( 'Map Skin', 'bb-powerpack' ),
							'default' => 'standard',
							'options' => array(
								'standard'     => __( 'Standard', 'bb-powerpack' ),
								'aqua'         => __( 'Aqua', 'bb-powerpack' ),
								'aubergine'    => __( 'Aubergine', 'bb-powerpack' ),
								'classic_blue' => __( 'Classic Blue', 'bb-powerpack' ),
								'dark'         => __( 'Dark', 'bb-powerpack' ),
								'earth'        => __( 'Earth', 'bb-powerpack' ),
								'magnesium'    => __( 'Magnesium', 'bb-powerpack' ),
								'night'        => __( 'Night', 'bb-powerpack' ),
								'silver'       => __( 'Silver', 'bb-powerpack' ),
								'retro'        => __( 'Retro', 'bb-powerpack' ),
								'custom'       => __( 'Custom Style', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'custom' => array(
									'fields' => array( 'map_style1', 'map_style_code' ),
								),
							),
						),
						'map_style1'     => array(
							'type'        => 'static',
							'description' => __( '<br/><a target="_blank" rel="noopener" href="https://mapstyle.withgoogle.com/"><b style="color: #0000ff;">Click here</b></a> to get JSON style code to style your map.', 'bb-powerpack' ),
						),
						'map_style_code' => array(
							'type'          => 'editor',
							'label'         => '',
							'rows'          => 3,
							'media_buttons' => false,
							'connections'   => array( 'string', 'html' ),
						),
					),
				),
				'info_style' => array(
					'title'  => __( 'Marker Tooltip', 'bb-powerpack' ),
					'fields' => array(
						'info_width'   => array(
							'type'       => 'unit',
							'label'      => __( 'Marker Tooltip Max Width', 'bb-powerpack' ),
							'default'    => '200',
							'units'      => array( 'px' ),
							'slider'     => array(
								'px' => array(
									'min' => 0,
									'max' => 1000,
								),
							),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gm-style .pp-infowindow-content',
								'property' => 'max-width',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
						'info_padding' => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gm-style .pp-infowindow-content',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
					),
				),
			),
		),
	)
);

FLBuilder::register_settings_form(
	'pp_google_map_addresses',
	array(
		'title' => __( 'Add Location', 'bb-powerpack' ),
		'tabs'  => array(
			'addr_general' => array(
				'title'    => __( 'General', 'bb-powerpack' ),
				'sections' => array(
					'features' => array(
						'title'  => __( 'Location', 'bb-powerpack' ),
						'fields' => array(
							'map_name'      => array(
								'type'        => 'text',
								'label'       => __( 'Location Name', 'bb-powerpack' ),
								'default'     => 'IdeaBox Creations',
								'help'        => __( 'Location Name to identify while editing', 'bb-powerpack' ),
								'connections' => array( 'string' ),
							),
							'map_latitude'  => array(
								'type'        => 'text',
								'label'       => __( 'Latitude', 'bb-powerpack' ),
								'default'     => '24.553311',
								'description' => __( '</br></br><a href="https://www.latlong.net/" target="_blank" rel="noopener"><b style="color: #0000ff;">Click here</b></a> to find Latitude and Longitude of your location', 'bb-powerpack' ),
								'connections' => array( 'string' ),
							),
							'map_longitude' => array(
								'type'        => 'text',
								'label'       => __( 'Longitude', 'bb-powerpack' ),
								'default'     => '73.694076',
								'description' => __( '</br></br><a href="https://www.latlong.net/" target="_blank" rel="noopener"><b style="color: #0000ff;">Click here</b></a> to find Latitude and Longitude of your location', 'bb-powerpack' ),
								'connections' => array( 'string' ),
							),
							'marker_point'  => array(
								'type'    => 'select',
								'label'   => __( 'Marker Point Icon', 'bb-powerpack' ),
								'default' => 'default',
								'options' => array(
									'default' => 'Default',
									'custom'  => 'Custom',
								),
								'toggle'  => array(
									'custom' => array(
										'fields' => array( 'marker_img' ),
									),
								),
							),
							'marker_img'    => array(
								'type'        => 'photo',
								'label'       => __( 'Custom Marker', 'bb-powerpack' ),
								'show_remove' => true,
								'connections' => array( 'photo' ),
							),
						),
					),
				),
			),
			'info_window'  => array(
				'title'    => __( 'Marker Tooltip', 'bb-powerpack' ),
				'sections' => array(
					'title' => array(
						'title'  => '',
						'fields' => array(
							'enable_info'      => array(
								'type'    => 'select',
								'label'   => __( 'Show Tooltip', 'bb-powerpack' ),
								'default' => 'yes',
								'options' => array(
									'yes' => __( 'Yes', 'bb-powerpack' ),
									'no'  => __( 'No', 'bb-powerpack' ),
								),
								'toggle'  => array(
									'yes' => array(
										'fields' => array( 'info_window_text' ),
									),
								),
							),
							'info_window_text' => array(
								'type'          => 'editor',
								'label'         => '',
								'default'       => __( 'IdeaBox Creations', 'bb-powerpack' ),
								'media_buttons' => false,
								'connections'   => array( 'string', 'html' ),
							),
						),
					),
				),
			),
		),
	)
);
