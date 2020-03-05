;(function($) {

	$(window).on('load', function() {
		setTimeout(function() {
			new PPInfoBanner({
				id: '<?php echo $id; ?>'
			});
		}, 500);
	});

})(jQuery);
