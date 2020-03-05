<?php

/**

 * *******************************************************************
 *
 * Post Properties
 *********************************************************************/

/**
 * Product Title
 */
FLPageData::add_post_property( 'woocommerce_product_title', array(
	'label'  => __( 'Product Title', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_product_title',
) );

/**
 * Product Rating
 */
FLPageData::add_post_property( 'woocommerce_product_rating', array(
	'label'  => __( 'Product Rating', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_product_rating',
) );

/**
 * Product Price
 */
FLPageData::add_post_property( 'woocommerce_product_price', array(
	'label'  => __( 'Product Price', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataWooCommerce::get_product_price',
) );

/**
 * Product Short Description
 */
FLPageData::add_post_property( 'woocommerce_product_short_description', array(
	'label'  => __( 'Product Short Description', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataWooCommerce::get_product_short_description',
) );

/**
 * Product Meta
 */
FLPageData::add_post_property( 'woocommerce_product_meta', array(
	'label'  => __( 'Product Meta', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_product_meta',
) );
/**
 * Product Weight
 */
FLPageData::add_post_property( 'woocommerce_product_weight', array(
	'label'  => __( 'Product Weight', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataWooCommerce::get_product_weight',
) );

/**
 * Product SKU
 */
FLPageData::add_post_property( 'woocommerce_product_sku', array(
	'label'  => __( 'Product SKU', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataWooCommerce::get_product_sku',
) );

FLPageData::add_post_property_settings_fields( 'woocommerce_product_sku', array(
	'sku_prefix'  => array(
		'type'    => 'select',
		'label'   => __( 'Prefix Text', 'fl-theme-builder' ),
		'default' => '1',
		'options' => array(
			'0' => __( 'False', 'fl-theme-builder' ),
			'1' => __( 'True', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'1' => array(
				'fields' => array( 'prefix_text' ),
			),
		),
	),
	'prefix_text' => array(
		'type'    => 'text',
		'label'   => __( 'Prefix', 'fl-theme-builder' ),
		'default' => __( 'SKU:', 'fl-theme-builder' ),
	),
) );

/**
 * Product Images
 */
FLPageData::add_post_property( 'woocommerce_product_images', array(
	'label'  => __( 'Product Images', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_product_images',
) );

/**
 * Product Sale Flash
 */
FLPageData::add_post_property( 'woocommerce_sale_flash', array(
	'label'  => __( 'Product Sale', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_sale_flash',
) );

/**
 * Product Tabs
 */
FLPageData::add_post_property( 'woocommerce_product_tabs', array(
	'label'  => __( 'Product Tabs', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_product_tabs',
) );

/**
 * Product Upsells
 */
FLPageData::add_post_property( 'woocommerce_product_upsells', array(
	'label'  => __( 'Product Upsells', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_product_upsells',
) );

/**
 * Related Products
 */
FLPageData::add_post_property( 'woocommerce_related_products', array(
	'label'  => __( 'Related Products', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_related_products',
) );

/**
 * Add to Cart Button
 */
FLPageData::add_post_property( 'woocommerce_add_to_cart_button', array(
	'label'  => __( 'Add to Cart Button', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_add_to_cart_button',
) );

/**
 * Store Breadcrumbs
 */
FLPageData::add_post_property( 'woocommerce_breadcrumb', array(
	'label'  => __( 'Store Breadcrumbs', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_breadcrumb',
) );

/**

********************************************************************
 *
 * Archive Properties
 */

/**
 * Category Image URL
 */
FLPageData::add_archive_property( 'woocommerce_category_image_url', array(
	'label'  => __( 'Category Image', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'photo',
	'getter' => 'FLPageDataWooCommerce::get_category_image_url',
) );

FLPageData::add_archive_property_settings_fields( 'woocommerce_category_image_url', array(
	'size' => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
) );

/**
 * Product Result Count
 */
FLPageData::add_archive_property( 'woocommerce_result_count', array(
	'label'  => __( 'Product Result Count', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_result_count',
) );

/**
 * Product Ordering
 */
FLPageData::add_archive_property( 'woocommerce_catalog_ordering', array(
	'label'  => __( 'Product Ordering', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataWooCommerce::get_catalog_ordering',
) );

/**
 * Product Attached Images
 */
FLPageData::add_post_property( 'product_attached_images', array(
	'label'  => __( 'Product Gallery Images', 'fl-theme-builder' ),
	'group'  => 'woocommerce',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataWooCommerce::get_product_attached_images',
) );
