<tr class="fl-template-theme-layout-row" style="display: none;">
	<th>
		<label for="fl-template[theme-layout]"><?php _e( 'Layout', 'fl-theme-builder' ); ?></label>
	</th>
	<td>
		<select name="fl-template[theme-layout]">
			<optgroup label="<?php _e( 'Structure', 'fl-theme-builder' ); ?>">
				<option value="header"><?php _e( 'Header', 'fl-theme-builder' ); ?> <?php echo ( ! $headers ) ? __( '(Unsupported)', 'fl-theme-builder' ) : ''; ?></option>
				<option value="footer"><?php _e( 'Footer', 'fl-theme-builder' ); ?> <?php echo ( ! $footers ) ? __( '(Unsupported)', 'fl-theme-builder' ) : ''; ?></option>
			</optgroup>
			<optgroup label="<?php _e( 'Content', 'fl-theme-builder' ); ?>">
				<option value="archive"><?php _e( 'Archive', 'fl-theme-builder' ); ?></option>
				<option value="singular"><?php _e( 'Singular', 'fl-theme-builder' ); ?></option>
				<option value="404"><?php _e( '404', 'fl-theme-builder' ); ?></option>
				<option value="part"><?php _e( 'Part', 'fl-theme-builder' ); ?> <?php echo ( ! $parts || empty( $hooks ) ) ? __( '(Unsupported)', 'fl-theme-builder' ) : ''; ?></option>
			</optgroup>
		</select>
	</td>
</tr>
