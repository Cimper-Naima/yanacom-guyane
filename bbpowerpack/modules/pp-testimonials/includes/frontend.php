<?php
$testimonials = $settings->testimonials;

if ( isset( $settings->order ) ) {
	if( 'random' == $settings->order ) {
		shuffle( $testimonials );
	}

	if( 'desc' == $settings->order ) {
		krsort( $testimonials );
	}
}

$testimonials_class = 'pp-testimonials-wrap';

if($settings->heading == '') {
	$testimonials_class .= ' pp-testimonials-no-heading';
}
?>
<div class="<?php echo $testimonials_class; ?>">
	<?php if( $settings->testimonial_layout == '4' ) { ?>
		<div class="layout-4-container <?php echo ( $settings->carousel == 1 ) ? 'carousel-enabled' : ''; ?>">
	<?php } ?>
	<?php if ( $settings->heading != '' ) { ?>
		<h2 class="pp-testimonials-heading"><?php echo $settings->heading; ?></h2>
	<?php } ?>
	<?php if ( $settings->arrows ) { ?>
	<div class="pp-arrow-wrapper">
		<div class="pp-slider-prev pp-slider-nav"></div>
		<div class="pp-slider-next pp-slider-nav"></div>
	</div>
	<?php } ?>
	<div class="pp-testimonials">
		<?php
		$layout = $settings->testimonial_layout;

		$number_testimonials = count($testimonials);

		$classes = '';
		if( ($settings->carousel == 1) ) {
			$classes = 'carousel-enabled';
		}
		else {
			$classes = '';
		}

		switch ( $layout ) {
			case '1':
			foreach( $testimonials as $testimonial ) :

				if ( ! is_object( $testimonial ) ) {
					continue;
				}

				?>
				<div class="pp-testimonial layout-1 <?php echo $classes; ?>">
					<?php if( $testimonial->photo ) { ?>
						<div class="pp-testimonials-image">
							<img src="<?php echo $testimonial->photo_src; ?>" alt="<?php echo $module->get_alt($testimonial); ?>" />
						</div>
					<?php } ?>
					<div class="pp-content-wrapper">
						<?php if( $settings->show_arrow == 'yes' ) { ?><div class="pp-arrow-top"></div><?php } ?>
						<?php if( $testimonial->testimonial ) { ?>
							<div class="pp-testimonials-content"><?php echo $testimonial->testimonial; ?></div>
						<?php } ?>
						<?php if( $testimonial->title || $testimonial->subtitle ) { ?>
							<div class="pp-title-wrapper">
								<?php if( $testimonial->title ) { ?>
									<h3 class="pp-testimonials-title"><?php echo $testimonial->title; ?></h3>
								<?php } ?>
								<?php if( $testimonial->subtitle ) { ?>
									<h4 class="pp-testimonials-subtitle"><?php echo $testimonial->subtitle; ?></h4>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php endforeach;
			break;

			case '2':
			foreach( $testimonials as $testimonial ) :

				if ( ! is_object( $testimonial ) ) {
					continue;
				}

				?>
				<div class="pp-testimonial layout-2 <?php echo $classes; ?>">
					<?php if( $testimonial->testimonial ) { ?>
						<div class="pp-content-wrapper">
							<div class="pp-testimonials-content"><?php echo $testimonial->testimonial; ?></div>
							<?php if( $settings->show_arrow == 'yes' ) { ?><div class="pp-arrow-bottom"></div><?php } ?>
						</div>
					<?php } ?>
					<div class="pp-vertical-align">
						<?php if( $testimonial->photo ) { ?>
							<div class="pp-testimonials-image">
								<img src="<?php echo $testimonial->photo_src; ?>" alt="<?php echo $module->get_alt($testimonial); ?>" />
							</div>
						<?php } ?>
						<?php if( $testimonial->title || $testimonial->subtitle ) { ?>
							<div class="pp-title-wrapper">
								<?php if( $testimonial->title ) { ?>
									<h3 class="pp-testimonials-title"><?php echo $testimonial->title; ?></h3>
								<?php } ?>
								<?php if( $testimonial->subtitle ) { ?>
									<h4 class="pp-testimonials-subtitle"><?php echo $testimonial->subtitle; ?></h4>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php endforeach;
			break;

			case '3':
			foreach( $testimonials as $testimonial ) :

				if ( ! is_object( $testimonial ) ) {
					continue;
				}

				?>
				<div class="pp-testimonial layout-3 <?php echo $classes; ?> clearfix">
					<?php if( $testimonial->photo ) { ?>
						<div class="pp-testimonials-image">
							<img src="<?php echo $testimonial->photo_src; ?>" alt="<?php echo $module->get_alt($testimonial); ?>" />
						</div>
					<?php } ?>
					<div class="layout-3-content pp-content-wrapper">
						<?php if( $settings->show_arrow == 'yes' ) { ?><div class="pp-arrow-left"></div><?php } ?>
						<?php if( $testimonial->testimonial ) { ?>
							<div class="pp-testimonials-content"><?php echo $testimonial->testimonial; ?></div>
						<?php } ?>
						<?php if( $testimonial->title || $testimonial->subtitle ) { ?>
							<div class="pp-title-wrapper">
								<?php if( $testimonial->title ) { ?>
									<h3 class="pp-testimonials-title"><?php echo $testimonial->title; ?></h3>
								<?php } ?>
								<?php if( $testimonial->subtitle ) { ?>
									<h4 class="pp-testimonials-subtitle"><?php echo $testimonial->subtitle; ?></h4>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php endforeach;
			break;

			case '4':
			foreach( $testimonials as $testimonial ) :

				if ( ! is_object( $testimonial ) ) {
					continue;
				}

				?>
				<div class="pp-testimonial layout-4 <?php echo $classes; ?> <?php echo (!$testimonial->photo) ? 'no-image-inner' : ''; ?>">
					<?php if( $testimonial->photo ) { ?>
						<div class="pp-testimonials-image">
							<img src="<?php echo $testimonial->photo_src; ?>" alt="<?php echo $module->get_alt($testimonial); ?>" />
						</div>
					<?php } ?>
					<div class="layout-4-content">
						<?php if( $testimonial->testimonial ) { ?>
							<div class="pp-testimonials-content"><?php echo $testimonial->testimonial; ?></div>
						<?php } ?>
						<?php if( $testimonial->title || $testimonial->subtitle ) { ?>
							<div class="pp-title-wrapper">
								<?php if( $testimonial->title ) { ?>
									<h3 class="pp-testimonials-title"><?php echo $testimonial->title; ?></h3>
								<?php } ?>
								<?php if( $testimonial->subtitle ) { ?>
									<h4 class="pp-testimonials-subtitle"><?php echo $testimonial->subtitle; ?></h4>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php endforeach;
			break;

			case '5':
			foreach( $testimonials as $testimonial ) :

				if ( ! is_object( $testimonial ) ) {
					continue;
				}

				?>
				<div class="pp-testimonial layout-5 <?php echo $classes; ?>">
					<div class="pp-vertical-align">
						<?php if( $testimonial->title || $testimonial->subtitle ) { ?>
							<div class="pp-title-wrapper">
								<?php if( $testimonial->title ) { ?>
									<h3 class="pp-testimonials-title"><?php echo $testimonial->title; ?></h3>
								<?php } ?>
								<?php if( $testimonial->subtitle ) { ?>
									<h4 class="pp-testimonials-subtitle"><?php echo $testimonial->subtitle; ?></h4>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<?php if( $testimonial->testimonial ) { ?>
						<div class="pp-content-wrapper">
							<?php if( $settings->show_arrow == 'yes' ) { ?><div class="pp-arrow-top"></div><?php } ?>
							<div class="pp-testimonials-content"><?php echo $testimonial->testimonial; ?></div>
						</div>
					<?php } ?>
				</div>
			<?php endforeach;
			break;

			default:
			foreach( $testimonials as $testimonial ) :

				if ( ! is_object( $testimonial ) ) {
					continue;
				}

				?>
				<div class="pp-testimonial layout-1 <?php echo $classes; ?>">
					<?php if( $testimonial->photo ) { ?>
						<div class="pp-testimonials-image">
							<img src="<?php echo $testimonial->photo_src; ?>" alt="<?php echo $module->get_alt($testimonial); ?>" />
						</div>
					<?php } ?>
					<?php if( $testimonial->testimonial ) { ?>
						<div class="pp-testimonials-content"><?php echo $testimonial->testimonial; ?></div>
					<?php } ?>
					<?php if( $testimonial->title || $testimonial->subtitle ) { ?>
						<div class="pp-title-wrapper">
							<?php if( $testimonial->title ) { ?>
								<h3 class="pp-testimonials-title"><?php echo $testimonial->title; ?></h3>
							<?php } ?>
							<?php if( $testimonial->subtitle ) { ?>
								<h4 class="pp-testimonials-subtitle"><?php echo $testimonial->subtitle; ?></h4>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			<?php endforeach;
			break;
		} ?>

	</div>
	<?php if( $settings->testimonial_layout == '4' ) { ?>
	</div>
	<?php } ?>
</div>
