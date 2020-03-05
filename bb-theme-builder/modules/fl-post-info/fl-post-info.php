<?php

/**
 * @class FLPostInfoModule
 */
class FLPostInfoModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Post Info', 'fl-theme-builder' ),
			'description'     => __( 'Displays meta information for a post.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'Posts', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'modules/fl-post-info/',
			'url'             => FL_THEME_BUILDER_URL . 'modules/fl-post-info/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'FLPostInfoModule', array(
	'general' => array(
		'title'    => __( 'General', 'fl-theme-builder' ),
		'sections' => array(
			'date'          => array(
				'title'  => __( 'Date', 'fl-theme-builder' ),
				'fields' => array(
					'show_date'   => array(
						'type'    => 'select',
						'label'   => __( 'Date', 'fl-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Show', 'fl-theme-builder' ),
							'0' => __( 'Hide', 'fl-theme-builder' ),
						),
					),
					'date_format' => array(
						'type'    => 'select',
						'label'   => __( 'Date Format', 'fl-theme-builder' ),
						'default' => '',
						'options' => array(
							''       => __( 'Default', 'fl-theme-builder' ),
							'M j, Y' => date( 'M j, Y' ),
							'F j, Y' => date( 'F j, Y' ),
							'm/d/Y'  => date( 'm/d/Y' ),
							'm-d-Y'  => date( 'm-d-Y' ),
							'd M Y'  => date( 'd M Y' ),
							'd F Y'  => date( 'd F Y' ),
							'Y-m-d'  => date( 'Y-m-d' ),
							'Y/m/d'  => date( 'Y/m/d' ),
						),
					),
					'date_prefix' => array(
						'type'    => 'text',
						'label'   => __( 'Prefix', 'fl-theme-builder' ),
						'default' => '',
					),
				),
			),
			'modified_date' => array(
				'title'  => __( 'Modified Date', 'fl-theme-builder' ),
				'fields' => array(
					'show_modified_date'   => array(
						'type'    => 'select',
						'label'   => __( 'Modified Date', 'fl-theme-builder' ),
						'default' => '0',
						'options' => array(
							'1' => __( 'Show', 'fl-theme-builder' ),
							'0' => __( 'Hide', 'fl-theme-builder' ),
						),
					),
					'modified_date_format' => array(
						'type'    => 'select',
						'label'   => __( 'Modified Date Format', 'fl-theme-builder' ),
						'default' => '',
						'options' => array(
							''       => __( 'Default', 'fl-theme-builder' ),
							'M j, Y' => date( 'M j, Y' ),
							'F j, Y' => date( 'F j, Y' ),
							'm/d/Y'  => date( 'm/d/Y' ),
							'm-d-Y'  => date( 'm-d-Y' ),
							'd M Y'  => date( 'd M Y' ),
							'd F Y'  => date( 'd F Y' ),
							'Y-m-d'  => date( 'Y-m-d' ),
							'Y/m/d'  => date( 'Y/m/d' ),
							'human'  => __( '3 days ago', 'fl-theme-builder' ),
						),
					),
					'modified_date_prefix' => array(
						'type'    => 'text',
						'label'   => __( 'Prefix', 'fl-theme-builder' ),
						'default' => __( 'Last Updated&nbsp;', 'fl-theme-builder' ),
					),
				),
			),
			'author'        => array(
				'title'  => __( 'Author', 'fl-theme-builder' ),
				'fields' => array(
					'show_author' => array(
						'type'    => 'select',
						'label'   => __( 'Author', 'fl-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Show', 'fl-theme-builder' ),
							'0' => __( 'Hide', 'fl-theme-builder' ),
						),
					),
				),
			),
			'comments'      => array(
				'title'  => __( 'Comments', 'fl-theme-builder' ),
				'fields' => array(
					'show_comments' => array(
						'type'    => 'select',
						'label'   => __( 'Comments', 'fl-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Show', 'fl-theme-builder' ),
							'0' => __( 'Hide', 'fl-theme-builder' ),
						),
					),
					'none_text'     => array(
						'type'    => 'text',
						'label'   => __( 'No Comments Text', 'fl-theme-builder' ),
						'default' => __( 'No Comments', 'fl-theme-builder' ),
					),
					'one_text'      => array(
						'type'    => 'text',
						'label'   => __( 'One Comment Text', 'fl-theme-builder' ),
						'default' => __( '1 Comment', 'fl-theme-builder' ),
					),
					'more_text'     => array(
						'type'    => 'text',
						'label'   => __( 'Comments Text', 'fl-theme-builder' ),
						'default' => __( '% Comments', 'fl-theme-builder' ),
					),
				),
			),
			'terms'         => array(
				'title'  => __( 'Terms', 'fl-theme-builder' ),
				'fields' => array(
					'show_terms'      => array(
						'type'    => 'select',
						'label'   => __( 'Terms', 'fl-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Show', 'fl-theme-builder' ),
							'0' => __( 'Hide', 'fl-theme-builder' ),
						),
					),
					'terms_taxonomy'  => array(
						'type'    => 'select',
						'label'   => __( 'Taxonomy', 'fl-theme-builder' ),
						'default' => 'category',
						'options' => FLPageDataPost::get_taxonomy_options(),
					),
					'terms_separator' => array(
						'type'    => 'text',
						'label'   => __( 'Separator', 'fl-theme-builder' ),
						'default' => __( ', ', 'fl-theme-builder' ),
						'size'    => '4',
					),
				),
			),
		),
	),
	'style'   => array(
		'title'    => __( 'Style', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'align'      => array(
						'type'    => 'select',
						'label'   => __( 'Alignment', 'fl-theme-builder' ),
						'default' => 'left',
						'options' => array(
							'left'   => __( 'Left', 'fl-theme-builder' ),
							'center' => __( 'Center', 'fl-theme-builder' ),
							'right'  => __( 'Right', 'fl-theme-builder' ),
						),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content',
							'property' => 'text-align',
						),
					),
					'font_size'  => array(
						'type'        => 'text',
						'label'       => __( 'Font Size', 'fl-theme-builder' ),
						'default'     => '',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px',
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Color', 'fl-theme-builder' ),
						'show_reset' => true,
					),
					'separator'  => array(
						'type'    => 'text',
						'label'   => __( 'Separator', 'fl-theme-builder' ),
						'default' => ' | ',
						'size'    => '4',
						'preview' => array(
							'type'     => 'text',
							'selector' => '.fl-post-info-sep',
						),
					),
				),
			),
		),
	),
	'order'   => array(
		'title'    => __( 'Order', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'order' => array(
						'type'    => 'ordering',
						'label'   => '',
						'default' => array( 'date', 'modified_date', 'author', 'comments', 'terms' ),
						'options' => array(
							'date'          => __( 'Date', 'fl-theme-builder' ),
							'modified_date' => __( 'Modified Date', 'fl-theme-builder' ),
							'author'        => __( 'Author', 'fl-theme-builder' ),
							'comments'      => __( 'Comments', 'fl-theme-builder' ),
							'terms'         => __( 'Terms', 'fl-theme-builder' ),
						),
					),
				),
			),
		),
	),
));
