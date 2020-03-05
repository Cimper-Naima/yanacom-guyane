<?php
/**
 * @class PPVideoModule
 */
class PPVideoModule extends FLBuilderModule {
	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'              => __( 'Video', 'bb-powerpack' ),
			'description'       => __( 'A module that displays a video player.', 'bb-powerpack' ),
			'group'             => pp_get_modules_group(),
			'category'		    => pp_get_modules_cat( 'content' ),
			'dir'               => BB_POWERPACK_DIR . 'modules/pp-video/',
			'url'               => BB_POWERPACK_URL . 'modules/pp-video/',
			'editor_export'     => true,
			'enabled'           => true,
			'partial_refresh'   => true,
		) );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		if ( isset( $this->settings ) && 'yes' === $this->settings->lightbox ) {
			$this->add_css( 'pp-jquery-fancybox' );
			$this->add_js( 'pp-jquery-fancybox' );
		}
	}

	/**
	 * Whether the video module has an overlay image or not.
	 *
	 * Used to determine whether an overlay image was set for the video.
	 *
	 * @since 2.7.2
	 *
	 * @return bool Whether an image overlay was set for the video.
	 */
	public function has_image_overlay() {
		return 'custom' === $this->settings->overlay && ! empty( $this->settings->custom_overlay );
	}

	/**
	 * Whether the video module has lightbox enabled or not.
	 *
	 * @since 2.7.2
	 *
	 * @return bool Whether the lightbox was enabled for the video.
	 */
	public function has_lightbox() {
		return 'custom' === $this->settings->overlay && 'yes' === $this->settings->lightbox;
	}

	/**
	 * Retrieve the video properties for a given video URL.
	 *
	 * @since 2.7.2
	 *
	 * @param string $video_url Video URL.
	 *
	 * @return null|array The video properties, or null.
	 */
	public function get_video_properties( $video_url ) {
		$provider_regex = array(
			'youtube' => '/^.*(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^\?&\"\'>]+)/',
			'vimeo' => '/^.*vimeo\.com\/(?:[a-z]*\/)*([‌​0-9]{6,11})[?]?.*/',
			'dailymotion' => '/^.*dailymotion.com\/(?:video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/',
		);

		foreach ( $provider_regex as $provider => $match_mask ) {
			preg_match( $match_mask, $video_url, $matches );

			if ( $matches ) {
				return array(
					'provider' => $provider,
					'video_id' => $matches[1],
				);
			}
		}

		return null;
	}

	/**
	 * Retrieve video module embed parameters.
	 *
	 * @since 2.7.2
	 *
	 * @return array Video embed parameters.
	 */
	public function get_embed_params() {
		$settings = $this->settings;
		$params = array();

		if ( 'yes' === $settings->autoplay ) {
			$params['autoplay'] = '1';
		}

		$params_dictionary = array();

		if ( 'youtube' === $settings->video_type ) {
			$params_dictionary = array(
				'loop',
				'controls',
				'mute',
				'rel',
				'modestbranding',
			);

			if ( 'yes' === $settings->loop ) {
				$video_properties = $this->get_video_properties( $settings->youtube_url );

				$params['playlist'] = $video_properties['video_id'];
			}

			$params['start'] = $settings->start_time;

			$params['end'] = $settings->end_time;

			$params['wmode'] = 'opaque';
		} elseif ( 'vimeo' === $settings->video_type ) {
			$params_dictionary = array(
				'loop',
				'mute' => 'muted',
				'vimeo_title' => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline' => 'byline',
			);

			$params['color'] = $settings->color;

			$params['autopause'] = '0';
		} elseif ( 'dailymotion' === $settings->video_type ) {
			$params_dictionary = array(
				'controls',
				'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo' => 'ui-logo',
			);

			$params['ui-highlight'] = $settings->color;

			$params['start'] = $settings->start_time;

			$params['endscreen-enable'] = '0';
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = 'yes' === $settings->{$setting_name} ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Get embed options for YouTube and Vimeo based on settings.
	 *
	 * @since 2.7.2
	 *
	 * @return array Embed options.
	 */
	public function get_embed_options() {
		$settings = $this->settings;
		$embed_options = array();

		if ( 'youtube' === $settings->video_type ) {
			$embed_options['privacy'] = 'yes' === $settings->yt_privacy;
		} elseif ( 'vimeo' === $settings->video_type ) {
			$embed_options['start'] = $settings->start_time;
		}

		return $embed_options;
	}

	/**
	 * Retrieve the embed URL for a given video.
	 *
	 * @since 2.7.2
	 *
	 * @param string $video_url        Video URL.
	 * @param array  $embed_url_params Optional. Embed parameters. Default is an
	 *                                 empty array.
	 * @param array  $options          Optional. Embed options. Default is an
	 *                                 empty array.
	 *
	 * @return null|array The video properties, or null.
	 */
	public function get_embed_url( $video_url, array $embed_url_params = array(), array $options = array() ) {
		$video_properties = $this->get_video_properties( $video_url );

		if ( ! $video_properties ) {
			return null;
		}

		$embed_patterns = array(
			'youtube' 		=> 'https://www.youtube{NO_COOKIE}.com/embed/{VIDEO_ID}?feature=oembed',
			'vimeo' 		=> 'https://player.vimeo.com/video/{VIDEO_ID}#t={TIME}',
			'dailymotion' 	=> 'https://dailymotion.com/embed/video/{VIDEO_ID}',
		);

		$embed_pattern = $embed_patterns[ $video_properties['provider'] ];

		$replacements = array(
			'{VIDEO_ID}' => $video_properties['video_id'],
		);

		if ( 'youtube' === $video_properties['provider'] ) {
			$replacements['{NO_COOKIE}'] = ! empty( $options['privacy'] ) ? '-nocookie' : '';
		} elseif ( 'vimeo' === $video_properties['provider'] ) {
			$time_text = '';

			if ( ! empty( $options['start'] ) ) {
				$time_text = date( 'H\hi\ms\s', $options['start'] );
			}

			$replacements['{TIME}'] = $time_text;
		}

		$embed_pattern = str_replace( array_keys( $replacements ), $replacements, $embed_pattern );

		return add_query_arg( $embed_url_params, $embed_pattern );
	}

	/**
	 * Get embed HTML.
	 *
	 * Retrieve the final HTML of the embedded URL.
	 *
	 * @since 2.7.2
	 *
	 * @param string $video_url        Video URL.
	 * @param array  $embed_url_params Optional. Embed parameters. Default is an
	 *                                 empty array.
	 * @param array  $options          Optional. Embed options. Default is an
	 *                                 empty array.
	 * @param array  $frame_attributes Optional. IFrame attributes. Default is an
	 *                                 empty array.
	 *
	 * @return string The embed HTML.
	 */
	public function get_embed_html( $video_url, array $embed_url_params = array(), array $options = array(), array $frame_attributes = array() ) {
		$default_frame_attributes = array(
			'class' => 'pp-video-iframe',
			'allowfullscreen',
			'allow'	=> 'autoplay',
		);

		$video_embed_url = $this->get_embed_url( $video_url, $embed_url_params, $options );
		if ( ! $video_embed_url ) {
			return null;
		}
		if ( ! isset( $options['lazy_load'] ) || ! $options['lazy_load'] ) {
			$default_frame_attributes['src'] = $video_embed_url;
		} else {
			$default_frame_attributes['data-lazy-load'] = $video_embed_url;
		}

		$frame_attributes = array_merge( $default_frame_attributes, $frame_attributes );

		$attributes_for_print = array();

		foreach ( $frame_attributes as $attribute_key => $attribute_value ) {
			$attribute_value = esc_attr( $attribute_value );

			if ( is_numeric( $attribute_key ) ) {
				$attributes_for_print[] = $attribute_value;
			} else {
				$attributes_for_print[] = sprintf( '%1$s="%2$s"', $attribute_key, $attribute_value );
			}
		}

		$attributes_for_print = implode( ' ', $attributes_for_print );

		$iframe_html = "<iframe $attributes_for_print></iframe>";

		/** This filter is documented in wp-includes/class-oembed.php */
		return apply_filters( 'oembed_result', $iframe_html, $video_url, $frame_attributes );
	}

	/**
	 * Get URL of video.
	 *
	 * @since 2.7.2
	 *
	 * @return string|bool Video URL or false.
	 */
	public function get_video_url() {
		$settings = $this->settings;
		$video_type = $settings->video_type;

		if ( 'hosted' == $video_type || 'external' == $video_type ) {
			return $this->get_hosted_video_url();
		}
		if ( isset( $settings->{$video_type . '_url'} ) ) {
			return $settings->{$video_type . '_url'};
		}

		return false;
	}

	/**
	 * Get HTML of video to render.
	 *
	 * @since 2.7.2
	 *
	 * @return string Video HTML.
	 */
	public function get_video_html() {
		$settings = $this->settings;
		$video_url = $this->get_video_url();
		$video_html = '';

		if ( ! $video_url ) {
			return $video_html;
		}

		if ( 'hosted' === $settings->video_type || 'external' === $settings->video_type ) {
			ob_start();

			$this->render_hosted_video();

			$video_html = ob_get_clean();
		} else {
			$embed_params = $this->get_embed_params();

			$embed_options = $this->get_embed_options();

			$video_html = $this->get_embed_html( $video_url, $embed_params, $embed_options );
		}

		return $video_html;
	}

	/**
	 * Get parameters for hosted video.
	 *
	 * @since 2.7.2
	 *
	 * @return array Video parameters.
	 */
	public function get_hosted_params() {
		$settings = $this->settings;
		$video_params = array();

		foreach ( array( 'autoplay', 'loop' ) as $option_name ) {
			if ( 'yes' === $settings->{$option_name} ) {
				$video_params[ $option_name ] = '';
				if ( 'autoplay' == $option_name ) {
					$video_params['webkit-playsinline'] = '';
					$video_params['playsinline'] = '';
				}
			}
		}

		if ( 'yes' === $settings->controls ) {
			$video_params['controls'] = '';
		}

		if ( 'yes' === $settings->mute ) {
			$video_params['muted'] = 'muted';
		}

		if ( 'hide' === $settings->download_button ) {
			$video_params['controlsList'] = 'nodownload';
		}

		if ( isset( $settings->poster_src ) ) {
			$video_params['poster'] = $settings->poster_src;
			$video_params['preload'] = 'none';
		}

		return $video_params;
	}

	/**
	 * Get URL of hosted video with time parameter.
	 *
	 * @since 2.7.2
	 *
	 * @return string Video URL.
	 */
	public function get_hosted_video_url() {
		$settings = $this->settings;

		if ( 'external' === $settings->video_type ) {
			$video_url = $settings->external_url;
		} else {
			$video_data = FLBuilderPhoto::get_attachment_data( $settings->hosted_url );
			$video_url = $video_data->url;
		}

		if ( empty( $video_url ) ) {
			return '';
		}

		if ( $settings->start_time || $settings->end_time ) {
			$video_url .= '#t=';
		}

		if ( $settings->start_time ) {
			$video_url .= $settings->start_time;
		}

		if ( $settings->end_time ) {
			$video_url .= ',' . $settings->end_time;
		}

		return $video_url;
	}

	/**
	 * Render hosted video.
	 *
	 * @since 2.7.2
	 *
	 * @return void
	 */
	public function render_hosted_video() {
		$video_url = $this->get_hosted_video_url();
		if ( empty( $video_url ) ) {
			return;
		}

		$video_params = $this->get_hosted_params();
		?>
		<video class="pp-video-player" src="<?php echo esc_url( $video_url ); ?>" <?php echo $this->render_html_attributes( $video_params ); ?>></video>
		<?php
	}

	/**
	 * Render html attributes
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public function render_html_attributes( array $attributes ) {
		$rendered_attributes = array();

		foreach ( $attributes as $attribute_key => $attribute_values ) {
			if ( is_array( $attribute_values ) ) {
				$attribute_values = implode( ' ', $attribute_values );
			}

			$rendered_attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( $attribute_values ) );
		}

		return implode( ' ', $rendered_attributes );
	}

	/**
	 * Get structured data - https://schema.org/VideoObject
	 *
	 * @param object $settings
	 *
	 * @return string
	 */
	public function get_structured_data( $settings = null ) {
		$settings = ! is_object( $settings ) ? $this->settings : $settings;
		
		if ( ! isset( $settings->schema_enabled ) || 'no' == $settings->schema_enabled ) {
			return false;
		}

		$markup = '';
		$url 	= $this->get_video_url();

		if ( '' == $settings->video_title || '' == $settings->video_desc || '' == $settings->video_thumbnail || '' == $settings->video_upload_date ) {
			return false;
		}
	
		$markup .= sprintf( '<meta itemprop="name" content="%s" />', esc_attr( $settings->video_title ) );
		$markup .= sprintf( '<meta itemprop="description" content="%s" />', esc_attr( $settings->video_desc ) );
		$markup .= sprintf( '<meta itemprop="uploadDate" content="%s" />', esc_attr( $settings->video_upload_date ) );
		$markup .= sprintf( '<meta itemprop="thumbnailUrl" content="%s" />', $settings->video_thumbnail_src );

		if ( ! empty( $url ) ) {
			$markup .= sprintf( '<meta itemprop="contentUrl" content="%s" />', $url );
			$markup .= sprintf( '<meta itemprop="embedUrl" content="%s" />', $url );
		}

		return $markup;
	}
}

FLBuilder::register_module(
	'PPVideoModule',
	array(
		'general' => array(
			'title'		=> __( 'General', 'bb-powerpack' ),
			'sections'	=> array(
				'general'	=> array(
					'title'		=> '',
					'fields'	=> array(
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
									'fields'		=> array( 'youtube_url', 'end_time', 'loop', 'controls', 'modestbranding', 'yt_privacy', 'rel' ),
								),
								'vimeo'		=> array(
									'fields'	=> array( 'vimeo_url', 'loop', 'color', 'vimeo_title', 'vimeo_portrait', 'vimeo_byline' ),
								),
								'dailymotion'	=> array(
									'fields'		=> array( 'dailymotion_url', 'controls', 'showinfo', 'logo', 'color' ),
								),
								'hosted'	=> array(
									'fields'	=> array( 'hosted_url', 'end_time', 'loop', 'controls', 'download_button', 'poster' ),
								),
								'external'	=> array(
									'fields'	=> array( 'external_url', 'end_time', 'loop', 'controls', 'poster' ),
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
				'video_options'	=> array(
					'title'			=> __( 'Video Options', 'bb-powerpack' ),
					'collapsed'		=> true,
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
							'default'		=> 'yes',
							'options'		=> array(
								'yes'			=> __( 'Show', 'bb-powerpack' ),
								'no'			=> __( 'Hide', 'bb-powerpack' ),
							),
						),
						'showinfo'		=> array(
							'type'			=> 'pp-switch',
							'label'			=> __( 'Video Info', 'bb-powerpack' ),
							'default'		=> 'show',
							'options'		=> array(
								'show'			=> __( 'Show', 'bb-powerpack' ),
								'hide'			=> __( 'Hide', 'bb-powerpack' ),
							),
						),
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
						'logo'			=> array(
							'type'			=> 'pp-switch',
							'label'			=> __( 'Logo', 'bb-powerpack' ),
							'default'		=> 'show',
							'options'		=> array(
								'show'			=> __( 'Show', 'bb-powerpack' ),
								'hide'			=> __( 'Hide', 'bb-powerpack' ),
							),
						),
						'color'			=> array(
							'type'			=> 'color',
							'label'			=> __( 'Controls Color', 'bb-powerpack' ),
							'default'		=> '',
							'show_reset'	=> true,
							'connections'	=> array( 'color' ),
						),
						'yt_privacy'	=> array(
							'type'			=> 'pp-switch',
							'label'			=> __( 'Privacy Mode', 'bb-powerpack' ),
							'help'			=> __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'bb-powerpack' ),
							'default'		=> 'no',
							'options'		=> array(
								'yes'			=> __( 'Yes', 'bb-powerpack' ),
								'no'			=> __( 'No', 'bb-powerpack' )
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
						),
						'custom_overlay'	=> array(
							'type'				=> 'photo',
							'label'				=> __( 'Custom Overlay', 'bb-powerpack' ),
							'show_remove'		=> true,
						),
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
			),
		),
		'style'   => array(
			'title'       => __( 'Style', 'bb-powerpack' ),
			'description' => __( 'Styling options are available for Play Icon and Lightbox. You will need to enable them under General > Overlay > Custom.', 'bb-powerpack' ),
			'sections'    => array(
				'general_style'  => array(
					'title'  => __( 'Box Style', 'bb-powerpack' ),
					'fields' => array(
						'box_border' => array(
							'type'    => 'border',
							'label'   => __( 'Border', 'bb-powerpack' ),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.pp-video-wrapper',
							),
						),
					),
				),
				'play_icon'	     => array(
					'title'		=> __( 'Custom Play Icon', 'bb-powerpack' ),
					'collapsed' => true,
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
				'lightbox_style' => array(
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
			),
		),
		'structured_data'	=> array(
			'title'		=> __( 'Structured Data', 'bb-powerpack' ),
			'sections'	=> array(
				'video_info'	=> array(
					'title'			=> '',
					'fields'		=> array(
						'schema_enabled'	=> array(
							'type'		=> 'pp-switch',
							'label'		=> __( 'Enable Structured Data?', 'bb-powerpack' ),
							'default'	=> 'no',
							'options'	=> array(
								'yes'		=> __( 'Yes', 'bb-powerpack' ),
								'no'		=> __( 'No', 'bb-powerpack' ),
							),
							'toggle'	=> array(
								'yes'		=> array(
									'fields'	=> array( 'video_title', 'video_desc', 'video_thumbnail', 'video_upload_date' ),
								),
							),
						),
						'video_title'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Video Title', 'bb-powerpack' ),
							'default'		=> '',
							'connections'	=> array( 'string' ),
							'preview' 		=> array(
								'type' 			=> 'none',
							),
						),
						'video_desc'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Video Description', 'bb-powerpack' ),
							'default'		=> '',
							'connections'	=> array( 'string' ),
							'preview' 		=> array(
								'type' 			=> 'none',
							),
						),
						'video_thumbnail'	=> array(
							'type'			=> 'photo',
							'label'			=> __( 'Video Thumbnail', 'bb-powerpack' ),
							'show_remove'	=> true,
							'connections'	=> array( 'photo' ),
							'preview' 		=> array(
								'type' 			=> 'none',
							),
						),
						'video_upload_date'	=> array(
							'type'   		=> 'date',
							'label'   		=> __( 'Upload Date', 'bb-powerpack' ),
							'connections'	=> array( 'string' ),
							'preview' 		=> array(
								'type' 			=> 'none',
							),
						),
					),
				),
			),
		),
	)
);
