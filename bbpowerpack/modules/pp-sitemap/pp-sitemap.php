<?php

/**
 * @class PPSiteMapModule
 */
class PPSiteMapModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public static $post_types = array();
	public static $taxonomies = array();

	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Sitemap', 'bb-powerpack' ),
				'description'     => __( 'A module for Sitemap.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-sitemap/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-sitemap/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);
		$this->add_css( BB_POWERPACK()->fa_css );
	}

	public static function get_taxonomies() {
		$supported_taxonomies = [];

		self::$post_types = FLBuilderLoop::post_types();
		$public_types     = self::$post_types;

		foreach ( $public_types as $type => $title ) {
			// $taxonomies = get_object_taxonomies( $type, 'objects' );
			$taxonomies = FLBuilderLoop::taxonomies( $type );
			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $key => $tax ) {
					if ( ! array_key_exists( $key, $supported_taxonomies ) ) {
						$label                        = $tax->label . ' (' . $tax->name . ')';
						$supported_taxonomies[ $key ] = $label;
					}
				}
			}
		}
		return $supported_taxonomies;
	}

	public static function get_sitemap_content( $sitemap_item, $label_tag, $no_follow, $query_args ) {
		$hierarchical = 'yes' === $sitemap_item['sitemap_heirarchical_view'];
		$max_depth    = $sitemap_item['sitemap_depth'];
		$is_taxonomy  = 'taxonomy' === $sitemap_item['sitemap_type'];

		$query_args['order']   = $sitemap_item['sitemap_order'];
		$query_args['orderby'] = $is_taxonomy ? $sitemap_item['sitemap_taxonomy_orderby'] : $sitemap_item['sitemap_post_type_orderby'];

		$item_type = $is_taxonomy ? $sitemap_item['sitemap_taxonomy_source'] : $sitemap_item['sitemap_post_type_source'];
		$title     = self::get_title( $sitemap_item['sitemap_label'], $item_type, $is_taxonomy );

		$items_html = '';

		if ( $is_taxonomy ) {
			$items_html .= self::sitemap_html_taxonomies( $item_type, $hierarchical, $no_follow, $max_depth, $sitemap_item, $query_args );
		} else {
			$items_html .= self::sitemap_html_post_types( $item_type, $hierarchical, $no_follow, $max_depth, $query_args );
		}

		$title = empty( $title ) ? '' : sprintf( '<%s class="pp-sitemap-label">%s</%1$s>', $label_tag, $title );

		$html = '<div class="pp-sitemap-section pp-sitemap-section-' . $item_type . '">' . $title;
		if ( empty( $items_html ) ) {
			$html .= sprintf( '<span class="pp-sitemap-list pp-sitemap-list-' . $item_type . '">%s</span>', __( 'None', 'bb-powerpack' ) );
		} else {
			$html .= sprintf( '<ul class="pp-sitemap-list pp-sitemap-list-' . $item_type . '">%s</ul>', $items_html );
		}
		$html .= '</div>';

		return $html;
	}

	private static function get_title( $current_title, $item_type, $is_taxonomy ) {
		if ( '' !== $current_title ) {
			return $current_title;
		}

		if ( $is_taxonomy ) {
			$obj = get_taxonomy( $item_type );
			if ( false === $obj ) {
				return '';
			}
			return $obj->label;
		}

		$obj = get_post_type_object( $item_type );
		if ( null === $obj ) {
			return '';
		}
		if ( '' === $obj->labels->name ) {
			return $obj->labels->singular_name;
		}

		return $obj->labels->name;
	}

	private static function sitemap_html_taxonomies( $taxonomy, $hierarchical, $no_follow, $max_depth, $item_settings, $query_args ) {
		$query_args['hide_empty']       = 'yes' === $item_settings['sitemap_taxonomy_hide_empty'];
		$query_args['show_option_none'] = '';
		$query_args['taxonomy']         = $taxonomy;
		$query_args['title_li']         = '';
		$query_args['echo']             = false;
		$query_args['depth']            = $max_depth;
		$query_args['hierarchical']     = $hierarchical;
		$query_args['orderby']          = $item_settings['sitemap_taxonomy_orderby'];
		$taxonomy_list                  = wp_list_categories( $query_args );
		$taxonomy_list                  = self::add_sitemap_no_follow( 'item' . $taxonomy, $taxonomy_list, $no_follow );

		return $taxonomy_list;
	}

	/**
	 * @param string $post_type
	 * @param array  $query_args
	 *
	 * @return \WP_Query
	 */
	private static function query_by_post_type( $post_type, $query_args ) {
		$args = [
			'posts_per_page'         => -1,
			'update_post_meta_cache' => false,
			'post_type'              => $post_type,
			'filter'                 => 'ids',
			'post_status'            => 'publish',
		];

		$args = array_merge( $query_args, $args );

		$query = new \WP_Query( $args );

		return $query;
	}

	/**
	 * @param string $post_type
	 * @param bool   $hierarchical
	 * @param int    $depth
	 * @param array  $query_args
	 *
	 * @return string
	 */
	private static function sitemap_html_post_types( $post_type, $hierarchical, $no_follow, $depth, $query_args ) {
		$html = '';

		$query_result = self::query_by_post_type( $post_type, $query_args );
		if ( empty( $query_result ) ) {
			return '';
		}

		if ( $query_result->have_posts() ) {
			if ( ! $hierarchical ) {
				$depth = -1;
			}
			$walker            = new \Walker_Page();
			$walker->tree_type = $post_type;
			$walker_str        = $walker->walk( $query_result->posts, $depth );
			$html             .= self::add_sitemap_no_follow( 'item' . $post_type, $walker_str, $no_follow );
		}

		return $html;
	}

	private static function add_sitemap_no_follow( $element, $str, $no_follow ) {
		$source  = array();
		$replace = array();
		if ( 'yes' === $no_follow ) {
			$source[]  = 'href=';
			$replace[] = 'rel="nofollow" href=';
		}

		return str_replace( $source, $replace, $str );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPSiteMapModule',
	array(
		'general'  => array(
			'title'    => __( 'Content', 'bb-powerpack' ),
			'sections' => array(
				'general' => array(
					'title'  => '',
					'fields' => array(
						'list_items' => array(
							'type'         => 'form',
							'label'        => __( 'Item', 'bb-powerpack' ),
							'form'         => 'pp_sitemap_list', // ID from registered form below.
							'preview_text' => 'sitemap_label', // Name of a field to use for the preview text.
							'multiple'     => true,
						),
					),
				),
			),
		),
		'settings' => array(
			'title'    => __( 'Settings', 'bb-powerpack' ),
			'sections' => array(
				'heading_section' => array(
					'title'  => __( 'Structure/Layout', 'bb-powerpack' ),
					'fields' => array(
						'sitemap_columns' => array(
							'type'       => 'select',
							'label'      => __( 'Columns', 'bb-powerpack' ),
							'default'    => 1,
							'responsive' => true,
							'options'    => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
							),
						),
						'label_tag'       => array(
							'type'    => 'select',
							'label'   => __( 'Title HTML Tag', 'bb-powerpack' ),
							'default' => 'h3',
							'options' => array(
								'h1'   => 'H1',
								'h2'   => 'H2',
								'h3'   => 'H3',
								'h4'   => 'H4',
								'h5'   => 'H5',
								'h6'   => 'H6',
								'div'  => 'div',
								'span' => 'span',
								'p'    => 'p',
							),
						),
						'no_follow'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'No Follow', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
				'tree'            => array(
					'title'       => __( 'Tree', 'bb-powerpack' ),
					'description' => __( '<br>Display list items with a toggle icon to expand and collapse the child items', 'bb-powerpack' ),
					'fields'      => array(
						'sitemap_tree'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Tree', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'sitemap_tree_style', 'sitemap_tree_color' ),
								),
							),
						),
						'sitemap_tree_style' => array(
							'type'    => 'select',
							'label'   => __( 'Style', 'bb-powerpack' ),
							'default' => 'plus_circle',
							'options' => array(
								'caret'       => __( 'Caret', 'bb-powerpack' ),
								'plus_circle' => __( 'Circle ( Plus & Minus )', 'bb-powerpack' ),
								'plus'        => __( 'Plus & Minus', 'bb-powerpack' ),
							),
						),
						'sitemap_tree_color' => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section ul.tree li',
								'property' => 'color',
							),
						),
					),
				),
			),
		),
		'style'    => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'list'       => array(
					'title'  => __( 'Sitemap', 'bb-powerpack' ),
					'fields' => array(
						'sitemap_indent'  => array(
							'type'         => 'unit',
							'label'        => __( 'Indent', 'bb-powerpack' ),
							'default'      => 0,
							// 'description'   => __('px', 'bb-powerpack'),
							'units'        => array( 'px', 'em' ),
							'default_unit' => 'px',
							'slider'       => true,
							'preview'      => array(
								'type'     => 'css',
								'property' => 'margin-left',
								'selector' => '.pp-sitemap-section .pp-sitemap-list',
							),
						),
						'sitemap_padding' => array(
							'type'        => 'dimension',
							'label'       => __( 'Padding', 'bb-powerpack' ),
							'responsive'  => true,
							'slider'      => true,
							'description' => __( 'px', 'bb-powerpack' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
					),
				),
				'site_label' => array(
					'title'  => __( 'Title', 'bb-powerpack' ),
					'fields' => array(
						'label_typography'       => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-label',
							),
						),
						'label_border'           => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-label',
							),
						),
						'label_padding'          => array(
							'type'        => 'dimension',
							'label'       => __( 'Padding', 'bb-powerpack' ),
							'responsive'  => true,
							'slider'      => true,
							'description' => __( 'px', 'bb-powerpack' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-label',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'label_color'            => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-label',
								'property' => 'color',
							),
						),
						'label_background_color' => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-label',
								'property' => 'background-color',
							),
						),
					),
				),
				'list_item'  => array(
					'title'  => __( 'List Item', 'bb-powerpack' ),
					'fields' => array(
						'list_item_typography'       => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-list',
							),
						),
						'list_item_color'            => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section ul li a',
								'property' => 'color',
							),
						),
						'list_item_color_hover'      => array(
							'type'       => 'color',
							'label'      => __( 'Hover Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
						),
						'list_item_background_color' => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-list',
								'property' => 'background-color',
							),
						),
						'list_item_padding'          => array(
							'type'        => 'dimension',
							'label'       => __( 'Padding', 'bb-powerpack' ),
							'responsive'  => true,
							'slider'      => true,
							'description' => __( 'px', 'bb-powerpack' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-list > li',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),

						'list_item_seperator_style'  => array(
							'type'    => 'select',
							'label'   => __( 'Seperator', 'bb-powerpack' ),
							'default' => 'none',
							'options' => array(
								'none'   => __( 'None', 'bb-powerpack' ),
								'solid'  => __( 'Solid', 'bb-powerpack' ),
								'dashed' => __( 'Dashed', 'bb-powerpack' ),
								'dotted' => __( 'Dotted', 'bb-powerpack' ),
								'double' => __( 'Double', 'bb-powerpack' ),
							),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-list > li',
								'property' => 'border-bottom-style',
							),
							'toggle'  => array(
								'solid'  => array(
									'fields' => array( 'list_item_seperator_size', 'list_item_seperator_color' ),
								),
								'dashed' => array(
									'fields' => array( 'list_item_seperator_size', 'list_item_seperator_color' ),
								),
								'dotted' => array(
									'fields' => array( 'list_item_seperator_size', 'list_item_seperator_color' ),
								),
								'double' => array(
									'fields' => array( 'list_item_seperator_size', 'list_item_seperator_color' ),
								),
							),
						),
						'list_item_seperator_size'   => array(
							'type'        => 'unit',
							'label'       => __( 'Seperator Size', 'bb-powerpack' ),
							'default'     => 1,
							'description' => __( 'px', 'bb-powerpack' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-list > li',
								'property' => 'border-bottom-width',
								'unit'     => 'px',
							),
						),
						'list_item_seperator_color'  => array(
							'type'       => 'color',
							'label'      => __( 'Seperator Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'default'    => '000000',
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section .pp-sitemap-list > li',
								'property' => 'border-bottom-color',
							),
						),
					),
				),
				'bullet'     => array(
					'title'  => __( 'Bullet', 'bb-powerpack' ),
					'fields' => array(
						'bullet_style' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Style', 'bb-powerpack' ),
							'default' => 'disc',
							'options' => array(
								'none'   => __( 'None', 'bb-powerpack' ),
								'disc'   => __( 'Disc', 'bb-powerpack' ),
								'circle' => __( 'Circle', 'bb-powerpack' ),
								'square' => __( 'Square', 'bb-powerpack' ),
							),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section ul.children,.pp-sitemap-section ul.pp-sitemap-list',
								'property' => 'list-style-type',
							),
						),
						'bullet_color' => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-sitemap-section ul.children,.pp-sitemap-section ul.pp-sitemap-list',
								'property' => 'color',
							),
						),
					),
				),
			),
		),

	)
);

FLBuilder::register_settings_form(
	'pp_sitemap_list',
	array(
		'title' => __( 'Add Item', 'bb-powerpack' ),
		'tabs'  => array(
			'general' => array(
				'title'    => __( 'Content', 'bb-powerpack' ),
				'sections' => array(
					'query_items'   => array(
						'title'  => __( 'Query', 'bb-powerpack' ),
						'fields' => array(
							'sitemap_type'                => array(
								'type'    => 'select',
								'label'   => __( 'Type', 'bb-powerpack' ),
								// 'default'       => 1,
								'options' => array(
									'post_type' => __( 'Post Type', 'bb-powerpack' ),
									'taxonomy'  => __( 'Taxonomy', 'bb-powerpack' ),
								),
								'toggle'  => array(
									'post_type' => array(
										'fields' => array( 'sitemap_post_type_source', 'sitemap_post_type_orderby' ),
									),
									'taxonomy'  => array(
										'fields' => array( 'sitemap_taxonomy_source', 'sitemap_taxonomy_orderby', 'sitemap_taxonomy_hide_empty' ),
									),
								),
							),
							'sitemap_post_type_source'    => array(
								'type'  => 'post-type',
								'label' => __( 'Source', 'bb-powerpack' ),
							),
							'sitemap_taxonomy_source'     => array(
								'type'    => 'select',
								'label'   => __( 'Source', 'bb-powerpack' ),
								'options' => PPSiteMapModule::get_taxonomies(),

							),
							'sitemap_post_type_orderby'   => array(
								'type'    => 'select',
								'label'   => __( 'Order By', 'bb-powerpack' ),
								'default' => 'date',
								'options' => array(
									'date'       => __( 'Date', 'bb-powerpack' ),
									'title'      => __( 'Title', 'bb-powerpack' ),
									'menu_order' => __( 'Menu Order', 'bb-powerpack' ),
									'random'     => __( 'Random', 'bb-powerpack' ),
								),

							),
							'sitemap_taxonomy_orderby'    => array(
								'type'    => 'select',
								'label'   => __( 'Order By', 'bb-powerpack' ),
								'default' => 'date',
								'options' => array(
									'id'   => __( 'ID', 'bb-powerpack' ),
									'name' => __( 'Name', 'bb-powerpack' ),
								),

							),
							'sitemap_order'               => array(
								'type'    => 'select',
								'label'   => __( 'Order', 'bb-powerpack' ),
								'default' => 'desc',
								'options' => array(
									'asc'  => __( 'ASC', 'bb-powerpack' ),
									'desc' => __( 'DESC', 'bb-powerpack' ),
								),

							),
							'sitemap_taxonomy_hide_empty' => array(
								'type'    => 'pp-switch',
								'label'   => __( 'Hide Empty', 'bb-powerpack' ),
								'default' => 'no',
								'options' => array(
									'yes' => __( 'Yes', 'bb-powerpack' ),
									'no'  => __( 'No', 'bb-powerpack' ),
								),
								'preview' => array(
									'type' => 'none',
								),
							),
						),
					),
					'content_items' => array(
						'title'  => __( 'Content', 'bb-powerpack' ),
						'fields' => array(
							'sitemap_label'             => array(
								'type'  => 'text',
								'label' => __( 'Title', 'bb-powerpack' ),
							),
							'sitemap_heirarchical_view' => array(
								'type'    => 'pp-switch',
								'label'   => __( 'Heirarchical View', 'bb-powerpack' ),
								'default' => 'yes',
								'options' => array(
									'yes' => __( 'Yes', 'bb-powerpack' ),
									'no'  => __( 'No', 'bb-powerpack' ),
								),
								'toggle'  => array(
									'yes' => array(
										'fields' => array( 'sitemap_depth' ),
									),
								),
								'preview' => array(
									'type' => 'none',
								),
							),
							'sitemap_depth'             => array(
								'type'    => 'select',
								'label'   => __( 'Depth', 'bb-powerpack' ),
								'default' => 'all',
								'options' => array(
									'all' => 'All',
									'1'   => '1',
									'2'   => '2',
									'3'   => '3',
									'4'   => '4',
									'5'   => '5',
									'6'   => '6',
								),
								'preview' => array(
									'type' => 'none',
								),
							),
						),
					),
				),
			),
			'exclude' => array(
				'title' => __( 'Include/Exclude', 'fl-builder' ),
				'file'  => BB_POWERPACK_DIR . 'modules/pp-sitemap/includes/exclude-posts.php',
			),
		),
	)
);
