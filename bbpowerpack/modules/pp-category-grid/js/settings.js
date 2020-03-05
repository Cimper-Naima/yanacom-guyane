(function($) {

	FLBuilder.registerModuleHelper(
		'pp-category-grid',
		{
			rules: '',

			init: function()
		{

				$( '.fl-builder-settings select[name=post_type]' ).on(
					"change",
					function(){
						$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter' ).css( 'display', 'none' );

						$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter.fl-custom-query-' + $( this ).val() + '-filter' ).css( 'display', 'table' );

						$( '.fl-builder-settings select[name=posts_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_tax_type]' ).on(
							"change",
							function () {

								$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter.fl-custom-query-' + $( '.fl-builder-settings select[name=post_type]' ).val() + '-filter tr.fl-field' ).show();
								$( '.fl-builder-settings .fl-form-table.fl-custom-query-filter.fl-custom-query-' + $( '.fl-builder-settings select[name=post_type]' ).val() + '-filter tr.fl-field:not(#fl-field-tax_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_' + $( this ).val() + ', #fl-field-posts_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_tax_type)' ).hide();

								$( '.fl-builder-settings select[name=tax_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_' + $( this ).val() + '_matching] option:selected' ).ready(
									function(){
										setTimeout( function () { $( '.fl-builder-settings select[name=tax_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_' + $( '.fl-builder-settings select[name=posts_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_tax_type]' ).val() + '_matching]' ).trigger( "change" ); }, 1000 );
									}
								);

							}
						);
						$( '.fl-builder-settings select[name=posts_' + $( '.fl-builder-settings select[name=post_type]' ).val() + '_tax_type]' ).trigger( "change" );
					}
				);

				$( '.fl-builder-settings select[name=post_type]' ).trigger( "change" );
			}
		}
	);

})( jQuery );
