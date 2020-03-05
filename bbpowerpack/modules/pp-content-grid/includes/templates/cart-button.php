<div class="pp-add-to-cart">
    <?php if( $settings->post_type == 'product' ) {
		global $product;
        // Updated function woocommerce_get_template to wc_get_template
        // @since 1.2.7
        if( function_exists( 'wc_get_template' ) && is_object( $product ) ) {
            wc_get_template( 'loop/add-to-cart.php', array( 'product' => $product ) );
        }
    } ?>
    <?php  if( $settings->post_type == 'download' && class_exists( 'Easy_Digital_Downloads' ) ) {
        if (!edd_has_variable_prices(get_the_ID())) { ?>
            <?php echo edd_get_purchase_link(get_the_ID(), 'Add to Cart', 'button'); ?>
        <?php }
    } ?>
</div>
