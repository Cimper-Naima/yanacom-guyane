<?php

$infolist_class = 'pp-infolist-wrap';
$title_tag = ( isset( $settings->title_tag ) ) ? $settings->title_tag : 'h3';
?>
<div class="<?php echo $infolist_class; ?>">
	<?php
	$number_items = count($settings->list_items);
	$layout = $settings->layouts;
	switch ( $layout ) {
		case '1': ?>
		<div class="pp-infolist layout-1">
			<ul class="layout-1-wrapper"> <?php
		for($i=0; $i < $number_items; $i++) :

			if(!is_object($settings->list_items[$i])) {
				continue;
			}

			$items = $settings->list_items[$i];
			$classes = '';
			if( $items->icon_animation ) {
				$classes = $items->icon_animation;
			}
			else {
				$classes = '';
			}
			?>
				<li class="pp-list-item pp-list-item-<?php echo $i; ?>">
					<?php if( $items->link_type == 'box' ) { ?>
						<a class="pp-more-link" href="<?php echo $items->link; ?>" target="<?php echo $items->link_target; ?>">
					<?php } ?>
						<div class="pp-icon-wrapper animated <?php echo $classes; ?>">
							<div class="pp-infolist-icon">
								<div class="pp-infolist-icon-inner">
									<?php if( $items->icon_type == 'icon' ) { ?>
										<span class="pp-icon <?php echo $items->icon_select; ?>"></span>
									<?php } else { ?>
										<?php if ( isset( $items->image_select_src ) && ! empty( $items->image_select_src ) ) { ?>
										<img src="<?php echo $items->image_select_src; ?>" alt="<?php echo get_the_title(absint($items->image_select)); ?>" />
										<?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="pp-heading-wrapper">
							<div class="pp-infolist-title">
								<?php if( $items->link_type == 'title' ) { ?>
									<a class="pp-more-link" href="<?php echo $items->link; ?>" target="<?php echo $items->link_target; ?>">
								<?php } ?>
								<<?php echo $title_tag; ?> class="pp-infolist-title-text"><?php echo $items->title; ?></<?php echo $title_tag; ?>>
								<?php if( $items->link_type == 'title' ) { ?>
									</a>
								<?php } ?>
							</div>
							<div class="pp-infolist-description">
								<?php echo $items->description; ?>
								<?php if( $items->link_type == 'read_more' ) { ?>
									<a class="pp-more-link" href="<?php echo $items->link; ?>" target="<?php echo $items->link_target; ?>"><?php echo $items->read_more_text; ?></a>
								<?php } ?>
							</div>
						</div>
						<div class="pp-list-connector"></div>
				<?php if( $items->link_type == 'box' ) { ?>
					</a>
				<?php } ?>
			</li> <?php
		endfor; ?>
		</ul>
	</div> <?php
			break;

		case '2': ?>
		<div class="pp-infolist layout-2">
			<ul class="layout-2-wrapper"> <?php
		for($i=0; $i < $number_items; $i++) :

			if(!is_object($settings->list_items[$i])) {
				continue;
			}

			$items = $settings->list_items[$i];
			$classes = '';
			if( $items->icon_animation ) {
				$classes = $items->icon_animation;
			}
			else {
				$classes = '';
			}
			?>
				<li class="pp-list-item pp-list-item-<?php echo $i; ?>">
					<?php if( $items->link_type == 'box' ) { ?>
						<a class="pp-more-link" href="<?php echo $items->link; ?>">
					<?php } ?>

						<div class="pp-heading-wrapper">
							<div class="pp-infolist-title">
								<?php if( $items->link_type == 'title' ) { ?>
									<a class="pp-more-link" href="<?php echo $items->link; ?>">
								<?php } ?>
								<<?php echo $title_tag; ?> class="pp-infolist-title-text"><?php echo $items->title; ?></<?php echo $title_tag; ?>>
								<?php if( $items->link_type == 'title' ) { ?>
									</a>
								<?php } ?>
							</div>
							<div class="pp-infolist-description">
								<?php echo $items->description; ?>
								<?php if( $items->link_type == 'read_more' ) { ?>
									<a class="pp-more-link" href="<?php echo $items->link; ?>"><?php echo $items->read_more_text; ?></a>
								<?php } ?>
							</div>
						</div>
						<div class="pp-icon-wrapper animated <?php echo $classes; ?>">
							<div class="pp-infolist-icon">
								<div class="pp-infolist-icon-inner">
									<?php if( $items->icon_type == 'icon' ) { ?>
										<span class="pp-icon <?php echo $items->icon_select; ?>"></span>
									<?php } else { ?>
										<img src="<?php echo wp_get_attachment_url( absint($items->image_select) ); ?>" alt="<?php echo get_the_title(absint($items->image_select)); ?>" />
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="pp-list-connector"></div>
				<?php if( $items->link_type == 'box' ) { ?>
					</a>
				<?php } ?>
			</li> <?php
		endfor; ?>
		</ul>
	</div> <?php
			break;


		case '3': ?>
		<div class="pp-infolist layout-3">
			<ul class="layout-3-wrapper"> <?php
				for($i=0; $i < $number_items; $i++) :

					if(!is_object($settings->list_items[$i])) {
						continue;
					}

					$items = $settings->list_items[$i];
					$classes = '';
					if( $items->icon_animation ) {
						$classes = $items->icon_animation;
					}
					else {
						$classes = '';
					}
					?>
					<li class="pp-list-item pp-list-item-<?php echo $i; ?>">
						<?php if( $items->link_type == 'box' ) { ?>
							<a class="pp-more-link" href="<?php echo $items->link; ?>">
						<?php } ?>
						<div class="pp-icon-wrapper animated <?php echo $classes; ?>">
							<div class="pp-infolist-icon">
								<div class="pp-infolist-icon-inner">
									<?php if( $items->icon_type == 'icon' ) { ?>
										<span class="pp-icon <?php echo $items->icon_select; ?>"></span>
									<?php } else { ?>
										<img src="<?php echo wp_get_attachment_url( absint($items->image_select) ); ?>" alt="<?php echo get_the_title(absint($items->image_select)); ?>" />
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="pp-infolist-title">
							<?php if( $items->link_type == 'title' ) { ?>
								<a class="pp-more-link" href="<?php echo $items->link; ?>">
							<?php } ?>
							<<?php echo $title_tag; ?> class="pp-infolist-title-text"><?php echo $items->title; ?></<?php echo $title_tag; ?>>
							<?php if( $items->link_type == 'title' ) { ?>
								</a>
							<?php } ?>
						</div>
						<div class="pp-infolist-description">
							<?php echo $items->description; ?>
							<?php if( $items->link_type == 'read_more' ) { ?>
								<a class="pp-more-link" href="<?php echo $items->link; ?>"><?php echo $items->read_more_text; ?></a>
							<?php } ?>
						</div>
						<div class="pp-list-connector"></div>
					<?php if( $items->link_type == 'box' ) { ?>
						</a>
					<?php } ?>
				</li> <?php
			endfor; ?>
		</ul>
	</div> <?php
		break;

		default: ?>
		<div class="pp-infolist layout-1">
			<ul class="layout-1-wrapper"> <?php
		for($i=0; $i < $number_items; $i++) :

			if(!is_object($settings->list_items[$i])) {
				continue;
			}

			$items = $settings->list_items[$i];
			$classes = '';
			if( $items->icon_animation ) {
				$classes = $items->icon_animation;
			}
			else {
				$classes = '';
			}
			?>
			<?php if( $items->link_type == 'box' ) { ?>
				<a class="pp-more-link" href="<?php echo $items->link; ?>">
			<?php } ?>
				<li class="pp-list-item pp-list-item-<?php echo $i; ?>">
					<div class="pp-icon-wrapper animated <?php echo $classes; ?>">
						<div class="pp-infolist-icon">
							<div class="pp-infolist-icon-inner">
								<?php if( $items->icon_type == 'icon' ) { ?>
									<span class="pp-icon <?php echo $items->icon_select; ?>"></span>
								<?php } else { ?>
									<img src="<?php echo wp_get_attachment_url( absint($items->image_select) ); ?>" alt="<?php echo get_the_title(absint($items->image_select)); ?>" />
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="pp-heading-wrapper">
						<div class="pp-infolist-title">
							<?php if( $items->link_type == 'title' ) { ?>
								<a class="pp-more-link" href="<?php echo $items->link; ?>">
							<?php } ?>
							<<?php echo $title_tag; ?> class="pp-infolist-title-text"><?php echo $items->title; ?></<?php echo $title_tag; ?>>
							<?php if( $items->link_type == 'title' ) { ?>
								</a>
							<?php } ?>
						</div>
						<div class="pp-infolist-description">
							<?php echo $items->description; ?>
							<?php if( $items->link_type == 'read_more' ) { ?>
								<a class="pp-more-link" href="<?php echo $items->link; ?>"><?php echo $items->read_more_text; ?></a>
							<?php } ?>
						</div>
						</div>

				<?php if( $items->link_type == 'box' ) { ?>
					</a>
				<?php } ?>
			</li> <?php
		endfor; ?>
		</ul>
	</div> <?php
			break;
	}
	?>

</div>
