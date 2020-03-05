(function ($) {

	FLBuilder.registerModuleHelper('pp-countdown', {

		rules: {
			title: {
				required: true
			}
		},
		submit: function () {

			var timer_type = this._getField('timer_type').val(),
				day = parseInt(this._getField('fixed_date_days').val(),),
				month = parseInt(this._getField('fixed_date_month').val(),),
				year = parseInt(this._getField('fixed_date_year').val(),),
				hour = parseInt(this._getField('fixed_date_hours').val(),),
				minute = parseInt(this._getField('fixed_date_minutes').val(),),
				date = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':00 ';

			if (timer_type == "fixed" && Date.parse(date) <= Date.now()) {
				FLBuilder.alert("Error! You should select date in the future.");
				return false;
			}
			return true;

		},
		
		_getField: function(name)
		{
			var form = $('.fl-builder-settings');
			var field = form.find( '[name="' + name + '"]' );

			return field;
		},

		init: function () {
			this._getField('timer_type').on('change', $.proxy( this.hide_fields, this ));
			this._getField('show_year').on('change', $.proxy(this.hide_fields, this));
			this._getField('show_month').on('change', $.proxy(this.hide_fields, this));
			this._getField('show_day').on('change', $.proxy(this.hide_fields, this));
			this._getField('show_hour').on('change', $.proxy(this.hide_fields, this));
			this._getField('show_minute').on('change', $.proxy(this.hide_fields, this));
			this._getField('show_second').on('change', $.proxy(this.hide_fields, this));
			this._getField('timer_type').on('change', $.proxy(this.hide_timer_type, this));
			this._getField('evergreen_timer_action').on('change', $.proxy(this.hide_timer_type, this));
			this._getField('fixed_timer_action').on('change', $.proxy(this.hide_timer_type, this));
			this._getField('block_style').on('change', $.proxy(this.hide_bg_color_fields, this));
			this._getField('label_position').on('change', $.proxy(this.hide_margin_fields, this));
			this._getField('show_separator').on('change', $.proxy(this.hide_margin_fields, this));

			this.hide_fields();
			this.hide_timer_type();
			this.hide_margin_fields();
			this.hide_bg_color_fields();

			setTimeout( $.proxy(function() {
				this._getField('timer_type').trigger('change');
			}, this), 100 );
		},

		hide_fields: function () {
			var timer_type 	= this._getField('timer_type').val(),
				show_year 	= this._getField('show_year').val(),
				show_month 	= this._getField('show_month').val(),
				show_day 	= this._getField('show_day').val(),
				show_hour 	= this._getField('show_hour').val(),
				show_minute = this._getField('show_minute').val(),
				show_second = this._getField('show_second').val();

			if ('fixed' === timer_type) {
				$("#fl-field-show_year").show();
				if ('' === show_year) {
					$("#fl-field-year_label_plural").hide();
					$("#fl-field-year_label_singular").hide();
				} else {
					$("#fl-field-year_label_plural").show();
					$("#fl-field-year_label_singular").show();
				}
			} else {
				$("#fl-field-year_label_plural").hide();
				$("#fl-field-year_label_singular").hide();
				$("#fl-field-show_year").hide();
			}

			if ('' === show_month) {
				$("#fl-field-month_label_plural").hide();
				$("#fl-field-month_label_singular").hide();
			} else {
				$("#fl-field-month_label_plural").show();
				$("#fl-field-month_label_singular").show();
			}

			if ('D' !== show_day) {
				$("#fl-field-day_label_plural").hide();
				$("#fl-field-day_label_singular").hide();
			} else {
				$("#fl-field-day_label_plural").show();
				$("#fl-field-day_label_singular").show();
			}

			if ('' === show_hour) {
				$("#fl-field-hour_label_plural").hide();
				$("#fl-field-hour_label_singular").hide();
			} else {
				$("#fl-field-hour_label_plural").show();
				$("#fl-field-hour_label_singular").show();
			}

			if ('' === show_minute) {
				$("#fl-field-minute_label_plural").hide();
				$("#fl-field-minute_label_singular").hide();
			} else {
				$("#fl-field-minute_label_plural").show();
				$("#fl-field-minute_label_singular").show();
			}

			if ('' === show_second) {
				$("#fl-field-second_label_plural").hide();
				$("#fl-field-second_label_singular").hide();
			} else {
				$("#fl-field-second_label_plural").show();
				$("#fl-field-second_label_singular").show();
			}
			
			$('#fl-field-separator_size').hide();

		},
		hide_timer_type: function () {
			var	timer_type = this._getField('timer_type').val(),
				show_year = this._getField('show_year').val(),
				show_month = this._getField('show_month').val(),
				evergreen_timer_action = this._getField('evergreen_timer_action').val(),
				fixed_timer_action = this._getField('fixed_timer_action').val();

			if ('Y' === $("#fl-field-show_year input[name=show_year]").val()) {
				$("#fl-field-year_label_plural").show();
				$("#fl-field-year_label_singular").show();
			}
			if (0 === $("#fl-field-show_month input[name=show_month]").val()) {
				$("#fl-field-month_label_plural").show();
				$("#fl-field-month_label_singular").show();
			}

			if ('evergreen' === timer_type) {
				if ('msg' === evergreen_timer_action) {
					$("#fl-field-redirect_link").hide();
					$("#fl-field-redirect_link_target").hide();
					$("#fl-field-expire_message").show();
					$("#fl-builder-settings-section-message").show();
				} else if ('redirect' === evergreen_timer_action) {
					$("#fl-field-redirect_link").show();
					$("#fl-field-redirect_link_target").show();
					$("#fl-field-expire_message").hide();
					$("#fl-builder-settings-section-message").hide();
				} else {
					$("#fl-field-redirect_link").hide();
					$("#fl-field-redirect_link_target").hide();
					$("#fl-field-expire_message").hide();
					$("#fl-builder-settings-section-message").hide();
				}
			}
			if ( 'fixed' === timer_type ) {
				if ( 'msg' === fixed_timer_action ) {
					$("#fl-field-redirect_link").hide();
					$("#fl-field-redirect_link_target").hide();
					$("#fl-field-expire_message").show();
					$("#fl-builder-settings-section-message").show();
				} else if ( 'redirect' === fixed_timer_action ) {
					$("#fl-field-redirect_link").show();
					$("#fl-field-redirect_link_target").show();
					$("#fl-field-expire_message").hide();
					$("#fl-builder-settings-section-message").hide();
				} else {
					$("#fl-field-redirect_link").hide();
					$("#fl-field-redirect_link_target").hide();
					$("#fl-field-expire_message").hide();
					$("#fl-builder-settings-section-message").hide();
				}
			}
		},
		hide_margin_fields: function () {
			var	label_position 			= this._getField('timer_type').val(),
				block_style 			= this._getField('timer_type').val(),
				label_inside_position 	= this._getField('label_inside_position').val(),
				label_outside_position 	= this._getField('label_outside_position').val(),
				default_position 		= this._getField('default_position').val(),
				show_separator 			= this._getField('show_separator').val(),
				separator_type 			= this._getField('separator_type').val();

			if ( 'inside' === label_position && ( 'in_below' === label_inside_position || 'in_above' === label_inside_position )) {
				$("#fl-field-default_position").hide();
				$("#fl-field-label_inside_position").show();

			}

			if ( 'outside' === label_position && ( 'out_below' === label_outside_position || 'out_above' === label_outside_position || 'out_right' === label_outside_position || 'out_left' === label_outside_position )) {
				$("#fl-field-default_position").hide();
				$("#fl-field-label_outside_position").show();
			}


			if ( 'default' === block_style && 'normal_below' === default_position ) {
				$("#fl-field-label_inside_position").hide();
				$("#fl-field-label_outside_position").hide();
				$("#fl-field-default_position").show();
			}
			if ( 'default' === block_style && 'normal_above' === default_position ) {
				$("#fl-field-label_inside_position").hide();
				$("#fl-field-label_outside_position").hide();
				$("#fl-field-default_position").show();
			}

			if ( 'yes' === show_separator && 'colon' === separator_type ) {
				$('#fl-field-separator_size').show();
			} else {
				$('#fl-field-separator_size').hide();
			}


		},
		hide_bg_color_fields: function () {

			var block_style = this._getField('block_style').val(),
				bg_type = this._getField('block_bg_type').val();

			if ( 'default' === block_style ) {
				$('#fl-field-block_bg_color').hide();
				$('#fl-field-block_bg_color_opc').hide();
				$('#fl-field-block_primary_color').hide();
				$('#fl-field-block_secondary_color').hide();
			} else {
				if ( 'solid' === bg_type ) {
					$('#fl-field-block_bg_color').show();
					$('#fl-field-block_bg_color_opc').show();
					$('#fl-field-block_primary_color').hide();
					$('#fl-field-block_secondary_color').hide();
				}
				if ( 'gradient' === bg_type ) {
					$('#fl-field-block_primary_color').show();
					$('#fl-field-block_secondary_color').show();
					$('#fl-field-block_bg_color').hide();
					$('#fl-field-block_bg_color_opc').hide();
				}
			}
		}
	});
})(jQuery);