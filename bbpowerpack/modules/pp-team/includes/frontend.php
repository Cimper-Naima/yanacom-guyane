<?php

$photo    = $module->get_data();
$classes  = $module->get_classes();
$src      = '';
if ( '' != $settings->member_image ) {
	$src      = $module->get_src();
}
$link     = $module->get_link();
$alt      = $module->get_alt();
$attrs    = $module->get_attributes();
$filetype = pathinfo($src, PATHINFO_EXTENSION);

$icon_prefix = 'fa';
$email_icon_prefix = 'fa';
$enabled_icons = FLBuilderModel::get_enabled_icons();

if ( in_array( 'font-awesome-5-brands', $enabled_icons ) ) {
	$icon_prefix = 'fab';
}
if ( in_array( 'font-awesome-5-solid', $enabled_icons ) ) {
	$email_icon_prefix = 'fas';
}

?>
<div class="pp-member-wrapper">
    <?php if ( '' != $src ) { ?>
        <div class="pp-member-image pp-image-crop-<?php echo $settings->member_image_crop; ?>">
            <?php if ( $settings->link && $settings->link_target ) { ?>
            <a href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>">
            <?php } ?>
            <img class="<?php echo $classes; ?>" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" itemprop="image" <?php echo $attrs; ?> />
            <?php if ( $settings->link && $settings->link_target ) { ?>
            </a>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="pp-member-content">
		<?php if ( $settings->content_position == 'hover' || $settings->content_position == 'over' ) { ?>
			<div class="pp-member-content-inner-wrapper">
				<div class="pp-member-content-inner">
		<?php } ?>
        <?php if ( $settings->link && $settings->link_target ) { ?>
        <a href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>">
        <?php } ?>
            <<?php echo $settings->title_tag; ?> class="pp-member-name"><?php echo $settings->member_name; ?></<?php echo $settings->title_tag; ?>>
        <?php if ( $settings->link && $settings->link_target ) { ?>
        </a>
        <?php } ?>
        <?php if ( $settings->separator_position == 'below_title' && $settings->separator_display == 'yes' ) { ?>
            <div class="pp-member-separator"></div>
        <?php } ?>
		<?php if ( $settings->member_designation ) { ?>
        	<div class="pp-member-designation"><?php echo $settings->member_designation; ?></div>
		<?php } ?>
        <?php if ( $settings->separator_position == 'below_designation' && $settings->separator_display == 'yes' ) { ?>
            <div class="pp-member-separator"></div>
        <?php } ?>
		<?php if ( $settings->member_description ) { ?>
        	<div class="pp-member-description"><?php echo $settings->member_description; ?></div>
		<?php } ?>
		<?php if ($settings->email || $settings->facebook_url || $settings->twiiter_url || $settings->googleplus_url || $settings->pinterest_url || $settings->linkedin_url || $settings->youtube_url ||
	 	$settings->instagram_url || $settings->vimeo_url || $settings->github_url || $settings->dribbble_url || $settings->tumblr_url || $settings->flickr_url || $settings->wordpress_url ) { ?>
        <div class="pp-member-social-icons">
            <ul>
				<?php if ($settings->email) { ?>
                    <li class="pp-social-email">
						<a href="mailto:<?php echo $settings->email; ?>">
							<span class="fa fa-envelope"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->facebook_url) { ?>
                    <li class="pp-social-fb">
						<a href="<?php echo $settings->facebook_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-facebook"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->twiiter_url) { ?>
                    <li class="pp-social-twitter">
						<a href="<?php echo  $settings->twiiter_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-twitter"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->googleplus_url) { ?>
                    <li class="pp-social-gplus">
						<a href="<?php echo $settings->googleplus_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-google-plus"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->pinterest_url) { ?>
                    <li class="pp-social-pinterest">
						<a href="<?php echo $settings->pinterest_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-pinterest"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->linkedin_url) { ?>
                    <li class="pp-social-linkedin">
						<a href="<?php echo $settings->linkedin_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-linkedin"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->youtube_url) { ?>
                    <li class="pp-social-youtube">
						<a href="<?php echo $settings->youtube_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-youtube"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->instagram_url) { ?>
                    <li class="pp-social-instagram">
						<a href="<?php echo $settings->instagram_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-instagram"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->vimeo_url) { ?>
                    <li class="pp-social-vimeo">
						<a href="<?php echo $settings->vimeo_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-vimeo"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->github_url) { ?>
                    <li class="pp-social-github">
						<a href="<?php echo $settings->github_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-github"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->dribbble_url) { ?>
                    <li class="pp-social-dribbble">
						<a href="<?php echo $settings->dribbble_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-dribbble"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ($settings->tumblr_url) { ?>
                    <li class="pp-social-tumblr">
						<a href="<?php echo $settings->tumblr_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-tumblr"></span>
						</a>
					</li>
                <?php } ?>
                <?php if ( $settings->flickr_url) { ?>
                    <li class="pp-social-flickr">
						<a href="<?php echo $settings->flickr_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-flickr"></span>
						</a>
					</li>
                <?php } ?>
				<?php if ( $settings->wordpress_url) { ?>
                    <li class="pp-social-wordpress">
						<a href="<?php echo $settings->wordpress_url; ?>" target="<?php echo $settings->social_link_target; ?>">
							<span class="<?php echo $icon_prefix; ?> fa-wordpress"></span>
						</a>
					</li>
                <?php } ?>
            </ul>
        </div>
		<?php } ?>
		<?php if ( $settings->content_position == 'hover' || $settings->content_position == 'over' ) { ?>
				</div>
			</div>
		<?php } ?>
    </div>
</div>
