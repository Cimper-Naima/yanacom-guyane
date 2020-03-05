<?php
	$enable_tabindex = false;
	$tabindex = -1;
	if ( isset( $settings->card_tabindex ) && 'yes' == $settings->card_tabindex ) {
		$enable_tabindex = true;
		$tabindex = 0;
		if ( isset( $settings->card_custom_tabindex ) && '' != $settings->card_custom_tabindex ) {
			$tabindex = $settings->card_custom_tabindex;
		}
	}
?>
<div class="fl-node-<?php echo $id; ?> pp-restaurant-menu-item-wrap">
	<h3 class="pp-restaurant-menu-heading"><?php echo $settings->menu_heading; ?></h3>
	<div class="pp-restaurant-menu-item-wrap-in">
		<?php
		foreach ( $settings->menu_items as $key => $menu_item ) {
			$item_title = '' != trim( $menu_item->menu_items_title ) ? trim( $menu_item->menu_items_title ) : '';
			$attr = '';

			if ( $enable_tabindex && $tabindex >= 0 ) {
				$attr .= ' tabindex="'.$tabindex.'"';
			}
			 
			if ( $settings->restaurant_menu_layout == 'stacked' ) {
			 	?>
			 	<div class="pp-restaurant-menu-item pp-restaurant-menu-item-<?php echo $key; ?> pp-menu-item pp-menu-item-<?php echo $key; ?>"<?php echo $attr; ?>>
				 	<?php if ( '' != trim( $menu_item->menu_item_images ) && 'yes' == $menu_item->restaurant_select_images ) { ?>
					 	<a <?php if ( '' != $menu_item->menu_items_link ) { ?>href="<?php echo $menu_item->menu_items_link;?>"<?php } ?> target="<?php echo $menu_item->menu_items_link_target;?>"<?php if('yes' == $menu_item->menu_items_link_nofollow){ echo " rel='nofollow'"; }else{ echo ''; } ?> class="pp-restaurant-menu-item-images">
							<?php
							$image = $menu_item->menu_item_images_src;
							?>
			   	 			<img src="<?php echo $image;?>" alt="<?php echo pp_get_image_alt($menu_item->menu_item_images, $item_title); ?>" />
						</a>
					<?php } ?>
					<div class="pp-restaurant-menu-item-left">
						<?php if ( '' != $item_title ) { ?>
							<h2 class="pp-restaurant-menu-item-header">
								<?php if ( '' != trim( $menu_item->menu_items_link ) ) { ?>
									<a href="<?php echo $menu_item->menu_items_link;?>" target="<?php echo $menu_item->menu_items_link_target;?>"<?php if('yes' == $menu_item->menu_items_link_nofollow){ echo " rel='nofollow'"; }else{ echo ''; } ?> class="pp-restaurant-menu-item-title"><?php echo $item_title; ?></a>
								<?php } else { ?>
									<span class="pp-restaurant-menu-item-title"><?php echo $item_title; ?></span>
								<?php } ?>
							</h2>
						<?php } ?>
						<?php if ( $settings->show_description == 'yes' ) { ?>
							<div class="pp-restaurant-menu-item-description">
								<?php echo $menu_item->menu_item_description; ?>
							</div>
						<?php } ?>
					</div>
					<div class="pp-restaurant-menu-item-right">
						<?php if ( '' != trim( $menu_item->menu_items_price ) && $settings->show_price == 'yes' ) { ?>
							<div class="pp-restaurant-menu-item-price">
								<span><?php echo $settings->currency_symbol; ?> </span> <?php echo $menu_item->menu_items_price; ?>
								<?php if ( '' != trim( $menu_item->menu_items_unit ) ) { ?>
									<span class="pp-menu-item-unit"> <?php echo trim( $menu_item->menu_items_unit ); ?></span>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php
			 	} else {
			 	?>
			 		<div class="pp-restaurant-menu-item-inline pp-restaurant-menu-item-inline-<?php echo $key; ?> pp-menu-item pp-menu-item-<?php echo $key; ?>"<?php echo $attr; ?>>
				 		<?php if ( '' != trim( $menu_item->menu_item_images ) && 'yes' == $menu_item->restaurant_select_images ) { ?>
				 			<a <?php if ( '' != $menu_item->menu_items_link ) { ?>href="<?php echo $menu_item->menu_items_link;?>"<?php } ?> target="<?php echo $menu_item->menu_items_link_target;?>"<?php if('yes' == $menu_item->menu_items_link_nofollow){ echo " rel='nofollow'"; }else{ echo ''; } ?> class="pp-restaurant-menu-item-images">
							<?php
							$image = $menu_item->menu_item_images_src;
							?>
			   	 			<img src="<?php echo $image;?>" alt="<?php echo pp_get_image_alt($menu_item->menu_item_images, $item_title); ?>" />
			   	 			</a>
			   	 		<?php } ?>
			   	 		<div class="pp-restaurant-menu-item-inline-right-content pp-menu-item-content">
			   	 			<?php if ( '' != $item_title ) { ?>
					   	 		<h2 class="pp-restaurant-menu-item-header">
									<?php if ( '' != trim($menu_item->menu_items_link) ) { ?>
										<a target="<?php echo $menu_item->menu_items_link_target;?>" href="<?php echo $menu_item->menu_items_link;?>"<?php if('yes' == $menu_item->menu_items_link_nofollow){ echo " rel='nofollow'"; }else{ echo ''; } ?> class="pp-restaurant-menu-item-title"><?php echo $item_title; ?></a>
									<?php } else { ?>
										<span class="pp-restaurant-menu-item-title"><?php echo $item_title; ?></span>
									<?php } ?>
								</h2>
							<?php } ?>
							<?php if ( $settings->show_description == 'yes' ) { ?>
								<div class="pp-restaurant-menu-item-description">
									<?php echo $menu_item->menu_item_description; ?>
								</div>
							<?php } ?>
						</div>
						<?php if ( '' != trim( $menu_item->menu_items_price ) && $settings->show_price == 'yes' ) { ?>
							<div class="pp-restaurant-menu-item-price">
								<span><?php echo $settings->currency_symbol; ?> </span> <?php echo $menu_item->menu_items_price; ?>
								<?php if ( '' != trim( $menu_item->menu_items_unit ) ) { ?>
									<span class="pp-menu-item-unit"> <?php echo trim( $menu_item->menu_items_unit ); ?></span>
								<?php } ?>
							</div>
						<?php } ?>
			 		</div>
			 	<?php
			 }
		?>
		<?php } ?>
	</div>
</div>
