<?php

/**
 * @class PPCategoryGridModule
 */

class PPCategoryGridModule extends FLBuilderModule {
	/**
	 * Constructor function for the module. You must pass the
	 * name, description, dir and url in an array to the parent class.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Category Grid', 'bb-powerpack' ),
				'description'     => __( 'A module to display Category.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-category-grid/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-category-grid/',
				'partial_refresh' => true,
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
			)
		);

		$this->add_css( 'jquery-swiper' );
		$this->add_js( 'jquery-swiper' );
	}

}
/**
* Register the module and its form settings.
*/
FLBuilder::register_module(
	'PPCategoryGridModule',
	array(
		'content'    => array(
			'title' => __( 'Content', 'bb-powerpack' ),
			'file'  => BB_POWERPACK_DIR . 'modules/pp-category-grid/includes/settings-content.php',
		),
		'structure'  => array(
			'title'    => __( 'Structure', 'bb-powerpack' ),

			'sections' => array(
				'config'          => array(
					'title'  => __( 'Structure', 'bb-powerpack' ),
					'fields' => array(
						'category_grid_slider' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Slider', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'sections' => array( 'slider_setting', 'slide_settings', 'pagination_style' ),
								),
								'no'  => array(
									'sections' => array(),
									'fields'   => array( 'category_columns', 'category_spacing' ),
								),
							),
						),
						'category_columns'     => array(
							'type'       => 'unit',
							'label'      => __( 'Columns', 'bb-powerpack' ),
							'default'    => '3',
							'slider'     => true,
							'responsive' => true,
						),
						'category_spacing'     => array(
							'type'       => 'unit',
							'label'      => __( 'Spacing', 'bb-powerpack' ),
							'default'    => '2',
							'units'      => array( '%' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.pp-category',
										'property' => 'margin-right',
										'unit'     => '%',
									),
									array(
										'selector' => '.pp-category',
										'property' => 'margin-bottom',
										'unit'     => '%',
									),
								),
							),
						),
						'category_height'      => array(
							'type'       => 'unit',
							'label'      => __( 'Box Height', 'bb-powerpack' ),
							'default'    => '300',
							'units'      => array( 'px' ),
							'slider'     => array(
								'px' => array(
									'min'  => 0,
									'max'  => 500,
									'step' => 1,
								),
							),
							'responsive' => true,
						),
						'category_text_align'  => array(
							'type'    => 'align',
							'label'   => __( 'Content Alignment', 'bb-powerpack' ),
							'default' => 'default',
							'options' => array(
								'default' => __( 'Default', 'bb-powerpack' ),
								'center'  => __( 'Center', 'bb-powerpack' ),
								'left'    => __( 'Left', 'bb-powerpack' ),
								'right'   => __( 'Right', 'bb-powerpack' ),
							),
						),
					),
				),
				'content_setting' => array(
					'title'  => __( 'Settings', 'bb-powerpack' ),
					'fields' => array(
						'show_empty'                 => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Empty?', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'category_show_counter'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Counter?', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields'   => array( 'category_count_text' ),
									'sections' => array( 'category_count_fonts' ),
								),
							),
						),
						'category_count_text'        => array(
							'type'    => 'text',
							'label'   => __( 'Counter Text ( Singular )', 'bb-powerpack' ),
							'default' => __( 'Post', 'bb-powerpack' ),
						),
						'category_count_text_plural' => array(
							'type'    => 'text',
							'label'   => __( 'Counter Text ( Plural )', 'bb-powerpack' ),
							'default' => __( 'Posts', 'bb-powerpack' ),
						),
						'category_show_description' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Description?', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'sections' => array( 'category_description_fonts' ),
									'fields'   => array( 'des_margin_top' ),
								),
							),
						),
						'category_show_button'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Button?', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'tabs'   => array( 'button' ),
									'fields' => array( 'category_button_text' ),
								),
							),
						),
						'category_button_text'      => array(
							'type'    => 'text',
							'label'   => __( 'Button Text', 'bb-powerpack' ),
							'default' => __( 'View More', 'bb-powerpack' ),
						),
						'category_link_target'      => array(
							'type'    => 'select',
							'label'   => __( 'Link Target', 'bb-powerpack' ),
							'options' => array(
								'_self'  => __( 'Same Window', 'bb-powerpack' ),
								'_blank' => __( 'New Window', 'bb-powerpack' ),
							),
						),
						'category_fallback_image'   => array(
							'type'        => 'photo',
							'label'       => __( 'Fallback Image', 'bb-powerpack' ),
							'connections' => array( 'photo' ),
						),
						'category_image_size'       => array(
							'type'    => 'photo-sizes',
							'label'   => __( 'Image Size', 'fl-builder' ),
							'default' => 'medium',
						),
					),
				),
				'slider_setting'  => array(
					'title'  => __( 'Slider Settings', 'bb-powerpack' ),
					'fields' => array(
						'carousel_type'    => array(
							'type'    => 'select',
							'label'   => __( 'Type', 'bb-powerpack' ),
							'default' => 'carousel',
							'options' => array(
								'carousel'  => __( 'Carousel', 'bb-powerpack' ),
								'coverflow' => __( 'Coverflow', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'carousel'  => array(
									'fields' => array( 'pagination_type', 'columns', 'slides_to_scroll' ),
								),
								'coverflow' => array(
									'fields' => array( 'pagination_type' ),
								),
							),
						),
						'columns'          => array(
							'type'       => 'unit',
							'label'      => __( 'Slides Per View', 'bb-powerpack' ),
							'default'    => 3,
							'slider'     => true,
							'responsive' => array(
								'placeholder' => array(
									'default'    => '3',
									'medium'     => '2',
									'responsive' => '1',
								),
							),
						),
						'slides_to_scroll' => array(
							'type'       => 'unit',
							'label'      => __( 'Slides to Scroll', 'bb-powerpack' ),
							'default'    => 1,
							'slider'     => true,
							'responsive' => array(
								'placeholder' => array(
									'default'    => '1',
									'medium'     => '1',
									'responsive' => '1',
								),
							),
							'help'       => __( 'Set numbers of slides to move at a time.', 'bb-powerpack' ),
						),
						'spacing'          => array(
							'type'       => 'unit',
							'label'      => __( 'Spacing', 'bb-powerpack' ),
							'default'    => 10,
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => array(
								'placeholder' => array(
									'default'    => '10',
									'medium'     => '10',
									'responsive' => '10',
								),
							),
						),
					),
				),
			),
		),
		'button'     => array(
			'title'    => __( 'Button', 'bb-powerpack' ),
			'sections' => array(
				'button_structure' => array(
					'title'  => __( 'Structure', 'bb-powerpack' ),
					'fields' => array(
						'button_alignment'     => array(
							'type'    => 'align',
							'label'   => __( 'Alignment', 'bb-powerpack' ),
							'default' => '',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper',
								'property' => 'text-align',
							),
						),
						'button_width'         => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Width', 'bb-powerpack' ),
							'default' => 'auto',
							'options' => array(
								'auto'       => __( 'Auto', 'bb-powerpack' ),
								'full_width' => __( 'Full Width', 'bb-powerpack' ),
								'custom'     => __( 'Custom', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'custom' => array(
									'fields' => array( 'button_width_custom' ),
								),
							),
						),
						'button_width_custom'  => array(
							'type'       => 'unit',
							'label'      => __( 'Custom Width', 'bb-powerpack' ),
							'units'      => array( '%' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper .pp-category__button',
								'property' => 'width',
								'unit'     => '%',
							),
						),
						'button_padding'       => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'units'      => array( 'px' ),
							'slider'     => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper .pp-category__button',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
						'button_margin_top'    => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Top', 'bb-powerpack' ),
							'default'    => 10,
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'button_margin_bottom' => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Bottom', 'bb-powerpack' ),
							'default'    => 15,
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
					),
				),
				'button_color'     => array(
					'title'     => __( 'Colors', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'button_bg_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper .pp-category__button',
								'property' => 'background-color',
							),
						),
						'button_bg_color_hover' => array(
							'type'       => 'color',
							'label'      => __( 'Background Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
						),
						'button_color'          => array(
							'type'       => 'color',
							'label'      => __( 'Text Color', 'bb-powerpack' ),
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper .pp-category__button',
								'property' => 'color',
							),
						),
						'button_color_hover'    => array(
							'type'       => 'color',
							'label'      => __( 'Text Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
						),
					),
				),
				'button_border'    => array(
					'title'     => __( 'Border', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'button_border_group'       => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper .pp-category__button',
							),
						),
						'button_border_color_hover' => array(
							'type'       => 'color',
							'label'      => __( 'Border Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
						),
					),
				),
			),
		),
		'style'      => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'box_styles'       => array(
					'title'     => __( 'Box', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'box_border_group' => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category',
							),
						),
					),
				),
				'overlay_styles'   => array(
					'title'  => __( 'Content', 'bb-powerpack' ),
					'fields' => array(
						'category_bg_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-powerpack' ),
							'default'    => 'fff192',
							'show_reset' => true,
							'show_alpha' => true,
						),
						'category_bg_color_hover' => array(
							'type'       => 'color',
							'label'      => __( 'Background Hover Color', 'bb-powerpack' ),
							'default'    => 'ffffff',
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
						'category_bg_opacity'     => array(
							'type'        => 'text',
							'label'       => __( 'Image Opacity', 'bb-powerpack' ),
							'default'     => '1',
							'description' => __( 'Between 0 to 1', 'bb-powerpack' ),
							'slider'      => array(
								'px' => array(
									'min'  => 0,
									'max'  => 1,
									'step' => .01,
								),
							),
							'size'        => '5',
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-category .category-inner .pp-category__img img',
								'property' => 'opacity',
							),
						),
						'overlay_border_group'    => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__content',
							),
						),
						'category_padding'        => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => 10,
							'units'      => array( 'px' ),
							'responsive' => true,
							'slider'     => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__content',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'overlay_width'           => array(
							'type'       => 'unit',
							'label'      => __( 'Width', 'bb-powerpack' ),
							'default'    => '100',
							'slider'     => true,
							'units'      => array( '%' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .category-inner .pp-category__content',
								'property' => 'width',
								'unit'     => '% !important',
							),
						),
						'overlay_vertical_align'  => array(
							'type'    => 'select',
							'label'   => __( 'Vertical Alignment', 'bb-powerpack' ),
							'default' => 'bottom',
							'options' => array(
								'top'    => __( 'Top', 'bb-powerpack' ),
								'middle' => __( 'Middle', 'bb-powerpack' ),
								'bottom' => __( 'Bottom', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'bottom' => array(
									'fields' => array( 'overlay_bottom_margin' ),
								),
								'top' => array(
									'fields' => array( 'overlay_bottom_margin' ),
								),
							),
						),
						'overlay_bottom_margin'   => array(
							'type'       => 'unit',
							'label'      => __( 'Spacing', 'bb-powerpack' ),
							'default'    => '0',
							'responsive' => 'true',
							'units'      => array( 'px' ),
							'slider'     => true,
							// 'preview'    => array(
							// 	'type'     => 'css',
							// 	'selector' => '.pp-category .pp-category__content',
							// 	'property' => 'margin-bottom',
							// 	'unit'     => 'px',
							// ),
						),
						'des_margin_top'          => array(
							'type'       => 'unit',
							'label'      => __( 'Description Margin Top', 'bb-powerpack' ),
							'units'      => array( 'px' ),
							'responsive' => true,
							'slider'     => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__description',
								'property' => 'margin-top',
								'unit'     => 'px',
							),
						),
					),
				),
				'slide_settings'   => array(
					'title'  => __( 'Slider Settings', 'bb-powerpack' ),
					'fields' => array(
						'transition_speed'     => array(
							'type'        => 'text',
							'label'       => __( 'Transition Speed', 'bb-powerpack' ),
							'default'     => '1000',
							'size'        => '5',
							'description' => _x( 'ms', 'Value unit for form field of time in mili seconds. Such as: "500 ms"', 'bb-powerpack' ),
						),
						'autoplay'             => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Auto Play', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'autoplay_speed' ),
								),
							),
						),
						'autoplay_speed'       => array(
							'type'        => 'text',
							'label'       => __( 'Auto Play Speed', 'bb-powerpack' ),
							'default'     => '5000',
							'size'        => '5',
							'description' => _x( 'ms', 'Value unit for form field of time in mili seconds. Such as: "500 ms"', 'bb-powerpack' ),
						),
						'pause_on_interaction' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Pause on Interaction', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'slider_navigation'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Navigation Arrows?', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'sections' => array( 'arrow_style' ),
								),
							),
						),
						'pagination_type'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Pagination Type', 'bb-powerpack' ),
							'default' => 'bullets',
							'options' => array(
								'none'        => __( 'None', 'bb-powerpack' ),
								'bullets'     => __( 'Dots', 'bb-powerpack' ),
								'fraction'    => __( 'Fraction', 'bb-powerpack' ),
								'progressbar' => __( 'Progress', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'bullets'  => array(
									'sections' => array(),
									'fields'   => array( 'bullets_width', 'bullets_border_radius' ),
								),
								'fraction' => array(
									'sections' => array(),
								),
								'progress' => array(
									'sections' => array(),
								),
							),
						),
					),
				),
				'pagination_style' => array(
					'title'  => __( 'Pagination', 'bb-powerpack' ),
					'fields' => array(
						'pagination_bg_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'default'     => '999999',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.pp-categories-container .swiper-pagination-bullet, .pp-categories-container.swiper-container-horizontal>.swiper-pagination-progress, .pp-categories-container .swiper-pagination-progressbar',
										'property' => 'background-color',
									),
									array(
										'selector' => '.pp-categories-container .swiper-pagination-fraction .swiper-pagination-total',
										'property' => 'color',
									),
								),
							),
						),
						'pagination_bg_hover'   => array(
							'type'        => 'color',
							'label'       => __( 'Active Color', 'bb-powerpack' ),
							'default'     => '000000',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.pp-categories-container .swiper-pagination-bullet:hover, .pp-categories-container .swiper-pagination-bullet-active, .pp-categories-container .swiper-pagination-progress .swiper-pagination-progressbar,.pp-categories-container .swiper-pagination-progressbar .swiper-pagination-progressbar-fill',
										'property' => 'background-color',
									),
									array(
										'selector' => '.pp-categories-container .swiper-pagination-fraction .swiper-pagination-current',
										'property' => 'color',
									),
								),
							),
						),
						'bullets_width'         => array(
							'type'    => 'unit',
							'label'   => __( 'Bullets Size', 'bb-powerpack' ),
							'default' => '10',
							'units'   => array( 'px' ),
							'slider'  => true,
							'preview' => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.pp-categories-container .swiper-pagination-bullet',
										'property' => 'width',
										'unit'     => 'px',
									),
									array(
										'selector' => '.pp-categories-container .swiper-pagination-bullet',
										'property' => 'height',
										'unit'     => 'px',
									),
								),
							),
						),
						'bullets_border_radius' => array(
							'type'    => 'unit',
							'label'   => __( 'Bullets Round Corners', 'bb-powerpack' ),
							'default' => '50',
							'units'   => array( '%' ),
							'slider'  => true,
							'preview' => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container .swiper-pagination-bullet',
								'property' => 'border-radius',
								'unit'     => '%',
							),
						),
						'bullets_top_margin'    => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Top', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container.swiper-container-horizontal > .swiper-pagination-bullets, .pp-categories-container .swiper-pagination-fraction',
								'property' => 'padding-top',
								'unit'     => 'px',
							),
						),
					),
				),
				'arrow_style'      => array(
					'title'  => __( 'Navigation Arrows', 'bb-powerpack' ),
					'fields' => array(
						'arrow_size'                   => array(
							'type'    => 'unit',
							'label'   => __( 'Size', 'bb-powerpack' ),
							'default' => '30',
							'units'   => array( 'px' ),
							'slider'  => true,
							'preview' => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.pp-categories-container .swiper-button-prev, .pp-categories-container .swiper-button-next',
										'property' => 'width',
									),
									array(
										'selector' => '.pp-categories-container .swiper-button-prev, .pp-categories-container .swiper-button-next',
										'property' => 'height',
									),
								),
							),
						),
						'arrow_border'                 => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container .swiper-button-prev, .pp-categories-container .swiper-button-next',
							),
						),
						'arrow_color'                  => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container .swiper-button-prev svg, .pp-categories-container .swiper-button-next svg',
								'property' => 'fill',
							),
						),
						'arrow_color_hover'            => array(
							'type'       => 'color',
							'label'      => __( 'Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container .swiper-button-prev:hover svg, .pp-categories-container .swiper-button-next:hover svg',
								'property' => 'fill',
							),
						),
						'arrow_background_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container .swiper-button-prev, .pp-categories-container .swiper-button-next',
								'property' => 'background-color',
							),
						),
						'arrow_background_hover_color' => array(
							'type'       => 'color',
							'label'      => __( 'Background Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-categories-container .swiper-button-prev:hover, .pp-categories-container .swiper-button-next:hover',
								'property' => 'background-color',
							),
						),
					),
				),
			),
		),
		'typography' => array(
			'title'    => __( 'Typography', 'bb-powerpack' ),
			'sections' => array(
				'category_title_fonts'       => array(
					'title'  => __( 'Category Title', 'bb-powerpack' ),
					'fields' => array(
						'category_title_tag'         => array(
							'type'    => 'select',
							'label'   => __( 'Tag', 'bb-powerpack' ),
							'default' => 'h3',
							'options' => array(
								'h1' => 'h1',
								'h2' => 'h2',
								'h3' => 'h3',
								'h4' => 'h4',
								'h5' => 'h5',
								'h6' => 'h6',
							),
						),
						'category_title_typography'  => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__title',
							),
						),
						'category_title_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__title',
								'property' => 'color',
							),
						),
						'category_title_hover_color' => array(
							'type'       => 'color',
							'label'      => __( 'Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
					),
				),
				'category_count_fonts'       => array(
					'title'  => __( 'Category Count', 'bb-powerpack' ),
					'fields' => array(
						'category_count_typography'  => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__content span.pp-category-count',
							),
						),
						'category_count_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__title span, .pp-category .category-style-0 .pp-category__title_wrapper span',
								'property' => 'color',
							),
						),
						'category_count_hover_color' => array(
							'type'       => 'color',
							'label'      => __( 'Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
					),
				),
				'category_description_fonts' => array(
					'title'  => __( 'Category Description', 'bb-powerpack' ),
					'fields' => array(
						'category_description_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__description',
							),
						),
						'category_description_color'      => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category .pp-category__description',
								'property' => 'color',
							),
						),
						'category_description_hover_color' => array(
							'type'       => 'color',
							'label'      => __( 'Description Hover Color', 'bb-powerpack' ),
							'show_reset' => true,
							'show_alpha' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
					),
				),
				'button_font'                => array(
					'title'     => __( 'Typography', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'button_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Button Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-category__button_wrapper .pp-category__button',
							),
						),
					),
				),
			),
		),
	)
);
