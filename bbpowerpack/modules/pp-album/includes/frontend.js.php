;(function($){
<?php $toolbarButtons = '';
foreach( $settings->toolbar_buttons as $i => $item ){
	if ( ($i+1) == count($settings->toolbar_buttons) ) {
		$toolbarButtons .= $item;
	}else{
		$toolbarButtons .= $item.",";
	}
};
?>
	new PPAlbum({
		id: 				'<?php echo $id; ?>',
		lightboxLoop:		'<?php echo $settings->lightbox_loop; ?>',
		lightboxArrows:		'<?php echo $settings->lightbox_arrows; ?>',
		slidesCounter:		'<?php echo $settings->slides_counter; ?>',
		keyboardNav:		'<?php echo $settings->keyboard_nav; ?>',
		toolbar:			'<?php echo $settings->toolbar; ?>',
		toolbarButtons:		'<?php echo $toolbarButtons; ?>',
		thumbsAutoStart:	'<?php echo $settings->thumbs_auto_start; ?>',
		thumbsPosition:		'<?php echo $settings->thumbs_position; ?>',
		lightboxAnimation:	'<?php echo $settings->lightbox_animation; ?>',
		transitionEffect:	'<?php echo $settings->transition_effect; ?>',
		lightboxBgColor:	'<?php echo $settings->lightbox_bg_color; ?>',
		lightboxbgOpacity:	'<?php echo $settings->lightboxbg_opacity; ?>',
		thumbsBgColor:		'<?php echo $settings->thumbs_bg_color; ?>',
	});

})(jQuery);
