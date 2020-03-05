<?php
$category_style = 'style-0';

$column_desktop    = empty( $settings->category_columns ) ? 3 : $settings->category_columns;
$column_medium     = empty( $settings->category_columns_medium ) ? $column_desktop : $settings->category_columns_medium;
$column_responsive = empty( $settings->category_columns_responsive ) ? $column_medium : $settings->category_columns_responsive;

$spacing_desktop    = empty( $settings->category_spacing ) ? 2 : $settings->category_spacing;
$spacing_medium     = empty( $settings->category_spacing_medium ) ? $spacing_desktop : $settings->category_spacing_medium;
$spacing_responsive = empty( $settings->category_spacing_responsive ) ? $spacing_medium : $settings->category_spacing_responsive;

$width_desktop    = ( 100 - ( $spacing_desktop * $column_desktop - 1 ) ) / $column_desktop;
$width_medium     = ( 100 - ( $spacing_medium * $column_medium - 1 ) ) / $column_medium;
$width_responsive = ( 100 - ( $spacing_responsive * $column_responsive - 1 ) ) / $column_responsive;


$height        = $settings->category_height;
$margin_top    = isset( $settings->category_margin_top ) && ! empty( $settings->category_margin_top ) ? $settings->category_margin_top : 0;
$margin_bottom = isset( $settings->category_margin_bottom ) && ! empty( $settings->category_margin_bottom ) ? $settings->category_margin_bottom : 0;
$margin_left   = isset( $settings->category_margin_left ) && ! empty( $settings->category_margin_left ) ? $settings->category_margin_left : 0;
$margin_right  = isset( $settings->category_margin_right ) && ! empty( $settings->category_margin_right ) ? $settings->category_margin_right : 0;
$speed         = 0.3;


// *************************************** Border ***************************************
// Box Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'box_border_group',
		'selector'     => ".fl-node-$id .pp-category",
	)
);

FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'arrow_border',
		'selector'     => ".fl-node-$id .pp-categories-container .swiper-button-prev, .fl-node-$id .pp-categories-container .swiper-button-next",
	)
);
// Button Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_border_group',
		'selector'     => ".fl-node-$id .pp-category__button_wrapper .pp-category__button",
	)
);
// Overlay Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'overlay_border_group',
		'selector'     => ".fl-node-$id .pp-category .pp-category__content",
	)
);

// *************************************** Padding ***************************************
// Category Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'category_padding',
		'selector'     => ".fl-node-$id .pp-category .pp-category__content",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'category_padding_top',
			'padding-right'  => 'category_padding_right',
			'padding-bottom' => 'category_padding_bottom',
			'padding-left'   => 'category_padding_left',
		),
	)
);
// Button Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_padding',
		'selector'     => ".fl-node-$id .pp-category__button_wrapper .pp-category__button",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'button_padding_top',
			'padding-right'  => 'button_padding_right',
			'padding-bottom' => 'button_padding_bottom',
			'padding-left'   => 'button_padding_left',
		),
	)
);
// *************************************** Typography ***************************************
// Button Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_typography',
		'selector'     => ".fl-node-$id .pp-category__button_wrapper .pp-category__button",
	)
);
// Category Title Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'category_title_typography',
		'selector'     => ".fl-node-$id .pp-category .pp-category__title",
	)
);

// Category Count Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'category_count_typography',
		'selector'     => ".fl-node-$id .pp-category .pp-category__content span.pp-category-count",
	)
);

// Category Description Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'category_description_typography',
		'selector'     => ".fl-node-$id .pp-category .pp-category__description",
	)
);

// *************************************** Responsive Rule ***************************************
// Bullets Margin
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'bullets_top_margin',
		'selector'     => ".fl-node-$id .pp-categories-container.swiper-container-horizontal > .swiper-pagination-bullets, .fl-node-$id .pp-categories-container .swiper-pagination-fraction",
		'prop'         => 'padding-top',
		'unit'         => 'px',
	)
);

// Overlay Width
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'overlay_width',
		'selector'     => ".fl-node-$id .pp-category .category-inner .pp-category__content",
		'prop'         => 'width',
		'unit'         => '%',
	)
);


// Arrow Size
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'arrow_size',
		'selector'     => ".fl-node-$id .pp-categories-container .swiper-button-prev, .fl-node-$id .pp-categories-container .swiper-button-next",
		'prop'         => 'bottom',
		'unit'         => '%',
	)
);

// Overlay Bottom Margin
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'overlay_bottom_margin',
		'selector'     => ".fl-node-$id .pp-category .category-inner .pp-category__content",
		'prop'         => 'margin-bottom',
		'unit'         => 'px',
	)
);

// Overlay Top Margin
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'overlay_bottom_margin',
		'selector'     => ".fl-node-$id .pp-category .category-inner .pp-category__content",
		'prop'         => 'margin-top',
		'unit'         => 'px',
	)
);

if ( 'no' === $settings->category_grid_slider ) {
	?>
	.fl-node-<?php echo $id; ?> .pp-category:nth-of-type(<?php echo $column_desktop . 'n'; ?>) {
		margin-right: 0;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-prev,
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-next {
	background: none;
	top:46%;
	<?php

	if ( '' !== $settings->arrow_background_color ) {
		?>
		background-color : <?php echo pp_get_color_value( $settings->arrow_background_color ); ?>;
		<?php
	}

	if ( '' !== $settings->arrow_size ) {
		?>
		height : <?php echo $settings->arrow_size; ?>px;
		width : <?php echo $settings->arrow_size; ?>px;
		<?php
	}
	?>

}

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-prev svg,
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-next svg {

	<?php
	if ( '' !== $settings->arrow_color ) {
		?>
		fill : <?php echo pp_get_color_value( $settings->arrow_color ); ?>;
		<?php
	}
	?>

}

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-prev:hover,
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-next:hover {
	<?php

	if ( '' !== $settings->arrow_background_hover_color ) {
		?>
		background-color : <?php echo pp_get_color_value( $settings->arrow_background_hover_color ); ?>;
		<?php
	}

	?>

}

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-prev:hover svg,
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-button-next:hover svg {

	<?php
	if ( '' !== $settings->arrow_color_hover ) {
		?>
		fill : <?php echo pp_get_color_value( $settings->arrow_color_hover ); ?>;
		<?php
	}
	?>

}


.fl-node-<?php echo $id; ?> .pp-category {

	width : <?php echo $width_desktop . '%'; ?>;
	height : <?php echo $height . 'px'; ?>;
	float: left;
	background-repeat: no-repeat;
	background-size: cover;
	margin-right : <?php echo $spacing_desktop . '%'; ?>;
	margin-bottom : <?php echo $spacing_desktop . '%'; ?>;
	overflow: hidden;
}
.fl-node-<?php echo $id; ?> .pp-category .pp-category__link {
	background-color : <?php echo pp_get_color_value( $settings->category_bg_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-category:hover .pp-category__link {
	<?php
	if ( 'style-2' !== $category_style ) {
		?>
				background-color : <?php echo pp_get_color_value( $settings->category_bg_color_hover ); ?>;
			<?php
	}
	?>
}
.fl-node-<?php echo $id; ?> .pp-category .pp-category__content {

	<?php
	if ( 'bottom' === $settings->overlay_vertical_align ) {
		?>
			bottom : 0;
		<?php
	} elseif ( 'top' === $settings->overlay_vertical_align ) {
		?>
			top : 0;
		<?php
	} elseif ( 'middle' === $settings->overlay_vertical_align ) {
		?>
			top : 50%;
			transform: translateX(-50%) translateY(-50%);
		<?php
	}

	if ( 'default' !== $settings->category_text_align ) {
		?>
			text-align : <?php echo $settings->category_text_align; ?>;
		<?php
	}
	?>
	height: <?php echo ( $height - ( $margin_top + $margin_bottom ) ); ?>px;
	width: calc( 100% - <?php echo ( $margin_left + $margin_right ); ?>px );
	display: table;

	<?php
	if ( '' !== $settings->overlay_width ) {
		?>
			width : <?php echo $settings->overlay_width; ?>%;
		<?php
	}
	if ( '' !== $settings->overlay_bottom_margin ) {
		if ( 'bottom' === $settings->overlay_vertical_align ) {
			?>
				margin-bottom : <?php echo $settings->overlay_bottom_margin; ?>px;
			<?php
		} elseif ( 'top' === $settings->overlay_vertical_align ) {
			?>
				margin-top : <?php echo $settings->overlay_bottom_margin; ?>px;
			<?php
		}
	}

	?>

}
.fl-node-<?php echo $id; ?> .pp-category .pp-category__title {

	<?php
	if ( '' !== $settings->category_title_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->category_title_color ); ?>;
			<?php
	}
	?>
}
.fl-node-<?php echo $id; ?> .pp-category .pp-category__title_wrapper span {

	<?php
	if ( '' !== $settings->category_count_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->category_count_color ); ?>;
			<?php
	}
	?>

}
.fl-node-<?php echo $id; ?> .pp-category .pp-category__description {

	<?php
	if ( '' !== $settings->des_margin_top ) {
		?>
				margin-top : <?php echo $settings->des_margin_top; ?>;
			<?php
	}

	if ( '' !== $settings->category_description_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->category_description_color ); ?>;
			<?php
	}
	?>
}
.fl-node-<?php echo $id; ?> .pp-category__button_wrapper {
	<?php
	if ( 'full_width' !== $settings->button_width ) {
		if ( 'default' !== $settings->button_alignment && '' !== $settings->button_alignment ) {
			?>
					text-align : <?php echo $settings->button_alignment; ?>;
				<?php
		}
	}
	?>
	z-index: 9999;
}
.fl-node-<?php echo $id; ?> .pp-category__button_wrapper .pp-category__button {

	<?php
	if ( 'full_width' === $settings->button_width ) {
		?>
				width : 100%;
		<?php
	}

	if ( 'custom' === $settings->button_width ) {
		?>
				width : <?php echo $settings->button_width_custom . '%'; ?>;
			<?php
	}

	if ( '' !== $settings->button_bg_color ) {
		?>
				background-color : <?php echo pp_get_color_value( $settings->button_bg_color ); ?>;
			<?php
	}

	if ( '' !== $settings->button_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->button_color ); ?>;
			<?php
	}

	if ( '' !== $settings->button_margin_top ) {
		?>
				margin-top : <?php echo $settings->button_margin_top . 'px'; ?>;
			<?php
	}

	if ( '' !== $settings->button_margin_bottom ) {
		?>
				margin-bottom : <?php echo $settings->button_margin_bottom . 'px'; ?>;
			<?php
	}
	?>
	text-align: center;
	float: none;
	z-index: 999999;
}
.fl-node-<?php echo $id; ?> .pp-category__button_wrapper .pp-category__button:hover {

	<?php
	if ( '' !== $settings->button_bg_color_hover ) {
		?>
				background-color : <?php echo pp_get_color_value( $settings->button_bg_color_hover ); ?>;
			<?php
	}

	if ( '' !== $settings->button_color_hover ) {
		?>
				color : <?php echo pp_get_color_value( $settings->button_color_hover ); ?>;
			<?php
	}

	if ( '' !== $settings->button_border_color_hover ) {
		?>
				border-color : <?php echo pp_get_color_value( $settings->button_border_color_hover ); ?>;
			<?php
	}
	?>
}

.fl-node-<?php echo $id; ?> .pp-category__img {
	<?php
	if ( '' !== $height ) {
		?>
				height : <?php echo $height . 'px'; ?>;
			<?php
	}
	?>
	overflow: hidden;
}
.fl-node-<?php echo $id; ?> .pp-category__img img {
	width: calc(100% + 0px);
	object-fit: cover;
	<?php
	if ( '' !== $height ) {
		?>
				height : <?php echo $height . 'px'; ?>;
			<?php
	}
	?>
}
.fl-node-<?php echo $id; ?> .pp-category,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__link,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__content,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__title_wrapper,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__title,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__title_wrapper span,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__img,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__img img,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__button_wrapper,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__button_wrapper .pp-category__button,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__content::before,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__content::after,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__description_wrapper {
	-webkit-transition: all <?php echo $speed; ?>s ease-in-out;
		-moz-transition: all <?php echo $speed; ?>s ease-in-out;
			transition: all <?php echo $speed; ?>s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-category:hover,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__content,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__title_wrapper,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__title,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__title_wrapper span,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__img,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__img img,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__button_wrapper,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__button_wrapper .pp-category__button,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__content::before,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__content::after,
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__description_wrapper {
	-webkit-transition: all <?php echo $speed; ?>s ease-in-out;
		-moz-transition: all <?php echo $speed; ?>s ease-in-out;
			transition: all <?php echo $speed; ?>s ease-in-out;
}

.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?> .pp-category__img img {
	<?php
	if ( '' !== $settings->category_bg_opacity && ( ! empty( $settings->category_bg_color ) ) ) {
		?>
				opacity : <?php echo $settings->category_bg_opacity; ?>;
			<?php
	}
	?>
}
.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__img img {
	<?php
	if ( '' !== $settings->category_bg_opacity && ( empty( $settings->category_bg_color ) && ! empty( $settings->category_bg_color_hover ) ) ) {
		?>
				opacity : <?php echo $settings->category_bg_opacity; ?>;
			<?php
	}
	?>
}

.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__title {
	<?php
	if ( '' !== $settings->category_title_hover_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->category_title_hover_color ); ?>;
			<?php
	}
	?>
}

.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__description {
	<?php
	if ( '' !== $settings->category_description_hover_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->category_description_hover_color ); ?>;
			<?php
	}
	?>
}

.fl-node-<?php echo $id; ?> .pp-category .category-<?php echo $category_style; ?>:hover .pp-category__title_wrapper span {
	<?php
	if ( '' !== $settings->category_count_hover_color ) {
		?>
				color : <?php echo pp_get_color_value( $settings->category_count_hover_color ); ?>;
			<?php
	}
	?>
}

<?php
// ========== Style - 0 ==========

if ( 'style-0' === $category_style ) {
	?>
	.fl-node-<?php echo $id; ?> .pp-category .category-style-0 .pp-category__link {
		background-color: transparent;
	}
	.fl-node-<?php echo $id; ?> .pp-category .category-style-0 .pp-category__content {
		<?php
		if ( '' !== $settings->category_bg_color ) {
			?>
					background-color : <?php echo pp_get_color_value( $settings->category_bg_color ); ?>;
				<?php
		}
		?>
	}
	.fl-node-<?php echo $id; ?> .pp-category .category-style-0:hover .pp-category__content {
		<?php
		if ( '' !== $settings->category_bg_color_hover ) {
			?>
					background-color : <?php echo pp_get_color_value( $settings->category_bg_color_hover ); ?>;
				<?php
		}
		?>
	}
	.fl-node-<?php echo $id; ?> .pp-category .category-style-0 .pp-category__title_wrapper span {
		<?php
		if ( '' !== $settings->category_count_color ) {
			?>
					color : <?php echo pp_get_color_value( $settings->category_count_color ); ?>;
				<?php
		}

		?>
	}
	.fl-node-<?php echo $id; ?> .pp-category .category-style-0 .pp-category__img img,
	.fl-node-<?php echo $id; ?> .pp-category .category-style-0:hover .pp-category__img img {
		opacity: 1;
	}

<?php } // End if(). ?>

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-bullet {
	opacity: 1;
	<?php if ( isset( $settings->pagination_bg_color ) && ! empty( $settings->pagination_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->pagination_bg_color ); ?>;
	<?php } ?>
	<?php if ( $settings->bullets_width >= 0 ) { ?>
	width: <?php echo $settings->bullets_width; ?>px;
	<?php } ?>
	<?php if ( $settings->bullets_width >= 0 ) { ?>
	height: <?php echo $settings->bullets_width; ?>px;
	<?php } ?>
	<?php if ( $settings->bullets_border_radius >= 0 ) { ?>
	border-radius: <?php echo $settings->bullets_border_radius; ?>%;
	<?php } ?>
	box-shadow: none;
}

.fl-node-<?php echo $id; ?> .pp-categories-container.swiper-container-horizontal > .swiper-pagination-bullets, .pp-categories-container .swiper-pagination-fraction {
	<?php if ( $settings->bullets_border_radius >= 0 ) { ?>
	padding-top: <?php echo $settings->bullets_top_margin; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-progressbar {
	<?php if ( isset( $settings->pagination_bg_color ) && ! empty( $settings->pagination_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->pagination_bg_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-bullet:hover,
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-bullet-active,
.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
	<?php if ( isset( $settings->pagination_bg_hover ) && ! empty( $settings->pagination_bg_hover ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->pagination_bg_hover ); ?>;
	<?php } ?>
	opacity: 1;
	box-shadow: none;
}

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-fraction .swiper-pagination-total {
	<?php if ( isset( $settings->pagination_bg_color ) && ! empty( $settings->pagination_bg_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->pagination_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-categories-container .swiper-pagination-fraction .swiper-pagination-current {
	<?php if ( isset( $settings->pagination_bg_hover ) && ! empty( $settings->pagination_bg_hover ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->pagination_bg_hover ); ?>;
	<?php } ?>
}

<?php
// *********************
// Media Query
// *********************
?>

@media only screen and ( max-width: <?php echo $global_settings->medium_breakpoint; ?>px ) {
	<?php
	$height_medium = $settings->category_height_medium;
	if ( 'no' === $settings->category_grid_slider ) {
		?>

	.fl-node-<?php echo $id; ?> .pp-category:nth-of-type(<?php echo $column_desktop . 'n'; ?>) {
		margin-right : <?php echo $column_medium . '%'; ?>;
	}

	.fl-node-<?php echo $id; ?> .pp-category:nth-of-type(<?php echo $column_medium . 'n'; ?>) {
		margin-right: 0;
	}

	<?php } ?>


	.fl-node-<?php echo $id; ?> .pp-category {
		width : <?php echo $width_medium . '%'; ?>;
		<?php
		if ( ! empty( $column_medium ) ) {

			if ( '' !== $width_medium ) {
				?>
					width : <?php echo $width_medium . '%'; ?>;
				<?php
			}

			if ( '' !== $height_medium ) {
				?>
					height : <?php echo $height_medium . 'px'; ?>;
				<?php
			}

			if ( '' !== $spacing_medium ) {
				?>
					margin-right : <?php echo $spacing_medium . '%'; ?>;
					margin-bottom : <?php echo $spacing_medium . '%'; ?>;
				<?php
			}
		}
		?>
	}
	.fl-node-<?php echo $id; ?> .pp-category .pp-category__content {
		<?php if ( ! empty( $height_medium ) ) { ?>
			height: <?php echo ( $height_medium - 40 ); ?>px;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-category .pp-category__title_wrapper span {
		<?php
		?>
	}

	.fl-node-<?php echo $id; ?> .pp-category__button_wrapper .pp-category__button {
		<?php
		if ( 'full_width' === $settings->button_width ) {
			?>
					width : 100%;
			<?php
		}

		if ( '' !== $settings->button_width_custom_medium && 'custom' === $settings->button_width ) {
			?>
					width : <?php echo $settings->button_width_custom_medium . '%'; ?>;
				<?php
		}

		if ( '' !== $settings->button_margin_top_medium ) {
			?>
					margin-top : <?php echo $settings->button_margin_top_medium . 'px'; ?>;
				<?php
		}

		if ( '' !== $settings->button_margin_bottom_medium ) {
			?>
					margin-bottom : <?php echo $settings->button_margin_bottom_medium . 'px'; ?>;
				<?php
		}
		?>
	}

	.fl-node-<?php echo $id; ?> .pp-category__img {
		<?php
		if ( '' !== $height_medium ) {
			?>
				height : <?php echo $height_medium . 'px'; ?>;
			<?php
		}
		?>
	}
}

@media only screen and ( max-width: <?php echo $global_settings->responsive_breakpoint; ?>px ) {
	<?php
	$height_responsive = $settings->category_height_responsive;

	if ( 'no' === $settings->category_grid_slider ) {
		?>

		.fl-node-<?php echo $id; ?> .pp-category:nth-of-type(<?php echo $column_desktop . 'n'; ?>) {
			margin-right : <?php echo $column_responsive . '%'; ?>;
		}

		.fl-node-<?php echo $id; ?> .pp-category:nth-of-type(<?php echo $column_medium . 'n'; ?>) {
			margin-right : <?php echo $column_responsive . '%'; ?>;
		}

		.fl-node-<?php echo $id; ?> .pp-category:nth-of-type(<?php echo $column_responsive . 'n'; ?>) {
			margin-right: 0;
		}
	<?php } ?>
	.fl-node-<?php echo $id; ?> .pp-category {
		width : <?php echo $width_medium . '%'; ?>;
		<?php
		if ( ! empty( $column_responsive ) ) {
			if ( '' !== $width_responsive ) {
				?>
					width : <?php echo $width_responsive . '%'; ?>;
				<?php
			}
		}
		?>
		<?php
		if ( '' !== $height_responsive ) {
			?>
					height : <?php echo $height_responsive . 'px'; ?>;
				<?php
		}

		if ( '' !== $spacing_responsive ) {
			?>
					margin-right : <?php echo $spacing_responsive . '%'; ?>;
					margin-bottom : <?php echo $spacing_responsive . '%'; ?>;
				<?php
		}
		?>
	}

	.fl-node-<?php echo $id; ?> .pp-category .pp-category__content {
		<?php if ( ! empty( $height_responsive ) ) { ?>
			height: <?php echo ( $height_responsive - 40 ); ?>px;
		<?php } ?>
	}

	.fl-node-<?php echo $id; ?> .pp-category .pp-category__title_wrapper span {
		<?php

		?>
	}

	.fl-node-<?php echo $id; ?> .pp-category__button_wrapper .pp-category__button {
		<?php
		if ( 'full_width' === $settings->button_width ) {
			?>
					width : 100%;
			<?php
		}

		if ( 'custom' === $settings->button_width && '' !== $settings->button_width_custom_responsive ) {
			?>
					width : <?php echo $settings->button_width_custom_responsive . '%'; ?>;
				<?php
		}

		if ( '' !== $settings->button_margin_top_responsive ) {
			?>
					margin-top : <?php echo $settings->button_margin_top_responsive . 'px'; ?>;
				<?php
		}

		if ( '' !== $settings->button_margin_bottom_responsive ) {
			?>
					margin-bottom : <?php echo $settings->button_margin_bottom_responsive . 'px'; ?>;
				<?php
		}
		?>
	}

	.fl-node-<?php echo $id; ?> .pp-category__img {
		<?php
		if ( '' !== $height_responsive ) {
			?>
					height : <?php echo $height_responsive . 'px'; ?>;
				<?php
		}
		?>
	}
}
