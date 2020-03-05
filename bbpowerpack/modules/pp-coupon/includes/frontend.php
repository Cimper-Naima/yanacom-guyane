<?php
// Trim coupon code for Reveal style
$str    = $settings->coupon_code;
$strlth = strlen( $settings->coupon_code );
if ( 1 === $strlth ) {
	$str = $settings->coupon_code;
} elseif ( 3 >= $strlth ) {
	$str = substr( $str, 1 );
} else {
	$strcut = $strlth - 3;
	$str    = substr( $str, $strcut );
}

// Coupon Icon
$icon_left  = '';
$icon_right = '';
if ( 'yes' === $settings->show_icon ) {
	if ( 'left' === $settings->icon_position ) {
		$icon_left = '<i class="pp-coupon-code-icon ' . $settings->icon_select . '"></i>';
	} else {
		$icon_right = '<i class="pp-coupon-code-icon ' . $settings->icon_select . '"></i>';
	}
}
// Coupon style Parent Div class generator
$coupon_class = 'pp-coupon-code pp-coupon-style-' . $settings->coupon_style . ' pp-coupon-icon-' . $settings->icon_position;

// Coupon style structure
if ( 'copy' === $settings->coupon_style ) {
	$coupon  = "<span class='pp-coupon-code-text' id='pp-coupon-code-" . $id . "'>" . $icon_left . $settings->coupon_code . $icon_right . '</span>';
	$coupon .= "<span class='pp-coupon-copy-text'>Copy</span>";
} elseif ( 'reveal' === $settings->coupon_style ) {
	$coupon  = "<div class='pp-coupon-reveal-wrap'>";
	$coupon .= "<span class='pp-coupon-reveal'>" . $icon_left . $settings->coupon_reveal . $icon_right . '</span>';
	$coupon .= '</div>';
	$coupon .= "<div class='pp-coupon-code-text-wrap pp-unreavel'>";
	$coupon .= "<span class='pp-coupon-code-text' id='pp-coupon-code-" . $id . "'>" . $str . '</span>';
	$coupon .= "<span class='pp-coupon-copy-text'style='display: none;'></span>";
	$coupon .= '</div>';
} else {
	$coupon = "<span class='pp-coupon-code-no-code' id='pp-coupon-code-" . $id . "'>" . $icon_left . $settings->no_code_need . $icon_right . '</span>';
}

// Button structure with link
if ( isset( $settings->link_icon ) ) {
	$link_icon = '<i class="pp-coupon-link-icon ' . $settings->link_icon . '"></i>';
} else {
	$link_icon = '';
}
if ( 'button' === $settings->link_type ) {
	if ( isset( $settings->link_icon_pos ) && 'left' == $settings->link_icon_pos ) {
		$link_type = '<button class="pp-coupon-link-button">' . $link_icon . $settings->link_text . '</button>';
	} else {
		$link_type = '<button class="pp-coupon-link-button">' . $settings->link_text . $link_icon . '</button>';
	}
} else {
	if ( isset( $settings->link_icon_pos ) && 'left' == $settings->link_icon_pos ) {
		$link_type = '<p class="pp-coupon-link-text">' . $link_icon . $settings->link_text . '</p>';
	} else {
		$link_type = '<p class="pp-coupon-link-text">' . $settings->link_text . $link_icon . '</p>';
	}
}
// link
$link = '<a class="pp-coupon-link" href="' . $settings->link_url . '" target="' . $settings->link_url_target . '" ' . $module->get_rel() . '>';

if ( isset( $settings->image_select ) && ! empty( $settings->image_select ) ) {
	$alt        = get_post_meta( $settings->image_select, '_wp_attachment_image_alt', true );
	$image_attr = 'src="' . $settings->image_select_src . '"';
	if ( isset( $alt ) && ! empty( $alt ) ) {
		$image_attr .= ' alt="' . $alt . '"';
	}
} else {
	$image_attr = 'src="' . BB_POWERPACK_URL . 'images/default-img.jpg"';
}
?>

<div class="pp-coupon-wrap">
	<div class="pp-coupon">
		<div class="pp-coupon-image-wrapper">
			<?php if ( 'yes' === $settings->show_discount ) { ?>
				<span class="pp-coupon-discount">
					<?php echo $settings->discount; ?>
				</span>
			<?php } ?>
			<span class='<?php echo $coupon_class; ?>'>
				<?php echo $coupon; ?>
			</span>
			<?php echo $link; ?>
				<img <?php echo $image_attr; ?>>
			</a>
		</div>
		<div class="pp-coupon-content-wrapper">
			<?php echo $link; ?>
				<h2 class="pp-coupon-title">
					<?php echo $settings->title; ?>
				</h2>
			</a>
			<div class="pp-coupon-description">
				<?php echo $settings->description; ?>
			</div>
			<?php if ( 'none' !== $settings->link_type ) { ?>
				<?php if ( '0' !== $settings->separator_width ) { ?>
					<hr class="pp-coupon-separator">
				<?php } ?>
				<div class="pp-coupon-button">
					<?php echo $link; ?>
						<?php echo $link_type; ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
