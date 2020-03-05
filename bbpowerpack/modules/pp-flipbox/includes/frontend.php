<?php

$flipbox_class = 'pp-flipbox-wrap ';
$flipbox_class .= 'pp-flip-type-' . $settings->flip_type;
$browser = ' pp-browser-' . pp_get_user_agent();

?>
<div class="pp-flip-box<?php echo $browser; ?>">
	<div class="<?php echo $flipbox_class; ?>">
		<div class="pp-flipbox-container">
			<div class="pp-flipbox pp-flipbox-front">
				<div class="pp-flipbox-inner">
					<?php if( $settings->icon_type == 'icon' && $settings->icon_select != '' ) { ?>
						<div class="pp-icon-wrapper animated">
							<div class="pp-flipbox-icon">
								<div class="pp-flipbox-icon-inner">
									<span class="pp-icon <?php echo $settings->icon_select; ?>"></span>
								</div>
							</div>
						</div>
					<?php } else if( $settings->icon_type == 'image' && $settings->image_select != '' ) { ?>
						<div class="pp-icon-wrapper animated">
							<div class="pp-flipbox-image">
								<img src="<?php echo $settings->image_select_src; ?>" alt="<?php echo pp_get_image_alt($settings->image_select); ?>" />
							</div>
						</div>
					<?php } ?>
					<div class="pp-flipbox-title">
						<<?php echo $settings->front_title_tag; ?> class="pp-flipbox-front-title"> <?php echo $settings->front_title; ?> </<?php echo $settings->front_title_tag; ?>>
					</div>
					<div class="pp-flipbox-description">
						<?php echo $settings->front_description; ?>
					</div>
				</div>
			</div>
			<div class="pp-flipbox pp-flipbox-back">
				<?php if( $settings->link_type == 'box' ) { ?>
					<a class="pp-flipbox-link" href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>">
				<?php } ?>
				<div class="pp-flipbox-inner">
					<div class="pp-flipbox-title">
						<<?php echo $settings->back_title_tag; ?> class="pp-flipbox-back-title"><?php echo $settings->back_title; ?></<?php echo $settings->back_title_tag; ?>>
					</div>
					<div class="pp-flipbox-description">
						<?php echo $settings->back_description; ?>
					</div>
					<?php if( $settings->link_type == 'custom' ) { ?>
						<a class="pp-more-link" href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>"><?php echo $settings->link_text; ?></a>
					<?php } ?>
				</div>
				<?php if( $settings->link_type == 'box' ) { ?>
					</a>
				<?php } ?>
			</div>
		</div>

	</div>
</div>
