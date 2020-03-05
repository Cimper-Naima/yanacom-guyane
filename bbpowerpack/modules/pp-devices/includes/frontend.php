<?php

if ( 'video' === $settings->media_type && 'self_hosted' !== $settings->video_src ) {
	//Embedded video html.
	$video_html = $module->get_video_html();
}


$image_src = BB_POWERPACK_URL . 'images/default-img.jpg';
if ( '' !== $settings->image_src ) {
	$image_src = $settings->image_src;
}
$device_classes = $device_type_class = '';
if ( 'landscape' === $settings->orientation && ( 'phone' === $settings->device_type || 'tablet' === $settings->device_type ) ) {
	$device_classes .= ' pp-device-orientation-landscape';
} else {
	$device_classes .= ' pp-device-orientation-portrait';
}
if ( 'phone' === $settings->device_type ) {
	$device_type_class = 'pp-device-phone';
} elseif ( 'tablet' === $settings->device_type ) {
	$device_type_class = 'pp-device-tablet';
} elseif ( 'laptop' === $settings->device_type ) {
	$device_type_class = 'pp-device-laptop';
} elseif ( 'desktop' === $settings->device_type ) {
	$device_type_class = 'pp-device-desktop';
} elseif ( 'window' === $settings->device_type ) {
	$device_type_class = 'pp-device-window';
}
$has_orientation_control_class = '';
if ( 'show' === $settings->orientation_control && ( 'phone' === $settings->device_type || 'tablet' === $settings->device_type ) ) {
	$has_orientation_control_class = ' has-orientation-control';
}

$tone_class = '';
if ( 'yes' === $settings->override_style ) {
	if ( 'light' === $settings->tone ) {
		$tone_class = ' light-tone';
	} elseif ( 'dark' === $settings->tone ) {
		$tone_class = ' dark-tone';
	}
}

$scrollable_class = '';
if ( 'yes' === $settings->scrollable ) {
	$scrollable_class = 'pp-scrollable';
}


$image_fit_class = '';
if ( ( 'contain' !== $settings->image_fit || 'landscape' === $settings->orientation ) && 'image' === $settings->media_type ) {
	$image_fit_class = 'pp-image-fit';
}

?>
<div class="pp-devices-content">
	<div class="pp-devices-wrapper <?php echo $device_classes; ?> ">
		<div class="pp-device-wrap <?php echo $device_type_class; ?>" >
			<div class="pp-device <?php echo $has_orientation_control_class; ?> <?php echo $tone_class; ?>">

				<div class="pp-device-shape" >
					<?php
						require BB_POWERPACK_DIR . 'modules/pp-devices/includes/svg/' . $settings->device_type . '.svg';
					?>
				</div>
				<div class="pp-device-media <?php echo $image_fit_class; ?>" >
					<div class="pp-device-media-inner">
						<?php
						if ( 'image' === $settings->media_type ) {
							if ( 'portrait' === $settings->orientation ) {
								?>
							<div class="pp-device-media-screen pp-device-media-screen-image <?php echo $scrollable_class; ?> ">
								<div class="pp-device-media-screen-inner">
									<figure><img src="<?php echo $image_src; ?>" ></figure>
								</div><!-- .pp-device-media-screen-inner -->
							</div><!-- .pp-device-media-screen -->
								<?php
							} elseif ( 'landscape' === $settings->orientation ) {
								?>
							<div class="pp-device-media-screen pp-device-media-screen-landscape <?php echo $scrollable_class; ?>">
								<div class="pp-device-media-screen-inner">
									<figure>
										<img width="801" height="801" src="<?php echo $image_src; ?>" class="attachment-large size-large" alt="">
									</figure>
								</div>
							</div>
								<?php
							}
						} elseif ( 'video' === $settings->media_type ) {
							$mp4_video_url  = '';
							$m4v_video_url  = '';
							$ogg_video_url  = '';
							$webm_video_url = '';

							if ( 'url' === $settings->mp4_video_source ) {
								$mp4_video_url = $settings->mp4_video_url;
							} elseif ( 'file' === $settings->mp4_video_source ) {
								$mp4_video_url = wp_get_attachment_url( $settings->mp4_video );
							}

							if ( 'url' === $settings->m4v_video_source ) {
								$m4v_video_url = $settings->m4v_video_url;
							} elseif ( 'file' === $settings->m4v_video_source ) {
								$m4v_video_url = wp_get_attachment_url( $settings->m4v_video );
							}

							if ( 'url' === $settings->ogg_video_source ) {
								$ogg_video_url = $settings->ogg_video_url;
							} elseif ( 'file' === $settings->ogg_video_source ) {
								$ogg_video_url = wp_get_attachment_url( $settings->ogg_video );
							}

							if ( 'url' === $settings->webm_video_source ) {
								$webm_video_url = $settings->webm_video_url;
							} elseif ( 'file' === $settings->webm_video_source ) {
								$webm_video_url = wp_get_attachment_url( $settings->webm_video );
							}

							$loop = '';
							if ( 'yes' === $settings->loop ) {
								$loop = 'loop';
							}

							?>
							<div  class="pp-device-media-screen pp-device-media-screen-video">
								<div class="pp-device-media-screen-inner">
									<div class="pp-video-player pp-player">
									<?php if ( 'self_hosted' === $settings->video_src ) { ?>
										<video class="pp-video-player-source pp-player-source" poster="<?php echo $settings->cover_image_src; ?>" <?php echo $loop; ?> >
											<?php
											if ( '' !== $mp4_video_url ) {
												?>
													<source src="<?php echo $mp4_video_url; ?>" type="video/mp4">
													<?php
											}
											if ( '' !== $m4v_video_url ) {
												?>
													<source src="<?php echo $m4v_video_url; ?>" type="video/x-m4v">
													<?php
											}
											if ( '' !== $ogg_video_url ) {
												?>
													<source src="<?php echo $ogg_video_url; ?>" type="video/ogg">
													<?php
											}
											if ( '' !== $webm_video_url ) {
												?>
													<source src="<?php echo $webm_video_url; ?>" type="video/webm">
													<?php
											}
											?>
										</video>
										<?php
									} else {
										echo $video_html;
									}
									?>
										<div class="pp-video-player-cover pp-player-cover">
										</div>
										<div class="pp-video-player-controls pp-player-controls">
											<div class="pp-player-controls-overlay pp-video-player-overlay">
												<div class="pp-video-buttons">
													<?php if ( 'self_hosted' === $settings->video_src ) { ?>
													<i class="fas fa-redo pp-player-controls-rewind pp-video-button" title="<?php echo __( 'Rewind', 'bb-powerpack' ); ?>"></i>
													<?php } ?>
													<i class="fas fa-play pp-player-controls-play pp-video-button" title="<?php echo __( 'Play / Pause', 'bb-powerpack' ); ?>"></i>
												</div>
											</div>
										</div>
										<?php if ( 'self_hosted' === $settings->video_src ) { ?>
										<div class="pp-player-controls-bar-wrapper pp-video-player-controls-bar-wrapper">
											<div class="pp-player-controls-bar">
												<i class="pp-player-controls-rewind pp-player-control-icon fas fa-redo" title="<?php echo __( 'Rewind', 'bb-powerpack' ); ?>"></i>
												<i class="pp-player-controls-play pp-player-control-icon fas fa-play" title="<?php echo __( 'Play / Pause', 'bb-powerpack' ); ?>"></i>

												<div class="pp-player-control-indicator pp-player-controls-time">00:00:00</div>

												<div class="pp-player-controls-progress pp-player-control-progress">
													<div class="pp-player-control-progress-outer pp-player-control-progress-track"></div>
													<div class="pp-player-controls-progress-time pp-player-control-progress-inner"></div>
												</div>

												<div class="pp-player-controls-duration pp-player-control-indicator">00:00:05</div>

												<div class="pp-player-controls-volume">

													<i class="pp-player-controls-volume-icon pp-player-control-icon fas fa-volume-up" title="<?php echo __( 'Volume', 'bb-powerpack' ); ?>"></i>

													<div class="pp-player-controls-volume-bar pp-player-control-progress">
														<div class="pp-player-controls-volume-bar-amount pp-player-control-progress-inner" style="width: 100%;"></div>
														<div class="pp-player-controls-volume-bar-track pp-player-control-progress-outer pp-player-control-progress-track"></div>
													</div>
												</div>
												<i class="pp-player-controls-fs pp-player-control-icon fas fa-expand" title="<?php echo __( 'Expand', 'bb-powerpack' ); ?>"></i>
											</div>
										</div>
									<?php } ?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
				if ( 'show' === $settings->orientation_control && ( 'phone' === $settings->device_type || 'tablet' === $settings->device_type ) ) {
					$mobile_icon_class = 'pp-mobile-icon-portrait';
					if ( 'landscape' === $settings->orientation ) {
						$mobile_icon_class = 'pp-mobile-icon-landscape';
					}
					?>
				<div class="pp-device-orientation"><i class="<?php echo $mobile_icon_class; ?> fas fa-mobile" aria-hidden="true"></i></div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
