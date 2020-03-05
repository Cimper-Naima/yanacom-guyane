<?php

/**
 * @class PPTeamModule
 */
class PPTeamModule extends FLBuilderModule {
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
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Team', 'bb-powerpack'),
            'description'   => __('Team module.', 'bb-powerpack'),
            'group'         => pp_get_modules_group(),
            'category'		=> pp_get_modules_cat( 'content' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-team/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-team/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh' => true,
        ));

        $this->add_css(BB_POWERPACK()->fa_css);
    }

	public function filter_settings( $settings, $helper )
	{
		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'box_border'	=> array(
				'type'				=> 'style'
			),
			'box_border_width'	=> array(
				'type'				=> 'width'
			),
			'box_border_color'	=> array(
				'type'				=> 'color'
			),
			'box_border_radius'	=> array(
				'type'				=> 'radius'
			),
			'box_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->box_shadow_display ) && 'yes' == $settings->box_shadow_display )
			),
			'box_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->box_shadow_display ) && 'yes' == $settings->box_shadow_display ),
				'opacity'			=> isset( $settings->box_shadow_opacity ) ? $settings->box_shadow_opacity : 1
			),
		), 'box_border_group' );

		// Handle box old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'box_padding', 'padding', 'box_padding_group' );

		// Handle old image border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'image_border'	=> array(
				'type'				=> 'style'
			),
			'image_border_width'	=> array(
				'type'				=> 'width'
			),
			'image_border_color'	=> array(
				'type'				=> 'color'
			),
			'image_border_radius'	=> array(
				'type'				=> 'radius'
			),
			'image_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->image_shadow_display ) && 'yes' == $settings->image_shadow_display )
			),
			'image_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->image_shadow_display ) && 'yes' == $settings->image_shadow_display ),
				'opacity'			=> isset( $settings->image_shadow_opacity ) ? $settings->image_shadow_opacity : 1
			),
		), 'image_border_group' );

		// Handle content old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'box_content_padding', 'padding', 'content_padding' );

		// Handle old social icons border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'social_links_border'	=> array(
				'type'				=> 'style'
			),
			'social_links_border_width'	=> array(
				'type'				=> 'width'
			),
			'social_links_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'social_links_border_group' );

		if ( isset( $settings->social_links_border_color ) ) {
			$settings->social_links_border_group['color'] = $settings->social_links_border_color['primary'];
			$settings->social_links_border_hover_color = $settings->social_links_border_color['secondary'];
			unset( $settings->social_links_border_color );
		}

		// Handle social links old padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'social_links_padding', 'padding', 'social_links_padding' );

		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'title_font'	=> array(
				'type'			=> 'font'
			),
			'title_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->title_font_size_toggle ) && 'custom' == $settings->title_font_size_toggle )
			),
			'title_custom_line_height'	=> array(
				'type'			=> 'line_height',
				'condition'		=> ( isset( $settings->title_line_height_toggle ) && 'custom' == $settings->title_line_height_toggle )
			),
		), 'title_typography' );

		// Handle designation's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'designation_font'	=> array(
				'type'			=> 'font'
			),
			'designation_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->designation_font_size_toggle ) && 'custom' == $settings->designation_font_size_toggle )
			),
			'designation_custom_line_height'	=> array(
				'type'			=> 'line_height',
				'condition'		=> ( isset( $settings->designation_line_height_toggle ) && 'custom'	== $settings->designation_line_height_toggle )
			),
		), 'designation_typography' );

		// Handle description's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'description_font'	=> array(
				'type'			=> 'font'
			),
			'description_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->description_font_size_toggle ) && 'custom' == $settings->description_font_size_toggle )
			),
			'description_custom_line_height'	=> array(
				'type'			=> 'line_height',
				'condition'		=> ( isset( $settings->description_line_height_toggle ) && 'custom'	== $settings->description_line_height_toggle )
			),
		), 'description_typography' );

		// Handle old box background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'box_background', array(
			'primary'	=> 'box_bg_color',
			'secondary'	=> 'box_bg_hover_color'
		) );

		// Handle old social icons background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'social_links_background', array(
			'primary'	=> 'social_links_bg_color',
			'secondary'	=> 'social_links_bg_hover_color'
		) );

		// Handle old link, link_target fields.
		$settings = PP_Module_Fields::handle_link_field( $settings, array(
			'link_url'			=> array(
				'type'			=> 'link'
			),
			'link_target'	=> array(
				'type'			=> 'target'
			),
		), 'link' );

		return $settings;
	}

    /**
	 * @method update
	 * @param $settings {object}
	 */
	public function update($settings)
	{
		// Make sure we have a photo_src property.
		if(!isset($settings->member_image_src)) {
			$settings->member_image_src = '';
		}

		// Cache the attachment data.
		$data = FLBuilderPhoto::get_attachment_data($settings->member_image);

		if($data) {
			$settings->data = $data;
		}

		// Save a crop if necessary.
		$this->crop();

		return $settings;
	}

	/**
	 * @method delete
	 */
	public function delete()
	{
		$cropped_path = $this->_get_cropped_path();
		
		if ( function_exists( 'fl_builder_filesystem' ) ) {
			if ( fl_builder_filesystem()->file_exists( $cropped_path['path'] ) ) {
				fl_builder_filesystem()->unlink( $cropped_path['path'] );
			}
		} else {
			if ( file_exists( $cropped_path['path'] ) ) {
				unlink( $cropped_path['path'] );
			}
		}
	}

	/**
	 * @method crop
	 */
	public function crop()
	{
		// Delete an existing crop if it exists.
		$this->delete();

		// Do a crop.
		if(!empty($this->settings->member_image_crop)) {

			$editor = $this->_get_editor();

			if(!$editor || is_wp_error($editor)) {
				return false;
			}

			$cropped_path = $this->_get_cropped_path();
			$size         = $editor->get_size();
			$new_width    = $size['width'];
			$new_height   = $size['height'];

			if($this->settings->member_image_crop == 'portrait') {
				$ratio_1 = .7;
				$ratio_2 = 1.43;
			}
			elseif($this->settings->member_image_crop == 'square') {
				$ratio_1 = 1;
				$ratio_2 = 1;
			}
			elseif($this->settings->member_image_crop == 'circle') {
				$ratio_1 = 1;
				$ratio_2 = 1;
			}

			// Get the new width or height.
			if($size['width'] / $size['height'] < $ratio_1) {
				$new_height = $size['width'] * $ratio_2;
			}
			else {
				$new_width = $size['height'] * $ratio_1;
			}

			// Make sure we have enough memory to crop.
			@ini_set('memory_limit', '300M');

			// Crop the photo.
			$editor->resize($new_width, $new_height, true);

			// Save the photo.
			$editor->save($cropped_path['path']);

			// Return the new url.
			return $cropped_path['url'];
		}

		return false;
	}

	/**
	 * @method get_data
	 */
	public function get_data()
	{
		if(!$this->data) {

			// Photo source is set to "library".
			if(is_object($this->settings->member_image)) {
				$this->data = $this->settings->member_image;
			}
			else {
				$this->data = FLBuilderPhoto::get_attachment_data($this->settings->member_image);
			}

			// Data object is empty, use the settings cache.
			if(!$this->data && isset($this->settings->data)) {
				$this->data = $this->settings->data;
			}
		}

		return $this->data;
	}

	/**
	 * @method get_classes
	 */
	public function get_classes()
	{
		$classes = array( 'fl-photo-img' );

		if ( ! empty( $this->settings->member_image ) ) {

			$data = self::get_data();

			if ( is_object( $data ) ) {

				$classes[] = 'wp-image-' . $data->id;

				if ( isset( $data->sizes ) ) {

					foreach ( $data->sizes as $key => $size ) {

						if ( $size->url == $this->settings->member_image_src ) {
							$classes[] = 'size-' . $key;
							break;
						}
					}
				}
			}
		}

		return implode( ' ', $classes );
	}

	/**
	 * @method get_src
	 */
	public function get_src()
	{
		$src = $this->_get_uncropped_url();

		// Return a cropped photo.
		if(!empty($this->settings->member_image_crop)) {

			$cropped_path = $this->_get_cropped_path();

			// See if the cropped photo already exists.
			if(file_exists($cropped_path['path'])) {
				$src = $cropped_path['url'];
			}
			// It doesn't, check if this is a demo image.
			elseif(stristr($src, FL_BUILDER_DEMO_URL) && !stristr(FL_BUILDER_DEMO_URL, $_SERVER['HTTP_HOST'])) {
				$src = $this->_get_cropped_demo_url();
			}
			// It doesn't, check if this is a OLD demo image.
			elseif(stristr($src, FL_BUILDER_OLD_DEMO_URL)) {
				$src = $this->_get_cropped_demo_url();
			}
			// A cropped photo doesn't exist, try to create one.
			else {

				$url = $this->crop();

				if($url) {
					$src = $url;
				}
			}
		}

		return $src;
	}

	/**
	 * @method get_link
	 */
	public function get_link()
	{
		$photo = $this->get_data();

		$link = $this->settings->link;

		return $link;
	}

	/**
	 * @method get_alt
	 */
	public function get_alt()
	{
		$photo = $this->get_data();

		if(!empty($photo->alt)) {
			return htmlspecialchars($photo->alt);
		}
		else if(!empty($photo->description)) {
			return htmlspecialchars($photo->description);
		}
		else if(!empty($photo->caption)) {
			return htmlspecialchars($photo->caption);
		}
		else if(!empty($photo->title)) {
			return htmlspecialchars($photo->title);
		}
	}

	/**
	 * @method get_attributes
	 */
	public function get_attributes()
	{
		$photo = $this->get_data();
		$attrs = '';

		if ( isset( $this->settings->attributes ) ) {
			foreach ( $this->settings->attributes as $key => $val ) {
				$attrs .= $key . '="' . $val . '" ';
			}
		}

		if ( is_object( $photo ) && isset( $photo->sizes ) ) {
			foreach ( $photo->sizes as $size ) {
				if ( $size->url == $this->settings->member_image_src && isset( $size->width ) && isset( $size->height ) ) {
					$attrs .= 'height="' . $size->height . '" width="' . $size->width . '" ';
				}
			}
		}

		if ( ! empty( $photo->title ) ) {
			$attrs .= 'title="' . htmlspecialchars( $photo->title ) . '" ';
		}

		return $attrs;
	}

	/**
	 * @method _has_source
	 * @protected
	 */
	protected function _has_source()
	{
		if(!empty($this->settings->link)) {
			return true;
		}

		return false;
	}

	/**
	 * @method _get_editor
	 * @protected
	 */
	protected function _get_editor()
	{
		if($this->_editor === null) {

			$url_path  = $this->_get_uncropped_url();
			$file_path = str_ireplace(home_url(), ABSPATH, $url_path);

			if(file_exists($file_path)) {
				$this->_editor = wp_get_image_editor($file_path);
			}
			else {
				$this->_editor = wp_get_image_editor($url_path);
			}
		}

		return $this->_editor;
	}

	/**
	 * @method _get_cropped_path
	 * @protected
	 */
	protected function _get_cropped_path()
	{
		$crop        = empty($this->settings->member_image_crop) ? 'none' : $this->settings->member_image_crop;
		$url         = $this->_get_uncropped_url();
		$cache_dir   = FLBuilderModel::get_cache_dir();

		if(empty($url)) {
			$filename    = uniqid(); // Return a file that doesn't exist.
		}
		else {

			if ( stristr( $url, '?' ) ) {
				$parts = explode( '?', $url );
				$url   = $parts[0];
			}

			$pathinfo    = pathinfo($url);
			$dir         = $pathinfo['dirname'];
			$ext         = $pathinfo['extension'];
			$name        = wp_basename($url, ".$ext");
			$new_ext     = strtolower($ext);
			$filename    = "{$name}-{$crop}.{$new_ext}";
		}

		return array(
			'filename' => $filename,
			'path'     => $cache_dir['path'] . $filename,
			'url'      => $cache_dir['url'] . $filename
		);
	}

	/**
	 * @method _get_uncropped_url
	 * @protected
	 */
	protected function _get_uncropped_url()
	{
		if(!empty($this->settings->member_image_src)) {
			$url = $this->settings->member_image_src;
		}
		else {
			$url = FL_BUILDER_URL . 'img/pixel.png';
		}

		return $url;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPTeamModule', array(
    'general'       => array( // Tab
        'title'         => __('Content', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'image_setting' => array(
                'title' => __('Image', 'bb-powerpack'),
                'fields'    => array(
                    'member_image'    => array(
                        'type'          => 'photo',
                        'show_remove'   => true,
                        'label'         => __('Image Source', 'bb-powerpack'),
						'connections'	=> array('photo')
                    ),
                    'member_image_crop'          => array(
						'type'          => 'select',
						'label'         => __('Crop', 'bb-powerpack'),
						'default'       => '',
						'options'       => array(
							''              => _x( 'None', 'Photo Crop.', 'bb-powerpack' ),
							'portrait'      => __('Portrait', 'bb-powerpack'),
							'square'        => __('Square', 'bb-powerpack'),
							'circle'        => __('Circle', 'bb-powerpack')
						)
					),
                )
            ),
            'member_setting'       => array( // Section
                'title'         => __('Details', 'bb-powerpack'), // Section Title
				'collapsed'			=> true,
                'fields'        => array( // Section Fields
                    'member_name'     => array(
                        'type'          => 'text',
                        'label'         => __('Name', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html' ),
                        'preview'         => array(
                            'type'             => 'text',
                            'selector'         => '.pp-member-wrapper .pp-member-name',
                        )
                    ),
                    'member_designation'     => array(
                        'type'          => 'text',
                        'label'         => __('Designation', 'bb-powerpack'),
                        'connections'   => array( 'string', 'html' ),
                        'preview'         => array(
                            'type'             => 'text',
                            'selector'         => '.pp-member-wrapper .pp-member-designation',
                        )
                    ),
                    'member_description' => array(
                        'type'          => 'editor',
                        'label'         => '',
                        'media_buttons' => false,
                        'default'       => '',
                        'rows'          => 8,
                        'connections'   => array( 'string', 'html', 'url' ),
                        'preview'         => array(
                            'type'             => 'text',
                            'selector'         => '.pp-member-wrapper .pp-member-description'
                        )
                    ),
                    'link'  => array(
						'type'          => 'link',
						'label'         => __('Link', 'bb-powerpack'),
						'placeholder'   => 'http://www.example.com',
						'show_target'	=> true,
						'connections'   => array( 'url' ),
						'preview'       => array(
							'type'          => 'none'
						)
					),
                )
            ),
            'separator_setting' => array(
                'title' =>  __('Separator', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'separator_display'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Enable Separator', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'        => __('Yes', 'bb-powerpack'),
							'no'         => __('No', 'bb-powerpack'),
						),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    =>  array('separator_position'),
                                'sections'  => array('separator_style')
                            )
                        )
					),
                    'separator_position'    => array(
                        'type'          => 'select',
						'label'         => __('Separator Position', 'bb-powerpack'),
						'default'       => 'below_title',
						'options'       => array(
							'below_title'        => __('Below Title', 'bb-powerpack'),
							'below_designation'         => __('Below Designation', 'bb-powerpack'),
						),
                    )
                )
            )
        )
    ),
    'social_icons_settings' => array(
        'title' =>  __('Social Icons', 'bb-powerpack'),
        'sections'  => array(
			'social_link_target'	=> array(
				'title'	=> __( 'Link Target', 'bb-powerpack' ),
				'fields'	=> array(
					'social_link_target'	=> array(
						'type'          => 'select',
						'label'         => __('Link Target', 'bb-powerpack'),
						'default'       => '_blank',
						'options'       => array(
							'_self' 		=> __('Same Window', 'bb-powerpack'),
							'_blank'    	=> __('New Window', 'bb-powerpack')
						)
					)
				)
			),
            'social_icons'  => array(
                'title' => __( 'Links', 'bb-powerpack' ),
				'collapsed'			=> true,
                'fields'    => array(
                    'email'	=> array(
                        'type'          => 'text',
						'label'         => __('Email', 'bb-powerpack'),
						'connections'   => array( 'url' ),
                    ),
                    'facebook_url'	=> array(
						'type'          => 'text',
						'label'         => __('Facebook URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'twiiter_url'	=> array(
						'type'          => 'text',
						'label'         => __('Twitter URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'googleplus_url'	=> array(
						'type'          => 'text',
						'label'         => __('Google Plus URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'pinterest_url'	=> array(
						'type'          => 'text',
						'label'         => __('Pinterest URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'linkedin_url'	=> array(
						'type'          => 'text',
						'label'         => __('Linkedin URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'youtube_url'	=> array(
						'type'          => 'text',
						'label'         => __('Youtube URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'instagram_url'	=> array(
						'type'          => 'text',
						'label'         => __('Instagram URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'vimeo_url'	=> array(
						'type'          => 'text',
						'label'         => __('Vimeo URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'github_url'	=> array(
						'type'          => 'text',
						'label'         => __('Github URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'dribbble_url'	=> array(
						'type'          => 'text',
						'label'         => __('Dribbble URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'tumblr_url'	=> array(
						'type'          => 'text',
						'label'         => __('Tumblr URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'flickr_url'	=> array(
						'type'      	=> 'text',
						'label'         => __('Flickr URL', 'bb-powerpack'),
						'connections'   => array( 'url' ),
					),
                    'wordpress_url'	=> array(
                        'type'              => 'text',
						'label'             => __('WordPress URL', 'bb-powerpack'),
						'connections'   	=> array( 'url' ),
                    )
                )
            )
        )
    ),
    'team_style'    => array(
        'title' => __('Style', 'bb-powerpack'),
        'sections'  => array(
            'general_style' => array(
                'title' => __('Box', 'bb-powerpack'),
                'fields'    => array(
					'box_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
					),
					'box_bg_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Hover Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
					),
                    'box_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-member-wrapper',
                            'property'  	=> 'border',
                        ),
					),
					'box_padding_group'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-member-wrapper',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                )
            ),
            'image_style' => array(
                'title' => __('Image', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'image_greyscale'       => array(
						'type'          => 'pp-switch',
						'label'         => __('Greyscale', 'bb-powerpack'),
						'default'       => 'original',
						'options'       => array(
							'original'             => __('Original', 'bb-powerpack'),
							'greyscale'             => __('Greyscale', 'bb-powerpack')
						),
					),
					'image_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-member-wrapper .pp-member-image img',
                            'property'  	=> 'border',
                        ),
					),
                )
            ),
            'separator_style' => array(
                'title' => __('Separator', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
                    'separator_color' => array(
                        'type'              => 'color',
                        'label'             => __('Color', 'bb-powerpack'),
						'default'           => '000000',
						'connections'		=> array('color'),
                        'preview'              => array(
                            'type'				=> 'css',
                            'selector'	=> '.pp-member-wrapper .pp-member-separator',
                            'property'	=> 'background-color',
                        )
                    ),
                    'separator_width'   => array(
                        'type'      => 'text',
                        'label'     => __('Width', 'bb-powerpack'),
                        'size'      => 5,
                        'maxlength' => 3,
                        'default'   => 60,
                        'description'   => 'px',
                        'preview'              => array(
                            'type'				=> 'css',
                            'selector'	=> '.pp-member-wrapper .pp-member-separator',
                            'property'	=> 'width',
                            'unit'		=> 'px'
                        )
                    ),
                    'separator_height'   => array(
                        'type'      => 'text',
                        'label'     => __('Height', 'bb-powerpack'),
                        'size'      => 5,
                        'maxlength' => 3,
                        'default'   => 2,
                        'description'   => 'px',
                        'preview'              => array(
                            'type'				=> 'css',
                            'selector'	=> '.pp-member-wrapper .pp-member-separator',
                            'property'	=> 'height',
                            'unit'		=> 'px'
                        )
                    ),
                ),
            ),
			'content_style'	=> array(
				'title'	=> __( 'Content', 'bb-powerpack' ),
				'collapsed'			=> true,
				'fields'	=> array(
                    'box_content_alignment'    => array(
                        'type'      => 'align',
                        'label'     => __('Content Alignment', 'bb-powerpack'),
                        'default'   => 'center',
                    ),
					'content_position'   => array(
                        'type'                 => 'select',
                        'label'                => __('Content Position', 'bb-powerpack'),
                        'default'              => 'below',
                        'options'              => array(
                            'below'          			=> __('Below Image', 'bb-powerpack'),
                            'hover'             		=> __('On Hover', 'bb-powerpack'),
                            'over'             			=> __('Over The Image', 'bb-powerpack'),
                        ),
                    ),
					'content_bg_color' => array(
                        'type'              => 'color',
                        'label'             => __('Background Color', 'bb-powerpack'),
                        'default'           => '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-member-wrapper .pp-member-content',
							'property'			=> 'background-color'
						)
                    ),
					'content_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Content Padding', 'bb-powerpack'),
						'default'			=> '0',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-member-wrapper .pp-member-content',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
				)
			),
            'social_icons_style'    => array(
                'title' => __('Social Icons', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'    => array(
					'social_links_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
					),
					'social_links_bg_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Hover Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
					),
					'social_links_text_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Icon Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'default'		=> '666666',
						'connections'	=> array('color'),
					),
					'social_links_text_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Icon Hover Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'default'		=> '333333',
						'connections'	=> array('color'),
					),
                    'social_links_font_size'   => array(
                        'type'          => 'unit',
						'label'         => __('Icon Size', 'bb-powerpack'),
                        'default'       => '10',
						'units'   		=> array('px'),
						'slider'		=> true,
                        'preview'       => array(
                            'type'			=> 'css',
                            'selector'		=> '.pp-member-social-icons li a',
                            'property'		=> 'font-size',
                            'unit'			=> 'px'
                        )
                    ),
                    'social_links_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-member-social-icons li a',
                            'property'  	=> 'border',
                        ),
					),
					'social_links_border_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Border Hover Color', 'bb-powerpack' ),
						'default'		=> '333333',
						'connections'	=> array('color'),
					),
                    'social_links_space'   => array(
                        'type'          => 'unit',
						'label'         => __('Space Between Icons', 'bb-powerpack'),
                        'default'       => '10',
						'units'   		=> array('px'),
						'slider'		=> true,
						'responsive'	=> true,
                        'preview'       => array(
                            'type'		=> 'css',
                            'selector'	=> '.pp-member-social-icons li',
                            'property'	=> 'margin-right',
                            'unit'		=> 'px'
                        ),
                    ),
					'social_links_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> '5',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-member-social-icons li a',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
                )
            )
        )
    ),
    'typography'	=> array( // Tab
		'title'			=> __('Typography', 'bb-powerpack'),
		'sections'		=> array(
			'title_typography'		=> array(
				'title'		=> __('Name', 'bb-powerpack'),
				'fields' 	=> array(
					'title_tag'		=> array(
						'type'		=> 'select',
						'label'		=> __('HTML Tag', 'bb-powerpack'),
						'options'	=> array(
							'h1'	=> 'H1',
							'h2'	=> 'H2',
							'h3'	=> 'H3',
							'h4'	=> 'H4',
							'h5'	=> 'H5',
							'h6'	=> 'H6',
						),
						'default'	=> 'h4',
						'help' 		=> __('Set the HTML tag for title output', 'bb-powerpack'),
					),
					'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-member-wrapper .pp-member-name',
						),
					),
					'title_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'       => '000000',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
                            'selector'        => '.pp-member-wrapper .pp-member-name',
                            'property'        => 'color',
						),
					),
					'title_margin' 	=> array(
                    	'type' 				=> 'pp-multitext',
                    	'label' 			=> __('Margin', 'bb-powerpack'),
                        'description'   	=> __( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-powerpack' ),
                        'default'       	=> array(
                            'top' 				=> 30,
                            'bottom' 			=> 5,
                        ),
                    	'options' 		=> array(
                    		'top' 			=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   =>  __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-up',
								'preview'       => array(
									'selector'		=> '.pp-member-wrapper .pp-member-name',
									'property'      => 'margin-top',
									'unit'          => 'px'
		                        ),
                    		),
                            'bottom' 		=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   =>  __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-down',
								'preview'       => array(
									'selector'      => '.pp-member-wrapper .pp-member-name',
									'property'      => 'margin-bottom',
									'unit'          => 'px'
		                        ),
                    		),
                    	)
                    ),
				)
			),
			'designation_typography' => array(
				'title'		=> __('Designation', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields' 	=> array(
					'designation_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-member-wrapper .pp-member-designation',
						),
					),
					'designation_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'       => '666666',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'        => '.pp-member-wrapper .pp-member-designation',
							'property'        => 'color',
						),
					),
					'designation_margin' 	=> array(
                    	'type' 				=> 'pp-multitext',
                    	'label' 			=> __('Margin', 'bb-powerpack'),
                        'description'   	=> __( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-powerpack' ),
                        'default'       	=> array(
                            'top' 				=> 0,
                            'bottom' 			=> 15,
                        ),
                    	'options' 		=> array(
                    		'top' 			=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   =>  __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-up',
								'preview'       => array(
									'selector'		=> '.pp-member-wrapper .pp-member-designation',
									'property'      => 'margin-top',
									'unit'          => 'px'
		                        ),
                    		),
                            'bottom' 		=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   =>  __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-down',
								'preview'       => array(
									'selector'      => '.pp-member-wrapper .pp-member-designation',
									'property'      => 'margin-bottom',
									'unit'          => 'px'
		                        ),
                    		),
                    	)
                    ),
				)
			),
            'description_typography' => array(
				'title'		=> __('Description', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields' 	=> array(
					'description_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-member-wrapper .pp-member-description',
						),
					),
					'description_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'       => '444444',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'selector'        => '.pp-member-wrapper .pp-member-description',
							'property'        => 'color',
						),
					),
					'description_margin' 	=> array(
                    	'type' 				=> 'pp-multitext',
                    	'label' 			=> __('Margin', 'bb-powerpack'),
                        'description'   	=> __( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-powerpack' ),
                        'default'       	=> array(
                            'top' 				=> 5,
                            'bottom' 			=> 20,
                        ),
                    	'options' 		=> array(
                    		'top' 			=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   =>  __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-up',
								'preview'       => array(
									'selector'		=> '.pp-member-wrapper .pp-member-description',
									'property'      => 'margin-top',
									'unit'          => 'px'
		                        ),
                    		),
                            'bottom' 		=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   =>  __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-down',
								'preview'       => array(
									'selector'      => '.pp-member-wrapper .pp-member-description',
									'property'      => 'margin-bottom',
									'unit'          => 'px'
		                        ),
                    		),
                    	)
                    ),
				)
			),
        ),
    ),
));
