<div class="pp-highlight-box-content <?php echo $settings->box_icon_effect; ?>">
    <?php if( $settings->box_font_icon && $settings->box_icon_select == 'font_icon' ) { ?>
        <div class="font_icon">
            <div class="font_icon_inner">
                <i class="<?php echo $settings->box_font_icon; ?>"></i>
            </div>
        </div>
    <?php } ?>
    <?php if( $settings->box_custom_icon && $settings->box_icon_select == 'custom_icon' ) { ?>
        <div class="custom_icon">
            <div class="custom_icon_inner">
                <div class="custom_icon_inner_wrap">
					<?php $alt = get_post_meta($settings->box_custom_icon , '_wp_attachment_image_alt', true); ?>
                    <img src="<?php echo $settings->box_custom_icon_src; ?>" alt="<?php echo $alt; ?>" />
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="box-text">
        <?php
        if ( $settings->box_content ) {
            echo $settings->box_content;
        }
        ?>
    </div>
    <?php if ( $settings->box_link ) { ?>
        <a class="box-link" href="<?php echo $settings->box_link; ?>" target="<?php echo $settings->box_link_target; ?>"<?php echo $module->get_rel(); ?>></a>
    <?php } ?>
</div>
