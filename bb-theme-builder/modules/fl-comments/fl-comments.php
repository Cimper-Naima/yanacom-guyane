<?php

/**
 * @since 1.0
 * @class FLCommentsModule
 */
class FLCommentsModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Comments', 'fl-theme-builder' ),
			'description'     => __( 'Displays the comments for the current post.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'Posts', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'modules/fl-comments/',
			'url'             => FL_THEME_BUILDER_URL . 'modules/fl-comments/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLCommentsModule', array() );
