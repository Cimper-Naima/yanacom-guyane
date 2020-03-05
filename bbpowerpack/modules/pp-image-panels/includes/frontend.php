<div class="pp-image-panels-wrap clearfix">
	<div class="pp-image-panels-inner">
		<?php
		$panels_count = count( $settings->image_panels );

		for ( $i = 0; $i < $panels_count; $i++ ) {
			if ( ! is_object( $settings->image_panels[ $i ] ) ) {
				continue;
			}
			$panel = $settings->image_panels[ $i ];
			$link = $panel->link;
			if ( 'lightbox' == $panel->link_type ) {
				$link = $panel->photo_src;
			}
		?>
		<?php if ( 'panel' == $panel->link_type || 'lightbox' == $panel->link_type ) { ?>
			<a class="pp-panel-link pp-panel-link-<?php echo $i; ?><?php echo ( 'lightbox' == $panel->link_type ) ? ' pp-panel-has-lightbox' : ''; ?>" href="<?php echo $link; ?>" target="<?php echo $panel->link_target; ?>" style="width: <?php echo 100 / ( $panels_count ); ?>%;">
		<?php } ?>
			<div class="pp-panel-item pp-panel-item-<?php echo $i; ?> clearfix" style="width: <?php echo ( $panel->link_type != 'panel' && $panel->link_type != 'lightbox' ) ? 100 / ( $panels_count ) . '%;' : '' ?>">
				<?php if( $panel->title ) { ?>
					<div class="pp-panel-title">
						<?php if( $panel->link_type == 'title' ) { ?>
						<a class="pp-panel-link" href="<?php echo $link; ?>" target="<?php echo $panel->link_target; ?>">
						<?php } ?>
						<h3><?php echo $panel->title; ?></h3>
						<?php if( $panel->link_type == 'title' ) { ?>
						</a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php if( $panel->link_type == 'panel' || 'lightbox' == $panel->link_type ) { ?>
			</a>
		<?php } ?>
		<?php
		}
		?>
	</div>
</div>
