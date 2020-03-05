<?php

/**
 * @since 1.0
 * @class FLPostContentModule
 */
class FLPostContentModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Post Content', 'fl-theme-builder' ),
			'description'     => __( 'Displays the content for a post.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'Posts', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'modules/fl-post-content/',
			'url'             => FL_THEME_BUILDER_URL . 'modules/fl-post-content/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));

		$this->add_js( 'jquery-fitvids' );
	}
}

FLBuilder::register_module( 'FLPostContentModule', array() );
