<?php

/**
 * @since 1.0
 * @class FLArchiveDescriptionModule
 */
class FLArchiveDescriptionModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Archive Description', 'fl-theme-builder' ),
			'description'     => __( 'Displays the description for the current archive.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'Archives', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'modules/fl-archive-description/',
			'url'             => FL_THEME_BUILDER_URL . 'modules/fl-archive-description/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
		));
	}
}

FLBuilder::register_module( 'FLArchiveDescriptionModule', array() );
