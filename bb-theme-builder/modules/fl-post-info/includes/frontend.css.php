.fl-node-<?php echo $id; ?> .fl-module-content {
	text-align: <?php echo $settings->align; ?>;
}

<?php if ( ! empty( $settings->font_size ) ) : ?>
.fl-node-<?php echo $id; ?> span,
.fl-node-<?php echo $id; ?> a {
	font-size: <?php echo $settings->font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> span,
.fl-node-<?php echo $id; ?> a {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>
