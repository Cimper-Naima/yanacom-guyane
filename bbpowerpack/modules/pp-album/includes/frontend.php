<?php

// Album Cover classes and attr.
$album_class	= 'pp-album';
$album_data		= 'bata-id="pp-album-' . $id . '"';

if ( 'album_cover' === $settings->trigger_on ) {
	$album_class	.= ' pp-album-cover-wrap pp-ins-filter-hover';
}

if ( 'bottom' === $settings->thumbs_position ) {
	$album_data		.= ' data-fancybox-class="pp-fancybox-thumbs-x" data-fancybox-axis="x"';
} else {
	$album_data		.= ' data-fancybox-class="pp-fancybox-thumbs-y" data-fancybox-axis="y"';
}

// Album Cover Image.
if ( isset( $settings->first_img_size ) ) {
	$first_size = $settings->first_img_size;
}else{
	$first_size = 'full';
}
if ( ! empty( $settings->gallery_photos ) ) {
	if ( 'first_img' == $settings->cover_img ) {
		$first_img_url = wp_get_attachment_image_src( $settings->gallery_photos[0], $first_size );
	} else {
		$first_img_url = array( $settings->custom_cover_src );
	}
} else {
	$first_img_url = array( BB_POWERPACK_URL . 'images/placeholder-600.jpg' );
}

// Button Type.
if ( 'text' === $settings->cover_btn_type ) {
	$button_content = '<span>' . $settings->cover_btn_text . '</span>';
} elseif ( 'icon' == $settings->cover_btn_type ) {
	$button_content = '<i class="' . $settings->cover_btn_icon . '"></i>';
} else {
	$button_content = '<span>' . $settings->cover_btn_text . '</span>';
	$button_content .= '<i class="' . $settings->cover_btn_icon . '"></i>';
}
?>

<div class="pp-album-container">
	<div class="pp-album-container-wrap<?php echo 'button' == $settings->trigger_on ? ' pp-trigger-button' : '';?>">
		<div class="<?php echo $album_class;?>" <?php echo $album_data;?>>
			<?php if ( 'album_cover' === $settings->trigger_on ) { ?>
			<a class="pp-clickable pp--album-<?php echo $id; ?>">
				<div class="pp-album-cover pp-ins-filter-target">
					<img src="<?php echo $first_img_url[0]; ?>" alt="">
					<div class="pp-album-cover-overlay"></div>
					<?php if ( 'show' === $settings->cover_content ) { ?>
						<div class="pp-album-content-wrap">
							<div class="pp-album-content<?php echo ('yes' === $settings->content_button) ? ' pp-album-cover-button-position-' . $settings->content_button_pos : ''; ?>">
								<div class="pp-album-content-inner">
									<?php if ( ! empty( $settings->content_icon ) ) { ?>
										<div class="pp-album-icon <?php echo $settings->content_icon; ?>"></div>
									<?php } ?>
									<?php if ( ! empty( $settings->content_title ) ) { ?>
										<<?php echo $settings->title_html_tag;?> class="pp-album-title"><?php echo $settings->content_title;?></<?php echo $settings->title_html_tag; ?>>
									<?php } ?>
									<?php if ( ! empty( $settings->content_subtitle ) ) { ?>
										<<?php echo $settings->subtitle_html_tag;?> class="pp-album-subtitle"><?php echo $settings->content_subtitle;?></<?php echo $settings->subtitle_html_tag; ?>>
									<?php } ?>
								</div>
								<?php if ( 'yes' == $settings->content_button ) { ?>
									<div class="pp-album-cover-button-wrap">
										<?php echo $settings->content_button_text; ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</a>
			<?php } else { ?>
			<div class="pp-album-trigger-button-wrap">
				<a class="pp-album-trigger-button pp--album-<?php echo $id; ?>">
					<div class="pp-album-button-content pp-album-button-<?php echo $settings->cover_btn_align; ?><?php echo 'icon_text' == $settings->cover_btn_type ? ' pp-button-icon_text pp-icon-' . $settings->icon_position : '';?>">
						<div  class="pp-album-button-inner">
							<?php echo $button_content; ?>
						</div>
					</div>
				</a>
			</div>
			<?php } // End if(). ?>
			<div class="pp-album-gallery">
				<?php
				if ( isset( $settings->gallery_photos ) && ! empty( $settings->gallery_photos ) ) {
					foreach ( $settings->gallery_photos as $index => $photo_id ) {
						// Caption / Title
						if ( 'caption' === $settings->lightbox_caption ) {
							$data_caption = wp_get_attachment_caption( $photo_id );
						} elseif ( 'title' === $settings->lightbox_caption ) {
							$data_caption = get_the_title( $photo_id );
						} else {
							$data_caption = '';
						}
						$src = wp_get_attachment_image_src( $photo_id, '' ); ?>
						<a class="pp-album-image pp-album-<?php echo ($index + 1);?> pp-album-<?php echo $id; ?>" href="<?php echo $src[0];?>" data-fancybox="pp-album-<?php echo $id;?>" <?php echo '' != $settings->lightbox_caption ? 'data-caption="' . $data_caption . '"' : '';?>>
							<img src="<?php echo $src[0];?>" alt="" />
						</a>
					<?php }
				} else { ?>
					<a class="pp-album-image pp-album-1 pp-album-<?php echo $id; ?>" href="<?php BB_POWERPACK_URL . 'images/placeholder-600.jpg';?>" data-fancybox="pp-album-<?php echo $id;?>">
						<img src="<?php BB_POWERPACK_URL . 'images/placeholder-600.jpg';?>" alt="" />
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
