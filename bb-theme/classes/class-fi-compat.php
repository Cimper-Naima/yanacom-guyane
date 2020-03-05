<?php
/**
 * Compatibility class.
 *
 * @since 1.6
 */
final class FLThemeCompat {

	/**
	 * Filters and actions to fix plugin compatibility.
	 */
	static public function init() {

		// Filter fl_archive_show_full to fix CRED form preview.
		add_filter( 'fl_archive_show_full', 'FLThemeCompat::fix_cred_preview' );
	}

	/**
	 * If we are showing a CRED form preview we need to show full post always
	 * so the shortcodes will render.
	 * @since 1.6
	 */
	static function fix_cred_preview( $show_full ) {

		if ( isset( $_REQUEST['cred_form_preview'] ) ) {
			return true;
		}
		return $show_full;
	}
}
