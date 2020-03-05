<?php

/**********************************************************************
 *
 * Post Properties
 *
 *********************************************************************/

/**
 * Product Title
 */
FLPageData::add_post_property( 'edd_product_title', array(
	'label'  => __( 'Product Title', 'fl-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_title',
) );

/**
 * Product Price
 */
FLPageData::add_post_property( 'edd_product_price', array(
	'label'  => __( 'Product Price', 'fl-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_price',
) );

/**
 * Product Content
 */
FLPageData::add_post_property( 'edd_product_content', array(
	'label'  => __( 'Product Content', 'fl-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_content',
) );

/**
 * Product Short Description
 */
FLPageData::add_post_property( 'edd_product_short_description', array(
	'label'  => __( 'Product Short Description', 'fl-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_short_description',
) );

/**
 * Add to Cart Button
 */
FLPageData::add_post_property( 'edd_add_to_cart_button', array(
	'label'  => __( 'Add to Cart Button', 'fl-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'html',
	'getter' => 'FLPageDataEDD::get_add_to_cart_button',
) );
