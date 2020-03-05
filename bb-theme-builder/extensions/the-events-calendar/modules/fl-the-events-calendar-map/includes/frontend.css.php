<?php if ( is_numeric( $settings->height ) ) : ?>
.fl-node-<?php echo $id; ?> div[id*=tribe-events-gmap] {
	height: <?php echo $settings->height; ?>px !important;
}
<?php endif; ?>
