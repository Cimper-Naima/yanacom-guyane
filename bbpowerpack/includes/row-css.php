<?php

function pp_row_render_css( $extensions ) {

    // if ( array_key_exists( 'gradient', $extensions['row'] ) || in_array( 'gradient', $extensions['row'] ) ) {
    //     add_filter( 'fl_builder_render_css', 'pp_row_gradient_css', 10, 3 );
    // }
    if ( array_key_exists( 'overlay', $extensions['row'] ) || in_array( 'overlay', $extensions['row'] ) ) {
        add_filter( 'fl_builder_render_css', 'pp_row_overlay_css', 10, 3 );
    }
    if ( array_key_exists( 'separators', $extensions['row'] ) || in_array( 'separators', $extensions['row'] ) ) {
        add_filter( 'fl_builder_render_css', 'pp_row_separators_css', 10, 3 );
    }
    if ( array_key_exists( 'expandable', $extensions['row'] ) || in_array( 'expandable', $extensions['row'] ) ) {
        add_filter( 'fl_builder_render_css', 'pp_row_expandable_css', 10, 3 );
    }
    if ( array_key_exists( 'downarrow', $extensions['row'] ) || in_array( 'downarrow', $extensions['row'] ) ) {
        add_filter( 'fl_builder_render_css', 'pp_row_downarrow_css', 10, 3 );
    }
    if ( array_key_exists( 'background_effect', $extensions['row'] ) || in_array( 'background_effect', $extensions['row'] ) ) {
        add_filter( 'fl_builder_render_css', 'pp_row_infinite_bg_css', 10, 3 );
		add_filter( 'fl_builder_render_css', 'pp_row_animated_bg_css', 10, 3 );
	}

}

function pp_row_gradient_css( $css, $nodes, $global_settings ) {
    foreach ( $nodes['rows'] as $row ) {
        ob_start();

        if ( isset( $row->settings->bg_type ) && 'pp_gradient' == $row->settings->bg_type ) {
        ?>

            <?php if ( $row->settings->gradient_type == 'linear' && isset( $row->settings->gradient_color ) ) { ?>
                <?php if ( $row->settings->linear_direction == 'bottom' ) { ?>
                    .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                        background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(top, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(bottom, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(bottom, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(bottom, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(to bottom, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $row->settings->linear_direction == 'right' ) { ?>
                    .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                        background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(left, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(right, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(right, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(right, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(to right, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $row->settings->linear_direction == 'top_right_diagonal' ) { ?>
                    .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                        background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(45deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(45deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(45deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(45deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(45deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $row->settings->linear_direction == 'top_left_diagonal' ) { ?>
                    .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                        background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(135deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(315deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(315deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(315deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(315deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $row->settings->linear_direction == 'bottom_right_diagonal' ) { ?>
                    .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                        background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(315deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(135deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(135deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(135deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(135deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $row->settings->linear_direction == 'bottom_left_diagonal' ) { ?>
                    .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                        background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(255deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(210deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(210deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(210deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(210deg, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
            <?php } ?>
            <?php if ( $row->settings->gradient_type == 'radial' && isset( $row->settings->gradient_color ) ) { ?>
                .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap {
                    background-color: #<?php echo $row->settings->gradient_color['primary']; ?>;
                    background-image: -webkit-radial-gradient(circle, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    background-image: -moz-radial-gradient(circle, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    background-image: -o-radial-gradient(circle, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    background-image: -ms-radial-gradient(circle, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                    background-image: radial-gradient(circle, <?php echo '#'.$row->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$row->settings->gradient_color['secondary']; ?> 100%);
                }
            <?php } ?>

        <?php
        }

        $css .= ob_get_clean();
    }

    return $css;
}

function pp_row_overlay_css( $css, $nodes, $global_settings ) {
    foreach ( $nodes['rows'] as $row ) {
        ob_start();
        ?>

        <?php if ( $row->settings->pp_bg_overlay_type == 'vertical_left' ) { ?>
            .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap:after {
                background-color: transparent !important;
                background: -webkit-linear-gradient( -170deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
                background: -moz-linear-gradient( -170deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
                background: -ms-linear-gradient( -170deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
                background: linear-gradient( -100deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
            }
        <?php } ?>
        <?php if ( $row->settings->pp_bg_overlay_type == 'vertical_right' ) { ?>
            .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap:after {
                background-color: transparent !important;
                background: -webkit-linear-gradient( -10deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
                background: -moz-linear-gradient( -10deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
                background: -ms-linear-gradient( -10deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
                background: linear-gradient( 100deg, rgba(225, 255, 255, 0) 0%, rgba(225, 255, 255, 0) 54.96%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%, <?php echo pp_get_color_value( $row->settings->bg_overlay_color ); ?> 55%);
            }
        <?php } ?>
        <?php if ( $row->settings->pp_bg_overlay_type == 'half_width' ) { ?>
            .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap:after {
                width: 50%;
            }
        <?php } ?>
        <?php if ( $row->settings->pp_bg_overlay_type == 'half_right' ) { ?>
            .fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap:after {
                width: 50%;
				left: auto;
            }
        <?php } ?>

        <?php
        $css .= ob_get_clean();
    }

    return $css;
}

function pp_row_separators_css( $css, $nodes, $global_settings ) {
    foreach ( $nodes['rows'] as $row ) {
        ob_start();
        ?>

        .fl-builder-row-settings #fl-field-separator_position {
            display: none !important;
        }
        <?php if ( 'none' != $row->settings->separator_type || 'none' != $row->settings->separator_type_bottom ) { ?>

            <?php $scaleY = '-webkit-transform: scaleY(-1); -moz-transform: scaleY(-1); -ms-transform: scaleY(-1); -o-transform: scaleY(-1); transform: scaleY(-1);'; ?>
            <?php $scaleX = '-webkit-transform: scaleX(-1); -moz-transform: scaleX(-1); -ms-transform: scaleX(-1); -o-transform: scaleX(-1); transform: scaleX(-1);'; ?>

            .fl-node-<?php echo $row->node; ?> .pp-row-separator {
                position: absolute;
                left: 0;
                width: 100%;
                z-index: 1;
            }
            .pp-previewing .fl-node-<?php echo $row->node; ?> .pp-row-separator {
                z-index: 2001;
            }
            .fl-node-<?php echo $row->node; ?> .pp-row-separator svg {
                position: absolute;
                left: 0;
                width: 100%;
            }
			.fl-node-<?php echo $row->node; ?> .pp-row-separator-top {
				margin-top: -1px;
			}
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top,
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg {
                top: 0;
                bottom: auto;
            }
			.fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom {
                margin-bottom: -1px;
			}
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom,
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg {
                top: auto;
                bottom: 0;
            }
            <?php if ( 'triangle' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-big-triangle {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'triangle_shadow' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-big-triangle-shadow {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'triangle_left' == $row->settings->separator_type ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg.pp-big-triangle-left {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'triangle_right' == $row->settings->separator_type ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg.pp-big-triangle-right {
                -webkit-transform: scale(-1);
                -moz-transform: scale(-1);
                -ms-transform: scale(-1);
                -o-transform: scale(-1);
                transform: scale(-1);
            }
            <?php } ?>
            <?php if ( 'triangle_small' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-small-triangle {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'tilt_right' == $row->settings->separator_type || 'tilt_right' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg.pp-tilt-right,
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-tilt-right {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'curve' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-curve {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'wave' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-wave {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'cloud' == $row->settings->separator_type ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg.pp-cloud {
                <?php echo $scaleY; ?>
            }
            <?php } ?>
            <?php if ( 'slit' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-slit {
                <?php echo $scaleY; ?>
            }
            <?php } ?>

            <?php if ( 'water' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-water-separator {
                <?php echo $scaleY; ?>
            }
            <?php } ?>

            <?php if ( 'triangle_right' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-big-triangle-right {
                <?php echo $scaleX; ?>
            }
            <?php } ?>
            <?php if ( 'tilt_right' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg.pp-tilt-right {
                <?php echo $scaleX; ?>
            }
            <?php } ?>

            <?php if ( 'tilt_left' == $row->settings->separator_type ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg.pp-tilt-left {
                -webkit-transform: scale(-1);
                -moz-transform: scale(-1);
                -ms-transform: scale(-1);
                -o-transform: scale(-1);
                transform: scale(-1);
            }
            <?php } ?>
            <?php if ( 'zigzag' == $row->settings->separator_type || 'zigzag' == $row->settings->separator_type_bottom ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-row-separator .pp-zigzag:before,
            .fl-node-<?php echo $row->node; ?> .pp-row-separator .pp-zigzag:after {
                content: '';
                pointer-events: none;
                position: absolute;
                right: 0;
                left: 0;
                z-index: 1;
                display: block;
            }
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top .pp-zigzag:before,
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top .pp-zigzag:after {
                height: <?php echo $row->settings->separator_height; ?>px;
                background-size: <?php echo $row->settings->separator_height; ?>px 100%;
            }
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom .pp-zigzag:before,
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom .pp-zigzag:after {
                height: <?php echo $row->settings->separator_height_bottom; ?>px;
                background-size: <?php echo $row->settings->separator_height_bottom; ?>px 100%;
            }
            .fl-node-<?php echo $row->node; ?> .pp-row-separator .pp-zigzag:after {
                top: 100%;
                background-position: 50%;
            }
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-top .pp-zigzag:after {
                background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, #<?php echo $row->settings->separator_color; ?>), color-stop(0.25, #<?php echo $row->settings->separator_color; ?>));
                background-image: linear-gradient(135deg, #<?php echo $row->settings->separator_color; ?> 25%, transparent 25%), linear-gradient(225deg, #<?php echo $row->settings->separator_color; ?> 25%, transparent 25%);
            }
            .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom .pp-zigzag:after {
                background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, #<?php echo $row->settings->separator_color_bottom; ?>), color-stop(0.25, #<?php echo $row->settings->separator_color_bottom; ?>));
                background-image: linear-gradient(135deg, #<?php echo $row->settings->separator_color_bottom; ?> 25%, transparent 25%), linear-gradient(225deg, #<?php echo $row->settings->separator_color_bottom; ?> 25%, transparent 25%);
            }
            <?php } ?>

            @media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
                .fl-node-<?php echo $row->node; ?> .pp-row-separator-top {
                    <?php if ( 'no' == $row->settings->separator_tablet ) { ?>
                        display: none;
                    <?php } ?>
                }
                .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom {
                    <?php if ( 'no' == $row->settings->separator_tablet_bottom ) { ?>
                        display: none;
                    <?php } ?>
                }
                <?php if ( 'yes' == $row->settings->separator_tablet && $row->settings->separator_height_tablet > 0 ) { ?>
                    .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg {
                        height: <?php echo $row->settings->separator_height_tablet; ?>px;
                    }
                <?php } ?>
                <?php if ( 'yes' == $row->settings->separator_tablet_bottom && $row->settings->separator_height_tablet_bottom > 0 ) { ?>
                    .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg {
                        height: <?php echo $row->settings->separator_height_tablet_bottom; ?>px;
                    }
                <?php } ?>
            }
            @media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
                .fl-node-<?php echo $row->node; ?> .pp-row-separator-top {
                    <?php if ( 'no' == $row->settings->separator_mobile ) { ?>
                        display: none;
                    <?php } ?>
                }
                .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom {
                    <?php if ( 'no' == $row->settings->separator_mobile_bottom ) { ?>
                        display: none;
                    <?php } ?>
                }
                <?php if ( 'yes' == $row->settings->separator_mobile && $row->settings->separator_height_mobile > 0 ) { ?>
                    .fl-node-<?php echo $row->node; ?> .pp-row-separator-top svg {
                        height: <?php echo $row->settings->separator_height_mobile; ?>px;
                    }
                <?php } ?>
                <?php if ( 'yes' == $row->settings->separator_mobile_bottom && $row->settings->separator_height_mobile_bottom > 0 ) { ?>
                    .fl-node-<?php echo $row->node; ?> .pp-row-separator-bottom svg {
                        height: <?php echo $row->settings->separator_height_mobile_bottom; ?>px;
                    }
                <?php } ?>
            }
        <?php } ?>

        <?php
        $css .= ob_get_clean();
    }

    return $css;
}

function pp_row_expandable_css( $css, $nodes, $global_settings ) {
    foreach ( $nodes['rows'] as $row ) {
        ob_start();
        ?>

        <?php if ( $row->settings->enable_expandable == 'yes' ) { ?>
            <?php if ( ! FLBuilderModel::is_builder_active() ) { ?>
            .fl-node-<?php echo $row->node; ?> .fl-row-content-wrap {
                <?php if ( 'collapsed' == $row->settings->er_default_state ) { ?>
                display: none;
                <?php } ?>
            }
            <?php } ?>
            .fl-node-<?php echo $row->node; ?> .pp-er {
                width: 100%;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-wrap {
                width: 100%;
                <?php echo $row->settings->er_bg_color ? 'background-color: ' . pp_hex2rgba('#'.$row->settings->er_bg_color, $row->settings->er_bg_opacity) : ''; ?>;
                padding-top: <?php echo $row->settings->er_title_padding['top']; ?>px;
                padding-bottom: <?php echo $row->settings->er_title_padding['bottom']; ?>px;
                cursor: pointer;
                -webkit-user-select: none;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-title-wrap {
                text-align: center;
                display: <?php echo $row->settings->er_arrow_pos != 'bottom' ? 'table' : 'block'; ?>;
                width: auto;
                margin: 0 auto;
            }
            <?php if ( $row->settings->er_arrow_pos != 'bottom' ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-title-wrap:before {
                content: "";
                display: inline-block;
                vertical-align: middle;
                height: 100%;
            }
            <?php } ?>
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-title {
                display: <?php echo $row->settings->er_arrow_pos == 'bottom' ? 'block' : 'inline-block'; ?>;
                color: <?php echo isset($row->settings->er_title_color['primary']) ? '#' . $row->settings->er_title_color['primary'] : 'inherit'; ?>;
                <?php if( $row->settings->er_title_font['family'] != 'Default' ) {
                    FLBuilderFonts::font_css( $row->settings->er_title_font );
                } ?>
                <?php echo is_numeric($row->settings->er_title_font_size) ? 'font-size: ' . $row->settings->er_title_font_size . 'px;' : ''; ?>
                margin-bottom: <?php echo $row->settings->er_arrow_pos == 'bottom' ? $row->settings->er_title_margin['bottom'] : 0; ?>px;
                margin-right: <?php echo $row->settings->er_arrow_pos != 'bottom' ? $row->settings->er_title_margin['right'] : 0; ?>px;
                text-transform: <?php echo $row->settings->er_title_case; ?>;
                vertical-align: middle;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-arrow {
                color: <?php echo isset($row->settings->er_arrow_color['primary']) ? '#' . $row->settings->er_arrow_color['primary'] : (isset($row->settings->er_title_color['primary']) ? '#' . $row->settings->er_title_color['primary'] : 'inherit'); ?>;
                display: <?php echo $row->settings->er_arrow_pos == 'bottom' ? 'block' : 'table-cell'; ?>;
                <?php echo is_numeric($row->settings->er_arrow_size) ? 'font-size: ' . $row->settings->er_arrow_size . 'px;' : ''; ?>
                vertical-align: middle;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-arrow:before {
                <?php echo isset($row->settings->er_arrow_bg['primary']) ? 'background-color: #' . $row->settings->er_arrow_bg['primary'] : ''; ?>;
                border: <?php echo $row->settings->er_arrow_border; ?>px solid <?php echo isset($row->settings->er_arrow_border_color['primary']) ? '#' . $row->settings->er_arrow_border_color['primary'] : 'transparent'; ?>;
                border-radius: <?php echo $row->settings->er_arrow_radius; ?>px;
                padding-top: <?php echo $row->settings->er_arrow_padding_all['top']; ?>px;
                padding-bottom: <?php echo $row->settings->er_arrow_padding_all['bottom']; ?>px;
                padding-left: <?php echo $row->settings->er_arrow_padding_all['left']; ?>px;
                padding-right: <?php echo $row->settings->er_arrow_padding_all['right']; ?>px;
                display: inline-block;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er-open .pp-er-arrow:before {
                <?php if ( $row->settings->er_arrow_weight == 'bold' ) { ?>
                content: "\f077";
                <?php } else { ?>
                content: "\f106";
                <?php } ?>
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-wrap:hover .pp-er-title {
                color: <?php echo isset($row->settings->er_title_color['secondary']) ? '#' . $row->settings->er_title_color['secondary'] : ''; ?>;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-wrap:hover .pp-er-arrow {
                color: <?php echo isset($row->settings->er_arrow_color['secondary']) ? '#' . $row->settings->er_arrow_color['secondary'] : (isset($row->settings->er_title_color['secondary']) ? '#' . $row->settings->er_title_color['secondary'] : 'inherit'); ?>;
            }
            .fl-node-<?php echo $row->node; ?> .pp-er .pp-er-wrap:hover .pp-er-arrow:before {
                <?php echo isset($row->settings->er_arrow_bg['secondary']) ? 'background-color: #' . $row->settings->er_arrow_bg['secondary'] : ''; ?>;
                border-color: <?php echo isset($row->settings->er_arrow_border_color['secondary']) ? '#' . $row->settings->er_arrow_border_color['secondary'] : 'transparent'; ?>;
            }
        <?php } ?>

        <?php
        $css .= ob_get_clean();
    }

    return $css;
}

function pp_row_downarrow_css( $css, $nodes, $global_settings ) {
    foreach ( $nodes['rows'] as $row ) {
        ob_start();
        ?>

        <?php if ( $row->settings->enable_down_arrow == 'yes' ) { ?>
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-container {
                margin-top: <?php echo $row->settings->da_arrow_margin['top']; ?>px;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap {
                text-align: center;
                position: absolute;
                width: 100%;
                left: 0;
                bottom: <?php echo $row->settings->da_arrow_margin['bottom']; ?>px;
                z-index: 1;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap .pp-down-arrow {
                display: inline-block;
                background-color: <?php echo '' != $row->settings->da_arrow_bg['primary'] ? '#'.$row->settings->da_arrow_bg['primary'] : 'transparent'; ?>;
                border: <?php echo $row->settings->da_arrow_border; ?>px solid <?php echo '#'.$row->settings->da_arrow_border_color['primary']; ?>;
                border-radius: <?php echo $row->settings->da_arrow_radius; ?>px;
                line-height: 0;
                cursor: pointer;
                padding: <?php echo $row->settings->da_arrow_padding; ?>px;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap .pp-down-arrow:hover {
                background-color: <?php echo '' != $row->settings->da_arrow_bg['secondary'] ? '#'.$row->settings->da_arrow_bg['secondary'] : 'transparent'; ?>;
                border-color: <?php echo '#'.$row->settings->da_arrow_border_color['secondary']; ?>;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap .pp-down-arrow.pp-da-bounce {
                -moz-animation: bounce 2s infinite;
                -webkit-animation: bounce 2s infinite;
                animation: bounce 2s infinite;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap .pp-down-arrow svg {
                width: 45px;
	            height: 45px;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap .pp-down-arrow svg path {
                stroke: <?php echo '#'.$row->settings->da_arrow_color['primary']; ?>;
	            fill: <?php echo '#'.$row->settings->da_arrow_color['primary']; ?>;
	            stroke-width: <?php echo 'bold' == $row->settings->da_arrow_weight ? 2 : 0; ?>px;
            }
            .fl-node-<?php echo $row->node; ?> .pp-down-arrow-wrap .pp-down-arrow:hover svg path {
                stroke: <?php echo '#'.$row->settings->da_arrow_color['secondary']; ?>;
	            fill: <?php echo '#'.$row->settings->da_arrow_color['secondary']; ?>;
            }

            @media only screen and (max-width: 767px) {
                .fl-node-<?php echo $row->node; ?> .pp-down-arrow-container {
                    <?php if ( $row->settings->da_hide_mobile == 'yes' ) : ?>
                        display: none;
                    <?php endif; ?>
                }
            }

            @-moz-keyframes pp-da-bounce {
              0%, 20%, 50%, 80%, 100% {
                -moz-transform: translateY(0);
                transform: translateY(0);
              }
              40% {
                -moz-transform: translateY(-30px);
                transform: translateY(-30px);
              }
              60% {
                -moz-transform: translateY(-15px);
                transform: translateY(-15px);
              }
            }
            @-webkit-keyframes pp-da-bounce {
              0%, 20%, 50%, 80%, 100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
              }
              40% {
                -webkit-transform: translateY(-30px);
                transform: translateY(-30px);
              }
              60% {
                -webkit-transform: translateY(-15px);
                transform: translateY(-15px);
              }
            }
            @keyframes pp-da-bounce {
              0%, 20%, 50%, 80%, 100% {
                -moz-transform: translateY(0);
                -ms-transform: translateY(0);
                -webkit-transform: translateY(0);
                transform: translateY(0);
              }
              40% {
                -moz-transform: translateY(-30px);
                -ms-transform: translateY(-30px);
                -webkit-transform: translateY(-30px);
                transform: translateY(-30px);
              }
              60% {
                -moz-transform: translateY(-15px);
                -ms-transform: translateY(-15px);
                -webkit-transform: translateY(-15px);
                transform: translateY(-15px);
              }
            }
        <?php } ?>

        <?php
        $css .= ob_get_clean();
    }

    return $css;
}

function pp_row_infinite_bg_css( $css, $nodes, $global_settings ) {

	foreach ( $nodes['rows'] as $row ) {
		ob_start();
		?>

		<?php if ( isset( $row->settings->bg_type ) && 'pp_infinite_bg' == $row->settings->bg_type ) { ?>
			<?php if ( isset( $row->settings->pp_bg_image ) ){ ?>
				.fl-node-<?php echo $row->node; ?>.fl-row-bg-pp_infinite_bg .fl-row-content-wrap .fl-builder-shape-layer {
					z-index: 1;
				}
				.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap {
					background-color: transparent;
					background-image: url(<?php echo $row->settings->pp_bg_image_src;?>);
					background-repeat: repeat;
					background-position: 0 0;
				}
				<?php if ( isset($row->settings->scrolling_direction ) && 'horizontal' == $row->settings->scrolling_direction ) { ?>
					.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap {
						animation: pp-animation-horizontally-<?php echo $row->settings->scrolling_direction_h; ?>-<?php echo $row->node; ?> <?php echo $row->settings->scrolling_speed; ?>s linear infinite;
						background-size: cover;
					}
				<?php } elseif ( isset($row->settings->scrolling_direction ) && 'vertical' == $row->settings->scrolling_direction ) { ?>
					.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap {
						animation: pp-animation-vertically-<?php echo $row->settings->scrolling_direction_v; ?>-<?php echo $row->node; ?> <?php echo $row->settings->scrolling_speed; ?>s linear infinite;
						background-size: contain;
					}
				<?php } ?>
				<?php if( isset($row->settings->pp_infinite_overlay) ) { ?>
					.fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap:after {
						background-color: <?php echo isset($row->settings->pp_infinite_overlay) ? pp_get_color_value($row->settings->pp_infinite_overlay) : 'transparent'; ?>;
						border-radius: inherit;
						content: '';
						display: block;
						position: absolute;
						top: 0;
						right: 0;
						bottom: 0;
						left: 0;
						z-index: 0;
					}
					.fl-node-<?php echo $row->node; ?> > .fl-row-content-wrap .fl-row-content {
						position: relative;
						z-index: 2;
					}
				<?php } ?>
			<?php } ?>
        <?php } ?>

        <?php
        $css .= ob_get_clean();
    }

    return $css;
}

function pp_row_animated_bg_css( $css, $nodes, $global_settings ) {

	foreach ( $nodes['rows'] as $row ) {
		ob_start();
		?>

		<?php if ( isset( $row->settings->bg_type ) && 'pp_animated_bg' == $row->settings->bg_type ) { ?>
			<?php if ( isset( $row->settings->pp_bg_image ) ){ ?>
				.fl-node-<?php echo $row->node; ?>.fl-row-bg-pp_animated_bg .fl-row-content-wrap .fl-builder-shape-layer {
					z-index: 1;
				}
			<?php }
			$anim_type = $row->settings->animation_type;

			if ( 'particles' == $anim_type || 'nasa' == $anim_type || 'bubble' == $anim_type || 'snow' == $anim_type || 'custom' == $anim_type ) { ?>
				.fl-node-<?php echo $row->node; ?> #pp-particles-wrap-<?php echo $row->node; ?> {
					position: absolute;
					top: 0;
					bottom: 0;
					left: 0;
					right: 0;
				}
				.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap {
					background-color: <?php echo isset($row->settings->part_bg_color) ? pp_get_color_value($row->settings->part_bg_color) : '#07192f'; ?>
				}
				<?php if ( 'yes' == $row->settings->part_bg_type ) { ?>
					.fl-node-<?php echo $row->node; ?> #pp-particles-wrap-<?php echo $row->node; ?> {
						background-image: url(<?php echo isset($row->settings->part_bg_image) ? $row->settings->part_bg_image_src : ''; ?>);
						background-size: <?php echo isset($row->settings->part_bg_size) ? $row->settings->part_bg_size . '%' : '50%'; ?>;
						background-repeat: no-repeat;
						background-position: <?php echo isset($row->settings->part_bg_position) ? $row->settings->part_bg_position : '50% 50%'; ?>;
					}
				<?php } ?>
				.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap #pp-particles-wrap-<?php echo $row->node; ?> {
					z-index: 0;
				}
				.fl-node-<?php echo $row->node; ?> .fl-row-content-wrap .fl-row-content {
					z-index: 1;
				}

			<?php }else{ ?>
				#fl-builder-settings-section-pp_animated_bg #fl-field-part_hover_size,
				#fl-builder-settings-section-pp_animated_bg #fl-field-part_bg_image,
				#fl-builder-settings-section-pp_animated_bg #fl-field-part_bg_size,
				#fl-builder-settings-section-pp_animated_bg #fl-field-part_hover_size,
				#fl-builder-settings-section-pp_animated_bg #fl-field-part_bg_position {
					display: none !important;
				}
			<?php } ?>

        <?php } ?>

        <?php
        $css .= ob_get_clean();
    }

    return $css;
}