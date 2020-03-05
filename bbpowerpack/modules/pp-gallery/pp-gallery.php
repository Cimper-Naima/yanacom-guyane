<?php
/**
 * @class PPGalleryModule
 */
class PPGalleryModule extends FLBuilderModule {
	public $photos = array();
	public $current_photos = array();

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct( array(
			'name'          => __('Photo Gallery', 'bb-powerpack'),
			'description'   => __('A module for photo gallery.', 'bb-powerpack'),
			'group'         => pp_get_modules_group(),
			'category'		=> pp_get_modules_cat( 'content' ),
			'dir'           => BB_POWERPACK_DIR . 'modules/pp-gallery/',
			'url'           => BB_POWERPACK_URL . 'modules/pp-gallery/',
			'editor_export' => true, // Defaults to true and can be omitted.
			'enabled'       => true, // Defaults to true and can be omitted.
			'partial_refresh' => true
		) );
		
		add_action( 'wp', array( $this, 'ajax_get_gallery_photos' ) );
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle old box border and radius fields.
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
			'image_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->show_image_shadow ) && 'yes' == $settings->show_image_shadow )
			),
			'image_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->show_image_shadow ) && 'yes' == $settings->show_image_shadow ),
				'opacity'			=> isset( $settings->image_shadow_opacity ) ? $settings->image_shadow_opacity : 1
			),
		), 'photo_border_group' );

		// Handle image shadow opacity + color field.
		if ( isset( $settings->image_shadow_opacity_hover ) ) {
			$opacity = $settings->image_shadow_opacity_hover >= 0 ? $settings->image_shadow_opacity_hover : 1;
			$color = $settings->image_shadow_color_hover;

			if ( ! empty( $color ) ) {
				$color = pp_hex2rgba( pp_get_color_value( $color ), $opacity );
				$settings->image_shadow_color_hover = $color;
			}

			unset( $settings->image_shadow_opacity_hover );
		}

		// Handle caption old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'caption_padding', 'padding', 'caption_padding' );

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

		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'load_more_border_style'	=> array(
				'type'				=> 'style'
			),
			'load_more_border_width'	=> array(
				'type'				=> 'width'
			),
			'load_more_border_color'	=> array(
				'type'				=> 'color'
			),
			'load_more_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'load_more_border' );

		return $settings;
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		$this->add_js('jquery-masonry');

		$this->add_js( 'jquery-isotope' );

		$this->add_css( 'pp-jquery-fancybox' );
		$this->add_js( 'pp-jquery-fancybox' );

		$this->add_css( 'jquery-justifiedgallery' );
		$this->add_js( 'jquery-justifiedgallery' );
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

	public function ajax_get_gallery_photos()
	{
		if ( ! isset( $_POST['pp_action'] ) || 'pp_gallery_get_photos' != $_POST['pp_action'] ) {
			return;
		}

		// Tell WordPress this is an AJAX request.
		if ( ! defined( 'DOING_AJAX' ) ) {
			define( 'DOING_AJAX', true );
		}

		$response = array(
			'error'	=> false,
			'data'	=> ''
		);

		$node_id 			= isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
		$template_id    	= isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
		$template_node_id   = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;

		if ( $node_id ) {
			$settings = (object)$_POST['settings'];

			if ( ! isset( $this->settings ) ) {
				$this->settings = $settings;
			}
			elseif ( empty( $this->settings ) ) {
				$this->settings = $settings;
			}

			if ( empty( $this->photos ) ) {
				$this->get_photos();
			}

			$item_class = $this->get_item_class();

			ob_start();
			foreach ( $this->photos as $photo ) {
				include $this->dir . 'includes/layout.php';
			}
			$response['data'] = ob_get_clean();
		} else {
			$response['error'] = true;
		}

		echo json_encode( $response ); die;
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

			foreach ($keys as $key) {
				$photos_id[$key] = $default_order[$key];
			}
		} else {
			$photos_id = $default_order;
		}

		$this->photos = $photos_id;

		if ( isset( $settings->pagination ) && 'none' != $settings->pagination ) {
			if ( empty( $settings->images_per_page ) ) {
				return $this->photos;
			}

			$per_page = (int)$settings->images_per_page;

			if ( $per_page >= count( $photos_id ) ) {
				return $this->photos;
			}

			$count = 0;

			foreach ( $photos_id as $photo_id => $photo ) {
				if ( $count == $per_page ) {
					break;
				} else {
					$this->current_photos[ $photo_id ] = $photo;
					$count++;
				}
			}

			return $this->current_photos;
		}

		return $this->photos;
	}

	/**
	 * @method get_wordpress_photos
	 */
	public function get_wordpress_photos()
	{
		$photos     = array();
		$ids        = $this->settings->gallery_photos;
		$medium_w   = get_option('medium_size_w');
		$large_w    = get_option('large_size_w');

		/* Template Cache */
		$photo_from_template = false;
		$photo_attachment_data = false;

		if(empty($this->settings->gallery_photos)) {
			return $photos;
		}

		/* Check if all photos are available on host */
		foreach ($ids as $id) {
			$photo_attachment_data[$id] = FLBuilderPhoto::get_attachment_data($id);

			if ( ! $photo_attachment_data[$id] ) {
				$photo_from_template = true;
			}

		}

		foreach($ids as $id) {

			$photo = $photo_attachment_data[$id];

			// Use the cache if we didn't get a photo from the id.
			if ( ! $photo && $photo_from_template ) {

				if ( ! isset( $this->settings->photo_data ) ) {
					continue;
				}
				else if ( is_array( $this->settings->photo_data ) ) {
					$photos[ $id ] = $this->settings->photo_data[ $id ];
				}
				else if ( is_object( $this->settings->photo_data ) ) {
					$photos[ $id ] = $this->settings->photo_data->{$id};
				}
				else {
					continue;
				}
			}


			// Only use photos who have the sizes object.
			if(isset($photo->sizes)) {

				$data = new stdClass();

				// Photo data object
				$data->id = $id;
				$data->alt = htmlspecialchars( $photo->alt );
				$data->caption = htmlspecialchars( $photo->caption );
				$data->description = htmlspecialchars( $photo->description );
				$data->title = htmlspecialchars( $photo->title );
				$data->sizes = array();

				$image_size = $this->settings->photo_size;

				// Collage photo src
				if($this->settings->gallery_layout == 'masonry') {

					if($this->settings->photo_size == 'thumbnail' && isset($photo->sizes->thumbnail)) {
						$data->src = $photo->sizes->thumbnail->url;
						$data->sizes['height'] = $photo->sizes->thumbnail->height;
						$data->sizes['width'] = $photo->sizes->thumbnail->width;
					}
					elseif($this->settings->photo_size == 'medium' && isset($photo->sizes->medium)) {
						$data->src = $photo->sizes->medium->url;
						$data->sizes['height'] = $photo->sizes->medium->height;
						$data->sizes['width'] = $photo->sizes->medium->width;
					}
					elseif( isset( $photo->sizes->{$image_size} ) ) {
						$data->src = $photo->sizes->{$image_size}->url;
						$data->sizes['height'] = $photo->sizes->{$image_size}->height;
						$data->sizes['width'] = $photo->sizes->{$image_size}->width;
					}
					else {
						$data->src = $photo->sizes->full->url;
						$data->sizes['height'] = $photo->sizes->full->height;
						$data->sizes['width'] = $photo->sizes->full->width;
					}
				}

				// Grid photo src
				else {

					if($this->settings->photo_size == 'thumbnail' && isset($photo->sizes->thumbnail)) {
						$data->src = $photo->sizes->thumbnail->url;
						$data->sizes['height'] = $photo->sizes->thumbnail->height;
						$data->sizes['width'] = $photo->sizes->thumbnail->width;
					}
					elseif($this->settings->photo_size == 'medium' && isset($photo->sizes->medium)) {
						$data->src = $photo->sizes->medium->url;
						$data->sizes['height'] = $photo->sizes->medium->height;
						$data->sizes['width'] = $photo->sizes->medium->width;
					}
					elseif( isset( $photo->sizes->{$image_size} ) ) {
						$data->src = $photo->sizes->{$image_size}->url;
						$data->sizes['height'] = $photo->sizes->{$image_size}->height;
						$data->sizes['width'] = $photo->sizes->{$image_size}->width;
					}
					else {
						$data->src = $photo->sizes->full->url;
						$data->sizes['height'] = $photo->sizes->full->height;
						$data->sizes['width'] = $photo->sizes->full->width;
					}
				}

				// Photo Link
				if(isset($photo->sizes->large)) {
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
				if(!empty($cta_link) && $this->settings->click_action == 'custom-link' ) {
					$data->cta_link = esc_url( $cta_link );
				}

				$photos[$id] = $data;
			}
		}

		return $photos;
	}

	public function get_item_class()
	{
		$item_class = 'pp-photo-gallery-item';
		$item_class .= ( 'masonry' == $this->settings->gallery_layout ) ? ' pp-gallery-masonry-item' : '';
		$item_class .= ( 'justified' == $this->settings->gallery_layout ) ? ' pp-gallery-justified-item' : '';

		return $item_class;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPGalleryModule', array(
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
							'justified'     => __( 'Justified', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'grid'	=> array(
								'sections'	=> array('gallery_columns', 'general_style', 'image_shadow_style', 'image_shadow_hover_style'),
								'fields'	=> array( 'align_items' ),
							),
							'masonry'	=> array(
								'sections'	=> array('gallery_columns', 'general_style', 'image_shadow_style', 'image_shadow_hover_style')
							),
							'justified'	=> array(
								'sections'	=> array('justified_settings')
							),
						)
					),
					'gallery_photos' => array(
						'type'          => 'multiple-photos',
						'label'         => __( 'Photos', 'bb-powerpack' ),
						'connections'  	=> array('multiple-photos')
					),
					'photo_size'        => array(
						'type'          => 'photo-sizes',
						'label'         => __('Image Size', 'bb-powerpack'),
						'default'       => 'medium',
						'options'       => array(
							'thumb'          	=> __( 'Thumbnail', 'bb-powerpack' ),
							'medium'       		=> __( 'Medium', 'bb-powerpack' ),
							'full'       		=> __( 'Full', 'bb-powerpack' ),
						),
					),
					'photo_order'        => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Display Order', 'bb-powerpack' ),
						'default'       => 'normal',
						'options'       => array(
							'normal'     	=> __( 'Normal', 'bb-powerpack' ),
							'random' 		=> __( 'Random', 'bb-powerpack' )
						),
					),
					'align_items'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Last Row Centered', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
					),
					'show_captions' => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Captions', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'no'             => __('Never', 'bb-powerpack'),
							'hover'         => __('On Hover', 'bb-powerpack'),
							'below'         => __('Always', 'bb-powerpack')
						),
						'toggle'	=> array(
							'hover'	=> array(
								'tabs'		=> array('caption_settings'),
							),
							'below'	=> array(
								'tabs'	=> array('caption_settings'),
								'sections'	=> array('caption_style')
							)
						),
						'help'          => __('The caption pulls from whatever text you put in the caption area in the media manager for each image.', 'bb-powerpack')
					),
				)
			),
			'click_action'	=> array(
				'title'			=> __('Click Action', 'bb-powerpack'),
				'collapsed'			=> true,
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
						'toggle'	=> array(
							'lightbox'	=> array(
								'fields'	=> array('show_lightbox_thumb', 'lightbox_image_size', 'lightbox_caption'),
								'sections'	=> array('lightbox_style'),
							),
							'custom-link'	=> array(
								'fields'	=> array('custom_link_target')
							)
						),
						'preview'       => array(
							'type'          => 'none'
						),
						'help'		=> __('Custom URL field is available in media uploader modal where you have added the images.', 'bb-powerpack')
					),
					'show_lightbox_thumb' => array(
						'type'		=> 'pp-switch',
						'label'		=> __('Show Thumbnail Navigation in Lightbox?', 'bb-powerpack'),
						'default'	=> 'no',
						'options'	=> array(
							'yes'		=> __('Yes', 'bb-powerpack'),
							'no'		=> __('No', 'bb-powerpack'),
						),
						'preview'	=> array(
							'type'		=> 'none'
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
					'lightbox_caption_source'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Caption Source', 'bb-powerpack'),
						'default'		=> 'title',
						'options'		=> array(
							'title'			=> __( 'Title', 'bb-powerpack' ),
							'caption'		=> __( 'Caption', 'bb-powerpack' ),
						),
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
			'hover_effects'	=> array(
				'title'			=> __('Hover Effects', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'hover_effects' => array(
						'type'          => 'select',
						'label'         => __('Image Hover Effect', 'bb-powerpack'),
						'default'       => 'none',
						'options'       => array(
							'none' 			=> __('None', 'bb-powerpack'),
							'zoom-in'		=> __('Zoom In', 'bb-powerpack'),
							'zoom-out'		=> __('Zoom Out', 'bb-powerpack'),
							'greyscale'		=> __('Greyscale', 'bb-powerpack'),
							'blur'			=> __('Blur', 'bb-powerpack'),
							'rotate'		=> __('Rotate', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'zoom-in'	=> array(
								'fields'	=> array('image_animation_speed')
							),
							'zoom-out'	=> array(
								'fields'	=> array('image_animation_speed')
							),
							'greyscale'	=> array(
								'fields'	=> array('image_animation_speed')
							),
							'blur'	=> array(
								'fields'	=> array('image_animation_speed')
							),
							'rotate'	=> array(
								'fields'	=> array('image_animation_speed')
							),
						),
						'preview'	=> 'none',
					),
					'image_animation_speed' => array(
						'type'          => 'text',
						'label'         => __('Animation Speed', 'bb-powerpack'),
						'description'   => __('ms', 'bb-powerpack'),
						'default'       => 300,
						'size'          => 5,
					),
				)
			),
			'overlay_settings'	=> array(
				'title'	=> __( 'Overlay', 'bb-powerpack' ),
				'collapsed'			=> true,
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
							'framed'		=> __('Framed', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'from-left'	=> array(
								'sections' 	=> array( 'overlay_style' ),
								'fields'	=> array('overlay_animation_speed')
							),
							'from-right'	=> array(
								'sections' 	=> array( 'overlay_style' ),
								'fields'	=> array('overlay_animation_speed')
							),
							'from-top'	=> array(
								'sections' 	=> array( 'overlay_style' ),
								'fields'	=> array('overlay_animation_speed')
							),
							'from-bottom'	=> array(
								'sections' 	=> array( 'overlay_style' ),
								'fields'	=> array('overlay_animation_speed')
							),
							'fade'	=> array(
								'sections' 	=> array( 'overlay_style' ),
								'fields'	=> array('overlay_animation_speed')
							),
							'framed'	=> array(
								'sections' 	=> array( 'overlay_style' ),
								'fields'	=> array('overlay_animation_speed', 'overlay_border_width', 'overlay_border_color', 'overlay_spacing')
							),
						),
						'preview'	=> 'none',
					),
					'overlay_animation_speed' => array(
						'type'          => 'text',
						'label'         => __('Animation Speed', 'bb-powerpack'),
						'description'   => __('ms', 'bb-powerpack'),
						'default'       => 300,
						'size'          => 5,
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
			'gallery_columns'	=> array(
				'title'	=> __( 'Columns Settings', 'bb-powerpack' ),
				'collapsed'			=> true,
				'fields'	=> array(
					'photo_grid_count'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Number of Columns', 'bb-powerpack'),
						'slider'          => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '4',
								'medium' => '2',
								'responsive' => '1',
							),
						),
					),
					'photo_spacing' => array(
						'type'          => 'unit',
						'label'         => __('Spacing', 'bb-powerpack'),
						'default'       => 2,
						'slider'		=> true,
						'units'		   	=> array( '%' )
					),
				)
			),
			'justified_settings'	=> array(
				'title'		=>	__('Justified Gallery Settings', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'	=> array(
					'justified_spacing' => array(
						'type'          => 'unit',
						'label'         => __('Spacing', 'bb-powerpack'),
						'default'       => 5,
						'slider'        => true,
						'units'   		=> array( 'px' )
					),
					'row_height' => array(
						'type'          => 'unit',
						'label'         => __('Row Height', 'bb-powerpack'),
						'default'       => 120,
						'slider'        => true,
						'units'   		=> array( 'px' )
					),
					'max_row_height' => array(
						'type'          => 'unit',
						'label'         => __('Max Row Height', 'bb-powerpack'),
						'default'       => 0,
						'slider'        => true,
						'units'   		=> array( 'px' )
					),
					'last_row' => array(
						'type'		=> 'pp-switch',
						'label'		=> __('Last Row', 'bb-powerpack'),
						'default'	=> 'nojustify',
						'options'	=> array(
							'nojustify'		=> __('No Justfiy', 'bb-powerpack'),
							'justify'		=> __('Justify', 'bb-powerpack'),
							'hide'			=> __('Hide', 'bb-powerpack'),
						),
					)
				)
			),
			'lightbox_settings'	=> array(
				'title'				=>	__('Lightbox Settings', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'lightbox_animation' => array(
						'type'				=> 'select',
						'label'				=> __( 'Open/Close Animation', 'bb-powerpack'),
						'default'			=> 'zoom',
						'options'			=> array(
							''              	=> __( 'None', 'bb-powerpack' ),
							'fade'          	=> __( 'Fade', 'bb-powerpack' ),
							'zoom'          	=> __( 'Zoom', 'bb-powerpack' ),
							'zoom-in-out'   	=> __( 'Zoom in Out', 'bb-powerpack' ),
						),
					),
					'transition_effect'	=> array(
						'type'				=> 'select',
						'label'				=> __( 'Transition Effect', 'bb-powerpack'),
						'default'			=> 'fade',
						'help'				=> __( 'Transition effect between slides', 'bb-powerpack' ),
						'options'			=> array(
							''              	=> __( 'None', 'bb-powerpack' ),
							'fade'          	=> __( 'Fade', 'bb-powerpack' ),
							'slide'         	=> __( 'Slide', 'bb-powerpack' ),
							'circular'      	=> __( 'Circular', 'bb-powerpack' ),
							'tube'          	=> __( 'Tube', 'bb-powerpack' ),
							'zoom-in-out'   	=> __( 'Zoom in Out', 'bb-powerpack' ),
							'rotate'        	=> __( 'Rotate', 'bb-powerpack' ),
						),
					),
				),
			),
		)
	),
	'style'	=> array(
		'title'	=> __( 'Style', 'bb-powerpack' ),
		'sections'	=> array(
			'general_style'	=> array(
				'title'	=> __( 'Image', 'bb-powerpack' ),
				'fields'	=> array(
					'photo_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
							'type'  		=> 'css',
							'selector'  	=> '.pp-photo-gallery-item',
							'property'  	=> 'border',
						),
					),
					'photo_padding'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Padding', 'bb-powerpack'),
						'units'			=> array( 'px' ),
						'slider'        => true,
						'responsive'	=> true,
						'preview' => array(
							'type' 		=> 'css',
							'selector'	=> '.pp-photo-gallery-item',
							'property'	=> 'padding',
							'unit' 		=> 'px'
						),
					),
				)
			),
			'image_shadow_hover_style'	=> array(
				'title'		=> __( 'Image Shadow on Hover', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'show_image_shadow_hover'   => array(
						'type'                 => 'pp-switch',
						'label'                => __('Enable Shadow', 'bb-powerpack'),
						'default'              => 'no',
						'options'              => array(
							'yes'          	=> __('Yes', 'bb-powerpack'),
							'no'            => __('No', 'bb-powerpack'),
						),
						'toggle'    =>  array(
							'yes'   => array(
								'fields'    => array('image_shadow_hover', 'image_shadow_color_hover', 'image_shadow_hover_speed')
							)
						)
					),
					'image_shadow_hover' 		=> array(
						'type'              => 'pp-multitext',
						'label'             => __('Shadow', 'bb-powerpack'),
						'default'           => array(
							'vertical'			=> 0,
							'horizontal'		=> 2,
							'blur'				=> 15,
							'spread'			=> 0
						),
						'options'			=> array(
							'vertical'			=> array(
								'placeholder'		=> __('Vertical', 'bb-powerpack'),
								'tooltip'			=> __('Vertical', 'bb-powerpack'),
								'icon'				=> 'fa-arrows-v'
							),
							'horizontal'		=> array(
								'placeholder'		=> __('Horizontal', 'bb-powerpack'),
								'tooltip'			=> __('Horizontal', 'bb-powerpack'),
								'icon'				=> 'fa-arrows-h'
							),
							'blur'				=> array(
								'placeholder'		=> __('Blur', 'bb-powerpack'),
								'tooltip'			=> __('Blur', 'bb-powerpack'),
								'icon'				=> 'fa-circle-o'
							),
							'spread'			=> array(
								'placeholder'		=> __('Spread', 'bb-powerpack'),
								'tooltip'			=> __('Spread', 'bb-powerpack'),
								'icon'				=> 'fa-paint-brush'
							),
						)
					),
					'image_shadow_color_hover' => array(
						'type'              => 'color',
						'label'             => __('Shadow Color', 'bb-powerpack'),
						'default'           => 'rgba(0,0,0,0.5)',
						'show_alpha'		=> true,
						'connections'		=> array('color'),
					),
					'image_shadow_hover_speed' => array(
						'type'              => 'text',
						'label'             => __('Transition Speed', 'bb-powerpack'),
						'default'			=> '300',
						'description'       => 'ms',
						'size'             	=> 5,
					),
				)
			),
			'overlay_style'       => array(
				'title'         => __( 'Overlay', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'overlay_type'     => array(
						'type'      => 'pp-switch',
						'label'     => __('Type', 'bb-powerpack'),
						'default'     => 'solid',
						'options'       => array(
							'solid'          => __('Solid', 'bb-powerpack'),
							'gradient'          => __('Gradient', 'bb-powerpack'),
						),
						'toggle'   => array(
							'solid'    => array(
								'fields'   => array('overlay_color')
							),
							'gradient'    => array(
								'fields'   => array('overlay_primary_color', 'overlay_secondary_color')
							),
						)
					),
					'overlay_color' => array(
						'type'       => 'color',
						'label'     => __('Color', 'bb-powerpack'),
						'default'	=> '',
						'show_reset' => true,
						'preview'	=> 'none',
						'connections'	=> array('color'),
					),
					'overlay_primary_color' => array(
						'type'       => 'color',
						'label'     => __('Primary Color', 'bb-powerpack'),
						'default'	=> '',
						'show_reset' => true,
						'preview'	=> 'none',
						'connections'	=> array('color'),
					),
					'overlay_secondary_color' => array(
						'type'       => 'color',
						'label'     => __('Secondary Color', 'bb-powerpack'),
						'default'	=> '',
						'show_reset' => true,
						'preview'	=> 'none',
						'connections'	=> array('color'),
					),
					'overlay_color_opacity'    => array(
						'type'        => 'text',
						'label'       => __('Opacity', 'bb-powerpack'),
						'default'     => '70',
						'description' => '%',
						'maxlength'   => '3',
						'size'        => '5',
					),
					'overlay_border_width'    => array(
						'type'        => 'text',
						'label'       => __('Border Width', 'bb-powerpack'),
						'default'     => '',
						'description' => 'px',
						'maxlength'   => '3',
						'size'        => '5',
					),
					'overlay_border_color' => array(
						'type'       => 'color',
						'label'     => __('Border Color', 'bb-powerpack'),
						'default'	=> '',
						'show_reset' => true,
						'preview'	=> 'none',
						'connections'	=> array('color'),
					),
					'overlay_spacing'    => array(
						'type'        => 'text',
						'label'       => __('Spacing', 'bb-powerpack'),
						'default'     => '',
						'description' => 'px',
						'maxlength'   => '3',
						'size'        => '5',
					),
				)
			),
			'icon_style'	=> array(
				'title'			=> __('Icon Style', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'		=> array(
					'overlay_icon_size'     => array(
						'type'          => 'text',
						'label'         => __('Icon Size', 'bb-powerpack'),
						'default'   	=> '30',
						'maxlength'     => 5,
						'size'          => 6,
						'description'   => 'px',
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
							'property'	=> 'font-size',
							'unit'		=> 'px'
						),
					),
					'overlay_icon_bg_color' => array(
						'type'       => 'color',
						'label'     => __('Background Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset'	=> true,
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
						'type'          => 'text',
						'label'         => __('Round Corners', 'bb-powerpack'),
						'default'   	=> '',
						'maxlength'     => 5,
						'size'          => 6,
						'description'   => 'px',
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
							'property'	=> 'border-radius',
							'unit'		=> 'px'
						),
					),
					'overlay_icon_horizotal_padding' 	=> array(
						'type'          => 'text',
						'label'         => __('Horizontal Padding', 'bb-powerpack'),
						'default'   	=> '',
						'maxlength'     => 5,
						'size'          => 6,
						'description'   => 'px',
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
									'property'	=> 'padding-left',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
									'property'	=> 'padding-right',
									'unit'		=> 'px'
								),
							)
						),
					),
					'overlay_icon_vertical_padding' 	=> array(
						'type'          => 'text',
						'label'         => __('Vertical Padding', 'bb-powerpack'),
						'default'   	=> '',
						'maxlength'     => 5,
						'size'          => 6,
						'description'   => 'px',
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
									'property'	=> 'padding-top',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-gallery-overlay .pp-overlay-icon span',
									'property'	=> 'padding-bottom',
									'unit'		=> 'px'
								),
							)
						),
					),
				)
			),
			'lightbox_style'	=> array(
				'title'	=> __( 'Lightbox', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'	=> array(
					'lightbox_overlay_color' => array(
						'type'       	=> 'color',
						'label'     	=> __('Overlay Color', 'bb-powerpack'),
						'default'    	=> 'rgba(0,0,0,0.5)',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
				),
			)
		)
	),
	'caption_settings'	=> array(
		'title'	=> __( 'Caption', 'bb-powerpack' ),
		'sections'	=> array(
			'caption_style'	=> array(
				'title'		=> __('Style', 'bb-powerpack'),
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
					'caption_padding'	=> array(
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
			'general_typography'	=> array(
				'title'	=> __( 'Typography', 'bb-powerpack' ),
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
			)
		)
	),
	'pagination'	=> array(
		'title'			=> __('Pagination', 'bb-powerpack'),
		'sections'		=> array(
			'pagination'	=> array(
				'title'			=> __('General', 'bb-powerpack'),
				'fields'		=> array(
					'pagination'	=> array(
						'type'			=> 'select',
						'label'			=> __('Pagination', 'bb-powerpack'),
						'default'		=> 'none',
						'options'		=> array(
							'none'			=> __('None', 'bb-powerpack'),
							'load_more'		=> __('Load More Button', 'bb-powerpack'),
							'scroll'		=> __('Scroll', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'load_more'		=> array(
								'sections'		=> array( 'pagination_button_style' ),
								'fields'		=> array( 'images_per_page', 'load_more_text' )
							),
							'scroll'		=> array(
								'fields'		=> array('images_per_page')
							)
						)
					),
					'images_per_page'	=> array(
						'type'				=> 'unit',
						'label'				=> __('Images Per Page', 'bb-powerpack'),
						'default'			=> '6',
						'slider'			=> true
					),
					'load_more_text'	=> array(
						'type'				=> 'text',
						'label'				=> __('Load More Button Text', 'bb-powerpack'),
						'default'			=> __('Load More', 'bb-powerpack'),
					)
				)
			),
			'pagination_button_style'	=> array(
				'title'				=> __('Button Style', 'bb-powerpack'),
				'fields'			=> PP_Module_Fields::get_button_style_fields(
					// field prefix
					'load_more',
					// data
					array(
						'bg_color'	=> array(
							'default'	=> 'eee',
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.pp-gallery-pagination .pp-gallery-load-more',
								'property'	=> 'background-color'
							)
						),
						'text_color' => array(
							'connections'	=> array('color'),
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.pp-gallery-pagination .pp-gallery-load-more',
								'property'	=> 'color'
							)
						),
						'border'	=> array(
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.pp-gallery-pagination .pp-gallery-load-more',
								'property'	=> 'border'
							)
						),
						'border_hover_color' => array(
							'connections'	=> array('color'),
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.pp-gallery-pagination .pp-gallery-load-more:hover',
								'property'	=> 'border-color'
							)
						),
						'margin_top' => array(
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.pp-gallery-pagination .pp-gallery-load-more',
								'property'	=> 'margin-top',
								'unit'		=> 'px'
							)
						),
						'padding'	=> array(
							'default'	=> '10',
						),
						'alignment'	=> array(
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.pp-gallery-pagination',
								'property'	=> 'text-align'
							)
						)
					)
				)
			)
		)
	)
));
