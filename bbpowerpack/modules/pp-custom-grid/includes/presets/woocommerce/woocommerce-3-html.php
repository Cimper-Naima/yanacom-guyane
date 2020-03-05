[wpbb-if post:featured_image]
<div class="pp-custom-grid-post-image">
	[wpbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wpbb-if]

[wpbb-if post:woocommerce_sale_flash]
<div class="pp-custom-grid-product-sale">
	[wpbb post:woocommerce_sale_flash]
</div>
[/wpbb-if]

<div class="pp-custom-grid-post-text">

    <h2 class="pp-custom-grid-post-title">[wpbb post:link text="title"]</h2>

    <div class="pp-custom-grid-post-meta">
        <div class="pp-custom-grid-product-rating">
            [wpbb post:woocommerce_product_rating]
        </div>
        <div class="pp-custom-grid-product-price">
            [wpbb post:woocommerce_product_price]
        </div>
    </div>

    <div class="pp-custom-grid-product-button">
    	[wpbb post:woocommerce_add_to_cart_button]
    </div>

</div>
