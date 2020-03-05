<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> form.cart button.button,
.fl-node-<?php echo $id; ?> form.cart button.button:hover,
.fl-node-<?php echo $id; ?> form.cart button.button.alt.disabled {
	background: #<?php echo $settings->bg_color; ?>;
	border-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> form.cart button.button,
.fl-node-<?php echo $id; ?> form.cart button.button:hover,
.fl-node-<?php echo $id; ?> form.cart button.button.alt.disabled  {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>
