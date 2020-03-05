(function($){

	FLBuilder.registerModuleHelper('pp-pricing-table', {
		node: '',
		rules: {},
		_dualPricing: '',

		init: function()
		{
			var self = this;

			$( 'input[name=btn_bg_color]' ).on( 'change', this._bgColorChange );
			this._bgColorChange();

			this.node = $('form.fl-builder-pp-pricing-table-settings').data('node');
			//$( 'input[name="pricing_columns[]"]' ).on( 'change', this._pricingColumnChange );
			//this._pricingColumnChange();

			if ( $( 'input[name="dual_pricing"' ).length > 0 ) {
				this._dualPricing = $( 'input[name="dual_pricing"' ).val();
				$( 'input[name="dual_pricing"' ).on( 'change', function() {
					self._dualPricing = $(this).val();
					self._updateStyles();
				} );
			}

			self._updateStyles();
		},

		_bgColorChange: function()
		{
			var bgColor = $( 'input[name=btn_bg_color]' ),
				style   = $( '#fl-builder-settings-section-btn_style' );

			if ( '' == bgColor.val() ) {
				style.hide();
			}
			else {
				style.show();
			}
		},

		_updateStyles: function()
		{
			$('#pp-pricing-table-form').remove();
			var styleNode = $('<style id="pp-pricing-table-form"></style>');

			if ( 'yes' == this._dualPricing ) {
				var styleText = 'form[data-form-id="pp_pricing_column_form"] #fl-field-price_2,' +
								'form[data-form-id="pp_pricing_column_form"] #fl-field-duration_2,' +
								'form[data-form-id="pp_pricing_column_form"] #fl-field-button_url_2' +
								' {display: table-row;}';
				styleNode.text( styleText );
				$(document.head).append( styleNode );
			} else {
				var styleText = 'form[data-form-id="pp_pricing_column_form"] #fl-field-price_2,' +
								'form[data-form-id="pp_pricing_column_form"] #fl-field-duration_2,' +
								'form[data-form-id="pp_pricing_column_form"] #fl-field-button_url_2' +
								' {display: none;}';
				styleNode.text( styleText );
				$(document.head).append( styleNode );
			}
		},

		_pricingColumnChange: function()
		{

			$.ajax({
				type: 'POST',
				data: { action: 'hl_package', node_preview: 1, node_id: this.node },
				url: ajaxurl,
				success: function( res ) {
					if ( res !== 'undefined' || res !== '' ) {

						var selected = parseInt(res); console.log(res);
						var count = 0;
						var html = '';

						$( 'input[name="pricing_columns[]"]' ).each(function() {
							var data = JSON.parse( $(this).val() );
							if ( count === selected ) {
								html += '<option value="'+count+'" selected="selected">'+data.title+'</option>';
							} else {
								html += '<option value="'+count+'">'+data.title+'</option>';
							}
							count++;
						});

						$( 'select[name="hl_package"]' ).html(html);
					}
				}
			});
		}
	});

})(jQuery);
