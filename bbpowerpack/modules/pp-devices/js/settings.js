;(function($) {
	FLBuilder.registerModuleHelper(
		'pp-devices',
		{
			init: function() {
				var form = $( '.fl-builder-settings' );
				var self = this;

				self._toggleVideoType();
				form.find( '#fl-field-video_type .pp-field-switch' ).on(
					'change',
					function() {
						self._toggleVideoType();
					}
				);

				self._toggleScrollable();
				form.find( '#fl-field-scrollable .pp-field-switch' ).on(
					'change',
					function () {
						self._toggleScrollable();
					}
				);

				self._toggleMediaType();
				form.find( '#fl-field-media_type select[name=media_type]' ).on(
					'change',
					function () {
						self._toggleMediaType();
					}
				);

				form.find( '#fl-field-video_src select[name=video_src]' ).on(
					'change',
					function () {
						self._toggleVideoSrc();
					}
				);

			},
			_toggleVideoType: function () {
				$( 'tr[id^=fl-field-mp4_]' ).hide();
				$( 'tr[id^=fl-field-m4v_]' ).hide();
				$( 'tr[id^=fl-field-ogg_]' ).hide();
				$( 'tr[id^=fl-field-webm_]' ).hide();
				var form       = $( '.fl-builder-settings' );
				var video_type = form.find( '#fl-field-video_type .pp-field-switch' ).val();
				if ('' === video_type || 'mp4' === video_type) {
					$( 'tr[id^=fl-field-mp4_video_source]' ).show();
				} else if ('m4v' === video_type) {
					$( 'tr[id^=fl-field-m4v_video_source]' ).show();
				} else if ('ogg' === video_type) {
					$( 'tr[id^=fl-field-ogg_video_source]' ).show();
				} else if ('webm' === video_type) {
					$( 'tr[id^=fl-field-webm_video_source]' ).show();
				}
			},
			_toggleMediaType: function() {
				var form       = $( '.fl-builder-settings' );
				var media_type = form.find( '#fl-field-media_type select[name=media_type]' ).val();
				if ( 'image' === media_type ) {
					setTimeout(
						function () {
							$( '#fl-builder-settings-section-video, #fl-builder-settings-section-embed_video,#fl-builder-settings-section-behaviour' ).hide();
							$( '#fl-builder-settings-section-display, #fl-builder-settings-section-volume,#fl-builder-settings-section-video_overlay' ).hide();
							$( '#fl-builder-settings-section-video_interface, #fl-builder-settings-section-video_buttons' ).hide();
						},
						1500
					);
				} else if ('video' === media_type) {
					form.find( '#fl-field-video_src select[name=video_src]' ).trigger( 'change' );
				}
			},
			_toggleVideoSrc: function () {
				this._toggleVideoType();
			},
			_toggleScrollable: function() {
				var form       = $( '.fl-builder-settings' );
				var scrollable = form.find( '#fl-field-scrollable .pp-field-switch' ).val();
				if ( 'yes' === scrollable ) {
					$( '#fl-field-vertical_alignment' ).hide();
					$( '#fl-field-top_offset' ).hide();
				} else {
					var vertical_alignment = form.find( '#fl-field-vertical_alignment .pp-field-switch' ).val();
					if ('custom' === vertical_alignment ) {
						$( '#fl-field-top_offset' ).show();
					}
				}
			}
		}
	);
})( jQuery );
