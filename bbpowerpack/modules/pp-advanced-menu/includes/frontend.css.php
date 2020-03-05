<?php

$toggle_width 	= 28;
$toggle_height 	= 28;
?>

/**
 * Overall menu alignment
 */

.fl-node-<?php echo $id; ?> .pp-advanced-menu {
	text-align: <?php echo $settings->alignment; ?>;
}

/**
 * Overall menu styling
 */

.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li {
	<?php if ( isset( $settings->spacing ) && ! empty( $settings->spacing ) ) { ?>
	<?php if( $settings->alignment == 'left' ) { ?>
		margin-right: <?php echo ( $settings->spacing ); ?>px;
    <?php } elseif( $settings->alignment == 'right' ) { ?>
		margin-left: <?php echo ( $settings->spacing ); ?>px;
    <?php } else { ?>
		margin-left: <?php echo ( $settings->spacing / 2 ); ?>px;
		margin-right: <?php echo ( $settings->spacing / 2 ); ?>px;
	<?php } ?>
	<?php } ?>
	<?php if( $settings->link_bottom_spacing ) { ?>margin-bottom: <?php echo $settings->link_bottom_spacing; ?>px;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu-container a > span {
	<?php if( $settings->submenu_hover_toggle != 'none' ) { ?>
		padding-right: 38px;
	<?php } else { ?>
		padding-right: 0;
	<?php } ?>
}

<?php

/**
 * Toggle - Arrows / None
 */
if( ( ( $settings->menu_layout == 'horizontal' || $settings->menu_layout == 'vertical' ) && in_array($settings->submenu_hover_toggle, array('arrows', 'none') ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle:before {
		content: '';
		position: absolute;
		right: 50%;
		top: 50%;
		z-index: 1;
		display: block;
		width: 9px;
		height: 9px;
		margin: -5px -5px 0 0;
		border-right: 2px solid;
		border-bottom: 2px solid;
		-webkit-transform-origin: right bottom;
			-ms-transform-origin: right bottom;
			    transform-origin: right bottom;
		-webkit-transform: translateX( -5px ) rotate( 45deg );
			-ms-transform: translateX( -5px ) rotate( 45deg );
				transform: translateX( -5px ) rotate( 45deg );
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu.pp-active > .pp-has-submenu-container .pp-menu-toggle {
		-webkit-transform: rotate( -180deg );
			-ms-transform: rotate( -180deg );
				transform: rotate( -180deg );
	}
<?php

/**
 * Toggle - Plus
 */
} elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle:before,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle:after {
		content: '';
		position: absolute;
		z-index: 1;
		display: block;
		border-color: #333;
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle:before {
		left: 50%;
		top: 50%;
		width: 12px;
		border-top: 3px solid;
		-webkit-transform: translate( -50%, -50% );
			-ms-transform: translate( -50%, -50% );
				transform: translate( -50%, -50% );
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle:after {
		left: 50%;
		top: 50%;
		border-left: 3px solid;
		height: 12px;
		-webkit-transform: translate( -50%, -50% );
			-ms-transform: translate( -50%, -50% );
				transform: translate( -50%, -50% );
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu.pp-active > .pp-has-submenu-container .pp-menu-toggle:after {
		display: none;
	}
<?php }

if( $settings->menu_layout == 'vertical' && $settings->submenu_hover_toggle == 'arrows' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle:before {
		border-right: 0;
		border-left: 2px solid;
		border-bottom: 2px solid;
	}
<?php }

if( $settings->menu_layout == 'expanded' && $settings->alignment == 'center' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu-container a > span {
		padding-right: 0;
	}
<?php }

/**
 * Responsive enabled
 */
if( $global_settings->responsive_enabled ) { ?>

	<?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'none' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu-container a {
			padding-right: <?php echo $toggle_width ?>px;
		}
	<?php } ?>

	<?php // Submenu - horizontal or vertical ?>
	<?php if( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) ) { ?>
		.fl-node-<?php echo $id; ?> .menu .pp-has-submenu .sub-menu {
			display: none;
		}
	<?php } ?>

	.fl-node-<?php echo $id; ?> .pp-advanced-menu li:first-child {
		border-top: none;
	}

	<?php if( isset( $settings->mobile_toggle ) && in_array($settings->mobile_toggle, array('hamburger', 'hamburger-label')) ) { ?>
		<?php if ( 'always' != $module->get_media_breakpoint() ) : ?>
			@media ( max-width: <?php echo $module->get_media_breakpoint() ?>px ) {
		<?php endif; ?>

			.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu {
				margin-top: 20px;
			}
			<?php if ( $settings->mobile_toggle != 'expanded' ) : ?>
				.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu {
				}
			<?php endif; ?>
			.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li {
				margin-left: 0 !important;
				margin-right: 0 !important;
			}

			.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-off-canvas-menu .pp-menu-close-btn,
			.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn {
				display: block;
			}

			.fl-node-<?php echo $id; ?> .pp-advanced-menu .sub-menu {
				box-shadow: none;
				border: 0;
			}

		<?php if ( 'always' != $module->get_media_breakpoint() ) : ?>
		} <?php // close media max-width ?>
		<?php endif; ?>
	<?php } ?>

	<?php if ( 'always' != $module->get_media_breakpoint() ) { ?>
		@media ( min-width: <?php echo ( $module->get_media_breakpoint() ) + 1 ?>px ) {

		<?php // if menu is horizontal ?>
		<?php if( $settings->menu_layout == 'horizontal' ) { ?>
			.fl-node-<?php echo $id; ?> .menu > li {
				display: inline-block;
			}

			.fl-node-<?php echo $id; ?> .menu li {
				border-top: none;
			}

			.fl-node-<?php echo $id; ?> .menu li:first-child {
				border: none;
			}
			.fl-node-<?php echo $id; ?> .menu li li {
				border-left: none;
			}

			.fl-node-<?php echo $id; ?> .menu .pp-has-submenu .sub-menu {
				position: absolute;
				top: 100%;
				left: 0;
				z-index: 10;
				visibility: hidden;
				opacity: 0;
				text-align:left;
			}

			.fl-node-<?php echo $id; ?> .pp-has-submenu .pp-has-submenu .sub-menu {
				top: 0;
				left: 100%;
			}

			<?php if( !empty( $settings->menu_align ) && $settings->menu_align != 'default' ) { ?>
				.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu {
					<?php
						if( in_array( $settings->menu_align, array( 'left', 'right' ) ) ) {
							echo 'float: '. $settings->menu_align .';';
						} elseif( $settings->menu_align == 'center' ) {
							echo 'display: inline-block;';
						}
					?>
				}
			<?php } ?>

		<?php // if menu is vertical ?>
		<?php } elseif( $settings->menu_layout == 'vertical' ) { ?>

			.fl-node-<?php echo $id; ?> .menu .pp-wp-has-submenu .sub-menu {
				position: absolute;
				top: 0;
				left: 100%;
				z-index: 10;
				visibility: hidden;
				opacity: 0;
			}

		<?php } ?>

		<?php // if menu is horizontal or vertical ?>
		<?php if( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) ) { ?>

			.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu:hover > .sub-menu,
			.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu.focus > .sub-menu {
				display: block;
				visibility: visible;
				opacity: 1;
			}

			.fl-node-<?php echo $id; ?> .menu .pp-has-submenu.pp-menu-submenu-right .sub-menu {
				top: 100%;
				left: inherit;
				right: 0;
			}

			.fl-node-<?php echo $id; ?> .menu .pp-has-submenu .pp-has-submenu.pp-menu-submenu-right .sub-menu {
				top: 0;
				left: inherit;
				right: 100%;
			}

			.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu.pp-active > .pp-has-submenu-container .pp-menu-toggle {
				-webkit-transform: none;
					-ms-transform: none;
						transform: none;
			}

			<?php //change selector depending on layout ?>
			<?php if( $settings->submenu_hover_toggle == 'arrows' ) { ?>
				<?php if( $settings->menu_layout == 'horizontal' ) { ?>
					.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu .pp-has-submenu .pp-menu-toggle:before {
						<?php } elseif( $settings->menu_layout == 'vertical' ) { ?>
						.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu .pp-menu-toggle:before {
						<?php } ?>
							-webkit-transform: translateY( -5px ) rotate( -45deg );
								-ms-transform: translateY( -5px ) rotate( -45deg );
									transform: translateY( -5px ) rotate( -45deg );
						}
					<?php } ?>

					<?php if( $settings->submenu_hover_toggle == 'none' ) { ?>
						.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle {
							display: none;
						}
					<?php } ?>

					<?php } ?>

					<?php if( $settings->mobile_toggle != 'expanded' ) { ?>
						.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle {
							display: none;
						}
					<?php } ?>

				}

		<?php
	}
		/**
		 * Responsive NOT enabled
		 */
	 } else { ?>

	<?php // if menu is horizontal ?>
	<?php if( $settings->menu_layout == 'horizontal' ) { ?>

		.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li {
			float: left;
		}

		.fl-node-<?php echo $id; ?> .menu li {
			border-left: 1px solid transparent;
		}

		.fl-node-<?php echo $id; ?> .menu li:first-child {
			border: none;
		}

		.fl-node-<?php echo $id; ?> .menu li li {
			border-left: none;
		}

		<?php if( !empty( $settings->menu_align ) && $settings->menu_align != 'default' ) { ?>
			.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu {
				<?php
					if( in_array( $settings->menu_align, array( 'left', 'right' ) ) ) {
						echo 'float: '. $settings->menu_align .';';
					} elseif( $settings->menu_align == 'center' ) {
						echo 'display: inline-block;';
					}
				?>
			}
		<?php } ?>

	<?php } ?>

	<?php // if menu is horizontal or vertical ?>
	<?php if( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) ) { ?>

		.fl-node-<?php echo $id; ?> .menu .pp-has-submenu .sub-menu {
			position: absolute;
			top: 100%;
			left: 0;
			z-index: 10;
			visibility: hidden;
			opacity: 0;
		}

		.fl-node-<?php echo $id; ?> .menu .pp-has-submenu .pp-has-submenu .sub-menu {
			top: 0;
			left: 100%;
		}

		.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu.pp-toggle-arrows .pp-has-submenu .pp-has-submenu .pp-menu-toggle:before {
			-webkit-transform: translateY( -2px ) rotate( -45deg );
				-ms-transform: translateY( -2px ) rotate( -45deg );
					transform: translateY( -2px ) rotate( -45deg );
		}

		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu:hover > .sub-menu,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-has-submenu.focus > .sub-menu {
			display: block;
			visibility: visible;
			opacity: 1;
		}

		<?php if( $settings->submenu_hover_toggle == 'none' ) { ?>
			.pp-advanced-menu .pp-menu-toggle {
				display: none;
			}
		<?php } ?>

	<?php } ?>

	<?php if( $settings->mobile_toggle == 'expanded' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle {
			display: none;
		}
	<?php } ?>

	<?php if ( 'always' != $module->get_media_breakpoint() ) { ?>
	@media (min-width: <?php echo $module->get_media_breakpoint(); ?>px) {
		.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle {
			display: none;
		}
	}
	<?php } ?>

<?php } ?>

.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-menu-toggle {
	<?php if ( isset( $settings->menu_link_padding_right ) ) { ?>
	right: <?php echo ( $settings->menu_link_padding_right == 0 ) ? '10' : $settings->menu_link_padding_right; ?>px;
	<?php } ?>
}

/**
 * Links
 */
<?php
// Link typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'link_typography',
	'selector'		=> ".fl-node-$id .pp-advanced-menu .menu a"
) );

// Sbumenu typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'submenu_typography',
	'selector'		=> ".fl-node-$id .pp-advanced-menu .menu .sub-menu a"
) );
?>

.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li > a,
.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li > .pp-has-submenu-container > a {
	border-style: <?php echo $settings->border_style; ?>;
	border-top-width: <?php echo ( $settings->border_size['top'] != '' && $settings->border_color ) ? $settings->border_size['top'] : '0'; ?>px;
	border-bottom-width: <?php echo ( $settings->border_size['bottom'] != '' && $settings->border_color ) ? $settings->border_size['bottom'] : '0'; ?>px;
	border-left-width: <?php echo ( $settings->border_size['left'] != '' && $settings->border_color ) ? $settings->border_size['left'] : '0'; ?>px;
	border-right-width: <?php echo ( $settings->border_size['right'] != '' && $settings->border_color ) ? $settings->border_size['right'] : '0'; ?>px;
	border-color: <?php echo '#' . $settings->border_color; ?>;
	background-color: <?php echo ( false === strpos( $settings->background_color, 'rgb' ) ) ? '#' . $settings->background_color : $settings->background_color; ?>;
	color: <?php echo '#' . $settings->link_color; ?>;
}
<?php
// Link Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'menu_link_padding',
	'selector' 		=> ".fl-node-$id .pp-advanced-menu .menu > li > a, .fl-node-$id .pp-advanced-menu .menu > li > .pp-has-submenu-container > a",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'menu_link_padding_top',
		'padding-right' 	=> 'menu_link_padding_right',
		'padding-bottom' 	=> 'menu_link_padding_bottom',
		'padding-left' 		=> 'menu_link_padding_left',
	),
) );
?>

<?php if( !empty( $settings->link_color ) ) { ?>

		<?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none .pp-menu-toggle:before {
			border-color: #<?php echo $settings->link_color; ?>;
		}
		<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-menu-toggle:after {
			border-color: #<?php echo $settings->link_color; ?>;
		}
		<?php } ?>
<?php } ?>

<?php if( !empty( $settings->link_hover_color ) ) { ?>

		<?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows li:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none li:hover .pp-menu-toggle:before {
			border-color: #<?php echo $settings->link_hover_color; ?>;
		}
		<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus li:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus li:hover .pp-menu-toggle:after {
			border-color: #<?php echo $settings->link_hover_color; ?>;
		}
		<?php } ?>
        <?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows li a:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none li a:hover .pp-menu-toggle:before {
			border-color: #<?php echo $settings->link_hover_color; ?>;
		}
		<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus li a:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus li a:hover .pp-menu-toggle:after {
			border-color: #<?php echo $settings->link_hover_color; ?>;
		}
		<?php } ?>
<?php }


/**
 * Links - hover / active
 */
if( !empty( $settings->background_hover_color ) || $settings->link_hover_color ) { ?>
	.fl-node-<?php echo $id; ?> .menu > li > a:hover,
	.fl-node-<?php echo $id; ?> .menu > li > a:focus,
	.fl-node-<?php echo $id; ?> .menu > li:hover > .pp-has-submenu-container > a,
	.fl-node-<?php echo $id; ?> .menu > li:focus > .pp-has-submenu-container > a,
	.fl-node-<?php echo $id; ?> .menu > li.current-menu-item > a,
	.fl-node-<?php echo $id; ?> .menu > li.current-menu-item > .pp-has-submenu-container > a {
		<?php if( !empty( $settings->background_hover_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $settings->background_hover_color ); ?>;
		<?php }
			if( !empty( $settings->link_hover_color ) ) {
				?>
				color: <?php echo pp_get_color_value( $settings->link_hover_color ); ?>;
				<?php
			}
		?>
	}
<?php } ?>

<?php if( !empty( $settings->link_hover_color ) ) { ?>
	<?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows .pp-has-submenu-container:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows .pp-has-submenu-container.focus .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows li.current-menu-item > .pp-has-submenu-container .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none .pp-has-submenu-container:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none .pp-has-submenu-container.focus .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none li.current-menu-item > .pp-has-submenu-container .pp-menu-toggle:before {
			border-color: #<?php echo $settings->link_hover_color ?>;
		}
		<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container.focus .pp-menu-toggle:before,
        .fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container a:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container.focus a .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus li.current-menu-item > .pp-has-submenu-container .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container:hover .pp-menu-toggle:after,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container.focus .pp-menu-toggle:after,
        .fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container a:hover .pp-menu-toggle:after,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .pp-has-submenu-container.focus a .pp-menu-toggle:after,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus li.current-menu-item > .pp-has-submenu-container .pp-menu-toggle:after {
			border-color: #<?php echo $settings->link_hover_color ?>;
		}
	<?php } ?>

<?php } ?>

/**
 * Sub Menu
 **/
.fl-node-<?php echo $id; ?> .pp-advanced-menu .sub-menu {
	<?php if ( ! empty( $settings->submenu_container_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->submenu_container_bg_color ); ?>;
	<?php } ?>
	<?php if ( $settings->submenu_width ) { ?>
		width: <?php echo $settings->submenu_width; ?>px;
		margin-left: auto;
		margin-right: auto;
	<?php } ?>
}
<?php
// Submenu Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'submenu_container_border',
	'selector' 		=> ".fl-node-$id .sub-menu",
) );
?>

.fl-node-<?php echo $id; ?> ul.pp-advanced-menu-horizontal li.mega-menu > ul.sub-menu {
	<?php if ( ! empty( $settings->submenu_container_bg_color ) ) { ?>
	background: <?php echo pp_get_color_value( $settings->submenu_container_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .sub-menu > li > a,
.fl-node-<?php echo $id; ?> .sub-menu > li > .pp-has-submenu-container > a {
	border-width: 0;
	border-style: <?php echo $settings->submenu_border_style; ?>;
	border-bottom-width: <?php echo ( $settings->submenu_border_size != '' && $settings->submenu_border_color ) ? $settings->submenu_border_size : ''; ?>px;
	border-color: <?php echo '#' . $settings->submenu_border_color; ?>;
	background-color: <?php echo pp_get_color_value( $settings->submenu_background_color ); ?>;
	color: #<?php echo empty($settings->submenu_link_color) ? $settings->link_color : $settings->submenu_link_color; ?>;
}
<?php
// Submenu link Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'submenu_link_padding',
	'selector' 		=> ".fl-node-$id .sub-menu > li > a, .fl-node-$id .sub-menu > li > .pp-has-submenu-container > a",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'submenu_link_padding_top',
		'padding-right' 	=> 'submenu_link_padding_right',
		'padding-bottom' 	=> 'submenu_link_padding_bottom',
		'padding-left' 		=> 'submenu_link_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .sub-menu > li:last-child > a,
.fl-node-<?php echo $id; ?> .sub-menu > li:last-child > .pp-has-submenu-container > a {
	border: 0;
}

.fl-node-<?php echo $id; ?> .sub-menu > li > a:hover,
.fl-node-<?php echo $id; ?> .sub-menu > li > a:focus,
.fl-node-<?php echo $id; ?> .sub-menu > li > .pp-has-submenu-container > a:hover,
.fl-node-<?php echo $id; ?> .sub-menu > li > .pp-has-submenu-container > a:focus,
.fl-node-<?php echo $id; ?> .sub-menu > li.current-menu-item > a,
.fl-node-<?php echo $id; ?> .sub-menu > li.current-menu-item > .pp-has-submenu-container > a {
	background-color: <?php echo pp_get_color_value( $settings->submenu_background_hover_color ); ?>;
	color: #<?php echo empty($settings->submenu_link_hover_color) ? $settings->link_hover_color : $settings->submenu_link_hover_color; ?>;
}

<?php if( !empty( $settings->submenu_link_color ) ) { ?>

		<?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows .sub-menu .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none .sub-menu .pp-menu-toggle:before {
			border-color: #<?php echo $settings->submenu_link_color; ?>;
		}
		<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .sub-menu .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .sub-menu .pp-menu-toggle:after {
			border-color: #<?php echo $settings->submenu_link_color; ?>;
		}
		<?php } ?>
<?php } ?>

<?php if( !empty( $settings->submenu_link_hover_color ) ) { ?>

		<?php if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-arrows .sub-menu li:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-none .sub-menu li:hover .pp-menu-toggle:before {
			border-color: #<?php echo $settings->submenu_link_hover_color; ?>;
		}
		<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:before,
		.fl-node-<?php echo $id; ?> .pp-advanced-menu .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:after {
			border-color: #<?php echo $settings->submenu_link_hover_color; ?>;
		}
		<?php } ?>
<?php } ?>

<?php
/**
 * Submenu toggle
 */
if( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && in_array( $settings->submenu_hover_toggle, array( 'arrows', 'none' ) ) ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'arrows' ) ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-<?php echo $settings->menu_layout ?>.pp-toggle-arrows .pp-has-submenu-container > a > span {
		padding-right: <?php echo $toggle_width ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-<?php echo $settings->menu_layout ?>.pp-toggle-arrows .pp-menu-toggle,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-<?php echo $settings->menu_layout ?>.pp-toggle-none .pp-menu-toggle {
		width: <?php echo $toggle_height ?>px;
		height: <?php echo $toggle_height ?>px;
		margin: -<?php echo $toggle_height/2 ?>px 0 0;
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-horizontal.pp-toggle-arrows .pp-menu-toggle,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-horizontal.pp-toggle-none .pp-menu-toggle,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-vertical.pp-toggle-arrows .pp-menu-toggle,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-vertical.pp-toggle-none .pp-menu-toggle {
		width: <?php echo $toggle_width ?>px;
		height: <?php echo $toggle_height ?>px;
		margin: -<?php echo $toggle_height/2 ?>px 0 0;
	}
<?php } elseif( ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) && $settings->submenu_hover_toggle == 'plus' ) || ( $settings->menu_layout == 'accordion' && $settings->submenu_click_toggle == 'plus' ) ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-<?php echo $settings->menu_layout ?>.pp-toggle-plus .pp-has-submenu-container a {
		padding-right: <?php echo $toggle_width ?>px;
	}

	.fl-node-<?php echo $id; ?> .pp-menu-accordion.pp-toggle-plus .pp-menu-toggle {
		width: <?php echo $toggle_height ?>px;
		height: <?php echo $toggle_height ?>px;
		margin: -<?php echo $toggle_height/2 ?>px 0 0;
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-horizontal.pp-toggle-plus .pp-menu-toggle,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-vertical.pp-toggle-plus .pp-menu-toggle {
		width: <?php echo $toggle_width ?>px;
		height: <?php echo $toggle_height ?>px;
		margin: -<?php echo $toggle_height/2 ?>px 0 0;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-advanced-menu.off-canvas .pp-toggle-arrows .pp-menu-toggle {
    width: <?php echo $toggle_width ?>px;
    height: <?php echo $toggle_height ?>px;
    margin: -<?php echo $toggle_height ?>px;
    padding: <?php echo $toggle_height ?>px;
    right: <?php echo $toggle_height ?>px;
}

<?php
/**
 * Separators
 */
if( isset( $settings->show_separator ) && $settings->show_separator == 'yes' ) { ?>
	<?php

		$separator_raw_color = !empty( $settings->separator_color ) ? $settings->separator_color : '000000';
		$separator_opacity   = !empty( $settings->separator_opacity ) ? $settings->separator_opacity : '100';
		$separator_color     = 'rgba('. implode( ',', FLBuilderColor::hex_to_rgb( $separator_raw_color ) ) .','. ( $separator_opacity/100 ) .')';

	 ?>
	.fl-node-<?php echo $id; ?> .menu.pp-advanced-menu-<?php echo $settings->menu_layout ?> li,
	.fl-node-<?php echo $id; ?> .menu.pp-advanced-menu-horizontal li li {
		border-color: #<?php echo $separator_raw_color; ?>;
		border-color: <?php echo $separator_color; ?>;
	}
<?php }

/**
 * Mobile toggle button
 */
if( isset( $settings->mobile_toggle ) && $settings->mobile_toggle != 'expanded' ) { ?>
	<?php if( !empty( $settings->menu_align ) && $settings->menu_align != 'default' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle{
			<?php
				if( in_array( $settings->menu_align, array( 'left', 'right' ) ) ) {
					echo 'float: '. $settings->menu_align .';';
				}
			?>
		}
	<?php } ?>

	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle {
		<?php
		if( !empty( $settings->mobile_toggle_color ) ) {
			echo 'color: #'. $settings->mobile_toggle_color .';';
		}

		if( $settings->mobile_toggle_font['family'] != 'Default' && ( $settings->mobile_toggle == 'hamburger-label' || $settings->mobile_toggle == 'text' ) ) { ?>
		   <?php FLBuilderFonts::font_css( $settings->mobile_toggle_font ); ?>
	   <?php } ?>
		<?php if( $settings->mobile_toggle_font_size == 'custom' && $settings->mobile_toggle_font_size_custom ) { ?>font-size: <?php echo $settings->mobile_toggle_font_size_custom; ?>px;<?php } ?>
		text-align: <?php echo $settings->alignment; ?>;
		<?php
			$toggle_alignment_desktop = 'center';
			if ( 'left' == $settings->alignment ) {
				$toggle_alignment_desktop = 'flex-start';
			} elseif ( 'right' == $settings->alignment ) {
				$toggle_alignment_desktop = 'flex-end';
			}
		?>
		-webkit-justify-content: <?php echo $toggle_alignment_desktop; ?>;
		-ms-flex-pack: <?php echo $toggle_alignment_desktop; ?>;
		justify-content: <?php echo $toggle_alignment_desktop; ?>;
	}

	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:before,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:after {
		<?php if ( $settings->mobile_toggle_size !== '' ) { ?>
			width: <?php echo $settings->mobile_toggle_size; ?>px;
		<?php } ?>
	}

	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:before,
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:after {
		<?php if( !empty( $settings->mobile_toggle_color ) ) {
			echo 'background-color: #'. $settings->mobile_toggle_color .';';
		} ?>
		<?php if ( $settings->mobile_toggle_thickness !== '' ) { ?>
			height: <?php echo $settings->mobile_toggle_thickness; ?>px;
		<?php } ?>
	}

	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle rect {
		<?php
			if( !empty( $settings->link_color ) ) {
				echo 'fill: #'. $settings->link_color .';';
			}
		?>
	}
<?php } ?>

<?php if( isset( $settings->mobile_button_label ) && $settings->mobile_button_label == 'no' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle.hamburger .pp-menu-mobile-toggle-label {
		display: none;
	}
<?php } ?>


<?php if (  'expanded' != $settings->mobile_toggle ) : ?>
	<?php if ( 'always' != $module->get_media_breakpoint() ) : ?>
		@media ( max-width: <?php echo $module->get_media_breakpoint() ?>px ) {
	<?php endif; ?>
		.fl-node-<?php echo $id; ?> .pp-advanced-menu {
			text-align: <?php echo $settings->responsive_alignment; ?>;
		}
	<?php if ( 'always' != $module->get_media_breakpoint() ) : ?>
		}
	<?php endif; ?>
<?php endif; ?>

<?php if ( 'always' != $module->get_media_breakpoint() ) : ?>
	@media ( min-width: <?php echo ( $module->get_media_breakpoint() ) + 1 ?>px ) {
		<?php // if menu is horizontal or vertical ?>
		<?php if ( in_array( $settings->menu_layout, array( 'horizontal', 'vertical' ) ) ) : ?>
			.fl-node-<?php echo $id; ?> ul.sub-menu {
				padding: <?php echo ! empty( $settings->submenu_spacing ) ? $settings->submenu_spacing . 'px' : '0' ?>;
			}
		<?php endif; ?>		
	}
<?php endif; ?>


@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li {
		<?php if ( isset( $settings->spacing_medium ) && ! empty( $settings->spacing_medium ) ) { ?>
			<?php if( $settings->alignment == 'left' ) { ?>
				margin-right: <?php echo ( $settings->spacing_medium ); ?>px;
			<?php } elseif( $settings->alignment == 'right' ) { ?>
				margin-left: <?php echo ( $settings->spacing_medium ); ?>px;
			<?php } else { ?>
				margin-left: <?php echo ( $settings->spacing_medium / 2 ); ?>px;
				margin-right: <?php echo ( $settings->spacing_medium / 2 ); ?>px;
			<?php } ?>
		<?php } ?>
		<?php if( $settings->link_bottom_spacing_medium ) { ?>margin-bottom: <?php echo $settings->link_bottom_spacing_medium; ?>px;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .sub-menu > li > a,
	.fl-node-<?php echo $id; ?> .sub-menu > li > .pp-has-submenu-container > a {
		border-bottom-width: <?php echo ( $settings->submenu_border_size_medium != '' && $settings->submenu_border_color ) ? $settings->submenu_border_size_medium : ''; ?>px;
		<?php if( isset( $settings->responsive_submenu_bg_color ) ) {
			echo 'background-color: '. pp_get_color_value($settings->responsive_submenu_bg_color) .' !important;';
		} ?>
	}

	.fl-node-<?php echo $id; ?> .sub-menu {
		width: auto;
	}

	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle {
		<?php if( $settings->mobile_toggle_font_size == 'custom' && $settings->mobile_toggle_font_size_custom_medium ) { ?>font-size: <?php echo $settings->mobile_toggle_font_size_custom_medium; ?>px;<?php } ?>
	}
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-advanced-menu .menu > li {
		<?php if ( isset( $settings->spacing_responsive ) && ! empty( $settings->spacing_responsive ) ) { ?>
			<?php if( $settings->alignment == 'left' ) { ?>
				margin-right: <?php echo ( $settings->spacing_responsive ); ?>px;
			<?php } elseif( $settings->alignment == 'right' ) { ?>
				margin-left: <?php echo ( $settings->spacing_responsive ); ?>px;
			<?php } else { ?>
				margin-left: <?php echo ( $settings->spacing_responsive / 2 ); ?>px;
				margin-right: <?php echo ( $settings->spacing_responsive / 2 ); ?>px;
			<?php } ?>
		<?php } ?>
		<?php if( $settings->link_bottom_spacing_responsive ) { ?>margin-bottom: <?php echo $settings->link_bottom_spacing_responsive; ?>px;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .sub-menu > li > a,
	.fl-node-<?php echo $id; ?> .sub-menu > li > .pp-has-submenu-container > a {
		border-bottom-width: <?php echo ( $settings->submenu_border_size_responsive != '' && $settings->submenu_border_color ) ? $settings->submenu_border_size_responsive : ''; ?>px;
		<?php if( isset( $settings->responsive_submenu_bg_color ) ) {
			echo 'background-color: '. pp_get_color_value($settings->responsive_submenu_bg_color) .' !important;';
		} ?>
	}
	.fl-node-<?php echo $id; ?> .pp-advanced-menu-mobile-toggle {
		<?php if( $settings->mobile_toggle_font_size == 'custom' && $settings->mobile_toggle_font_size_custom_responsive ) { ?>font-size: <?php echo $settings->mobile_toggle_font_size_custom_responsive; ?>px;<?php } ?>
		<?php if ( isset( $settings->responsive_toggle_alignment ) && 'default' != $settings->responsive_toggle_alignment ) { ?>
			text-align: <?php echo $settings->responsive_toggle_alignment; ?>;
			<?php
			if ( 'left' === $settings->responsive_toggle_alignment ) {
				$toggle_alignment = 'flex-start';
			} elseif ( 'right' === $settings->responsive_toggle_alignment ) {
				$toggle_alignment = 'flex-end';
			} else {
				$toggle_alignment = 'center';
			}
			?>
			-webkit-justify-content: <?php echo $toggle_alignment; ?>;
			-ms-flex-pack: <?php echo $toggle_alignment; ?>;
			justify-content: <?php echo $toggle_alignment; ?>;
		<?php } ?>
	}

}

<?php
if( 'default' != $settings->mobile_menu_type ) {
	include $module->dir . 'includes/menu-' . $settings->mobile_menu_type . '.css.php';
}
