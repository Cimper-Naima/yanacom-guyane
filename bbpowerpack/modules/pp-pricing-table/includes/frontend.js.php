;(function($) {

	new PPPricingTable({
		id: '<?php echo $id; ?>',
		dualPricing: <?php echo ( 'yes' == $settings->dual_pricing ) ? 'true' : 'false'; ?>
	});

	$(document).ready(function() {
		var spaceHeight = $('.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-card .pp-pricing-table-price').outerHeight();
		$(".fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-matrix .pp-pricing-table-price").css('height', spaceHeight + 'px');

		$('.fl-node-<?php echo $id; ?> .pp-pricing-table-matrix .pp-pricing-table-features li').each(function() {
			var height = $(this).outerHeight();
			var index = $(this).index();

			$('.fl-node-<?php echo $id; ?> .pp-pricing-table-card .pp-pricing-table-features li.pp-pricing-table-item-' + (index+1)).css('height', height + 'px');
		});

		$(window).on('resize', function() {
			var spaceHeight = $('.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-card .pp-pricing-table-price').outerHeight();
			$(".fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-matrix .pp-pricing-table-price").css('height', spaceHeight + 'px');

			$('.fl-node-<?php echo $id; ?> .pp-pricing-table-matrix .pp-pricing-table-features li').each(function() {
				var height = $(this).outerHeight();
				var index = $(this).index();

				$('.fl-node-<?php echo $id; ?> .pp-pricing-table-card .pp-pricing-table-features li.pp-pricing-table-item-' + (index+1)).css('height', height + 'px');
			});
		});
	});

})(jQuery);