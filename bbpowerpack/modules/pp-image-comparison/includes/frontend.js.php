;(function($){

	new PPImageComparison({
		id:              '<?php echo $id; ?>',
		beforeLabel:     '<?php echo $settings->before_img_label; ?>',
		afterLabel:      '<?php echo $settings->after_img_label; ?>',
		visibleRatio:    '<?php echo $settings->visible_ratio; ?>',
		imgOrientation:  '<?php echo $settings->img_orientation; ?>',
		sliderHandle:    <?php echo 'drag' === $settings->move_slider ? 'true' : 'false'; ?>,
		sliderHover:     <?php echo 'mouse_move' === $settings->move_slider ? 'true' : 'false'; ?>,
		sliderClick:     <?php echo 'mouse_click' === $settings->move_slider ? 'true' : 'false'; ?>,
		isBuilderActive: <?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>,
	});

})(jQuery);
