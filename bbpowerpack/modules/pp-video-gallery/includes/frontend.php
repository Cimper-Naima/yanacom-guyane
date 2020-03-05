<?php
$layout = $module->get_layout();
$videos = $settings->videos;
$filters_enabled = $module->filters_enabled();

$wrapper_classes = array(
	'pp-video-gallery',
);

$items_classes = array(
	'pp-video-gallery-items'
);

if ( empty( $videos ) ) {
	return;
}

if ( 'carousel' === $layout ) {
	$wrapper_classes[] = 'pp-video-carousel';
	$wrapper_classes[] = 'swiper-container';
	$items_classes[] = 'swiper-wrapper';
}
?>
<div class="<?php echo implode( ' ', $wrapper_classes ); ?>">

	<?php
	// Render filters.
	if ( 'gallery' === $layout ) {
		$module->render_filters();
	}
	?>

	<div class="<?php echo implode( ' ', $items_classes ); ?>">
		<?php foreach ( $videos as $video ) {
			if ( ! is_object( $video ) ) {
				continue;
			}

			$item_classes = array(
				'pp-video-gallery-item'
			);

			if ( 'custom' === $video->overlay && ! empty( $video->custom_overlay ) ) {
				$item_classes[] = 'pp-video-has-overlay';
			}
			if ( 'carousel' === $layout ) {
				$item_classes[] = 'swiper-slide';
			}

			if ( $filters_enabled ) {
				$tags = $module->get_tags_array( $video );
				foreach ( array_keys( $tags ) as $tag_name ) {
					$item_classes[] = 'pp-filter-' . $tag_name;
				}
			}
		?>
		<div class="<?php echo implode( ' ', $item_classes ); ?>">
			<div class="pp-video">
				<?php
				if ( 'above' === $settings->info_position ) {
					$module->render_video_info( $video );
				}
				?>
				<?php
					FLBuilder::render_module_html( 'pp-video', array(
						'video_type'		=> $video->video_type,
						'youtube_url'		=> $video->youtube_url,
						'vimeo_url'			=> $video->vimeo_url,
						'dailymotion_url'	=> $video->dailymotion_url,
						'hosted_url'		=> $video->hosted_url,
						'external_url'		=> $video->external_url,
						'start_time'		=> $video->start_time,
						'end_time'			=> $video->end_time,
						'aspect_ratio'		=> $settings->aspect_ratio,
						'autoplay'			=> $settings->autoplay,
						'mute'				=> $settings->mute,
						'loop'				=> $settings->loop,
						'controls'			=> $settings->controls,
						'showinfo'			=> $settings->showinfo,
						'modestbranding'	=> $settings->modestbranding,
						'logo'				=> $settings->logo,
						'color'				=> $settings->color,
						'yt_privacy'		=> $settings->yt_privacy,
						'rel'				=> $settings->rel,
						'vimeo_title'		=> $settings->vimeo_title,
						'vimeo_portrait'	=> $settings->vimeo_portrait,
						'vimeo_byline'		=> $settings->vimeo_byline,
						'download_button'	=> $settings->download_button,
						'poster'			=> $settings->poster,
						'poster_src'		=> $settings->poster_src,
						'overlay'			=> $video->overlay,
						'custom_overlay'	=> $video->custom_overlay,
						'custom_overlay_src'	=> $video->custom_overlay_src,
						'play_icon'			=> $settings->play_icon,
						'lightbox'			=> $settings->lightbox,
					) );
				?>
				<?php
				if ( 'below' === $settings->info_position ) {
					$module->render_video_info( $video );
				}
				?>
			</div>
		</div>
		<?php } // End foreach(). ?>
		<?php if ( 'gallery' === $layout ) { ?>
			<div class="pp-video-gallery--spacer"></div>
		<?php } ?>
	</div>
	<?php if ( 'carousel' === $layout && 1 < count( $videos ) ) { ?>
		<?php if ( $settings->pagination_type ) { ?>
			<div class="swiper-pagination"></div>
		<?php } ?>

		<?php if ( 'yes' === $settings->slider_navigation ) { ?>
			<div class="pp-video-carousel-nav pp-video-carousel-nav-prev">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.28 15.7l-1.34 1.37L5 12l4.94-5.07 1.34 1.38-2.68 2.72H19v1.94H8.6z"/></svg>
			</div>
			<div class="pp-video-carousel-nav pp-video-carousel-nav-next">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.4 12.97l-2.68 2.72 1.34 1.38L19 12l-4.94-5.07-1.34 1.38 2.68 2.72H5v1.94z"/></svg>
			</div>
		<?php } ?>
	<?php } ?>
</div>
