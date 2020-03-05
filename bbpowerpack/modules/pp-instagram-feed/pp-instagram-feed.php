<?php

/**
 * @class PPInstagramFeedModule
 */
class PPInstagramFeedModule extends FLBuilderModule {
	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __( 'Instagram Feed', 'bb-powerpack' ),
			'description'   	=> __( 'A module to fetch instagram photos.', 'bb-powerpack' ),
			'group'         	=> pp_get_modules_group(),
			'category'			=> pp_get_modules_cat( 'creative' ),
			'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-instagram-feed/',
			'url'           	=> BB_POWERPACK_URL . 'modules/pp-instagram-feed/',
			'editor_export' 	=> true, // Defaults to true and can be omitted.
			'enabled'       	=> true, // Defaults to true and can be omitted.
		));

		$this->add_css( 'font-awesome' );

		$this->add_js( 'jquery-magnificpopup' );
		$this->add_css( 'jquery-magnificpopup' );

		$this->add_js( 'imagesloaded' );

		$this->add_css( 'jquery-swiper' );
		$this->add_js( 'jquery-swiper' );

		$this->add_js('jquery-masonry');
	}

	public function enqueue_scripts() {
		if ( ! isset( $this->settings->use_api ) || 'yes' == $this->settings->use_api ) {
			$this->add_js( 'instafeed' );
		}
	}

	public function filter_settings( $settings, $helper )
	{
		// Handle title's old typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'feed_title_font'	=> array(
				'type'			=> 'font'
			),
			'feed_title_custom_font_size'	=> array(
				'type'			=> 'font_size',
				'condition'		=> ( isset( $settings->feed_title_font_size ) && 'custom' == $settings->feed_title_font_size )
			),
			'feed_title_line_height'	=> array(
				'type'			=> 'line_height',
			),
			'feed_title_transform'	=> array(
				'type'			=> 'text_transform',
			),
			'feed_title_letter_spacing'	=> array(
				'type'			=> 'letter_spacing',
			),
		), 'title_typography' );

		// Handle old title border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'feed_title_border'	=> array(
				'type'				=> 'style'
			),
			'feed_title_border_width'	=> array(
				'type'				=> 'width'
			),
			'feed_title_border_color'	=> array(
				'type'				=> 'color'
			),
			'feed_title_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'feed_title_border_group' );

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPInstagramFeedModule', array(
	'general'       => array( // Tab
		'title'         => __( 'General', 'bb-powerpack' ), // Tab title
		'description' => __( '<span style="color: red;">Starting October 15, 2019, new client registration and permission review on Instagram API platform are discontinued.</span>', 'bb-powerpack' ),
		'sections'      => array( // Tab Sections
			'use_api' => array(
				'title'		=> '',
				'fields'	=> array(
					'use_api'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Use Instagram API', 'bb-powerpack' ),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array( 'account_settings' ),
								'fields'		=> array( 'image_resolution', 'sort_by' ),
							),
							'no'			=> array(
								'fields'		=> array( 'username' ),
							),
						),
						'preview'	=> array(
							'type'		=> 'none',
						),
					),
					'username'	=> array(
						'type'		=> 'text',
						'label'		=> __( 'Instagram Username', 'bb-powerpack' ),
						'default'	=> '',
						'help'		=> __( 'This must be public account.', 'bb-powerpack' ),
						'connections'	=> array( 'string' ),
					),
				),
			),
			'account_settings'	=> array( // Section
				'title'				=> __( 'API Authentication', 'bb-powerpack' ), // Section Title
				'fields'        	=> array( // Section Fields
					'user_id'     	=> array(
						'type'          => 'text',
						'label'         => __( 'User ID', 'bb-powerpack' ),
						'default'       => '',
						'connections'	=> array('string')
					),
					'client_id'	=> array(
						'type'		=> 'text',
						'label'     => __( 'Client ID', 'bb-powerpack' ),
						'default'   => '',
						'connections'	=> array('string')
					),
					'access_token'	=> array(
						'type'          => 'text',
						'label'         => __( 'Access Token', 'bb-powerpack' ),
						'default'       => '',
						'connections'	=> array('string')
					),
				),
			),
			'feed_settings'	=> array(
				'title'			=> __( 'Feed Settings', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'feed_by_tags'  => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Filter the feed by Hashtag', 'bb-powerpack' ),
						'description'	=> __('<storng style="display: block; color: red;">This option is deprecated by Instagram.</strong>', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'        	=> __( 'No', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'yes'	=> array(
								'fields'	=> array( 'tag_name' ),
							),
						),
					),
					'tag_name'     	=> array(
						'type'          => 'text',
						'label'         => __( 'Tag Name', 'bb-powerpack' ),
						'default'       => '',
						'connections'	=> array('string')
					),
					'images_count'		=> array(
						'type'          => 'unit',
						'label'         => __( 'Max Images Count', 'bb-powerpack' ),
						'default'       => '12',
						'slider'        => true,
					),
					'image_resolution'  => array(
						'type'          => 'select',
						'label'         => __( 'Image Resolution', 'bb-powerpack' ),
						'default'       => 'standard_resolution',
						'options'       => array(
							'thumbnail'             => __( 'Thumbnail', 'bb-powerpack' ),
							'low_resolution'        => __( 'Low Resolution', 'bb-powerpack' ),
							'standard_resolution'   => __( 'Standard Resolution', 'bb-powerpack' ),
						),
					),
					'sort_by'	=> array(
						'type'			=> 'select',
						'label'         => __( 'Sort By', 'bb-powerpack' ),
						'default'       => 'none',
						'options'       => array(
							'none'              => __( 'None', 'bb-powerpack' ),
							'most-recent'       => __( 'Most Recent', 'bb-powerpack' ),
							'least-recent'      => __( 'Least Recent', 'bb-powerpack' ),
							'most-liked'        => __( 'Most Liked', 'bb-powerpack' ),
							'least-liked'       => __( 'Least Liked', 'bb-powerpack' ),
							'most-commented'    => __( 'Most Commented', 'bb-powerpack' ),
							'least-commented'   => __( 'Least Commented', 'bb-powerpack' ),
							'random'            => __( 'Random', 'bb-powerpack' ),
						),
					),
				),
			),
			'general'	=> array(
				'title'		=> __( 'General', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'    => array(
					'feed_layout'  => array(
						'type'          => 'select',
						'label'         => __( 'Layout', 'bb-powerpack' ),
						'default'       => 'grid',
						'options'       => array(
							'grid'           => __( 'Masonry Grid', 'bb-powerpack' ),
							'square-grid'    => __( 'Square Grid', 'bb-powerpack' ),
							'carousel'       => __( 'Carousel', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'grid'  => array(
								'fields'    => array( 'grid_columns', 'spacing' ),
							),
							'square-grid'  => array(
								'fields'    => array( 'grid_columns', 'spacing', 'image_custom_size' ),
							),
							'carousel'  => array(
								'tabs'		=> array( 'carousel' ),
								'fields'	=> array( 'image_custom_size' ),
							),
						),
					),
					'image_custom_size'		=> array(
						'type'			=> 'unit',
						'label' 		=> __( 'Custom Size', 'bb-powerpack' ),
						'default'       => '',
						'units'			=> array('px'),
						'slider'		=> array(
							'min'			=> '150',
							'max'			=> '1000',
							'step'			=> '1',
						),
						'responsive' 	=> array(
							'placeholder'	=> array(
								'default'		=> '',
								'medium'		=> '',
								'responsive' 	=> '',
							),
						),
					),
					'grid_columns'	=> array(
						'type'			=> 'unit',
						'label' 		=> __( 'Grid Columns', 'bb-powerpack' ),
						'slider'        => true,
						'default'       => '3',
						'responsive' 	=> array(
							'placeholder'	=> array(
								'default'		=> '3',
								'medium'		=> '2',
								'responsive' 	=> '1',
							),
						),
					),
					'spacing' => array(
						'type' 			=> 'unit',
						'label' 		=> __('Spacing', 'bb-powerpack'),
						'default'		=> '',
						'units'			=> array( 'px' ),
						'slider'        => true,
						'responsive' => array(
							'placeholder' => array(
								'default' => '',
								'medium' => '',
								'responsive' => '',
							),
						),
					),
					'likes'	=> array(
						'type'		=> 'pp-switch',
						'label'     => __( 'Show Likes Count', 'bb-powerpack' ),
						'default'   => 'no',
						'options'   => array(
							'yes'		=> __( 'Yes', 'bb-powerpack' ),
							'no'		=> __( 'No', 'bb-powerpack' ),
						),
					),
					'comments'	=> array(
						'type'		=> 'pp-switch',
						'label'     => __( 'Show Comments Count', 'bb-powerpack' ),
						'default'  	=> 'no',
						'options'   => array(
							'yes'		=> __( 'Yes', 'bb-powerpack' ),
							'no'		=> __( 'No', 'bb-powerpack' ),
						),
					),
					'content_visibility'  => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Content Visibility', 'bb-powerpack' ),
						'default'       => 'always',
						'options'       => array(
							'always'		=> __( 'Always', 'bb-powerpack' ),
							'hover'         => __( 'Hover', 'bb-powerpack' ),
						),
					),
					'image_popup'  => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Image Link Type', 'bb-powerpack' ),
						'default'       => 'no',
						'options'       => array(
							'no'            => __( 'None', 'bb-powerpack' ),
							'yes'           => __( 'Popup', 'bb-powerpack' ),
							'link'			=> __( 'Link', 'bb-powerpack' )
						),
					),
					'profile_link'  => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Show Link to Instagram Profile?', 'bb-powerpack' ),
						'default'       => 'no',
						'options'       => array(
							'yes'           => __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'yes'		=> array(
								'tabs'		=> array( 'typography' ),
								'sections'	=> array( 'feed_title' ),
								'fields'	=> array( 'insta_link_title', 'insta_profile_url', 'insta_title_icon', 'insta_title_icon_position' ),
							),
						),
					),
					'insta_link_title'	=> array(
						'type'				=> 'text',
						'label'         	=> __( 'Link Text', 'bb-powerpack' ),
						'default'       	=> __( 'Follow @example on instagram', 'bb-powerpack' ),
						'connections'		=> array('string')
					),
					'insta_profile_url'	=> array(
						'type'          	=> 'link',
						'label'         	=> __( 'Instagram Profile URL', 'bb-powerpack' ),
						'connections'		=> array( 'url' ),
						'preview'       	=> array(
							'type'      	=> 'none',
						),
					),
					'insta_title_icon'  => array(
						'type'          	=> 'icon',
						'label'         	=> __( 'Icon', 'bb-powerpack' ),
						'preview'			=> 'none',
						'show_remove' 		=> true,
					),
					'insta_title_icon_position'  => array(
						'type'			=> 'pp-switch',
						'label'         => __( 'Icon Position', 'bb-powerpack' ),
						'default'       => 'before_title',
						'options'       => array(
							'before_title'		=> __( 'Before Title', 'bb-powerpack' ),
							'after_title'       => __( 'After Title', 'bb-powerpack' ),
						),
					),
				),
			),
		),
	),
	'carousel'  => array(
		'title'     => __( 'Carousel', 'bb-powerpack' ),
		'sections'  => array(
			'carousel_settings'     => array(
				'title'     => __( 'Image', 'bb-powerpack' ),
				'fields'    => array(
					'visible_items'		=> array(
						'type' 				=> 'unit',
						'label' 			=> __( 'Visible Items', 'bb-powerpack' ),
						'size'          	=> '5',
						'default'       	=> '3',
						'responsive' 		=> array(
							'placeholder' 	=> array(
								'default' 		=> '3',
								'medium' 		=> '2',
								'responsive' 	=> '1',
							),
						),
					),
					'images_gap'     => array(
						'type' 			=> 'unit',
						'label' 		=> __( 'Items Spacing', 'bb-powerpack' ),
						'size'          => '5',
						'default'       => '10',
						'description'	=> 'px',
						'responsive' 	=> array(
							'placeholder'		=> array(
								'default'		=> '10',
								'medium'		=> '10',
								'responsive'	=> '10',
							),
						),
					),
					'autoplay'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __( 'Auto Play', 'bb-powerpack' ),
						'default'   => 'yes',
						'options'   => array(
							'yes'		=> __( 'Yes', 'bb-powerpack' ),
							'no'        => __( 'No', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'yes'	=> array(
								'fields'	=> array( 'autoplay_speed' ),
							),
						),
					),
					'autoplay_speed'	=> array(
						'type'          => 'text',
						'label'         => __( 'Auto Play Speed', 'bb-powerpack' ),
						'default'       => '5000',
						'size'          => '5',
						'description'   => _x( 'ms', 'Value unit for form field of time in mili seconds. Such as: "5000 ms"', 'bb-powerpack' ),
					),
					'infinite_loop'		=> array(
						'type'          => 'pp-switch',
						'label'         => __( 'Infinite Loop', 'bb-powerpack' ),
						'default'       => 'no',
						'options'       => array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
					),
					'grab_cursor'  => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Grab Cursor', 'bb-powerpack' ),
						'default'       => 'no',
						'options'        => array(
							'yes'           => __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
					),
				),
			),
			'controls'		=> array(
				'title'         => __( 'Controls', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'        => array(
					'navigation'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Arrows', 'bb-powerpack' ),
						'default'       => 'yes',
						'options'       => array(
							'yes'        	=> __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array( 'arrow_style' ),
							),
						),
					),
					'pagination'	=> array(
						'type'          => 'pp-switch',
						'label'         => __( 'Dots', 'bb-powerpack' ),
						'default'       => 'yes',
						'options'       => array(
							'yes'       	=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'yes'	=> array(
								'sections'	=> array( 'dot_style' ),
							),
						),
					),
				),
			),
			'arrow_style'   => array( // Section
				'title' => __( 'Arrow Settings', 'bb-powerpack' ), // Section Title
				'collapsed'		=> true,
				'fields' => array( // Section Fields
					'arrow_font_size'   => array(
						'type'          => 'text',
						'label'         => __( 'Arrow Size', 'bb-powerpack' ),
						'description'   => 'px',
						'size'      	=> 5,
						'maxlength' 	=> 3,
						'default'       => '24',
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-instagram-feed .pp-swiper-button',
							'property'        => 'font-size',
							'unit'            => 'px',
						),
					),
					'arrow_bg_color'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Background Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> 'eaeaea',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-instagram-feed .pp-swiper-button',
							'property'        => 'background-color',
						),
					),
					'arrow_bg_hover'	=> array(
						'type'      	=> 'color',
						'label'     	=> __( 'Background Hover Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> '4c4c4c',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-instagram-feed .pp-swiper-button:hover',
							'property'        => 'background-color',
						),
					),
					'arrow_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Arrow Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> '000000',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-swiper-button',
							'property'      => 'color',
						),
					),
					'arrow_color_hover'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Arrow Hover Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> 'eeeeee',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-swiper-button:hover',
							'property'      => 'color',
						),
					),
					'arrow_border_style'	=> array(
						'type'      	=> 'pp-switch',
						'label'     	=> __( 'Border Style', 'bb-powerpack' ),
						'default'     	=> 'none',
						'options'       => array(
							'none'          => __( 'None', 'bb-powerpack' ),
							'solid'         => __( 'Solid', 'bb-powerpack' ),
							'dashed'        => __( 'Dashed', 'bb-powerpack' ),
							'dotted'        => __( 'Dotted', 'bb-powerpack' ),
						),
						'toggle'   => array(
							'solid'    => array(
								'fields'	=> array( 'arrow_border_width', 'arrow_border_color', 'arrow_border_hover' ),
							),
							'dashed'    => array(
								'fields'	=> array( 'arrow_border_width', 'arrow_border_color', 'arrow_border_hover' ),
							),
							'dotted'	=> array(
								'fields'	=> array( 'arrow_border_width', 'arrow_border_color', 'arrow_border_hover' ),
							),
							'double'    => array(
								'fields'   	=> array( 'arrow_border_width', 'arrow_border_color', 'arrow_border_hover' ),
							),
						),
						'preview'	=> array(
							'type'            => 'css',
							'selector'        => '.pp-instagram-feed .pp-swiper-button',
							'property'        => 'border-style',
							'unit'            => 'px',
						),
					),
					'arrow_border_width'	=> array(
						'type'          	=> 'text',
						'label'         	=> __( 'Border Width', 'bb-powerpack' ),
						'description'   	=> 'px',
						'size'      		=> 5,
						'maxlength' 		=> 3,
						'default'       	=> '1',
						'preview'         	=> array(
							'type'				=> 'css',
							'selector'        	=> '.pp-instagram-feed .pp-swiper-button',
							'property'        	=> 'border-width',
							'unit'            	=> 'px',
						),
					),
					'arrow_border_color'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Border Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> '',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-swiper-button',
							'property'      => 'border-color',
						),
					),
					'arrow_border_hover'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Border Hover Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> '',
						'connections'	=> array('color'),
						'preview'      	=> array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-swiper-button:hover',
							'property'      => 'border-color',
						),
					),
					'arrow_border_radius'   => array(
						'type'          => 'text',
						'label'         => __( 'Round Corners', 'bb-powerpack' ),
						'description'   => 'px',
						'size'      	=> 5,
						'maxlength' 	=> 3,
						'default'       => '100',
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-swiper-button',
							'property'      => 'border-radius',
							'unit'          => 'px',
						),
					),
					'arrow_horizontal_padding' 	=> array(
						'type'          => 'text',
						'label'         => __( 'Horizontal Padding', 'bb-powerpack' ),
						'default'   	=> '13',
						'maxlength'     => 5,
						'size'          => 6,
						'description'   => 'px',
						'preview'		=> array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-image-carousel .pp-swiper-button',
									'property'	=> 'padding-left',
									'unit'		=> 'px',
								),
								array(
									'selector'	=> '.pp-instagram-feed .pp-swiper-button',
									'property'	=> 'padding-right',
									'unit'		=> 'px',
								),
							),
						),
					),
					'arrow_vertical_padding'	=> array(
						'type'          => 'text',
						'label'         => __( 'Vertical Padding', 'bb-powerpack' ),
						'default'   	=> '5',
						'maxlength'     => 5,
						'size'          => 6,
						'description'   => 'px',
						'preview'		=> array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-instagram-feed .pp-swiper-button',
									'property'	=> 'padding-top',
									'unit'		=> 'px',
								),
								array(
									'selector'	=> '.pp-instagram-feed .pp-swiper-button',
									'property'	=> 'padding-bottom',
									'unit'		=> 'px',
								),
							),
						),
					),
				),
			),
			'dot_style'	=> array( // Section
				'title' 	=> __( 'Dot Settings', 'bb-powerpack' ), // Section Title
				'collapsed'		=> true,
				'fields' 	=> array( // Section Fields
					'dot_position'	=> array(
						'type'          => 'pp-switch',
						'label'         => __( 'Position', 'bb-powerpack' ),
						'default'       => 'outside',
						'options'       => array(
							'outside'        	=> __( 'Outside', 'bb-powerpack' ),
							'inside'            => __( 'Inside', 'bb-powerpack' ),
						),
					),
					'dot_bg_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'bb-powerpack' ),
						'default'       => '666666',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .swiper-pagination-bullet',
							'property'      => 'background-color',
						),
					),
					'dot_bg_hover'      => array(
						'type'          => 'color',
						'label'         => __( 'Active Color', 'bb-powerpack' ),
						'default'       => '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .swiper-pagination-bullet:hover, .pp-instagram-feed .swiper-pagination-bullet-active',
							'property'      => 'background-color',
						),
					),
					'dot_width'   => array(
						'type'          => 'text',
						'label'         => __( 'Size', 'bb-powerpack' ),
						'description'   => 'px',
						'size'      	=> 5,
						'maxlength' 	=> 3,
						'default'       => '10',
						'preview'       => array(
							'type'            => 'css',
							'rules'           => array(
								array(
									'selector'        => '.pp-instagram-feed .swiper-pagination-bullet',
									'property'        => 'width',
									'unit'            => 'px',
								),
								array(
									'selector'        => '.pp-instagram-feed .swiper-pagination-bullet',
									'property'        => 'height',
									'unit'            => 'px',
								),
							),
						),
					),
					'dot_border_radius'	=> array(
						'type'				=> 'text',
						'label'         	=> __( 'Round Corners', 'bb-powerpack' ),
						'description'   	=> 'px',
						'size'      		=> 5,
						'maxlength' 		=> 3,
						'default'       	=> '100',
						'preview'         	=> array(
							'type'				=> 'css',
							'selector'        	=> '.pp-instagram-feed .swiper-pagination-bullet',
							'property'        	=> 'border-radius',
							'unit'            	=> 'px',
						),
					),
				),
			),
		),
	),
	'style' => array(
		'title'     => __( 'Style', 'bb-powerpack' ),
		'description' => __( 'For smooth transition effect, please do not use grayscale feature with overlay.', 'bb-powerpack' ),
		'sections'  => array(
			'image'		=> array(
				'title'		=> __( 'Image', 'bb-powerpack' ),
				'fields'    => array(
					'image_grayscale'	=> array(
						'type'          => 'pp-switch',
						'label'         => __( 'Grayscale Image', 'bb-powerpack' ),
						'default'       => 'no',
						'options'       => array(
							'yes'        	=> __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
						'help'	=> __( 'For smooth transition effect, please do not use this feature with overlay.', 'bb-powerpack' ),
					),
					'image_overlay_type'	=> array(
						'type'          	=> 'pp-switch',
						'label'         	=> __( 'Image Overlay Type', 'bb-powerpack' ),
						'default'       	=> 'none',
						'options'       	=> array(
							'none'        		=> __( 'None', 'bb-powerpack' ),
							'solid'        		=> __( 'Solid', 'bb-powerpack' ),
							'gradient'      	=> __( 'Gradient', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'solid'		=> array(
								'fields'	=> array( 'image_overlay_color', 'image_overlay_opacity' ),
							),
							'gradient'	=> array(
								'fields'	=> array( 'image_overlay_angle', 'image_overlay_color', 'image_overlay_secondary_color', 'image_overlay_gradient_type', 'image_overlay_opacity' ),
							),
						),
					),
					'image_overlay_color'	=> array(
						'type'          		=> 'color',
						'label'         		=> __( 'Overlay Color', 'bb-powerpack' ),
						'default'       		=> '',
						'show_reset'    		=> true,
						'connections'			=> array('color'),
					),
					'image_overlay_secondary_color'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Overlay Secondary Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
					),
					'image_overlay_gradient_type'	=> array(
						'type'			=> 'pp-switch',
						'label'         => __( 'Type', 'bb-powerpack' ),
						'default'       => 'linear',
						'options'       => array(
							'linear'		=> __( 'Linear', 'bb-powerpack' ),
							'radial'        => __( 'Radial', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'linear'	=> array(
								'fields'	=> array( 'image_overlay_angle' ),
							),
							'radial'	=> array(
								'fields'	=> array( 'image_overlay_gradient_position' ),
							),
						),
					),
					'image_overlay_angle'	=> array(
						'type'			=> 'text',
						'label'       	=> __( 'Angle', 'bb-powerpack' ),
						'default'     	=> '180',
						'maxlength'   	=> '3',
						'size'        	=> '5',
						'description'	=> __('degree', 'bb-powerpack')
					),
					'image_overlay_gradient_position'	=> array(
						'type'			=> 'select',
						'label'         => __( 'Position', 'bb-powerpack' ),
						'default'       => 'center center',
						'options'       => array(
							'center center'			=> __( 'Center Center', 'bb-powerpack' ),
							'center left'           => __( 'Center Left', 'bb-powerpack' ),
							'center right'          => __( 'Center Right', 'bb-powerpack' ),
							'top center'            => __( 'Top Center', 'bb-powerpack' ),
							'top left'            	=> __( 'Top Left', 'bb-powerpack' ),
							'top right'            	=> __( 'Top Right', 'bb-powerpack' ),
							'bottom center'         => __( 'Bottom Center', 'bb-powerpack' ),
							'bottom left'           => __( 'Bottom Left', 'bb-powerpack' ),
							'bottom right'          => __( 'Bottom Right', 'bb-powerpack' ),
						),
					),
					'image_overlay_opacity'	=> array(
						'type'			=> 'text',
						'label'       	=> __( 'Overlay Opacity', 'bb-powerpack' ),
						'default'     	=> '70',
						'description' 	=> '%',
						'maxlength'   	=> '3',
						'size'        	=> '5',
					),
					'likes_comments_color'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Likes & Comments Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-feed-item .pp-overlay-container',
							'property'      => 'color',
						),
					),
				),
			),
			'image_hover'	=> array(
				'title'     	=> __( 'Image Hover', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'    	=> array(
					'image_hover_grayscale'	=> array(
						'type'			=> 'pp-switch',
						'label'         => __( 'Grayscale Image', 'bb-powerpack' ),
						'default'       => 'no',
						'options'       => array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
						'help'	=> __( 'For smooth transition effect, please do not use this feature with overlay.', 'bb-powerpack' ),
					),
					'image_hover_overlay_type'	=> array(
						'type'          => 'pp-switch',
						'label'         => __( 'Image Overlay Type', 'bb-powerpack' ),
						'default'       => 'none',
						'options'       => array(
							'none'        	=> __( 'None', 'bb-powerpack' ),
							'solid'        	=> __( 'Solid', 'bb-powerpack' ),
							'gradient'      => __( 'Gradient', 'bb-powerpack' ),
						),
						'toggle'    => array(
							'solid' 	=> array(
								'fields'    => array( 'image_hover_overlay_color', 'image_hover_overlay_opacity' ),
							),
							'gradient' => array(
								'fields'    => array( 'image_hover_overlay_color', 'image_hover_overlay_secondary_color', 'image_hover_overlay_gradient_type', 'image_hover_overlay_opacity' ),
							),
						),
					),
					'image_hover_overlay_color'	=> array(
						'type'			=> 'color',
						'label'         => __( 'Overlay Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'connections'	=> array('color'),
					),
					'image_hover_overlay_secondary_color'	=> array(
						'type'       	=> 'color',
						'label'     	=> __( 'Overlay Secondary Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
					),
					'image_hover_overlay_gradient_type'	=> array(
						'type'			=> 'pp-switch',
						'label'         => __( 'Type', 'bb-powerpack' ),
						'default'       => 'linear',
						'options'       => array(
							'linear'        	=> __( 'Linear', 'bb-powerpack' ),
							'radial'            => __( 'Radial', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'linear'	=> array(
								'fields'	=> array( 'image_hover_overlay_angle' ),
							),
							'radial'	=> array(
								'fields'	=> array( 'image_hover_overlay_gradient_position' ),
							),
						),
					),
					'image_hover_overlay_angle'	=> array(
						'type'			=> 'text',
						'label'       	=> __( 'Angle', 'bb-powerpack' ),
						'default'     	=> '180',
						'maxlength'   	=> '3',
						'size'        	=> '5',
						'description'	=> __('degree', 'bb-powerpack')
					),
					'image_hover_overlay_gradient_position'	=> array(
						'type'			=> 'select',
						'label'         => __( 'Position', 'bb-powerpack' ),
						'default'       => 'center center',
						'options'       => array(
							'center center'			=> __( 'Center Center', 'bb-powerpack' ),
							'center left'           => __( 'Center Left', 'bb-powerpack' ),
							'center right'          => __( 'Center Right', 'bb-powerpack' ),
							'top center'            => __( 'Top Center', 'bb-powerpack' ),
							'top left'            	=> __( 'Top Left', 'bb-powerpack' ),
							'top right'            	=> __( 'Top Right', 'bb-powerpack' ),
							'bottom center'         => __( 'Bottom Center', 'bb-powerpack' ),
							'bottom left'           => __( 'Bottom Left', 'bb-powerpack' ),
							'bottom right'          => __( 'Bottom Right', 'bb-powerpack' ),
						),
					),
					'image_hover_overlay_opacity'	=> array(
						'type'			=> 'text',
						'label'       	=> __( 'Overlay Opacity', 'bb-powerpack' ),
						'default'     	=> '70',
						'description' 	=> '%',
						'maxlength'   	=> '3',
						'size'        	=> '5',
					),
					'likes_comments_hover_color'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Likes & Comments Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
					),
				),
			),
			'feed_title'	=> array(
				'title'			=> __( 'Feed Title', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'feed_title_position'	=> array(
						'type'          => 'select',
						'label'         => __( 'Position', 'bb-powerpack' ),
						'default'       => 'middle',
						'options'       => array(
							'top'			=> __( 'Top', 'bb-powerpack' ),
							'middle'        => __( 'Middle', 'bb-powerpack' ),
							'bottom'        => __( 'Bottom', 'bb-powerpack' ),
						),
					),
					'feed_title_bg_color'	=> array(
						'type'			=> 'color',
						'label'         => __( 'Background Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-instagram-feed-title-wrap',
							'property'      => 'background-color',
						),
					),
					'feed_title_bg_hover'	=> array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-instagram-feed .pp-instagram-feed-title-wrap:hover',
							'property'      => 'background-color',
						),
					),
					'feed_title_text_color'	=> array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-instagram-feed .pp-instagram-feed-title-wrap .pp-instagram-feed-title',
							'property'      => 'color',
						),
					),
					'feed_title_text_hover'	=> array(
						'type'			=> 'color',
						'label'         => __( 'Text Hover Color', 'bb-powerpack' ),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-instagram-feed-title-wrap:hover .pp-instagram-feed-title',
							'property'      => 'color',
						),
					),
					'feed_title_border_group'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-instagram-feed .pp-instagram-feed-title-wrap',
                            'property'  	=> 'border',
                        ),
					),
					'feed_title_border_hover'	=> array(
						'type'			=> 'color',
						'label'     	=> __( 'Border Hover Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> '',
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-instagram-feed .pp-instagram-feed-title-wrap:hover',
							'property'      => 'border-color',
						),
					),
					'feed_title_horizontal_padding'	=> array(
						'type'			=> 'unit',
						'label' 		=> __( 'Horizontal Padding', 'bb-powerpack' ),
						'units'			=> array( 'px' ),
						'slider'        => true,
						'responsive' 	=> array(
							'placeholder'	=> array(
								'default'		=> '',
								'medium'		=> '',
								'responsive'	=> '',
							),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-instagram-feed .pp-instagram-feed-title-wrap',
									'property'	=> 'padding-left',
									'unit' 		=> 'px',
								),
								array(
									'selector'	=> '.pp-instagram-feed .pp-instagram-feed-title-wrap',
									'property'	=> 'padding-right',
									'unit' 		=> 'px',
								),
							),
						),
					),
					'feed_title_vertical_padding'	=> array(
						'type' 			=> 'unit',
						'label' 		=> __( 'Vertical Padding', 'bb-powerpack' ),
						'units'			=> array( 'px' ),
						'slider'        => true,
						'responsive'	=> array(
							'placeholder'	=> array(
								'default'		=> '',
								'medium'		=> '',
								'responsive'	=> '',
							),
						),
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-instagram-feed .pp-instagram-feed-title-wrap',
									'property'	=> 'padding-top',
									'unit' 		=> 'px',
								),
								array(
									'selector'	=> '.pp-instagram-feed .pp-instagram-feed-title-wrap',
									'property'	=> 'padding-bottom',
									'unit' 		=> 'px',
								),
							),
						),
					),
				),
			),
		),
	),
	'typography'	=> array(
		'title'			=> __( 'Typography', 'bb-powerpack' ),
		'sections'  	=> array(
			'feed_title_typography'	=> array(
				'title'		=> __( 'Feed Title', 'bb-powerpack' ),
				'fields'	=> array(
					'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __('Typography', 'bb-powerpack'),
						'responsive'  	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-instagram-feed .pp-instagram-feed-title-wrap',
						),
					),
				),
			),
		),
	),
));
