(function($) {

	<?php if( $settings->layouts == '1' ) { ?>
		$('.fl-node-<?php echo $id; ?> .pp-list-connector').css('left', ( $('.fl-node-<?php echo $id; ?> .pp-icon-wrapper').width() )/2 + "px");
	<?php } ?>
	<?php if( $settings->layouts == '2' ) { ?>
		$('.fl-node-<?php echo $id; ?> .pp-list-connector').css('right', ( $('.fl-node-<?php echo $id; ?> .pp-icon-wrapper').width() )/2 + "px");
	<?php } ?>
	<?php if( $settings->layouts == '3' ) { ?>
		$('.fl-node-<?php echo $id; ?> .pp-list-connector').css('top', ( $('.fl-node-<?php echo $id; ?> .pp-icon-wrapper').height() )/2 + "px");
		$('.fl-node-<?php echo $id; ?> .pp-list-connector').css('left', ( $('.fl-node-<?php echo $id; ?> .pp-list-item').outerWidth() )/2 + "px");
	<?php } ?>
})(jQuery);
