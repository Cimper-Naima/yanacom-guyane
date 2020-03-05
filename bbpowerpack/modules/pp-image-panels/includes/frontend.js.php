(function($) {
    function pp_render_panels() {
        if( $(window).width() > 768 ) {
            <?php
            $number_panels = count($settings->image_panels);
            for( $i = 0; $i < $number_panels; $i++ ) {
            	$panel = $settings->image_panels[$i];

                if ( !is_object($panel) ) {
                    continue;
                }

                if($panel->link_type == 'none' || $panel->link_type == 'title') { ?>
                    <?php if( $number_panels == 2 ) { ?>
                    $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?>').css('width', <?php echo 100/($number_panels); ?> + '%');

                    $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?>').on('mouseenter', function() {
                        $(this).css('width', '70%');
                        $(this).siblings().css('width', '30%');
                    });
                    <?php } else if( $number_panels > 2 ) { ?>
                    $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?>').on('mouseenter', function() {
                        $(this).css('width', '40%');
                        $(this).siblings().css('width', <?php echo 60/($number_panels-1); ?> + '%');
                    });
                    <?php } ?>
                    $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?>').on('mouseleave', function() {
                        $(this).css('width', <?php echo 100/($number_panels); ?> + '%');
                        $(this).siblings().css('width', <?php echo 100/($number_panels); ?> + '%');
                    });
                <?php } else if($panel->link_type == 'panel' || $panel->link_type == 'lightbox') { ?>
                    $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-link-<?php echo $i; ?>').css('width', <?php echo 100/($number_panels); ?> + '%');
                    
					<?php if( $number_panels == 2 ) { ?>
                        $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-link-<?php echo $i; ?>').on('mouseenter', function() {
                            $(this).css('width', '70%');
                            $(this).siblings().css('width', '30%');
                        });
                    <?php } else if( $number_panels > 2 ) { ?>
                        $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-link-<?php echo $i; ?>').on('mouseenter', function() {
                            $(this).css('width', '40%');
                            $(this).siblings().css('width', <?php echo 60/($number_panels-1); ?> + '%');
                        });
                    <?php } ?>
                    $('.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-link-<?php echo $i; ?>').on('mouseleave', function() {

                        $(this).css('width', <?php echo 100/($number_panels); ?> + '%');
                        $(this).siblings().css('width', <?php echo 100/($number_panels); ?> + '%');

                    });
                <?php } ?>
            <?php } ?>
        }
    }
    pp_render_panels();
    $(window).resize(function() {
        pp_render_panels();
    });

	if ( $('.fl-node-<?php echo $id; ?> a.pp-panel-has-lightbox').length > 0 ) {
		$('.fl-node-<?php echo $id; ?> a.pp-panel-has-lightbox').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false
		});
	}

})(jQuery);
