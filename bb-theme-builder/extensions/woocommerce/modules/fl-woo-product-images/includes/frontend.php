<?php

global $product;

if ( is_object( $product ) && $product->is_on_sale() && $settings->sale_flash ) {
	echo FLPageDataWooCommerce::get_sale_flash();
}

echo FLPageDataWooCommerce::get_product_images();
