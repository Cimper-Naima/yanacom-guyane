<?php

$hover_card_class = 'pp-hover-card-wrap';

?>
<div class="<?php echo $hover_card_class; ?> pp-clearfix">
	<?php
	$number_cards = count( $settings->card_content );
	for ( $i = 0; $i < $number_cards; $i++ ) {
		if ( ! is_object( $settings->card_content[ $i ] ) ) {
			continue;
		}
		$cards = $settings->card_content[$i];
	?>
		<div class="pp-hover-card-container pp-clearfix hover-card-<?php echo $i; ?> <?php echo $settings->style_type; ?>" onclick="">
			<?php if( $cards->hover_card_link_type == 'box' ) { ?>
				<a class="pp-more-link-container" href="<?php echo $cards->button_link == '#' ? 'javascript:void(0)' : $cards->button_link; ?>" target="<?php echo $cards->button_link_target; ?>">
			<?php } ?>
				<div class="pp-hover-card">
					<div class="pp-hover-card-border"></div>
					<div class="pp-hover-card-inner">
						<div class="card-inner-wrap">
							<?php if($settings->style_type == 'powerpack-style') { ?>
								<div class="powerpack-title-image-wrapper">
							<?php } ?>
									<?php if($settings->style_type == 'powerpack-style' && ( $cards->hover_card_font_icon != '' || $cards->hover_card_custom_icon != '' ) ) { ?>
										<div class="pp-card-image">
											<?php if($cards->hover_card_font_icon && $cards->hover_card_image_select == 'hover_card_font_icon_select') { ?>
												<span class="icon <?php echo $cards->hover_card_font_icon; ?>"></span>
											<?php } ?>
											<?php if($cards->hover_card_custom_icon && $cards->hover_card_image_select == 'hover_card_custom_icon_select') { ?>
													<img class="icon" src="<?php echo $cards->hover_card_custom_icon_src; ?>" />
											<?php } ?>
										</div>
									<?php } ?>

								<?php if( $cards->title ) { ?>
									<div class="pp-hover-card-title">
										<<?php echo $settings->hover_card_title_tag; ?>><?php echo $cards->title; ?></<?php echo $settings->hover_card_title_tag; ?>>
									</div>
								<?php } ?>
							<?php if($settings->style_type == 'powerpack-style') { ?>
								</div>
							<?php } ?>
							<?php if( $cards->hover_content ) { ?>
							<div class="pp-hover-card-description">
								<?php echo $cards->hover_content; ?>
							</div>
							<?php } ?>
							<?php if( $cards->hover_card_link_type == 'button' ) { ?>
								<div class="pp-more-link-button">
									<a class="pp-more-link" href="<?php echo $cards->button_link == '#' ? 'javascript:void(0)' : $cards->button_link; ?>" target="<?php echo $cards->button_link_target; ?>">
										<?php echo $cards->button_text; ?>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>

				</div>
				<?php if( $cards->hover_card_link_type == 'box' ) { ?>
					</a>
				<?php } ?>
			</div>
		<?php
	}
	?>
</div>
