<?php

/**
 * @class PPAccordionModule
 */
class PPAccordionModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Advanced Accordion', 'bb-powerpack' ),
				'description'     => __( 'Display a collapsible accordion of items.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-advanced-accordion/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-advanced-accordion/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);

		$this->add_css( BB_POWERPACK()->fa_css );
	}

	public static function get_general_fields() {
		$fields = array(
			'accordion_source' => array(
				'type'    => 'select',
				'label'   => __( 'Source', 'bb-powerpack' ),
				'default' => 'manual',
				'options' => array(
					'manual' => __( 'Manual', 'bb-powerpack' ),
					'post'   => __( 'Post', 'bb-powerpack' ),
				),
				'toggle'  => array(
					'manual' => array(
						'fields' => array( 'items' ),
					),
					'post'   => array(
						'sections' => array( 'post_content' ),
					),
				),
			),
			'items'            => array(
				'type'         => 'form',
				'label'        => __( 'Item', 'bb-powerpack' ),
				'form'         => 'pp_accordion_items_form',
				'preview_text' => 'label',
				'multiple'     => true,
			),
		);

		if ( class_exists( 'acf' ) ) {
			$fields['accordion_source']['options']['acf']          = __( 'ACF Repeater Field', 'bb-powerpack' );
			$fields['accordion_source']['toggle']['acf']['fields'] = array( 'acf_repeater_name', 'acf_repeater_label', 'acf_repeater_content' );

			$fields['acf_repeater_name']    = array(
				'type'        => 'text',
				'label'       => __( 'ACF Repeater Field Name', 'bb-powerpack' ),
				'connections' => array( 'string' ),
			);
			$fields['acf_repeater_label']   = array(
				'type'        => 'text',
				'label'       => __( 'ACF Repeater Sub Field Name (Label)', 'bb-powerpack' ),
				'connections' => array( 'string' ),
			);
			$fields['acf_repeater_content'] = array(
				'type'        => 'text',
				'label'       => __( 'ACF Repeater Sub Field Name (Content)', 'bb-powerpack' ),
				'connections' => array( 'string' ),
			);
		}

		return $fields;
	}

	public function get_cpt_data() {
		if ( ! isset( $this->settings->post_slug ) || empty( $this->settings->post_slug ) ) {
			return;
		}
		$data = array();

		$post_type = ! empty( $this->settings->post_slug ) ? $this->settings->post_slug : 'post';
		$cpt_count = ! empty( $this->settings->post_count ) || '-1' !== $this->settings->post_count ? $this->settings->post_count : '-1';
		$cpt_order = ! empty( $this->settings->post_order ) ? $this->settings->post_order : 'ASC';

		$var_tax_type     = 'posts_' . $post_type . '_tax_type';
		$tax_type         = '';
		$var_cat_matching = '';
		$var_cat          = '';

		if ( isset( $this->settings->$var_tax_type ) ) {
			$tax_type         = $this->settings->$var_tax_type;
			$var_cat          = 'tax_' . $post_type . '_' . $tax_type;
			$var_cat_matching = $var_cat . '_matching';
		}

		$cat_match = isset( $this->settings->$var_cat_matching ) ? $this->settings->$var_cat_matching : false;
		$ids       = isset( $this->settings->$var_cat ) ? explode( ',', $this->settings->$var_cat ) : array();
		$taxonomy  = isset( $tax_type ) ? $tax_type : '';
		$tax_query = array();

		if ( isset( $ids[0] ) && ! empty( $ids[0] ) ) {
			if ( $cat_match && 'related' !== $cat_match ) {
				$tax_query = array(
					'relation' => 'AND',
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => $ids,
					),
				);
			} elseif ( ! $cat_match || 'related' === $cat_match ) {

				$tax_query = array(
					'relation' => 'AND',
					array(
						'taxonomy'    => $taxonomy,
						'field'       => 'term_id',
						'terms'       => $ids,
						'operator'    => 'NOT IN', // exclude
						'post_parent' => 0, // top level only
					),
				);
			}
		}
		$posts = get_posts(
			array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'numberposts' => $cpt_count,
				'order'       => $cpt_order,
				'tax_query'   => $tax_query,
			)
		);
		foreach ( $posts as $row ) {
			$item          = new stdClass;
			$item->label   = isset( $row->post_title ) ? $row->post_title : '';
			$item->content = isset( $row->post_content ) ? $row->post_content : '';

			$data[] = $item;
		}
		return $data;
	}

	public function get_acf_data( $post_id = false ) {
		if ( ! isset( $this->settings->acf_repeater_name ) || empty( $this->settings->acf_repeater_name ) ) {
			return;
		}

		$data    = array();
		$post_id = apply_filters( 'pp_faq_acf_post_id', $post_id );

		$repeater_name = $this->settings->acf_repeater_name;
		$label_name    = $this->settings->acf_repeater_label;
		$content_name  = $this->settings->acf_repeater_content;

		$repeater_rows = get_field( $repeater_name, $post_id );

		if ( ! $repeater_rows ) {
			return;
		}

		foreach ( $repeater_rows as $row ) {
			$item          = new stdClass;
			$item->label   = isset( $row[ $label_name ] ) ? $row[ $label_name ] : '';
			$item->content = isset( $row[ $content_name ] ) ? $row[ $content_name ] : '';

			$data[] = $item;
		}

		return $data;
	}
	public function get_accordion_items() {
		$source = $this->settings->accordion_source;

		if ( ! isset( $source ) || empty( $source ) ) {
			return $this->settings->items;
		}

		if ( 'acf' === $source ) {
			return $this->get_acf_data();
		}

		if ( 'post' === $source ) {
			return $this->get_cpt_data();
		}

		return $this->settings->items;
	}
	/**
	 * Render content.
	 *
	 * @since 1.4
	 */
	public function render_content( $settings ) {
		$html = '';

		switch ( $settings->content_type ) {
			case 'content':
				global $wp_embed;
				$html  = '<div itemprop="text">';
				$html .= wpautop( $wp_embed->autoembed( $settings->content ) );
				$html .= '</div>';
				break;
			case 'photo':
				$html  = '<div itemprop="image">';
				$html .= '<img src="' . $settings->content_photo_src . '" alt="" style="max-width: 100%;" />';
				$html .= '</div>';
				break;
			case 'video':
				global $wp_embed;
				$html = $wp_embed->autoembed( $settings->content_video );
				break;
			case 'module':
				$html = '[fl_builder_insert_layout id="' . $settings->content_module . '"]';
				break;
			case 'row':
				$html = '[fl_builder_insert_layout id="' . $settings->content_row . '"]';
				break;
			case 'layout':
				$html = '[fl_builder_insert_layout id="' . $settings->content_layout . '"]';
				break;
			default:
				break;
		}

		return $html;
	}

	public function filter_settings( $settings, $helper ) {
		// Handle old label background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field(
			$settings,
			'label_background_color',
			array(
				'primary'   => 'label_bg_color_default',
				'secondary' => 'label_bg_color_active',
				'opacity'   => 'label_background_opacity',
			)
		);

		// Handle old label text dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field(
			$settings,
			'label_text_color',
			array(
				'primary'   => 'label_text_color_default',
				'secondary' => 'label_text_color_active',
			)
		);

		// Handle old label padding field.
		if ( isset( $settings->label_padding ) && is_array( $settings->label_padding ) ) {
			$settings = PP_Module_Fields::handle_multitext_field( $settings, 'label_padding', 'padding', 'label_padding' );
		}

		// Handle old label border field.
		$settings = PP_Module_Fields::handle_border_field(
			$settings,
			array(
				'label_border_style'  => array(
					'type' => 'style',
				),
				'label_border_width'  => array(
					'type' => 'width',
				),
				'label_border_color'  => array(
					'type' => 'color',
				),
				'label_border_radius' => array(
					'type' => 'radius',
				),
			),
			'label_border'
		);

		// Merge content bg opacity to content bg color.
		if ( isset( $settings->content_bg_opacity ) ) {
			$opacity = 1;
			if ( '0' === $settings->content_bg_opacity ) {
				$opacity = 0;
			} else {
				$opacity = ( $settings->content_bg_opacity / 100 );
			}
			$content_bg_color = $settings->content_bg_color;
			if ( ! empty( $content_bg_color ) ) {
				$settings->content_bg_color = pp_hex2rgba( $content_bg_color, $opacity );
			}

			unset( $settings->content_bg_opacity );
		}

		// Handle old content padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'content_padding', 'padding', 'content_padding' );

		// Handle old content border field.
		$settings = PP_Module_Fields::handle_border_field(
			$settings,
			array(
				'content_border_style'  => array(
					'type' => 'style',
				),
				'content_border_width'  => array(
					'type' => 'width',
				),
				'content_border_color'  => array(
					'type' => 'color',
				),
				'content_border_radius' => array(
					'type' => 'radius',
				),
			),
			'content_border'
		);

		// Handle old label typography fields.
		$settings = PP_Module_Fields::handle_typography_field(
			$settings,
			array(
				'label_font'             => array(
					'type' => 'font',
				),
				'label_custom_font_size' => array(
					'type'      => 'font_size',
					'condition' => ( isset( $settings->label_font_size ) && 'custom' === $settings->label_font_size ),
				),
				'label_line_height'      => array(
					'type' => 'line_height',
				),
			),
			'label_typography'
		);

		// Handle old content typography fields.
		$settings = PP_Module_Fields::handle_typography_field(
			$settings,
			array(
				'content_font'             => array(
					'type' => 'font',
				),
				'content_custom_font_size' => array(
					'type'      => 'font_size',
					'condition' => ( isset( $settings->content_font_size ) && 'custom' === $settings->content_font_size ),
				),
				'content_line_height'      => array(
					'type' => 'line_height',
				),
				'content_alignment'        => array(
					'type' => 'text_align',
				),
			),
			'content_typography'
		);

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPAccordionModule',
	array(
		'items'      => array(
			'title'    => __( 'Items', 'bb-powerpack' ),
			'sections' => array(
				'general'      => array(
					'title'  => '',
					'fields' => PPAccordionModule::get_general_fields(),
				),
				'post_content' => array(
					'title' => __( 'Content', 'bb-powerpack' ),
					'file'  => BB_POWERPACK_DIR . 'modules/pp-advanced-accordion/includes/loop-settings.php',
				),
			),
		),
		'icon_style' => array(
			'title'    => __( 'Icon', 'bb-powerpack' ),
			'sections' => array(
				'accordion_icon_style'    => array(
					'title'	=> '',
					'fields'	=> array(
						'accordion_icon_size'   => array(
							'type'          => 'unit',
							'label'         => __( 'Size', 'bb-powerpack' ),
							'units'			=> array( 'px' ),
							'slider'		=> true,
							'default'       => '15',
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.pp-accordion-item .pp-accordion-icon, .pp-accordion-item .pp-accordion-icon:before',
								'property'  => 'font-size',
								'unit'      => 'px'
							)
						),
					)
				),
				'responsive_toggle_icons' => array(
					'title'	=> __( 'Toggle Icons', 'bb-powerpack' ),
					'fields'	=> array(
						'accordion_open_icon' => array(
							'type'          => 'icon',
							'label'         => __( 'Open Icon', 'bb-powerpack' ),
							'show_remove'   => true
						),
						'accordion_close_icon' => array(
							'type'          => 'icon',
							'label'         => __( 'Close Icon', 'bb-powerpack' ),
							'show_remove'   => true
						),
						'accordion_toggle_icon_size'   => array(
							'type'          => 'unit',
							'label'         => __( 'Size', 'bb-powerpack' ),
							'units'			=> array( 'px' ),
							'slider'		=> true,
							'default'       => '14',
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.pp-accordion-item .pp-accordion-button-icon, .pp-accordion-item .pp-accordion-button-icon:before',
								'property'  => 'font-size',
								'unit'      => 'px'
							)
						),
						'accordion_toggle_icon_color'  => array(
							'type'          => 'color',
							'label'         => __( 'Color', 'bb-powerpack' ),
							'default'       => '666666',
							'show_reset'	=> true,
							'connections'	=> array( 'color' ),
							'preview'	    => array(
								'type'	=> 'css',
								'selector'	=> '.pp-accordion-item .pp-accordion-button-icon',
								'property'	=> 'color',
							),
						),
					),
				),
			),
		),
		'style'      => array(
			'title'         => __( 'Style', 'bb-powerpack' ),
			'sections'      => array(
				'general'       => array(
					'title'         => '',
					'fields'        => array(
						'item_spacing'     => array(
							'type'          => 'unit',
							'label'         => __( 'Item Spacing', 'bb-powerpack' ),
							'default'       => '10',
							'units'			=> array( 'px' ),
							'slider'		=> true,
							'preview'       => array(
								'type'          => 'css',
								'selector'      => '.pp-accordion-item',
								'property'      => 'margin-bottom',
								'unit'			=> 'px'
							)
						),
						'collapse'   => array(
							'type'          => 'pp-switch',
							'label'         => __( 'Collapse Inactive', 'bb-powerpack' ),
							'default'       => '1',
							'options'       => array(
								'1'             => __( 'Yes', 'bb-powerpack' ),
								'0'             => __( 'No', 'bb-powerpack' )
							),
							'help'          => __( 'Choosing yes will keep only one item open at a time. Choosing no will allow multiple items to be open at the same time.', 'bb-powerpack' ),
							'preview'       => array(
								'type'          => 'none'
							)
						),
						'open_first'       => array(
							'type'          => 'pp-switch',
							'label'         => __( 'Expand First Item', 'bb-powerpack' ),
							'default'       => '0',
							'options'       => array(
								'1'             => __( 'Yes', 'bb-powerpack' ),
								'0'             => __( 'No', 'bb-powerpack' ),
							),
							'help' 			=> __( 'Choosing yes will expand the first item by default.', 'bb-powerpack' ),
							'toggle'		=> array(
								'0'				=> array(
									'fields'		=> array( 'open_custom' )
								)
							)
						),
						'open_custom'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Expand Custom', 'bb-powerpack' ),
							'default'		=> '',
							'size'			=> 5,
							'help'			=> __( 'Add item number to expand by default.', 'bb-powerpack' )
						),
						'responsive_collapse'	=> array(
							'type'					=> 'pp-switch',
							'label'					=> __( 'Responsive Collapse All', 'bb-powerpack' ),
							'default'				=> 'no',
							'options'				=> array(
								'yes'					=> __( 'Yes', 'bb-powerpack' ),
								'no'					=> __( 'No', 'bb-powerpack' ),
							),
							'help'					=> __( 'Items will not appear as expanded on responsive devices until user clicks on it.', 'bb-powerpack' )
						),
						'accordion_id_prefix'	=> array(
							'type'			=> 'text',
							'label'			=> __( 'Custom ID Prefix', 'bb-powerpack' ),
							'default'		=> '',
							'placeholder'	=> __( 'myaccordion', 'bb-powerpack' ),
							'help'			=> __( 'A prefix that will be applied to ID attribute of accordion items in HTML. For example, prefix "myaccordion" will be applied as "myaccordion-1", "myaccordion-2" in ID attribute of accordion item 1 and accordion item 2 respectively. It should only contain dashes, underscores, letters or numbers. No spaces.', 'bb-powerpack' )
						),
					)
				),
				'label_style'       => array(
					'title'         => __( 'Label', 'bb-powerpack' ),
					'fields'        => array(
						'label_bg_color_default'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Background Color - Default', 'bb-powerpack' ),
							'default'		=> 'dddddd',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.pp-accordion-item .pp-accordion-button',
								'property'		=> 'background-color',
							),
						),
						'label_bg_color_active'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Background Color - Active', 'bb-powerpack' ),
							'default'		=> '',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
						),
						'label_text_color_default'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Text Color - Default', 'bb-powerpack' ),
							'default'		=> '666666',
							'show_reset'	=> true,
							'connections'	=> array( 'color' ),
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.pp-accordion-item .pp-accordion-button',
								'property'		=> 'color',
							),
						),
						'label_text_color_active'	=> array(
							'type'			=> 'color',
							'label'			=> __( 'Text Color - Active', 'bb-powerpack' ),
							'default'		=> '777777',
							'connections'	=> array( 'color' ),
							'show_reset'	=> true,
						),
						'label_border'		=> array(
							'type'				=> 'border',
							'label'         	=> __( 'Border', 'bb-powerpack' ),
							'responsive'		=> true,
							'preview'       	=> array(
								'type'          	=> 'css',
								'selector'			=> '.pp-accordion-item .pp-accordion-button',
								'important'			=> false,
							),
						),
						'label_padding'	=> array(
							'type'			=> 'dimension',
							'label'			=> __( 'Padding', 'bb-powerpack' ),
							'units'			=> array( 'px' ),
							'default'		=> '10',
							'slider'		=> true,
							'responsive'	=> true,
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.pp-accordion-item .pp-accordion-button',
								'property'		=> 'padding',
								'unit'			=> 'px',
							),
						),
					),
				),
				'content_style'       => array(
					'title'         => __( 'Content', 'bb-powerpack' ),
					'fields'        => array(
						'content_bg_color'  => array(
							'type'          => 'color',
							'label'         => __( 'Background Color', 'bb-powerpack' ),
							'default'       => 'eeeeee',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.pp-accordion-item .pp-accordion-content',
								'property'		=> 'background-color',
							),
						),
						'content_text_color'  => array(
							'type'          => 'color',
							'label'         => __( 'Text Color', 'bb-powerpack' ),
							'default'       => '333333',
							'show_reset'	=> true,
							'connections'	=> array( 'color' ),
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.pp-accordion-item .pp-accordion-content',
								'property'		=> 'color',
							),
						),
						'content_border'	=> array(
							'type'				=> 'border',
							'label'				=> __( 'Border', 'bb-powerpack' ),
							'responsive'		=> true,
							'preview'       	=> array(
								'type'          	=> 'css',
								'selector'			=> '.pp-accordion-item .pp-accordion-content',
								'important'			=> false,
							),
						),
						'content_padding'	=> array(
							'type'				=> 'dimension',
							'label'				=> __( 'Padding', 'bb-powerpack' ),
							'default'			=> '15',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
						),
					),
				),
			),
		),
		'typography' => array(
			'title'         => __( 'Typography', 'bb-powerpack' ),
			'sections'      => array(
				'label_typography'	=> array(
					'title'				=> __( 'Label', 'bb-powerpack' ),
					'fields'			=> array(
						'label_typography'	=> array(
							'type'				=> 'typography',
							'label'				=> __( 'Label Typography', 'bb-powerpack' ),
							'responsive'  		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.pp-accordion-item .pp-accordion-button .pp-accordion-button-label',
							),
						),
					),
				),
				'content_typography'	=> array(
					'title'	=> __( 'Content', 'bb-powerpack' ),
					'fields'	=> array(
						'content_typography'	=> array(
							'type'					=> 'typography',
							'label'					=> __( 'Content Typography', 'bb-powerpack' ),
							'responsive'  			=> true,
							'preview'				=> array(
								'type'					=> 'css',
								'selector'				=> '.pp-accordion-item .pp-accordion-content'
							)
						),
					)
				),
			)
		),
	)
);

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form( 'pp_accordion_items_form', array(
	'title' => __( 'Add Item', 'bb-powerpack' ),
	'tabs'  => array(
		'general'      => array(
			'title'         => __( 'General', 'bb-powerpack' ),
			'sections'      => array(
				'general'       => array(
					'title'         => '',
					'fields'        => array(
						'accordion_font_icon' => array(
							'type'          => 'icon',
							'label'         => __( 'Icon', 'bb-powerpack' ),
							'show_remove'   => true
						),
						'label'         => array(
							'type'          => 'text',
							'label'         => __( 'Label', 'bb-powerpack' ),
							'connections'   => array( 'string', 'html', 'url' ),
						)
					)
				),
				'content'       => array(
					'title'         => __( 'Content', 'bb-powerpack' ),
					'fields'        => array(
						'content_type'	=> array(
							'type'			=> 'select',
							'label'			=> __( 'Type', 'bb-powerpack' ),
							'default'		=> 'content',
							'options'		=> array(
								'content'		=> __( 'Content', 'bb-powerpack' ),
								'photo'			=> __( 'Photo', 'bb-powerpack' ),
								'video'			=> __( 'Video', 'bb-powerpack' ),
								'module'		=> __( 'Saved Module', 'bb-powerpack' ),
								'row'			=> __( 'Saved Row', 'bb-powerpack' ),
								'layout'		=> __( 'Saved Layout', 'bb-powerpack' ),
							),
							'toggle'		=> array(
								'content'		=> array(
									'fields'		=> array( 'content' )
								),
								'photo'		=> array(
									'fields'	=> array( 'content_photo' )
								),
								'video'		=> array(
									'fields'	=> array( 'content_video' )
								),
								'module'	=> array(
									'fields'	=> array( 'content_module' )
								),
								'row'		=> array(
									'fields'	=> array( 'content_row' )
								),
								'layout'	=> array(
									'fields'	=> array( 'content_layout' )
								)
							)
						),
						'content'       => array(
							'type'          => 'editor',
							'label'         => '',
							'connections'   => array( 'string', 'html', 'url' ),
						),
						'content_photo'	=> array(
							'type'			=> 'photo',
							'label'			=> __( 'Photo', 'bb-powerpack' ),
							'connections'   => array( 'photo' ),
						),
						'content_video'     => array(
							'type'              => 'textarea',
							'label'             => __( 'Embed Code / URL', 'bb-powerpack' ),
							'rows'              => 6,
							'connections'   	=> array( 'string', 'html', 'url' ),
						),
						'content_module'	=> array(
							'type'				=> 'select',
							'label'				=> __( 'Saved Module', 'bb-powerpack' ),
							'options'			=> array()
						),
						'content_row'		=> array(
							'type'				=> 'select',
							'label'				=> __( 'Saved Row', 'bb-powerpack' ),
							'options'			=> array()
						),
						'content_layout'	=> array(
							'type'				=> 'select',
							'label'				=> __( 'Saved Layout', 'bb-powerpack' ),
							'options'			=> array()
						),
					)
				)
			)
		)
	)
));
