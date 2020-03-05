<?php
$activeTabIndex = absint($settings->tab_default);
$activeTabIndex = $activeTabIndex > count($settings->items) ? 0 : $activeTabIndex;
$activeTabIndex = $activeTabIndex < 1 ? 0 : $activeTabIndex - 1;
$css_id = '';
?>

<div class="pp-tabs pp-tabs-<?php echo $settings->layout; ?> pp-tabs-<?php echo $settings->tab_style; ?> pp-clearfix" role="tablist">

	<div class="pp-tabs-labels pp-clearfix">
		<?php for( $i = 0; $i < count($settings->items); $i++ ) :
			if( !is_object($settings->items[$i]) ) continue;
			$css_id = ( $settings->tab_id_prefix != '' ) ? $settings->tab_id_prefix . '-' . ($i+1) : 'pp-tab-' . $id . '-' . ($i+1);
			?>
		<div id="<?php echo $css_id; ?>" class="pp-tabs-label<?php if($i == $activeTabIndex) echo ' pp-tab-active'; ?> <?php echo 'pp-tab-icon-' . $settings->tab_icon_position; ?>" data-index="<?php echo $i; ?>" role="tab" aria-controls="<?php echo $css_id; ?>-content">
			<div class="pp-tab-label-inner">
				<?php if( $settings->tab_icon_position == 'left' || $settings->tab_icon_position == 'top' ) { ?>
					<?php if( $settings->items[$i]->tab_font_icon ) { ?>
						<span class="pp-tab-icon <?php echo $settings->items[$i]->tab_font_icon; ?>"></span>
					<?php } ?>
				<?php } ?>
				<span class="pp-tab-title"><?php echo $settings->items[$i]->label; ?></span>

				<?php if( $settings->tab_icon_position == 'right' || $settings->tab_icon_position == 'bottom' ) { ?>
					<?php if( $settings->items[$i]->tab_font_icon ) { ?>
						<span class="pp-tab-icon <?php echo $settings->items[$i]->tab_font_icon; ?>"></span>
					<?php } ?>
				<?php } ?>

			</div>
		</div>
		<?php endfor; ?>
	</div>

	<div class="pp-tabs-panels pp-clearfix">
		<?php for($i = 0; $i < count($settings->items); $i++) :
			if ( ! is_object( $settings->items[$i] ) ) continue;
			$css_id = ( $settings->tab_id_prefix != '' ) ? $settings->tab_id_prefix . '-' . ($i+1) : 'pp-tab-' . $id . '-' . ($i+1);
			?>
		<div class="pp-tabs-panel"<?php if ( ! empty( $settings->id ) ) echo ' id="' . sanitize_html_class( $settings->id ) . '-' . $i . '"'; ?>>
			<div class="pp-tabs-label pp-tabs-panel-label<?php if($i == $activeTabIndex) echo ' pp-tab-active'; ?> <?php echo 'pp-tab-icon-' . $settings->tab_icon_position; ?>" data-index="<?php echo $i; ?>" role="tab">
				<div class="pp-tab-label-inner">
					<?php if( $settings->tab_icon_position == 'left' || $settings->tab_icon_position == 'top' ) { ?>
						<?php if( $settings->items[$i]->tab_font_icon ) { ?>
							<span class="pp-tab-icon <?php echo $settings->items[$i]->tab_font_icon; ?>"></span>
						<?php } ?>
					<?php } ?>
					<span class="pp-tab-title"><?php echo $settings->items[$i]->label; ?></span>

					<?php if( $settings->tab_icon_position == 'right' || $settings->tab_icon_position == 'bottom' ) { ?>
						<?php if( $settings->items[$i]->tab_font_icon ) { ?>
							<span class="pp-tab-icon <?php echo $settings->items[$i]->tab_font_icon; ?>"></span>
						<?php } ?>
					<?php } ?>
					<?php if( $settings->tab_open_icon != '' ) { ?>
						<span class="pp-toggle-icon pp-tab-open <?php echo $settings->tab_open_icon; ?>"></span>
					<?php } else { ?>
						<i class="pp-toggle-icon pp-tab-open fa fa-plus"></i>
					<?php } ?>

					<?php if( $settings->tab_close_icon != '' ) { ?>
						<span class="pp-toggle-icon pp-tab-close <?php echo $settings->tab_close_icon; ?>"></span>
					<?php } else { ?>
						<i class="pp-toggle-icon pp-tab-close fa fa-minus"></i>
					<?php } ?>
				</div>
			</div>
			<div id="<?php echo $css_id; ?>-content" class="pp-tabs-panel-content pp-clearfix<?php if($i == $activeTabIndex) echo ' pp-tab-active'; ?>" data-index="<?php echo $i; ?>" role="tabpanel" aria-labelledby="<?php echo $css_id; ?>">
				<?php echo $module->render_content( $settings->items[ $i ] ); ?>
			</div>
		</div>
		<?php endfor; ?>
	</div>

</div>
