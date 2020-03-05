<?php
// Columns.
$columns = ! empty( $settings->columns ) ? absint( $settings->columns ) : 3;
$columns_medium = $columns;
$columns_responsive = $columns;

if ( isset( $settings->columns_medium ) && ! empty( $settings->columns_medium ) ) {
	$columns_medium = absint( $settings->columns_medium );
	$columns_responsive = $columns_medium;
}
if ( isset( $settings->columns_responsive ) && ! empty( $settings->columns_responsive ) ) {
	$columns_responsive = absint( $settings->columns_responsive );
}

// Spacing.
$spacing = ! empty( $settings->spacing ) ? (int) $settings->spacing : 2;
$spacing_medium = $spacing;
$spacing_responsive = $spacing;
//$spacing_unit = $settings->spacing_unit;

if ( isset( $settings->spacing_medium ) && ! empty( $settings->spacing_medium ) ) {
	$spacing_medium = (int) $settings->spacing_medium;
	$spacing_responsive = $spacing_medium;
}
if ( isset( $settings->spacing_responsive ) && ! empty( $settings->spacing_responsive ) ) {
	$spacing_responsive = (int) $settings->spacing_responsive;
}
?>

<?php
// Item Border.
FLBuilderCSS::border_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'item_border',
	'selector'		=> ".fl-node-$id .pp-video-gallery-item .pp-video",
) );
?>

<?php if ( 'gallery' === $module->get_layout() ) { ?>
	.fl-node-<?php echo $id; ?> .pp-video-gallery-item {
		width: calc((100% - <?php echo $spacing * ( $columns - 1 ); ?>%) / <?php echo $columns; ?>);
		<?php if ( ! $module->filters_enabled() ) { ?>
		margin-right: <?php echo $spacing; ?>%;
		<?php } ?>
		margin-bottom: <?php echo $spacing; ?>%;
	}
	.fl-node-<?php echo $id; ?> .pp-video-gallery-item:nth-of-type(<?php echo $columns; ?>n) {
		margin-right: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-video-gallery--spacer {
		width: <?php echo $spacing; ?>%;
		height: <?php echo $spacing; ?>%;
	}
<?php } ?>

<?php
// Title Typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'title_typography',
	'selector'		=> ".fl-node-$id .pp-video-title",
) );

// Title Padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'title_padding',
	'selector'		=> ".fl-node-$id .pp-video-title",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top'		=> 'title_padding_top',
		'padding-right'		=> 'title_padding_right',
		'padding-bottom'	=> 'title_padding_bottom',
		'padding-left'		=> 'title_padding_left',
	),
) );

// Title Margin Top.
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'title_margin',
	'selector'		=> ".fl-node-$id .pp-video-title",
	'prop'			=> 'margin-top',
	'unit'			=> 'px',
) );
?>
.fl-node-<?php echo $id; ?> .pp-video-title {
	<?php if ( isset( $settings->title_color ) && ! empty( $settings->title_color ) ) { ?>
		color: #<?php echo $settings->title_color; ?>;
	<?php } ?>
	<?php if ( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-gallery-item:hover .pp-video-title {
	<?php if ( isset( $settings->title_hover_color ) && ! empty( $settings->title_hover_color ) ) { ?>
		color: #<?php echo $settings->title_hover_color; ?>;
	<?php } ?>
	<?php if ( isset( $settings->title_bg_hover_color ) && ! empty( $settings->title_bg_hover_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->title_bg_hover_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-video-gallery-filters {
	<?php if ( isset( $settings->filters_align ) ) { ?>
		<?php if ( 'left' === $settings->filters_align ) { ?>
			justify-content: flex-start;
		<?php } ?>
		<?php if ( 'center' === $settings->filters_align ) { ?>
			justify-content: center;
		<?php } ?>
		<?php if ( 'right' === $settings->filters_align ) { ?>
			justify-content: flex-end;
		<?php } ?>
	<?php } ?>
}
<?php
// Filter border.
if ( 'all' === $settings->filters_border_on ) {
	FLBuilderCSS::border_field_rule( array(
		'settings'	=> $settings,
		'setting_name'	=> 'filters_border',
		'selector'	=> ".fl-node-$id .pp-video-gallery-filter",
	) );
} else {
	FLBuilderCSS::border_field_rule( array(
		'settings'	=> $settings,
		'setting_name'	=> 'filters_border',
		'selector'	=> ".fl-node-$id .pp-video-gallery-filter.pp-filter--active",
	) );
}

// Filter padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'filters_padding',
	'selector'		=> ".fl-node-$id .pp-video-gallery-filter",
	'props'			=> array(
		'padding-top'		=> 'filters_padding_top',
		'padding-right'		=> 'filters_padding_right',
		'padding-bottom'	=> 'filters_padding_bottom',
		'padding-left'		=> 'filters_padding_left',
	),
	'unit'			=> 'px',
) );

// Filter Typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'filters_typography',
	'selector'		=> ".fl-node-$id .pp-video-gallery-filter",
) );
?>
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter {
	<?php if ( ! empty( $settings->filters_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->filters_bg_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->filters_margin ) && ! empty( $settings->filters_margin ) ) { ?>
	margin-left: <?php echo (float) $settings->filters_margin / 2; ?>px;
	margin-right: <?php echo (float) $settings->filters_margin / 2; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter:first-child {
	margin-left: 0;
}
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter:last-of-type {
	margin-right: 0;
}
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter span {
	<?php if ( ! empty( $settings->filters_color ) ) { ?>
		color: #<?php echo $settings->filters_color; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter:hover,
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter.pp-filter--active {
	<?php if ( ! empty( $settings->filters_bg_hover_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->filters_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->filters_border_hover_color ) ) { ?>
		border-color: #<?php echo $settings->filters_border_hover_color; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter:hover span,
.fl-node-<?php echo $id; ?> .pp-video-gallery-filter.pp-filter--active span {
	<?php if ( ! empty( $settings->filters_hover_color ) ) { ?>
		color: #<?php echo $settings->filters_hover_color; ?>;
	<?php } ?>
}

/* Carousel */
.fl-node-<?php echo $id; ?> .pp-video-carousel .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
	<?php if ( isset( $settings->pagination_bg_color ) && ! empty( $settings->pagination_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->pagination_bg_color ); ?>;
		opacity: 1;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-video-carousel.swiper-container-horizontal>.swiper-pagination-progress {
	<?php if ( isset( $settings->pagination_bg_color ) && ! empty( $settings->pagination_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->pagination_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-video-carousel .swiper-pagination-bullet:hover,
.fl-node-<?php echo $id; ?> .pp-video-carousel .swiper-pagination-bullet.swiper-pagination-bullet-active,
.fl-node-<?php echo $id; ?> .pp-video-carousel .swiper-pagination-progress .swiper-pagination-progressbar {
	<?php if ( isset( $settings->pagination_bg_hover ) && ! empty( $settings->pagination_bg_hover ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->pagination_bg_hover ); ?>;
	<?php } ?>
    box-shadow: none;
}

.fl-node-<?php echo $id; ?> .pp-video-carousel .pp-video-carousel-nav {
	<?php if ( isset( $settings->nav_color ) && ! empty( $settings->nav_color ) ) { ?>
		color: #<?php echo $settings->nav_color; ?>;
    <?php } ?>
	<?php if ( isset( $settings->nav_bg_color ) && ! empty( $settings->nav_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->nav_bg_color ); ?>;
	<?php } ?>
    <?php if ( $settings->nav_vertical_padding >= 0 ) { ?>
    	padding-top: <?php echo $settings->nav_vertical_padding; ?>px;
    <?php } ?>
    <?php if ( $settings->nav_vertical_padding >= 0 ) { ?>
    	padding-bottom: <?php echo $settings->nav_vertical_padding; ?>px;
    <?php } ?>
    <?php if ( $settings->nav_horizontal_padding >= 0 ) { ?>
    	padding-left: <?php echo $settings->nav_horizontal_padding; ?>px;
    <?php } ?>
    <?php if ( $settings->nav_horizontal_padding >= 0 ) { ?>
    	padding-right: <?php echo $settings->nav_horizontal_padding; ?>px;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-carousel .pp-video-carousel-nav svg {
	<?php if ( isset( $settings->nav_color ) && ! empty( $settings->nav_color ) ) { ?>
		fill: #<?php echo $settings->nav_color; ?>;
	<?php } ?>
	<?php if ( isset( $settings->nav_size ) && ! empty( $settings->nav_size ) ) { ?>
		height: <?php echo $settings->nav_size; ?>px;
		width: <?php echo $settings->nav_size; ?>px;
	<?php } ?>
}

<?php
	// nav - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'nav_border',
		'selector' 		=> ".fl-node-$id .pp-video-carousel .pp-video-carousel-nav",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-video-carousel .pp-video-carousel-nav:not(.swiper-button-disabled):hover {
	<?php if ( isset( $settings->nav_bg_hover ) && ! empty( $settings->nav_bg_hover ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->nav_bg_hover ); ?>;
	<?php } ?>
    <?php if ( isset( $settings->nav_border_hover ) && ! empty( $settings->nav_border_hover ) ) { ?>
    	border-color: #<?php echo $settings->nav_border_hover; ?>;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-carousel .pp-video-carousel-nav:not(.swiper-button-disabled):hover svg {
	<?php if ( isset( $settings->nav_color_hover ) && ! empty( $settings->nav_color_hover ) ) { ?>
    	fill: #<?php echo $settings->nav_color_hover; ?>;
    <?php } ?>
}

/* Video */
<?php
FLBuilderCSS::border_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'play_icon_border',
	'selector'		=> ".fl-node-$id .pp-video-play-icon",
) );
?>
.fl-node-<?php echo $id; ?> .pp-video-play-icon {
	<?php if ( ! empty( $settings->play_icon_bg_color ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->play_icon_bg_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->play_icon_size ) ) { ?>
		padding: calc( <?php echo $settings->play_icon_size; ?>px / 1.2 );
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-play-icon:hover {
	<?php if ( ! empty( $settings->play_icon_bg_hover_color ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->play_icon_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->play_icon_border_hover_color ) && ! empty( $settings->play_icon_border_hover_color ) ) { ?>
		border-color: #<?php echo $settings->play_icon_border_hover_color; ?>;
	<?php } ?>
}
<?php
FLBuilderCSS::responsive_rule( array(
	'settings'	=> $settings,
	'setting_name'	=> 'play_icon_size',
	'selector'	=> ".fl-node-$id .pp-video-play-icon svg",
	'prop'		=> 'width',
	'unit'		=> 'px',
) );
FLBuilderCSS::responsive_rule( array(
	'settings'	=> $settings,
	'setting_name'	=> 'play_icon_size',
	'selector'	=> ".fl-node-$id .pp-video-play-icon svg",
	'prop'		=> 'height',
	'unit'		=> 'px',
) );
?>
.fl-node-<?php echo $id; ?> .pp-video-play-icon svg {
	<?php if ( ! empty( $settings->play_icon_color ) ) { ?>
		fill: <?php echo pp_get_color_value( $settings->play_icon_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-play-icon:hover svg {
	<?php if ( ! empty( $settings->play_icon_hover_color ) ) { ?>
		fill: <?php echo pp_get_color_value( $settings->play_icon_hover_color ); ?>;
	<?php } ?>
}

/* Lightbox */
.fancybox-<?php echo $id; ?> .pp-aspect-ratio-<?php echo $settings->aspect_ratio; ?> {
	background: none;
	width: 100%;
	height: 100%;
}
.fancybox-<?php echo $id; ?> .pp-video-container {
	<?php if ( 'top' === $settings->lightbox_video_position ) { ?>
		top: 60px;
		transform: translateX(-50%);
	<?php } ?>
}
.fancybox-<?php echo $id; ?> .fancybox-close-small {
	color: #<?php echo ! empty( $settings->lightbox_color ) ? $settings->lightbox_color : 'fff'; ?>;
	height: 60px;
	width: 60px;
	background: none !important;
	border: none !important;
	box-shadow: none !important;
}
.fancybox-<?php echo $id; ?> .fancybox-close-small:hover,
.fancybox-<?php echo $id; ?> .fancybox-close-small:focus {
	color: #<?php echo ! empty( $settings->lightbox_hover_color ) ? $settings->lightbox_hover_color : 'fff'; ?>;
}
.fancybox-<?php echo $id; ?> .fancybox-close-small,
.fancybox-<?php echo $id; ?> .fancybox-close-small:focus {
	position: absolute;
	top: 0;
	right: 0;
}
.admin-bar .fancybox-<?php echo $id; ?> .fancybox-close-small {
	top: 32px;
}
.fancybox-<?php echo $id; ?>-overlay {
	<?php if ( ! empty( $settings->lightbox_bg_color ) ) { ?>
	opacity: 1 !important;
	background: <?php echo pp_get_color_value( $settings->lightbox_bg_color ); ?>;
	<?php } ?>
}

@media only screen and (min-width: 1025px) {
	.fancybox-<?php echo $id; ?> .pp-video-container {
		<?php if ( ! empty( $settings->lightbox_video_width ) ) { ?>
			width: <?php echo $settings->lightbox_video_width; ?>%;
		<?php } ?>
	}
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-video-play-icon {
		<?php if ( isset( $settings->play_icon_size_medium ) && ! empty( $settings->play_icon_size_medium ) ) { ?>
			padding: calc( <?php echo $settings->play_icon_size_medium; ?>px / 1.2 );
		<?php } ?>
	}
	<?php if ( 'gallery' === $module->get_layout() ) { ?>
		.fl-node-<?php echo $id; ?> .pp-video-gallery-item {
			width: calc((100% - <?php echo $spacing_medium * ( $columns_medium - 1 ); ?>%) / <?php echo $columns_medium; ?>);
			<?php if ( ! $module->filters_enabled() ) { ?>
			margin-right: <?php echo $spacing_medium; ?>%;
			margin-bottom: <?php echo $spacing_medium; ?>%;
			<?php } ?>
		}
		.fl-node-<?php echo $id; ?> .pp-video-gallery-item:nth-of-type(<?php echo $columns; ?>n) {
			margin-right: <?php echo $spacing; ?>%;
		}
		.fl-node-<?php echo $id; ?> .pp-video-gallery-item:nth-of-type(<?php echo $columns_medium; ?>n) {
			margin-right: 0;
		}
	<?php } ?>
}
@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-video-play-icon {
		<?php if ( isset( $settings->play_icon_size_responsive ) && ! empty( $settings->play_icon_size_responsive ) ) { ?>
			padding: calc( <?php echo $settings->play_icon_size_responsive; ?>px / 1.2 );
		<?php } ?>
	}
	<?php if ( 'gallery' === $module->get_layout() ) { ?>
		.fl-node-<?php echo $id; ?> .pp-video-gallery-item {
			width: calc((100% - <?php echo $spacing_responsive * ( $columns_responsive - 1 ); ?>%) / <?php echo $columns_responsive; ?>);
			<?php if ( ! $module->filters_enabled() ) { ?>
			margin-right: <?php echo $spacing_responsive; ?>%;
			margin-bottom: <?php echo $spacing_responsive; ?>%;
			<?php } ?>
		}
		.fl-node-<?php echo $id; ?> .pp-video-gallery-item:nth-of-type(<?php echo $columns_medium; ?>n) {
			margin-right: <?php echo $spacing_medium; ?>%;
		}
		.fl-node-<?php echo $id; ?> .pp-video-gallery-item:nth-of-type(<?php echo $columns_responsive; ?>n) {
			margin-right: 0;
		}
	<?php } ?>
}
