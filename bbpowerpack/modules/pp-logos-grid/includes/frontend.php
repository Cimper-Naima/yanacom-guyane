<div class="pp-logos-content clearfix">
    <div class="pp-logos-wrapper clearfix">
		<?php
		for($i=0; $i < count($settings->logos_grid); $i++) {

			if(!is_object($settings->logos_grid[$i])) {
				continue;
			}

			$logos_grid = $settings->logos_grid[$i];
			$alt = $logos_grid->upload_logo_title;

			if ( empty( $alt ) ) {
				$alt = get_post_meta( $logos_grid->upload_logo_grid, '_wp_attachment_image_alt', true );
				if ( empty( $alt ) && isset( $logos_grid->upload_logo_grid_src ) ) {
					$alt = $logos_grid->upload_logo_grid_src;
				}
			}

		?>
		<div class="pp-logo pp-logo-<?php echo $i; ?>">
        <?php if ( $logos_grid->upload_logo_link != '' ) { ?>
            <a href="<?php echo $logos_grid->upload_logo_link; ?>" target="<?php echo $settings->upload_logo_link_target; ?>"<?php echo $module->get_rel(); ?>>
        <?php } ?>
            <div class="pp-logo-inner">
                <div class="pp-logo-inner-wrap">
                    <?php if( $logos_grid->upload_logo_grid ) { ?>
						<div class="logo-image-wrapper">
                        	<img class="logo-image" src="<?php echo $logos_grid->upload_logo_grid_src; ?>" alt="<?php echo $alt; ?>" data-no-lazy="1" />
						</div>
                    <?php } ?>
                    <?php if( $logos_grid->upload_logo_title ) { ?>
                        <div class="title-wrapper">
                            <p class="logo-title">
                                <?php echo $logos_grid->upload_logo_title; ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if ( $logos_grid->upload_logo_link != '' ) { ?>
                </a>
            <?php } ?>
		</div>
		<?php } ?>
	</div>
    <div class="logo-slider-next"></div>
	<div class="logo-slider-prev"></div>
</div>
