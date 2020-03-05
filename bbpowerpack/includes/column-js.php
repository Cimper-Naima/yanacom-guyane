<?php

function pp_column_render_js( $extensions ) {

    if ( array_key_exists( 'separators', $extensions['col'] ) || in_array( 'separators', $extensions['col'] ) ) {
        add_filter( 'fl_builder_render_js', 'pp_column_separators_js', 10, 3 );
    }
}

function pp_column_separators_js( $js, $nodes, $global_settings ) {
    ob_start();
    foreach ( $nodes['columns'] as $column ) {
        if ( isset( $column->settings->enable_separator ) && 'yes' == $column->settings->enable_separator ) {
            ?>
            ;(function($) {
                var colH_<?php echo $column->node; ?> = $('.fl-node-<?php echo $column->node; ?>').outerHeight();
                $('.fl-node-<?php echo $column->node; ?> .pp-col-separator-left svg, .fl-node-<?php echo $column->node; ?> .pp-col-separator-right svg').css('width', colH_<?php echo $column->node; ?> + 'px');
                $(window).on('load resize', function() {
                    var colH_<?php echo $column->node; ?> = $('.fl-node-<?php echo $column->node; ?>').outerHeight();
                    $('.fl-node-<?php echo $column->node; ?> .pp-col-separator-left svg, .fl-node-<?php echo $column->node; ?> .pp-col-separator-right svg').css('width', colH_<?php echo $column->node; ?> + 'px');
                });
            })(jQuery);
            <?php
        }
    }
    $js .= ob_get_clean();

    return $js;
}
