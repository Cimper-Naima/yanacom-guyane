<?php
/**
 * List of modules.
 */
$modules = array(
	'modules/pp-highlight-box/pp-highlight-box.php',
	'modules/pp-testimonials/pp-testimonials.php',
	'modules/pp-info-banner/pp-info-banner.php',
	'modules/pp-infolist/pp-infolist.php',
	'modules/pp-flipbox/pp-flipbox.php',
	'modules/pp-infobox/pp-infobox.php',
	'modules/pp-modal-box/pp-modal-box.php',
	'modules/pp-column-separator/pp-column-separator.php',
	'modules/pp-dotnav/pp-dotnav.php',
	'modules/pp-line-separator/pp-line-separator.php',
	'modules/pp-heading/pp-heading.php',
	'modules/pp-logos-grid/pp-logos-grid.php',
	'modules/pp-announcement-bar/pp-announcement-bar.php',
	'modules/pp-hover-cards/pp-hover-cards.php',
	'modules/pp-timeline/pp-timeline.php',
	'modules/pp-notifications/pp-notifications.php',
	'modules/pp-pullquote/pp-pullquote.php',
	'modules/pp-content-grid/pp-content-grid.php',
	'modules/pp-smart-button/pp-smart-button.php',
	'modules/pp-image-panels/pp-image-panels.php',
	'modules/pp-dual-button/pp-dual-button.php',
	'modules/pp-image/pp-image.php',
	'modules/pp-advanced-tabs/pp-advanced-tabs.php',
	'modules/pp-contact-form/pp-contact-form.php',
	'modules/pp-spacer/pp-spacer.php',
	'modules/pp-team/pp-team.php',
	'modules/pp-advanced-accordion/pp-advanced-accordion.php',
	'modules/pp-subscribe-form/pp-subscribe-form.php',
	'modules/pp-social-icons/pp-social-icons.php',
	'modules/pp-iconlist/pp-iconlist.php',
	'modules/pp-content-tiles/pp-content-tiles.php',
	'modules/pp-restaurant-menu/pp-restaurant-menu.php',
	'modules/pp-fancy-heading/pp-fancy-heading.php',
	'modules/pp-pricing-table/pp-pricing-table.php',
	'modules/pp-business-hours/pp-business-hours.php',
	'modules/pp-hover-cards-2/pp-hover-cards-2.php',
	'modules/pp-3d-slider/pp-3d-slider.php',
	'modules/fl-button/fl-button.php',
	'modules/pp-table/pp-table.php',
	'modules/pp-filterable-gallery/pp-filterable-gallery.php',
	'modules/pp-advanced-menu/pp-advanced-menu.php',
	'modules/pp-gallery/pp-gallery.php',
	'modules/pp-animated-headlines/pp-animated-headlines.php',
	'modules/pp-instagram-feed/pp-instagram-feed.php',
	'modules/pp-image-carousel/pp-image-carousel.php',
	'modules/pp-post-timeline/pp-post-timeline.php',
	'modules/pp-facebook-page/pp-facebook-page.php',
	'modules/pp-facebook-button/pp-facebook-button.php',
	'modules/pp-facebook-embed/pp-facebook-embed.php',
	'modules/pp-facebook-comments/pp-facebook-comments.php',
	'modules/pp-twitter-tweet/pp-twitter-tweet.php',
	'modules/pp-twitter-grid/pp-twitter-grid.php',
	'modules/pp-twitter-timeline/pp-twitter-timeline.php',
	'modules/pp-twitter-buttons/pp-twitter-buttons.php',
	'modules/pp-countdown/pp-countdown.php',
	'modules/pp-search-form/pp-search-form.php',
	'modules/pp-album/pp-album.php',
	'modules/pp-image-comparison/pp-image-comparison.php',
	'modules/pp-hotspot/pp-hotspot.php',
	'modules/pp-image-scroll/pp-image-scroll.php',
	'modules/pp-video/pp-video.php',
	'modules/pp-video-gallery/pp-video-gallery.php',
	'modules/pp-google-map/pp-google-map.php',
	'modules/pp-login-form/pp-login-form.php',
	'modules/pp-devices/pp-devices.php',
	'modules/pp-faq/pp-faq.php',
	'modules/pp-login-form/pp-login-form.php',
	'modules/pp-google-map/pp-google-map.php',
	'modules/pp-how-to/pp-how-to.php',
	'modules/pp-breadcrumbs/pp-breadcrumbs.php',
	'modules/pp-sitemap/pp-sitemap.php',
	'modules/pp-category-grid/pp-category-grid.php',
	'modules/pp-coupon/pp-coupon.php',
);

/* Custom Grid */
if ( class_exists( 'FLThemeBuilderLoader' ) ) {
	$modules[] = 'modules/pp-custom-grid/pp-custom-grid.php';
}

/* Form Modules */
if ( class_exists( 'GFForms' ) ) {
	$modules[] = 'modules/pp-gravity-form/pp-gravity-form.php';
}
if ( class_exists( 'WPCF7_ContactForm' ) ) {
	$modules[] = 'modules/pp-contact-form-7/pp-contact-form-7.php';
}
if ( function_exists( 'wpforms' ) ) {
	$modules[] = 'modules/pp-wpforms/pp-wpforms.php';
}
if ( class_exists( 'Caldera_Forms_Forms' ) ) {
	$modules[] = 'modules/pp-caldera-form/pp-caldera-form.php';
}
if ( class_exists( 'FrmForm' ) ) {
	$modules[] = 'modules/pp-formidable-form/pp-formidable-form.php';
}
if ( function_exists( 'Ninja_Forms' ) ) {
	$modules[] = 'modules/pp-ninja-form/pp-ninja-form.php';
}

$theme_dir = '';

if ( is_child_theme() ) {
	$theme_dir = get_stylesheet_directory();
} else {
	$theme_dir = get_template_directory();
}

sort( $modules );

/**
 * Loop through each module path and
 * check if the module is available in theme
 * to override. If available, load the module
 * from theme.
 */
foreach ( $modules as $module ) {
	if ( file_exists( $theme_dir . '/bb-powerpack/' . $module ) ) {
		require_once $theme_dir . '/bb-powerpack/' . $module;
	} elseif ( file_exists( $theme_dir . '/bbpowerpack/' . $module ) ) {
		require_once $theme_dir . '/bbpowerpack/' . $module;
	} else {
		require_once BB_POWERPACK_DIR . $module;
	}
}
