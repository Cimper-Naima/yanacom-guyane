;(function($) {
	$(".fl-node-<?php echo $id; ?> .pp-device-orientation .fas.fa-mobile").click(function(e){
		if( $(this).hasClass( 'pp-mobile-icon-portrait' ) ){
			$('.fl-node-<?php echo $id; ?> .pp-devices-wrapper').removeClass( 'pp-device-orientation-portrait' );
			$('.fl-node-<?php echo $id; ?> .pp-devices-wrapper').addClass( 'pp-device-orientation-landscape' );
			$(this).removeClass( 'pp-mobile-icon-portrait' );
			$(this).addClass( 'pp-mobile-icon-landscape' );
		}
		else if( $(this).hasClass( 'pp-mobile-icon-landscape' ) ){
			$('.fl-node-<?php echo $id; ?> .pp-devices-wrapper').removeClass( 'pp-device-orientation-landscape' );
			$('.fl-node-<?php echo $id; ?> .pp-devices-wrapper').addClass( 'pp-device-orientation-portrait' );
			$(this).addClass( 'pp-mobile-icon-portrait' );
			$(this).removeClass( 'pp-mobile-icon-landscape' );
		}
	});
	/**
 * This file should contain frontend logic for
 * all module instances.
 */


$(function() {
		var nodeclass = '.fl-node-' + '<?php echo $id; ?>';
		var $video_obj = $(nodeclass + ' .pp-video-player-source');
		var video = $(nodeclass + ' .pp-video-player-source')[0];
		var playbtn = $(nodeclass + ' .pp-player-controls-play');
		var rewindbtn = $(nodeclass + ' .pp-player-controls-rewind');
		var controls = $(nodeclass + ' .pp-video-player-controls');
		var control_bar = $(nodeclass + ' .pp-player-controls-bar');
		var fs_control = $(nodeclass + ' .pp-player-controls-fs');
		var isBuilderActive = <?php echo ( FLBuilderModel::is_builder_active() ) ? 'true' : 'false'; ?>;
		var restart_on_pause = false;
		if( ! isBuilderActive ){
			$(nodeclass + ' .pp-player-controls-rewind.pp-video-button').hide();
		}
		<?php
		if ( 'yes' === $settings->restart_on_pause ) {
			?>
				restart_on_pause = true;
			<?php
		}
		?>

		<?php
		if ( 'yes' === $settings->stop_others ) {
			?>
				$("video").on("play", function() {
					$("video").not(this).each(function(index, video) {
						plybtn = $(video).parent().find('.pp-player-controls-play');
						plybtn.removeClass('fa-pause');
						plybtn.addClass('fa-play');
						video.pause();
					});
				});
			<?php
		}
		?>
		<?php
		if ( ! empty( $settings->hover_controls_color ) ) {
			?>
				$(nodeclass + ' .pp-player-controls-bar').on("hover", function() {
					$(nodeclass + ' .pp-player-control-progress').children().css('background', '<?php echo pp_get_color_value( $settings->hover_controls_color ); ?>');
				});
				<?php
		}
		?>

		//get HTML5 video time duration
		$video_obj.on('loadedmetadata', function() {
			<?php
			if ( 'yes' === $settings->mute && 'self_hosted' === $settings->video_src ) {
				?>
				$(nodeclass + ' .pp-player-controls-volume-icon').trigger('click');
				<?php
			}
			if ( 'yes' === $settings->auto_play ) {
				?>
				playbtn.first().trigger('click');
				<?php
			}
			?>
			//playback speed.
			video.playbackRate = <?php echo $settings->playback_speed; ?>;
			var date = new Date(null);
			date.setSeconds(video.duration); // specify value for SECONDS here
			var timeString = date.toISOString().substr(11, 8);
			$( nodeclass +' .pp-player-controls-duration').text(timeString);
		});


		//update HTML5 video current play time
		$video_obj.on('timeupdate', function() {
			var currentPos = video.currentTime; //Get currenttime
			var maxduration = video.duration; //Get video duration
			var percentage = 100 * currentPos / maxduration; //in %
			$(nodeclass +' .pp-player-controls-progress-time.pp-player-control-progress-inner').css('width', percentage+'%');
			var date = new Date(null);
			date.setSeconds(video.currentTime); // specify value for SECONDS here
			timeString = date.toISOString().substr(11, 8);
			$(nodeclass +' .pp-player-controls-time').text(timeString);
		});

		//on video play
		$video_obj.on('play', function() {
			controls.fadeOut();
			control_bar.fadeOut();
			$(nodeclass +' .pp-video-player-cover.pp-player-cover').css('opacity', '0');
		});

		//on video pause
		$video_obj.on('pause', function() {
			$(nodeclass + ' .pp-player-controls-rewind.pp-video-button').show();
		});


		if( ! isBuilderActive ){
			if ( $(video).length > 0 ) {
				$(nodeclass +' .pp-device-media').hover(function(){
					controls.fadeIn();
					control_bar.fadeIn();
					$(nodeclass +' .pp-video-player-cover.pp-player-cover').css('opacity', '');
				},
				function(){
					controls.fadeOut();
					control_bar.fadeOut();
					$(nodeclass +' .pp-video-player-cover.pp-player-cover').css('opacity', '0');
				});
			}
		}

		//mute
		$(nodeclass + ' .pp-player-controls-volume-icon').click(function() {
			if( $(this).hasClass('fa-volume-up') ){
				$(this).removeClass('fa-volume-up');
				$(this).addClass('fa-volume-mute');
			}
			else if( $(this).hasClass('fa-volume-mute') ){
				$(this).removeClass('fa-volume-mute');
				$(this).addClass('fa-volume-up');
			}
			video.muted = !video.muted;
			return false;
		});

		//volume bar

		var volumeDrag = false;   /* Drag status */
		$( nodeclass + ' .pp-player-controls-volume-bar').mousedown(function(e) {
			volumeDrag = true;
			updateVolumeBar(e.pageX);
		});
		$(nodeclass + ' .pp-player-controls-volume-bar').mouseup(function(e) {
			if(volumeDrag) {
				volumeDrag = false;
				updateVolumeBar(e.pageX);
			}
		});
		$(nodeclass + ' .pp-player-controls-volume-bar').mousemove(function(e) {
			if(volumeDrag) {
				updateVolumeBar(e.pageX);
			}
		});

		//Update Volume Bar control
		var updateVolumeBar = function(x) {
			var volumebar = $( nodeclass + ' .pp-player-controls-volume-bar');

			var position = x - volumebar.offset().left; //Click pos
			var volume = position / volumebar.width();
			var percentage = 100 * volume; //in %
			//Check within range
			if(volume > 1) {
				volume = 1;
				percentage = 100;
			}
			if(volume < 0) {
				volume = 0;
				percentage = 0;
			}

			//Update volume
			video.volume = volume;
			$( nodeclass +' .pp-player-controls-volume-bar-amount.pp-player-control-progress-inner').css('width', percentage+'%');
		};


		//Rewind control
		rewindbtn.on('click', function() {
			video.currentTime = 0;
			return false;
		});

		//Full screen control
		fs_control.on('click', function() {
			// go full-screen
			if (video.requestFullscreen) {
				video.requestFullscreen();
			} else if (video.webkitRequestFullscreen) {
				video.webkitRequestFullscreen();
			} else if (video.mozRequestFullScreen) {
				video.mozRequestFullScreen();
			} else if (video.msRequestFullscreen) {
				video.msRequestFullscreen();
			}
			return false;
		});

		var timeDrag = false;   /* Drag status */
		$( nodeclass + ' .pp-player-controls-progress').mousedown(function(e) {
			timeDrag = true;
			updatebar(e.pageX);
		});
		$(nodeclass + ' .pp-player-controls-progress').mouseup(function(e) {
			if(timeDrag) {
				timeDrag = false;
				updatebar(e.pageX);
			}
		});
		$(nodeclass + ' .pp-player-controls-progress').mousemove(function(e) {
			if(timeDrag) {
				updatebar(e.pageX);
			}
		});

		//Update Progress Bar control
		var updatebar = function(x) {
			var progress = $( nodeclass + ' .pp-player-controls-progress');
			var maxduration = video.duration; //Video duraiton
			var position = x - progress.offset().left; //Click pos
			var percentage = 100 * position / progress.width();

			//Check within range
			if(percentage > 100) {
				percentage = 100;
			}
			if(percentage < 0) {
				percentage = 0;
			}

			//Update progress bar and video currenttime
			video.currentTime = maxduration * percentage / 100;
			$(nodeclass +' .pp-player-controls-progress-time.pp-player-control-progress-inner').css('width', percentage+'%');


			<?php
			if ( 'yes' === $settings->end_at_last_frame && 'no' === $settings->loop ) {
				?>
				if( 100 === percentage ){
					plybtn = $( nodeclass + ' .pp-player-controls-play');
					plybtn.removeClass('fa-pause');
					plybtn.addClass('fa-play');
				}
				<?php
			}
			?>
		};


		playbtn.on("click", function (e) {
			if ( $(nodeclass).find( '.pp-video-iframe' ).length > 0 ) {
				$(nodeclass).find( '.pp-video-iframe' )[0].src = $(nodeclass).find( '.pp-video-iframe' )[0].src.replace('&autoplay=1', '');
				$(nodeclass).find( '.pp-video-iframe' )[0].src = $(nodeclass).find( '.pp-video-iframe' )[0].src.replace('autoplay=1', '');

				$(nodeclass).find( '.pp-video-player-cover' ).fadeOut(800, function() {
					$(this).hide();
				});

				$(nodeclass).find( '.pp-video-player-controls' ).hide();

				var iframeSrc = $(nodeclass).find( '.pp-video-iframe' )[0].src.replace('&autoplay=0', '');

				iframeSrc = iframeSrc.replace('autoplay=0', '');

				var src = iframeSrc.split('#');
				iframeSrc = src[0] + '&autoplay=1';

				if ( 'undefined' !== typeof src[1] ) {
					iframeSrc += '#' + src[1];
				}

				$(nodeclass).find( '.pp-video-iframe' )[0].src = iframeSrc;

			}
			else if ( $(video).length > 0 ) {
				if( $(this).hasClass('fa-play') ) {
					video.play();
					playbtn.removeClass('fa-play');
					playbtn.addClass('fa-pause');
				}
				else if( $(this).hasClass('fa-pause') ){
					video.pause();
					playbtn.removeClass('fa-pause');
					playbtn.addClass('fa-play');
					if ( restart_on_pause ) {
						video.currentTime = 0;
					}

				}
			}
			return false;
		});


		<?php
		if ( 'self_hosted' !== $settings->video_src && '' !== $settings->embed_cover_image_src && 'yes' === $settings->auto_play ) {
			?>
			if ( $(nodeclass).find( '.pp-video-iframe' ).length > 0 ) {
				playbtn.first().click();
			}
			<?php
		}
		?>
	});

})(jQuery);
