<?php
/**
 * @class PPVideoGalleryModule
 */
class PPVideoGalleryModule extends FLBuilderModule {
	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'              => __( 'Video Gallery', 'bb-powerpack' ),
			'description'       => __( 'A module that displays a gallery of videos.', 'bb-powerpack' ),
			'group'             => pp_get_modules_group(),
			'category'		    => pp_get_modules_cat( 'content' ),
			'dir'               => BB_POWERPACK_DIR . 'modules/pp-video-gallery/',
			'url'               => BB_POWERPACK_URL . 'modules/pp-video-gallery/',
			'editor_export'     => true,
			'enabled'           => true,
			'partial_refresh'   => true,
		) );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		$this->add_js( 'jquery-isotope' );
		$this->add_js( 'imagesloaded' );

		if ( isset( $this->settings ) && 'yes' === $this->settings->lightbox ) {
			$this->add_css( 'pp-jquery-fancybox' );
			$this->add_js( 'pp-jquery-fancybox' );
		}

		if ( 'carousel' === $this->get_layout() ) {
			$this->add_css( 'jquery-swiper' );
			$this->add_js( 'jquery-swiper' );
		}

		$this->add_css( BB_POWERPACK()->fa_css );
	}

	/**
	 * Get layout - gallery or carousel.
	 *
	 * @since 2.7.3
	 * @return string
	 */
	public function get_layout() {
		return isset( $this->settings->layout ) ? $this->settings->layout : 'gallery';
	}

	/**
	 * Check if Video Info is enabled or not.
	 *
	 * @since 2.7.3
	 * @return boolean
	 */
	public function info_enabled() {
		return isset( $this->settings->enable_info ) && 'yes' === $this->settings->enable_info;
	}

	/**
	 * Check if Filter is enabled or not.
	 *
	 * @since 2.7.3
	 * @return boolean
	 */
	public function filters_enabled() {
		if ( 'gallery' !== $this->get_layout() ) {
			return false;
		}

		return isset( $this->settings->enable_filters ) && 'yes' === $this->settings->enable_filters;
	}

	/**
	 * Returns HTML tag for video title.
	 *
	 * @since 2.7.3
	 * @return string
	 */
	public function get_title_html_tag() {
		return isset( $this->settings->title_tag ) ? $this->settings->title_tag : 'div';
	}

	/**
	 * Get the tags from each video item form
	 * and build an array of slug from them.
	 *
	 * @since 2.7.3
	 * @param object $item	Video item form.
	 * @return array
	 */
	public function get_tags_array( $item ) {
		$tags = isset( $item->filter_tags ) ? array_map( 'trim', explode( ',', $item->filter_tags ) ) : array();

		$tags_array = array();

		if ( ! empty( $tags ) ) {
			foreach ( $tags as $tag ) {
				if ( empty( $tag ) ) {
					continue;
				}
				$tags_array[ $this->get_clean_str( $tag ) ] = $tag;
			}
		}

		return $tags_array;
	}

	/**
	 * Replace all instances of spaces with hyphen
	 * and remove any special characters from string.
	 *
	 * @since 2.7.2
	 * @param string $str
	 * @return string
	 */
	public function get_clean_str( $str ) {
		// Replace all instances of space with hyphen.
		$str = str_replace( ' ', '-', $str );

		// Remove any special characters.
		$str = preg_replace( '/[^A-Za-z0-9\-]/', '', $str );

		// Lowercase.
		return strtolower( $str );
	}

	/**
	 * Get the filter data.
	 *
	 * @since 2.7.2
	 * @return array
	 */
	public function get_filters_data() {
		$filters = array();

		if ( ! empty( $this->settings->videos ) ) {
			foreach ( $this->settings->videos as $video ) {
				if ( ! is_object( $video ) ) {
					continue;
				}

				$tags = $this->get_tags_array( $video );

				if ( ! empty( $tags ) ) {
					$filters = array_unique( array_merge( $filters, $tags ) );
				}
			}
		}

		return $filters;
	}

	/**
	 * Renders the filters.
	 *
	 * @since 2.7.2
	 * @return void
	 */
	public function render_filters() {
		if ( ! $this->filters_enabled() ) {
			return;
		}

		$filters = $this->get_filters_data();

		if ( empty( $filters ) ) {
			return;
		}
		?>
		<div class="pp-video-gallery-filters-wrap">
			<ul class="pp-video-gallery-filters">
			<?php if ( isset( $this->settings->filters_all_text ) && ! empty( $this->settings->filters_all_text ) ) { ?>
				<li class="pp-video-gallery-filter pp-filter--active" data-filter="*"><span><?php echo $this->settings->filters_all_text; ?></span></li>
			<?php } ?>
			<?php foreach ( $filters as $key => $value ) { ?>
				<li class="pp-video-gallery-filter" data-filter=".pp-filter-<?php echo $key; ?>"><span><?php echo $value; ?></span></li>
			<?php } ?>
			</ul>
		</div>
		<?php
	}

	public function render_video_info( $item ) {
		if ( $this->info_enabled() && ! empty( $item->video_title ) ) {
		?>
		<div class="pp-video-info">
			<<?php echo $this->get_title_html_tag(); ?> class="pp-video-title"><?php echo $item->video_title; ?></<?php echo $this->get_title_html_tag(); ?>>
		</div>
		<?php
		}
	}
}

FLBuilder::register_module('PPVideoGalleryModule', array(
	'layout'	=> array(
		'title'		=> __( 'General', 'bb-powerpack' ),
		'sections'	=> array(
			'general'	=> array(
				'title'		=> __( 'General', 'bb-powerpack' ),
				'fields'	=> array(
					'layout'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __( 'Layout', 'bb-powerpack' ),
						'options'	=> array(
							'gallery'	=> __( 'Gallery', 'bb-powerpack' ),
							'carousel'	=> __( 'Carousel', 'bb-powerpack' ),
						),
						'default'	=> 'gallery',
						'toggle'	=> array(
							'carousel'	=> array(
								'tabs'		=> array( 'carousel' ),
							),
						),
					),
					'enable_info'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Enable Video Title', 'bb-powerpack' ),
						'help'			=> __( 'By enabling this option will render the video title entered in individual video settings under Videos tab in module.', 'bb-powerpack' ),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'fields'		=> 'info_position',
							),
						),
					),
					'info_position'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Title Position', 'bb-powerpack' ),
						'default'			=> 'below',
						'options'			=> array(
							'above'				=> __( 'Above', 'bb-powerpack' ),
							'below'				=> __( 'Below', 'bb-powerpack' ),
						),
					),
				),
			),
			'structure'	=> array(
				'title'		=> __( 'Structure', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'columns'	=> array(
						'type'		=> 'unit',
						'label'		=> __( 'Columns', 'bb-powerpack' ),
						'default'	=> '3',
						'slider'	=> array(
							'min'		=> '1',
							'max'		=> '10',
							'step'		=> '1',
						),
						'responsive'	=> true,
					),
					'spacing'		=> array(
						'type'			=> 'unit',
						'label'			=> __( 'Spacing', 'bb-powerpack' ),
						'default'		=> '2',
						'slider'		=> true,
						'responsive'	=> true,
						'help'			=> __( 'Spacing unit will be "%" for gallery and "px" for carousel.', 'bb-powerpack' ),
					),
					'aspect_ratio'	=> array(
						'type'			=> 'select',
						'label'			=> __( 'Aspect Ratio', 'bb-powerpack' ),
						'default' 		=> '169',
						'options' 		=> array(
							'169' 			=> '16:9',
							'219' 			=> '21:9',
							'43' 			=> '4:3',
							'32' 			=> '3:2',
							'11' 			=> '1:1',
						),
					),
				),
			),
			'overlay'	=> array(
				'title'		=> __( 'Play Icon and Lightbox', 'bb-powerpack' ),
				'description'	=> __( 'Note: Custom Play Icon and Lightbox will not work with default overlay. You will need to set custom overlay in individual video item.', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'play_icon'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __( 'Custom Play Icon', 'bb-powerpack' ),
						'default'	=> 'hide',
						'options'	=> array(
							'show'		=> __( 'Show', 'bb-powerpack' ),
							'hide'		=> __( 'Hide', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'show'		=> array(
								'sections'	=> array( 'play_icon' ),
							),
						),
					),
					'lightbox'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __( 'Enable Lightbox', 'bb-powerpack' ),
						'default'	=> 'no',
						'options'	=> array(
							'yes'		=> __( 'Yes', 'bb-powerpack' ),
							'no'		=> __( 'No', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'yes'		=> array(
								'sections'	=> array( 'lightbox_style' ),
							),
						),
					),
				),
			),
			'filters'	=> array(
				'title'		=> __( 'Filters', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'enable_filters'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __( 'Enable Tags Filter', 'bb-powerpack' ),
						'help'		=> __( 'You need to enter tags in individual video settings under Videos tab in module.', 'bb-powerpack' ),
						'default'	=> 'no',
						'options'	=> array(
							'yes'		=> __( 'Yes', 'bb-powerpack' ),
							'no'		=> __( 'No', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'yes'		=> array(
								'sections'	=> array( 'filters_style' ),
								'fields'	=> array( 'filters_all_text' ),
							),
						),
					),
					'filters_all_text'	=> array(
						'type'		=> 'text',
						'label'		=> __( '"All" Text', 'bb-powerpack' ),
						'default'	=> __( 'All', 'bb-powerpack' ),
						'connections'	=> array( 'string' ),
					),
				),
			),
		),
	),
	'carousel'	=> array(
		'title'		=> __( 'Carousel', 'bb-powerpack' ),
		'sections'	=> array(
			'carousel_opts'	=> array(
				'title'			=> '',
				'fields'		=> array(
					'carousel_autoplay'		=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Auto Play', 'bb-powerpack' ),
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
						'default'		=> 'yes',
						'toggle'		=> array(
							'yes'			=> array(
								'fields'		=> array( 'autoplay_delay', 'pause_on_interaction' ),
							),
						),
					),
					'autoplay_delay'	=> array(
						'type'				=> 'unit',
						'label'				=> __( 'Auto Play Delay', 'bb-powerpack' ),
						'default'			=> 3000,
						'units'				=> array( 'ms' ),
						'slider'			=> false,
					),
					'pause_on_interaction'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Pause on Interaction', 'bb-powerpack' ),
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
						'default'		=> 'no',
					),
					'slides_to_scroll'	=> array(
						'type' 				=> 'unit',
						'label' 			=> __( 'Slides to Scroll', 'bb-powerpack' ),
						'default'			=> 1,
						'slider'			=> true,
						'responsive' 		=> array(
							'placeholder' 		=> array(
								'default' 			=> '1',
								'medium' 			=> '1',
								'responsive' 		=> '1',
							),
						),
						'help'	=> __( 'Set numbers of slides to move at a time.', 'bb-powerpack' )
					),
					'effect'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Effect', 'bb-powerpack' ),
						'options'		=> array(
							'slide'			=> __( 'Slide', 'bb-powerpack' ),
							'fade'			=> __( 'Fade', 'bb-powerpack' ),
						),
						'default'		=> 'slide',
					),
					'transition_speed'	=> array(
						'type'				=> 'unit',
						'label'				=> __( 'Transition Speed', 'bb-powerpack' ),
						'default'			=> '1000',
						'units'				=> array( 'ms' ),
						'slider'			=> false,
					),
					'carousel_loop'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Loop', 'bb-powerpack' ),
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
						'default'		=> 'no',
					),
				),
			),
			'navigation'	=> array(
				'title' 		=> __( 'Controls', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'slider_navigation'     => array(
						'type'          => 'pp-switch',
						'label'         => __( 'Show Navigation Buttons?', 'bb-powerpack' ),
						'default'       => 'no',
						'options'       => array(
							'yes'        	=> __( 'Yes', 'bb-powerpack' ),
							'no'            => __( 'No', 'bb-powerpack' ),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array( 'nav_style' ),
							)
						),
					),
					'pagination_type'   => array(
						'type'          	=> 'pp-switch',
						'label'         	=> __( 'Pagination Type', 'bb-powerpack' ),
						'default'       	=> 'bullets',
						'options'       	=> array(
							'none'				=> __( 'None', 'bb-powerpack' ),
							'bullets'       	=> __( 'Dots', 'bb-powerpack' ),
							'fraction'			=> __( 'Fraction', 'bb-powerpack' ),
							'progress'			=> __( 'Progress', 'bb-powerpack' ),
						),
						'toggle'			=> array(
							'bullets'			=> array(
								'sections'			=> array( 'pagination_style' ),
								'fields'			=> array( 'bullets_width', 'bullets_border_radius' ),
							),
							'fraction'			=> array(
								'sections'			=> array( 'pagination_style' ),
							),
							'progress'			=> array(
								'sections'			=> array( 'pagination_style' ),
							)
						)
					),
				),
			),
		),
	),
	'videos'	=> array(
		'title'		=> __( 'Videos', 'bb-powerpack' ),
		'sections'	=> array(
			'videos'	=> array(
				'title'		=> '',
				'fields'	=> array(
					'videos'	=> array(
						'type'         => 'form',
						'label'        => __( 'Video', 'bb-powerpack' ),
						'form'         => 'pp_video_gallery_items',
						'preview_text' => 'video_title',
						'multiple'     => true,
					)
				),
			),
		),
	),
	'options'	=> array(
		'title'		=> __( 'Options', 'bb-powerpack' ),
		'sections'	=> array(
			'common_options'	=> array(
				'title'			=> __( 'Common Options', 'bb-powerpack' ),
				'fields'		=> array(
					'autoplay'		=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Auto Play', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
					),
					'mute'			=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Mute', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
					),
					'loop'			=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Loop', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
					),
					'controls'		=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Controls', 'bb-powerpack' ),
						'help'			=> __( 'Vimeo does not support this option.', 'bb-powerpack' ),
						'default'		=> 'yes',
						'options'		=> array(
							'yes'			=> __( 'Show', 'bb-powerpack' ),
							'no'			=> __( 'Hide', 'bb-powerpack' ),
						),
					),
					'color'			=> array(
						'type'			=> 'color',
						'label'			=> __( 'Controls Color', 'bb-powerpack' ),
						'help'			=> __( 'Only works with Vimeo and Dailymotion.', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array( 'color' ),
					),
				),
			),
			'youtube_options'	=> array(
				'title'			=> __( 'YouTube Options', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'modestbranding'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Modest Branding', 'bb-powerpack' ),
						'help'			=> __( 'This option lets you use a YouTube player that does not show a YouTube logo. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player.', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
					),
					'yt_privacy'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Privacy Mode', 'bb-powerpack' ),
						'help'			=> __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'bb-powerpack' ),
						'default'		=> 'no',
						'options'		=> array(
							'yes'			=> __( 'Yes', 'bb-powerpack' ),
							'no'			=> __( 'No', 'bb-powerpack' ),
						),
					),
					'rel'		=> array(
						'type'		=> 'select',
						'label'		=> __( 'Suggested Video', 'bb-powerpack' ),
						'options'	=> array(
							''			=> __( 'Current Video Channel', 'bb-powerpack' ),
							'any'		=> __( 'Any Video', 'bb-powerpack' ),
						),
					),
				),
			),
			'vimeo_options'	=> array(
				'title'			=> __( 'Vimeo Options', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'vimeo_title'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Intro Title', 'bb-powerpack' ),
						'default'		=> 'show',
						'options'		=> array(
							'show'			=> __( 'Show', 'bb-powerpack' ),
							'hide'			=> __( 'Hide', 'bb-powerpack' ),
						),
					),
					'vimeo_portrait'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Intro Portrait', 'bb-powerpack' ),
						'default'			=> 'show',
						'options'			=> array(
							'show'				=> __( 'Show', 'bb-powerpack' ),
							'hide'				=> __( 'Hide', 'bb-powerpack' ),
						),
					),
					'vimeo_byline'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Intro Byline', 'bb-powerpack' ),
						'default'		=> 'show',
						'options'		=> array(
							'show'			=> __( 'Show', 'bb-powerpack' ),
							'hide'			=> __( 'Hide', 'bb-powerpack' ),
						),
					),
				),
			),
			'dailymotion_options'	=> array(
				'title'			=> __( 'Dailymotion Options', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'showinfo'		=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Video Info', 'bb-powerpack' ),
						'default'		=> 'show',
						'options'		=> array(
							'show'			=> __( 'Show', 'bb-powerpack' ),
							'hide'			=> __( 'Hide', 'bb-powerpack' ),
						),
					),
					'logo'			=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Logo', 'bb-powerpack' ),
						'default'		=> 'show',
						'options'		=> array(
							'show'			=> __( 'Show', 'bb-powerpack' ),
							'hide'			=> __( 'Hide', 'bb-powerpack' ),
						),
					),
				),
			),
			'hosted_options'	=> array(
				'title'			=> __( 'Self Hosted Options', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'download_button'	=> array(
						'type'				=> 'pp-switch',
						'label'				=> __( 'Download Button', 'bb-powerpack' ),
						'default'			=> 'show',
						'options'			=> array(
							'show'				=> __( 'Show', 'bb-powerpack' ),
							'hide'				=> __( 'Hide', 'bb-powerpack' ),
						),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'poster'	=> array(
						'type'		=> 'photo',
						'label'		=> __( 'Poster', 'bb-powerpack' ),
						'show_remove'	=> true,
						'connections'	=> array( 'photo' ),
					),
				),
			),
		),
	),
	'style'		=> array(
		'title'		=> __( 'Style', 'bb-powerpack' ),
		'sections'	=> array(
			'gallery_item'		=> array(
				'title'		=> __( 'Item', 'bb-powerpack' ),
				'fields'	=> array(
					'item_border'	=> array(
						'type'		=> 'border',
						'label'		=> __( 'Border', 'bb-powerpack' ),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-video-gallery-item',
						),
					),
				),
			),
			'play_icon'	=> array(
				'title'		=> __( 'Play Icon', 'bb-powerpack' ),
				'description'	=> __( 'Note: Below settings will work for Custom Play Icon only.', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'play_icon_bg_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Background Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-video-play-icon',
							'property'			=> 'background',
						),
					),
					'play_icon_bg_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Background Hover Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'play_icon_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-video-play-icon svg',
							'property'			=> 'fill',
						),
					),
					'play_icon_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Hover Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'play_icon_size'	=> array(
						'type'				=> 'unit',
						'label'				=> __( 'Size', 'bb-powerpack' ),
						'default'			=> '',
						'slider'			=> array(
							'min'				=> '10',
							'max'				=> '300',
							'step'				=> '1',
						),
						'units'				=> array( 'px' ),
						'responsive'		=> true,
					),
					'play_icon_border'	=> array(
						'type'				=> 'border',
						'label'				=> __( 'Border', 'bb-powerpack' ),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-video-play-icon'
						)
					),
					'play_icon_border_hover_color'	=> array(
						'type'		=> 'color',
						'label'		=> __( 'Border Hover Color', 'bb-powerpack' ),
						'default'	=> '',
						'connections'	=> array( 'color' ),
						'preview'	=> array(
							'type'		=> 'none',
						),
					),
				),
			),
			'lightbox_style'	=> array(
				'title'				=> __( 'Lightbox', 'bb-powerpack' ),
				'collapsed'			=> true,
				'fields'			=> array(
					'lightbox_bg_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Background Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'lightbox_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Close Button Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'lightbox_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __( 'Close Button Hover Color', 'bb-powerpack' ),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'lightbox_video_width'	=> array(
						'type'		=> 'unit',
						'label'		=> __( 'Content Width', 'bb-powerpack' ),
						'default'	=> '',
						'slider'	=> true,
						'units'		=> array( '%' ),
						'preview'	=> array(
							'type'		=> 'none',
						),
					),
					'lightbox_video_position'	=> array(
						'type'		=> 'pp-switch',
						'label'		=> __( 'Content Position', 'bb-powerpack' ),
						'default'	=> 'center',
						'options'	=> array(
							'center'	=> __( 'Center', 'bb-powerpack' ),
							'top'		=> __( 'Top', 'bb-powerpack' ),
						),
						'preview'	=> array(
							'type'		=> 'none',
						),
					),
				),
			),
			'title_style'	=> array(
				'title'			=> __( 'Video Title', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'title_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-title',
							'property'		=> 'color',
						),
					),
					'title_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Hover Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'none',
						),
					),
					'title_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Background Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-title',
							'property'		=> 'background-color',
						),
					),
					'title_bg_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Background Hover Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'none',
						),
					),
					'title_padding'	=> array(
						'type'			=> 'dimension',
						'label'			=> __( 'Padding', 'bb-powerpack' ),
						'default'		=> '',
						'slider'		=> true,
						'responsive'	=> true,
						'units'			=> array( 'px' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-title',
							'property'		=> 'padding',
							'unit'			=> 'px',
						),
					),
					'title_margin'	=> array(
						'type'			=> 'unit',
						'label'			=> __( 'Margin Top', 'bb-powerpack' ),
						'default'		=> '',
						'slider'		=> true,
						'responsive'	=> true,
						'units'			=> array( 'px' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-title',
							'property'		=> 'margin-top',
							'unit'			=> 'px',
						),
					),
				),
			),
			'filters_style'	=> array(
				'title'			=> __( 'Filters', 'bb-powerpack' ),
				'collapsed'		=> true,
				'fields'		=> array(
					'filters_align'	=> array(
						'type'			=> 'align',
						'label'			=> __( 'Alignment', 'bb-powerpack' ),
						'default'		=> 'left',
					),
					'filters_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-gallery-filter span',
							'property'		=> 'color',
						),
					),
					'filters_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Hover Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-gallery-filter.pp-filter--active span',
							'property'		=> 'color',
						),
					),
					'filters_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Background Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-gallery-filter',
							'property'		=> 'background-color',
						),
					),
					'filters_bg_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Background Hover Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-gallery-filter.pp-filter--active',
							'property'		=> 'background-color',
						),
					),
					'filters_border'	=> array(
						'type'		=> 'border',
						'label'		=> __( 'Border', 'bb-powerpack' ),
					),
					'filters_border_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Border Hover Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'none',
						),
					),
					'filters_border_on'	=> array(
						'type'		=> 'select',
						'label'		=> __( 'Apply Border On', 'bb-powerpack' ),
						'default'	=> 'active',
						'options'	=> array(
							'active'	=> __( 'Active Filter', 'bb-powerpack' ),
							'all'		=> __( 'Every Filter', 'bb-powerpack' ),
						),
					),
					'filters_padding'	=> array(
						'type'		=> 'dimension',
						'label'		=> __( 'Padding', 'bb-powerpack' ),	
						'default'	=> '',
						'slider'	=> true,
						'units'		=> array( 'px' ),
						'preview'	=> array(
							'type'		=> 'css',
							'selector'	=> '.pp-video-gallery-filter',
							'property'	=> 'padding',
							'unit'		=> 'px',
						),
					),
					'filters_margin'	=> array(
						'type'		=> 'unit',
						'label'		=> __( 'Spacing', 'bb-powerpack' ),
						'default'	=> '',
						'slider'	=> true,
						'units'		=> array( 'px' ),
					),
				),
			),
			'nav_style'	=> array(
				'title'		=> __( 'Carousel Navigation', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields' 	=> array(
					'nav_size'   => array(
						'type'          => 'unit',
						'label'         => __( 'Icon Size', 'bb-powerpack' ),
						'units'			=> array( 'px' ),
						'slider'		=> true,
						'default'       => '24',
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.pp-video-carousel .pp-video-carousel-nav',
							'property'        => 'font-size',
							'unit'            => 'px',
						),
					),
                    'nav_bg_color'       => array(
						'type'      	=> 'color',
                        'label'     	=> __( 'Background Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'default'   	=> 'rgba(255, 255, 255, 0.8)',
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-carousel .pp-video-carousel-nav',
							'property'		=> 'background-color',
						),
					),
                    'nav_bg_hover'	=> array(
						'type'      		=> 'color',
                        'label'     		=> __( 'Background Hover Color', 'bb-powerpack' ),
						'show_reset' 		=> true,
						'show_alpha'		=> true,
						'default'   		=> '4c4c4c',
						'connections'		=> array( 'color' ),
						'preview'			=> array(
							'type'				=> 'none',
						),
					),
					'nav_color'	=> array(
						'type'      	=> 'color',
						'label'     	=> __( 'Color', 'bb-powerpack' ),
						'show_reset' 	=> true,
						'default'   	=> '4c4c4c',
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-carousel .pp-video-carousel-nav:not(.swiper-button-disabled) svg',
							'property'		=> 'fill',
						),
					),
					'nav_color_hover'	=> array(
						'type'      		=> 'color',
						'label'     		=> __( 'Hover Color', 'bb-powerpack' ),
						'show_reset' 		=> true,
						'default'   		=> 'eeeeee',
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'none'
						),
					),
                    'nav_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-video-carousel .pp-video-carousel-nav',
                            'property'  	=> 'border',
                        ),
					),
                    'nav_border_hover'    => array(
						'type'      			=> 'color',
                        'label'     			=> __( 'Border Hover Color', 'bb-powerpack' ),
						'show_reset' 			=> true,
						'default'   			=> '',
						'connections'			=> array( 'color' ),
						'preview'				=> array(
							'type'					=> 'none',
						),
					),
					'nav_horizontal_padding' 	=> array(
                    	'type'          => 'unit',
						'label'         => __('Horizontal Padding', 'bb-powerpack'),
						'default'   	=> '5',
						'units'			=> array( 'px' ),
						'slider'		=> true,
						'preview'	=> array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-video-carousel .pp-video-carousel-nav',
									'property'	=> 'padding-left',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-video-carousel .pp-video-carousel-nav',
									'property'	=> 'padding-right',
									'unit'		=> 'px'
								),
							)
						),
                    ),
					'nav_vertical_padding' 	=> array(
                    	'type'          => 'unit',
						'label'         => __('Vertical Padding', 'bb-powerpack'),
						'default'   	=> '5',
						'units'			=> array( 'px' ),
						'slider'		=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'rules'			=> array(
								array(
									'selector'	=> '.pp-video-carousel .pp-video-carousel-nav',
									'property'	=> 'padding-top',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-video-carousel .pp-video-carousel-nav',
									'property'	=> 'padding-bottom',
									'unit'		=> 'px'
								),
							)
						),
                    ),
                )
			),
			'pagination_style'	=> array(
				'title'		=> __( 'Carousel Pagination', 'bb-powerpack' ),
				'collapsed'	=> true,
				'fields'	=> array(
					'pagination_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Background Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-carousel .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)',
							'property'		=> 'background-color'
						),
					),
					'pagination_active_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __( 'Active Background Color', 'bb-powerpack' ),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array( 'color' ),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-carousel .swiper-pagination-bullet.swiper-pagination-bullet-active',
							'property'		=> 'background-color'
						),
					),
				),
			),
		),
	),
	'typography'	=> array(
		'title'			=> __( 'Typography', 'bb-powerpack' ),
		'sections'		=> array(
			'title_typography'	=> array(
				'title'		=> __( 'Video Title', 'bb-powerpack' ),
				'fields'	=> array(
					'title_tag'	=> array(
						'type'		=> 'select',
						'label'		=> __( 'HTML Tag', 'bb-powerpack' ),
						'default'	=> 'div',
						'options'	=> array(
							'h1'		=> 'h1',
							'h2'		=> 'h2',
							'h3'		=> 'h3',
							'h4'		=> 'h4',
							'h5'		=> 'h5',
							'h6'		=> 'h6',
							'div'		=> 'div',
							'p'			=> 'p',
						),
					),
					'title_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __( 'Typography', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-title',
						),
					),
				),
			),
			'filters_typography'	=> array(
				'title'		=> __( 'Filters', 'bb-powerpack' ),
				'fields'	=> array(
					'filters_typography'	=> array(
						'type'			=> 'typography',
						'label'			=> __( 'Typography', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-video-gallery-filter',
						),
					),
				),
			),
		),
	),
) );

FLBuilder::register_settings_form('pp_video_gallery_items', array(
	'title' => __( 'Add Video', 'bb-powerpack' ),
	'tabs'  => array(
		'general'      => array(
			'title'         => __( 'General', 'bb-powerpack' ),
			'sections'      => array(
				'general'		=> array(
					'title'			=> __( 'General', 'bb-powerpack' ),
					'fields'		=> array(
						'video_title'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Title', 'bb-powerpack' ),
							'default'		=> '',
							'connections'	=> array( 'string', 'html' ),
						),
						'video_type'	=> array(
							'type'			=> 'select',
							'label'			=> __( 'Source', 'bb-powerpack' ),
							'options' 		=> array(
								'youtube' 		=> __( 'YouTube', 'bb-powerpack' ),
								'vimeo' 		=> __( 'Vimeo', 'bb-powerpack' ),
								'dailymotion' 	=> __( 'Dailymotion', 'bb-powerpack' ),
								'hosted' 		=> __( 'Self Hosted', 'bb-powerpack' ),
								'external'		=> __( 'External URL', 'bb-powerpack' ),
							),
							'toggle'		=> array(
								'youtube'		=> array(
									'fields'		=> array( 'youtube_url', 'end_time', 'controls', 'modestbranding', 'yt_privacy', 'rel' ),
								),
								'vimeo'		=> array(
									'fields'	=> array( 'vimeo_url', 'color', 'vimeo_title', 'vimeo_portrait', 'vimeo_byline' ),
								),
								'dailymotion'	=> array(
									'fields'		=> array( 'dailymotion_url', 'controls', 'showinfo', 'logo', 'color' ),
								),
								'hosted'	=> array(
									'fields'	=> array( 'hosted_url', 'end_time', 'controls', 'download_button', 'poster' ),
								),
								'external'	=> array(
									'fields'	=> array( 'external_url', 'end_time', 'controls', 'poster' ),
								),
							),
						),
						'youtube_url'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Link', 'bb-powerpack' ),
							'placeholder'	=> __( 'Enter YouTube URL', 'bb-powerpack' ),
							'default'		=> 'https://www.youtube.com/watch?v=A7ZkZazfvao',
							'connections'	=> array( 'url' ),
						),
						'vimeo_url'		=> array(
							'type'			=> 'text',
							'label'			=> __( 'Link', 'bb-powerpack' ),
							'placeholder'	=> __( 'Enter Viemo URL', 'bb-powerpack' ),
							'default'		=> 'https://vimeo.com/103344490',
							'connections'	=> array( 'url' ),
						),
						'dailymotion_url'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Link', 'bb-powerpack' ),
							'placeholder'	=> __( 'Enter Dailymotion URL', 'bb-powerpack' ),
							'default'		=> '',
							'connections'	=> array( 'url' ),
						),
						'hosted_url'	=> array(
							'type'			=> 'video',
							'label'			=> __( 'Choose File', 'bb-powerpack' ),
							'show_remove' 	=> true,
						),
						'external_url'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'External URL', 'bb-powerpack' ),
							'default'		=> '',
							'connections'	=> array( 'url' ),
						),
						'start_time'	=> array(
							'type'			=> 'unit',
							'label'			=> __( 'Start Time', 'bb-powerpack' ),
							'default'		=> '',
							'slider'		=> true,
							'units'			=> array( 'seconds' ),
							'help'			=> __( 'Specify a start time (in seconds)', 'bb-powerpack' ),
						),
						'end_time'		=> array(
							'type'			=> 'unit',
							'label'			=> __( 'End Time', 'bb-powerpack' ),
							'default'		=> '',
							'slider'		=> true,
							'units'			=> array( 'seconds' ),
							'help'			=> __( 'Specify a end time (in seconds)', 'bb-powerpack' ),
						),
						'filter_tags'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Tags', 'bb-powerpack' ),
							'help'			=> __( 'Enter comma separated tags to create filters.', 'bb-powerpack' ),
							'default'		=> '',
							'connections'	=> array( 'string' ),
						),
					),
				),
				'overlay'	=> array(
					'title'		=> __( 'Overlay', 'bb-powerpack' ),
					'collapsed'	=> true,
					'fields'	=> array(
						'overlay'	=> array(
							'type'		=> 'pp-switch',
							'label'		=> __( 'Overlay', 'bb-powerpack' ),
							'default'	=> 'default',
							'options'	=> array(
								'default'	=> __( 'Default', 'bb-powerpack' ),
								'custom'	=> __( 'Custom', 'bb-powerpack' ),
							),
							'toggle'	=> array(
								'custom'	=> array(
									'fields'	=> array( 'custom_overlay', 'play_icon', 'lightbox' ),
								),
							),
							'preview'	=> array(
								'type'		=> 'none',
							),
						),
						'custom_overlay'	=> array(
							'type'				=> 'photo',
							'label'				=> __( 'Custom Overlay', 'bb-powerpack' ),
							'show_remove'		=> true,
							'connections'		=> array( 'photo' ),
						),
					),
				),
			),
		),
	),
) );
