(function($) {
    $('.fl-node-<?php echo $id; ?> .pp-column-separator').closest('.fl-col').css({'position': 'relative'});
    $('.fl-node-<?php echo $id; ?> .pp-side-triangle').css('top', $('.fl-node-<?php echo $id; ?> .pp-column-separator').closest('.fl-col').outerHeight()/2 - $('.fl-node-<?php echo $id; ?> .pp-side-triangle').height()/2 + "px");
    $('.fl-node-<?php echo $id; ?> .pp-big-triangle-side').css({'width': $('.fl-node-<?php echo $id; ?> .pp-column-separator-wrap.pp-big-side-separator').closest('.fl-col').height()+2+'px'});
})(jQuery);
