<?php
$title_tag = isset( $settings->title_tag ) ? $settings->title_tag : 'h3';
?>

<form class="pp-contact-form pp-form-<?php echo $settings->form_layout; ?>" <?php if ( isset( $module->template_id ) ) echo 'data-template-id="' . $module->template_id . '" data-template-node-id="' . $module->template_node_id . '"'; ?>>
    <<?php echo $title_tag; ?> class="pp-form-title">
	<?php if ( $settings->custom_title ) {
	 	echo $settings->custom_title;
	} ?>
	</<?php echo $title_tag; ?>>
	<p class="pp-form-description">
	<?php if ( $settings->custom_description ) {
		echo $settings->custom_description;
	} ?>
	</p>
    <div class="pp-contact-form-inner pp-clearfix">
        <?php if( $settings->form_layout == 'stacked-inline' ) { ?>
            <div class="pp-contact-form-fields-left">
        <?php } ?>
    	<?php if ($settings->name_toggle == 'show') : ?>
    	<div class="pp-input-group pp-name">
    		<label for="pp-name-<?php echo $id; ?>"><?php echo ( ! isset( $settings->name_label ) ) ? _x( 'Name', 'Contact form Name field label.', 'bb-powerpack' ) : $settings->name_label;?></label>
    		<span class="pp-contact-error"><?php esc_html_e('Please enter your name.', 'bb-powerpack');?></span>
    		<input type="text" name="pp-name" id="pp-name-<?php echo $id; ?>" value="" <?php if( $settings->input_placeholder_display == 'block' ) { ?>placeholder="<?php echo ! empty($settings->name_label) ? $settings->name_label : esc_attr__( 'Name', 'bb-powerpack' ); ?>" <?php } ?> />
    	</div>
    	<?php endif; ?>

    	<?php if ($settings->email_toggle == 'show') : ?>
    	<div class="pp-input-group pp-email">
    		<label for="pp-email-<?php echo $id; ?>"><?php echo ( ! isset( $settings->email_label ) ) ? _x( 'Email', 'Contact form Email field label.', 'bb-powerpack' ) : $settings->email_label;?></label>
    		<span class="pp-contact-error"><?php esc_html_e('Please enter a valid email.', 'bb-powerpack');?></span>
    		<input type="email" name="pp-email" id="pp-email-<?php echo $id; ?>" value="" <?php if( $settings->input_placeholder_display == 'block' ) { ?>placeholder="<?php echo ! empty($settings->email_label) ? $settings->email_label : esc_attr__( 'Email', 'bb-powerpack' ); ?>" <?php } ?> />
    	</div>
    	<?php endif; ?>

    	<?php if ($settings->phone_toggle == 'show') : ?>
    	<div class="pp-input-group pp-phone">
    		<label for="pp-phone-<?php echo $id; ?>"><?php echo ( ! isset( $settings->phone_label ) ) ? _x( 'Phone', 'Contact form Phone field label.', 'bb-powerpack' ) : $settings->phone_label;?></label>
    		<span class="pp-contact-error"><?php esc_html_e('Please enter a valid phone number.', 'bb-powerpack');?></span>
    		<input type="tel" name="pp-phone" id="pp-phone-<?php echo $id; ?>" value="" <?php if( $settings->input_placeholder_display == 'block' ) { ?>placeholder="<?php echo ! empty($settings->phone_label) ? $settings->phone_label : esc_attr__( 'Phone', 'bb-powerpack' ); ?>" <?php } ?> />
    	</div>
    	<?php endif; ?>

        <?php if( $settings->form_layout == 'stacked-inline' ) { ?>
        </div>
        <?php } ?>

        <?php if( $settings->form_layout == 'stacked-inline' ) { ?>
            <div class="pp-contact-form-fields-right">
        <?php } ?>

    	<?php if ($settings->subject_toggle == 'show') : ?>
    	<div class="pp-input-group pp-subject">
    		<label for="pp-subject-<?php echo $id; ?>"><?php echo ( ! isset( $settings->subject_label ) ) ? _x( 'Subject', 'Contact form Subject field label.', 'bb-powerpack' ) : $settings->subject_label;?></label>
    		<span class="pp-contact-error"><?php esc_html_e('Please enter a subject.', 'bb-powerpack');?></span>
    		<input type="text" name="pp-subject" id="pp-subject-<?php echo $id; ?>" value="" <?php if( $settings->input_placeholder_display == 'block' ) { ?>placeholder="<?php echo ! empty($settings->subject_label) ? $settings->subject_label : esc_attr__( 'Subject', 'bb-powerpack' ); ?>" <?php } ?> />
    	</div>
    	<?php endif; ?>

        <?php if ($settings->message_toggle == 'show') : ?>
    	<div class="pp-input-group pp-message">
    		<label for="pp-message-<?php echo $id; ?>"><?php echo ( ! isset( $settings->message_label ) ) ? _x( 'Message', 'Contact form Message field label.', 'bb-powerpack' ) : $settings->message_label;?></label>
    		<span class="pp-contact-error"><?php esc_html_e('Please enter a message.', 'bb-powerpack');?></span>
    		<textarea name="pp-message" id="pp-message-<?php echo $id; ?>" <?php if( $settings->input_placeholder_display == 'block' ) { ?>placeholder="<?php echo ! empty($settings->message_label) ? $settings->message_label : esc_attr__( 'Message', 'bb-powerpack' ); ?>" <?php } ?>></textarea>
    	</div>
        <?php endif; ?>

        <?php if( $settings->form_layout == 'stacked-inline' ) { ?>
        </div>
        <?php } ?>

		<?php
		if ( 'show' == $settings->recaptcha_toggle && (isset( $settings->recaptcha_site_key ) && ! empty( $settings->recaptcha_site_key )) ) :
		?>
		<div class="fl-input-group fl-recaptcha">
			<p class="pp-contact-error"><?php _e( 'Please check the captcha to verify you are not a robot.', 'bb-powerpack' );?></p>
			<div id="<?php echo $id; ?>-fl-grecaptcha" class="fl-grecaptcha" data-sitekey="<?php echo $settings->recaptcha_site_key; ?>"<?php if ( isset( $settings->recaptcha_validate_type ) ) { echo ' data-validate="' . $settings->recaptcha_validate_type . '"';} ?><?php if ( isset( $settings->recaptcha_theme ) ) { echo ' data-theme="' . $settings->recaptcha_theme . '"';} ?>></div>
		</div>
		<?php endif; ?>
	</div>
	
	<?php if ($settings->checkbox_toggle == 'show') : ?>
    	<div class="pp-input-group pp-checkbox">
		<input type="checkbox" name="pp-checkbox" id="pp-checkbox_<?php echo $id; ?>" value="1"<?php echo ( isset( $settings->checked_default ) && 'yes' == $settings->checked_default ) ? ' checked="checked"' : ''; ?> />
		<label for="pp-checkbox_<?php echo $id; ?>"><?php echo ( ! isset( $settings->checkbox_label ) ) ? _x( 'I accept the Terms & Conditions', 'Contact form custom checkbox field label.', 'bb-powerpack' ) : $settings->checkbox_label;?></label>
		<span class="pp-contact-error"><?php esc_html_e('Please check this field.', 'bb-powerpack');?></span>
	</div>
	<?php endif; ?>

    <div class="pp-button-wrap fl-button-wrap">
    	<a href="#" target="_self" class="fl-button<?php if ('enable' == $settings->btn_icon_animation): ?> fl-button-icon-animation<?php endif; ?>" role="button">
    		<?php if ( ! empty( $settings->btn_icon ) && ( 'before' == $settings->btn_icon_position || ! isset( $settings->btn_icon_position ) ) ) : ?>
    		<i class="fl-button-icon fl-button-icon-before fa <?php echo $settings->btn_icon; ?>"></i>
    		<?php endif; ?>
    		<?php if ( ! empty( $settings->btn_text ) ) : ?>
    		<span class="fl-button-text"><?php echo $settings->btn_text; ?></span>
    		<?php endif; ?>
    		<?php if ( ! empty( $settings->btn_icon ) && 'after' == $settings->btn_icon_position ) : ?>
    		<i class="fl-button-icon fl-button-icon-after fa <?php echo $settings->btn_icon; ?>"></i>
    		<?php endif; ?>
    	</a>
    </div>

	<?php if ($settings->success_action == 'redirect') : ?>
		<input type="text" value="<?php echo $settings->success_url; ?>" style="display: none;" class="pp-success-url">
	<?php elseif($settings->success_action == 'none') : ?>
		<span class="pp-success-none" style="display:none;"><?php esc_html_e( 'Message Sent!', 'bb-powerpack' ); ?></span>
	<?php endif; ?>
	<?php $error_msg = isset( $settings->error_message ) && ! empty( $settings->error_message ) ? $settings->error_message : __( 'Message failed. Please try again.', 'bb-powerpack' ); ?>
	<span class="pp-send-error" style="display:none;"><?php echo $error_msg; ?></span>
</form>
<?php if($settings->success_action == 'show_message') : ?>
  <span class="pp-success-msg" style="display:none;"><?php echo $settings->success_message; ?></span>
<?php endif; ?>
