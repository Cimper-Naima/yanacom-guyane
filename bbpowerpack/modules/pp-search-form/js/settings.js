(function($){

	FLBuilder.registerModuleHelper('pp-search-form', {
		init: function() {
			var form = $('.fl-builder-settings'),
				nodeId = form.data('node'),
				node = $('.fl-node-' + nodeId);

			form.find('input[name="toggle_icon_size"]').on('change keyup blur', function() {
				var size = $(this).val();
				var style = '--toggle-icon-size: calc( ' + size + 'em / 100 )'
				node.find('.pp-search-form__toggle i').attr('style', style);
			});

			form.find('select[name="style"]').on('change', function() {
				var layout = $(this).val();

				if ( 'full_screen' === layout ) {
					form.find('#fl-field-toggle_size').show();
					form.find('#fl-field-input_height').show();
					form.find('#fl-field-size').hide();
					form.find('#fl-field-input_bg_color').hide();
					form.find('#fl-field-input_focus_bg_color').hide();
				} else {
					form.find('#fl-field-toggle_size').hide();
					form.find('#fl-field-input_height').hide();
					form.find('#fl-field-size').show();
					form.find('#fl-field-input_bg_color').show();
					form.find('#fl-field-input_focus_bg_color').show();
				}
			});

			form.find('select[name="style"]').trigger('change');
		}
	});

})(jQuery);