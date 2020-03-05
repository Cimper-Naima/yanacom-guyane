<?php
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'dp_button_spacing_bottom',
	'selector'		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-switch",
	'prop'			=> 'margin-bottom',
	'unit'			=> 'px'
) );
?>
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons {
	display: block;
    float: none;
	text-align: <?php echo $settings->dp_button_alignment; ?>;
}
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button {
	display: inline-block;
	float: none;
	<?php if ( ! empty( $settings->dp_button_default_text_color ) ) { ?>
	color: #<?php echo $settings->dp_button_default_text_color; ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->dp_button_font_size ) ) { ?>
	font-size: <?php echo $settings->dp_button_font_size; ?>px;
	<?php } ?>
	<?php if ( ! empty( $settings->dp_button_padding_v ) ) { ?>
	padding-top: <?php echo $settings->dp_button_padding_v; ?>px;
	padding-bottom: <?php echo $settings->dp_button_padding_v; ?>px;
	<?php } ?>
	<?php if ( ! empty( $settings->dp_button_padding_h ) ) { ?>
	padding-left: <?php echo $settings->dp_button_padding_h; ?>px;
	padding-right: <?php echo $settings->dp_button_padding_h; ?>px;
	<?php } ?>
	 <?php if ( isset( $settings->dp_button_border_group ) && isset( $settings->dp_button_border_group['radius'] ) ) { ?>
		border-top-left-radius: <?php echo $settings->dp_button_border_group['radius']['top_left']; ?>px;
		border-top-right-radius: <?php echo $settings->dp_button_border_group['radius']['top_right']; ?>px;
		border-bottom-left-radius: <?php echo $settings->dp_button_border_group['radius']['bottom_left']; ?>px;
		border-bottom-right-radius: <?php echo $settings->dp_button_border_group['radius']['bottom_right']; ?>px;
	<?php } ?>
	outline: none;
	text-decoration: none !important;
	transition: all 0.25s ease-in-out;
}
<?php // Toggle - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'dp_button_border_group',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button",
) );
?>

<?php if ( 'active' == $settings->dp_button_apply_border ) { ?>
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button:not(.pp-pricing-button-active) {
		border-color: transparent;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button.pp-pricing-button-active,
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button:hover {
	<?php if ( ! empty( $settings->dp_button_active_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value($settings->dp_button_active_bg_color); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->dp_button_active_text_color ) ) { ?>
		color: <?php echo pp_get_color_value($settings->dp_button_active_text_color); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-button-1 {
	<?php if ( ! empty( $settings->dp_button_spacing ) ) { ?>
	margin-right: <?php echo $settings->dp_button_spacing; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col {
	padding-left: <?php echo $settings->box_spacing; ?>px;
	padding-right: <?php echo $settings->box_spacing; ?>px;
}

<?php if( $settings->box_spacing == 0 && isset( $settings->box_border_group ) && '' != $settings->box_border_group['width']['right'] ) { ?>
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col {
		margin-right: -<?php echo $settings->box_border_group['width']['right']; ?>px;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column {
	<?php if ( ! empty( $settings->box_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value($settings->box_bg_color); ?>;
	<?php } ?>
}

<?php
// Box - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'box_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'box_padding_top',
		'padding-right' 	=> 'box_padding_right',
		'padding-bottom' 	=> 'box_padding_bottom',
		'padding-left' 		=> 'box_padding_left',
	),
) );
// Box - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'box_border_group',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column",
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-matrix .pp-pricing-table-header {
	padding-top: <?php echo ( $settings->box_padding_top / 2 ); ?>px;
	padding-bottom: <?php echo ( $settings->box_padding_top / 2 ); ?>px;
}

<?php if( $settings->highlight == 'package' ) { ?>
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column {
	<?php if ( isset( $settings->hl_box_bg_color ) && ! empty( $settings->hl_box_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->hl_box_bg_color ); ?>;
	<?php } ?>
	margin-top: <?php echo $settings->hl_box_margin_top; ?>px;
}

<?php
// Highlight Box - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'hl_box_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'hl_box_padding_top',
		'padding-right' 	=> 'hl_box_padding_right',
		'padding-bottom' 	=> 'hl_box_padding_bottom',
		'padding-left' 		=> 'hl_box_padding_left',
	),
) );
// Highlight box - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'hl_box_border_group',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column",
) );
?>

<?php } ?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column {
	background-color: transparent;
	border: 0;
	padding: 0;
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column ul {
	background-color: <?php echo ($settings->matrix_bg) ? pp_get_color_value( $settings->matrix_bg ) : 'transparent'; ?>;
}

<?php
// Matrix - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'box_border_group',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column ul",
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-column .pp-pricing-featured-title {
	<?php if ( isset( $settings->featured_title_bg_color ) && ! empty( $settings->featured_title_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->featured_title_bg_color ); ?>;
	<?php } ?>
	color: #<?php echo $settings->featured_title_color; ?>;
}
<?php
// Featured Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'featured_title_typography',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-column .pp-pricing-featured-title",
) );
// Featured Title - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'featured_title_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-column .pp-pricing-featured-title",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'featured_title_padding_top',
		'padding-right' 	=> 'featured_title_padding_right',
		'padding-bottom' 	=> 'featured_title_padding_bottom',
		'padding-left' 		=> 'featured_title_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-featured-title {
	<?php if ( isset( $settings->hl_featured_title_bg_color ) && ! empty( $settings->hl_featured_title_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->hl_featured_title_bg_color ); ?>;
	<?php } ?>
	color: #<?php echo $settings->hl_featured_title_color; ?>;
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-title {
	<?php if ( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
	<?php } ?>
	color: #<?php echo $settings->title_color; ?>;
}

<?php
// Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'title_typography',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-title",
) );
// Title - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'title_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-title",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'title_padding_top',
		'padding-right' 	=> 'title_padding_right',
		'padding-bottom' 	=> 'title_padding_bottom',
		'padding-left' 		=> 'title_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-title {
	margin: 0;
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-price {
	color: #<?php echo $settings->price_color; ?>;
}

<?php
// Price Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'price_typography',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-price",
) );
// Price - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'price_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-price",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'price_padding_top',
		'padding-right' 	=> 'price_padding_right',
		'padding-bottom' 	=> 'price_padding_bottom',
		'padding-left' 		=> 'price_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col:not(.pp-pricing-table-matrix) .pp-pricing-table-column .pp-pricing-table-price {
	<?php if ( isset( $settings->price_bg_color ) && ! empty( $settings->price_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->price_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-column .pp-pricing-table-duration {
	color: #<?php echo $settings->duration_text_color; ?>;
}

<?php
// Custom Duration Font Size
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'duration_custom_font_size',
	'selector'		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-column .pp-pricing-table-duration",
	'prop'			=> 'font-size',
	'unit'			=> 'px',
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-column .pp-pricing-table-features {
   color: #<?php echo $settings->features_font_color; ?>;
   min-height: <?php echo $settings->features_min_height; ?>px;
}

<?php
// Features Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'features_typography',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-column .pp-pricing-table-features",
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-column .pp-pricing-table-features li {
	<?php if ( isset( $settings->features_typography['text_align'] ) ) { ?>
		<?php if ( 'left' == $settings->features_typography['text_align'] ) { ?>
			justify-content: flex-start;
		<?php } elseif ( 'center' == $settings->features_typography['text_align'] ) { ?>
			justify-content: center;
		<?php } elseif ( 'right' == $settings->features_typography['text_align'] ) { ?>
			justify-content: flex-end;
		<?php } ?>
	<?php } ?> 
}

/* Highlight */
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-title .pp-pricing-table-column .pp-pricing-table-title,
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-title {
	color: #<?php echo $settings->hl_title_color; ?>;
	<?php if ( isset( $settings->hl_title_bg_color ) && ! empty( $settings->hl_title_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->hl_title_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-price .pp-pricing-table-column .pp-pricing-table-price,
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-price {
	color: #<?php echo $settings->hl_price_color; ?>;
	<?php if ( isset( $settings->hl_price_bg_color ) && ! empty( $settings->hl_price_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->hl_price_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight-price .pp-pricing-table-column .pp-pricing-table-duration,
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-duration {
	color: #<?php echo $settings->hl_duration_color; ?>;
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features {
	color: #<?php echo $settings->hl_features_color; ?>;
}

/* Matrix Items */
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features {
	color: #<?php echo $settings->matrix_text_color; ?>;
	text-align: <?php echo $settings->matrix_alignment; ?>;
}

/* All Items */
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-features li {
	border-bottom-style: <?php echo $settings->features_border; ?>;
	<?php if( $settings->features_border_width && $settings->features_border != 'none' ) { ?>border-bottom-width: <?php echo $settings->features_border_width; ?>px; <?php } ?>
	<?php if( $settings->features_border_color ) { ?> border-bottom-color: #<?php echo $settings->features_border_color; ?>; <?php } ?>
}

<?php
// Features - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'features_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-features li",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'features_padding_top',
		'padding-right' 	=> 'features_padding_right',
		'padding-bottom' 	=> 'features_padding_bottom',
		'padding-left' 		=> 'features_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column .pp-pricing-table-features li:nth-child(even) {
	<?php if ( isset( $settings->even_features_background ) && ! empty( $settings->even_features_background ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->even_features_background ); ?>;
	<?php } ?>
}

<?php if( $settings->highlight == 'package' ) { ?>
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features li:nth-child(even) {
	<?php if ( isset( $settings->hl_even_features_bg_color ) && ! empty( $settings->hl_even_features_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->hl_even_features_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-highlight .pp-pricing-table-column .pp-pricing-table-features li {
	border-bottom-style: <?php echo $settings->hl_features_border; ?>;
	<?php if( $settings->hl_features_border_width && $settings->hl_features_border != 'none' ) { ?>border-bottom-width: <?php echo $settings->hl_features_border_width; ?>px; <?php } ?>
	<?php if( $settings->hl_features_border_color ) { ?> border-bottom-color: #<?php echo $settings->hl_features_border_color; ?>; <?php } ?>
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features li:nth-child(even) {
	background-color: <?php echo ($settings->matrix_even_features_bg_color) ? pp_get_color_value( $settings->matrix_even_features_bg_color ) : 'transparent'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-features li {
		border-bottom-style: <?php echo $settings->matrix_features_border; ?>;
		<?php if( $settings->matrix_features_border_width && $settings->matrix_features_border != 'none' ) { ?>border-bottom-width: <?php echo $settings->matrix_features_border_width; ?>px; <?php } ?>
		<?php if( $settings->matrix_features_border_color ) { ?> border-color: #<?php echo $settings->matrix_features_border_color; ?>; <?php } ?>
}


<?php
// Loop through and style each pricing box
for($i = 0; $i < count($settings->pricing_columns); $i++) :

	if(!is_object($settings->pricing_columns[$i])) continue;

	// Pricing Box Settings
	$pricing_column = $settings->pricing_columns[$i];

?>

.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-column-<?php echo $i; ?> {
<?php if( $pricing_column->hl_featured_title == '' ) { ?>
	overflow: hidden;
<?php } ?>
	margin-top: <?php echo $pricing_column->margin; ?>px;
}

<?php if ( isset( $pricing_column->package_bg_color ) && ! empty( $pricing_column->package_bg_color ) ) { ?>
.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col .pp-pricing-table-column-<?php echo $i; ?> {
	background-color: <?php echo pp_get_color_value( $pricing_column->package_bg_color ); ?>;
}
<?php } ?>


<?php
// Button - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $pricing_column,
	'setting_name' 	=> 'button_padding',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-column-$i a.fl-button",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'button_padding_top',
		'padding-right' 	=> 'button_padding_right',
		'padding-bottom' 	=> 'button_padding_bottom',
		'padding-left' 		=> 'button_padding_left',
	),
) );
// Button - Margin
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $pricing_column,
	'setting_name' 	=> 'button_margin',
	'selector' 		=> ".fl-node-$id .pp-pricing-table .pp-pricing-table-column-$i a.fl-button",
	'unit'			=> 'px',
	'props'			=> array(
		'margin-top' 		=> 'button_margin_top',
		'margin-right' 	=> 'button_margin_right',
		'margin-bottom' 	=> 'button_margin_bottom',
		'margin-left' 		=> 'button_margin_left',
	),
) );
?>

/* Pricing Box Highlight */
<?php if ( $settings->highlight != 'none' ) : ?>
	<?php if ( $settings->highlight == 'price' ) : ?>
		.fl-builder-content .fl-node-<?php echo $id; ?> .pp-pricing-table-highlight .pp-pricing-table-price {
			<?php if ( isset( $settings->hl_price_bg_color ) && ! empty( $settings->hl_price_bg_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $settings->hl_price_bg_color ); ?>;
			<?php } ?>
		}
	<?php endif; ?>
	<?php if ( $settings->highlight == 'title' ) : ?>
		.fl-builder-content .fl-node-<?php echo $id; ?> .pp-pricing-table-highlight .pp-pricing-table-title {
			<?php if ( isset( $settings->hl_title_bg_color ) && ! empty( $settings->hl_title_bg_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $settings->hl_title_bg_color ); ?>;
			<?php } ?>
		}
	<?php endif; ?>
<?php endif; ?>


/* Button CSS */
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-pricing-table-column-<?php echo $i; ?> a.fl-button {
	<?php if ( empty( $pricing_column->btn_width ) ) : ?>
	 	display:block;
	 	margin: 0 30px 5px;
	<?php endif; ?>
}

<?php
FLBuilder::render_module_css('fl-button', $id . ' .pp-pricing-table-column-' . $i , array(
	'align'             => 'center',
	'bg_color'          => $pricing_column->btn_bg_color,
	'bg_hover_color'    => $pricing_column->btn_bg_hover_color,
	'bg_opacity'        => $pricing_column->btn_bg_opacity,
	'bg_hover_opacity'  => $pricing_column->btn_bg_hover_opacity,
	'button_transition' => $pricing_column->btn_button_transition,
	'border_radius'     => $pricing_column->btn_border_radius,
	'border_size'       => $pricing_column->btn_border_size,
	'icon'              => $pricing_column->btn_icon,
	'icon_position'     => $pricing_column->btn_icon_position,
	'link'              => $pricing_column->button_url,
	'link_target'       => '_self',
	'style'             => $pricing_column->btn_style,
	'text_color'        => $pricing_column->btn_text_color,
	'text_hover_color'  => $pricing_column->btn_text_hover_color,
	'width'             => $pricing_column->btn_width
));
?>

<?php endfor; ?>

<?php
// Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'button_typography',
	'selector' 		=> "div.fl-node-$id .pp-pricing-table .pp-pricing-table-column a.fl-button",
) );
?>


@media only screen and ( max-width: 768px ) {

	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button {
		<?php if ( ! empty( $settings->dp_button_font_size_medium ) ) { ?>
		font-size: <?php echo $settings->dp_button_font_size_medium; ?>px;
		<?php } ?>
		<?php if ( ! empty( $settings->dp_button_padding_v_medium ) ) { ?>
		padding-top: <?php echo $settings->dp_button_padding_v_medium; ?>px;
		padding-bottom: <?php echo $settings->dp_button_padding_v_medium; ?>px;
		<?php } ?>
		<?php if ( ! empty( $settings->dp_button_padding_h_medium ) ) { ?>
		padding-left: <?php echo $settings->dp_button_padding_h_medium; ?>px;
		padding-right: <?php echo $settings->dp_button_padding_h_medium; ?>px;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-button-1 {
		<?php if ( ! empty( $settings->dp_button_spacing_medium ) ) { ?>
		margin-right: <?php echo $settings->dp_button_spacing_medium; ?>px;
		<?php } ?>
	}

	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-title,
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-pricing-table-matrix .pp-pricing-table-column .pp-pricing-table-price {
		display: none;
	}

	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col {
		margin-right: auto;
	}
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-col.pp-has-featured-title {
		margin-top: 80px;
	}

	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-matrix {
		display: none;
	}
   .fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-features li span.pp-pricing-table-item-label {
	   display: block;
   }
   .fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-features li {
	   height: auto !important;
	   display: block !important;
   }
}

@media only screen and ( max-width: 600px ) {
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-table-button {
		<?php if ( ! empty( $settings->dp_button_font_size_responsive ) ) { ?>
		font-size: <?php echo $settings->dp_button_font_size_responsive; ?>px;
		<?php } ?>
		<?php if ( ! empty( $settings->dp_button_padding_v_responsive ) ) { ?>
		padding-top: <?php echo $settings->dp_button_padding_v_responsive; ?>px;
		padding-bottom: <?php echo $settings->dp_button_padding_v_responsive; ?>px;
		<?php } ?>
		<?php if ( ! empty( $settings->dp_button_padding_h_responsive ) ) { ?>
		padding-left: <?php echo $settings->dp_button_padding_h_responsive; ?>px;
		padding-right: <?php echo $settings->dp_button_padding_h_responsive; ?>px;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-pricing-table .pp-pricing-table-buttons .pp-pricing-button-1 {
		<?php if ( ! empty( $settings->dp_button_spacing_responsive ) ) { ?>
		margin-right: <?php echo $settings->dp_button_spacing_responsive; ?>px;
		<?php } ?>
	}
}
