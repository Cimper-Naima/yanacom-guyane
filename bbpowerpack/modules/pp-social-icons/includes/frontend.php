<div class="pp-social-icons pp-social-icons-<?php echo $settings->align; ?> pp-social-icons-<?php echo $settings->direction; ?> pp-responsive-<?php echo $settings->responsive_align; ?>">
<?php
$icon_prefix = 'fa';
$email_icon_prefix = 'fa';
$rss_icon_prefix = 'fa';
$enabled_icons = $module->_enabled_icons;

if ( in_array( 'font-awesome-5-brands', $enabled_icons ) ) {
	$icon_prefix = 'fab';
}
if ( in_array( 'font-awesome-5-solid', $enabled_icons ) ) {
	$rss_icon_prefix = 'fas';
	$email_icon_prefix = 'fas';
}

$labels = $module->get_labels();

foreach ( $settings->icons as $icon ) {

	if ( ! is_object( $icon ) ) {
		continue;
	}
	$title = '';
	
	if ( isset( $labels[ $icon->icon ] ) ) {
		$title = $labels[ $icon->icon ];
	}
	if ( 'custom' == $icon->icon && isset( $icon->icon_custom_title ) ) {
		$title = $icon->icon_custom_title;
	}
	$link_target = isset($icon->link_target) ? $icon->link_target : '_blank';
	$link_nofollow = isset($icon->link_nofollow) ? $icon->link_nofollow : 'no';
	?>
	<span class="pp-social-icon" itemscope itemtype="http://schema.org/Organization">
		<link itemprop="url" href="<?php echo site_url(); ?>">
		<a itemprop="sameAs" href="<?php echo $icon->link; ?>" target="<?php echo $link_target; ?>"<?php echo isset( $labels[ $icon->icon ] ) ? ' title="' . $title . '" aria-label="' . $title . '"' : '' ; ?> role="button"<?php echo $module->get_rel($link_target, $link_nofollow); ?>>
			<?php if ( $icon->icon == 'custom' ) { ?>
				<i class="<?php echo $icon->icon_custom; ?>"></i>
			<?php } elseif ( 'fa-envelope' == $icon->icon ) { ?>
				<i class="<?php echo $email_icon_prefix; ?> <?php echo $icon->icon; ?>"></i>
			<?php } elseif ( 'fa-rss' == $icon->icon ) { ?>
				<i class="<?php echo $rss_icon_prefix; ?> <?php echo $icon->icon; ?>"></i>
			<?php } else { ?>
				<i class="<?php echo $icon_prefix; ?> <?php echo $icon->icon; ?>"></i>
			<?php } ?>
		</a>
	</span>
	<?php
}

?>
</div>
