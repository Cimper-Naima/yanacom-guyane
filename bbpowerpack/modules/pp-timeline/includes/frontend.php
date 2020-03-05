<div class="pp-timeline">
	<div class="pp-timeline-content-box clearfix">
		<div class="pp-timeline-content-wrapper">
			<?php
			$number_items = count($settings->timeline);
			for( $i = 0; $i < $number_items; $i++ ) {

				if(!is_object($settings->timeline[$i])) {
					continue;
				}
				$timeline = $settings->timeline[$i];
			?>
			<div class="pp-timeline-item clearfix pp-timeline-item-<?php echo $i; ?>">
				<div class="pp-timeline-icon-wrapper">
					<span class="pp-separator-arrow"></span>
					<div class="pp-timeline-icon">
						<span class="pp-icon <?php echo $timeline->timeline_icon; ?>"></span>
					</div>
				</div>
				<div class="pp-timeline-content">
					<?php if( $timeline->title ) { ?>
						<div class="pp-timeline-title-wrapper">
							<<?php echo $settings->title_html_tag; ?> class="pp-timeline-title"><?php echo $timeline->title; ?></<?php echo $settings->title_html_tag; ?>>
						</div>
					<?php } ?>
					<div class="pp-timeline-text-wrapper">
						<div class="pp-timeline-text">
							<?php echo $timeline->content; ?>
							<?php if( $timeline->button_text ) { ?>
								<a class="pp-timeline-button" href="<?php echo $timeline->button_link; ?>"<?php if( isset( $timeline->button_link_target ) ) {?> target="<?php echo $timeline->button_link_target; ?>"<?php } ?>>
									<?php echo $timeline->button_text; ?>
								</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
