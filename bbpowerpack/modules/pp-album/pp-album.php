<?php
/**
 * @class PPAlbumModule
 */
class PPAlbumModule extends FLBuilderModule {
	public $photos = array();
	public $current_photos = array();

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct( array(
			'name'          	=> __('Album', 'bb-powerpack'),
            'description'   	=> __('A module for photo Album.', 'bb-powerpack'),
            'group'         	=> pp_get_modules_group(),
            'category'			=> pp_get_modules_cat( 'content' ),
            'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-album/',
            'url'           	=> BB_POWERPACK_URL . 'modules/pp-album/',
            'editor_export' 	=> true, // Defaults to true and can be omitted.
            'enabled'       	=> true, // Defaults to true and can be omitted.
            'partial_refresh'	=> true
		) );
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		$this->add_css( 'pp-jquery-fancybox' );
		$this->add_js( 'pp-jquery-fancybox' );
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPAlbumModule', array(
    'general'       => array(
        'title'         => __('General', 'bb-powerpack'),
        'sections'      => array(
            'general'       => array(
                'title'         => '',
                'fields'        => array(
					'gallery_photos' => array(
					    'type'          => 'multiple-photos',
					    'label'         => __( 'Photos', 'bb-powerpack' ),
                        'connections'  	=> array('multiple-photos')
					),
                )
			),
            'trigger'       => array(
				'title'         => 'Trigger',
				'collapsed'		=> true,
                'fields'        => array(
					'trigger_on'	=> array(
					    'type'          => 'pp-switch',
						'label'         => __( 'Trigger with', 'bb-powerpack' ),
						'default'		=> 'album_cover',
						'options'		=> array(
							'album_cover'	=> __('Album Cover', 'bb-powerpack'),
							'button'		=> __('Button', 'bb-powerpack'),
						),
                        'toggle' 		=> array(
                            'album_cover'	=> array(
								'tabs'			=> array( 'trigger_album_cover', 'style' ),
                            ),
                            'button'		=> array(
								'tabs'			=> array( 'trigger_album_button', 'trigger_button_style' ),
                            ),
						)
					),
                )
			),
        )
	),
    'trigger_album_cover'	=> array(
        'title'         => __('Album Cover', 'bb-powerpack'),
        'sections'      => array(
			'cover_image'	=> array(
				'title'         => 'Album Cover',
                'fields'        => array(
					'cover_img'		=> array(
					    'type'          => 'select',
						'label'         => __( 'Cover Image', 'bb-powerpack' ),
						'default'		=> 'first_img',
						'options'		=> array(
							'first_img'		=> __('First Image of Album', 'bb-powerpack'),
							'custom'		=> __('Custom', 'bb-powerpack'),
						),
                        'toggle' 		=> array(
                            'first_img'    	=> array(
                                'fields'   		=> array( 'first_img_size' ),
                            ),
                            'custom'    	=> array(
                                'fields'   		=> array( 'custom_cover' ),
                            ),
						)
					),
					'first_img_size'	=> array(
					    'type'          => 'select',
						'label'         => __( 'Image Size', 'bb-powerpack' ),
						'default'		=> 'full',
						'options'		=> array(
							'thumbnail'		=> __('Thumbnail', 'bb-powerpack'),
							'medium'		=> __('Medium', 'bb-powerpack'),
							'large'			=> __('Large', 'bb-powerpack'),
							'full'			=> __('Full', 'bb-powerpack'),
						),
					),
					'custom_cover'	=> array(
					    'type'          => 'photo',
						'label'         => __( 'Add Cover Image', 'bb-powerpack' ),
						'connections'  	=> array('photo')
					),
					'cover_width'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Album Cover Width', 'bb-switch'),
						'units'			=> array('px'),
						'slider'		=> array(
							'min'			=> '1',
							'max'			=> '2000',
							'step'			=> '50'
						),
						'responsive'	=> true,
						'default'		=> 250,
					),
					'cover_height'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Album Cover Height', 'bb-switch'),
						'units'			=> array('px'),
						'slider'		=> array(
							'min'			=> '1',
							'max'			=> '500',
							'step'			=> '10'
						),
						'responsive'	=> true,
						'default'		=> 300,
					),
                )
			),
			'cover_content'	=> array(
				'title'			=> __('Cover Content', 'bb-powerpack'),
				'collapsed'		=> true,
                'fields'		=> array(
					'cover_content'			=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Show Cover Content', 'bb-powerpack'),
						'default'				=> 'show',
						'options'				=> array(
							'show'					=> __('Show', 'bb-powerpack'),
							'hide'					=> __('Hide', 'bb-powerpack'),
						),
						'toggle'				=> array(
							'show'					=> array(
								'fields'				=> array( 'content_icon', 'content_title', 'title_html_tag', 'content_subtitle', 'subtitle_html_tag' ),
								'tabs'					=> array( 'title_typography' ),
								'sections'				=> array( 'content_button' ),
							),
						),
					),
					'content_icon'			=> array(
					    'type'          		=> 'icon',
						'label'         		=> __( 'Icon', 'bb-powerpack' ),
						'default'				=> 'far fa-images',
						'show_remove'			=> true,
					),
					'content_title'			=> array(
					    'type'          		=> 'text',
						'label'        			=> __( 'Title', 'bb-powerpack' ),
						'default'				=> __('My Album','bb-powerpack' ),
						'connections'  			=> array('string')
					),
					'title_html_tag'		=> array(
						'type'					=> 'select',
						'label'					=> __('Title HTML Tag', 'bb-powerpack'),
						'default'				=> 'div',
                		'options'				=> array(
							'h1'     				=> __( 'H1', 'bb-powerpack' ),
							'h2'     				=> __( 'H2', 'bb-powerpack' ),
							'h3'     				=> __( 'H3', 'bb-powerpack' ),
							'h4'     				=> __( 'H4', 'bb-powerpack' ),
							'h5'     				=> __( 'H5', 'bb-powerpack' ),
							'h6'     				=> __( 'H6', 'bb-powerpack' ),
							'div'    				=> __( 'div', 'bb-powerpack' ),
							'span'   				=> __( 'span', 'bb-powerpack' ),
							'p'      				=> __( 'p', 'bb-powerpack' ),
						),
					),
					'content_subtitle'		=> array(
					    'type'          		=> 'text',
						'label'         		=> __( 'Subtitle', 'bb-powerpack' ),
						'default'				=> __('Memorable Moments','bb-powerpack' ),
						'connections'  			=> array('string')
					),
					'subtitle_html_tag'		=> array(
						'type'					=> 'select',
						'label'					=> __('Subtitle HTML Tag', 'bb-powerpack'),
						'default'				=> 'div',
                		'options'				=> array(
							'h1'     				=> __( 'H1', 'bb-powerpack' ),
							'h2'     				=> __( 'H2', 'bb-powerpack' ),
							'h3'     				=> __( 'H3', 'bb-powerpack' ),
							'h4'     				=> __( 'H4', 'bb-powerpack' ),
							'h5'     				=> __( 'H5', 'bb-powerpack' ),
							'h6'     				=> __( 'H6', 'bb-powerpack' ),
							'div'    				=> __( 'div', 'bb-powerpack' ),
							'span'   				=> __( 'span', 'bb-powerpack' ),
							'p'      				=> __( 'p', 'bb-powerpack' ),
						),
					),
				),
			),
			'content_button' => array(
				'title'				=> __('Button', 'bb-powerpack'),
				'collapsed'			=> true,
                'fields'			=> array(
					'content_button'		=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Show Button', 'bb-powerpack'),
						'default'				=> 'yes',
						'options'				=> array(
							'yes'					=> __('Yes', 'bb-powerpack'),
							'no'					=> __('No', 'bb-powerpack'),
						),
						'toggle'				=> array(
							'yes'					=> array(
								'fields'				=> array( 'content_button_text', 'content_button_pos', 'content_button_typo' ),
								'sections'				=> array( 'album_cover_button' ),
							),
						),
					),
					'content_button_text'	=> array(
						'type'					=> 'text',
						'label'					=> __('Button Text', 'bb-powerpack'),
						'default'				=> __('Show Album', 'bb-powerpack'),
						'connections'  			=> array('string')
					),
					'content_button_pos'	=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Button Position', 'bb-powerpack'),
						'default'				=> 'bottom',
						'options'				=> array(
							'inline'				=> __('Inline', 'bb-powerpack'),
							'bottom'				=> __('Bottom', 'bb-powerpack'),
						),
						'toggle' 				=> array(
							'inline'				=> array(
								'fields'				=> array( 'inline_button_pos' ),
							),
						)
					),
					'inline_button_pos'		=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Button Align', 'bb-powerpack'),
						'default'				=> 'center',
						'options'				=> array(
							'flex-start'			=> __('Top', 'bb-powerpack'),
							'center'				=> __('Center', 'bb-powerpack'),
							'flex-end'				=> __('Bottom', 'bb-powerpack'),
						),
						'preview'   				=> array(
							'type'  					=> 'css',
							'selector'  				=> '.pp-album-content.pp-album-cover-button-position-inline',
							'property'  				=> 'align-items',
						),
					),
				),
			),
		),
	),
    'trigger_album_button'	=> array(
        'title'         => __('Button', 'bb-powerpack'),
        'sections'      => array(
            'cover_button'	=> array(
				'title'         => 'Button',
                'fields'        => array(
					'btn_max_width'		=> array(
						'type'				=> 'unit',
						'label'				=> __('Max Width', 'bb-powerpack'),
						'default'			=> 200,
						'units'				=> array( 'px' ),
						'slider'			=> true,
						'responsive'		=> true,
					),
					'btn_align'			=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Button Horizontal Align', 'bb-powerpack'),
						'default'				=> 'center',
						'options'				=> array(
							'flex-start'			=> __('Left', 'bb-powerpack'),
							'center'				=> __('Center', 'bb-powerpack'),
							'flex-end'				=> __('Right', 'bb-powerpack'),
						),
					),
					'cover_btn_align'	=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Button Content Align', 'bb-powerpack'),
						'default'				=> 'center',
						'options'				=> array(
							'left'					=> __('Left', 'bb-powerpack'),
							'center'				=> __('Center', 'bb-powerpack'),
							'right'					=> __('Right', 'bb-powerpack'),
						),
					),
					'cover_btn_type'	=> array(
					    'type'          	=> 'pp-switch',
						'label'         	=> __( 'Button Type', 'bb-powerpack' ),
						'default'			=> 'text',
						'options'			=> array(
							'text'				=> __('Text', 'bb-powerpack'),
							'icon'				=> __('Icon', 'bb-powerpack'),
							'icon_text'			=> __('Icon + Text', 'bb-powerpack'),
						),
                        'toggle' 			=> array(
                            'text'	    		=> array(
                                'fields'   			=> array( 'cover_btn_text', 'trigger_button_color', 'trigger_button_hover_color', 'trigger_button_bg', 'trigger_button_hover_bg', 'trigger_button_border', 'trigger_button_hover_border', 'trigger_button_padding', 'trigger_button_typo' ),
                            ),
                            'icon'	    		=> array(
                                'fields'   			=> array( 'cover_btn_icon', 'trigger_icon_color', 'trigger_icon_hover_color', 'trigger_icon_size' ),
                            ),
                            'icon_text'	    	=> array(
                                'fields'   			=> array( 'cover_btn_text', 'cover_btn_icon', 'icon_position', 'icon_spacing','trigger_button_color', 'trigger_button_hover_color', 'trigger_button_bg', 'trigger_button_hover_bg', 'trigger_button_border', 'trigger_button_hover_border', 'trigger_button_padding', 'trigger_button_typo', 'trigger_icon_color', 'trigger_icon_hover_color', 'trigger_icon_size' ),
                            ),
						)
					),
					'cover_btn_text'	=> array(
					    'type'          	=> 'text',
						'label'         	=> __( 'Text', 'bb-powerpack' ),
						'default'			=> __('View Album','bb-powerpack' ),
						'connections'  		=> array('string')
					),
					'cover_btn_icon'	=> array(
					    'type'          	=> 'icon',
						'label'         	=> __( 'Icon', 'bb-powerpack' ),
						'default'			=> __('far fa-address-book', 'bb-powerpack' ),
						'show_reset'		=> true,
					),
					'icon_position'		=> array(
					    'type'          	=> 'pp-switch',
						'label'         	=> __( 'Icon Position', 'bb-powerpack' ),
						'default'			=> 'top',
						'options'			=> array(
							'top'				=> __('Top', 'bb-powerpack'),
							'bottom'			=> __('Bottom', 'bb-powerpack'),
							'left'				=> __('Left', 'bb-powerpack'),
							'right'				=> __('Right', 'bb-powerpack'),
						),
					),
					'icon_spacing'		=> array(
						'type'				=> 'unit',
						'label'				=> __('Icon Spacing', 'bb-powerpack'),
						'default'			=> 10,
						'units'				=> array( 'px' ),
						'slider'			=> true,
						'responsive'		=> true,
					),
                )
			),
		),
	),
    'settings'		=> array(
        'title'         => __('Settings', 'bb-powerpack'),
        'sections'      => array(
			'lightbox_settings'	=> array(
				'title'				=> __('Lightbox Settings', 'bb-powerpack'),
				'fields'			=> array(
					'lightbox_caption'	=> array(
						'type'				=> 'select',
						'label'				=> __( 'Lightbox Caption', 'bb-powerpack'),
						'default'			=> '',
						'options'			=> array(
							''					=> __( 'None', 'bb-powerpack'),
							'caption'			=> __( 'Caption', 'bb-powerpack'),
							'title'				=> __( 'Title', 'bb-powerpack'),
						),
					),
					'lightbox_loop'		=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Loop', 'bb-powerpack'),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack'),
							'no'				=> __( 'No', 'bb-powerpack'),						
						),
					),
					'lightbox_arrows'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Arrows', 'bb-powerpack'),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack'),
							'no'				=> __( 'No', 'bb-powerpack'),						
						),
					),
					'slides_counter'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Slides Counter', 'bb-powerpack'),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack'),
							'no'				=> __( 'No', 'bb-powerpack'),						
						),
					),
					'keyboard_nav'		=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Keyboard Navigation', 'bb-powerpack'),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack'),
							'no'				=> __( 'No', 'bb-powerpack'),						
						),
					),
					'toolbar'			=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Toolbar', 'bb-powerpack'),
						'default'			=> 'yes',
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack'),
							'no'				=> __( 'No', 'bb-powerpack'),						
						),
                        'toggle' => array(
                            'yes'	=> array(
								'fields'		=> array( 'toolbar_buttons' ),
                            ),
						)
					),
					'toolbar_buttons'	=> array(
						'type'				=> 'select',
						'label'				=> __( 'Toolbar Buttons', 'bb-powerpack'),
						'default'			=> array('zoom','fullScreen'),
						'multi-select'		=> true,
						'options'			=> array(
							'zoom'          	=> __( 'Zoom', 'bb-powerpack' ),
							'share'         	=> __( 'Share', 'bb-powerpack' ),
							'slideShow'     	=> __( 'SlideShow', 'bb-powerpack' ),
							'fullScreen'    	=> __( 'Full Screen', 'bb-powerpack' ),
							'download'      	=> __( 'Download', 'bb-powerpack' ),
							'thumbs'        	=> __( 'Thumbs', 'bb-powerpack' ),
							'close'         	=> __( 'Close', 'bb-powerpack' ),
						),
					),
					'thumbs_auto_start'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Thumbs Auto Start', 'bb-powerpack'),
						'default'			=> 'yes',
						'help'				=> __( 'Display thumbnails on lightbox opening', 'bb-powerpack' ),
						'options'			=> array(
							'yes'				=> __( 'Yes', 'bb-powerpack'),
							'no'				=> __( 'No', 'bb-powerpack'),						
						),
					),
					'thumbs_position'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Thumbs Position', 'bb-powerpack'),
						'default'			=> '',
						'options'			=> array(
							''					=> __( 'Default', 'bb-powerpack'),
							'bottom'			=> __( 'Bottom', 'bb-powerpack'),						
						),
					),
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
        ),
	),
    'style'			=> array(
        'title'         => __('Style', 'bb-powerpack'),
        'sections'      => array(
			'album_cover_style'		=> array(
				'title'				=> __('Album Cover', 'bb-powerpack'),
				'fields'			=> array(
					'cover_img_scale'	=> array(
						'type'				=> 'unit',
						'label'				=> __('Image Scale', 'bb-powerpack'),
						'slider'			=> true,
						'default'			=> 1,
					),
					'cover_overlay_bg'	=> array(
						'type'				=> 'color',
						'label'				=> __('Cover Overlay Background', 'bb-powerpack'),
						'default'			=> 'rgba(0,0,0,0.5)',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'preview'   		=> array(
                            'type'  			=> 'css',
                            'selector'  		=> '.pp-album-cover-overlay',
                            'property'  		=> 'background-color',
						),
						'connections'  		=> array('color')
					),
					'cover_border'		=> array(
						'type'          	=> 'border',
						'label'         	=> __( 'Border', 'bb-powerpack' ),
						'responsive'		=> true,
						'preview'   		=> array(
                            'type'  			=> 'css',
                            'selector'  		=> '.pp-album-cover',
                            'property'  		=> 'border',
                        ),
					),
                    'overlay_margin'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Cover Overlay Margin', 'bb-powerpack'),
						'default'			=> '10',
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-album-cover-overlay',
							'property'			=> 'margin',
							'unit'				=> 'px'
						)
                    ),
				),
			),
			'album_cover_hover'		=> array(
				'title'					=> __('Album Cover on Hover', 'bb-powerpack'),
				'collapsed'				=> true,
				'fields'				=> array(
					'cover_img_hover_scale'		=> array(
						'type'						=> 'unit',
						'label'						=> __('Image Scale', 'bb-powerpack'),
						'slider'					=> true,
						'default'					=> 1,
						'preview'					=> false,
					),
					'cover_hover_border'		=> array(
						'type'          			=> 'border',
						'label'         			=> __( 'Border', 'bb-powerpack' ),
						'responsive'				=> true,
						'preview'					=> false,
					),
					'cover_overlay_hover_bg'	=> array(
						'type'						=> 'color',
						'label'						=> __('Cover Overlay Background', 'bb-powerpack'),
						'default'					=> 'rgba(0,0,0,0.5)',
						'show_reset'				=> true,
						'show_alpha'				=> true,
						'preview'					=> false,
						'connections'  				=> array('color')
					),
                    'overlay_hover_margin'		=> array(
						'type'						=> 'dimension',
						'label'						=> __('Overlay Hover Margin', 'bb-powerpack'),
						'default'					=> '10',
						'units'						=> array('px'),
						'slider'					=> true,
						'responsive'				=> true,
						'preview'					=> false,
                    ),
				),
			),
			'album_cover_content'	=> array(
				'title'				=> __('Album Cover Content', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'vertical_align'		=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Vertical Align', 'bb-powerpack'),
						'default'				=> 'center',
						'options'				=> array(
							'flex-start'			=> __('Top', 'bb-powerpack'),
							'center'				=> __('Center', 'bb-powerpack'),
							'flex-end'				=> __('Bottom', 'bb-powerpack'),
						),
						'preview'   				=> array(
                            'type'  					=> 'css',
                            'selector'  				=> '.pp-album-content-wrap',
                            'property'  				=> 'justify-content',
                        ),
					),
					'horizontal_align'		=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Horizontal Align', 'bb-powerpack'),
						'default'				=> 'center',
						'options'				=> array(
							'flex-start'			=> __('Left', 'bb-powerpack'),
							'center'				=> __('Center', 'bb-powerpack'),
							'flex-end'				=> __('Right', 'bb-powerpack'),
							'stretch'				=> __('Justify', 'bb-powerpack'),
						),
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-content-wrap',
                            'property'  			=> 'align-items',
                        ),
					),
					'content_text_align'	=> array(
						'type'					=> 'align',
						'label'					=> __('Text Align', 'bb-powerpack'),
						'default'				=> 'center',
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-content',
                            'property'  			=> 'text-align',
                        ),
					),
                    'content_padding'		=> array(
						'type'					=> 'dimension',
						'label'					=> __('Content Padding', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-content',
							'property'				=> 'padding',
							'unit'					=> 'px'
						)
                    ),
                    'content_margin'		=> array(
						'type'					=> 'dimension',
						'label'					=> __('Content Margin', 'bb-powerpack'),
						'default'				=> '0',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-content',
							'property'				=> 'margin',
							'unit'					=> 'px'
						)
					),
					'content_bg'			=> array(
						'type'					=> 'color',
						'label'					=> __('Background Color', 'bb-powerpack'),
						'default'				=> 'rgba(137,137,137,0.24)',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-content',
                            'property'  			=> 'background-color',
						),
						'connections'  			=> array('color')
					),
					'content_border'		=> array(
						'type'          		=> 'border',
						'label'         		=> __( 'Border', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-content',
                            'property'  			=> 'border',
                        ),
					),
					'content_icon_color'	=> array(
						'type'					=> 'color',
						'label'					=> __('Icon Color', 'bb-powerpack'),
						'default'				=> 'ffffff',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-icon',
                            'property'  			=> 'color',
						),
						'connections'  			=> array('color')
					),
					'content_icon_size'		=> array(
						'type'					=> 'unit',
						'label'					=> __('Icon Size', 'bb-powerpack'),
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-icon',
                            'property'  			=> 'font-size',
                        ),
					),
					'content_icon_spacing'	=> array(
						'type'					=> 'unit',
						'label'					=> __('Icon Bottom Spacing', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-icon',
                            'property'  			=> 'margin-bottom',
                        ),
					),
					'content_title_color'	=> array(
						'type'					=> 'color',
						'label'					=> __('Title Color', 'bb-powerpack'),
						'default'				=> 'ffffff',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-title',
                            'property'  			=> 'color',
						),
						'connections'  			=> array('color')
					),
					'content_title_spacing'	=> array(
						'type'					=> 'unit',
						'label'					=> __('Title Bottom Spacing', 'bb-powerpack'),
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-title',
                            'property'  			=> 'margin-bottom',
                        ),
					),
					'content_subtitle_color'=> array(
						'type'						=> 'color',
						'label'						=> __('Subtitle Color', 'bb-powerpack'),
						'default'					=> 'ffffff',
						'show_alpha'				=> true,
						'show_reset'				=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-subtitle',
                            'property'  			=> 'color',
						),
						'connections'  			=> array('color')
					),
				),
			),
			'album_cover_content_h'	=> array(
				'title'				=> __('Album Cover Content on Hover', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'content_hover_bg'		=> array(
						'type'					=> 'color',
						'label'					=> __('Hover Background Color', 'bb-powerpack'),
						'default'				=> '',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'				=> false,
						'connections'  			=> array('color')
					),
					'content_hover_border'	=> array(
						'type'          		=> 'border',
						'label'         		=> __( 'Hover Border', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'   			=> false,
					),
					'content_icon_color_h'	=> array(
						'type'					=> 'color',
						'label'					=> __('Icon Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'				=> false,
						'connections'  			=> array('color')
					),
					'content_title_color_h'	=> array(
						'type'					=> 'color',
						'label'					=> __('Title Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'				=> false,
						'connections'  			=> array('color')
					),
					'content_subtitle_color_h'	=> array(
						'type'						=> 'color',
						'label'						=> __('Subtitle Hover Color', 'bb-powerpack'),
						'default'					=> '',
						'show_alpha'				=> true,
						'show_reset'				=> true,
						'preview'					=> false,
						'connections'	  			=> array('color')
					),
				),
			),
			'album_cover_button'	=> array(
				'title'					=> __('Album Cover Button', 'bb-powerpack'),
				'collapsed'				=> true,
				'fields'				=> array(
					'content_button_color'		=> array(
						'type'					=> 'color',
						'label'					=> __('Text Color', 'bb-powerpack'),
						'default'				=> 'fff',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-cover-button-wrap',
                            'property'  			=> 'color',
						),
						'connections'  			=> array('color')
					),
					'content_button_hover_color'=> array(
						'type'					=> 'color',
						'label'					=> __('Text Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'   			=> false,
						'connections'  			=> array('color')
					),
					'content_button_bg'			=> array(
						'type'					=> 'color',
						'label'					=> __('Background Color', 'bb-powerpack'),
						'default'				=> 'rgba(0,0,0,1)',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-cover-button-wrap',
                            'property'  			=> 'background-color',
						),
						'connections'  			=> array('color')
					),
					'content_button_hover_bg'	=> array(
						'type'					=> 'color',
						'label'					=> __('Background Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> false,
						'connections'  			=> array('color')
					),
					'content_button_border'		=> array(
						'type'          		=> 'border',
						'label'         		=> __( 'Border', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-cover-button-wrap',
                            'property'  			=> 'border',
                        ),
					),
					'content_button_hover_border'=> array(
						'type'					=> 'color',
						'label'					=> __('Border Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> false,
						'connections'  			=> array('color')
					),
                    'content_button_padding'	=> array(
						'type'					=> 'dimension',
						'label'					=> __('Padding', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-cover-button-wrap',
							'property'				=> 'padding',
							'unit'					=> 'px'
						)
                    ),
                    'content_button_margin'		=> array(
						'type'					=> 'dimension',
						'label'					=> __('Margin', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-cover-button-wrap',
							'property'				=> 'margin',
							'unit'					=> 'px'
						)
					),
				),
			),
			'album_lightbox'		=> array(
				'title'					=> __('Lightbox', 'bb-powerpack'),
				'collapsed'				=> true,
				'fields'				=> array(
					'lightbox_bg_color'		=> array(
						'type'						=> 'color',
						'label'						=> __('Background color', 'bb-powerpack'),
						'default'					=> '000',
						'show_reset'				=> true,
						'preview'					=> false,
						'connections'  				=> array('color')
					),
					'lightboxbg_opacity'	=> array(
						'type'					=> 'unit',
						'label'					=> __('Backgroung Opacity', 'bb-powerpack'),
						'property'				=> 'opacity',
						'default'				=> '0.87',
						'slider'				=> array(
							'min'					=> 0,
							'max'					=> 1,
							'step'					=> 0.1
						),
						'preview'   			=> array(
							'type'  				=> 'none',
						),
					),
					'thumbs_bg_color'		=> array(
						'type'						=> 'color',
						'label'						=> __('Thumbs Background Color', 'bb-powerpack'),
						'default'					=> 'ffffff',
						'show_reset'				=> true,
						'show_alpha'				=> true,
						'preview'					=> false,
						'connections'  				=> array('color')
					),
				),
			),
        ),
	),
    'trigger_button_style'	=> array(
        'title'         		=> __('Style', 'bb-powerpack'),
        'sections'     			=> array(
			'trigger_button'		=> array(
				'title'					=> __('Trigger Button', 'bb-powerpack'),
				'fields'				=> array(
					'trigger_icon_color'		=> array(
						'type'						=> 'color',
						'label'						=> __('Icon Color', 'bb-powerpack'),
						'default'					=> 'fff',
						'show_alpha'				=> true,
						'show_reset'				=> true,
						'preview'   				=> array(
                            'type'  					=> 'css',
                            'selector'  				=> '.pp-album-button-content i',
                            'property'  				=> 'color',
						),
						'connections'  				=> array('color')
					),
					'trigger_icon_hover_color'	=> array(
						'type'						=> 'color',
						'label'						=> __('Icon Hover Color', 'bb-powerpack'),
						'default'					=> '',
						'show_alpha'				=> true,
						'show_reset'				=> true,
						'preview'   				=> false,
						'connections'  				=> array('color')
					),
					'trigger_icon_size'			=> array(
						'type'						=> 'unit',
						'label'						=> __('Icon Size', 'bb-powerpack'),
						'default'					=> 20,
						'units'						=> array( 'px' ),
						'slider'					=> true,
						'responsive'				=> true,
						'preview'   				=> array(
                            'type'  					=> 'css',
                            'selector'  				=> '.pp-album-button-content i',
                            'property'  				=> 'font-size',
                        ),
					),
					'trigger_button_color'		=> array(
						'type'					=> 'color',
						'label'					=> __('Text Color', 'bb-powerpack'),
						'default'				=> 'fff',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-button-content',
                            'property'  			=> 'color',
                        ),
					),
					'trigger_button_hover_color'=> array(
						'type'					=> 'color',
						'label'					=> __('Text Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_alpha'			=> true,
						'show_reset'			=> true,
						'preview'   			=> false,
						'connections'  			=> array('color')
					),
					'trigger_button_bg'			=> array(
						'type'					=> 'color',
						'label'					=> __('Background Color', 'bb-powerpack'),
						'default'				=> 'rgba(0,0,0,1)',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-button-content',
                            'property'  			=> 'background-color',
						),
						'connections'  			=> array('color')
					),
					'trigger_button_hover_bg'	=> array(
						'type'					=> 'color',
						'label'					=> __('Background Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> false,
						'connections'  			=> array('color')
					),
					'trigger_button_border'		=> array(
						'type'          		=> 'border',
						'label'         		=> __( 'Border', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'   			=> array(
                            'type'  				=> 'css',
                            'selector'  			=> '.pp-album-button-content',
                            'property'  			=> 'border',
                        ),
					),
					'trigger_button_hover_border'=> array(
						'type'					=> 'color',
						'label'					=> __('Border Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_reset'			=> true,
						'show_alpha'			=> true,
						'preview'   			=> false,
						'connections'  			=> array('color')
					),
                    'trigger_button_padding'	=> array(
						'type'					=> 'dimension',
						'label'					=> __('Padding', 'bb-powerpack'),
						'default'				=> '10',
						'units'					=> array('px'),
						'slider'				=> true,
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-button-content',
							'property'				=> 'padding',
							'unit'					=> 'px'
						)
					),
					'trigger_button_typo'		=> array(
						'type'						=> 'typography',
						'label'						=> __( 'Button Typography', 'bb-powerpack' ),
						'responsive'				=> true,
						'preview'					=> array(
							'type'						=> 'css',
							'selector'					=> '.pp-album-button-inner',
						),
					),
				),
			),
	    ),
	),
    'title_typography'	=> array(
        'title'         => __('Typography', 'bb-powerpack'),
        'sections'      => array(
            'title_typography'	=> array(
                'title'         	=> __('Album Cover Content', 'bb-powerpack'),
				'fields'			=> array(
					'content_title_typo'	=> array(
						'type'					=> 'typography',
						'label'					=> __( 'Title', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-title',
						),
					),
					'content_subtitle_typo'	=> array(
						'type'					=> 'typography',
						'label'					=> __( 'Subtitle', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-subtitle',
						),
					),
					'content_button_typo'	=> array(
						'type'					=> 'typography',
						'label'					=> __( 'Button', 'bb-powerpack' ),
						'responsive'			=> true,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-album-cover-button-wrap',
						),
					),
				),
			),
		),
	),
));
