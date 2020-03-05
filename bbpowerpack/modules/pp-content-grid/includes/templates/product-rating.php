<div class="pp-product-rating">
    <?php
    // Updated function woocommerce_get_template to wc_get_template
    // @since 1.2.7
    if( function_exists( 'wc_get_template' ) ) {
        wc_get_template('loop/rating.php');
    }
    ?>
</div>
