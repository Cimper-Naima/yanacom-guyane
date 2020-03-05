<?php
/**
 * @class PPFAQModule
 */
class PPFAQModule extends FLBuilderModule {

	private $_schema_rendered = false;

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'FAQ', 'bb-powerpack' ),
				'description'     => __( 'Display a collapsible FAQ of items.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-faq/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-faq/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);

		$this->add_css( BB_POWERPACK()->fa_css );
	}

	public function filter_settings( $settings, $helper ) {
		if ( isset( $settings->collapse ) ) {
			if ( '0' === $settings->collapse ) {
				$settings->collapse = 'no';
			}
			if ( '1' === $settings->collapse ) {
				$settings->collapse = 'yes';
			}
		}

		return $settings;
	}

	/**
	 * Render content.
	 */
	public function render_content( $item, $embed = true ) {
		if ( ! $embed ) {
			$text = ! empty( $item->answer ) ? json_encode( $item->answer ) : '';
			return $text;
		}

		global $wp_embed;

		$html  = '';
		$html .= wpautop( $wp_embed->autoembed( $item->answer ) );

		return $html;
	}

	/**
	 * Render schema markup.
	 */
	public function render_schema( $return = false ) {
		$settings      = $this->settings;
		$enable_schema = true;

		if ( isset( $settings->enable_schema ) && 'no' === $settings->enable_schema ) {
			$enable_schema = false;
		}

		if ( ! $enable_schema ) {
			return;
		}

		if ( $this->_schema_rendered ) {
			return;
		}

		// @codingStandardsIgnoreStart.
		$schema_data = array(
			"@context" => "https://schema.org",
			"@type" => "FAQPage",
			"mainEntity" => array(),
		);

		$items = $this->get_faq_items();

		for ( $i = 0; $i < count( $items ); $i++ ) {
			if ( ! is_object( $items[ $i ] ) ) {
				continue;
			}

			$item = (object) array(
				"@type" => "Question",
				"name" => $items[ $i ]->faq_question,
				"acceptedAnswer" => (object) array(
					"@type" => "Answer",
					"text" => $items[ $i ]->answer,
				),
			);

			$schema_data['mainEntity'][] = $item;
		}
		// @codingStandardsIgnoreEnd.

		if ( $return ) {
			return $schema_data;
		}

		$schema_data = apply_filters( 'pp_faq_schema_markup', $schema_data, $settings );
		?>
		<script type="application/ld+json">
		<?php echo json_encode( $schema_data ); ?>
		</script>
		<?php

		$this->_schema_rendered = true;
	}

	public static function get_general_fields() {
		$fields = array(
			'faq_source' => array(
				'type'    => 'select',
				'label'   => __( 'Source', 'bb-powerpack' ),
				'default' => '',
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
			'items'      => array(
				'type'         => 'form',
				'label'        => __( 'FAQ', 'bb-powerpack' ),
				'form'         => 'pp_faq_items_form', // ID from registered form below
				'preview_text' => 'faq_question', // Name of a field to use for the preview text
				'multiple'     => true,
			),
		);

		if ( class_exists( 'acf' ) ) {
			$fields['faq_source']['options']['acf']          = __( 'ACF Repeater Field', 'bb-powerpack' );
			$fields['faq_source']['toggle']['acf']['fields'] = array( 'acf_repeater_name', 'acf_repeater_question', 'acf_repeater_answer' );

			$fields['acf_repeater_name']     = array(
				'type'        => 'text',
				'label'       => __( 'ACF Repeater Field Name', 'bb-powerpack' ),
				'connections' => array( 'string' ),
			);
			$fields['acf_repeater_question'] = array(
				'type'        => 'text',
				'label'       => __( 'ACF Repeater Sub Field Name (Question)', 'bb-powerpack' ),
				'connections' => array( 'string' ),
			);
			$fields['acf_repeater_answer']   = array(
				'type'        => 'text',
				'label'       => __( 'ACF Repeater Sub Field Name (Answer)', 'bb-powerpack' ),
				'connections' => array( 'string' ),
			);
		}

		return $fields;
	}

	public function get_acf_data( $post_id = false ) {
		if ( ! isset( $this->settings->acf_repeater_name ) || empty( $this->settings->acf_repeater_name ) ) {
			return;
		}

		$data    = array();
		$post_id = apply_filters( 'pp_faq_acf_post_id', $post_id );

		$repeater_name = $this->settings->acf_repeater_name;
		$question_name = $this->settings->acf_repeater_question;
		$answer_name   = $this->settings->acf_repeater_answer;

		$repeater_rows = get_field( $repeater_name, $post_id );

		if ( ! $repeater_rows ) {
			return;
		}

		foreach ( $repeater_rows as $row ) {
			$item               = new stdClass;
			$item->faq_question = isset( $row[ $question_name ] ) ? $row[ $question_name ] : '';
			$item->answer       = isset( $row[ $answer_name ] ) ? $row[ $answer_name ] : '';

			$data[] = $item;
		}

		return $data;
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
			$item               = new stdClass;
			$item->faq_question = isset( $row->post_title ) ? $row->post_title : '';
			$item->answer       = isset( $row->post_content ) ? $row->post_content : '';

			$data[] = $item;
		}
		return $data;
	}

	public function get_faq_items() {
		if ( ! isset( $this->settings->faq_source ) || empty( $this->settings->faq_source ) ) {
			return $this->settings->items;
		}

		if ( 'acf' === $this->settings->faq_source ) {
			return $this->get_acf_data();
		}

		if ( 'post' === $this->settings->faq_source ) {
			return $this->get_cpt_data();
		}

		return $this->settings->items;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPFAQModule',
	array(
		'items'      => array(
			'title'    => __( 'FAQ', 'bb-powerpack' ),
			'sections' => array(
				'schema_markup' => array(
					'title'  => 'Schema Markup',
					'fields' => array(
						'enable_schema' => array(
							'type'        => 'pp-switch',
							'label'       => __( 'Enable Schema Markup', 'bb-powerpack' ),
							'default'     => 'yes',
							'options'     => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'description' => __( '<br>Enable Schema Markup if you are setting up a unique FAQ page on your website. The module adds FAQ Page schema to the page as per Google\'s Structured Data guideline.<br><a target="_blank" rel="noopener" href="https://developers.google.com/search/docs/data-types/faqpage"><b style="color: #2d7ea2;">Click here</b></a> for more details.', 'bb-powerpack' ),
						),
					),
				),
				'faq_general'   => array(
					'title'  => __( 'FAQ Items', 'bb-powerpack' ),
					'fields' => PPFAQModule::get_general_fields(),
				),
				'post_content'  => array(
					'title' => __( 'Content', 'bb-powerpack' ),
					'file'  => BB_POWERPACK_DIR . 'modules/pp-faq/includes/loop-settings.php',
				),
				'faq_settings'  => array(
					'title'     => __( 'Settings', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'expand_option'       => array(
							'type'    => 'select',
							'label'   => __( 'Expand', 'bb-powerpack' ),
							'default' => 'first',
							'options' => array(
								'first'  => __( 'First Item', 'bb-powerpack' ),
								'custom' => __( 'Custom Item', 'bb-powerpack' ),
								'all'    => __( 'All', 'bb-powerpack' ),
								'none'   => __( 'None', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'first'  => array(
									'fields' => array( 'collapse' ),
								),
								'custom' => array(
									'fields' => array( 'open_custom', 'collapse' ),
								),
							),
						),
						'open_custom'         => array(
							'type'    => 'text',
							'label'   => __( 'Expand Custom', 'bb-powerpack' ),
							'default' => '',
							'size'    => 5,
							'help'    => __( 'Add item number to expand by default.', 'bb-powerpack' ),
						),
						'collapse'            => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Collapse Inactive', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'help'    => __( 'Choosing yes will keep only one item open at a time. Choosing no will allow multiple items to be open at the same time.', 'bb-powerpack' ),
							'preview' => array(
								'type' => 'none',
							),
						),
						'responsive_collapse' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Responsive Collapse All', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'help'    => __( 'Items will not appear as expanded on responsive devices until user clicks on it.', 'bb-powerpack' ),
						),
						'faq_id_prefix'       => array(
							'type'        => 'text',
							'label'       => __( 'Custom ID Prefix', 'bb-powerpack' ),
							'default'     => '',
							'placeholder' => __( 'myfaq', 'bb-powerpack' ),
							'help'        => __( 'A prefix that will be applied to ID attribute of faq items in HTML. For example, prefix "myfaq" will be applied as "myfaq-1", "myfaq-2" in ID attribute of faq item 1 and faq item 2 respectively. It should only contain dashes, underscores, letters or numbers. No spaces.', 'bb-powerpack' ),
						),
					),
				),
			),
		),
		'icon_style' => array(
			'title'    => __( 'Icon', 'bb-powerpack' ),
			'sections' => array(
				'responsive_toggle_icons' => array(
					'title'  => __( 'Toggle Icons', 'bb-powerpack' ),
					'fields' => array(
						'faq_open_icon'               => array(
							'type'        => 'icon',
							'label'       => __( 'Open Icon', 'bb-powerpack' ),
							'show_remove' => true,
						),
						'faq_close_icon'              => array(
							'type'        => 'icon',
							'label'       => __( 'Close Icon', 'bb-powerpack' ),
							'show_remove' => true,
						),
						'faq_toggle_icon_position'    => array(
							'type'    => 'select',
							'label'   => __( 'Icon Position', 'bb-powerpack' ),
							'default' => 'right',
							'options' => array(
								'left'  => __( 'Left', 'bb-powerpack' ),
								'right' => __( 'Right', 'bb-powerpack' ),
							),
						),
						'faq_toggle_icon_spacing'     => array(
							'type'       => 'unit',
							'label'      => __( 'Spacing', 'bb-powerpack' ),
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'default'    => '15',
						),
						'faq_toggle_icon_size'        => array(
							'type'       => 'unit',
							'label'      => __( 'Size', 'bb-powerpack' ),
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'default'    => '14',
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button-icon, .pp-faq-item .pp-faq-button-icon:before',
								'property' => 'font-size',
							),
						),
						'faq_toggle_icon_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button-icon',
								'property' => 'color',
							),
						),
						'faq_toggle_icon_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Hover Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
					),
				),
			),
		),
		'style'      => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'box_style'       => array(
					'title'  => __( 'Box Style', 'bb-powerpack' ),
					'fields' => array(
						'item_spacing' => array(
							'type'       => 'unit',
							'label'      => __( 'Item Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'box_border'   => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
						),
					),
				),
				'questions_style' => array(
					'title'     => __( 'Questions', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'qus_bg_color_default'   => array(
							'type'        => 'color',
							'label'       => __( 'Background Color - Default', 'bb-powerpack' ),
							'default'     => 'dddddd',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button',
								'property' => 'background-color',
							),
						),
						'qus_bg_color_active'    => array(
							'type'        => 'color',
							'label'       => __( 'Background Color - Active/Hover', 'bb-powerpack' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button:hover, .pp-faq-item.pp-faq-item-active .pp-faq-button',
								'property' => 'background-color',
							),
						),
						'qus_text_color_default' => array(
							'type'        => 'color',
							'label'       => __( 'Text Color - Default', 'bb-powerpack' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button .pp-faq-button-label',
								'property' => 'color',
							),
						),
						'qus_text_color_active'  => array(
							'type'        => 'color',
							'label'       => __( 'Text Color - Active/Hover', 'bb-powerpack' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button:hover .pp-faq-button-label, .pp-faq-item.pp-faq-item-active .pp-faq-button .pp-faq-button-label',
								'property' => 'color',
							),
						),
						'qus_padding'            => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'units'      => array( 'px' ),
							'default'    => '10',
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
					),
				),
				'answer_style'    => array(
					'title'     => __( 'Answer', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'answer_bg_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'default'     => 'eeeeee',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-content',
								'property' => 'background-color',
							),
						),
						'answer_text_color' => array(
							'type'        => 'color',
							'label'       => __( 'Text Color', 'bb-powerpack' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-content',
								'property' => 'color',
							),
						),
						'answer_border'     => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'      => 'css',
								'selector'  => '.pp-faq-item .pp-faq-content',
								'important' => false,
							),
						),
						'answer_padding'    => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '15',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-content',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
					),
				),
			),
		),
		'typography' => array(
			'title'    => __( 'Typography', 'bb-powerpack' ),
			'sections' => array(
				'qus_typography'    => array(
					'title'  => __( 'Questions', 'bb-powerpack' ),
					'fields' => array(
						'qus_tag'        => array(
							'type'    => 'select',
							'label'   => __( 'HTML Tag', 'bb-powerpack' ),
							'default' => 'span',
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
						'qus_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Questions Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-button .pp-faq-button-label',
							),
						),
					),
				),
				'answer_typography' => array(
					'title'     => __( 'Answer', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'answer_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Answer Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-faq-item .pp-faq-content',
							),
						),
					),
				),
			),
		),
	)
);

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form(
	'pp_faq_items_form',
	array(
		'title' => __( 'Add FAQ', 'bb-powerpack' ),
		'tabs'  => array(
			'general' => array(
				'title'    => __( 'General', 'bb-powerpack' ),
				'sections' => array(
					'general' => array(
						'title'  => '',
						'fields' => array(
							'faq_question' => array(
								'type'        => 'text',
								'label'       => __( 'Question', 'bb-powerpack' ),
								'default'     => __( 'FAQ', 'bb-powerpack' ),
								'connections' => array( 'string', 'html', 'url' ),
							),
							'answer'       => array(
								'type'        => 'editor',
								'label'       => __( 'Answer', 'bb-powerpack' ),
								'connections' => array( 'string', 'html', 'url' ),
							),
						),
					),
				),
			),
		),
	)
);
