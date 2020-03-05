<?php

	$filter_labels = $module->get_gallery_filter_ids( $settings->gallery_filter, true );
	$all_filter = ( isset( $settings->show_all_filter_btn ) && 'no' == $settings->show_all_filter_btn ) ? false : true;
	$all_text = ( $settings->show_custom_all_text == 'yes' && $settings->custom_all_text != '' ) ? $settings->custom_all_text : esc_html__('All', 'bb-powerpack');
	$id_prefix = ( isset( $settings->custom_id_prefix ) && ! empty( $settings->custom_id_prefix ) ) ? $settings->custom_id_prefix : 'pp-gallery-' . $id;
	$active_filter = ( isset( $settings->active_filter ) && ! empty( $settings->active_filter ) ) ? absint( $settings->active_filter ) : false;

	$item_class = 'pp-gallery-item pp-gallery-' . $settings->gallery_layout . '-item';

	if ( ! $active_filter && ! $all_filter ) {
		$active_filter = 1;
	}

	if ( count( $filter_labels ) ) : ?>

		<div class="pp-gallery-filters-wrapper">
			<div class="pp-gallery-filters-toggle">
				<span class="toggle-text"><?php echo $all_text; ?></span>
			</div>
			<ul class="pp-gallery-filters">
				<?php if ( $all_filter ) { ?>
				<li id="<?php echo $id_prefix; ?>-0" class="pp-gallery-filter-label <?php echo ! $active_filter ? 'pp-filter-active ' : ''; ?>all" data-filter="*"><?php echo $all_text; ?></li>
				<?php } ?>
			<?php
				for ( $i = 0; $i < count( $settings->gallery_filter ); $i++ ) :

					if ( ! is_object( $settings->gallery_filter[ $i ] ) ) continue;

						$filter 		= $settings->gallery_filter[ $i ];
						$filter_label 	= $filter->filter_label;

						if ( ! empty( $filter_label ) ) {
							echo '<li id="' . $id_prefix . '-' . ( $i + 1 ) . '" class="pp-gallery-filter-label'. ( ( $i + 1 ) == $active_filter ? ' pp-filter-active ' : '' ) .'" data-filter=".pp-group-' . ($i+1) . '">' . $filter_label . '</li>';
						}

				endfor;
			?>
			</ul>
		</div>

	<div class="pp-photo-gallery<?php echo ( $settings->hover_effects != 'none' ) ? ' ' . $settings->hover_effects : ''; ?>">

	<?php

		foreach( $module->get_photos() as $photo ) :

			$photo_filter_label 		= $filter_labels[ $photo->id ];
			$final_photo_filter_label 	= preg_replace( '/[^\sA-Za-z0-9]/', '-', $photo_filter_label ); ?>

		<div class="<?php echo $item_class; ?> <?php echo $final_photo_filter_label; ?>">
			<div class="pp-photo-gallery-content">

				<?php if ( $settings->click_action != 'none' ) :
						$click_action_link = 'javascript:void(0)';
						$click_action_target = $settings->custom_link_target;

						if ( $settings->click_action == 'custom-link' ) {
							if ( ! empty( $photo->cta_link ) ) {
								$click_action_link = $photo->cta_link;
							}
						}

						if ( $settings->click_action == 'lightbox' ) {
							$click_action_link = $photo->link;
						}
					?>
				<a href="<?php echo $click_action_link; ?>" target="<?php echo $click_action_target; ?>" rel="nofollow<?php echo ( '_blank' === $click_action_target ) ? ' noopener' : ''; ?>">
				<?php endif; ?>

				<img class="pp-gallery-img" src="<?php echo $photo->src; ?>" alt="<?php echo $photo->alt; ?>" data-no-lazy="1" />

				<?php if( $settings->hover_effects != 'none' || $settings->overlay_effects != 'none' || $settings->show_captions == 'hover' ) : ?>
					<!-- overlay start -->
					<div class="pp-gallery-overlay">
						<div class="pp-overlay-inner">

							<?php if( $settings->show_captions == 'hover' ) : ?>
								<div class="pp-caption">
									<?php echo $photo->caption; ?>
								</div>
							<?php endif; ?>

							<?php if( $settings->icon == '1' && $settings->overlay_icon != '' ) : ?>
							<div class="pp-overlay-icon">
								<span class="<?php echo $settings->overlay_icon; ?>" ></span>
							</div>
							<?php endif; ?>

						</div>
					</div>
					<!-- overlay end -->
				<?php endif; ?>

				<?php if( $settings->click_action != 'none' ) : ?>
				</a>
				<?php endif; ?>
			</div>
			<?php if($photo && !empty($photo->caption) && 'below' == $settings->show_captions) : ?>
			<div class="pp-photo-gallery-caption pp-photo-gallery-caption-below" itemprop="caption"><?php echo $photo->caption; ?></div>
			<?php endif; ?>
		</div>
		<?php
		endforeach; ?>
	
	<div class="pp-photo-space"></div>
	</div>
<?php else: ?>
	<p><?php _e('Please add photos to the gallery.', 'bb-powerpack'); ?></p>
<?php endif; ?>
