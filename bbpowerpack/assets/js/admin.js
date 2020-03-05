;(function($) {

	PPAdminNotices = {
		init: function() {
			var self = this;
			if ( $('.pp-latest-update-notice').length > 0 ) {
				$('.pp-latest-update-notice').on('click', '.notice-dismiss', function() {
					self.close();
				});
			}
		},

		close: function() {
			$.ajax({
				type: 'post',
				url: ajaxurl,
				data: {
					action: 'pp_notice_close',
					notice: 'latest_update',
					nonce: $('.pp-latest-update-notice').data('nonce')
				},
				success: function(res) {
					if ( 'object' === typeof res ) {
						if ( res.error ) {
							alert( res.data );
							return;
						}
					}
					$('.pp-latest-update-notice').slideUp(200, function() {
						$(this).remove();
					});
				}
			});
		}
	};

	PPAdminNotices.init();

})(jQuery);