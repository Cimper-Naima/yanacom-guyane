<?php

/**
 * @class PPFilterableGalleryModule
 */
class PPFilterableGalleryModule extends FLBuilderModule {
	/**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
			'name'          => __('Filterable Gallery', 'bb-powerpack'),
            'description'   => __('A module for filterable gallery.', 'bb-powerpack'),
			'group'			=> pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'content' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-filterable-gallery/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-filterable-gallery/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh' => true,
        ));

		$this->add_css('jquery-magnificpopup');
		$this->add_js('jquery-magnificpopup');
		
		$this->add_js('jquery-masonry');
		$this->add_js( 'jquery-isotope' );
		$this->add_js( 'imagesloaded' );
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle grid old columns field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'photo_grid_count', 'responsive', 'photo_grid_count' );

		// Handle old image border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'photo_border'	=> array(
				'type'				=> 'style'
			),
			'photo_border_width'	=> array(
				'type'				=> 'width'
			),
			'photo_border_color'	=> array(
				'type'				=> 'color'
			),
			'photo_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'photo_border_group' );

		// Handle photo old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'photo_padding', 'padding', 'photo_padding' );

		// Handle image overlay opacity + color field.
		if ( isset( $settings->overlay_color_opacity ) ) {
			$opacity = $settings->overlay_color_opacity >= 0 ? $settings->overlay_color_opacity : 1;
			$color = $settings->overlay_color;

			if ( ! empty( $color ) ) {
				$color = pp_hex2rgba( pp_get_color_value( $color ), $opacity );
				$settings->overlay_color = $color;
			}

			unset( $settings->overlay_color_opacity );
		}

		// Handle caption old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'caption_padding', 'padding', 'caption_padding' );

		// Handle old filters border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'filter_border'	=> array(
				'type'				=> 'style'
			),
			'filter_border_width'	=> array(
				'type'				=> 'width'
			),
			'filter_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'filter_border_group' );

		if ( isset( $settings->filter_border_color ) ) {
			$settings->filter_border_group['color'] = $settings->filter_border_color['primary'];
			$settings->filter_border_color_hover = $settings->filter_border_color['secondary'];
			unset( $settings->filter_border_color );
		}

		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'filter_background', array(
			'primary'	=> 'filter_bg_color',
			'secondary'	=> 'filter_bg_hover'
		) );

		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'filter_color', array(
			'primary'	=> 'filter_text_color',
			'secondary'	=> 'filter_text_hover'
		) );

		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'filter_res_background', array(
			'primary'	=> 'filter_res_bg_color',
			'secondary'	=> 'filter_res_bg_hover'
		) );

		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'filter_res_color', array(
			'primary'	=> 'filter_res_text_color',
			'secondary'	=> 'filter_res_text_hover'
		) );


		// Handle filter old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'filter_padding', 'padding', 'filter_padding' );

		// Handle caption's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'caption_font'	=> array(
				'type'			=> 'font'
			),
			'caption_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->caption_font_size_toggle ) && 'custom' == $settings->caption_font_size_toggle )
			),
		), 'caption_typography' );

		// Handle filter's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'filter_font'	=> array(
				'type'			=> 'font'
			),
			'filter_font_size'	=> array(
				'type'			=> 'font_size',
			),
			'filter_text_transform'	=> array(
				'type'		=> 'text_transform'
			)
		), 'filter_typography' );

		return $settings;
	}
	
	/**
	 * @method update
	 * @param $settings {object}
	 */
	public function update($settings)
	{
		// Cache the photo data if using the WordPress media library.
		$settings->photo_data = $this->get_wordpress_photos();

		return $settings;
	}

    /**
     * @method get_gallery_filter_ids
     * @param $filters_data {object}
     * @param $get_labels {boolean}
     */
	public function get_gallery_filter_ids( $filters_data, $get_labels = false )
	{
		$array_big = array();
		$filter_labels = array();

		if ( ! count( (array)$filters_data ) ) {
			return $array_big;
		}

		foreach ( $filters_data as $filter_key => $filter ) {

			if ( !is_object( $filter ) ) {
				continue;
			}

			$gphotos = str_replace( str_split('[]'), "", $filter->gallery_photos);
			$gphotos = explode(',', $gphotos);

			if ( is_array( $gphotos ) && count( $gphotos ) ) {
				foreach ( $gphotos as $gphoto ) {
					$array_big[] = $gphoto;
				}
				$filter_group_label = 'pp-group-' . ($filter_key+1);
				$filter_labels[$filter_group_label] = $gphotos;
			}
		}

		if ( ! count( $array_big ) ) {
			return $array_big;
		}

		$unique = array_unique( $array_big );

		if ( $get_labels ) :

			$labels = array();

			foreach ( $unique as $unique_id ) {
				if ( empty($unique_id) ) {
					continue;
				}
				foreach ( $filter_labels as $key => $filter_label ) {
					if ( in_array( $unique_id, $filter_label ) ) {
						if ( isset( $labels[$unique_id] ) ) {
							$labels[$unique_id] = $labels[$unique_id]  . ' ' . str_replace(" ", "-", strtolower($key));
						}
						else {
							$labels[$unique_id] = str_replace(" ", "-", strtolower($key));
						}
					}
				}
			}

			return $labels;

		endif;

		return $unique;
	}

	/**
	 * @method get_photos
	 */
	public function get_photos()
	{
		$default_order 	= $this->get_wordpress_photos();
		$photos_id 		= array();
		$settings 		= $this->settings;

		if ( $settings->photo_order == 'random' && is_array( $default_order ) ) {

			$keys = array_keys( $default_order );
			shuffle($keys);

			foreach ( $keys as $key ) {
				$photos_id[ $key ] = $default_order[ $key ];
			}
		} else {
			$photos_id = $default_order;
		}

		return $photos_id;
	}

	/**
	 * @method get_wordpress_photos
	 */
	public function get_wordpress_photos()
	{
		$photos     = array();
		$filters    = $this->settings->gallery_filter;
		$medium_w   = get_option('medium_size_w');
		$large_w    = get_option('large_size_w');
		$ids		= array();
		$custom_link = $this->settings->click_action;

		if ( ! count( $filters ) ) {
			return $photos;
		}

		$filter_ids = $this->get_gallery_filter_ids($this->settings->gallery_filter);

		/* Template Cache */
		$photo_from_template = false;
		$photo_attachment_data = false;

		/* Check if all photos are available on host */
		foreach ($filter_ids as $id) {
			if ( empty( $id ) ) {
				continue;
			}
			$photo_attachment_data[$id] = FLBuilderPhoto::get_attachment_data($id);

			if ( ! $photo_attachment_data[$id] ) {
				$photo_from_template = true;
			}

		}

		foreach($filter_ids as $id) {
			if ( empty( $id ) ) {
				continue;
			}
			$photo = $photo_attachment_data[$id];

			// Use the cache if we didn't get a photo from the id.
			if ( ! $photo && $photo_from_template ) {

				if ( ! isset( $this->settings->photo_data ) ) {
					continue;
				}
				else if ( is_array( $this->settings->photo_data ) ) {
					$photos[ $id ] = $this->settings->photo_data[ $id ];
					//preg_match("\{(.*)\}", $photos[ $id ], $photos);
				}
				else if ( is_object( $this->settings->photo_data ) ) {
					$photos[ $id ] = $this->settings->photo_data->{$id};
					//preg_match("\{(.*)\}", $photos[ $id ], $photos);
				}
				else {
					continue;
				}
			}


			// Only use photos who have the sizes object.
			if (isset($photo->sizes)) {

				$data = new stdClass();

				// Photo data object
				$data->id = $id;
				$data->alt = $photo->alt;
				$data->caption = $photo->caption;
				$data->description = $photo->description;
				$data->title = $photo->title;

				$image_size = $this->settings->photo_size;

				// Collage photo src
				if ( $this->settings->photo_size == 'thumbnail' && isset( $photo->sizes->thumbnail ) ) {
					$data->src = $photo->sizes->thumbnail->url;
				}
				elseif ( $this->settings->photo_size == 'medium' && isset( $photo->sizes->medium ) ) {
					$data->src = $photo->sizes->medium->url;
				}
				elseif ( isset( $photo->sizes->{$image_size} ) ) {
					$data->src = $photo->sizes->{$image_size}->url;
				}
				else {
					$data->src = $photo->sizes->full->url;
				}

				// Photo Link
				if (isset($photo->sizes->large)) {
					$data->link = $photo->sizes->large->url;
				}
				else {
					$data->link = $photo->sizes->full->url;
				}

				if ( $this->settings->lightbox_image_size == 'full' ) {
					$data->link = $photo->sizes->full->url;
				}

				/* Add Custom field attachment data to object */
	 			$cta_link = get_post_meta( $id, 'gallery_external_link', true );
				$data->cta_link = $cta_link;

				$photos[$id] = $data;

				//preg_match("\{(.*)\}", $photos[ $id ], $photos);
			}

		}

		return $photos;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPFilterableGalleryModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
					'gallery_layout'        => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Layout', 'bb-powerpack' ),
						'default'       => 'grid',
						'options'       => array(
							'grid'          => __( 'Grid', 'bb-powerpack' ),
							'masonry'       => __( 'Masonry', 'bb-powerpack' ),
						),
					),
					'photo_size'        => array(
						'type'          => 'photo-sizes',
						'label'         => __('Image Size', 'bb-powerpack'),
						'default'       => 'medium',
					),
					'photo_order'        => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Display Order', 'bb-powerpack' ),
						'default'       => 'normal',
						'options'       => array(
							'normal'     	=> __( 'Normal', 'bb-powerpack'),
							'random' 		=> __( 'Random', 'bb-powerpack' )
						),
					),
					'show_captions' => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Captions', 'bb-powerpack'),
						'default'       => '0',
						'options'       => array(
							'0'             => __('Never', 'bb-powerpack'),
							'hover'         => __('On Hover', 'bb-powerpack'),
							'below'         => __('Below Photo', 'bb-powerpack')
						),
						'toggle'	=> array(
							'below'	=> array(
								'sections'	=> array('caption_style')
							),
						),
						'help'          => __('The caption pulls from whatever text you put in the caption area in the media manager for each image.', 'bb-powerpack')
					),
                )
			),
			'click_action'	=> array(
				'title'			=> __('Click Action', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'click_action'  => array(
						'type'          => 'pp-switch',
						'label'         => __('Click Action', 'bb-powerpack'),
						'default'       => 'lightbox',
						'options'       => array(
							'none'          => __( 'None', 'Click action.', 'bb-powerpack' ),
							'lightbox'      => __('Lightbox', 'bb-powerpack'),
							'custom-link'   => __('Custom URL', 'bb-powerpack')
						),
						'toggle'		=> array(
							'lightbox'		=> array(
								'fields'		=> array('lightbox_image_size', 'lightbox_caption')
							),
							'custom-link'	=> array(
								'fields'		=> array('custom_link_target')
							)
						),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'lightbox_image_size'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Lightbox Image Size', 'bb-powerpack'),
						'default'	=> 'large',
						'options'	=> array(
							'large'		=> __('Large', 'bb-powerpack'),
							'full'		=> __('Full', 'bb-powerpack')
						)
					),
					'lightbox_caption'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __('Show Caption in Lightbox', 'bb-powerpack'),
						'default'	=> 'yes',
						'options'	=> array(
							'yes'		=> __('Yes', 'bb-powerpack'),
							'no'		=> __('No', 'bb-powerpack')
						)
					),
					'custom_link_target' => array(
						'type'		=> 'select',
						'label'		=> __('Link Target', 'bb-powerpack'),
						'default'	=> '_self',
						'options'	=> array(
							'_self'		=> __('Same Window', 'bb-powerpack'),
							'_blank'	=> __('New Window', 'bb-powerpack'),
						),
						'preview'	=> array(
							'type'		=> 'none'
						)
					)
				)
			),
			'overlay_settings'	=> array(
				'title'	=> __( 'Overlay', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'	=> array(
					'overlay_effects' => array(
						'type'          => 'select',
						'label'         => __('Overlay Effect', 'bb-powerpack'),
						'default'       => 'none',
						'options'       => array(
							'none' 			=> __('None', 'bb-powerpack'),
							'fade' 			=> __('Fade', 'bb-powerpack'),
							'from-left'		=> __('Overlay From Left', 'bb-powerpack'),
							'from-right'	=> __('Overlay From Right', 'bb-powerpack'),
							'from-top'		=> __('Overlay From Top', 'bb-powerpack'),
							'from-bottom'	=> __('Overlay From Bottom', 'bb-powerpack'),
						),
						'preview'	=> 'none',
					),
					'icon' => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Icon?', 'bb-powerpack'),
						'default'       => '0',
						'options'       => array(
							'1'				=> __('Yes', 'bb-powerpack'),
							'0' 			=> __('No', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'1'	=> array(
								'sections' => array( 'icon_style' ),
								'fields'	=> array('overlay_icon')
							),
						),
						'preview'	=> 'none',
					),
					'overlay_icon'	=> array(
						'type'			=> 'icon',
						'label'			=> __('Icon', 'bb-powerpack'),
						'preview'		=> 'none',
						'show_remove' => true
					),
				)
			),
			'filters_settings'	=> array(
				'title'	=> __( 'Filters', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'	=> array(
					'show_all_filter_btn'	=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Show "All" filter button', 'bb-powerpack'),
						'default'				=> 'yes',
						'options'				=> array(
							'yes'					=> __('Yes', 'bb-powerpack'),
							'no'					=> __('No', 'bb-powerpack'),
						)
					),
					'show_custom_all_text' => array(
						'type'          => 'pp-switch',
						'label'         => __('Rename "All" text?', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no' 			=> __('No', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'yes'	=> array(
								'fields'	=> array('custom_all_text')
							),
						),
						'preview'	=> 'none',
					),
					'custom_all_text' => array(
						'type'          => 'text',
						'label'         => __('Custom Text', 'bb-powerpack'),
						'default'       => '',
						'connections'	=> array('string'),
						'preview'         => array(
                            'type'            => 'text',
                            'selector'        => '.pp-gallery-filters li.all',
                        )
					),
					'custom_id_prefix'	=> array(
						'type'				=> 'text',
						'label'				=> __('Custom ID Prefix', 'bb-powerpack'),
						'default'			=> '',
						'placeholder'		=> __('mygallery', 'bb-powerpack'),
						'connections'		=> array('string'),
						'help'				=> __('To filter the gallery using URL parameters, a prefix that will be applied to ID attribute of filter button in HTML. For example, prefix "mygallery" will be applied as "mygallery-1", "mygallery-2" in ID attribute of filter button 1 and filter button 2 respectively. It should only contain dashes, underscores, letters or numbers. No spaces and no other special characters.', 'bb-powerpack')
					),
					'active_filter'	=> array(
						'type'			=> 'text',
						'label'			=> __('Active Filter Index', 'bb-powerpack'),
						'default'		=> '',
						'size'			=> 5,
						'help'			=> __('Add an index number of a filter to be activated on page load. For example, place 1 for the first filter.', 'bb-powerpack')
					)
				)
			),
			'gallery_columns'	=> array(
				'title'	=> __( 'Columns Settings', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'	=> array(
					'photo_grid_count'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Number of Columns', 'bb-powerpack'),
                        'slider'          => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '3',
								'medium' => '',
								'responsive' => '',
							),
						),
                    ),
					'photo_spacing' => array(
						'type'          => 'unit',
						'label'         => __('Spacing', 'bb-powerpack'),
						'default'       => 2,
						'units'   		=> array( '%' ),
						'slider'		=> true
					),
				)
			)
        )
    ),
	'gallery_filters'	=> array(
		'title'	=> __( 'Photos', 'bb-powerpack' ),
		'sections'	=> array(
			'gallery_filter'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'gallery_filter'     => array(
						'type'         => 'form',
						'label'        => __('Photo Group', 'bb-powerpack'),
						'form'         => 'pp_gallery_filter_form',
						'preview_text' => 'filter_label',
						'multiple'     => true
					),
				)
			)
		)
	),
	'style'	=> array(
		'title'	=> __( 'Style', 'bb-powerpack' ),
		'sections'	=> array(
			'general_style'	=> array(
				'title'	=> '',
				'fields'	=> array(
					'hover_effects' => array(
						'type'          => 'select',
						'label'         => __('Image Hover Effect', 'bb-powerpack'),
						'default'       => 'zoom',
						'options'       => array(
							'none' 			=> __('None', 'bb-powerpack'),
							'zoom-in'		=> __('Zoom', 'bb-powerpack'),
						),
						'preview'	=> 'none',
					),
					'photo_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-gallery-item, .pp-masonry-item',
                            'property'  	=> 'border',
                        ),
					),
					'photo_padding'    => array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-gallery-item',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
                    ),
				)
			),
			'overlay_style'       => array(
				'title'         => __( 'Overlay', 'bb-powerpack' ),
				'fields'        => array(
					'overlay_color' => array(
						'type'       	=> 'color',
						'label'     	=> __('Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'preview'		=> 'none',
						'connections'	=> array('color'),
					),
				)
			),
			'icon_style'	=> array(
				'title'			=> __('Icon Style', 'bb-powerpack'),
				'fields'		=> array(
					'overlay_icon_size'     => array(
						'type'          => 'unit',
						'label'         => __('Icon Size', 'bb-powerpack'),
						'default'   	=> '30',
						'units'   		=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span, .pp-gallery-overlay .pp-overlay-icon span:before',
							'property'	=> 'font-size',
							'unit'		=> 'px'
						),
					),
					'overlay_icon_bg_color' => array(
						'type'       	=> 'color',
						'label'     	=> __('Background Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
							'property'	=> 'color'
						),
					),
					'overlay_icon_color' => array(
						'type'       	=> 'color',
						'label'     	=> __('Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
							'property'	=> 'color'
						),
					),
					'overlay_icon_radius'     => array(
						'type'          => 'unit',
						'label'         => __('Border Radius', 'bb-powerpack'),
						'default'   	=> '',
						'units'  	 	=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
							'property'	=> 'border-radius',
							'unit'		=> 'px'
						),
					),
					'overlay_icon_padding' 	=> array(
						'type'          => 'unit',
						'label'         => __('Padding', 'bb-powerpack'),
						'default'   	=> '',
						'units'   		=> array( 'px' ),
						'slider'		=> true,
						'responsive'	=> true,
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
							'property'	=> 'padding',
							'unit'		=> 'px'
						),
                    ),
				)
			),
			'caption_style'	=> array(
				'title'		=> __('Caption', 'bb-powerpack'),
				'fields'	=> array(
					'caption_bg_color'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Background Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-photo-gallery-caption',
							'property'	=> 'background-color'
						),
					),
					'caption_alignment' => array(
						'type'		=> 'align',
						'label'		=> __('Text Alignment', 'bb-powerpack'),
						'default'	=> 'center',
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-photo-gallery-caption',
							'property'	=> 'text-align'
						),
					),
					'caption_padding'    => array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-photo-gallery-caption',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
                    ),
				)
			),
		)
	),
	'filters'	=> array(
		'title'		=> __('Filters', 'bb-powerpack'),
		'sections'	=> array(
			'filters_style'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'filter_bg_color'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Background Color', 'bb-powerpack'),
						'default'    	=> 'eeeeee',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-filters li',
							'property'	=> 'background-color'
						),
					),
					'filter_bg_hover'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Background Hover Color', 'bb-powerpack'),
						'default'    	=> 'bbbbbb',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'filter_text_color'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Text Color', 'bb-powerpack'),
						'default'    	=> '000000',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-filters li',
							'property'	=> 'color'
						),
					),
					'filter_text_hover'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Text Hover Color', 'bb-powerpack'),
						'default'    	=> 'ffffff',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-filters li:hover',
							'property'	=> 'color'
						),
					),
					'filter_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-gallery-filters li',
                            'property'  	=> 'border',
                        ),
					),
					'filter_border_color_hover'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Border Hover Color', 'bb-powerpack' ),
						'default'		=> 'eeeeee',
						'connections'	=> array('color'),
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-gallery-filters li:hover',
                            'property'  	=> 'border-color',
                        ),
					),
					'filter_padding'    => array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-gallery-filters li',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
                    ),
					'filter_margin' 	=> array(
						'type'      => 'unit',
                        'label'     => __('Horizontal Spacing', 'bb-powerpack'),
                        'default'   => 10,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-gallery-filters li',
							'property'        => 'margin-right',
							'unit'            => 'px'
                        ),
                    ),
					'filter_margin_bottom' 	=> array(
						'type'      => 'unit',
                        'label'     => __('Vertical Spacing', 'bb-powerpack'),
                        'default'   => 30,
                        'units'   	=> array( 'px' ),
						'slider'	=> true,
                        'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-gallery-filters',
							'property'        => 'margin-bottom',
							'unit'            => 'px'
                        ),
                    ),
					'filter_alignment'    => array(
                        'type'      => 'align',
                        'label'     => __('Alignment', 'bb-powerpack'),
                        'default'   => 'left',
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-gallery-filters',
							'property'        => 'text-align',
                        ),
                    ),
				)
			),
			'filters_style_responsive'	=> array(
				'title'		=> __('Filters Responsive', 'bb-powerpack'),
				'fields'	=> array(
					'filter_toggle_bg'	=> array(
						'type'				=> 'color',
						'label'				=> __('Toggle Background Color', 'bb-powerpack'),
						'default'			=> 'fafafa',
						'show_reset' 		=> true,
						'show_alpha'		=> true,
						'connections'	=> array('color'),
						'preview'			=> array(
							'type'				=> 'none'
						)
					),
					'filter_toggle_color'	=> array(
						'type'		=>	'color',
						'label'		=> __( 'Toggle Text Color', 'bb-powerpack' ),
						'default'	=> '333333',
						'connections'	=> array('color'),
					),
					'filter_toggle_icon_color'	=> array(
						'type'		=>	'color',
						'label'		=> __( 'Toggle Icon Color', 'bb-powerpack' ),
						'default'	=> '333333',
						'connections'	=> array('color'),
					),
					'filter_toggle_border'	=> array(
						'type'					=> 'unit',
						'label'					=> __('Toggle Border Width', 'bb-powerpack'),
						'default'				=> '0',
						'units'					=> array( 'px' ),
						'slider'				=> true,
						'preview'				=> array(
							'type'					=> 'none'
						)
					),
					'filter_toggle_border_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Toggle Border Color', 'bb-powerpack'),
						'default'		=> 'eeeeee',
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'filter_toggle_radius'	=> array(
						'type'					=> 'unit',
						'label'					=> __('Toggle Round Corners', 'bb-powerpack'),
						'default'				=> '0',
						'units'					=> array( 'px' ),
						'slider'				=> true,
						'preview'				=> array(
							'type'					=> 'none'
						)
					),
					'filter_res_bg_color'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Filter Background Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'filter_res_bg_hover'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Filter Background Hover Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
					'filter_res_text_color'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Filter Text Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'filter_res_text_hover'	=> array(
						'type'       	=> 'color',
						'label'     	=> __('Filter Text Hover Color', 'bb-powerpack'),
						'default'    	=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
				)
			)
		)
	),
	'typography'	=> array(
		'title'	=> __( 'Typography', 'bb-powerpack' ),
		'sections'	=> array(
			'general_typography'	=> array(
				'title'	=> __( 'Caption', 'bb-powerpack' ),
				'fields'	=> array(
					'caption_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-photo-gallery-caption, .pp-gallery-overlay .pp-caption',
						),
					),
			        'caption_color'        => array(
			            'type'       => 'color',
			            'label'      => __('Color', 'bb-powerpack'),
						'default'    => '',
						'connections'	=> array('color'),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-photo-gallery-caption, .pp-gallery-overlay .pp-caption',
							'property'	=> 'color'
						)
			        ),
				)
			),
			'filter_typography'  => array(
                'title' => __('Filter', 'bb-powerpack'),
                'fields'    => array(
                    'filter_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-gallery-filters li',
						),
					),
                ),
            ),
		)
	)
));

FLBuilder::register_settings_form('pp_gallery_filter_form', array(
	'title' => __( 'Add Filter', 'bb-powerpack' ),
	'tabs'	=> array(
		'general'	=> array(
			'title'	=> __( 'General', 'bb-powerpack' ),
			'sections'	=> array(
				'filters'	=> array(
					'title'		=> '',
					'fields'	=> array(
						'filter_label'     => array(
							'type'          => 'text',
							'label'         => __( 'Filter Label', 'bb-powerpack' ),
							'placeholder'   => '',
							'connections'	=> array('string')
						),
						'gallery_photos' => array(
						    'type'          => 'multiple-photos',
						    'label'         => __( 'Photos', 'bb-powerpack' ),
                            'connections'   => array('multiple-photos')
						),
					)
				)
			)
		)
	)
));
