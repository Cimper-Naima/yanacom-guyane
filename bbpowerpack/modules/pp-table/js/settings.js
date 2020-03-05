;(function($) {
	
	FLBuilder.registerModuleHelper( 'pp-table', {
		init: function() {
			var form = $('.fl-builder-settings');
			var uploadBtn = form.find('#fl-field-csv_import .pp-field-file-upload');
			var fileInput = form.find('#fl-field-csv_import input.pp-field-file');
			var filenameInput = form.find('#fl-field-csv_import input.pp-field-file-name');
			var nonce = form.find('#fl-field-csv_import input.pp-field-file-nonce').val();
			var file = '';
			var formData = new FormData();

			fileInput.on('change', function() {
				uploadBtn.removeClass('disabled');
				if ( $(this).val() === '' ) {
					return;
				}
				
				file = this.files[0];
				
				var type = file.type;
				var ext = file.name.substr( file.name.length - 4, 4 ).toLowerCase();
				var valid = false;

				if ( "text/csv" === type || ( "application/vnd.ms-excel" === type && ".csv" === ext ) ) {
					valid = true;
				}

				if ( ! valid ) {
					alert('Please select valid CSV file.');
					$(this).val('');
					return false;
				}
			});

			uploadBtn.off('click').on('click', function(e) {
				if ( fileInput.val() === '' ) {
					alert('Please select CSV file.');
					return false;
				}
				formData.append('file', file);
				formData.append('time', new Date().getTime());
				formData.append('nonce', nonce);
				formData.append('pp_action', 'table_csv_upload');

				FLBuilder.preview.delayPreview(e);
				uploadBtn.addClass('disabled');
				fileInput.addClass('disabled');

				$.ajax({
					type: 'POST',
					url: '/',
					data: formData,
					contentType: false,
					processData: false,
					cache: false,
					success: function (response) {
						if ( response.success ) {
							filenameInput.val( JSON.stringify( response.data ) );
							FLBuilder.preview.delayPreview(e);
							form.find('.pp-field-file-msg strong').text( response.data.filename );
						}
						else if ( response.error ) {
							alert( response.data );
							setTimeout(function() {
								uploadBtn.removeClass('disabled');
							}, 1000);
						}
						fileInput.removeClass('disabled');
					}
				});
			});
		}
	});

})(jQuery);