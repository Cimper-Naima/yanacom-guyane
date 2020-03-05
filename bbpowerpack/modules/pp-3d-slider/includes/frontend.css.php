div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close {
	opacity: 1;
    background-color: rgba(0,0,0,0.8) !important;
    padding: 1px 7px !important;
    height: 30px;
    width: 30px;
    border-radius: 0;
    line-height: 1 !important;
    font-family: inherit !important;
    font-weight: bold !important;
	font-size: 16px;
    text-align: center !important;
    top: 0 !important;
    right: 0 !important;
}

.admin-bar div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close,
.admin-bar div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close:active,
.admin-bar div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close:hover,
.admin-bar div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close:focus {
    top: 0 !important;
}

div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close:hover,
div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-close:focus {
	background-color: #000 !important;
}

div.mfp-wrap.mfp-<?php echo $id; ?> .mfp-bottom-bar {
    margin-top: 10px;
}

.fl-node-<?php echo $id; ?> {
    overflow-x: hidden;
}
.fl-node-<?php echo $id; ?> .pp-3d-slider.pp-user-agent-safari {
}

<?php if ( 'yes' == $settings->enable_photo_border ) { ?>
	.fl-node-<?php echo $id; ?> .pp-3d-slider .pp-slider-img {
		border-style: solid;
	}
	<?php // Photo Border - Settings
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'photo_border_group',
		'selector' 		=> ".fl-node-$id .pp-3d-slider .pp-slider-img",
	) );
	?>
<?php } ?>
.fl-node-<?php echo $id; ?> .pp-3d-slider .pp-slider-img-caption {
    <?php if ( $settings->caption_color ) { ?>
        color: <?php echo pp_get_color_value($settings->caption_color); ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-3d-slider .pp-slider-nav .fa {
    <?php if ( $settings->arrow_color ) { ?>
        color: <?php echo pp_get_color_value($settings->arrow_color); ?>;
    <?php } ?>
    <?php if ( $settings->arrow_bg_color ) { ?>
        background-color: <?php echo pp_get_color_value($settings->arrow_bg_color); ?>;
    <?php } ?>
    border-radius: <?php echo $settings->arrow_radius; ?>%;
}
.fl-node-<?php echo $id; ?> .pp-3d-slider .pp-slider-nav .fa:hover {
    <?php if ( $settings->arrow_hover_color ) { ?>
        color: <?php echo pp_get_color_value($settings->arrow_hover_color); ?>;
    <?php } ?>
    <?php if ( $settings->arrow_bg_hover_color ) { ?>
        background-color: <?php echo pp_get_color_value($settings->arrow_bg_hover_color); ?>;
    <?php } ?>
}

@media (max-width: 991px) and (min-width: 768px) {
	.pp-3d-slider {
        <?php if ( 'yes' == $settings->autoplay ) { ?>
	        height: 300px;
        <?php } else { ?>
            height: 440px;
        <?php } ?>
	}
}
@media only screen and (max-width: 767px) and (min-width: 480px) {
	.pp-3d-slider {
        <?php if ( 'yes' == $settings->autoplay ) { ?>
	        height: 345px;
        <?php } else { ?>
            height: 420px;
        <?php } ?>
	}
}
@media (max-width: 479px) {
	.pp-3d-slider {
        <?php if ( 'yes' == $settings->autoplay ) { ?>
	        height: 345px;
        <?php } else { ?>
            height: 385px;
        <?php } ?>
	}
}
@media (max-width: 400px) {
	.pp-3d-slider {
        height: 335px;
	}
}
@media (max-width: 370px) {
	.pp-3d-slider {
        height: 310px;
	}
}
