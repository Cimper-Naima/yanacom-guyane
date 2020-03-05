<?php

if ( 'short' == $settings->description_type ) {
	echo FLPageDataWooCommerce::get_product_short_description();
} else {
	echo FLPageDataPost::get_content();
}
