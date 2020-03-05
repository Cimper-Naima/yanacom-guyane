<?php $module->render_toggle_button(); ?>
<div class="pp-advanced-menu<?php if ( $settings->collapse ) echo ' pp-advanced-menu-accordion-collapse'; ?> <?php echo $settings->mobile_menu_type; ?>">
	<div class="pp-clear"></div>
	<div class="pp-off-canvas-menu pp-menu-<?php echo $settings->offcanvas_direction; ?>">
		<div class="pp-menu-close-btn">×</div>

		<?php do_action( 'pp_advanced_menu_before', $settings->mobile_menu_type, $settings, $id ); ?>

		<?php
			if( !empty( $settings->wp_menu ) ) {

				if( isset( $settings->menu_layout ) ) {
					if( in_array( $settings->menu_layout, array( 'vertical', 'horizontal' ) ) && isset( $settings->submenu_hover_toggle ) ) {
						$toggle = ' pp-toggle-'. $settings->submenu_hover_toggle;
					} elseif ( $settings->menu_layout == 'accordion' && isset( $settings->submenu_click_toggle ) ) {
						$toggle = ' pp-toggle-'. $settings->submenu_click_toggle;
					} else {
						$toggle = ' pp-toggle-arrows';
					}
				} else {
					$toggle = ' pp-toggle-arrows';
				}

				$layout = isset( $settings->menu_layout ) ? 'pp-advanced-menu-'. $settings->menu_layout : 'pp-advanced-menu-horizontal';

				$defaults = array(
					'menu'			=> $settings->wp_menu,
					'container'		=> false,
					'menu_class'	=> 'menu '. $layout . $toggle,
					'walker'		=> new Advanced_Menu_Walker(),
				);

				wp_nav_menu( $defaults );
			}
		?>

		<?php do_action( 'pp_advanced_menu_after', $settings->mobile_menu_type, $settings, $id ); ?>

	</div>
</div>
