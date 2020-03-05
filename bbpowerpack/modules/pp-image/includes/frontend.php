<?php

$photo    = $module->get_data();
$classes  = $module->get_classes();
$src      = $module->get_src();
$link     = $module->get_link();
$alt      = $module->get_alt();
$attrs    = $module->get_attributes();
$class = '';
if( 'hover' == $settings->show_caption ) {
	$class = 'pp-overlay-wrap';
}
?>
<div class="pp-photo-container">
	<div class="pp-photo<?php if ( ! empty( $settings->crop ) ) echo ' pp-photo-crop-' . $settings->crop ; ?> pp-photo-align-<?php echo $settings->align; ?> pp-photo-align-responsive-<?php echo $settings->align_responsive; ?>" itemscope itemtype="http://schema.org/ImageObject">
		<div class="pp-photo-content <?php echo $class; ?>">
			<div class="pp-photo-content-inner">
				<?php if(!empty($link)) : ?>
					<a href="<?php echo $link; ?>" target="<?php echo $settings->link_target; ?>" itemprop="url"<?php echo $module->get_rel(); ?>>
				<?php endif; ?>
						<img class="<?php echo $classes; ?>" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" itemprop="image" <?php echo $attrs; ?> />
						<div class="pp-overlay-bg"></div>
						<?php if($photo && !empty($photo->caption) && 'overlay' == $settings->show_caption) : ?>
							<div class="pp-photo-caption pp-photo-caption-overlay" itemprop="caption"><?php echo $photo->caption; ?></div>
						<?php endif; ?>
				<?php if(!empty($link)) : ?>
					</a>
				<?php endif; ?>
				<?php if($photo && !empty($photo->caption) && 'hover' == $settings->show_caption) : ?>
					<?php if(!empty($link)) : ?>
						<a href="<?php echo $link; ?>" target="<?php echo $settings->link_target; ?>" itemprop="url"<?php echo $module->get_rel(); ?>>
					<?php endif; ?>
					<div class="pp-photo-caption pp-photo-caption-hover" itemprop="caption" title="<?php echo $photo->caption; ?>"><?php echo $photo->caption; ?></div>
					<?php if(!empty($link)) : ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
				<?php if($photo && !empty($photo->caption) && 'below' == $settings->show_caption) : ?>
					<?php if(!empty($link)) : ?>
						<a href="<?php echo $link; ?>" target="<?php echo $settings->link_target; ?>" itemprop="url"<?php echo $module->get_rel(); ?>>
					<?php endif; ?>
					<div class="pp-photo-caption pp-photo-caption-below" itemprop="caption"><?php echo $photo->caption; ?></div>
					<?php if(!empty($link)) : ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
