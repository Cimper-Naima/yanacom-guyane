(function($){

	FLBuilder.registerModuleHelper('pp-advanced-tabs', {

		_templates: {
			module: '',
			row: '',
			layout: ''
		},

		init: function()
		{
			$('body').delegate( '.fl-builder-settings select[name="content_type"]', 'change', $.proxy(this._contentTypeChange, this) );
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
				if ( "tab_items_form" === FLBuilderSettingsForms.config.id ) {
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
		}
	});

})(jQuery);
