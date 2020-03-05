<?php

/**
 * Post module alias for products on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-woo-products', array(
	'module'      => 'post-grid',
	'name'        => __( 'Products', 'fl-theme-builder' ),
	'description' => __( 'Displays a grid of products for the current archive.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'WooCommerce', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'         => 'columns',
		'match_height'   => '1',
		'data_source'    => 'main_query',
		'post_align'     => 'center',
		'show_author'    => '0',
		'show_date'      => '0',
		'show_content'   => '0',
		'woo_ordering'   => 'show',
		'woo_sale_flash' => 'show',
		'woo_rating'     => 'show',
		'woo_price'      => 'show',
		'woo_button'     => 'show',
		'border_type'    => 'none',
	),
) );
