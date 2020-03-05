<?php
// Before
if ( isset( $settings->before_img ) && ! empty( $settings->before_img ) ) {
	$before_alt      = get_post_meta( $settings->before_img, '_wp_attachment_image_alt', true );
	$before_img_attr = 'src="' . $settings->before_img_src . '"';

	if ( isset( $before_alt ) && ! empty( $before_alt ) ) {
		$before_img_attr .= ' alt="' . $before_alt . '"';
	}
} else {
	$before_img_attr = 'src="' . BB_POWERPACK_URL . 'images/default-img.jpg"';
}
// After
if ( isset( $settings->after_img ) && ! empty( $settings->after_img ) ) {
	$after_alt      = get_post_meta( $settings->after_img, '_wp_attachment_image_alt', true );
	$after_img_attr = 'src="' . $settings->after_img_src . '"';

	if ( isset( $after_alt ) && ! empty( $after_alt ) ) {
		$after_img_attr .= ' alt="' . $after_alt . '"';
	}
} else {
	$after_img_attr = 'src="' . BB_POWERPACK_URL . 'images/default-img.jpg"';
}
?>

<div class="pp-image-comp">
	<div class="pp-image-comp-inner">
		<img <?php echo $before_img_attr; ?> class="pp-before-img">
		<img <?php echo $after_img_attr; ?> class="pp-after-img">
	</div>
</div>
