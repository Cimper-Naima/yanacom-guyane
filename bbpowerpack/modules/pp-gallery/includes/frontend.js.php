var pp_gallery_<?php echo $id; ?>;
;(function($) {

	$(".fl-node-<?php echo $id; ?> .pp-photo-gallery-item, .fl-node-<?php echo $id; ?> .pp-gallery-masonry-item").find('.pp-photo-gallery-caption-below').parent().addClass('has-caption');

	<?php
	$row_height = '' == $settings->row_height ? 0 : $settings->row_height;
	$max_row_height = '' == $settings->max_row_height ? $row_height : $settings->row_height;
	?>

	var options = {
		id: '<?php echo $id ?>',
		layout: '<?php echo $settings->gallery_layout; ?>',
		gutter: <?php echo '' == $settings->photo_spacing ? 0 : $settings->photo_spacing; ?>,
		spacing: <?php echo '' == $settings->justified_spacing ? 0 : $settings->justified_spacing; ?>,
		columns: <?php echo '' == $settings->photo_grid_count ? 3 : intval( $settings->photo_grid_count ); ?>,
		rowHeight: <?php echo $row_height; ?>,
		maxRowHeight: <?php echo $max_row_height; ?>,
		lastRow: '<?php echo $settings->last_row; ?>',
		lightbox: <?php echo 'lightbox' == $settings->click_action ? 'true' : 'false'; ?>,
		lightboxCaption: <?php echo ( isset( $settings->lightbox_caption ) && 'yes' == $settings->lightbox_caption ) ? 'true' : 'false'; ?>,
		lightboxCaptionSource: '<?php echo isset( $settings->lightbox_caption_source ) ? $settings->lightbox_caption_source : 'title'; ?>',
		lightboxThumbs: <?php echo 'yes' == $settings->show_lightbox_thumb ? 'true' : 'false'; ?>,
		lightboxAnimation: '<?php echo isset( $settings->lightbox_animation ) ? $settings->lightbox_animation : ''; ?>',
		transitionEffect: '<?php echo isset( $settings->transition_effect ) ? $settings->transition_effect : ''; ?>',
		<?php if ( isset( $settings->pagination ) ) { ?>
		pagination: '<?php echo $settings->pagination; ?>',
		perPage: <?php echo ! empty( $settings->images_per_page ) ? absint( $settings->images_per_page ) : 6; ?>,
		<?php } ?>
		<?php if ( isset( $module->template_id ) ) { ?>
		templateId: '<?php echo $module->template_id; ?>',
		templateNodeId: '<?php echo $module->template_node_id; ?>',
		<?php } ?>
		settings: <?php echo json_encode( $settings ); ?>,
		isBuilderActive: <?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>
	};

	pp_gallery_<?php echo $id; ?> = new PPGallery(options);

	// expandable row fix.
	var state = 0;
	$(document).on('pp_expandable_row_toggle', function(e, selector) {
		if ( selector.is('.pp-er-open') && state === 0 ) {
			new PPGallery(options);
			state = 1;
		}
	});

	// accordion fix
	var accordion_state = false;
	$(document).on('pp-accordion-toggle-complete', function(e, selector) {
		if ( ! accordion_state ) {
			new PPGallery(options);
			accordion_state = true;
		}
	});

	// tabs fix
	var tabs_state = false;
	$(document).on('pp-tabs-switched', function(e, selector) {
		if ( selector.find('.pp-photo-gallery-content').length > 0 && ! tabs_state ) {
			new PPGallery(options);
			tabs_state = true;
		}
	});
})(jQuery);
