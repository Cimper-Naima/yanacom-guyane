<?php
$rotating_text = str_replace( array("\r\n", "\n", "\r", "<br/>", "<br>"), '|', $settings->rotating_text );
?>

;(function($) {

    new PPAnimatedHeadlines({
        id: '<?php echo $id; ?>',
        headline_style: '<?php echo $settings->headline_style; ?>',
        rotating_text: '<?php echo str_replace("'", "\'", $rotating_text); ?>',
        highlighted_text: '<?php echo str_replace("'", "\'", $settings->highlighted_text ); ?>',
        headline_shape: '<?php echo $settings->headline_shape; ?>',
        animation_type: '<?php echo $settings->animation_type; ?>',
    });

})(jQuery);
