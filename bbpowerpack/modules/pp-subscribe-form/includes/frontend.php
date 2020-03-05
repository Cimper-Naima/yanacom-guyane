<?php if ( 'standard' != $settings->box_type && 'fixed_bottom' != $settings->box_type ) { ?>
	<div class="pp-subscribe-<?php echo $id; ?> pp-subscribe-<?php echo $settings->box_type; ?> pp-subscribe-box fl-node-<?php echo $id; ?> pp-clearfix">
		<div class="pp-subscribe-inner">
			<a href="#" class="pp-box-close">
				<svg class="pp-box-close-svg" viewbox="0 0 40 40">
			    	<path d="M 10,10 L 30,30 M 30,10 L 10,30" />
			  	</svg>
			</a>
			<div class="pp-subscribe-body">
				<div class="pp-subscribe-content">
					<?php echo $settings->box_content; ?>
				</div>
<?php } ?>

	<div class="pp-subscribe-form pp-subscribe-form-<?php echo $settings->layout; ?> pp-subscribe-form-name-<?php echo $settings->show_name; ?> pp-form pp-clearfix" <?php if ( isset( $module->template_id ) ) echo 'data-template-id="' . $module->template_id . '" data-template-node-id="' . $module->template_node_id . '"'; ?>>

		<?php if ( 'fixed_bottom' == $settings->box_type ) { ?>
			<div class="pp-box-close"></div>
		<?php } ?>

		<div class="pp-subscribe-form-inner pp-clearfix">

			<?php if ( ('standard' == $settings->box_type || 'fixed_bottom' == $settings->box_type) && 'yes' == $settings->show_content ) { ?>
			<div class="pp-subscribe-content">
				<?php echo $settings->box_content; ?>
			</div>
			<?php } ?>

			<?php if ( 'show' == $settings->show_name ) : ?>

				<div class="pp-form-field pp-name-field">
					<input type="text" name="pp-subscribe-form-name" placeholder="<?php echo $settings->input_name_placeholder; ?>" />
					<div class="pp-form-error-message"><?php esc_html_e( 'Please enter your name.', 'bb-powerpack' ); ?></div>
				</div>

			<?php endif; ?>

			<div class="pp-form-field pp-email-field">
				<input type="email" name="pp-subscribe-form-email" placeholder="<?php echo $settings->input_email_placeholder; ?>" />
				<div class="pp-form-error-message"><?php esc_html_e( 'Please enter a valid email address.', 'bb-powerpack' ); ?></div>
			</div>

			<?php if ( ( 'stacked' == $settings->layout || 'compact' == $settings->layout ) && isset( $settings->checkbox_field ) && 'show' == $settings->checkbox_field ) : ?>
			<div class="pp-form-field pp-acceptance-field pp-checkbox-input">
				<input type="checkbox" name="pp-subscribe-form-acceptance" id="pp-subscribe-form-acceptance-<?php echo $id; ?>" value="1" />
				<label for="pp-subscribe-form-acceptance-<?php echo $id; ?>"><?php echo $settings->checkbox_field_text; ?></label>
				<div class="pp-form-error-message"><?php esc_html_e( 'Please check the required field.', 'bb-powerpack' ); ?></div>
			</div>
			<?php endif; ?>

			<div class="pp-form-button pp-button-wrap" data-wait-text="<?php esc_attr_e( 'Please Wait...', 'bb-powerpack' ); ?>">

				<?php

					FLBuilder::render_module_html( 'fl-button', array(
						'align'             => '',
						'bg_color'          => $settings->btn_bg_color,
						'bg_hover_color'    => $settings->btn_bg_hover_color,
						'bg_opacity'        => $settings->btn_bg_opacity,
						'bg_hover_opacity'  => $settings->btn_bg_hover_opacity,
						'icon'              => $settings->btn_icon,
						'icon_position'     => $settings->btn_icon_position,
						'icon_animation'    => $settings->btn_icon_animation,
						'link'              => '#',
						'link_target'       => '_self',
						'style'             => $settings->btn_style,
						'text'              => $settings->btn_text,
						'text_color'        => $settings->btn_text_color,
						'text_hover_color'  => $settings->btn_text_hover_color,
						'width'             => 'full',
						'class'				=> 'pp-button'
					));

				?>

			</div>

			<?php if ( 'inline' == $settings->layout && isset( $settings->checkbox_field ) && 'show' == $settings->checkbox_field ) : ?>
			<div class="pp-form-field pp-acceptance-field pp-checkbox-input">
				<input type="checkbox" name="pp-subscribe-form-acceptance" id="pp-subscribe-form-acceptance-<?php echo $id; ?>" value="1" />
				<label for="pp-subscribe-form-acceptance-<?php echo $id; ?>"><?php echo $settings->checkbox_field_text; ?></label>
				<div class="pp-form-error-message"><?php esc_html_e( 'Please check the required field.', 'bb-powerpack' ); ?></div>
			</div>
			<?php endif; ?>

			<div class="pp-form-error-message"><?php esc_html_e( 'Something went wrong. Please check your entries and try again.', 'bb-powerpack' ); ?></div>
		</div>
		<?php if( '' != $settings->footer_text ) { ?>
			<div class="pp-subscribe-form-footer">
				<?php echo $settings->footer_text; ?>
			</div>
		<?php } ?>
	</div>

<?php if ( 'standard' != $settings->box_type && 'fixed_bottom' != $settings->box_type ) { ?>
			</div><!-- .pp-subscribe-body -->
		</div><!-- .pp-subscribe-inner -->
	</div>
<?php } ?>
