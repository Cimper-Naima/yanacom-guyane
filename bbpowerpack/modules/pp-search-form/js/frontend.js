;(function($) {

	PPSearchForm = function(settings) {
		this.id 	= settings.id;
		this.node 	= $('.fl-node-' + this.id);
		this.form	= this.node.find('.pp-search-form');

		this._init();
	};

	PPSearchForm.prototype = {
		id: '',
		node: '',
		form: '',

		_init: function() {
			this.form.find('.pp-search-form__input').on('focus', $.proxy(function() {
				this.form.addClass('pp-search-form--focus');
			}, this));
			this.form.find('.pp-search-form__input').on('blur', $.proxy(function() {
				this.form.removeClass('pp-search-form--focus');
			}, this));

			this.form.find('.pp-search-form__toggle').on('click', $.proxy(function() {
				this.form.find('.pp-search-form__container').addClass('pp-search-form--lightbox').find('.pp-search-form__input').focus();
			}, this));

			this.form.find('.pp-search-form--lightbox-close').on('click', $.proxy(function() {
				this.form.find('.pp-search-form__container').removeClass('pp-search-form--lightbox');
			}, this));

			var self = this;

			// close modal box on Esc key press.
			$(document).keyup(function(e) {
                if ( 27 == e.which && self.form.find('.pp-search-form--lightbox').length > 0 ) {
                    self.form.find('.pp-search-form__container').removeClass('pp-search-form--lightbox');
                }
			});
		},
	};

})(jQuery);