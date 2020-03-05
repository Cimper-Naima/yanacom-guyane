<?php if ( $settings->carousel_type == 'slideshow' ) : ?>
<div class="pp-thumbnails-swiper swiper-container pp-thumbs-ratio-<?php echo $settings->thumb_ratio; ?>">
	<div class="swiper-wrapper">
		<?php foreach($photos as $photo) : ?>
			<?php
				$photo_thumb_link = $photo->src;

				if ( isset( $photo->thumb_link ) && ! empty( $photo->thumb_link ) ) {
					$photo_thumb_link = $photo->thumb_link;
				}
			?>
			<div class="swiper-slide">
				<div class="pp-image-carousel-thumb" style="background-image:url(<?php echo $photo_thumb_link; ?>)"></div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>