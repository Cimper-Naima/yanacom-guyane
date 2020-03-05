<?php

/**
 *
 * @class PPAdvancedMenu
 */
class PPAdvancedMenu extends FLBuilderModule {

    /**
     * Parent class constructor.
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Advanced Menu', 'bb-powerpack'),
            'description'   => __('A module for advanced menu.', 'bb-powerpack'),
			'group'         => pp_get_modules_group(),
			'category'      => pp_get_modules_cat( 'creative' ),
            'dir'           => BB_POWERPACK_DIR . 'modules/pp-advanced-menu/',
            'url'           => BB_POWERPACK_URL . 'modules/pp-advanced-menu/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));

    }

	public static function _get_menus() {
		$get_menus =  get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		$fields = array(
		    'type'          => 'select',
		    'label'         => __( 'Menu', 'bb-powerpack' ),
		    'helper'		=> __( 'Select a WordPress menu that you created in the admin under Appearance > Menus.', 'bb-powerpack' )
		);

		if( $get_menus ) {

			foreach( $get_menus as $key => $menu ) {

				if( $key == 0 ) {
					$fields['default'] = $menu->name;
				}

				$menus[ $menu->slug ] = $menu->name;
			}

			$fields['options'] = $menus;

		} else {
			$fields['options'] = array( '' => __( 'No Menus Found', 'bb-powerpack' ) );
		}

		return $fields;

	}

	public function render_toggle_button() {

		$toggle = $this->settings->mobile_toggle;
		$menu_text = $this->settings->custom_menu_text;

		if( isset( $toggle ) && $toggle != 'expanded' ) {

			if( in_array( $toggle, array( 'hamburger', 'hamburger-label' ) ) ) {

				echo '<div class="pp-advanced-menu-mobile-toggle '. $toggle .'">';
                    echo '<div class="pp-hamburger">';
					echo '<div class="pp-hamburger-box">';
					echo '<div class="pp-hamburger-inner"></div>';
					echo '</div>';
					echo '</div>';

				if( $toggle == 'hamburger-label' ) {
					if( $menu_text ) {
						echo '<span class="pp-advanced-menu-mobile-toggle-label">'. $menu_text .'</span>';
					} else {
						echo '<span class="pp-advanced-menu-mobile-toggle-label">'. __( 'Menu', 'bb-powerpack' ) .'</span>';
					}
				}

				echo '</div>';

			} elseif( $toggle == 'text' ) {

				if( $menu_text ) {
					echo '<div class="pp-advanced-menu-mobile-toggle text"><span class="pp-advanced-menu-mobile-toggle-label">'. $menu_text .'</span></div>';
				} else {
					echo '<div class="pp-advanced-menu-mobile-toggle text"><span class="pp-advanced-menu-mobile-toggle-label">'. __( 'Menu', 'bb-powerpack' ) .'</span></div>';
				}

			}

		}
	}

	public static function set_pre_get_posts_query( $query ) {
		if ( ! is_admin() && $query->is_main_query() ) {
	    	self::$fl_builder_page_id = $query->queried_object_id;
	    }
	}

	public static function sort_nav_objects( $sorted_menu_items, $args ) {
		$menu_items = array();
		$parent_items = array();

		foreach ( $sorted_menu_items as $key => $menu_item ) {
			$classes = (array) $menu_item->classes;

			// Setup classes for current menu item.
			if ( $menu_item->object_id == self::$fl_builder_page_id ) {
				$parent_items[$menu_item->object_id] = $menu_item->menu_item_parent;

				if ( ! in_array( 'current-menu-item', $classes ) ) {
					$classes[] = 'current-menu-item';

					if ($menu_item->object == 'page') {
		        		$classes[] = 'current_page_item';
		        	}
				}
			}
			$menu_item->classes = $classes;
			$menu_items[ $key ] = $menu_item;
		}

		// Setup classes for parent's current item.
		foreach ( $menu_items as $key => $sorted_item ) {
			if ( in_array( $sorted_item->db_id, $parent_items ) && ! in_array( 'current-menu-parent', (array) $sorted_item->classes) ) {
				$menu_items[ $key ]->classes[] = 'current-menu-ancestor';
				$menu_items[ $key ]->classes[] = 'current-menu-parent';
			}
		}

		return $menu_items;
	}

	public function get_media_breakpoint() {
		$global_settings = FLBuilderModel::get_global_settings();
		$media_width = $global_settings->responsive_breakpoint;
		$mobile_breakpoint = $this->settings->mobile_breakpoint;

		if ( isset( $mobile_breakpoint ) && 'expanded' != $this->settings->mobile_toggle ) {
			if ( 'medium-mobile' == $mobile_breakpoint ) {
				$media_width = $global_settings->medium_breakpoint;
			} elseif ( 'mobile' == $this->settings->mobile_breakpoint ) {
				$media_width = $global_settings->responsive_breakpoint;
			} elseif ( 'always' == $this->settings->mobile_breakpoint ) {
				$media_width = 'always';
			} elseif ( 'custom' == $this->settings->mobile_breakpoint ) {
				$media_width = $this->settings->custom_breakpoint;
			}
		}

		return $media_width;
	}

	public function filter_settings( $settings, $helper ) {
		// Handle old link padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'menu_link_padding', 'padding' );
		
		// Handle old submenu link padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'submenu_link_padding', 'padding' );

		// Handle old responsive link padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'responsive_link_padding', 'padding' );
		
		// Handle old responsive overlay padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'responsive_overlay_padding', 'padding' );

		// Handle old responsive link border width field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'responsive_link_border_width', 'dimension' );

		// Handle old submenu border field.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'submenu_border_width'	=> array(
				'type'					=> 'width'
			),
			'submenu_box_border_color'	=> array(
				'type'						=> 'color'
			),
			'submenu_box_shadow'	=> array(
				'type'					=> 'shadow',
				'condition'				=> ( isset( $settings->submenu_box_shadow_display ) && 'yes' == $settings->submenu_box_shadow_display )
			),
			'submenu_box_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->submenu_box_shadow_display ) && 'yes' == $settings->submenu_box_shadow_display ),
				'opacity'			=> ( isset( $settings->submenu_box_shadow_opacity ) && ! empty( $settings->submenu_box_shadow_opacity ) ) ? ( $settings->submenu_box_shadow_opacity / 100 ) : 1
			)
		), 'submenu_container_border' );

		// Handle old link typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'link_font_family'	=> array(
				'type'				=> 'font'
			),
			'link_font_size_custom'	=> array(
				'type'				=> 'font_size',
				'condition'			=> ( isset( $settings->link_font_size ) && 'custom' == $settings->link_font_size )
			),
			'link_line_height_custom'	=> array(
				'type'					=> 'line_height',
				'condition'				=> ( isset( $settings->link_line_height ) && 'custom' == $settings->link_line_height )
			),
			'link_text_transform'	=> array(
				'type'					=> 'text_transform'
			)
		), 'link_typography' );

		// Handle old submenu typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'submenu_font_family'	=> array(
				'type'				=> 'font'
			),
			'submenu_font_size_custom'	=> array(
				'type'				=> 'font_size',
				'condition'			=> ( isset( $settings->submenu_font_size ) && 'custom' == $settings->submenu_font_size )
			),
			'submenu_line_height_custom'	=> array(
				'type'					=> 'line_height',
				'condition'				=> ( isset( $settings->submenu_line_height ) && 'custom' == $settings->submenu_line_height )
			),
			'submenu_text_transform'	=> array(
				'type'					=> 'text_transform'
			)
		), 'submenu_typography' );

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPAdvancedMenu', array(
    'general'       => array( // Tab
        'title'         => __('General', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
					'wp_menu' => PPAdvancedMenu::_get_menus(),
					'menu_layout' => array(
					    'type'          => 'pp-switch',
					    'label'         => __( 'Layout', 'bb-powerpack' ),
					    'default'       => 'horizontal',
					    'options'       => array(
					    	'horizontal'	=> __( 'Horizontal', 'bb-powerpack' ),
					    	'vertical'		=> __( 'Vertical', 'bb-powerpack' ),
					    	'accordion'		=> __( 'Accordion', 'bb-powerpack' ),
					    	'expanded'		=> __( 'Expanded', 'bb-powerpack' ),
					    ),
					    'toggle'		=> array(
					    	'horizontal'	=> array(
					    		'fields'		=> array( 'submenu_hover_toggle', 'menu_align' ),
					    	),
					    	'vertical'		=> array(
					    		'fields'		=> array( 'submenu_hover_toggle' ),
					    	),
					    	'accordion'		=> array(
					    		'fields'		=> array( 'submenu_click_toggle', 'collapse' ),
					    	),
					    )
					),
					'submenu_hover_toggle' => array(
					    'type'          => 'pp-switch',
					    'label'         => __( 'Submenu Icon', 'bb-powerpack' ),
					    'default'       => 'arrows',
					    'options'       => array(
					    	'arrows'		=> __( 'Arrows', 'bb-powerpack' ),
					    	'plus'			=> __( 'Plus Sign', 'bb-powerpack' ),
					    	'none'			=> __( 'None', 'bb-powerpack' ),
					    )
					),
					'submenu_click_toggle' => array(
					    'type'          => 'pp-switch',
					    'label'         => __( 'Submenu Icon click', 'bb-powerpack' ),
					    'default'       => 'arrows',
					    'options'       => array(
					    	'arrows'		=> __( 'Arrows', 'bb-powerpack' ),
					    	'plus'			=> __( 'Plus Sign', 'bb-powerpack' ),
					    )
					),
					'collapse'   => array(
						'type'          => 'pp-switch',
						'label'         => __('Collapse Inactive', 'bb-powerpack'),
						'default'       => '1',
						'options'       => array(
							'1'             => __('Yes', 'bb-powerpack'),
							'0'             => __('No', 'bb-powerpack')
						),
						'help'          => __('Choosing yes will keep only one item open at a time. Choosing no will allow multiple items to be open at the same time.', 'bb-powerpack'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
                )
            ),
			'mobile'       => array(
				'title'         => __( 'Responsive', 'bb-powerpack' ),
				'fields'        => array(
                    'mobile_breakpoint' => array(
                        'type'          => 'select',
                        'label'         => __( 'Responsive Breakpoint', 'bb-powerpack' ),
                        'default'       => 'mobile',
                        'options'       => array(
                            'always'		=> __( 'Always', 'bb-powerpack' ),
                            'medium-mobile'	=> __( 'Medium & Small Devices Only', 'bb-powerpack' ),
                            'mobile'		=> __( 'Small Devices Only', 'bb-powerpack' ),
                            'custom'		=> __( 'Custom', 'bb-powerpack' ),
                        ),
                        'toggle'	=> array(
                            'custom'	=> array(
                                'fields'	=> array('custom_breakpoint')
                                )
                        )
                    ),
                    'custom_breakpoint'	=> array(
                        'type'				=> 'text',
                        'label'             => __('Custom Breakpoint', 'bb-powerpack'),
                        'default'       	=> '768',
                        'description'       => __('px', 'bb-powerpack'),
                        'size'              => 5
                    ),
					'mobile_toggle' => array(
					    'type'          => 'select',
					    'label'         => __( 'Responsive Toggle', 'bb-powerpack' ),
					    'default'       => 'hamburger',
					    'options'       => array(
					    	'hamburger'			=> __( 'Hamburger Icon', 'bb-powerpack' ),
					    	'hamburger-label'	=> __( 'Hamburger Icon + Label', 'bb-powerpack' ),
					    	'text'				=> __( 'Menu Button', 'bb-powerpack' ),
					    	'expanded'			=> __( 'None', 'bb-powerpack' ),
					    ),
					    'toggle'		=> array(
					    	'hamburger'	=> array(
					    		'fields'		=> array( 'mobile_menu_type', 'mobile_breakpoint', 'mobile_toggle_size', 'mobile_toggle_thickness' ),
								'sections'		=> array('mobile_toggle_typography', 'mobile_toggle_style'),
								'tabs'		=> array( 'responsive_style' )
					    	),
					    	'hamburger-label'	=> array(
					    		'fields'		=> array( 'mobile_menu_type', 'mobile_breakpoint', 'custom_menu_text', 'mobile_toggle_font', 'mobile_toggle_size', 'mobile_toggle_thickness' ),
								'sections'		=> array('mobile_toggle_typography', 'mobile_toggle_style'),
								'tabs'			=> array( 'responsive_style' )
					    	),
					    	'text'	=> array(
					    		'fields'		=> array( 'mobile_menu_type', 'mobile_breakpoint', 'custom_menu_text', 'mobile_toggle_font' ),
								'sections'		=> array('mobile_toggle_typography', 'mobile_toggle_style'),
								'tabs'		=> array( 'responsive_style' )
					    	),
					    )
					),
					'custom_menu_text'	=> array(
						'type'				=> 'text',
						'label'				=> __( 'Custom Menu Toggle Text', 'bb-powerpack' ),
						'default'			=> __('Menu', 'bb-powerpack'),
						'preview'			=> array(
							'type'			=> 'text',
							'selector'		=> '.pp-advanced-menu-mobile-toggle-label',
						),
						'connections'		=> array('string')
					),
					'mobile_menu_type'	=> array(
						'type'          => 'select',
					    'label'         => __( 'Menu Type', 'bb-powerpack' ),
					    'default'       => 'default',
					    'options'       => array(
					    	'default'		=> __( 'Default', 'bb-powerpack' ),
					    	'off-canvas'	=> __( 'Off Canvas', 'bb-powerpack' ),
					    	'full-screen'	=> __( 'Full Screen Overlay', 'bb-powerpack' ),
					    ),
						'toggle'	=> array(
							'off-canvas'	=> array(
                                'sections'      => array('menu_shadow', 'close_icon'),
								'fields'	    => array( 'offcanvas_direction', 'animation_speed', 'responsive_overlay_bg_color', 'responsive_overlay_bg_opacity', 'responsive_overlay_padding', 'close_icon_size', 'close_icon_color', 'responsive_link_color', 'responsive_link_hover_color', 'responsive_link_border_color', 'responsive_alignment_vertical' )
							),
							'full-screen'	=> array(
								'sections'	=> array('close_icon'),
								'fields'	    => array( 'full_screen_effects', 'animation_speed', 'responsive_overlay_bg_color', 'responsive_overlay_bg_opacity', 'responsive_overlay_padding', 'close_icon_size', 'close_icon_color', 'responsive_link_color', 'responsive_link_hover_color', 'responsive_link_border_color'  )
							)
						)
					),
					'full_screen_effects'	=> array(
						'type'          => 'select',
					    'label'         => __( 'Effects', 'bb-powerpack' ),
					    'default'       => 'fade',
					    'options'       => array(
					    	'fade'			=> __( 'Fade', 'bb-powerpack' ),
					    	'corner'		=> __( 'Corner', 'bb-powerpack' ),
					    	'slide-down'	=> __( 'Slide Down', 'bb-powerpack' ),
					    	'scale'			=> __( 'Zoom', 'bb-powerpack' ),
					    	'door'			=> __( 'Door', 'bb-powerpack' ),
					    ),
					),
					'offcanvas_direction'	=> array(
						'type'          => 'select',
					    'label'         => __( 'Direction', 'bb-powerpack' ),
					    'default'       => 'left',
					    'options'       => array(
					    	'left'			=> __( 'From Left', 'bb-powerpack' ),
					    	'right'			=> __( 'From Right', 'bb-powerpack' ),
					    ),
					),
					'animation_speed'   => array(
                        'type'              => 'text',
                        'label'             => __('Animation Speed', 'bb-powerpack'),
                        'default'       	=> 500,
                        'description'       => __('ms', 'bb-powerpack'),
                        'size'              => 5
                    ),
				)
			),
        )
    ),
    'style'       => array( // Tab
        'title'         => __('Style', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('Style', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'alignment'    => array(
                        'type'          => 'align',
                        'label'         => __('Alignment', 'bb-powerpack'),
                        'default'       => 'center',
                    ),
                    'spacing'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Horizontal Spacing', 'bb-powerpack'),
						'placeholder'   => '10',
						'units' 		=> array('px'),
						'slider'		=> true,
                        'help'          => __( 'This option controls the left-right spacing of each link.', 'bb-powerpack' ),
						'responsive' => array(
							'placeholder' => array(
								'default' => '10',
								'medium' => '',
								'responsive' => '',
							),
						),
                    ),
                    'link_bottom_spacing'    => array(
						'type' 			=> 'unit',
						'label' 		=> __('Vertical Spacing', 'bb-powerpack'),
						'units' 		=> array('px'),
						'slider'		=> true,
                        'help'          => __( 'This option controls the top-bottom spacing of each link.', 'bb-powerpack' ),
						'preview' 		=> array(
							'type' 			=> 'css',
							'selector'		=> '.pp-advanced-menu .menu > li',
							'property'		=> 'margin-bottom',
							'unit' 			=> 'px'
						),
						'responsive' => array(
							'placeholder' => array(
								'default' => '',
								'medium' => '',
								'responsive' => '',
							),
						),
					),
					'menu_link_padding'		=> array(
						'type'			=> 'dimension',
						'label'			=> __('Link Padding', 'bb-powerpack'),
						'default'		=> 10,
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
							'property'      => 'padding',
							'unit'          => 'px'
						)
					),
                )
            ),
            'color_settings'       => array( // Section
                'title'         => __('Colors', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'link_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 'css',
							'rules'			=> array(
								array(
									'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
									'property'        => 'color',
								),
								array(
									'selector'        => '.pp-advanced-menu-mobile-toggle rect',
									'property'        => 'fill',
								),
								array(
									'selector'        => '.pp-advanced-menu .pp-wp-toggle-arrows .pp-menu-toggle:before, .pp-advanced-menu .pp-toggle-none .pp-menu-toggle:before, .pp-advanced-menu .pp-toggle-plus .pp-menu-toggle:before, .pp-advanced-menu .pp-toggle-plus .pp-menu-toggle:after',
									'property'        => 'border-color',
								)
							)
						)
                    ),
                    'link_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Hover Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'          => 'css',
							'rules'			=> array(
								array(
									'selector'        => '.menu > li > a:hover, .menu > li > a:focus, .menu > li > .pp-has-submenu-container:hover > a, .menu > li > .pp-has-submenu-container.focus > a, .menu > li.current-menu-item > a, .menu > li.current-menu-item > .pp-has-submenu-container > a',
									'property'        => 'color',
								),
								array(
									'selector'        => '.pp-advanced-menu .pp-wp-toggle-arrows li:hover .pp-menu-toggle:before, .pp-advanced-menu .pp-toggle-none li:hover .pp-menu-toggle:before, .pp-advanced-menu .pp-toggle-plus li:hover .pp-menu-toggle:before, .pp-advanced-menu .pp-toggle-plus li:hover .pp-menu-toggle:after',
									'property'        => 'border-color',
								)
							)
						)
                    ),
                    'background_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'bb-powerpack'),
                        'default'    => '',
                        'show_reset' => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
							'property'        => 'background-color',
						)
                    ),
                    'background_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Hover Color', 'bb-powerpack'),
                        'default'    => '',
                        'show_reset' => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.menu > li > a:hover, .menu > li > a:focus, .menu > li > .pp-has-submenu-container:hover > a, .menu > li > .pp-has-submenu-container.focus > a, .menu > li.current-menu-item > a, .menu > li.current-menu-item > .pp-has-submenu-container > a',
							'property'        => 'background-color',
						)
                    ),
                )
            ),
            'border_settings'       => array( // Section
                'title'         => __('Borders', 'bb-powerpack'), // Section Title
                'fields'        => array( // Section Fields
                    'border_style' => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Border Style', 'bb-powerpack'),
                        'default'       => 'solid',
                        'options'       => array(
                            'solid'        => __('Solid', 'bb-powerpack'),
                            'dashed'       => __('Dashed', 'bb-powerpack'),
                            'double'       => __('Double', 'bb-powerpack'),
                            'dotted'       => __('Dotted', 'bb-powerpack'),
                        ),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
							'property'        => 'border-style',
						)
                    ),
					'border_size' 	=> array(
                    	'type' 			=> 'pp-multitext',
                    	'label' 		=> __('Border Width', 'bb-powerpack'),
                        'description'   => 'px',
                        'default'       => array(
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ),
                    	'options' 		=> array(
                    		'top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-up',
								'preview'         => array(
		                            'type'            => 'css',
		                            'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
		                            'property'        => 'border-top-width',
		                            'unit'            => 'px'
		                        )
                    		),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-down',
								'preview'         => array(
		                            'type'            => 'css',
									'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
		                            'property'        => 'border-bottom-width',
		                            'unit'            => 'px'
		                        )
                    		),
                            'left' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Left', 'bb-powerpack'),
                                'tooltip'       => __('Left', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-left',
								'preview'         => array(
		                            'type'            => 'css',
									'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
		                            'property'        => 'border-left-width',
		                            'unit'            => 'px'
		                        )
                    		),
                            'right' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Right', 'bb-powerpack'),
                                'tooltip'       => __('Right', 'bb-powerpack'),
                    			'icon'		=> 'fa-long-arrow-right',
								'preview'         => array(
		                            'type'            => 'css',
									'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
		                            'property'        => 'border-right-width',
		                            'unit'            => 'px'
		                        )
                    		),
                    	)
                    ),
                    'border_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.pp-advanced-menu .menu > li > a, .pp-advanced-menu .menu > li > .pp-has-submenu-container > a',
							'property'        => 'border-color',
						)
                    ),
                )
            ),
			'submenu_style'	=> array(
				'title'		=> __( 'Sub Menu', 'bb-powerpack' ),
				'fields'	=> array(
					'submenu_width'		=> array(
						'type'				=> 'unit',
						'label'				=> __('Submenu Minimum Width', 'bb-powerpack'),
						'default'			=> '220',
						'slider'			=> true,
						'units'				=> array('px'),
						'help'				=> __('Minimum width of sub-menu for desktop. Default width is 220px.', 'bb-powerpack')
					),
					'submenu_spacing' => array(
						'type'          => 'unit',
						'label'         => __( 'Submenu Spacing', 'bb-powerpack' ),
						'default'       => '0',
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'      	=> array(
							'type'         	=> 'css',
							'selector'		=> 'ul.sub-menu',
							'property'		=> 'padding',
							'unit'			=> 'px'
						),
					),
					'submenu_container_border'	=> array(
						'type'				=> 'border',
						'label'				=> __('Container Border', 'bb-powerpack'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.sub-menu'
						)
					),
					'submenu_container_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Container Background Color', 'bb-powerpack'),
                        'default'    => '',
                        'show_reset' => true,
						'preview'         => array(
							'type'            => 'css',
							'selector'        => 'ul.sub-menu',
							'property'        => 'background-color',
						),
						'help'		=> __('You can set sub-menu container background color if you are using mega menu.', 'bb-powerpack')
                    ),
					'submenu_background_color' => array(
                        'type'       	=> 'color',
                        'label'      	=> __('Link Background Color', 'bb-powerpack'),
                        'default'    	=> '',
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.sub-menu > li > a, .sub-menu > li > .pp-has-submenu-container > a',
							'property'        => 'background-color',
						)
                    ),
                    'submenu_background_hover_color' => array(
                        'type'       	=> 'color',
                        'label'      	=> __('Link Background Hover Color', 'bb-powerpack'),
                        'default'    	=> '',
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.sub-menu > li > a:hover, .sub-menu > li > a:focus, .sub-menu > li > .pp-has-submenu-container > a:hover, .sub-menu > li > .pp-has-submenu-container > a:focus',
							'property'        => 'background-color',
						)
                    ),
					'submenu_link_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.sub-menu > li > a, .sub-menu > li > .pp-has-submenu-container > a',
							'property'        => 'color',
						)
                    ),
                    'submenu_link_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Hover Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.sub-menu > li > a:hover, .sub-menu > li > a:focus, .sub-menu > li > .pp-has-submenu-container > a:hover, .sub-menu > li > .pp-has-submenu-container > a:focus',
							'property'        => 'color',
						)
					),
					'submenu_link_padding'		=> array(
						'type'			=> 'dimension',
						'label'			=> __('Link Padding', 'bb-powerpack'),
						'default'		=> 10,
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.sub-menu > li > a, .sub-menu > li > .pp-has-submenu-container > a',
							'property'      => 'padding',
							'unit'          => 'px'
						)
					),
					'submenu_border_style' => array(
                        'type'          => 'pp-switch',
                        'label'         => __('Link Separator Style', 'bb-powerpack'),
                        'default'       => 'solid',
                        'options'       => array(
                            'solid'        => __('Solid', 'bb-powerpack'),
                            'dashed'       => __('Dashed', 'bb-powerpack'),
                            'double'       => __('Double', 'bb-powerpack'),
                            'dotted'       => __('Dotted', 'bb-powerpack'),
                        ),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.sub-menu > li > a, .sub-menu > li > .pp-has-submenu-container > a',
							'property'        => 'border-style',
						)
                    ),
                    'submenu_border_size'    => array(
						'type' 					=> 'unit',
						'label' 				=> __('Link Separator Size', 'bb-powerpack'),
						'units' 				=> array('px'),
						'slider'				=> true,
						'preview'         		=> array(
							'type'            		=> 'css',
							'selector'        		=> '.sub-menu > li > a, .sub-menu > li > .pp-has-submenu-container > a',
							'property'        		=> 'border-bottom-width',
							'unit'			  		=> 'px'
						),
						'responsive' => array(
							'placeholder' => array(
								'default' => '1',
								'medium' => '',
								'responsive' => '',
							),
						),
                    ),
                    'submenu_border_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Separator Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.sub-menu > li > a, .sub-menu > li > .pp-has-submenu-container > a',
							'property'        => 'border-color',
						)
                    ),
				)
			),
        )
    ),
	'responsive_style'	=> array(
		'title'	=> __('Responsive', 'bb-powerpack'),
		'sections'	=> array(
			'responsive_container'	=> array(
				'title'	=> __( 'Container', 'bb-powerpack' ),
				'fields'	=> array(
					'responsive_alignment'    => array(
                        'type'          => 'align',
                        'label'         => __('Horizontal Alignment', 'bb-powerpack'),
                        'default'       => 'center',
                    ),
                    'responsive_alignment_vertical' => array(
                        'type'  => 'pp-switch',
                        'label' => __('Vertical Alignment', 'bb-powerpack'),
                        'default'   => 'top',
                        'options'   => array(
                            'top'       => __('Top', 'bb-powerpack'),
                            'center'    => __('Center', 'bb-powerpack')
                        )
					),
					'responsive_toggle_alignment'	=> array(
						'type'          => 'pp-switch',
                        'label'         => __('Hamburger Icon Alignment', 'bb-powerpack'),
                        'default'       => 'default',
                        'options'       => array(
							'default'		=> __('Default', 'bb-powerpack'),
                            'left'         	=> __('Left', 'bb-powerpack'),
                            'center'        => __('Center', 'bb-powerpack'),
                            'right'        	=> __('Right', 'bb-powerpack'),
                        ),
					),
					'responsive_overlay_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'	 => array(
							'type'		=> 'css',
							'selector'	=> '.pp-advanced-menu .pp-menu-overlay, .pp-advanced-menu .pp-off-canvas-menu',
							'property'	=> 'background-color'
						)
                    ),
					'responsive_overlay_bg_opacity'    => array(
                        'type'          => 'text',
                        'label'         => __( 'Background Opacity', 'bb-powerpack' ),
                        'placeholder'   => '50',
						'default'		=> '80',
                        'size'          => '8',
                        'description'   => '%',
					),
					'responsive_overlay_padding'		=> array(
						'type'			=> 'dimension',
						'label'			=> __('Padding', 'bb-powerpack'),
						'default'		=> 50,
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-advanced-menu.full-screen .pp-menu-overlay, .pp-advanced-menu.off-canvas .menu',
							'property'      => 'padding',
							'unit'          => 'px'
						)
					),
				),
			),
			'responsive_colors'	=> array(
				'title'			=> __('Links', 'bb-powerpack'),
				'fields'		=> array(
					'responsive_link_color' => array(
						'type'       => 'color',
						'label'      => __('Link Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'	 => array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-advanced-menu.full-screen .menu li a, .pp-advanced-menu.full-screen .menu li .pp-has-submenu-container a, .pp-advanced-menu.off-canvas .menu li a, .pp-advanced-menu.off-canvas .menu li .pp-has-submenu-container a',
									'property'	=> 'color'
								),
								array(
									'selector'	=> '.pp-advanced-menu.off-canvas .pp-toggle-arrows .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-arrows .sub-menu .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-plus .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-plus .pp-menu-toggle:after,
									.pp-advanced-menu.off-canvas .pp-toggle-plus .sub-menu .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-plus .sub-menu .pp-menu-toggle:after, .pp-advanced-menu.full-screen .pp-toggle-arrows .pp-menu-toggle:before, .pp-advanced-menu.full-screen .pp-toggle-arrows .sub-menu .pp-menu-toggle:before,
									 .pp-advanced-menu.full-screen .pp-toggle-plus .pp-menu-toggle:before, .pp-advanced-menu.full-screen .pp-toggle-plus .pp-menu-toggle:after, .pp-advanced-menu.full-screen .pp-toggle-plus .sub-menu .pp-menu-toggle:before, .pp-advanced-menu.full-screen .pp-toggle-plus .sub-menu .pp-menu-toggle:after',
									'property'	=> 'border-color'
								)
							)
						)
					),
					'responsive_link_hover_color' => array(
						'type'       => 'color',
						'label'      => __('Link Hover Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'	 => array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-advanced-menu.full-screen .menu li a:hover, .pp-advanced-menu.full-screen .menu li a:focus, .pp-advanced-menu.full-screen .menu li .pp-has-submenu-container a:hover, .pp-advanced-menu.full-screen .menu li .pp-has-submenu-container a:focus, .pp-advanced-menu.off-canvas .menu li a:hover,
									.pp-advanced-menu.off-canvas .menu li a:focus, .pp-advanced-menu.off-canvas .menu li .pp-has-submenu-container a:hover, .pp-advanced-menu.off-canvas .menu li .pp-has-submenu-container a:focus',
									'property'	=> 'color'
								),
								array(
									'selector'	=> '.pp-advanced-menu.off-canvas .pp-toggle-arrows li:hover .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-arrows .sub-menu li:hover .pp-menu-toggle:before,
									.pp-advanced-menu.off-canvas .pp-toggle-plus li:hover .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-plus li:hover .pp-menu-toggle:after, .pp-advanced-menu.off-canvas .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:before, .pp-advanced-menu.off-canvas .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:after, .pp-advanced-menu.off-canvas .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:before,
									.pp-advanced-menu.off-canvas .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:after, .pp-advanced-menu.full-screen .pp-toggle-arrows li:hover .pp-menu-toggle:before, .pp-advanced-menu.full-screen .pp-toggle-arrows .sub-menu li:hover .pp-menu-toggle:before, .pp-advanced-menu.full-screen .pp-toggle-plus li:hover .pp-menu-toggle:before,
									.pp-advanced-menu.full-screen .pp-toggle-plus li:hover .pp-menu-toggle:after, .pp-advanced-menu.full-screen .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:before, .pp-advanced-menu.full-screen .pp-toggle-plus .sub-menu li:hover .pp-menu-toggle:after',
									'property'	=> 'border-color'
								)
							)
						)
					),
					'responsive_link_bg_color'  => array(
						'type'       => 'color',
						'label'      => __('Link Background Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset' => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'    => array(
							'type'      => 'css',
							'selector'	=> '.pp-advanced-menu.full-screen .menu li a, .pp-advanced-menu.full-screen .menu li .pp-has-submenu-container a, .pp-advanced-menu.off-canvas .menu li a, .pp-advanced-menu.off-canvas .menu li .pp-has-submenu-container a',
							'property'	=> 'background-color'
						)
					),
					'responsive_link_bg_hover_color'  => array(
						'type'       => 'color',
						'label'      => __('Link Background Hover Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset' => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'responsive_link_padding'		=> array(
						'type'			=> 'dimension',
						'label'			=> __('Link Padding', 'bb-powerpack'),
						'default'		=> 10,
						'slider'		=> true,
						'units'			=> array('px'),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.pp-advanced-menu.full-screen .menu li a span.menu-item-text, .pp-advanced-menu.full-screen .menu li .pp-has-submenu-container a span.menu-item-text, .pp-advanced-menu.off-canvas .menu li a, .pp-advanced-menu.off-canvas .menu li .pp-has-submenu-container a',
							'property'      => 'padding',
							'unit'          => 'px'
						)
					),
					'responsive_submenu_bg_color'  => array(
						'type'       => 'color',
						'label'      => __('Submenu Background Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset' => true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'    => array(
							'type'      => 'none',
						)
					),
				)
			),
			'responsive_border'	=> array(
				'title'		=> __('Border', 'bb-powerpack'),
				'fields'	=> array(
					'responsive_link_border_width'		=> array(
						'type'			=> 'dimension',
						'label'			=> __('Link Border Width', 'bb-powerpack'),
						'default'		=> 0,
						'slider'		=> true,
						'units'			=> array('px'),
					),
					'responsive_link_border_color' => array(
						'type'       => 'color',
						'label'      => __('Link Border Color', 'bb-powerpack'),
						'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'	 => array(
							'type'		=> 'css',
							'selector'	=> '.pp-advanced-menu.full-screen .menu li a span.menu-item-text, .pp-advanced-menu.full-screen .menu li .pp-has-submenu-container a span.menu-item-text, .pp-advanced-menu.off-canvas .menu li a, .pp-advanced-menu.off-canvas .menu li .pp-has-submenu-container a',
							'property'	=> 'border-color'
						)
					),
				)
			),
			'menu_shadow'   => array(
                'title'         => __('Shadow', 'bb-powerpack'),
                'fields'        => array(
                    'enable_shadow'     => array(
                        'type'              => 'pp-switch',
                        'label'             => __('Enable Shadow', 'bb-powerpack'),
                        'default'           => 'no',
                        'options'           => array(
                            'yes'               => __('Yes', 'bb-powerpack'),
                            'no'                => __('No', 'bb-powerpack'),
                        ),
                        'toggle'            => array(
                            'yes'               => array(
                                'fields'            => array('menu_shadow', 'menu_shadow_color', 'menu_shadow_opacity')
                            )
                        )
                    ),
                    'menu_shadow' 		=> array(
                        'type'              => 'pp-multitext',
                        'label'             => __('Shadow', 'bb-powerpack'),
                        'default'           => array(
                            'vertical'			=> 0,
                            'horizontal'		=> 0,
                            'blur'				=> 10,
                            'spread'			=> 0
                        ),
                        'options'			=> array(
                            'horizontal'		=> array(
                                'placeholder'		=> __('Horizontal', 'bb-powerpack'),
                                'tooltip'			=> __('Horizontal', 'bb-powerpack'),
                                'icon'				=> 'fa-arrows-h'
                            ),
                            'vertical'			=> array(
                                'placeholder'		=> __('Vertical', 'bb-powerpack'),
                                'tooltip'			=> __('Vertical', 'bb-powerpack'),
                                'icon'				=> 'fa-arrows-v'
                            ),
                            'blur'				=> array(
                                'placeholder'		=> __('Blur', 'bb-powerpack'),
                                'tooltip'			=> __('Blur', 'bb-powerpack'),
                                'icon'				=> 'fa-circle-o'
                            ),
                            'spread'			=> array(
                                'placeholder'		=> __('Spread', 'bb-powerpack'),
                                'tooltip'			=> __('Spread', 'bb-powerpack'),
                                'icon'				=> 'fa-paint-brush'
                            ),
                        )
                    ),
                    'menu_shadow_color'     => array(
                        'type'                  => 'color',
                        'label'                 => __('Shadow Color', 'bb-powerpack'),
						'default'               => '000000',
						'connections'			=> array('color'),
                    ),
                    'menu_shadow_opacity'   => array(
                        'type'                  => 'text',
                        'label'                 => __('Shadow Opacity', 'bb-powerpack'),
                        'description'           => '%',
                        'size'                  => 5,
                        'default'               => 10,
                    ),
                )
            ),
			'mobile_toggle_style' => array(
				'title'	=> __( 'Mobile Toggle', 'bb-powerpack' ),
				'fields'	=> array(
					'mobile_toggle_size'    => array(
                        'type'          => 'unit',
                        'label'         => __( 'Size', 'bb-powerpack' ),
                        'placeholder'   => '30',
						'default'		=> '30',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'	 => array(
                            'type'		=> 'css',
                            'selector'	=> '.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box,
											.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner,
											.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:before,
											.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:after',
                            'property'	=> 'width',
							'unit'		=> 'px'
                        )
                    ),
					'mobile_toggle_thickness'    => array(
                        'type'          => 'unit',
                        'label'         => __( 'Thickness', 'bb-powerpack' ),
                        'placeholder'   => '4',
						'default'		=> '3',
                        'units'			=> array('px'),
						'slider'		=> true,
						'preview'	 => array(
                            'type'		=> 'css',
                            'selector'	=> '.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner,
											.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:before,
											.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:after',
                            'property'	=> 'height',
							'unit'		=> 'px'
                        )
                    ),
					 'mobile_toggle_color' => array(
                        'type'       => 'color',
                        'label'      => __('Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
                        'preview'	 => array(
                            'type'		=> 'css',
                            'rules'		=> array(
								array(
									'selector'	=> '.pp-advanced-menu-mobile-toggle',
                            		'property'	=> 'color'
								),
								array(
									'selector'	=> '.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner,
													.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:before,
													.pp-advanced-menu-mobile-toggle .pp-hamburger .pp-hamburger-box .pp-hamburger-inner:after',
                            		'property'	=> 'background-color'
								),
							)
                        )
                    ),
				)
			),
			'close_icon'	=> array(
				'title'		=> __('Close Icon', 'bb-powerpack'),
				'fields'	=> array(
					'close_icon_size'    => array(
                        'type'          => 'unit',
                        'label'         => __( 'Close Icon Size', 'bb-powerpack' ),
                        'placeholder'   => '30',
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'         => array(
							'type'            => 'css',
							'rules'			  => array(
								array(
									'selector'        => '.pp-advanced-menu.off-canvas .pp-off-canvas-menu .pp-menu-close-btn',
									'property'        => 'font-size',
									'unit'            => 'px'
								),
								array(
									'selector'        => '.pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn',
									'property'        => 'width',
									'unit'            => 'px'
								),
								array(
									'selector'        => '.pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn, .pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn:before, .pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn:after',
									'property'        => 'height',
									'unit'            => 'px'
								),
							)
						)
                    ),
                    'close_icon_color' => array(
                        'type'       => 'color',
                        'label'      => __('Close Icon Color', 'bb-powerpack'),
                        'default'    => '',
						'show_reset' => true,
						'connections'	=> array('color'),
						'preview'	 => array(
							'type'		=> 'css',
							'rules'		=> array(
								array(
									'selector'	=> '.pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn:before, .pp-advanced-menu .pp-menu-overlay .pp-menu-close-btn:after',
									'property'	=> 'background-color'
								),
								array(
									'selector'	=> '.pp-advanced-menu .pp-off-canvas-menu .pp-menu-close-btn',
									'property'	=> 'color'
								),
							)
						)
                    ),
				)
			)
		)
	),
    'typography'       => array( // Tab
        'title'         => __('Typography', 'bb-powerpack'), // Tab title
        'sections'      => array( // Tab Sections
            'link_typography' => array(
                'title' => __('Link', 'bb-powerpack' ),
                'fields'    => array(
					'link_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true
					),
                )
            ),
            'submenu_typography'    => array(
                'title'                 => __('Sub Menu', 'bb-powerpack'),
                'fields'                => array(
					'submenu_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true
					),
                )
            ),
			'mobile_toggle_typography' => array(
                'title' => __('Mobile Toggle', 'bb-powerpack' ),
                'fields'    => array(
                    'mobile_toggle_font'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'bb-powerpack'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.pp-advanced-menu-mobile-toggle'
                        )
                    ),
					'mobile_toggle_font_size'     => array(
                        'type'          => 'pp-switch',
						'label'         => __('Font Size', 'bb-powerpack'),
						'default'       => 'default',
						'options'       => array(
							'default'       => __('Default', 'bb-powerpack'),
							'custom'        => __('Custom', 'bb-powerpack')
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array('mobile_toggle_font_size_custom')
							)
						)
                    ),
					'mobile_toggle_font_size_custom' => array(
						'type' 			=> 'unit',
						'label' 		=> __('Custom Font Size', 'bb-powerpack'),
						'units' 		=> array('px'),
						'slider'		=> true,
						'preview' 		=> array(
							'type' 			=> 'css',
							'selector'		=> '.pp-advanced-menu-mobile-toggle',
							'property'		=> 'font-size',
							'unit' 			=> 'px'
						),
						'responsive' 	=> array(
							'placeholder' 	=> array(
								'default' 	=> '18',
								'medium' 	=> '',
								'responsive' => '',
							),
						),
					),
                )
            ),
        )
    ),
));

class Advanced_Menu_Walker extends Walker_Nav_Menu {

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $args   = ( object )$args;

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $submenu = $args->has_children ? ' pp-has-submenu' : '';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = ' class="' . esc_attr( $class_names ) . $submenu . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names . '>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
		$attributes .= ' tabindex="0" role="link"';

        $item_output = $args->has_children ? '<div class="pp-has-submenu-container">' : '';
        $item_output .= $args->before;
        $item_output .= '<a'. $attributes .'><span class="menu-item-text">';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if( $args->has_children ) {
			$item_output .= '<span class="pp-menu-toggle"></span>';
		}
		$item_output .= '</span>';
		if ( apply_filters( 'pp_advanced_menu_enable_item_description', false ) ) {
			$item_output .= '<p class="menu-item-description">' . $item->description . '</p>';
		}
		$item_output .= '</a>';


        $item_output .= $args->after;
        $item_output .= $args->has_children ? '</div>' : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}
