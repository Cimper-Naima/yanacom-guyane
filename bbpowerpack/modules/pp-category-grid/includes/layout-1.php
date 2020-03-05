<div class="<?php echo 'yes' === $settings->category_grid_slider ? 'swiper-slide' : ''; ?> pp-category pp-clear" title="<?php echo $cat->name; ?>">
	<?php
		$style       = 'style-0';
		$category_id = $cat->term_id;
	?>
		<div class="category-inner category-<?php echo $style; ?>">
			<a href="<?php echo $term_link; ?>" target="<?php echo $settings->category_link_target; ?>" class="pp-category__link">
				<div class="pp-category__img">
					<?php if ( is_array( $category_image ) && ! empty( $category_image ) ) { ?>
						<img src="<?php echo $category_image[0]; ?>" alt="<?php echo $cat->name; ?>">
						<?php
					} elseif ( ! empty( $settings->category_fallback_image ) && ! empty( $settings->category_fallback_image_src ) ) {
						?>
							<img src="<?php echo $settings->category_fallback_image_src; ?>" alt="<?php echo $cat->name; ?>">
						<?php
					} else {
						?>
							<img src="<?php echo BB_POWERPACK_URL; ?>images/placeholder-300.jpg" alt="<?php echo $cat->name; ?>">
					<?php } ?>
				</div>
				<div class="pp-category__content">
					<div class='pp-category__title_wrapper'>
						<?php if ( 'style-0' === $style ) { ?>
							<<?php echo $settings->category_title_tag; ?> class="pp-category__title">
								<?php echo $cat->name; ?>
							</<?php echo $settings->category_title_tag; ?>>
							<?php if ( 'yes' === $settings->category_show_counter ) { ?>
								<span class="pp-category-count">
									<?php $category_count_text = ( 0 === $cat->count || $cat->count > 1 ) ? $settings->category_count_text_plural : $settings->category_count_text; ?>
									<?php echo $cat->count; ?> <?php echo  $category_count_text; ?> </span>
							<?php } ?>
						<?php } ?>
					</div>
					<?php if ( 'yes' === $settings->category_show_description ) : ?>
						<div class='pp-category__description_wrapper'>
							<p class="pp-category__description"><?php echo $cat->category_description; ?></p>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $settings->category_show_button ) : ?>
						<div class="pp-category__button_wrapper">
							<button type="button" name="button" class="pp-category__button">
								<?php
								if ( '' !== $settings->category_button_text ) {
									echo $settings->category_button_text;
								} else {
									esc_html_e( 'Shop Now', 'bb-powerpack' );
								}
								?>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</a>
		</div>
</div>
