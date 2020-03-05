<?php

function pp_column_render_css( $extensions ) {

    // if ( array_key_exists( 'gradient', $extensions['col'] ) || in_array( 'gradient', $extensions['col'] ) ) {
    //     add_filter( 'fl_builder_render_css', 'pp_column_gradient_css', 10, 3 );
    // }
    // if ( array_key_exists( 'corners', $extensions['col'] ) || in_array( 'corners', $extensions['col'] ) ) {
    //     add_filter( 'fl_builder_render_css', 'pp_column_round_corners_css', 10, 3 );
    // }
    if ( array_key_exists( 'separators', $extensions['col'] ) || in_array( 'separators', $extensions['col'] ) ) {
        add_filter( 'fl_builder_render_css', 'pp_column_separators_css', 10, 3 );
    }
    // if ( array_key_exists( 'shadow', $extensions['col'] ) || in_array( 'shadow', $extensions['col'] ) ) {
    //     add_filter( 'fl_builder_render_css', 'pp_column_shadow_css', 10, 3 );
    // }
}

function pp_column_gradient_css( $css, $nodes, $global_settings ) {

    foreach ( $nodes['columns'] as $column ) {

        ob_start();

        if ( isset( $column->settings->bg_type ) && 'pp_gradient' == $column->settings->bg_type ) {
            ?>
            <?php if ( $column->settings->gradient_type == 'linear' ) { ?>
                <?php if ( $column->settings->linear_direction == 'bottom' ) { ?>
                    .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                        background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(top, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(bottom, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(bottom, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(bottom, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(to bottom, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $column->settings->linear_direction == 'right' ) { ?>
                    .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                        background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(left, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(right, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(right, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(right, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(to right, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $column->settings->linear_direction == 'top_right_diagonal' ) { ?>
                    .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                        background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(45deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(45deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(45deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(45deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(45deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $column->settings->linear_direction == 'top_left_diagonal' ) { ?>
                    .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                        background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(135deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(315deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(315deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(315deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(315deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $column->settings->linear_direction == 'bottom_right_diagonal' ) { ?>
                    .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                        background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(315deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(135deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(135deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(135deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(135deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
                <?php if ( $column->settings->linear_direction == 'bottom_left_diagonal' ) { ?>
                    .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                        background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                        background-image: -webkit-linear-gradient(255deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -moz-linear-gradient(210deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -o-linear-gradient(210deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: -ms-linear-gradient(210deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                        background-image: linear-gradient(210deg, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    }
                <?php } ?>
            <?php } ?>
            <?php if ( $column->settings->gradient_type == 'radial' ) { ?>
                .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                    background-color: #<?php echo $column->settings->gradient_color['primary']; ?>;
                    background-image: -webkit-radial-gradient(circle, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    background-image: -moz-radial-gradient(circle, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    background-image: -o-radial-gradient(circle, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    background-image: -ms-radial-gradient(circle, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                    background-image: radial-gradient(circle, <?php echo '#'.$column->settings->gradient_color['primary']; ?> 0%, <?php echo '#'.$column->settings->gradient_color['secondary']; ?> 100%);
                }
            <?php } ?>
        <?php } ?>
    <?php
        $css .= ob_get_clean();
    }

    return $css;
}


function pp_column_separators_css( $css, $nodes, $global_settings ) {

    foreach ( $nodes['columns'] as $column ) {

        ob_start();

        if ( isset( $column->settings->enable_separator ) && $column->settings->enable_separator == 'yes' ) { ?>

            .fl-node-<?php echo $column->node; ?> {
                position: relative;
                <?php if ( $column->settings->separator_type != 'tilt' && $column->settings->separator_type != 'triangle_small_out' ) { ?>
                overflow: hidden;
                <?php } ?>
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator {
                position: absolute;
                <?php echo $column->settings->separator_position; ?>: 0;
                left: 0;
                width: 100%;
                z-index: 1;
            }
            .pp-previewing .fl-node-<?php echo $column->node; ?> .pp-col-separator {
                z-index: 2;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator svg {
                position: absolute;
                left: 0;
                width: 100%;
                opacity: <?php echo $column->settings->separator_opacity / 100; ?>;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-left,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-right,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-left svg,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-right svg {
                top: 0;
                bottom: auto;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg {
                top: auto;
                bottom: 0;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator.pp-col-separator-left {
                left: 0;
                right: auto;
                z-index: 0;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator.pp-col-separator-right {
                left: auto;
                right: 0;
                z-index: 0;
            }

            .fl-node-<?php echo $column->node; ?> .pp-col-separator-left svg {
                left: 0;
                right: auto;
                <?php $scal_y_left = ($column->settings->separator_type == 'triangle_small_out') ? '1' : '-1'; ?>
                -webkit-transform: rotate(90deg) scaleY(<?php echo $scal_y_left; ?>) translateX(-<?php echo $column->settings->separator_height / 2; ?>px);
                -moz-transform: rotate(90deg) scaleY(<?php echo $scal_y_left; ?>) translateX(-<?php echo $column->settings->separator_height / 2; ?>px);
                -ms-transform: rotate(90deg) scaleY(<?php echo $scal_y_left; ?>) translateX(-<?php echo $column->settings->separator_height / 2; ?>px);
                transform: rotate(90deg) scaleY(<?php echo $scal_y_left; ?>) translateX(-<?php echo $column->settings->separator_height / 2; ?>px);
                transform-origin: left;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-right svg {
                left: auto;
                right: 0;
                <?php $scal_y_right = ($column->settings->separator_type == 'triangle_small_out') ? '-1' : '1'; ?>
                -webkit-transform: rotate(90deg) scale(-1, <?php echo $scal_y_right; ?>) translateX(<?php echo $column->settings->separator_height / 2; ?>px);
                -moz-transform: rotate(90deg) scale(-1, <?php echo $scal_y_right; ?>) translateX(<?php echo $column->settings->separator_height / 2; ?>px);
                -ms-transform: rotate(90deg) scale(-1, <?php echo $scal_y_right; ?>) translateX(<?php echo $column->settings->separator_height / 2; ?>px);
                transform: rotate(90deg) scale(-1, <?php echo $scal_y_right; ?>) translateX(<?php echo $column->settings->separator_height / 2; ?>px);
                transform-origin: right;
            }
            <?php if ( $column->settings->separator_type == 'tilt' ) { ?>
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-right svg.pp-tilt-right {
                <?php $t = $column->settings->separator_height / 2; ?>
                -webkit-transform: rotate(90deg) scale(-1, 1) translate3d(<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
                -moz-transform: rotate(90deg) scale(-1, 1) translate3d(<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
                -ms-transform: rotate(90deg) scale(-1, 1) translate3d(<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
                transform: rotate(90deg) scale(-1, 1) translate3d(<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-left svg.pp-tilt-left {
                <?php $t = $column->settings->separator_height / 2; ?>
                -webkit-transform: rotate(90deg) scaleY(-1) translate3d(-<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
                -moz-transform: rotate(90deg) scaleY(-1) translate3d(-<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
                -ms-transform: rotate(90deg) scaleY(-1) translate3d(-<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
                transform: rotate(90deg) scaleY(-1) translate3d(-<?php echo $t; ?>px, -<?php echo $t; ?>px, 0);
            }
            <?php } ?>

            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-big-triangle,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg.pp-big-triangle-left,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg.pp-big-triangle-right,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-small-triangle,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg.pp-tilt-right,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-tilt-right,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-curve,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-wave,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg.pp-cloud,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-slit,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-slit {
                -webkit-transform: scaleY(-1);
                -moz-transform: scaleY(-1);
                -ms-transform: scaleY(-1);
                -o-transform: scaleY(-1);
                transform: scaleY(-1);
            }
            <?php if ( $column->settings->separator_type == 'triangle_small_out' ) { ?>
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg.pp-small-triangle {
                top: -<?php echo $column->settings->separator_height; ?>px;
                -webkit-transform: scaleY(-1);
                -moz-transform: scaleY(-1);
                -ms-transform: scaleY(-1);
                -o-transform: scaleY(-1);
                transform: scaleY(-1);
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-small-triangle {
                bottom: -<?php echo $column->settings->separator_height; ?>px;
                -webkit-transform: scaleY(1);
                -moz-transform: scaleY(1);
                -ms-transform: scaleY(1);
                -o-transform: scaleY(1);
                transform: scaleY(1);
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-left svg.pp-small-triangle {
                left: -<?php echo $column->settings->separator_height / 2; ?>px;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-right svg.pp-small-triangle {
                right: -<?php echo $column->settings->separator_height / 2; ?>px;
            }
            <?php } ?>
            <?php if ( $column->settings->separator_type == 'wave_out' ) { ?>
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-wave {
                -webkit-transform: scaleY(1) translateY(<?php echo $column->settings->separator_height; ?>px);
                -moz-transform: scaleY(1) translateY(<?php echo $column->settings->separator_height; ?>px);
                -ms-transform: scaleY(1) translateY(<?php echo $column->settings->separator_height; ?>px);
                -o-transform: scaleY(1) translateY(<?php echo $column->settings->separator_height; ?>px);
                transform: scaleY(1) translateY(<?php echo $column->settings->separator_height; ?>px);
            }
            <?php } ?>
            .fl-node-<?php echo $column->node; ?> .pp-col-separator svg.pp-big-triangle-right,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-bottom svg.pp-tilt-right {
                -webkit-transform: scaleX(-1);
                -moz-transform: scaleX(-1);
                -ms-transform: scaleX(-1);
                -o-transform: scaleX(-1);
                transform: scaleX(-1);
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator-top svg.pp-tilt-left {
                -webkit-transform: scale(-1);
                -moz-transform: scale(-1);
                -ms-transform: scale(-1);
                -o-transform: scale(-1);
                transform: scale(-1);
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator .pp-zigzag:before,
            .fl-node-<?php echo $column->node; ?> .pp-col-separator .pp-zigzag:after {
                content: '';
                pointer-events: none;
                position: absolute;
                right: 0;
                left: 0;
                z-index: 1;
                display: block;
                height: <?php echo $column->settings->separator_height; ?>px;
                background-size: <?php echo $column->settings->separator_height; ?>px 100%;
            }
            .fl-node-<?php echo $column->node; ?> .pp-col-separator .pp-zigzag:after {
                top: 100%;
                background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, #<?php echo $column->settings->separator_color; ?>), color-stop(0.25, #<?php echo $column->settings->separator_color; ?>));
                background-image: linear-gradient(135deg, #<?php echo $column->settings->separator_color; ?> 25%, transparent 25%), linear-gradient(225deg, #<?php echo $column->settings->separator_color; ?> 25%, transparent 25%);
                background-position: 50%;
            }
            @media only screen and (max-width: 768px) {
                .fl-node-<?php echo $column->node; ?> .pp-col-separator {
                    <?php if ( 'no' == $column->settings->separator_tablet ) { ?>
                        display: none;
                    <?php } ?>
                }
                <?php if ( 'yes' == $column->settings->separator_tablet && $column->settings->separator_height_tablet > 0 ) { ?>
                    .fl-node-<?php echo $column->node; ?> .pp-col-separator svg {
                        height: <?php echo $column->settings->separator_height_tablet; ?>px;
                    }
                <?php } ?>
            }
            @media only screen and (max-width: 480px) {
                .fl-node-<?php echo $column->node; ?> .pp-col-separator {
                    <?php if ( 'no' == $column->settings->separator_mobile ) { ?>
                        display: none;
                    <?php } ?>
                }
                <?php if ( 'yes' == $column->settings->separator_mobile && $column->settings->separator_height_mobile > 0 ) { ?>
                    .fl-node-<?php echo $column->node; ?> .pp-col-separator svg {
                        height: <?php echo $column->settings->separator_height_mobile; ?>px;
                    }
                <?php } ?>
            } <?php
        }

        $css .= ob_get_clean();
    }

    return $css;
}

/** Corners */
function pp_column_round_corners_css( $css, $nodes, $global_settings ) {

    foreach ( $nodes['columns'] as $column ) {

        ob_start();
    ?>

        .fl-node-<?php echo $column->node; ?> > .fl-col-content {
            <?php if ( isset( $column->settings->pp_round_corners ) ) { ?>
                <?php if ( $column->settings->pp_round_corners['top_left'] > 0 ) { ?>
                border-top-left-radius: <?php echo $column->settings->pp_round_corners['top_left']; ?>px;
                <?php } ?>
                <?php if ( $column->settings->pp_round_corners['top_right'] > 0 ) { ?>
                border-top-right-radius: <?php echo $column->settings->pp_round_corners['top_right']; ?>px;
                <?php } ?>
                <?php if ( $column->settings->pp_round_corners['bottom_left'] > 0 ) { ?>
                border-bottom-left-radius: <?php echo $column->settings->pp_round_corners['bottom_left']; ?>px;
                <?php } ?>
                <?php if ( $column->settings->pp_round_corners['bottom_right'] > 0 ) { ?>
                border-bottom-right-radius: <?php echo $column->settings->pp_round_corners['bottom_right']; ?>px;
                <?php } ?>
            <?php } ?>
        }

        <?php $css .= ob_get_clean();
    }

    return $css;
}

/** Shadow */
function pp_column_shadow_css( $css, $nodes, $global_settings ) {

    foreach ( $nodes['columns'] as $column ) {

        ob_start();
    ?>

        <?php if ( isset( $column->settings->pp_box_shadow ) ) { ?>

            .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                -webkit-box-shadow: <?php echo $column->settings->pp_box_shadow['vertical']; ?>px <?php echo $column->settings->pp_box_shadow['horizontal']; ?>px <?php echo $column->settings->pp_box_shadow['blur']; ?>px <?php echo $column->settings->pp_box_shadow['spread']; ?>px <?php echo pp_hex2rgba('#'.$column->settings->pp_box_shadow_color, $column->settings->pp_box_shadow_opacity / 100); ?>;
                -moz-box-shadow: <?php echo $column->settings->pp_box_shadow['vertical']; ?>px <?php echo $column->settings->pp_box_shadow['horizontal']; ?>px <?php echo $column->settings->pp_box_shadow['blur']; ?>px <?php echo $column->settings->pp_box_shadow['spread']; ?>px <?php echo pp_hex2rgba('#'.$column->settings->pp_box_shadow_color, $column->settings->pp_box_shadow_opacity / 100); ?>;
                box-shadow: <?php echo $column->settings->pp_box_shadow['vertical']; ?>px <?php echo $column->settings->pp_box_shadow['horizontal']; ?>px <?php echo $column->settings->pp_box_shadow['blur']; ?>px <?php echo $column->settings->pp_box_shadow['spread']; ?>px <?php echo pp_hex2rgba('#'.$column->settings->pp_box_shadow_color, $column->settings->pp_box_shadow_opacity / 100); ?>;
                -webkit-transition: -webkit-box-shadow <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out, -webkit-transform <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out;
                -moz-transition: -moz-box-shadow <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out, -moz-transform <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out;
                transition: box-shadow <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out, transform <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out;
                will-change: box-shadow;
            }

            <?php if ( 'yes' == $column->settings->pp_box_shadow_hover_switch ) { ?>
                .fl-node-<?php echo $column->node; ?> > .fl-col-content:hover {
                    -webkit-box-shadow: <?php echo $column->settings->pp_box_shadow_hover['vertical']; ?>px <?php echo $column->settings->pp_box_shadow_hover['horizontal']; ?>px <?php echo $column->settings->pp_box_shadow_hover['blur']; ?>px <?php echo $column->settings->pp_box_shadow_hover['spread']; ?>px <?php echo pp_hex2rgba('#'.$column->settings->pp_box_shadow_color_hover, $column->settings->pp_box_shadow_opacity_hover / 100); ?>;
                    -moz-box-shadow: <?php echo $column->settings->pp_box_shadow_hover['vertical']; ?>px <?php echo $column->settings->pp_box_shadow_hover['horizontal']; ?>px <?php echo $column->settings->pp_box_shadow_hover['blur']; ?>px <?php echo $column->settings->pp_box_shadow_hover['spread']; ?>px <?php echo pp_hex2rgba('#'.$column->settings->pp_box_shadow_color_hover, $column->settings->pp_box_shadow_opacity_hover / 100); ?>;
                    box-shadow: <?php echo $column->settings->pp_box_shadow_hover['vertical']; ?>px <?php echo $column->settings->pp_box_shadow_hover['horizontal']; ?>px <?php echo $column->settings->pp_box_shadow_hover['blur']; ?>px <?php echo $column->settings->pp_box_shadow_hover['spread']; ?>px <?php echo pp_hex2rgba('#'.$column->settings->pp_box_shadow_color_hover, $column->settings->pp_box_shadow_opacity_hover / 100); ?>;
                    -webkit-transition: -webkit-box-shadow <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out, -webkit-transform <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out;
                    -moz-transition: -moz-box-shadow <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out, -moz-transform <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out;
                    transition: box-shadow <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out, transform <?php echo $column->settings->pp_box_shadow_transition; ?>ms ease-in-out;
                }
            <?php } ?>

        <?php }

        $css .= ob_get_clean();
    }

    return $css;
}
