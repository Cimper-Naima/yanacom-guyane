<?php
//ini_set('xdebug.max_nesting_level', 10000);

function pp_column_settings_init() {

    require_once BB_POWERPACK_DIR . 'includes/column-settings.php';
    require_once BB_POWERPACK_DIR . 'includes/column-css.php';
    require_once BB_POWERPACK_DIR . 'includes/column-js.php';

    $extensions = BB_PowerPack_Admin_Settings::get_enabled_extensions();

    pp_column_register_settings( $extensions );
    pp_column_render_css( $extensions );

    if ( array_key_exists( 'separators', $extensions['col'] ) || in_array( 'separators', $extensions['col'] ) ) {
        add_action( 'fl_builder_before_render_modules', 'pp_output_before_module', 20, 2 );
    }

    pp_column_render_js( $extensions );

}

function pp_column_separator_html( $type, $position, $color, $height, $shadow ) {
    ob_start();
    ?>
    <div class="pp-col-separator pp-col-separator-<?php echo $position; ?>">
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
            <?php case 'triangle_small_out': ?>
                <svg class="pp-small-triangle" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 0.156661 0.1">
                    <polygon points="0.156661,3.93701e-006 0.156661,0.000429134 0.117665,0.05 0.0783307,0.0999961 0.0389961,0.05 -0,0.000429134 -0,3.93701e-006 0.0783307,3.93701e-006 "></polygon>
                </svg>
            <?php break; ?>
            <?php case 'tilt_left': ?>
                <svg class="pp-tilt-left" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4 0.266661" preserveAspectRatio="none">
					<polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "></polygon>
				</svg>
            <?php break; ?>
            <?php case 'tilt': ?>
                <svg class="pp-tilt-<?php echo $position; ?>" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4 0.266661" preserveAspectRatio="none">
					<polygon class="fil0" points="4,0 4,0.266661 -0,0.266661 "></polygon>
				</svg>
            <?php break; ?>
            <?php case 'curve': ?>
                <svg class="pp-curve" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#<?php echo $color; ?>" width="100%" height="<?php echo $height; ?>" viewBox="0 0 4.66666 0.333331" preserveAspectRatio="none">
					<path class="fil1" d="M4.66666 0l0 7.87402e-006 -3.93701e-006 0c0,0.0920315 -1.04489,0.166665 -2.33333,0.166665 -1.28844,0 -2.33333,-0.0746339 -2.33333,-0.166665l-3.93701e-006 0 0 -7.87402e-006 4.66666 0z"></path>
				</svg>
            <?php break; ?>
            <?php case 'wave': ?>
            <?php case 'wave_out': ?>
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
            <?php case 'box': ?>
                <div class="pp-box"></div>
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
 * Output.
 */
function pp_output_before_module( $modules, $col_id ) {

    $column = is_object( $col_id ) ? $col_id : FLBuilderModel::get_node( $col_id );

    if ( isset( $column->settings->enable_separator ) && 'yes' == $column->settings->enable_separator ) {
        $type       = $column->settings->separator_type;
        $position   = $column->settings->separator_position;
        $color      = $column->settings->separator_color;
        $height     = $column->settings->separator_height;
        $shadow     = 'triangle_shadow' == $type ? $column->settings->separator_shadow : '';
        echo pp_column_separator_html( $type, $position, $color, $height, $shadow );
    }
}

pp_column_settings_init();
