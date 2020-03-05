<table class="fl-theme-builder-settings-form fl-mb-table widefat">

	<tr class="fl-mb-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Type', 'fl-theme-builder' ); ?></label>
		</td>
		<td class="fl-mb-row-content">
			<?php

			echo ucwords( $type );

			if ( ! FLThemeBuilderLayoutData::is_layout_supported( $post->ID ) ) {
				echo ' <strong style="color:#a00;">(' . __( 'Unsupported', 'fl-theme-builder' ) . ')</strong>';
			}

			?>
			<input name="fl-theme-layout-type" type="hidden" value="<?php echo $type; ?>" />
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-hook-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Position', 'fl-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'The position on the page where this layout should appear.', 'fl-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-hook">
				<option value=""><?php _e( 'Choose...', 'fl-theme-builder' ); ?></option>
				<?php foreach ( $hooks as $hook_group ) : ?>
				<optgroup label="<?php echo $hook_group['label']; ?>">
					<?php foreach ( $hook_group['hooks'] as $key => $label ) : ?>
					<option value="<?php echo $key; ?>" <?php selected( $key, $hook ); ?>><?php echo $label; ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-order-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Order', 'fl-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'The order of this Themer layout when others are present.', 'fl-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<input name="fl-theme-layout-order" type="number" value="<?php echo ( '' == $order ? 0 : $order ); ?>" />
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-sticky">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Sticky', 'fl-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Stick this header to the top of the window as the page is scrolled.', 'fl-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[sticky]">
				<option value="1" <?php selected( $settings['sticky'], '1' ); ?>><?php _e( 'Yes', 'fl-theme-builder' ); ?></option>
				<option value="0" <?php selected( $settings['sticky'], '0' ); ?>><?php _e( 'No', 'fl-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-shrink">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Shrink', 'fl-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Shrink this header when the page is scrolled.', 'fl-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[shrink]">
				<option value="1" <?php selected( $settings['shrink'], '1' ); ?>><?php _e( 'Yes', 'fl-theme-builder' ); ?></option>
				<option value="0" <?php selected( $settings['shrink'], '0' ); ?>><?php _e( 'No', 'fl-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-overlay">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Overlay', 'fl-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Overlay this header on top of the page content with a transparent background.', 'fl-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[overlay]">
				<option value="1" <?php selected( $settings['overlay'], '1' ); ?>><?php _e( 'Yes', 'fl-theme-builder' ); ?></option>
				<option value="0" <?php selected( $settings['overlay'], '0' ); ?>><?php _e( 'No', 'fl-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-overlay-bg">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Background', 'fl-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Use either the default background color or a transparent background color until the page is scrolled.', 'fl-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[overlay_bg]">
				<option value="default" <?php selected( $settings['overlay_bg'], 'default' ); ?>><?php _e( 'Default', 'fl-theme-builder' ); ?></option>
				<option value="transparent" <?php selected( $settings['overlay_bg'], 'transparent' ); ?>><?php _e( 'Transparent', 'fl-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

</table>
