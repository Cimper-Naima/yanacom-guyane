<?php

$class = array( 'pp-instagram-feed' );
$attrs = array();
$attr = ' ';

$class[] = 'pp-instagram-feed-' . $settings->content_visibility;

if ( 'carousel' == $settings->feed_layout ) {
	$class[] = 'pp-instagram-feed-carousel';
} else {
	$class[] = 'pp-instagram-feed-grid';
}

if ( 'grid' == $settings->feed_layout && $settings->grid_columns ) {
	$class[] = 'pp-instagram-feed-' . $settings->grid_columns;
}

if ( 'yes' == $settings->image_hover_grayscale ) {
	$class[] = 'pp-instagram-feed-hover-gray';
}

$inner_class = array( 'pp-instagram-feed-inner' );
$feed_container_class = array();

if ( 'carousel' == $settings->feed_layout ) {
	$inner_class[] = 'swiper-container-wrap';
	$feed_container_class[] = 'swiper-container';
}

if ( 'yes' == $settings->infinite_loop ) {
	$attrs['data-loop'] = 1;
}

if ( 'yes' == $settings->grab_cursor ) {
	$attrs['data-grab-cursor'] = 1;
}

$attrs['data-layout'] = $settings->feed_layout;

foreach ( $attrs as $key => $value ) {
	$attr .= $key . '=' . $value . ' ';
}

?>
<div class="<?php echo implode( ' ', $class ); ?>"<?php echo $attr; ?>>
	<?php if ( 'yes' == $settings->profile_link ) { ?>
		<?php if ( ! empty( $settings->insta_link_title ) ) { ?>
			<span class="pp-instagram-feed-title-wrap">
				<a href="<?php echo $settings->insta_profile_url; ?>" target="_blank" rel="nofollow noopener">
					<span class="pp-instagram-feed-title">
						<?php if ( ! empty( $settings->insta_title_icon ) ) { ?>
							<?php if ( 'before_title' == $settings->insta_title_icon_position ) { ?>
								<span class="<?php echo $settings->insta_title_icon; ?>" aria-hidden="true"></span>
							<?php } ?>
						<?php } ?>
						<?php echo $settings->insta_link_title; ?>
						<?php if ( ! empty( $settings->insta_title_icon ) ) { ?>
							<?php if ( 'after_title' == $settings->insta_title_icon_position ) { ?>
								<span class="<?php echo $settings->insta_title_icon; ?>" aria-hidden="true"></span>
							<?php } ?>
						<?php } ?>
					</span>
				</a>
			</span>
		<?php } ?>
	<?php } ?>
	<div class="<?php echo implode( ' ', $inner_class ); ?>">
		<div class="<?php echo implode( ' ', $feed_container_class ); ?>">
			<div id="pp-instagram-<?php echo $id; ?>" class="pp-instagram-feed-items<?php if ( 'carousel' == $settings->feed_layout ) { ?> swiper-wrapper<?php } ?>">
			</div>
			<?php if ( 'carousel' == $settings->feed_layout ) : ?>
			<?php if ( 'yes' == $settings->pagination ) { ?>
			<!-- pagination -->
			<div class="swiper-pagination"></div>
			<?php } ?>

			<?php if ( 'yes' == $settings->navigation ) { ?>
			<!-- navigation arrows -->
			<div class="pp-swiper-button swiper-button-prev"><span class="fa fa-angle-left"></span></div>
			<div class="pp-swiper-button swiper-button-next"><span class="fa fa-angle-right"></span></div>
			<?php } ?>
		<?php endif; ?>
		</div>
	</div>
</div>
