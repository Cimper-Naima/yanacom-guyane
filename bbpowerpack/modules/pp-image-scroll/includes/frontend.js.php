;(function($){

	new PPImageScroll({
		id:              '<?php echo $id; ?>',
		imgHeight:       '<?php echo $settings->photo_height; ?>',
		imgTriggerOn:    '<?php echo $settings->img_trigger; ?>',
		scrollSpeed:     '<?php echo $settings->scroll_speed; ?>',
		scrollDir:       '<?php echo $settings->scroll_dir; ?>',
		reverseDir:      '<?php echo $settings->reverse_dir; ?>',
		isBuilderActive:  <?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>,
	});

})(jQuery);
