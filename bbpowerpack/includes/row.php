<?php

function pp_row_settings_init() {

    require_once BB_POWERPACK_DIR . 'includes/row-settings.php';
    require_once BB_POWERPACK_DIR . 'includes/row-css.php';
    require_once BB_POWERPACK_DIR . 'includes/row-js.php';

    $extensions = BB_PowerPack_Admin_Settings::get_enabled_extensions();

    pp_row_register_settings( $extensions );
    pp_row_render_css( $extensions );

    if ( array_key_exists( 'separators', $extensions['row'] ) || in_array( 'separators', $extensions['row'] ) ) {
        add_action( 'fl_builder_before_render_row', 'pp_before_render_row' );
        add_action( 'fl_builder_before_render_row_bg', 'pp_output_before_row_bg' );
    }

    if ( array_key_exists( 'downarrow', $extensions['row'] ) || in_array( 'downarrow', $extensions['row'] ) ) {
        add_action( 'fl_builder_after_render_row_bg', 'pp_output_after_render_row_bg', 100 );
    }

    pp_row_render_js( $extensions );
}

function pp_row_separator_html( $type, $position, $color, $height, $shadow ) {
    ob_start();
    ?>
    <div class="pp-row-separator pp-row-separator-<?php echo $position; ?>">
        <?php switch($type): ?>
<?php case 'triangle': ?>
                <svg class="pp-big-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none">
                    <path class="fil0" d="M-0 0.333331l4.66666 0 0 -3.93701e-006 -2.33333 0 -2.33333 0 0 3.93701e-006zm0 -0.333331l4.66666 0 0 0.166661 -4.66666 0 0 -0.166661zm4.66666 0.332618l0 -0.165953 -4.66666 0 0 0.165953 1.16162 -0.0826181 1.17171 -0.0833228 1.17171 0.0833228 1.16162 0.0826181z"></path>
                </svg>
            <?php break; ?>
            <?php case 'triangle_shadow': ?>
                <svg class="pp-big-triangle-shadow" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 100 100" preserveAspectRatio="none">
				    <path class="pp-main-color" d="M0 0 L50 100 L100 0 Z" />
				    <path class="pp-shadow-color" <?php echo '' != $shadow ? 'fill="#'.$shadow.'"' : ''; ?> d="M50 100 L100 40 L100 0 Z" />
				</svg>
            <?php break; ?>
            <?php case 'triangle_left': ?>
                <svg class="pp-big-triangle-left" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 2000 90" preserveAspectRatio="none">
                    <polygon xmlns="http://www.w3.org/2000/svg" points="535.084,64.886 0,0 0,90 2000,90 2000,0 "></polygon>
                </svg>
            <?php break; ?>
            <?php case 'triangle_right': ?>
                <svg class="pp-big-triangle-right" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 2000 90" preserveAspectRatio="none">
                    <polygon xmlns="http://www.w3.org/2000/svg" points="535.084,64.886 0,0 0,90 2000,90 2000,0 "></polygon>
                </svg>
            <?php break; ?>
            <?php case 'triangle_small': ?>
                <svg class="pp-small-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 0.156661 0.1">
                    <polygon points="0.156661,3.93701e-006 0.156661,0.000429134 0.117665,0.05 0.0783307,0.0999961 0.0389961,0.05 -0,0.000429134 -0,3.93701e-006 0.0783307,3.93701e-006 "></polygon>
                </svg>
            <?php break; ?>
            <?php case 'tilt_left': ?>
                <svg class="pp-tilt-left" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4 0.266661" preserveAspectRatio="none">
					<polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "></polygon>
				</svg>
            <?php break; ?>
            <?php case 'tilt_right': ?>
                <svg class="pp-tilt-right" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4 0.266661" preserveAspectRatio="none">
					<polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "></polygon>
				</svg>
            <?php break; ?>
            <?php case 'curve': ?>
                <svg class="pp-curve" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none">
					<path class="fil1" d="M4.66666 0l0 7.87402e-006 -3.93701e-006 0c0,0.0920315 -1.04489,0.166665 -2.33333,0.166665 -1.28844,0 -2.33333,-0.0746339 -2.33333,-0.166665l-3.93701e-006 0 0 -7.87402e-006 4.66666 0z"></path>
				</svg>
            <?php break; ?>
            <?php case 'wave': ?>
                <svg class="pp-wave" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 100 100" preserveAspectRatio="none">
      				<path d="M0 0 Q 2.5 40 5 0
						 Q 7.5 40 10 0
						 Q 12.5 40 15 0
						 Q 17.5 40 20 0
						 Q 22.5 40 25 0
						 Q 27.5 40 30 0
						 Q 32.5 40 35 0
						 Q 37.5 40 40 0
						 Q 42.5 40 45 0
						 Q 47.5 40 50 0
						 Q 52.5 40 55 0
						 Q 57.5 40 60 0
						 Q 62.5 40 65 0
						 Q 67.5 40 70 0
						 Q 72.5 40 75 0
						 Q 77.5 40 80 0
						 Q 82.5 40 85 0
						 Q 87.5 40 90 0
						 Q 92.5 40 95 0
						 Q 97.5 40 100 0 Z">
    	 			</path>
    			</svg>
            <?php break; ?>
            <?php case 'cloud': ?>
                <svg class="pp-cloud" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 100 100" preserveAspectRatio="none">
    				<path d="M-5 100 Q 0 20 5 100 Z
				         M0 100 Q 5 0 10 100
				         M5 100 Q 10 30 15 100
				         M10 100 Q 15 10 20 100
				         M15 100 Q 20 30 25 100
				         M20 100 Q 25 -10 30 100
				         M25 100 Q 30 10 35 100
				         M30 100 Q 35 30 40 100
				         M35 100 Q 40 10 45 100
				         M40 100 Q 45 50 50 100
				         M45 100 Q 50 20 55 100
				         M50 100 Q 55 40 60 100
				         M55 100 Q 60 60 65 100
				         M60 100 Q 65 50 70 100
				         M65 100 Q 70 20 75 100
				         M70 100 Q 75 45 80 100
				         M75 100 Q 80 30 85 100
				         M80 100 Q 85 20 90 100
				         M85 100 Q 90 50 95 100
				         M90 100 Q 95 25 100 100
				         M95 100 Q 100 15 105 100 Z">
					 </path>
				 </svg>
            <?php break; ?>
            <?php case 'slit': ?>
                <svg class="pp-slit" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 100 100" preserveAspectRatio="none">
			        <path class="pp-slit-1" d="M50 100 C49 80 47 0 40 0 L47 0 Z"></path>
			        <path class="pp-slit-2" d="M50 100 C51 80 53 0 60 0 L53 0 Z"></path>
			        <path class="pp-slit-3" d="M47 0 L50 100 L53 0 Z"></path>
    			</svg>
            <?php break; ?>
            <?php case 'water': ?>
                <svg class="pp-water-separator" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 1920 127" xml:space="preserve" preserveAspectRatio="none">
                <path d="M0,62c0,0,91.667-14.667,175.667,30.667C236.333,124,253,113.333,290.333,91.333s53.333-10,74,4
                    s59.333,17.333,98.667-8.667c39.333-26,42,4,65.333,12S593.667,80,608.333,66C623,52,678.332,34,730.999,72s84,70.667,135.333,44
                    s31.334-50.667,100-22.667s67.998,15.333,113.332-4.667s26.667,21.333,68.667-4s61.333-34.667,144,12s111.999,12.665,137.999-4.668
                    s38,27.333,82,12s89.581-54.75,144-10c65.669,54.002,139.334-34,180.667-16.667c31.883,13.37,61.386,26.345,83.002,19.951V0H1.24
                    L0,62z"/>
                </svg>
            <?php break; ?>
            <?php case 'box': ?>
                <div class="pp-box"></div>
            <?php break; ?>
            <?php case 'pyramid': ?>
                <div class="pp-pyramid"></div>
            <?php break; ?>
            <?php case 'zigzag': ?>
                <div class="pp-zigzag"></div>
            <?php break; ?>
            <?php default: ?>
        <?php endswitch; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Fallback for row position.
 */
function pp_before_render_row( $row ) {
    if ( isset( $row->settings->enable_separator ) && 'no' == $row->settings->enable_separator && 'none' != $row->settings->separator_type ) {
        $row_settings = FLBuilderModel::get_node_settings( $row );
        $row_settings->separator_type = 'none';
    }
    if ( isset( $row->settings->enable_separator ) && 'yes' == $row->settings->enable_separator &&  'none' != $row->settings->separator_type ) {
        if ( 'bottom' == $row->settings->separator_position ) {

            // Get row settings.
            $row_settings = FLBuilderModel::get_node_settings( $row );
            $template_post_id 	= FLBuilderModel::is_node_global( $row );

            // Add top separator setting to bottom.
            $row_settings->separator_type_bottom            = $row_settings->separator_type;
            $row_settings->separator_type                   = 'none';
            $row_settings->separator_color_bottom           = $row_settings->separator_color;
            $row_settings->separator_shadow_bottom          = $row_settings->separator_shadow;
            $row_settings->separator_height_bottom          = $row_settings->separator_height;
            $row_settings->separator_tablet_bottom          = $row_settings->separator_tablet;
            $row_settings->separator_tablet                 = 'no';
            $row_settings->separator_height_tablet_bottom   = $row_settings->separator_height_tablet;
            $row_settings->separator_height_tablet          = '';
            $row_settings->separator_mobile_bottom          = $row_settings->separator_mobile;
            $row_settings->separator_mobile                 = 'no';
            $row_settings->separator_height_mobile_bottom   = $row_settings->separator_height_mobile;
            $row_settings->separator_height_mobile          = '';
            $row_settings->separator_position               = 'top';

            // Get layout data.
            $data = FLBuilderModel::get_layout_data();
            // Replace row settings with new settings.
    		$data[$row->node]->settings = $row_settings;
    		// Update the layout data.
    		FLBuilderModel::update_layout_data($data);

            // Save settings for global rows.
            if ( $template_post_id && ! FLBuilderModel::is_post_node_template() ) {

    			// Get the template data.
    			$template_data = FLBuilderModel::get_layout_data( 'published', $template_post_id );

    			// Update the template node settings.
    			$template_data[ $row->template_node_id ]->settings = $row_settings;

    			// Save the template data.
    			FLBuilderModel::update_layout_data( $template_data, 'published', $template_post_id );
    			FLBuilderModel::update_layout_data( $template_data, 'draft', $template_post_id );

    			// Delete the template asset cache.
    			FLBuilderModel::delete_all_asset_cache( $template_post_id );
    			FLBuilderModel::delete_node_template_asset_cache( $template_post_id );
    		}
        }
    }
}

/**
 * Output for Rows
 */
function pp_output_before_row_bg( $row ) {

    if ( 'yes' == $row->settings->enable_separator && 'none' != $row->settings->separator_type ) {
        $type       = $row->settings->separator_type;
        $position   = 'top';
        $color      = $row->settings->separator_color;
        $height     = $row->settings->separator_height;
        $shadow     = 'triangle_shadow' == $type ? $row->settings->separator_shadow : '';
        echo pp_row_separator_html( $type, $position, $color, $height, $shadow );
    }

    if ( 'yes' == $row->settings->enable_separator && isset( $row->settings->separator_type_bottom ) && 'none' != $row->settings->separator_type_bottom ) {
        $type       = $row->settings->separator_type_bottom;
        $position   = 'bottom';
        $color      = $row->settings->separator_color_bottom;
        $height     = $row->settings->separator_height_bottom;
        $shadow     = 'triangle_shadow' == $type ? $row->settings->separator_shadow_bottom : '';
        echo pp_row_separator_html( $type, $position, $color, $height, $shadow );
    }
}

/**
 * Output for Columns
 */
function pp_output_after_render_row_bg( $row ) {
    if ( is_object($row) && isset($row->settings->enable_down_arrow) && 'yes' == $row->settings->enable_down_arrow ) {
        ?>
        <div class="pp-down-arrow-container">
            <div class="pp-down-arrow-wrap">
               	<div class="pp-down-arrow<?php echo ($row->settings->da_animation == 'yes') ? ' pp-da-bounce' : ''; ?>" data-row-id="<?php echo $row->node; ?>" data-top-offset="<?php echo $row->settings->da_top_offset; ?>" data-transition-speed="<?php echo $row->settings->da_transition_speed; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg">
        				<path stroke="null" d="m1.00122,14.45485c0,-0.24438 0.10878,-0.48877 0.32411,-0.67587c0.4329,-0.37231 1.13663,-0.37231 1.56952,0l19.19382,16.50735l19.19381,-16.50735c0.4329,-0.37231 1.13663,-0.37231 1.56952,0s0.43289,0.97753 0,1.34983l-19.97969,17.18324c-0.43289,0.3723 -1.13662,0.3723 -1.56951,0l-19.97969,-17.18324c-0.21755,-0.1871 -0.32411,-0.43149 -0.32411,-0.67587l0.00222,0.00191z" fill="#000000" id="svg_1"/>
        			</svg>
                </div>
            </div>
        </div>
        <?php
    }
}

pp_row_settings_init();
