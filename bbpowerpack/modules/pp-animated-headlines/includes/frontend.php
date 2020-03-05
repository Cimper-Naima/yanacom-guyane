<?php
$class = 'pp-headline';
$loop = isset( $settings->loop ) && $settings->loop == 'yes' ? ' pp-headline-loop' : '';

if ( 'rotate' == $settings->headline_style ) {
	$class .= ' pp-headline-animation-type-' . $settings->animation_type;
	if ( in_array( $settings->animation_type, array( 'typing', 'swirl', 'blinds', 'wave' ) ) ) {
		$class .= ' pp-headline-letters';
	}
}

$class .= ' pp-headline-' . $settings->alignment;

?>
<div class="pp-animated-headlines pp-headline--style-<?php echo $settings->headline_style; ?><?php echo $loop; ?>">
	<<?php echo $settings->headline_tag; ?> class="<?php echo $class; ?>">
		<?php if ( ! empty( $settings->before_text ) ) : ?>
			<span class="pp-headline-plain-text pp-headline-text-wrapper"><?php echo $settings->before_text; ?></span>
		<?php endif; ?>

		<?php if ( 'rotate' == $settings->headline_style && ! empty( $settings->rotating_text ) ) : ?>
			<span class="pp-headline-dynamic-wrapper pp-headline-text-wrapper"></span>
		<?php endif; ?>
		
		<?php if ( 'highlight' == $settings->headline_style && ! empty( $settings->highlighted_text ) ) : ?>
			<span class="pp-headline-dynamic-wrapper pp-headline-text-wrapper"></span>
		<?php endif; ?>

		<?php if ( ! empty( $settings->after_text ) ) : ?>
			<span class="pp-headline-plain-text pp-headline-text-wrapper"><?php echo $settings->after_text; ?></span>
		<?php endif; ?>
	</<?php echo $settings->headline_tag; ?>>
</div>
