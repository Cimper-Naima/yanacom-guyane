<?php if ( ! empty( $settings->woo_sale_flash_bg ) ) : ?>
.woocommerce .fl-node-<?php echo $id; ?> span.onsale {
	background: #<?php echo $settings->woo_sale_flash_bg; ?>;
}
<?php endif; ?> 

<?php if ( ! empty( $settings->woo_sale_flash_color ) ) : ?>
.woocommerce .fl-node-<?php echo $id; ?> span.onsale {
	color: #<?php echo $settings->woo_sale_flash_color; ?>;
}
<?php endif; ?> 

<?php if ( ! empty( $settings->woo_rating_fg ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-meta .star-rating span:before {
	color: #<?php echo $settings->woo_rating_fg; ?> !important;
}
<?php endif; ?> 

<?php if ( ! empty( $settings->woo_rating_bg ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-meta .star-rating:before {
	color: #<?php echo $settings->woo_rating_bg; ?> !important;
}
<?php endif; ?>

<?php if ( ! empty( $settings->woo_rating_font_size ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-meta .star-rating {
	font-size: <?php echo $settings->woo_rating_font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->woo_price_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-meta .price span.woocommerce-Price-amount {
	color: #<?php echo $settings->woo_price_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->woo_price_font_size ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-meta .price span.woocommerce-Price-amount {
	font-size: <?php echo $settings->woo_price_font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->woo_button_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-button a.button {
	background: #<?php echo $settings->woo_button_bg_color; ?>;
	border-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->woo_button_bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->woo_button_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-woo-button a.button {
	color: #<?php echo $settings->woo_button_text_color; ?>;
}
<?php endif; ?>
