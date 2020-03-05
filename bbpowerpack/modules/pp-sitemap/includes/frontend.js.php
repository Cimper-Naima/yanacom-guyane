(function ($) {
	<?php if ( 'yes' === $settings->sitemap_tree ) { ?>
		if( 'plus_circle' === '<?php echo $settings->sitemap_tree_style; ?>' ){
			$('.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-list').treed();
		}
		else if ( 'caret' === '<?php echo $settings->sitemap_tree_style; ?>' ) {
			$('.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-list').treed({ openedClass: 'fa-caret-down', closedClass: 'fa-caret-right' });
		}
		else if ( 'plus' === '<?php echo $settings->sitemap_tree_style; ?>' ) {
			$('.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-list').treed({ openedClass: 'fa-minus', closedClass: 'fa-plus' });
		}
	<?php } ?>
})(jQuery);
