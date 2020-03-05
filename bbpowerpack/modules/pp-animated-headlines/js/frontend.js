(function($) {

	PPAnimatedHeadlines = function( settings ) {

		this.settings           = settings;
		this.nodeClass          = '.fl-node-' + settings.id;
		this.headline			= this.nodeClass + ' .pp-headline';
		this.dynamicWrapper		= this.nodeClass + ' .pp-headline-dynamic-wrapper';
		this.animationDelay     = 2500;
		// letters effect
		this.lettersDelay		= 50;
		// typing effect
		this.typeLettersDelay	= 150;
		this.selectionDuration	= 500;
		// clip effect
		this.revealDuration		= 600,
		this.revealAnimationDelay = 1500;

		this.typeAnimationDelay = this.selectionDuration + 800;

		this.classes			= {
			dynamicText: 			'pp-headline-dynamic-text',
			dynamicLetter:			'pp-headline-dynamic-letter',
			textActive: 			'pp-headline-text-active',
			textInactive: 			'pp-headline-text-inactive',
			letters: 				'pp-headline-letters',
			animationIn: 			'pp-headline-animation-in',
			typeSelected: 			'pp-headline-typing-selected'
		};

		this.elements			= {};

		this._fillWords();
		this._initHeadlines();
	};

  	PPAnimatedHeadlines.prototype = {
	    settings        		: {},
	    nodeClass       		: '',
	    headline				: '',
		dynamicWrapper			: '',
		animationDelay			: 2500,
		lettersDelay			: 50,
		typeLettersDelay		: 150,
		selectionDuration		: 500,
		revealDuration			: 600,
		revealAnimationDelay	: 1500,

		svgPaths: {
			circle: [ 'M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7' ],
			curly: [ 'M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6' ],
			strikethrough: ['M3,75h493.5'],
			underline: [ 'M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7' ],
			underline_zigzag: [ 'M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9' ]
		},

		_fillWords: function()
		{
			var classes 		= this.classes,
				dynamicWrapper 	= $(this.dynamicWrapper),
				settings		= this.settings;

			if ( 'rotate' == this.settings.headline_style ) {
				var rotatingText = this.settings.rotating_text.split('|');

				rotatingText.forEach( function( word, index ) {
					var dynamicText = $('<span>', { 'class': classes.dynamicText }).html( word.replace( / /g, '&nbsp;' ) );

					if ( ! index ) {
						dynamicText.addClass( classes.textActive );
					}

					dynamicWrapper.append( dynamicText );
				} );
			} else {
				var dynamicText = $('<span>', { 'class': classes.dynamicText + ' ' + classes.textActive }).text( settings.highlighted_text );
				var svg = $('<svg>', {
					xmlns: 'http://www.w3.org/2000/svg',
					viewBox: '0 0 500 150',
					preserveAspectRatio: 'none'
				}).html(this._getSvgPaths( settings.headline_shape ));

				if ( dynamicWrapper.find('.' + classes.dynamicText).length === 0 ) {
					dynamicWrapper.append( dynamicText, svg[0].outerHTML );
				}
			}

			this.elements.dynamicText = dynamicWrapper.children( '.' + classes.dynamicText );
		},

		_initHeadlines: function()
		{
			if ( 'rotate' === this.settings.headline_style ) {
				this._rotateHeadline();
			}
		},

		_rotateHeadline: function() {

			//insert <span> element for each letter of a changing word
			if ( $(this.headline).hasClass( this.classes.letters ) ) {
				this._singleLetters();
			}

			//initialise headline animation
			this._animateHeadline();
		},

		_singleLetters: function() {
			var classes = this.classes;

			this.elements.dynamicText.each( function() {
				var $word = $( this ),
					letters = $word.text().split( '' ),
					isActive = $word.hasClass( classes.textActive );

				$word.empty();

				letters.forEach( function( letter ) {
					var $letter = jQuery( '<span>', { 'class': classes.dynamicLetter } ).text( letter );

					if ( isActive ) {
						$letter.addClass( classes.animationIn );
					}

					$word.append( $letter );
				} );

				$word.css( 'opacity', 1 );
			} );
		},

		_animateHeadline: function() {
			var self 			= this,
				animationType 	= self.settings.animation_type,
				dynamicWrapper 	= $(self.dynamicWrapper);

			if ( 'clip' === animationType ) {
				dynamicWrapper.width( dynamicWrapper.width() + 10 );
			} else if ( 'typing' !== animationType ) {
				//assign to .pp-headline-dynamic-wrapper the width of its longest word
				var width = 0;

				self.elements.dynamicText.each( function() {
					var wordWidth = $( this ).width();

					if ( wordWidth > width ) {
						width = wordWidth;
					}
				} );

				dynamicWrapper.css( 'width', width );
			}

			//trigger animation
			setTimeout( function() {
				self._hideWord( self.elements.dynamicText.eq( 0 ) );
			}, self.animationDelay );
		},

		_showLetter: function( $letter, $word, bool, duration ) {
			var self 			= this,
				classes 		= self.classes,
				animationType 	= self.settings.animation_type;

			$letter.addClass( classes.animationIn );

			if ( ! $letter.is( ':last-child' ) ) {
				setTimeout( function() {
					self._showLetter( $letter.next(), $word, bool, duration );
				}, duration );
			} else {
				if ( ! bool ) {
					setTimeout( function() {
						self._hideWord( $word );
					}, self.animationDelay );
				}
			}
		},

		_hideLetter: function( $letter, $word, bool, duration ) {
			var self = this;

			$letter.removeClass( self.classes.animationIn );

			if ( ! $letter.is( ':last-child' ) ) {
				setTimeout( function() {
					self._hideLetter( $letter.next(), $word, bool, duration );
				}, duration );
			} else if ( bool ) {
				setTimeout( function() {
					self._hideWord( self._getNextWord( $word ) );
				}, self.animationDelay );
			}
		},

		_showWord: function( $word, duration ) {
			var self 			= this,
				animationType 	= self.settings.animation_type;

			if ( 'typing' === animationType ) {
				self._showLetter( $word.find( '.' + self.classes.dynamicLetter ).eq( 0 ), $word, false, duration );

				$word
					.addClass( self.classes.textActive )
					.removeClass( self.classes.textInactive );
			} else if ( 'clip' === animationType ) {
				$(self.dynamicWrapper).animate( { 'width': $word.width() + 10 }, self.revealDuration, function() {
					setTimeout( function() {
						self._hideWord( $word );
					}, self.revealAnimationDelay );
				} );
			}
		},

		_hideWord: function( $word ) {
			var self 			= this,
				classes 		= self.classes,
				letterSelector 	= '.' + classes.dynamicLetter,
				animationType 	= self.settings.animation_type,
				nextWord 		= self._getNextWord( $word );

			if ( 'typing' === animationType ) {
				$(self.dynamicWrapper).addClass( classes.typeSelected );

				setTimeout( function() {
					$(self.dynamicWrapper).removeClass( classes.typeSelected );

					$word
						.addClass( classes.textInactive )
						.removeClass( classes.textActive )
						.children( letterSelector )
						.removeClass( classes.animationIn );
				}, self.selectionDuration );
				setTimeout( function() {
					self._showWord( nextWord, self.typeLettersDelay );
				}, self.typeAnimationDelay );

			} else if ( $(self.headline).hasClass( classes.letters ) ) {
				var bool = $word.children( letterSelector ).length >= nextWord.children( letterSelector ).length;

				self._hideLetter( $word.find( letterSelector ).eq( 0 ), $word, bool, self.lettersDelay );

				$word.removeClass( classes.textActive );

				self._showLetter( nextWord.find( letterSelector ).eq( 0 ), nextWord, bool, self.lettersDelay );

				nextWord.addClass( classes.textActive );

			} else if ( 'clip' === animationType ) {
				$(self.dynamicWrapper).animate( { width: '2px' }, self.revealDuration, function() {
					self._switchWord( $word, nextWord );
					self._showWord( nextWord );
				} );
			} else {
				self._switchWord( $word, nextWord );

				setTimeout( function() {
					self._hideWord( nextWord );
				}, self.animationDelay );
			}
		},

		_getNextWord: function( $word )
		{
			return $word.is( ':last-child' ) ? $word.parent().children().eq( 0 ) : $word.next();
		},

		_switchWord: function( $oldWord, $newWord )
		{
			$oldWord
				.removeClass( 'pp-headline-text-active' )
				.addClass( 'pp-headline-text-inactive' );

			$newWord
				.removeClass( 'pp-headline-text-inactive' )
				.addClass( 'pp-headline-text-active' );
		},

		_getSvgPaths: function( pathName ) {
			var pathsInfo = this.svgPaths[ pathName ],
				$paths = jQuery();

			pathsInfo.forEach( function( pathInfo ) {
				$paths = $paths.add( $( '<path>', { d: pathInfo } ) );
			} );

			return $paths;
		},
  	};

})(jQuery);
