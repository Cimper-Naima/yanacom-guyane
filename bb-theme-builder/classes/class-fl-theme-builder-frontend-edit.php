<?php

/**
 * Handles frontend editing UI logic for the builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderFrontendEdit {

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts', 11 );
		add_action( 'fl_builder_enabled_modules', __CLASS__ . '::enable_modules' );
	}

	/**
	 * Enqueues styles and scripts for the editing UI.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {

		global $wp_the_query;

		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		} elseif ( ! is_object( $wp_the_query ) || ! is_object( $wp_the_query->post ) ) {
			return;
		} elseif ( 'fl-theme-layout' == $wp_the_query->post->post_type ) {
			return;
		}

		$post       = $wp_the_query->post;
		$post_type  = get_post_type_object( $post->post_type );
		$post_label = strtolower( $post_type->labels->singular_name );

		wp_enqueue_script( 'fl-theme-builder-frontend-edit', FL_THEME_BUILDER_URL . 'js/fl-theme-builder-frontend-edit.js', array(), FL_THEME_BUILDER_VERSION );

		wp_localize_script( 'fl-theme-builder-frontend-edit', 'FLThemeBuilderConfig', array(
			'adminEditURL' => admin_url( '/post.php?post=' . $post->ID . '&action=edit' ),
			'layouts'      => FLThemeBuilderLayoutData::get_current_page_layouts(),
			'strings'      => array(
				/* translators: 1: post type label, 2: custom builder branding */
				'overrideWarning'       => sprintf( _x( 'This %1$s has a Themer layout assigned to it. Using %2$s here will override that layout. Do you want to continue?', '%1$s post type label. %2$s custom builder branding.', 'fl-theme-builder' ), $post_label, FLBuilderModel::get_branding() ),
				'overrideWarningOk'     => __( 'Yes, use the builder', 'fl-theme-builder' ),
				'overrideWarningCancel' => __( 'No, take me back', 'fl-theme-builder' ),
			),
		) );
	}

	/**
	 * Makes sure theme builder modules are enabled.
	 *
	 * @since 1.0.1
	 * @param array $modules
	 * @return array
	 */
	static public function enable_modules( $modules ) {
		return array_merge( $modules, FLThemeBuilderLoader::get_loaded_modules() );
	}
}

FLThemeBuilderFrontendEdit::init();
