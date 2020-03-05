;(function($) {
    $( '#pp-dotnav-<?php echo $id; ?> .pp-dot a' ).on( 'click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if( 0 === $( '#'+$(this).data('row-id') ).length ) {
            return;
        }
        if ( $( 'html, body' ).is(':animated') ) {
        	return;
        }
        $( 'html, body' ).animate({
            scrollTop: $( '#'+$(this).data('row-id') ).offset().top - <?php echo absint($settings->top_offset); ?>
        }, <?php echo absint($settings->scroll_speed); ?>);
        $( '#pp-dotnav-<?php echo $id; ?> .pp-dot' ).removeClass( 'active' );
        $(this).parent().addClass( 'active' );
        return false;
    } );
    updateDot();
    $(window).on('scroll', function() {
        updateDot();
    });
    function updateDot() {
        $('.fl-row').each(function(){
            var $this = $(this);
            if ( ( $this.offset().top - $(window).height()/2 < $(window).scrollTop() ) && ( $this.offset().top >= $(window).scrollTop() || $this.offset().top + $this.height() - $(window).height()/2 > $(window).scrollTop() ) ) {
                $( '#pp-dotnav-<?php echo $id; ?> .pp-dot a[data-row-id="'+$this.attr('id')+'"]' ).parent().addClass('active');
            } else {
                $( '#pp-dotnav-<?php echo $id; ?> .pp-dot a[data-row-id="'+$this.attr('id')+'"]' ).parent().removeClass('active');
            }
        });
    }
    <?php if ( isset($settings->scroll_wheel) && 'enable' == $settings->scroll_wheel && ! FLBuilderModel::is_builder_active() ) { ?>
        var lastAnimation = 0,
            quietPeriod = 500,
            animationTime = 800,
            startX,
            startY,
            timestamp;
        $(document).on('mousewheel DOMMouseScroll', function(e){
            var timeNow = new Date().getTime();
            if(timeNow - lastAnimation < quietPeriod + animationTime) {
                e.preventDefault();
                return;
            }
        	wDelta = e.wheelDelta < 0 ? 'down' : 'up';
            var delta = e.originalEvent.detail < 0 || e.originalEvent.wheelDelta > 0 ? 1 : -1;
            if ( !$("html,body").is(":animated") ) {
                if ( delta < 0 ) {
                    if ( $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).next().length > 0 ) {
                    	$( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).next().find('a').trigger('click');
                    }
                } else {
                    if ( $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).prev().length > 0 ) {
                    	$( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).prev().find('a').trigger('click');
                    }
                }
            }
            lastAnimation = timeNow;
        });
        <?php if ( isset( $settings->scroll_touch ) && 'enable' == $settings->scroll_touch ) { ?>
        $(document).on('pointerdown touchstart', function(e) {
            var touches = e.originalEvent.touches;
            if (touches && touches.length) {
                startY = touches[0].screenY;
                timestamp = e.originalEvent.timeStamp;
            }
        }).on('touchmove', function(e) {
            if($("html,body").is(":animated")) {
                e.preventDefault();
            }
        }).on('pointerup touchend', function(e) {
            var touches = e.originalEvent;
            if (touches.pointerType === 'touch' || e.type === 'touchend') {
                var Y = touches.screenY || touches.changedTouches[0].screenY;
                var deltaY = startY - Y;
                var time = touches.timeStamp - timestamp;
                // swipe up.
                if (deltaY < 0) {
                    if ( $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).prev().length > 0 ) {
                    	$( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).prev().find('a').trigger('click');
                    }
                }
                // swipe down.
                if (deltaY > 0) {
                    if ( $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).next().length > 0 ) {
                    	$( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).next().find('a').trigger('click');
                    }
                }
                if (Math.abs(deltaY) < 2) {
                    return;
                }
            }
        });
        <?php } ?>
    <?php } ?>
    <?php if ( 'enable' == $settings->scroll_keys ) { ?>
        $(document).keydown(function(e) {
            var tag = e.target.tagName.toLowerCase();
            if (tag === 'input' && tag === 'textarea') {
                return;
            }
            switch(e.which) {
                case 38: // up arrow key.
                    $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).prev().find('a').trigger('click');
                break;
                case 40: // down arrow key.
                    $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).next().find('a').trigger('click');
                break;
                case 33: // pageup key.
                    $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).prev().find('a').trigger('click');
                break;
                case 36: // pagedown key.
                    $( '#pp-dotnav-<?php echo $id; ?> .pp-dot.active' ).next().find('a').trigger('click');
                break;
                default: return;
            }
        });
    <?php } ?>
})(jQuery);
