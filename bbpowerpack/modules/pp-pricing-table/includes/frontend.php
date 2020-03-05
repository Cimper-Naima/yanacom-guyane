<?php

	$columns = count($settings->pricing_columns);

	if( $settings->pricing_table_style == 'matrix' ) {
		$columns = $columns + 1;
	}

?>

<div class="pp-pricing-table pp-pricing-table-spacing-<?php echo $settings->box_spacing; ?>">

	<?php if ( 'yes' == $settings->dual_pricing ) { ?>
	<div class="pp-pricing-table-switch">
		<div class="pp-pricing-table-buttons">
			<a href="javascript:void(0)" class="pp-pricing-table-button pp-pricing-button-1 pp-pricing-button-active" data-activate-price="primary"><?php echo $settings->dp_button_1_text; ?></a>
			<a href="javascript:void(0)" class="pp-pricing-table-button pp-pricing-button-2" data-activate-price="secondary"><?php echo $settings->dp_button_2_text; ?></a>
		</div>
	</div>
	<?php } ?>

	<?php if( $settings->pricing_table_style == 'matrix' ) { ?>
		<div class="pp-pricing-table-col pp-pricing-table-col-<?php echo $columns; ?> pp-pricing-table-matrix">
			<div class="pp-pricing-table-column">
				<div class="pp-pricing-table-header">
					<<?php echo $settings->title_tag; ?> class="pp-pricing-table-title">&nbsp;</<?php echo $settings->title_tag; ?>>
					<div class="pp-pricing-table-price">
						&nbsp;
					</div>
				</div>
				<ul class="pp-pricing-table-features">
					<?php if ( ! empty( $settings->matrix_items ) ) : $item_count = 0; ?>
						<?php foreach ($settings->matrix_items as $item) : $item_count++; ?>
						<li class="pp-pricing-table-item-<?php echo $item_count; ?>"><?php echo trim( $item ); ?></li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	<?php } ?>

	<?php

	for ($i=0; $i < count($settings->pricing_columns); $i++) :

		if(!is_object($settings->pricing_columns[$i])) continue;

		$pricingColumn = $settings->pricing_columns[$i];

		$highlight = '';
		$f_title = '';

		if( $settings->highlight !== 'none' && $i == $settings->hl_packages ) {
			$highlight = ' pp-pricing-table-highlight';
			if ( $settings->highlight == 'title' ) {
				$highlight = ' pp-pricing-table-highlight-title';
			}
			if ( $settings->highlight == 'price' ) {
				$highlight = ' pp-pricing-table-highlight-price';
			}
		}

		if( $pricingColumn->hl_featured_title ) {
			$f_title = ' pp-has-featured-title';
		}
	?>
	<div class="pp-pricing-table-col pp-pricing-table-card pp-pricing-table-col-<?php echo $columns; ?><?php echo $highlight; ?><?php echo $f_title; ?>">
		<div class="pp-pricing-table-column pp-pricing-table-column-<?php echo $i; ?>">
			<?php if( $pricingColumn->hl_featured_title ) { ?>
				<div class="pp-pricing-featured-title">
					<?php echo $pricingColumn->hl_featured_title; ?>
				</div>
			<?php } ?>
			<div class="pp-pricing-table-inner-wrap">
				<div class="pp-pricing-table-header">
					<?php if( $settings->title_position == 'above' ) { ?>
						<<?php echo $settings->title_tag; ?> class="pp-pricing-table-title"><?php echo isset( $pricingColumn->title ) ? $pricingColumn->title : ''; ?></<?php echo $settings->title_tag; ?>>
					<?php } ?>
					<div class="pp-pricing-table-price pp-price-primary">
						<?php echo isset( $pricingColumn->price ) ? $pricingColumn->price : ''; ?> <span class="pp-pricing-table-duration"><?php echo isset( $pricingColumn->duration ) ? $pricingColumn->duration : ''; ?></span>
					</div>
					<?php if ( 'yes' == $settings->dual_pricing ) { ?>
						<div class="pp-pricing-table-price pp-price-secondary">
						<?php echo $pricingColumn->price_2; ?> <span class="pp-pricing-table-duration"><?php echo $pricingColumn->duration_2; ?></span>
					</div>
					<?php } ?>
					<?php if( $settings->title_position == 'below' ) { ?>
						<<?php echo $settings->title_tag; ?> class="pp-pricing-table-title"><?php echo $pricingColumn->title; ?></<?php echo $settings->title_tag; ?>>
					<?php } ?>
				</div>
				<ul class="pp-pricing-table-features">
					<?php if ( ! empty( $pricingColumn->features ) ) : $item_count = 0; ?>
						<?php foreach ( $pricingColumn->features as $feature ) : $item_count++; ?>
						<li class="pp-pricing-table-item-<?php echo $item_count; ?>">
							<?php if ( ! empty( $settings->matrix_items ) && isset( $settings->matrix_items[ $item_count - 1 ] ) ) { ?>
							<span class="pp-pricing-table-item-label"><?php echo trim( $settings->matrix_items[ $item_count - 1 ] ); ?></span>
							<?php } ?>
							<?php echo trim( $feature ); ?>
						</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>

				<?php $module->render_button($i); ?>
			</div>
		</div>
	</div>
	<?php

	endfor;

	?>
</div>
