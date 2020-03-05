.fl-node-<?php echo $id; ?> .tribe-events-cal-links {
	text-align: <?php echo $settings->align; ?>;
}

<?php if ( ! empty( $settings->text_color ) ) : ?>
#tribe-events .fl-node-<?php echo $id; ?> .tribe-events-button {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->bg_color ) ) : ?>
#tribe-events .fl-node-<?php echo $id; ?> .tribe-events-button {
	background-color: #<?php echo $settings->bg_color; ?>;
}
<?php endif; ?>

<?php if ( is_numeric( $settings->border_radius ) ) : ?>
#tribe-events .fl-node-<?php echo $id; ?> .tribe-events-button {
	border-radius: <?php echo $settings->border_radius; ?>px;
}
<?php endif ?>
