(function($) {

        $(".fl-node-<?php echo $id; ?> table.pp-table-content tbody tr:nth-child(odd)").addClass("odd");
		$(".fl-node-<?php echo $id; ?> table.pp-table-content tbody tr:nth-child(even)").addClass("even");

		$( document ).trigger( "enhance.tablesaw" );

		$(document).on('pp-tabs-switched', function(e, selector) {
			if ( selector.find('.pp-table-content').length > 0 ) {
				$( window ).trigger( "resize" );
			}
		});

})(jQuery);
