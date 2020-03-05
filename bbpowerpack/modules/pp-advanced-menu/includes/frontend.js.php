<?php

	// set defaults
	$type 				= isset( $settings->menu_layout ) ? $settings->menu_layout : 'horizontal';
	$mobile 			= isset( $settings->mobile_toggle ) ? $settings->mobile_toggle : 'expanded';
	$mobile_breakpoint 	= isset( $settings->mobile_breakpoint ) ? $settings->mobile_breakpoint : 'mobile';
 ?>

(function($) {

    new PPAdvancedMenu({
    	id: '<?php echo $id ?>',
    	type: '<?php echo $type ?>',
    	mobile: '<?php echo $mobile ?>',
		breakPoints: {
			medium: <?php echo empty( $global_settings->medium_breakpoint ) ? '' : $global_settings->medium_breakpoint; ?>,
			small: <?php echo empty( $global_settings->responsive_breakpoint ) ? '' : $global_settings->responsive_breakpoint; ?>,
			custom: <?php echo empty($settings->custom_breakpoint) ? 0 : $settings->custom_breakpoint; ?>
		},
		mobileBreakpoint: '<?php echo $mobile_breakpoint ?>',
		mediaBreakpoint: '<?php echo $module->get_media_breakpoint(); ?>',
		mobileMenuType: '<?php echo $settings->mobile_menu_type; ?>',
		offCanvasDirection: '<?php echo $settings->offcanvas_direction; ?>',
		fullScreenAnimation: '',
		isBuilderActive: <?php echo ( FLBuilderModel::is_builder_active() ) ? 'true' : 'false'; ?>
    });

})(jQuery);
