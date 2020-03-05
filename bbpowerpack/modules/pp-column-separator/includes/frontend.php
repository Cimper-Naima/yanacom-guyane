<?php if ( FLBuilderModel::is_builder_active() ) { ?>
	<div class="pp-helper"><?php _e('Click here to edit the separator. This text is only for editing and will disappear after you publish the changes.', 'bb-powerpack'); ?></div>
<?php } ?>
<?php
$classes = '';
if( $settings->separator_type == 'triangle_left_side' || $settings->separator_type == 'triangle_right_side'  ) {
	$classes = 'pp-side-separator';
}
else if( $settings->separator_type == 'big_triangle_left' || $settings->separator_type == 'big_triangle_right' ) {
	$classes = 'pp-big-side-separator';
}
else {
	$classes = '';
}
$infobox_class = 'pp-column-separator-wrap '.$classes;

?>
<div class="<?php echo $infobox_class; ?>">
	<?php
		if( $settings->separator_type == 'triangle' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-large-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#ecf0f1" width="100%" height="100" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none">
					<path class="fil0" d="M-0 0.333331l4.66666 0 0 -3.93701e-006 -2.33333 0 -2.33333 0 0 3.93701e-006zm0 -0.333331l4.66666 0 0 0.166661 -4.66666 0 0 -0.166661zm4.66666 0.332618l0 -0.165953 -4.66666 0 0 0.165953 1.16162 -0.0826181 1.17171 -0.0833228 1.17171 0.0833228 1.16162 0.0826181z"></path>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'big_triangle_left' || $settings->separator_type == 'big_triangle_right' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-big-triangle-side" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#ecf0f1" width="100%" height="100" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none">
					<path class="fil0" d="M-0 0.333331l4.66666 0 0 -3.93701e-006 -2.33333 0 -2.33333 0 0 3.93701e-006zm0 -0.333331l4.66666 0 0 0.166661 -4.66666 0 0 -0.166661zm4.66666 0.332618l0 -0.165953 -4.66666 0 0 0.165953 1.16162 -0.0826181 1.17171 -0.0833228 1.17171 0.0833228 1.16162 0.0826181z"></path>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'triangle_left_side' || $settings->separator_type == 'triangle_right_side' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-side-triangle" viewBox="0 0 200 200" preserveAspectRatio="none">
  					<path d="M0 0 L0 200 L200 100 Z" />
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'triangle_shadow' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-large-triangle-shadow" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
				    <path class="pp-main-color" d="M0 0 L50 100 L100 0 Z" />
				    <path class="pp-shadow-color" d="M50 100 L100 40 L100 0 Z" />
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'triangle_left' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-large-triangle-left" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#e74c3c" width="100%" height="100" viewBox="0 0 2000 90" preserveAspectRatio="none">
					<polygon xmlns="http://www.w3.org/2000/svg" points="535.084,64.886 0,0 0,90 2000,90 2000,0 "></polygon>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'triangle_right' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-large-triangle-right" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#3fc45e" width="100%" height="100" viewBox="0 0 2000 90" preserveAspectRatio="none">
					<polygon xmlns="http://www.w3.org/2000/svg" points="535.084,64.886 0,0 0,90 2000,90 2000,0 "></polygon>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'triangle_small' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-small-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#ecf0f1" width="100%" height="60" viewBox="0 0 0.156661 0.1">
					<polygon points="0.156661,3.93701e-006 0.156661,0.000429134 0.117665,0.05 0.0783307,0.0999961 0.0389961,0.05 -0,0.000429134 -0,3.93701e-006 0.0783307,3.93701e-006 "></polygon>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'tilt_left' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-tilt-left-separator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#2c3e50" width="100%" height="100" viewBox="0 0 4 0.266661" preserveAspectRatio="none">
					<polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "></polygon>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'tilt_right' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-tilt-right-separator" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#2ecc71" width="100%" height="100" viewBox="0 0 4 0.266661" preserveAspectRatio="none">
					<polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "></polygon>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'curve' ) { ?>
			<div class="pp-column-separator">
				<svg class="pp-large-circle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#ecf0f1" width="100%" height="150" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none">
					<path class="fil1" d="M4.66666 0l0 7.87402e-006 -3.93701e-006 0c0,0.0920315 -1.04489,0.166665 -2.33333,0.166665 -1.28844,0 -2.33333,-0.0746339 -2.33333,-0.166665l-3.93701e-006 0 0 -7.87402e-006 4.66666 0z"></path>
				</svg>
			</div>
		<?php }
		if( $settings->separator_type == 'zigzag' ) { ?>
			<div class="pp-column-separator">
				<div class="pp-zigzag"></div>
			</div>
		<?php }
	?>
</div>
