(function($) {

	$(function() {
		<?php
		if ( 'first' === $settings->expand_option ) {
			$default_item = '1';
		} elseif ( 'custom' === $settings->expand_option ) {
			$default_item = ( absint( $settings->open_custom ) > 0 ? absint( $settings->open_custom ) : 'false' );
		} elseif ( 'all' === $settings->expand_option ) {
			$default_item = 'all';
		} else {
			$default_item = 'none';
		}
		?>
		new PPFAQModule({
			id: '<?php echo $id; ?>',
			defaultItem: '<?php echo $default_item; ?>',
			responsiveCollapse: <?php echo ( isset( $settings->responsive_collapse ) && 'yes' === $settings->responsive_collapse ) ? 'true' : 'false'; ?>
		});
	});

})(jQuery);
