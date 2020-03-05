(function($){

	var currentIndex = 0;

	FLBuilder.registerModuleHelper('pp-hotspot', {
		_currentIndex: 0,

		init: function() {
			var self = this;

			$('body').delegate('.fl-builder-settings #fl-field-markers_content .fl-form-field-edit', 'click', function() {
				var row = $(this).parents('.fl-builder-field-multiple');
				self._currentIndex = currentIndex = row.index();
			});
		}
	});

	FLBuilder.registerModuleHelper('pp_marker_form', {
		init: function() {
			if ( 'undefined' === typeof FLBuilderSettingsForms ) {
				return;
			}
			
			var node = $('.fl-node-' + FLBuilderSettingsForms.config.nodeId);
			var marker = node.find('.pp-marker-' + (currentIndex + 1));

			if ( $('input[name="marker_title"]').val() === '' ) {
				$('input[name="marker_title"]').val('Marker ' + (currentIndex + 1));
			}
			
			$('input[name="marker_position_horizontal"]').on('input change keyup blur', function() {
				marker.css('left', $('input[name="marker_position_horizontal"]').val() + '%');
			});
			$('input[name="marker_position_vertical"]').on('input change keyup blur', function() {
				marker.css('top', $('input[name="marker_position_vertical"]').val() + '%');
			});
			
			var form = $( '.fl-builder-lightbox[data-parent]:visible' );
			var formId = form.attr( 'data-instance-id' );

			if ( 'undefined' === typeof FLLightbox ) {
				return;
			}

			var formObj = FLLightbox._instances[ formId ];

			formObj.on( 'close', function() {
				marker.removeAttr('style');
			});
		}
	});

})(jQuery);