<?php
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'list_item_typography',
			'selector'     => ".fl-node-$id .pp-sitemap-section .pp-sitemap-list",
		)
	);

	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'label_typography',
			'selector'     => ".fl-node-$id .pp-sitemap-section .pp-sitemap-label",
		)
	);

	FLBuilderCSS::border_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'label_border',
			'selector'     => ".fl-node-$id .pp-sitemap-section .pp-sitemap-label",
		)
	);

	FLBuilderCSS::responsive_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'sitemap_padding',
			'selector'     => ".fl-node-$id .pp-sitemap-section",
			'prop'         => 'padding',
			'unit'         => 'px',
		)
	);

	FLBuilderCSS::responsive_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'label_padding',
			'selector'     => ".fl-node-$id .pp-sitemap-section .pp-sitemap-label",
			'prop'         => 'padding',
			'unit'         => 'px',
		)
	);

	FLBuilderCSS::dimension_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'list_item_padding',
			'selector'     => ".fl-node-$id .pp-sitemap-section .pp-sitemap-list > li",
			'unit'         => 'px',
			'props'        => array(
				'padding-top'    => 'list_item_padding_top',
				'padding-right'  => 'list_item_padding_right',
				'padding-bottom' => 'list_item_padding_bottom',
				'padding-left'   => 'list_item_padding_left',
			),
		)
	);

	FLBuilderCSS::dimension_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'label_padding',
			'selector'     => ".fl-node-$id .pp-sitemap-section .pp-sitemap-label",
			'unit'         => 'px',
			'props'        => array(
				'padding-top'    => 'label_padding_top',
				'padding-right'  => 'label_padding_right',
				'padding-bottom' => 'label_padding_bottom',
				'padding-left'   => 'label_padding_left',
			),
		)
	);

	?>

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section {
	flex-basis: calc( 1 / <?php echo $settings->sitemap_columns; ?> * 100% );
	<?php if ( ! empty( $settings->sitemap_padding_top ) ) { ?>
		padding-top: <?php echo $settings->sitemap_padding_top; ?>px;
		<?php
	}
	if ( ! empty( $settings->sitemap_padding_right ) ) {
		?>
		padding-right: <?php echo $settings->sitemap_padding_right; ?>px;
		<?php
	}
	if ( ! empty( $settings->sitemap_padding_bottom ) ) {
		?>
		padding-bottom: <?php echo $settings->sitemap_padding_bottom; ?>px;
		<?php
	}
	if ( ! empty( $settings->sitemap_padding_left ) ) {
		?>
		padding-left: <?php echo $settings->sitemap_padding_left; ?>px;
	<?php } ?>
}

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section .pp-sitemap-list {
	<?php
	if ( ! empty( $settings->sitemap_indent ) ) {
		?>
		margin-left: <?php echo $settings->sitemap_indent; ?>px;
		<?php
	}

	if ( ! empty( $settings->list_item_color ) ) {
		?>
		color : <?php echo pp_get_color_value( $settings->list_item_color ); ?>;
		<?php
	}

	if ( ! empty( $settings->list_item_background_color ) ) {
		?>
		background-color : <?php echo pp_get_color_value( $settings->list_item_background_color ); ?>;
		<?php
	}

	?>
}

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section .pp-sitemap-list > li {
	<?php
	if ( ! empty( $settings->list_item_seperator_style ) && 'none' !== $settings->list_item_seperator_style ) {
		?>
		border-bottom-style: <?php echo $settings->list_item_seperator_style; ?>;
		border-bottom-width: <?php echo $settings->list_item_seperator_size; ?>px;
		border-bottom-color: <?php echo pp_get_color_value( $settings->list_item_seperator_color ); ?>;
		<?php
	}

	?>
}

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section ul.children, .fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section ul.pp-sitemap-list {
	<?php
	if ( ! empty( $settings->bullet_style ) ) {
		?>
		list-style-type: <?php echo $settings->bullet_style; ?>;
		<?php
	}
	if ( ! empty( $settings->bullet_color ) && 'no' === $settings->sitemap_tree ) {
		?>
		color : <?php echo pp_get_color_value( $settings->bullet_color ); ?>;
		<?php
	}
	?>
}

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section ul li a {
	<?php
	if ( ! empty( $settings->list_item_color ) ) {
		?>
		color : <?php echo pp_get_color_value( $settings->list_item_color ); ?>;
		<?php
	}
	?>
}

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section ul li a:hover {
	<?php
	if ( ! empty( $settings->list_item_color_hover ) ) {
		?>
		color : <?php echo pp_get_color_value( $settings->list_item_color_hover ); ?>;
		<?php
	}
	?>
}

.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section .pp-sitemap-label {
	<?php
	if ( ! empty( $settings->label_color ) ) {
		?>
		color : <?php echo pp_get_color_value( $settings->label_color ); ?>;
		<?php
	}

	if ( ! empty( $settings->label_background_color ) ) {
		?>
		background-color : <?php echo pp_get_color_value( $settings->label_background_color ); ?>;
		<?php
	}
	?>
}

<?php
if ( 'yes' === $settings->sitemap_tree ) {
	?>
	.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section ul {
		list-style-type : none !important;
		padding-inline-start: 0 !important;
	}

	<?php if ( '' !== $settings->sitemap_tree_color ) { ?>
	.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section ul.tree li {
		color: <?php echo pp_get_color_value( $settings->sitemap_tree_color ); ?>;
	}
	<?php } ?>

<?php } ?>

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section {
		<?php
		if ( isset( $settings->sitemap_columns_medium ) && ! empty( $settings->sitemap_columns_medium ) ) {
			?>
			flex-basis: calc( 1 / <?php echo $settings->sitemap_columns_medium; ?> * 100% );
			<?php
		} else {
			?>
			flex-basis: calc( 1 / 2 * 100% );
			<?php
		}
		?>
	}

}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-module-pp-sitemap.fl-node-<?php echo $id; ?> .pp-sitemap-section {
		<?php
		if ( isset( $settings->sitemap_columns_responsive ) && ! empty( $settings->sitemap_columns_responsive ) ) {
			?>
			flex-basis: calc( 1 / <?php echo $settings->sitemap_columns_responsive; ?> * 100% );
			<?php
		} else {
			?>
			flex-basis: calc( 1 / 1 * 100% );
			<?php
		}
		?>
	}
}
