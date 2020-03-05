(function($) {

	window.onLoadFLReCaptcha = function () {
		var reCaptchaFields = $('.fl-grecaptcha'),
			widgetID;

		if (reCaptchaFields.length > 0) {
			reCaptchaFields.each(function (i) {
				var self = $(this),
					attrWidget = self.attr('data-widgetid'),
					newID = $(this).attr('id') + '-' + i;

				// Avoid re-rendering as it's throwing API error
				if ((typeof attrWidget !== typeof undefined && attrWidget !== false)) {
					return;
				}
				else {
					// Increment ID to avoid conflict with the same form.
					self.attr('id', newID);

					widgetID = grecaptcha.render(newID, {
						sitekey: self.data('sitekey'),
						theme: self.data('theme'),
						size: self.data('validate'),
						callback: function (response) {
							if (response != '') {
								self.attr('data-fl-grecaptcha-response', response);

								// Re-submitting the form after a successful invisible validation.
								if ('invisible' == self.data('validate')) {
									self.closest('.pp-contact-form').find('a.fl-button').trigger('click');
								}
							}
						}
					});

					self.attr('data-widgetid', widgetID);
				}
			});
		}
	};

	PPContactForm = function( settings )
	{
		this.settings	= settings;
		this.nodeClass	= '.fl-node-' + settings.id;
		this._init();
	};

	PPContactForm.prototype = {

		settings	: {},
		nodeClass	: '',

		_init: function()
		{
			$( this.nodeClass + ' .fl-button' ).click( $.proxy( this._submit, this ) );
		},

		_submit: function( e )
		{
			var theForm	  		= $(this.nodeClass + ' .pp-contact-form'),
				submit	  		= $(this.nodeClass + ' .fl-button'),
				name	  		= $(this.nodeClass + ' .pp-name input'),
				email			= $(this.nodeClass + ' .pp-email input'),
				phone			= $(this.nodeClass + ' .pp-phone input'),
				subject	  		= $(this.nodeClass + ' .pp-subject input'),
				message	  		= $(this.nodeClass + ' .pp-message textarea'),
				checkbox		= $(this.nodeClass + ' .pp-checkbox input'),
				reCaptchaField 	= $(this.nodeClass + ' .fl-grecaptcha'),
				reCaptchaValue 	= reCaptchaField.data('fl-grecaptcha-response'),
				ajaxData		= null,
				ajaxurl	  		= FLBuilderLayoutConfig.paths.wpAjaxUrl,
				email_regex 	= /\S+@\S+\.\S+/,
				isValid	  		= true,
				postId      	= theForm.closest( '.fl-builder-content' ).data( 'post-id' ),
				templateId		= theForm.data( 'template-id' ),
				templateNodeId	= theForm.data( 'template-node-id' ),
				nodeId      	= theForm.closest( '.fl-module' ).data( 'node' );

			e.preventDefault();

			// End if button is disabled (sent already)
			if (submit.hasClass('pp-disabled')) {
				return;
			}

			// validate the name
			if(name.length) {
				if (name.val() === '') {
					isValid = false;
					name.parent().addClass('pp-error');
				}
				else if (name.parent().hasClass('pp-error')) {
					name.parent().removeClass('pp-error');
				}
			}

			// validate the email
			if(email.length) {
				if (email.val() === '' || !email_regex.test(email.val())) {
					isValid = false;
					email.parent().addClass('pp-error');
				}
				else if (email.parent().hasClass('pp-error')) {
					email.parent().removeClass('pp-error');
				}
			}

			// validate the subject..just make sure it's there
			if(subject.length) {
				if (subject.val() === '') {
					isValid = false;
					subject.parent().addClass('pp-error');
				}
				else if (subject.parent().hasClass('pp-error')) {
					subject.parent().removeClass('pp-error');
				}
			}

			// validate the phone..just make sure it's there
			if(phone.length) {
				if (phone.val() === '') {
					isValid = false;
					phone.parent().addClass('pp-error');
				}
				else if (phone.parent().hasClass('pp-error')) {
					phone.parent().removeClass('pp-error');
				}
			}

			// validate the message..just make sure it's there
			if (message.length > 0) {
				if (message.val() === '') {
					isValid = false;
					message.parent().addClass('pp-error');
				}
				else if (message.parent().hasClass('pp-error')) {
					message.parent().removeClass('pp-error');
				}
			}

			// validate the checkbox
			if (checkbox.length > 0) {
				if (!checkbox.is(':checked')) {
					isValid = false;
					checkbox.parent().addClass('pp-error');
				}
				else if (checkbox.parent().hasClass('pp-error')) {
					checkbox.parent().removeClass('pp-error');
				}
			}

			// validate if reCAPTCHA is enabled and checked
			if (reCaptchaField.length > 0) {
				if ('undefined' === typeof reCaptchaValue || reCaptchaValue === false) {
					isValid = false;
					if ('normal' == reCaptchaField.data('validate')) {
						reCaptchaField.parent().addClass('pp-error');
					} else if ('invisible' == reCaptchaField.data('validate')) {

						// Invoke the reCAPTCHA check.
						grecaptcha.execute(reCaptchaField.data('widgetid'));
					}
				} else {
					reCaptchaField.parent().removeClass('pp-error');
				}
			}

			// end if we're invalid, otherwise go on..
			if (!isValid) {
				return false;
			}
			else {

				// disable send button
				submit.addClass('pp-disabled');

				ajaxData = {
					action: 'pp_send_email',
					name: name.val(),
					subject: subject.val(),
					email: email.val(),
					phone: phone.val(),
					message: message.val(),
					post_id: postId,
					template_id: templateId,
					template_node_id: templateNodeId,
					node_id: nodeId
				}

				if (reCaptchaValue) {
					ajaxData.recaptcha_response = reCaptchaValue;
				}

				// post the form data
				$.post(ajaxurl, ajaxData, $.proxy( this._submitComplete, this ) );
			}
		},

		_submitComplete: function( response )
		{
			var urlField 	= $( this.nodeClass + ' .pp-success-url' ),
				noMessage 	= $( this.nodeClass + ' .pp-success-none' );

			// On success show the success message
			if (typeof response.error !== 'undefined' && response.error === false) {

				$( this.nodeClass + ' .pp-send-error' ).fadeOut();

				if ( urlField.length > 0 ) {
					window.location.href = urlField.val();
				}
				else if ( noMessage.length > 0 ) {
					noMessage.fadeIn();
				}
				else {
					$( this.nodeClass + ' .pp-contact-form' ).hide();
					$( this.nodeClass + ' .pp-success-msg' ).fadeIn();
				}
			}
			// On failure show fail message and re-enable the send button
			else {
				$(this.nodeClass + ' .fl-button').removeClass('pp-disabled');
				if ( typeof response.message !== 'undefined' ) {
					$(this.nodeClass + ' .pp-send-error').html(response.message);
				}
				$(this.nodeClass + ' .pp-send-error').fadeIn();
				return false;
			}
		}
	};

})(jQuery);
