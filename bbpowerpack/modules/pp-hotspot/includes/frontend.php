<?php
if ( 'library' === $settings->photo_source ) {
	$img_url = $settings->photo_src;
} else {
	$img_url = $settings->photo_url;
}
if ( empty( $img_url ) ) {
	$img_url = BB_POWERPACK_URL . 'images/default-img.jpg';
}
// Hotspot Tour Check
if ( 'yes' === $settings->enable_tour ) {
	$hotspot_tour = 'pp-hotspot-tour pp-tour-active';
	if ( 'yes' === $settings->non_active_marker ) {
		$hotspot_tour .= ' pp-hotspot-marker-nonactive';
	}
} else {
	$hotspot_tour = 'pp-tour-inactive';
}
if ( 'yes' === $settings->enable_tour && 'yes' === $settings->non_active_marker ) {
	$non_active = ' pp-non-active-marker';
} else {
	$non_active = '';
}
?>

<div class="pp-hotspot">
	<div class="pp-hotspot-container">
		<div class="pp-hotspot-image-container">
			<img src="<?php echo $img_url; ?>" alt="" class="pp-hotspot-image">
		</div>
		<div class="pp-hotspot-content">
		<?php
		foreach ( $settings->markers_content as $i => $marker ) {
			/* translators: %d: number count */
			$marker_title = ! empty( $marker->marker_title ) ? $marker->marker_title : sprintf( __( 'Marker %d', 'bb-powerpack' ), ( $i + 1 ) );
			?>
			<?php if ( ! empty( $marker_title ) ) { ?>
				<?php
				if ( 'yes' === $settings->enable_tour ) {
					$enable_tour = ' data-pptour=' . ( $i + 1 );
				} else {
					$enable_tour = '';
				}
				?>
				<span class="pp-hotspot-marker pp-marker-<?php echo ( $i + 1 ) . $non_active; ?>" data-title="<?php echo $marker_title; ?>" data-tooltip-content="#pp-tooltip-content-<?php echo $id . '-' . ( $i + 1 ); ?>"<?php echo $enable_tour; ?>>
				<?php if ( 'yes' === $settings->add_marker_link && $marker->marker_link ) { ?>
					<a href="<?php echo $marker->marker_link; ?>" target="<?php echo $marker->marker_link_target; ?>">
				<?php } ?>
					<?php if ( 'icon' === $marker->marker_type ) { ?>
						<i class="<?php echo $marker->marker_icon; ?> pp-marker-icon"></i>
					<?php } elseif ( 'image' === $marker->marker_type ) { ?>
						<img src="<?php echo $marker->marker_image_src; ?>" alt="" class="pp-marker-image">
					<?php } elseif ( 'text' === $marker->marker_type ) { ?>
						<p class="pp-marker-text"><?php echo $marker->marker_text; ?></p>
					<?php } ?>
					<span class="pp-marker-title"> <?php echo $marker_title; ?> </span>
				<?php if ( 'yes' === $settings->add_marker_link && $marker->marker_link ) { ?>
					</a>
				<?php } ?>
				</span>

				<?php if ( 'yes' === $settings->tooltip && ! empty( $marker->tooltip_content ) ) { ?>
					<span class="pp-tooltip-container pp-tooltip-<?php echo ( $i + 1 ); ?>">
						<span class="<?php echo $hotspot_tour; ?> pp-tooltip-content-<?php echo $id; ?>" id="pp-tooltip-content-<?php echo $id . '-' . ( $i + 1 ); ?>">
							<?php echo $marker->tooltip_content; ?>
							<?php if ( 'yes' === $settings->enable_tour ) { ?>
								<span class="pp-tour">
									<ul>
										<li>
											<a class="pp-prev" data-tooltipid="<?php echo ( $i + 1 ); ?>">
											<?php if ( 'icon' === $settings->navigation_type ) { ?>
												<i class='<?php echo isset( $settings->pre_icon ) ? $settings->pre_icon : 'fas fa-angle-double-left'; ?>'></i>
											<?php } elseif ( 'text' === $settings->navigation_type ) { ?>
												<?php echo isset( $settings->pre_text ) ? $settings->pre_text : 'Previous'; ?>
											<?php } else { ?>
												<i class='<?php echo isset( $settings->pre_icon ) ? $settings->pre_icon : 'fas fa-angle-double-left'; ?>'></i>
												<?php echo isset( $settings->pre_text ) ? $settings->pre_text : 'Previous'; ?>
											<?php } ?>
											</a>
										</li>
										<li>
											<a class="pp-next" data-tooltipid="<?php echo ( $i + 1 ); ?>">
											<?php if ( 'icon' === $settings->navigation_type ) { ?>
												<i class='<?php echo isset( $settings->next_icon ) ? $settings->next_icon : 'fas fa-angle-double-right'; ?>'></i>
											<?php } elseif ( 'text' === $settings->navigation_type ) { ?>
												<?php echo isset( $settings->next_text ) ? $settings->next_text : 'Next'; ?>
											<?php } else { ?>
												<?php echo isset( $settings->next_text ) ? $settings->next_text : 'Next'; ?>
												<i class='<?php echo isset( $settings->next_icon ) ? $settings->next_icon : 'fas fa-angle-double-right'; ?>'></i>
											<?php } ?>
											</a>
										</li>
									</ul>
								</span>
								<span class="pp-tour">
									<ul>
										<li>
											<?php if ( 'yes' === $settings->repeat_tour ) { ?>
												<span class="pp-hotspot-end">
													<a class="pp-tour-end">
														<?php echo isset( $settings->end_text ) ? $settings->end_text : 'End Tour'; ?>
													</a>
												</span>
											<?php } ?>
										</li>
										<li>
											<span class="pp-actual-step" style="display: block;">
												<?php echo ( $i + 1 ); ?> 
												<?php echo __( 'of', 'bb-powerpack' ); ?> 
												<?php echo sizeof( $settings->markers_content ); ?>
											</span>
										</li>
									</ul>
								</span>
						<?php } ?>
						</span>
					</span>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		</div>
		<?php if ( 'yes' === $settings->enable_tour && 'button_click' === $settings->launch_tour ) { ?>
			<div class="pp-hotspot-overlay">
				<button class="pp-hotspot-overlay-button"><?php echo $settings->overlay_button; ?></button>
			</div>
		<?php } ?>
	</div>
</div>
