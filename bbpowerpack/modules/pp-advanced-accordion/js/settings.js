(function($){

	FLBuilder.registerModuleHelper(
		'pp-advanced-accordion', {

		rules: {
			item_spacing: {
				required: true,
				number: true
			}
		},

		_templates: {
			module: '',
			row: '',
			layout: ''
		},

		init: function()
		{
			var form            = $('.fl-builder-settings'),
				itemSpacing     = form.find('input[name=item_spacing]');
			
			this._getPostSlugOnChange();
			
			itemSpacing.on('keyup', this._previewItemSpacing);

			$('body').delegate( '.fl-builder-settings select[name="content_type"]', 'change', $.proxy(this._contentTypeChange, this) );
		},

		_previewLabelSize: function()
		{
			wrap  = FLBuilder.preview.elements.node.find('.pp-accordion');
		},

		_previewItemSpacing: function()
		{
			var spacing = parseInt($('.fl-builder-settings input[name=item_spacing]').val(), 10),
				items   = FLBuilder.preview.elements.node.find('.pp-accordion-item');

			items.attr('style', '');

			if(isNaN(spacing) || spacing === 0) {
				items.css('margin-bottom', '0px');
				items.not(':last-child').css('border-bottom', 'none');
			}
			else {
				items.css('margin-bottom', spacing + 'px');
			}
		},

		_contentTypeChange: function(e)
		{
			var type = $(e.target).val();

			if ( 'module' === type ) {
				this._setTemplates('module');
			}
			if ( 'row' === type ) {
				this._setTemplates('row');
			}
			if ( 'layout' === type ) {
				this._setTemplates('layout');
			}
		},

		_getTemplates: function(type, callback)
		{
			if ( 'undefined' === typeof type ) {
				return;
			}

			if ( 'undefined' === typeof callback ) {
				return;
			}

			var self = this;

			$.post(
				ajaxurl,
				{
					action: 'pp_get_saved_templates',
					type: type
				},
				function( response ) {
					callback(response);
				}
			);
		},

		_setTemplates: function(type)
		{
			var form = $('.fl-builder-settings'),
				select = form.find( 'select[name="content_' + type + '"]' ),
				value = '', self = this;

			if ( 'undefined' !== typeof FLBuilderSettingsForms && 'undefined' !== typeof FLBuilderSettingsForms.config ) {
				if ( "pp_accordion_items_form" === FLBuilderSettingsForms.config.id ) {
					value = FLBuilderSettingsForms.config.settings['content_' + type];
				}
			}

			if ( this._templates[type] !== '' ) {
				select.html( this._templates[type] );
				select.find( 'option[value="' + value + '"]').attr('selected', 'selected');

				return;
			}

			this._getTemplates(type, function(data) {
				var response = JSON.parse( data );

				if ( response.success ) {
					self._templates[type] = response.data;
					select.html( response.data );
					if ( '' !== value ) {
						select.find( 'option[value="' + value + '"]').attr('selected', 'selected');
					}
				}
			});
		},

		_getPostSlugOnChange: function() {
			$( '.fl-builder-settings select[name=post_slug]' ).on(
				"change",
				function(){
					$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter' ).css( 'display', 'none' );

					$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter.fl-custom-query-' + $( this ).val() + '-filter' ).css( 'display', 'table' );

					$( '.fl-builder-settings select[name=posts_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_tax_type]' ).on(
						"change",
						function () {

							$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter.fl-custom-query-' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '-filter tr.fl-field' ).show();
							$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter.fl-custom-query-' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '-filter tr.fl-field:not(#fl-field-tax_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_' + $( this ).val() + ', #fl-field-posts_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_tax_type)' ).hide();

							$( '.fl-builder-settings select[name=tax_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_' + $( this ).val() + '_matching] option:selected' ).ready(
								function(){
									setTimeout( function () { $( '.fl-builder-settings select[name=tax_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_' + $( '.fl-builder-settings select[name=posts_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_tax_type]' ).val() + '_matching]' ).trigger( "change" ); }, 1000 );
								}
							);

						}
					);
					$( '.fl-builder-settings select[name=posts_' + $( '.fl-builder-settings select[name=post_slug]' ).val() + '_tax_type]' ).trigger( "change" );
				}
			);

			$( '.fl-builder-settings select[name=post_slug]' ).trigger( "change" );
		}
	});

})(jQuery);
