<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file:
 *
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * PPCalderaFormModule:
 */

?>
<div class="pp-caldera-form-content">
	<h3 class="pp-form-title">
	<?php if ( $settings->custom_title ) {
	 	echo $settings->custom_title;
	} ?>
	</h3>
	<p class="pp-form-description">
	<?php if ( $settings->custom_description ) {
		echo $settings->custom_description;
	} ?>
	</p>
    <?php
    if ( $settings->select_form_field ) {
        ?>
		[caldera_form id="<?php echo $settings->select_form_field; ?>"]
		<?php
    }
    ?>
</div>
