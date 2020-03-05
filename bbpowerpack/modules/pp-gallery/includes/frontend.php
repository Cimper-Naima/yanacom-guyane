<?php
$item_class = $module->get_item_class();
$photos = $module->get_photos();
?>

<div class="pp-photo-gallery" itemscope="itemscope" itemtype="https://schema.org/ImageGallery">
	<?php foreach ( $photos as $photo ) {
		include $module->dir . 'includes/layout.php';
	} ?>

	<?php if ( 'masonry' == $settings->gallery_layout ) { ?>
		<div class="pp-photo-space"></div>
	<?php } ?>
</div>

<?php if ( ! empty( $settings->gallery_photos ) ) { ?>
	<?php if ( isset( $settings->pagination ) && ( 'load_more' == $settings->pagination || 'scroll' == $settings->pagination ) ) { ?>
		<?php if ( ! empty( $settings->images_per_page ) && absint( $settings->images_per_page ) < count( $settings->gallery_photos ) ) { ?>
			<div class="pp-gallery-pagination pagination-<?php echo $settings->pagination; ?>">
				<a href="#" class="pp-gallery-load-more"><?php echo $settings->load_more_text; ?></a>
			</div>
			<?php if ( 'scroll' == $settings->pagination ) { ?>
				<div class="pp-gallery-loader" style="display: none;">
					<span class="pp-grid-loader-text"><?php _e('Loading...', 'bb-powerpack'); ?></span>
					<span class="pp-grid-loader-icon"><img src="<?php echo BB_POWERPACK_URL . 'images/spinner.gif'; ?>" style="height: 15px;"/></span>
				</div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
