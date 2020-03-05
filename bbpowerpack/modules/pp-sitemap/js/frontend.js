/**
 * This file should contain frontend logic for
 * all module instances.
 */
(function ($) {
	$.fn.extend(
		{
			treed: function (o) {
				var openedClass = 'fa-minus-circle';
				var closedClass = 'fa-plus-circle';

				if (typeof o != 'undefined') {
					if (typeof o.openedClass != 'undefined') {
						openedClass = o.openedClass;
					}
					if (typeof o.closedClass != 'undefined') {
						closedClass = o.closedClass;
					}
				};

				// initialize each of the top levels
				var tree = $( this );
				tree.addClass( "tree" );
				tree.find( 'li' ).has( "ul" ).each(
					function () {
						var branch = $( this ); // li with children ul
						branch.prepend( "<i class='indicator fas " + closedClass + "'></i>" );
						branch.addClass( 'branch' );
						branch.on(
							'click',
							function (e) {
								if (this == e.target) {
									var icon = $( this ).children( 'i:first' );
									icon.toggleClass( openedClass + " " + closedClass );
									$( this ).children().children().toggle();
								}
							}
						)
						branch.children().children().toggle();
					}
				);
				// fire event from the dynamically added icon
				tree.find( '.branch .indicator' ).each(
					function () {
						$( this ).on(
							'click',
							function () {
								$( this ).closest( 'li' ).click();
							}
						);
					}
				);
				// fire event to open branch if the li contains an anchor instead of text
				// tree.find( '.branch>a' ).each(
				// 	function () {
				// 		$( this ).on(
				// 			'click',
				// 			function (e) {
				// 				$( this ).closest( 'li' ).click();
				// 				e.preventDefault();
				// 			}
				// 		);
				// 	}
				// );
				// fire event to open branch if the li contains a button instead of text
				tree.find( '.branch>button' ).each(
					function () {
						$( this ).on(
							'click',
							function (e) {
								$( this ).closest( 'li' ).click();
								e.preventDefault();
							}
						);
					}
				);
			}
		}
	);

	// Initialization of treeviews

	// $('.pp-sitemap-list').treed();

	// $('.pp-sitemap-list').treed({ openedClass: 'glyphicon-folder-open', closedClass: 'glyphicon-folder-close' });
	// $('.pp-sitemap-list.pp-sitemap-tree').treed();
	// $('.pp-sitemap-list').treed({ openedClass: 'fa-angle-right', closedClass: 'fa-angle-down' });
})( jQuery );
