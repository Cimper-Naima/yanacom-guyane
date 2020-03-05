<?php

$photos = $module->get_photos();

?>
<div class="pp-3d-slider pp-user-agent-<?php echo pp_get_user_agent(); ?>">
    <div class="pp-slider-wrapper">
        <?php if ( $photos ) : $target = ' target="' . $settings->link_target . '"'; ?>
            <?php foreach ( $photos as $photo ) :
                $url = $photo->url;
                $tag = 'div';
                $href = '';
                if ( $url && !empty( $url ) || 'yes' == $settings->lightbox ) {
					$tag = 'a';
					if ( 'yes' == $settings->lightbox ) {
						$href = ' href="'.$photo->link.'"';
					} else {
						$href = ' href="'.$url.'"';
					}
                }
				?>
                <<?php echo $tag . $href . $target; ?> class="pp-slide" data-caption="<?php echo $photo->caption; ?>">
                    <img class="pp-slider-img" src="<?php echo $photo->src; ?>" alt="<?php echo $photo->alt; ?>" />
                    <?php if ( 'yes' == $settings->show_captions ) { ?>
                        <div class="pp-slider-img-caption"><?php echo $photo->caption; ?></div>
                    <?php } ?>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if ( 'no' == $settings->autoplay ) { ?>
        <nav class="pp-slider-nav">
    		<span class="fa fa-angle-left pp-slider-prev"></span>
    		<span class="fa fa-angle-right pp-slider-next"></span>
    	</nav>
    <?php } ?>
</div>
