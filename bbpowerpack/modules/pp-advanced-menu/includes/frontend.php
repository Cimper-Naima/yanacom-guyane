<?php
if( $settings->mobile_breakpoint == 'always' ) {
	include $module->dir . 'includes/menu-' . $settings->mobile_menu_type . '.php';
}
else {
	include $module->dir . 'includes/menu-default.php';
	if ( 'default' != $settings->mobile_menu_type ) {
		include $module->dir . 'includes/menu-' . $settings->mobile_menu_type . '.php';
	}
}
