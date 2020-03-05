<?php
$css_id        = '';
$qus_tag       = isset( $settings->qus_tag ) ? $settings->qus_tag : 'h3';
$items         = $module->get_faq_items();
$icon_position = $settings->faq_toggle_icon_position;

if ( ! empty( $settings->faq_open_icon ) ) {
	$open_icon_class = 'pp-faq-button-icon pp-faq-open ' . $settings->faq_open_icon . ' pp-faq-icon-' . $icon_position;
} else {
	$open_icon_class = 'pp-faq-button-icon pp-faq-open fa fa-plus pp-fa-icon-' . $icon_position;
}
if ( ! empty( $settings->faq_close_icon ) ) {
	$close_icon_class = 'pp-faq-button-icon pp-faq-close ' . $settings->faq_close_icon . ' pp-faq-icon-' . $icon_position;
} else {
	$close_icon_class = 'pp-faq-button-icon pp-faq-close fa fa-minus pp-faq-icon-' . $icon_position;
}
?>

<div class="pp-faq <?php echo ( 'all' !== $settings->expand_option && $settings->collapse ) ? 'pp-faq-collapse' : ''; ?>">
	<?php
	for ( $i = 0; $i < count( $items ); $i++ ) :
		if ( empty( $items[ $i ] ) ) {
			continue;
		}

		$css_id = ! empty( $settings->faq_id_prefix ) ? $settings->faq_id_prefix . '-' . ( $i + 1 ) : 'pp-faq-' . $id . '-' . ( $i + 1 );
		?>
		<div id="<?php echo $css_id; ?>" class="pp-faq-item">
			<div class="pp-faq-button">
				<?php if ( 'left' === $icon_position ) { ?>
					<span class="<?php echo $open_icon_class; ?>"></span>
					<span class="<?php echo $close_icon_class; ?>"></span>
				<?php } ?>

				<<?php echo $qus_tag; ?> class="pp-faq-button-label">
					<?php echo $items[ $i ]->faq_question; ?>
				</<?php echo $qus_tag; ?>>

				<?php if ( 'right' === $icon_position ) { ?>
					<span class="<?php echo $open_icon_class; ?>"></span>
					<span class="<?php echo $close_icon_class; ?>"></span>
				<?php } ?>

			</div>
			<div class="pp-faq-content fl-clearfix">
				<div class="pp-faq-content-text">
					<?php echo $module->render_content( $items[ $i ] ); ?>
				</div>
			</div>
		</div>
	<?php endfor; ?>
</div>
