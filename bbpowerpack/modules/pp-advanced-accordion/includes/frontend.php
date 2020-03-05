<?php
	$css_id = '';
	$items  = $module->get_accordion_items();
	$source = $settings->accordion_source;
?>

<div class="pp-accordion<?php echo ( $settings->collapse ) ? ' pp-accordion-collapse' : ''; ?>">
	<?php
	for ( $i = 0; $i < count( $items ); $i++ ) :
		if ( empty( $items[ $i ] ) ) {
			continue;
		}
		$css_id = ( '' !== $settings->accordion_id_prefix ) ? $settings->accordion_id_prefix . '-' . ( $i + 1 ) : 'pp-accord-' . $id . '-' . ( $i + 1 );
		?>
		<div id="<?php echo $css_id; ?>" class="pp-accordion-item">
			<div class="pp-accordion-button">
				<?php if ( $items[ $i ]->accordion_font_icon ) { ?>
					<span class="pp-accordion-icon <?php echo $items[ $i ]->accordion_font_icon; ?>"></span>
				<?php } ?>
				<span class="pp-accordion-button-label" itemprop="name description"><?php echo $items[ $i ]->label; ?></span>

				<?php if ( '' !== $settings->accordion_open_icon ) { ?>
					<span class="pp-accordion-button-icon pp-accordion-open <?php echo $settings->accordion_open_icon; ?>"></span>
				<?php } else { ?>
					<i class="pp-accordion-button-icon pp-accordion-open fa fa-plus"></i>
				<?php } ?>

				<?php if ( '' !== $settings->accordion_close_icon ) { ?>
					<span class="pp-accordion-button-icon pp-accordion-close <?php echo $settings->accordion_close_icon; ?>"></span>
				<?php } else { ?>
					<i class="pp-accordion-button-icon pp-accordion-close fa fa-minus"></i>
				<?php } ?>

			</div>

			<div class="pp-accordion-content fl-clearfix">
				<?php
				if ( ! isset( $source ) || empty( $source ) ) {
					echo $module->render_content( $items[ $i ] );
				} else {
					if ( 'manual' === $source ) {
						echo $module->render_content( $items[ $i ] );
					} else {
						echo $items[ $i ]->content;
					}
				}
				?>
			</div>
		</div>
	<?php endfor; ?>
</div>
