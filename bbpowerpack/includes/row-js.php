<?php

function pp_row_render_js( $extensions ) {

	if ( array_key_exists( 'expandable', $extensions['row'] ) || in_array( 'expandable', $extensions['row'] ) ) {
		add_filter( 'fl_builder_render_js', 'pp_row_expandable_js', 10, 3 );
	}
	if ( array_key_exists( 'downarrow', $extensions['row'] ) || in_array( 'downarrow', $extensions['row'] ) ) {
		add_filter( 'fl_builder_render_js', 'pp_row_downarrow_js', 10, 3 );
	}
	if ( array_key_exists( 'background_effect', $extensions['row'] ) || in_array( 'background_effect', $extensions['row'] ) ) {
		add_filter( 'fl_builder_render_js', 'pp_infinite_bg_js', 10, 3 );
		add_filter( 'fl_builder_render_js', 'pp_animated_bg_js', 10, 3 );
	}
}

/**
 * Animated Background
 */
function pp_animated_bg_js( $js, $nodes, $global_settings ) {
	$anim_array              = array();
	$anim_three_enqueued     = false;
	$anim_particles_enqueued = false;

	foreach ( $nodes['rows'] as $row ) {
		if ( isset( $row->settings->bg_type ) && 'pp_animated_bg' === $row->settings->bg_type ) {
			ob_start();

			$hide_tablet = isset( $row->settings->bg_hide_tablet ) && ! empty( $row->settings->bg_hide_tablet ) ? $row->settings->bg_hide_tablet : '';
			$hide_mobile = isset( $row->settings->bg_hide_mobile ) && ! empty( $row->settings->bg_hide_mobile ) ? $row->settings->bg_hide_mobile : '';
			$bp_tablet   = ! empty( $global_settings->medium_breakpoint ) ? $global_settings->medium_breakpoint : 1025;
			$bp_mobile   = ! empty( $global_settings->responsive_breakpoint ) ? $global_settings->responsive_breakpoint : 768;
			$max_width   = 'none';
			$min_width   = 'none';

			if ( 'yes' === $hide_tablet && 'yes' !== $hide_mobile ) {
				$max_width = $bp_tablet;
				$min_width = $bp_mobile;
			} elseif ( 'yes' !== $hide_tablet && 'yes' === $hide_mobile ) {
				$max_width = $bp_mobile - 1;
				$min_width = 0;
			} elseif ( 'yes' === $hide_tablet && 'yes' === $hide_mobile ) {
				$max_width = $bp_tablet;
				$min_width = 0;
			}
			?>
			var winWidth = jQuery( window ).width();
			<?php if ( 'none' !== $max_width || 'none' !== $min_width ) { ?>
			if ( winWidth > <?php echo $max_width; ?> || winWidth < <?php echo $min_width; ?> ) {
			<?php } ?>		
				setTimeout(function(){
				<?php
				if ( isset( $row->settings->animation_type ) ) {
					$anim_type = $row->settings->animation_type;

					if ( 'particles' === $anim_type || 'nasa' === $anim_type || 'bubble' === $anim_type || 'snow' === $anim_type || 'custom' === $anim_type ) {
						if ( ! $anim_particles_enqueued ) {
							include BB_POWERPACK_DIR . 'assets/js/particles.min.js';
							$anim_particles_enqueued = true;
						}
					} else {
						if ( ! $anim_three_enqueued ) {
							include BB_POWERPACK_DIR . 'assets/js/three.r92.min.js';
							$anim_three_enqueued = true;
						}

						if ( ! in_array( $anim_type, $anim_array ) && file_exists( BB_POWERPACK_DIR . 'assets/js/vanta.' . $anim_type . '.min.js' ) ) {
							include BB_POWERPACK_DIR . 'assets/js/vanta.' . $anim_type . '.min.js';
						}
					}
					$anim_array[] = $anim_type;
					?>
					;(function($) {
						<?php if( 'birds' == $anim_type ) { ?>
							VANTA.BIRDS({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->bird_bg_color) && !empty($row->settings->bird_bg_color) ? 'backgroundColor: 0x' . $row->settings->bird_bg_color .',' : ''; ?>
								<?php echo isset($row->settings->bird_bg_opacity) && !empty($row->settings->bird_bg_opacity) ? 'backgroundAlpha: ' . $row->settings->bird_bg_opacity .',' : ''; ?>
								<?php echo isset($row->settings->bird_color_1) && !empty($row->settings->bird_color_1) ? 'color1: 0x' . $row->settings->bird_color_1 .',' : ''; ?>
								<?php echo isset($row->settings->bird_color_2) && !empty($row->settings->bird_color_2) ? 'color2: 0x' . $row->settings->bird_color_2 .',' : ''; ?>
								<?php echo isset($row->settings->bird_color_mode) && !empty($row->settings->bird_color_mode) ? 'colorMode: "' . $row->settings->bird_color_mode .'",' : ''; ?>
								<?php echo isset($row->settings->bird_quantity) && !empty($row->settings->bird_quantity) ? 'quantity: ' . $row->settings->bird_quantity .',' : ''; ?>
								<?php echo isset($row->settings->bird_size) && !empty($row->settings->bird_size) ? 'birdSize: ' . $row->settings->bird_size .',' : ''; ?>
								<?php echo isset($row->settings->bird_wing_span) && !empty($row->settings->bird_wing_span) ? 'wingSpan: ' . $row->settings->bird_wing_span .',' : ''; ?>
								<?php echo isset($row->settings->bird_speed_limit) && !empty($row->settings->bird_speed_limit) ? 'speedLimit: ' . $row->settings->bird_speed_limit .',' : ''; ?>
								<?php echo isset($row->settings->bird_separation) && !empty($row->settings->bird_separation) ? 'separation: ' . $row->settings->bird_separation .',' : ''; ?>
								<?php echo isset($row->settings->bird_alignment) && !empty($row->settings->bird_alignment) ? 'alignment: ' . $row->settings->bird_alignment .',' : ''; ?>
								<?php echo isset($row->settings->bird_cohesion) && !empty($row->settings->bird_cohesion) ? 'cohesion: ' . $row->settings->bird_cohesion .',' : ''; ?>
							});
						<?php }elseif( 'fog' == $anim_type ) { ?>
							VANTA.FOG({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->fog_highlight_color) && !empty($row->settings->fog_highlight_color) ? 'highlightColor: 0x' . $row->settings->fog_highlight_color .',' : ''; ?>
								<?php echo isset($row->settings->fog_midtone_color) && !empty($row->settings->fog_midtone_color) ? 'midtoneColor: 0x' . $row->settings->fog_midtone_color .',' : ''; ?>
								<?php echo isset($row->settings->fog_lowlight_color) && !empty($row->settings->fog_lowlight_color) ? 'lowlightColor: 0x' . $row->settings->fog_lowlight_color .',' : ''; ?>
								<?php echo isset($row->settings->fog_base_color) && !empty($row->settings->fog_base_color) ? 'baseColor: 0x' . $row->settings->fog_base_color .',' : ''; ?>
								<?php echo isset($row->settings->fog_blur_factor) && !empty($row->settings->fog_blur_factor) ? 'blurFactor: ' . $row->settings->fog_blur_factor .',' : ''; ?>
								<?php echo isset($row->settings->fog_zoom) && !empty($row->settings->fog_zoom) ? 'zoom: ' . $row->settings->fog_zoom .',' : ''; ?>
								<?php echo isset($row->settings->fog_speed) && !empty($row->settings->fog_speed) ? 'speed: ' . $row->settings->fog_speed .',' : ''; ?>
							});
						<?php }elseif( 'waves' == $anim_type ) { ?>
							VANTA.WAVES({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->waves_color) && !empty($row->settings->waves_color) ? 'color: 0x' . $row->settings->waves_color .',' : ''; ?>
								<?php echo isset($row->settings->waves_shininess) && !empty($row->settings->waves_shininess) ? 'shininess: ' . $row->settings->waves_shininess .',' : ''; ?>
								<?php echo isset($row->settings->waves_height) && !empty($row->settings->waves_height) ? 'waveHeight: ' . $row->settings->waves_height .',' : ''; ?>
								<?php echo isset($row->settings->waves_speed) && !empty($row->settings->waves_speed) ? 'waveSpeed: ' . $row->settings->waves_speed .',' : ''; ?>
								<?php echo isset($row->settings->waves_zoom) && !empty($row->settings->waves_zoom) ? 'zoom: ' . $row->settings->waves_zoom .',' : ''; ?>
							});
						<?php }elseif( 'net' == $anim_type ) { ?>
							VANTA.NET({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->net_color) && !empty($row->settings->net_color) ? 'color: 0x' . $row->settings->net_color .',' : ''; ?>
								<?php echo isset($row->settings->net_bg_color) && !empty($row->settings->net_bg_color) ? 'backgroundColor: 0x' . $row->settings->net_bg_color .',' : ''; ?>
								<?php echo isset($row->settings->net_points) && !empty($row->settings->net_points) ? 'points: ' . $row->settings->net_points .',' : ''; ?>
								<?php echo isset($row->settings->net_max_distance) && !empty($row->settings->net_max_distance) ? 'maxDistance: ' . $row->settings->net_max_distance .',' : ''; ?>
								<?php echo isset($row->settings->net_spacing) && !empty($row->settings->net_spacing) ? 'spacing: ' . $row->settings->net_spacing .',' : ''; ?>
								<?php echo isset($row->settings->net_show_dot) && !empty($row->settings->net_show_dot) ? 'showDots: ' . $row->settings->net_show_dot .',' : ''; ?>
							});
						<?php }elseif( 'dots' == $anim_type ) { ?>
							VANTA.DOTS({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->dots_color_1) && !empty($row->settings->dots_color_1) ? 'color: 0x' . $row->settings->dots_color_1 .',' : ''; ?>
								<?php echo isset($row->settings->dots_color_2) && !empty($row->settings->dots_color_2) ? 'color2: 0x' . $row->settings->dots_color_2 .',' : ''; ?>
								<?php echo isset($row->settings->dots_bg_color) && !empty($row->settings->dots_bg_color) ? 'backgroundColor: 0x' . $row->settings->dots_bg_color .',' : ''; ?>
								<?php echo isset($row->settings->dots_size) && !empty($row->settings->dots_size) ? 'size: ' . $row->settings->dots_size .',' : ''; ?>
								<?php echo isset($row->settings->dots_spacing) && !empty($row->settings->dots_spacing) ? 'spacing: ' . $row->settings->dots_spacing .',' : ''; ?>
							});
						<?php }elseif( 'rings' == $anim_type ) { ?>
							VANTA.RINGS({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->rings_bg_color) && !empty($row->settings->rings_bg_color) ? 'backgroundColor: 0x' . $row->settings->rings_bg_color .',' : ''; ?>
								<?php echo isset($row->settings->rings_bg_opacity) && !empty($row->settings->rings_bg_opacity) ? 'backgroundAlpha: ' . $row->settings->rings_bg_opacity .',' : ''; ?>
								<?php echo isset($row->settings->rings_color) && !empty($row->settings->rings_color) ? 'color: 0x' . $row->settings->rings_color .',' : ''; ?>
							});
						<?php }elseif( 'cells' == $anim_type ) { ?>
							VANTA.CELLS({
								el: ".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap",
								<?php echo isset($row->settings->cells_color_1) && !empty($row->settings->cells_color_1) ? 'color1: 0x' . $row->settings->cells_color_1 .',' : ''; ?>
								<?php echo isset($row->settings->cells_color_2) && !empty($row->settings->cells_color_2) ? 'color2: 0x' . $row->settings->cells_color_2 .',' : ''; ?>
								<?php echo isset($row->settings->cells_size) && !empty($row->settings->cells_size) ? 'size: ' . $row->settings->cells_size .',' : ''; ?>
								<?php echo isset($row->settings->cells_speed) && !empty($row->settings->cells_speed) ? 'speed: ' . $row->settings->cells_speed .',' : ''; ?>
							});
						<?php }
						if ( 'particles' == $anim_type || 'nasa' == $anim_type || 'bubble' == $anim_type || 'snow' == $anim_type || 'custom' == $anim_type ) { ?>
							var appendDiv = "<div id='pp-particles-wrap-<?php echo $row->node; ?>' class='pp-particles-wrap'></div>";

							$(".fl-node-<?php echo $row->node; ?> .fl-row-content-wrap").prepend(appendDiv);

							<?php if ( 'particles' === $anim_type ) { ?>
								var lineLinked 		= true,
									partQuantity 	= 80,
									partOpacity 	= 0.5,
									partShapeType	= 'circle',
									partRandOpacity	= false,
									partDirection 	= 'none',
									partMoveRand 	= false,
									partSpeed 		= 3,
									partSize 		= 3,
									partSizeRandom	= true,
									showHoverEffect = true,
									partHoverEffect	= 'repulse',
									partHoverSize 	= 0;
							<?php } else if( 'nasa' == $anim_type ) { ?>
								var lineLinked		= false,
									partQuantity	= 110,
									partShapeType 	= 'star',
									partOpacity 	= 1,
									partRandOpacity	= true,
									partDirection 	= 'none',
									partMoveRand 	= true,
									partSpeed 		= 1,
									partSize 		= 3,
									partSizeRandom	= true,
									showHoverEffect = true,
									partHoverEffect	= 'bubble',
									partHoverSize 	= 0;
							<?php } else if( 'bubble' == $anim_type ) { ?>
								var lineLinked		= false,
									partQuantity 	= 6,
									partShapeType	= 'circle',
									partOpacity 	= 0.6,
									partRandOpacity = false,
									partDirection 	= 'none',
									partMoveRand 	= true,
									partSpeed 		= 10,
									partSize 		= 160,
									partSizeRandom 	= false,
									showHoverEffect = true,
									partHoverEffect	= 'none',
									partHoverSize 	= 0;
							<?php } else if ( 'snow' == $anim_type ) { ?>
								var lineLinked		= false,
									partQuantity 	= 300,
									partShapeType	= 'circle',
									partOpacity 	= 0.5,
									partRandOpacity = true,
									partDirection 	= 'bottom',
									partMoveRand 	= false,
									partSpeed 		= 5,
									partSize 		= 10,
									partSizeRandom	= true,
									showHoverEffect = true,
									partHoverEffect	= 'bubble',
									partHoverSize 	= 4;
							<?php } ?>

							var partColor = '<?php echo isset($row->settings->part_color) && !empty($row->settings->part_color) ? '#' . $row->settings->part_color : '#fff'; ?>';

							<?php
							if (  ! empty($row->settings->part_quantity) && isset($row->settings->part_quantity) ){ ?>
								var partQuantity = <?php echo $row->settings->part_quantity; ?>;
							<?php }
							if (  ! empty($row->settings->part_opacity) && isset($row->settings->part_opacity) ){ ?>
								var partOpacity = <?php echo $row->settings->part_opacity; ?>;
							<?php }
							if (  ! empty($row->settings->part_rand_opacity) && isset($row->settings->part_rand_opacity) ){ ?>
								var partRandOpacity = <?php echo $row->settings->part_rand_opacity; ?>;
							<?php }
							if (  ! empty($row->settings->part_direction) && isset($row->settings->part_direction) && 'none' != $row->settings->part_direction ){ ?>
								var partDirection = '<?php echo $row->settings->part_direction; ?>';
							<?php }
							if (  ! empty($row->settings->part_speed) && isset($row->settings->part_speed) ){ ?>
								var partSpeed = <?php echo $row->settings->part_speed; ?>;
							<?php }
							if (  ! empty($row->settings->part_size) && isset($row->settings->part_size) ){ ?>
								var partSize = <?php echo $row->settings->part_size; ?>;
							<?php }

							if ( ! empty($row->settings->part_hover_effect) && isset($row->settings->part_hover_effect) && 'none' != $row->settings->part_hover_effect ){ ?>
								var	partHoverEffect	= '<?php echo $row->settings->part_hover_effect;?>';
								<?php if( 'noeffect' == $row->settings->part_hover_effect ){ ?> 
									var showHoverEffect	= false;
								<?php }else{ ?> 
									var showHoverEffect	= true;
								<?php } ?> 
							<?php } ?>
							<?php if (  ! empty($row->settings->part_hover_size) && isset($row->settings->part_hover_size) ){ ?>
								var partHoverSize = <?php echo $row->settings->part_hover_size; ?>;
							<?php } ?>

							<?php
							if( 'custom' == $anim_type ){
								if ( ! empty($row->settings->part_custom_code) && isset($row->settings->part_custom_code) ) {
		
									$json_particles_custom = wp_strip_all_tags( $row->settings->part_custom_code ); ?>
									particlesJS( 'pp-particles-wrap-<?php echo $row->node; ?>', <?php echo $json_particles_custom;?> );

								<?php } ?>
							<?php }else{ ?>

								var particlesData = {
									"particles": {
										"number": {
											"value": partQuantity,
											"density": {
												"enable": true,
												"value_area": 800
											}
										},
										"color": {
											"value": partColor,
										},
										"shape": {
											"type": partShapeType,
											"stroke": {
												"width": 0,
												"color": "#000000"
											},
											"polygon": {
												"nb_sides": 5
											},
											"image": {
												"src": "",
												"width": 0,
												"height": 0
											}
										},
										"opacity": {
											"value": partOpacity,
											"random": partRandOpacity,
											"anim": {
												"enable": true,
												"speed": 1,
												"opacity_min": 0.1,
												"sync": false
											}
										},
										"size": {
											"value": partSize,
											"random": partSizeRandom,
											"anim": {
												"enable": false,
												"speed": 40,
												"size_min": 0.1,
												"sync": false
											}
										},
										"line_linked": {
											"enable": lineLinked,
											"distance": 150,
											"color": "#ffffff",
											"opacity": 0.4,
											"width": 1,
										},
										"move": {
											"enable": true,
											"speed": partSpeed,
											"direction": partDirection,
											"random": partMoveRand,
											"straight": false,
											"out_mode": "out",
											"bounce": false,
											"attract": {
												"enable": false,
												"rotateX": 600,
												"rotateY": 1200
											}
										}
									},
									"interactivity": {
										"detect_on": "canvas",
										"events": {
											"onhover": {
												"enable": showHoverEffect,
												"mode": partHoverEffect,
											},
											"onclick": {
												"enable": true,
												"mode": "repulse"
											},
											"resize": true
										},
										"modes": {
											"grab": {
												"distance": 400,
												"line_linked": {
												"opacity": 0.5
												}
											},
											"bubble": {
												"distance": 400,
												"size": partHoverSize,
												"duration": 0.3,
												"opacity": 1,
												"speed": 3
											},
											"repulse": {
												"distance": 200,
												"duration": 0.4
											},
											"push": {
												"particles_nb": 4
											},
											"remove": {
												"particles_nb": 2
											}
										}
									},
									"retina_detect": true
								}
								particlesJS( 'pp-particles-wrap-<?php echo $row->node; ?>', particlesData );
							<?php } ?>

						<?php } ?>
					})(jQuery);
					<?php
				}
				?>
				}, 500);
			<?php if ( 'none' !== $max_width || 'none' !== $min_width ) { ?>
			}
			<?php } ?>	
			<?php
			$js .= ob_get_clean();
		}
	}

	return $js;
}

/**
 * Infinite Background
 */
function pp_infinite_bg_js( $js, $nodes, $global_settings ) {
	foreach ( $nodes['rows'] as $row ) {
		if ( isset($row->settings->bg_type) && 'pp_infinite_bg' == $row->settings->bg_type ) {
			ob_start();
			?>
			;(function($) {
				var createStyle = function() {
					var height = 0;
					$('.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap').imagesLoaded(function() {

						var width = $('.fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap').outerWidth();

						height = height + $('.fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap')[0].scrollHeight + 1;
						if ( $('.fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap > .fl-row-content').height() <= 1 ) {
							height = height + 9;
						}

						var s = document.createElement('style');
						s.className = 'pp-infinite-bg-row-css';

						s.innerHTML = '@keyframes pp-animation-horizontally-right_left-<?php echo $row->node; ?> { ';
						s.innerHTML	+= '0% { background-position: 0 0; }';
						s.innerHTML	+=	'100% { background-position: -' + width + 'px 0; }';
						s.innerHTML +=	' }';
						s.innerHTML += '@keyframes pp-animation-horizontally-left_right-<?php echo $row->node; ?> { ';
						s.innerHTML	+= '0% { background-position: 0 0; }';
						s.innerHTML	+=	'100% { background-position: ' + width + 'px 0; }';
						s.innerHTML +=	' }';
						s.innerHTML += '@keyframes pp-animation-vertically-top_bottom-<?php echo $row->node; ?> { ';
						s.innerHTML	+= '0% { background-position: 0 0; }';
						s.innerHTML	+=	'100% { background-position: 0 ' + height + 'px; }';
						s.innerHTML +=	' }';
						s.innerHTML += '@keyframes pp-animation-vertically-bottom_top-<?php echo $row->node; ?> { ';
						s.innerHTML	+= '0% { background-position: 0 0; }';
						s.innerHTML	+=	'100% { background-position: 0 -' + height + 'px; }';
						s.innerHTML +=	' }';

						document.head.appendChild(s);
					
					});
				}
				
				$(window).on('load', function() {
					createStyle();
					$(window).resize(function() {
						$('.pp-infinite-bg-row-css').remove();
						createStyle();
					});
				});
			})(jQuery);
			<?php
			$js .= ob_get_clean();
		}
	}

	return $js;
}

/**
 * Expandable
 */
function pp_row_expandable_js( $js, $nodes, $global_settings ) {
    foreach ( $nodes['rows'] as $row ) {
        ob_start();

        if ( $row->settings->enable_expandable == 'yes' ) {
        ?>

            ;(function($) {
                var html = '<div class="pp-er pp-er-<?php echo $row->node; ?>"> <div class="pp-er-wrap"> <div class="pp-er-inner"> <div class="pp-er-title-wrap"> <?php if ( "" != $row->settings->er_title ) { ?> <span class="pp-er-title"><?php echo htmlspecialchars( $row->settings->er_title, ENT_QUOTES | ENT_HTML5 ); ?></span> <?php } ?> <span class="pp-er-arrow fa <?php echo $row->settings->er_arrow_weight == 'bold' ? 'fa-chevron-down' : 'fa-angle-down'; ?>"></span> </div> </div> </div> </div>';
				if ( $('.fl-row.fl-node-<?php echo $row->node; ?>').find('.pp-er').length === 0 ) {
                	$('.fl-row.fl-node-<?php echo $row->node; ?>').prepend(html);
				}
				<?php if ( 'collapsed' != $row->settings->er_default_state ) { ?>
					$('.pp-er-<?php echo $row->node; ?> .pp-er-wrap').parent().addClass('pp-er-open');
				<?php } ?>
                $('.pp-er-<?php echo $row->node; ?> .pp-er-wrap').off('click').on('click', function(e) {
					e.stopPropagation();
                    var $this = $(this);
                    $this.parent().addClass('pp-er-open');
                    $this.find('.pp-er-title').html('<?php echo htmlspecialchars( $row->settings->er_title_e, ENT_QUOTES | ENT_HTML5 ); ?>');
                    $(this).parents('.fl-row').find('.fl-row-content-wrap').slideToggle(<?php echo absint($row->settings->er_transition_speed); ?>, function() {
                        if ( !$(this).is(':visible') ) {
                            $this.parent().removeClass('pp-er-open');
                            $this.find('.pp-er-title').html('<?php echo htmlspecialchars( $row->settings->er_title, ENT_QUOTES | ENT_HTML5 ); ?>');
                        }

						$(document).trigger('pp_expandable_row_toggle', [$('.pp-er-<?php echo $row->node; ?>')]);
                    });
                });
            })(jQuery);

        <?php
        }

        $js .= ob_get_clean();
    }

    return $js;
}

/**
 * Down Arrow
 */
function pp_row_downarrow_js( $js, $nodes, $global_settings ) {
    $count = 0;
    foreach ( $nodes['rows'] as $row ) {
        if ( $count > 0 ) {
            break;
        }
        if ( is_object($row) && isset($row->settings->enable_down_arrow) && 'yes' == $row->settings->enable_down_arrow ) {
            ob_start();
            ?>

            ;(function($) {
            	$('.pp-down-arrow').on('click', function() {
            		var rowSelector = '.fl-node-' + $(this).data('row-id');
            		var nextRow		= $(rowSelector).next();
            		var topOffset	= ( '' === $(this).data('top-offset') ) ? 0 : $(this).data('top-offset');
                    var adminBar    = $('body').hasClass('admin-bar') ? 32 : 0;
            		var trSpeed		= $(this).data('transition-speed');
            		$('html, body').animate({
            			scrollTop: nextRow.offset().top - (topOffset + adminBar)
            		}, trSpeed);
            	});
            })(jQuery);

            <?php

            $js .= ob_get_clean();
            $count++;
        }
    }

    return $js;
}
