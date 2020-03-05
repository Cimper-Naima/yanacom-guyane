;(function($) {

	new PPSubscribeForm({
		id: '<?php echo $id ?>',
		type: '<?php echo $settings->box_type; ?>',
		cookie: <?php echo absint($settings->display_after); ?>
	});

	var closed = false;
	var winWidth = window.innerWidth;
	var mediumWidth = <?php echo $global_settings->medium_breakpoint; ?>;
	var smallWidth = <?php echo $global_settings->responsive_breakpoint; ?>;

	<?php if ( $settings->responsive_display == 'desktop' ) { ?>
		if ( winWidth > mediumWidth ) {
	<?php } elseif ( $settings->responsive_display == 'desktop-medium' ) { ?>
		if ( winWidth > smallWidth ) {
	<?php } elseif ( $settings->responsive_display == 'medium' ) { ?>
		if ( winWidth <= mediumWidth && winWidth > smallWidth ) {
	<?php } elseif ( $settings->responsive_display == 'medium-mobile' ) { ?>
		if ( winWidth <= mediumWidth ) {
	<?php } elseif ( $settings->responsive_display == 'mobile' ) { ?>
		if ( winWidth <= smallWidth ) {
	<?php } else { ?>
		if ( winWidth ) {
	<?php } ?>

	<?php if ( ! FLBuilderModel::is_builder_active() && ( 'popup_scroll' == $settings->box_type || 'popup_exit' == $settings->box_type || 'popup_auto' == $settings->box_type || 'welcome_gate' == $settings->box_type || 'two_step' == $settings->box_type ) ) { ?>
		<?php if ( 'yes' == $settings->show_overlay ) { ?>
		if ( $('.pp-subscribe-<?php echo $id; ?>-overlay').length === 0 ) {
			$('<div class="pp-subscribe-<?php echo $id; ?>-overlay"></div>').appendTo('body');
		}
		<?php } ?>
	<?php } ?>

	<?php if ( ! FLBuilderModel::is_builder_active() && 'fixed_bottom' == $settings->box_type ) { ?>
		$('.fl-module.fl-node-<?php echo $id; ?>').wrap('<div class="fl-builder-content fl-builder-content-<?php echo get_the_ID(); ?> pp-wrap-<?php echo $id; ?>" data-post-id="<?php echo get_the_ID(); ?>"></div>');
		$('.fl-builder-content.pp-wrap-<?php echo $id; ?>').appendTo('body');
	<?php } ?>

	<?php if ( ! FLBuilderModel::is_builder_active() && 'standard' != $settings->box_type ) { ?>

		//$('.pp-subscribe-<?php echo $id; ?>').appendTo('body');

		if ( $.cookie('pp_subscribe_<?php echo $id ?>') === undefined || parseInt($.cookie('pp_subscribe_<?php echo $id ?>')) === 0 ) {

			<?php if ( 'slidein' == $settings->box_type || 'popup_scroll' == $settings->box_type ) { ?>

				var lastScrollPos = 0;
				$(window).on('scroll', function() {
					if ( closed ) {
						return;
					}
					var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
					if (scrollTop > lastScrollPos) {
						var scrollOffset = document.body.scrollHeight * (<?php echo $settings->box_scroll; ?>/100);
						if ( scrollTop >= scrollOffset && $('.pp-subscribe-<?php echo $id; ?>').hasClass('pp-box-active') === false ) {
							<?php if ( 'slidein' == $settings->box_type ) { ?>
								if ( $('.pp-subscribe-<?php echo $id; ?>.pp-subscribe-slidein').width() > $(window).width() ) {
									$('.pp-subscribe-<?php echo $id; ?>').css({
										'max-width': '90%',
										'<?php echo $settings->slidein_position; ?>': '5%',
										'height': 'auto'
									});
								}
							<?php } ?>
							<?php if ( 'popup_scroll' == $settings->box_type || 'popup_exit' == $settings->box_type ) { ?>
								var left = ($(window).width() - <?php echo $settings->box_width; ?>) / 2;
								var width = <?php echo absint($settings->box_width); ?>;

								if ( width > $(window).width() ) {
									left = '5%';
									width = '90%';
								}

								<?php if ( 'yes' == $settings->show_overlay ) { ?>
								$('.pp-subscribe-<?php echo $id; ?>-overlay').fadeIn(200);
								<?php } ?>
								$('.pp-subscribe-<?php echo $id; ?>').css({
									'bottom': 'auto',
									'top': ($(window).height() - <?php echo absint($settings->box_height); ?>) / 2,
									'left': left,
									'right': 'auto',
									'max-width': width
								}).fadeIn(200);
							<?php } ?>

							$('.pp-subscribe-<?php echo $id; ?>').addClass('pp-box-active');
						}
					}
					lastScrollPos = scrollTop;
				});

			<?php } ?>

			<?php if ( 'popup_exit' == $settings->box_type ) { ?>
				var left = ($(window).width() - <?php echo $settings->box_width; ?>) / 2;
				var width = <?php echo absint($settings->box_width); ?>;

				if ( width > $(window).width() ) {
					left = '5%';
					width = '90%';
				}
				document.addEventListener('mouseout', function(e) {
					if ( $.cookie('pp_subscribe_<?php echo $id ?>') !== undefined && parseInt($.cookie('pp_subscribe_<?php echo $id ?>')) > 0 ) {
						return;
					}
					e = e ? e : window.event;
					var pos = e.relatedTarget || e.toElement;
					if ( (!pos || null === pos) && $('.pp-subscribe-<?php echo $id; ?>').hasClass('pp-box-active') === false ) {
						<?php if ( 'yes' == $settings->show_overlay ) { ?>
						$('.pp-subscribe-<?php echo $id; ?>-overlay').fadeIn(200);
						<?php } ?>
						$('.pp-subscribe-<?php echo $id; ?>').css({
							'bottom': 'auto',
							'top': ($(window).height() - <?php echo absint($settings->box_height); ?>) / 2,
							'left': left,
							'right': 'auto',
							'max-width': width
						}).fadeIn(200).addClass('pp-box-active');
					}
				});
			<?php } ?>

			<?php if ( 'popup_auto' == $settings->box_type || 'welcome_gate' == $settings->box_type ) { ?>
				var left = ($(window).width() - <?php echo $settings->box_width; ?>) / 2;
				var width = <?php echo absint($settings->box_width); ?>;

				if ( width > $(window).width() ) {
					left = '5%';
					width = '90%';
				}
				setTimeout(function() {
					<?php if ( 'yes' == $settings->show_overlay || 'welcome_gate' == $settings->box_type ) { ?>
					$('.pp-subscribe-<?php echo $id; ?>-overlay').fadeIn(200);
					<?php } ?>
					$('.pp-subscribe-<?php echo $id; ?>').css({
						'bottom': 'auto',
						'top': ($(window).height() - <?php echo absint($settings->box_height); ?>) / 2,
						'left': left,
						'right': 'auto',
						'max-width': width
					}).fadeIn(200).addClass('pp-box-active');
				}, <?php echo $settings->popup_delay * 1000; ?>);
			<?php } ?>

			<?php if ( 'fixed_bottom' == $settings->box_type ) { ?>
				$('.fl-module.fl-node-<?php echo $id; ?>').css('margin-top', $('.fl-node-<?php echo $id; ?> .pp-subscribe-form').outerHeight() + 'px');
				$('.fl-node-<?php echo $id; ?> .pp-subscribe-form').addClass('pp-box-active');
			<?php } ?>
		}

		if ( $('.pp_subscribe_<?php echo $id; ?>').length > 0 ) {
			$('.pp_subscribe_<?php echo $id; ?>').off('click').on('click', function(e) {
				e.preventDefault();
				var left = ($(window).width() - <?php echo $settings->box_width; ?>) / 2;
				var width = <?php echo absint($settings->box_width); ?>;

				if ( width > $(window).width() ) {
					left = '5%';
					width = '90%';
				}
				<?php if ( 'yes' == $settings->show_overlay ) { ?>
				$('.pp-subscribe-<?php echo $id; ?>-overlay').fadeIn(200);
				<?php } ?>
				$('.pp-subscribe-<?php echo $id; ?>').css({
					'bottom': 'auto',
					'top': ($(window).height() - <?php echo absint($settings->box_height); ?>) / 2,
					'left': left,
					'right': 'auto',
					'max-width': width
				}).fadeIn(200).addClass('pp-box-active');
			});
		}

		$('.fl-node-<?php echo $id; ?> .pp-box-close').on('click', function(e) {
			e.preventDefault();
			$('.pp-subscribe-<?php echo $id; ?>').removeClass('pp-box-active');
			<?php if ( 'popup_scroll' == $settings->box_type || 'popup_exit' == $settings->box_type || 'popup_auto' == $settings->box_type || 'welcome_gate' == $settings->box_type || 'two_step' == $settings->box_type ) { ?>
			$('.pp-subscribe-<?php echo $id; ?>').fadeOut(200);
			$('.pp-subscribe-<?php echo $id; ?>-overlay').fadeOut(200);
			<?php } ?>
			<?php if ( 'fixed_bottom' == $settings->box_type ) { ?>
				$('.fl-node-<?php echo $id; ?>').removeAttr('style');
				$('.fl-node-<?php echo $id; ?> .pp-subscribe-form').removeClass('pp-box-active');
			<?php } ?>
			$.cookie('pp_subscribe_<?php echo $id ?>', <?php echo absint($settings->display_after); ?>, {expires: <?php echo absint($settings->display_after); ?>, path: '/'});
			closed = true;
		});

	<?php } ?>
	}

})(jQuery);
