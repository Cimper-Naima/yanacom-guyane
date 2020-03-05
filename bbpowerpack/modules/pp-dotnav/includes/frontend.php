<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file:
 *
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 */

?>
<?php if ( FLBuilderModel::is_builder_active() ) { ?>
<div class="pp-helper"><?php _e('Click here to edit the dot navigation module. This text is only for editing and will not appear after you publish the changes.', 'bb-powerpack'); ?></div>
<?php } ?>

<div id="pp-dotnav-<?php echo $module->node; ?>" class="pp-dotnav">
    <ul class="pp-dots">
        <?php echo $module->get_dot_html(); ?>
    </ul>
</div>
