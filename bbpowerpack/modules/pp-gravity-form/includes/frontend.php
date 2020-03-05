<?php
$enable_ajax = 'yes' === $settings->form_ajax ? 'true' : 'false';
?>
<div class="pp-gf-content">
	<?php if ( 'yes' === $settings->form_custom_title_desc ) { ?>
		<h3 class="form-title"><?php echo $settings->custom_title; ?></h3>
		<p class="form-description"><?php echo $settings->custom_description; ?></p>
	<?php } ?>
	<?php if ( ! empty( $settings->select_form_field ) ) { ?>
		[gravityform id="<?php echo absint( $settings->select_form_field ); ?>" title="<?php echo $settings->title_field; ?>" description="<?php echo $settings->description_field; ?>" ajax="<?php echo $enable_ajax; ?>" tabindex="<?php echo $settings->form_tab_index; ?>"]
	<?php } ?>
</div>
