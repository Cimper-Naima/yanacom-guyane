;(function($) {
	
	new PPVideo({
		id: '<?php echo $id; ?>',
		type: '<?php echo $settings->video_type; ?>',
		aspectRatio: '<?php echo $settings->aspect_ratio; ?>',
		lightbox: <?php echo $module->has_lightbox() ? 'true' : 'false'; ?>,
		overlay: <?php echo $module->has_image_overlay() ? 'true' : 'false'; ?>,
	});

})(jQuery);
