( function( $ ) {

	PPSubscribeForm = function( settings )
	{
		this.settings	= settings;
		this.nodeClass	= '.fl-node-' + settings.id;
		this.form 		= $( this.nodeClass + ' .pp-subscribe-form' );
		this.wrap 		= this.form.find( '.pp-subscribe-form-inner' );
		this.button		= this.form.find( 'a.fl-button' );
		this._init();
	};

	PPSubscribeForm.prototype = {

		settings	: {},
		nodeClass	: '',
		form		: null,
		button		: null,

		_init: function()
		{
			this.button.on( 'click', $.proxy( this._submitForm, this ) );
			this.form.find( 'input[type="email"]' ).on( 'keypress', $.proxy( this._onEnterKey, this) );
		},

		_submitForm: function( e )
		{
			var postId      	= this.form.closest( '.fl-builder-content' ).data( 'post-id' ),
				templateId		= this.form.data( 'template-id' ),
				templateNodeId	= this.form.data( 'template-node-id' ),
				nodeId      	= this.form.closest( '.fl-module' ).data( 'node' ),
				buttonText  	= this.button.find( '.fl-button-text' ).text(),
				waitText    	= this.button.closest( '.pp-form-button' ).data( 'wait-text' ),
				name        	= this.form.find( 'input[name=pp-subscribe-form-name]' ),
				email       	= this.form.find( 'input[name=pp-subscribe-form-email]' ),
				acceptance   	= this.form.find( 'input[name=pp-subscribe-form-acceptance]'),
				re          	= /\S+@\S+\.\S+/,
				valid       	= true;

			e.preventDefault();

			if ( this.button.hasClass( 'pp-form-button-disabled' ) ) {
				return; // Already submitting
			}
			if ( name.length > 0 ) {
				if ( name.val() == '' ) {
					name.addClass( 'pp-form-error' );
					name.siblings( '.pp-form-error-message' ).show();
					valid = false;
				} else {
					name.removeClass( 'pp-form-error' );
					name.siblings( '.pp-form-error-message' ).hide();
				}
			}
			if ( '' == email.val() || ! re.test( email.val() ) ) {
				email.addClass( 'pp-form-error' );
				email.siblings( '.pp-form-error-message' ).show();
				valid = false;
			} else {
				email.removeClass( 'pp-form-error' );
				email.siblings( '.pp-form-error-message' ).hide();
			}

			if ( acceptance.length ) {
				if ( ! acceptance.is(':checked') ) {
					valid = false;
					acceptance.addClass( 'pp-form-error' );
					acceptance.parent().find( '.pp-form-error-message' ).show();
				}
				else {
					acceptance.removeClass( 'pp-form-error' );
					acceptance.parent().find( '.pp-form-error-message' ).hide();
				}
			}

			if ( valid ) {

				this.form.find( '> .pp-form-error-message' ).hide();
				this.button.find( '.fl-button-text' ).text( waitText );
				this.button.data( 'original-text', buttonText );
				this.button.addClass( 'pp-form-button-disabled' );

				$.post( FLBuilderLayoutConfig.paths.wpAjaxUrl, {
					action  			: 'pp_subscribe_form_submit',
					name    			: name.val(),
					email   			: email.val(),
					acceptance			: acceptance.is(':checked') ? '1' : '0',
					post_id 			: postId,
					template_id 		: templateId,
					template_node_id 	: templateNodeId,
					node_id 			: nodeId
				}, $.proxy( this._submitFormComplete, this ) );
			}
		},

		_submitFormComplete: function( response )
		{
			var data        = JSON.parse( response ),
				buttonText  = this.button.data( 'original-text' );

			if ( data.error ) {

				if ( data.error ) {
					this.wrap.find( '> .pp-form-error-message' ).text( data.error );
				}

				this.wrap.find( '> .pp-form-error-message' ).show();
				this.button.removeClass( 'pp-form-button-disabled' );
				this.button.find( '.fl-button-text' ).text( buttonText );
			}
			else if ( 'message' == data.action ) {
				this.form.find( '> *' ).hide();
				this.form.append( '<div class="pp-form-success-message">' + data.message + '</div>' );
			}
			else if ( 'redirect' == data.action ) {
				window.location.href = data.url;
			}
		},

		_onEnterKey: function( e )
		{
			if (e.which == 13) {
		    	this.button.trigger( 'click' );
		  	}
		}
	}

})( jQuery );
