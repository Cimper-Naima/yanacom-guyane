<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file:
 *
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * PPNinjaFormModule:
 */

?>
<div class="pp-ninja-form-content">
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
        echo do_shortcode( '[ninja_forms id='.$settings->select_form_field.']' );
    }
    ?>
</div>
