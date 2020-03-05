<?php
if ( 'library' === $settings->photo_source ) {
	$img_url = $settings->photo_src;
} else {
	$img_url = $settings->photo_url;
}
$icon_position = '';

if ( 'icon_text' === $settings->overlay_type ) {
	$icon_position = ' pp-icon-' . $settings->icon_position;
}

// if Link is enabled
if ( ! empty( $settings->link ) ) {
	$link  = "<a class='pp-image-scroll-link'";
	$link .= " href='" . $settings->link . "' target='" . $settings->link_target . "'";
	if ( 'yes' === $settings->link_nofollow ) {
		$link .= " rel='nofollow'";
	}
	$link .= '></a>';
}
?>

<div class="pp-image-scroll-wrap">
	<div class="pp-image-scroll-container pp-image-scroll-<?php echo $settings->scroll_dir; ?> pp-image-control-<?php echo $settings->img_trigger; ?>">
		<div class="pp-image-scroll-image">
			<img src="<?php echo $img_url; ?>" alt="" class="pp-scroll-image">
		</div>
		<?php if ( 'yes' === $settings->image_overlay ) { ?>
			<div class="pp-image-scroll-overlay pp-overlay-<?php echo $settings->scroll_dir; ?><?php echo $icon_position; ?>">
			<?php if ( 'hover' === $settings->img_trigger ) { ?>
				<div class="pp-overlay-content">
					<?php if ( 'icon' === $settings->overlay_type ) { ?>
						<i class="<?php echo $settings->overlay_icon; ?> pp-overlay-icon"></i>
					<?php } elseif ( 'image' === $settings->overlay_type ) { ?>
						<img src="<?php echo $settings->overlay_image_src; ?>" alt="" class="pp-overlay-image">
					<?php } elseif ( 'text' === $settings->overlay_type ) { ?>
						<p class="pp-overlay-text"><?php echo $settings->overlay_text; ?></p>
					<?php } elseif ( 'icon_text' === $settings->overlay_type ) { ?>
						<p class="pp-overlay-text"><?php echo $settings->overlay_text; ?></p>
						<i class="<?php echo $settings->overlay_icon; ?> pp-overlay-icon"></i>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
		<?php } ?>

		<?php
		if ( ! empty( $settings->link ) ) {
			echo $link;
		}
		?>
	</div>
	<?php if ( 'scroll' === $settings->img_trigger && 'yes' === $settings->image_overlay ) { ?>
		<div class="pp-overlay-scroll-content pp-scroll-overlay-<?php echo $settings->scroll_dir; ?>">
			<div class="pp-overlay-content">
				<?php if ( 'icon' === $settings->overlay_type ) { ?>
					<i class="<?php echo $settings->overlay_icon; ?> pp-overlay-icon"></i>
				<?php } elseif ( 'image' === $settings->overlay_type ) { ?>
					<img src="<?php echo $settings->overlay_image_src; ?>" alt="" class="pp-overlay-image">
				<?php } elseif ( 'text' === $settings->overlay_type ) { ?>
					<p class="pp-overlay-text"><?php echo $settings->overlay_text; ?></p>
				<?php } elseif ( 'icon_text' === $settings->overlay_type ) { ?>
					<p class="pp-overlay-text"><?php echo $settings->overlay_text; ?></p>
					<i class="<?php echo $settings->overlay_icon; ?> pp-overlay-icon"></i>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>
