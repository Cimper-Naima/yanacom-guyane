<div class="pp-post-timeline-item slide-item clearfix">
	<span class="pp-separator-arrow"></span>
	<div class="pp-post-timeline-content">

		<?php if ( has_post_thumbnail() && $settings->show_image == 'yes' && $settings->image_position == 'above_header' ) { ?>
			<div class="pp-post-timeline-image above-header">
				<?php if ( 'thumb' == $settings->link_type || 'title_thumb' == $settings->link_type ) { ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php } ?>
						<?php the_post_thumbnail($settings->image_thumb_size); ?>
				<?php if ( 'thumb' == $settings->link_type || 'title_thumb' == $settings->link_type ) { ?>
					</a>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="pp-post-timeline-title-wrapper">
			<h3 class="pp-post-timeline-title" itemprop="headline">
				<?php if ( 'title' == $settings->link_type || 'title_thumb' == $settings->link_type ) { ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php } ?>
					<?php the_title(); ?>
				<?php if ( 'title' == $settings->link_type || 'title_thumb' == $settings->link_type ) { ?>
				</a>
				<?php } ?>
			</h3>

			<?php if( $settings->show_author == 'yes' || $settings->show_date == 'yes' || $settings->show_categories == 'yes' ) : ?>
			<div class="pp-post-timeline-meta">
				<?php if($settings->show_author == 'yes' ) : ?>
					<span class="pp-post-timeline-author">
						<?php

						printf(
							_x( 'By %s', '%s stands for author name.', 'bb-powerpack' ),
							'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '"><span>' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '</span></a>'
						);

						?>
					</span>
				<?php endif; ?>
				<?php if( $settings->show_date == 'yes' ) : ?>
					<?php if($settings->show_author == 'yes' ) : ?>
					<span> <?php echo $settings->meta_separator; ?> </span>
					<?php endif; ?>
					<span class="pp-post-timeline-date">
						<?php echo get_the_date(); ?>
					</span>
				<?php endif; ?>

				<?php if( ( ($settings->show_author == 'yes' && $settings->show_categories == 'yes') || ( $settings->show_author == 'no' && $settings->show_date == 'yes' && $settings->show_categories == 'yes' ) ) && taxonomy_exists($settings->post_taxonomies) && !empty($terms_list) ) : ?>
					<span> <?php echo $settings->meta_separator; ?> </span>
				<?php endif; ?>

				<?php if($settings->show_categories == 'yes') : ?>
					<span class="pp-content-post-category">
						<?php if(taxonomy_exists($settings->post_taxonomies)) { ?>
							<?php $i = 1;
							foreach ($terms_list as $term):
								?>
							<?php if( $i == count($terms_list) ) { ?>
								<?php echo $term->name; ?>
							<?php } else { ?>
								<?php echo $term->name . ' /'; ?>
							<?php } ?>
							<?php $i++; endforeach; ?>
						<?php } ?>
					</span>
				<?php endif; ?>

			</div>
			<?php endif; ?>
		</div>

		<?php if ( has_post_thumbnail() && $settings->show_image == 'yes' && $settings->image_position == 'below_header' ) { ?>
			<div class="pp-post-timeline-image below-header">
					<?php the_post_thumbnail($settings->image_thumb_size); ?>
			</div>
		<?php } ?>

		<?php if($settings->show_content == 'yes' || $settings->show_button == 'yes') : ?>
			<div class="pp-post-timeline-text-wrapper">
				<div class="pp-post-timeline-text">

					<?php
					if($settings->show_content == 'yes') :

						if ( $settings->content_type == 'excerpt' ) :
							the_excerpt();
						endif;
						if ( $settings->content_type == 'content' ) :
							$more = '...';
							echo wp_trim_words( get_the_content(), $settings->content_length, apply_filters( 'pp_pt_content_limit_more', $more ) );
						endif;
						if ( $settings->content_type == 'full' ) :
							the_content();
						endif;

					endif;
					?>

					<?php if( $settings->button_text != '' && $settings->show_button == 'yes' ) : ?>
						<div class="pp-post-timeline-read-more">
							<a class="pp-post-timeline-button" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings->button_text; ?></a>
						</div>
					<?php endif; ?>

				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
