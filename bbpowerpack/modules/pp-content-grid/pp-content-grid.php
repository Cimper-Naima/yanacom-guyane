<?php

/**
 * @class PPContentGridModule
 */
class PPContentGridModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Content Grid', 'bb-powerpack'),
			'description'   	=> __('Display posts and pages in grid or carousel format.', 'bb-powerpack'),
			'group'         	=> pp_get_modules_group(),
            'category'			=> pp_get_modules_cat( 'content' ),
            'dir'           	=> BB_POWERPACK_DIR . 'modules/pp-content-grid/',
            'url'           	=> BB_POWERPACK_URL . 'modules/pp-content-grid/',
			'partial_refresh'	=> true,
		));

		add_filter( 'fl_builder_loop_query_args', array( $this, 'exclude_current_post' ), 10, 1 );
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		$this->add_js( 'imagesloaded' );

		if(FLBuilderModel::is_builder_active() || $this->settings->layout == 'grid') {
			$this->add_js( 'jquery-isotope' );
		}

		if(FLBuilderModel::is_builder_active() || $this->settings->layout == 'carousel') {
			$this->add_css( BB_POWERPACK()->fa_css );
			$this->add_css( 'owl-carousel' );
			$this->add_css( 'owl-carousel-theme' );
			$this->add_js( 'owl-carousel' );
		}

		// Jetpack sharing has settings to enable sharing on posts, post types and pages.
		// If pages are disabled then jetpack will still show the share button in this module
		// but will *not* enqueue its scripts and fonts.
		// This filter forces jetpack to enqueue the sharing scripts.
		add_filter( 'sharing_enqueue_scripts', '__return_true' );
	}

	/**
	 * @since 1.3.1
	 */
	public function update( $settings ) {
		global $wp_rewrite;
		$wp_rewrite->flush_rules( false );
		return $settings;
	}


	/**
	 * Renders the schema structured data for the current
	 * post in the loop.
	 *
	 * @return void
	 */
	static public function schema_meta()
	{
		BB_PowerPack_Post_Helper::schema_meta();
	}

	/**
	 * Renders the schema itemtype for the current
	 * post in the loop.
	 *
	 * @return void
	 */
	static public function schema_itemtype()
	{
		BB_PowerPack_Post_Helper::schema_itemtype();
	}

	public function pp_get_settings() {
		return $this->settings;
	}

	public function exclude_current_post( $args ) {
		if ( ! isset( $args['settings'] ) ) {
			return $args;
		}

		$settings = $args['settings'];

		if ( ! isset( $settings->pp_content_grid ) || ! $settings->pp_content_grid ) {
			return $args;
		}

		if ( ! isset( $settings->exclude_current_post ) || 'no' == $settings->exclude_current_post ) {
			return $args;
		}

		if ( ! isset( $settings->pp_post_id ) ) {
			return $args;
		}

		if ( isset( $args['post__in'] ) && is_array( $args['post__in'] ) ) {
			$args['post__in'] = array_diff( $args['post__in'], array( $settings->pp_post_id ) );
		}
		
		if ( ! isset( $args['post__not_in'] ) || ! is_array( $args['post__not_in'] ) ) {
			$args['post__not_in'] = array();
		}

		$args['post__not_in'][] = $settings->pp_post_id;

		return $args;
	}

	public function filter_settings( $settings, $helper ) {
		// Handle old post background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'post_background', array(
			'primary'	=> 'post_bg_color',
			'secondary'	=> 'post_bg_color_hover',
		) );

		// Handle old post border fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'post_border'		=> array(
				'type'				=> 'style'
			),
			'post_border_color'	=> array(
				'type'				=> 'color'
			),
			'post_shadow'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->post_shadow_display ) && 'yes' == $settings->post_shadow_display )
			),
			'post_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->post_shadow_display ) && 'yes' == $settings->post_shadow_display ),
				'opacity'			=> ( isset( $settings->post_shadow_opacity ) && ! empty( $settings->post_shadow_opacity ) ) ? $settings->post_shadow_opacity / 100 : 1
			),
			'post_border_radius'	=> array(
				'type'					=> 'radius'
			),
		), 'post_border_group' );
		
		if ( isset( $settings->post_border_position ) && isset( $settings->post_border_group ) ) {
			if ( isset( $settings->post_border_width ) ) {
				if ( empty( $settings->post_border_position ) ) {
					$settings->post_border_group['width']['top'] = $settings->post_border_width;
					$settings->post_border_group['width']['bottom'] = $settings->post_border_width;
					$settings->post_border_group['width']['left'] = $settings->post_border_width;
					$settings->post_border_group['width']['right'] = $settings->post_border_width;
				} else {
					$settings->post_border_group['width'][ $settings->post_border_position ] = $settings->post_border_width;
				}
			}
		}

		// Handle old post padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'post_grid_padding', 'padding', 'post_grid_padding' );

		// Handle old post content padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'post_content_padding', 'padding', 'post_content_padding' );

		// Handle old button background dual color fields.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'button_background', array(
			'primary'	=> 'button_bg_color',
			'secondary'	=> 'button_bg_hover_color',
		) );


		/****************************
		 * Button
		 ****************************/

		// Handle old button text dual color fields.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'button_color', array(
			'primary'	=> 'button_text_color',
			'secondary'	=> 'button_text_hover_color',
		) );

		// Handle old button border fields.
		$button_border_color = '';
		if ( isset( $settings->button_border_color ) && is_array( $settings->button_border_color ) ) {
			$button_border_color = $settings->button_border_color['primary'];
			$settings->button_border_hover_color = $settings->button_border_color['secondary'];
		}
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'button_border'	=> array(
				'type'			=> 'style'
			),
			'button_border_width'	=> array(
				'type'			=> 'width'
			),
			'button_border_color'	=> array(
				'type'			=> 'color',
				'value'			=> $button_border_color
			),
			'button_border_radius'	=> array(
				'type'			=> 'radius'
			)
		), 'button_border_group' );

		// Handle old button padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'button_padding', 'padding' );

		/****************************
		 * Pagination
		 ****************************/

		// Handle old pagination padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'pagination_padding', 'padding' );

		// Handle old pagination background dual color fields.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'pagination_background_color', array(
			'primary'	=> 'pagination_bg_color',
			'secondary'	=> 'pagination_bg_color_hover'
		) );
		
		// Handle old pagination text dual color fields.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'pagination_text_color', array(
			'primary'	=> 'pagination_color',
			'secondary'	=> 'pagination_color_hover'
		) );

		// Handle old pagination border fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'pagination_border'	=> array(
				'type'			=> 'style'
			),
			'pagination_border_width'	=> array(
				'type'			=> 'width'
			),
			'pagination_border_color'	=> array(
				'type'			=> 'color'
			),
			'pagination_border_radius'	=> array(
				'type'			=> 'radius'
			)
		), 'pagination_border_group' );

		/****************************
		 * Filter
		 ****************************/

		// Handle old filter background dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'filter_background', array(
			'primary'	=> 'filter_bg_color',
			'secondary'	=> 'filter_bg_color_active'
		) );

		// Handle old filter text dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'filter_color', array(
			'primary'	=> 'filter_text_color',
			'secondary'	=> 'filter_text_color_active'
		) );

		// Handle old filter border fields.
		$filter_border_color = '';
		if ( isset( $settings->filter_border_color ) && is_array( $settings->filter_border_color ) ) {
			$filter_border_color = $settings->filter_border_color['primary'];
			$settings->filter_border_hover_color = $settings->filter_border_color['secondary'];
		}
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'filter_border'		=> array(
				'type'				=> 'style'
			),
			'filter_border_width'	=> array(
				'type'				=> 'width'
			),
			'filter_border_color'	=> array(
				'type'				=> 'color',
				'value'				=> $filter_border_color
			),
			'filter_border_radius'	=> array(
				'type'				=> 'radius'
			)
		), 'filter_border_group' );

		// Handle old filter padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'filter_padding', 'padding' );

		// Handle old filter toggle border fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'filter_toggle_border'	=> array(
				'type'			=> 'width'
			),
			'filter_toggle_border_color'	=> array(
				'type'			=> 'color'
			),
			'filter_toggle_radius'	=> array(
				'type'			=> 'radius'
			)
		), 'filter_toggle_border_group' );

		/****************************
		 * Typography
		 ****************************/

		// Handle old title typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'title_font'		=> array(
				'type'				=> 'font'
			),
			'title_custom_font_size'	=> array(
				'type'				=> 'font_size',
				'condition'			=> ( isset( $settings->title_font_size_toggle ) && 'custom' == $settings->title_font_size_toggle )
			),
			'title_custom_line_height'	=> array(
				'type'				=> 'line_height',
				'condition'			=> ( isset( $settings->title_line_height_toggle ) && 'custom' == $settings->title_line_height_toggle )
			),
			'title_text_transform'	=> array(
				'type'					=> 'text_transform'
			)
		), 'title_typography' );

		// Handle old content typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'content_font'		=> array(
				'type'				=> 'font'
			),
			'content_custom_font_size'	=> array(
				'type'				=> 'font_size',
				'condition'			=> ( isset( $settings->content_font_size_toggle ) && 'custom' == $settings->content_font_size_toggle )
			),
			'content_custom_line_height'	=> array(
				'type'				=> 'line_height',
				'condition'			=> ( isset( $settings->content_line_height_toggle ) && 'custom' == $settings->content_line_height_toggle )
			)
		), 'content_typography' );

		// Handle old meta typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'post_meta_font'	=> array(
				'type'				=> 'font'
			),
			'post_meta_font_size'	=> array(
				'type'				=> 'font_size'
			),
			'post_meta_text_transform'	=> array(
				'type'				=> 'text_transform'
			)
		), 'meta_typography' );

		// Handle old button typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'button_font'	=> array(
				'type'				=> 'font'
			),
			'button_font_size'	=> array(
				'type'				=> 'font_size'
			),
			'button_text_transform'	=> array(
				'type'				=> 'text_transform'
			)
		), 'button_typography' );

		// Handle old filter typography fields.
		$settings = PP_Module_Fields::handle_typography_field( $settings, array(
			'filter_font'	=> array(
				'type'				=> 'font'
			),
			'filter_font_size'	=> array(
				'type'				=> 'font_size'
			),
			'filter_text_transform'	=> array(
				'type'				=> 'text_transform'
			)
		), 'filter_typography' );

		// Handle old pagination font size field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'pagination_font_size', 'responsive' );

		/****************************
		 * Slider
		 ****************************/

		// Handle old slider arrow dual color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'post_slider_arrow_color', array(
			'primary'	=> 'arrow_color',
			'secondary'	=> 'arrow_hover_color'
		) );

		// Handle old slider arrow dual background color field.
		$settings = PP_Module_Fields::handle_dual_color_field( $settings, 'post_slider_arrow_bg_color', array(
			'primary'	=> 'arrow_bg_color',
			'secondary'	=> 'arrow_bg_hover_color'
		) );

		// Handle old slider arrow border field.
		$arrow_border_color = '';
		if ( isset( $settings->post_slider_arrow_border_color ) && is_array( $settings->post_slider_arrow_border_color ) ) {
			$arrow_border_color = $settings->post_slider_arrow_border_color['primary'];
			$settings->arrow_border_hover_color = $settings->post_slider_arrow_border_color['secondary'];
		}
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'post_slider_arrow_border_style'	=> array(
				'type'			=> 'style'
			),
			'post_slider_arrow_border_width'	=> array(
				'type'			=> 'width'
			),
			'post_slider_arrow_border_color'	=> array(
				'type'			=> 'color',
				'value'			=> $arrow_border_color
			),
			'post_slider_arrow_border_radius'	=> array(
				'type'			=> 'radius'
			)
		), 'arrow_border' );

		// Handle old slider arrow padding field.
		$settings = PP_Module_Fields::handle_multitext_field( $settings, 'post_slider_arrow_padding', 'padding', 'arrow_padding' );

		return $settings;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPContentGridModule', array(
	'layout'        => array(
		'title'         => __('Layout', 'bb-powerpack'),
		'sections'      => array(
			'layout_cg'       => array(
				'title'         => '',
				'fields'        => array(
					'layout'        => array(
						'type'          => 'pp-switch',
						'label'         => __('Layout Type', 'bb-powerpack'),
						'default'       => 'grid',
						'options'       => array(
							'grid'          => __('Grid', 'bb-powerpack'),
							'carousel'       => __('Carousel', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'grid'			=> array(
								'fields'		=> array('pagination', 'post_grid_filters_display'),
								'sections'		=> array('pagination_style'),
								'tabs'			=> array('filters_style', 'pagination')
							),
							'carousel'			=> array(
								'fields'		=> array('slide_width', 'post_carousel_minimum', 'post_carousel_maximum'),
								'tabs'			=> array('slider')
							),
						),
						'hide'	=> array(
							'carousel'	=> array(
								'tabs'	=> array('filters_style')
							)
						)
					),
					'post_grid_style_select'    => array(
                        'type'      => 'select',
                        'label'     => __('Select Style', 'bb-powerpack'),
                        'default'   => 'default',
                        'options'   => array(
							'default'  => __('Default', 'bb-powerpack'),
                            'style-1'  => __('Style 1', 'bb-powerpack'),
                            'style-2'  => __('Style 2', 'bb-powerpack'),
							'style-3'  => __('Style 3', 'bb-powerpack'),
							'style-4'  => __('Style 4', 'bb-powerpack'),
							'style-5'  => __('Style 5', 'bb-powerpack'),
							'style-6'  => __('Style 6', 'bb-powerpack'),
							'style-7'  => __('Style 7', 'bb-powerpack'),
							'style-8'  => __('Style 8', 'bb-powerpack'),
							'style-9'  => __('Style 9', 'bb-powerpack'),
                        ),
						'toggle'	=> array(
							'default'	=> array(
								'fields'	=> array('post_content_alignment', 'show_categories')
							),
							'style-1'	=> array(
								'fields'	=> array('post_content_alignment', 'show_categories')
							),
							'style-2'	=> array(
								'fields'	=> array('post_content_alignment', 'show_categories'),
								'sections'	=> array('divider_style')
							),
							'style-3'	=> array(
								'fields'	=> array('post_content_alignment', 'show_categories'),
								'sections'	=> array('post_category_style')
							),
							'style-4'	=> array(
								'fields'	=> array('post_content_alignment', 'show_categories'),
								'sections'	=> array('post_title_style')
							),
							'style-5'	=> array(
								'fields'	=> array('post_date_day_bg_color', 'show_categories', 'post_date_day_text_color', 'post_date_month_bg_color', 'post_date_month_text_color', 'post_date_border_radius'),
								'sections'	=> array('post_date_style')
							),
							'style-6'	=> array(
								'fields'	=> array('post_date_bg_color', 'post_date_text_color', 'show_categories'),
								'sections'	=> array('post_date_style')
							),
							'style-7'	=> array(
								'fields'	=> array('post_content_alignment', 'show_categories')
							),
							'style-9'	=> array(
								'fields'	=> array('custom_height', 'post_meta_bg_color')
							)
						),
                    ),
					'match_height'  => array(
						'type'          => 'pp-switch',
						'label'         => __('Equal Heights', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'          	=> __('Yes', 'bb-powerpack'),
							'no'         	=> __('No', 'bb-powerpack'),
						),
					),
					'custom_height'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Custom Height', 'bb-powerpack'),
						'default'		=> '275',
						'units'			=> array('px'),
						'slider'		=> array(
							'min'			=> 1,
							'max'			=> 1000,
							'step'			=> 1
						),
						'responsive'	=> true			
					),
					'total_post'  => array(
						'type'          => 'pp-switch',
						'label'         => __('Total Posts', 'bb-powerpack'),
						'default'       => 'all',
						'options'       => array(
							'all'          	=> __('All', 'bb-powerpack'),
							'custom'        => __('Custom', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('total_posts_count')
							)
						)
					),
					'total_posts_count' => array(
						'type'          => 'text',
						'label'         => __('Posts Count', 'bb-powerpack'),
						'default'       => '20',
						'size'          => '4',
					),
					'posts_per_page' => array(
						'type'          => 'text',
						'label'         => __('Posts Per Page', 'bb-powerpack'),
						'default'       => '10',
						'size'          => '4',
						'help'			=> __('Number of posts to be displayed at once. Should be less than or equal to total post count.', 'bb-powerpack')
					),
					'exclude_current_post'	=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Exclude Current Post', 'bb-powerpack'),
						'default'				=> 'no',
						'options'				=> array(
							'yes'					=> __('Yes', 'bb-powerpack'),
							'no'					=> __('No', 'bb-powerpack')
						)
					)
				)
			),
			'grid'          => array(
				'title'         => __('Column Settings', 'bb-powerpack'),
				'fields'        => array(
					'post_grid_count'    => array(
						'type' 			=> 'pp-multitext',
						'label' 		=> __('Number of Columns', 'bb-powerpack'),
						'default'		=> array(
							'desktop'	=> 3,
							'tablet'	=> 2,
							'mobile'	=> 1,
						),
						'options' 		=> array(
							'desktop' => array(
								'icon'		=> 'fa-desktop',
								'tooltip'	=> __('Desktop', 'bb-powerpack'),
							),
							'tablet' => array(
								'icon'		=> 'fa-tablet',
								'tooltip'	=> __('Tablet', 'bb-powerpack'),
							),
							'mobile' => array(
								'icon'		=> 'fa-mobile',
								'tooltip'	=> __('Mobile', 'bb-powerpack'),
							),
						),
					),
					'post_spacing'  => array(
						'type'          => 'unit',
						'label'         => __('Column Spacing', 'bb-powerpack'),
						'default'       => '2',
						'units'			=> array('%'),
						'slider'		=> array(
							'min'			=> '0',
							'max'			=> '20',
							'step'			=> '1'
						),
					),
				)
			),
		),
	),
	'slider'      => array(
		'title'         => __('Carousel', 'bb-powerpack'),
		'sections'      => array(
			'slider_general'       => array(
				'title'         => '',
				'fields'        => array(
					'auto_play'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Autoplay', 'bb-powerpack'),
						'default'       => 'yes',
						'options'       => array(
							'yes'          	=> __('Yes', 'bb-powerpack'),
							'no'         	=> __('No', 'bb-powerpack'),
						)
					),
					'stop_on_hover'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Stop On Hover', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'          => __('Yes', 'bb-powerpack'),
							'no'         => __('No', 'bb-powerpack'),
						)
					),
					'lazy_load'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Lazy Load', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'          => __('Yes', 'bb-powerpack'),
							'no'         => __('No', 'bb-powerpack'),
						)
					),
					'slides_center_align'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __('Center Aligned Slides', 'bb-powerpack'),
						'default'		=> 'no',
						'options'       => array(
							'yes'          	=> __('Yes', 'bb-powerpack'),
							'no'         	=> __('No', 'bb-powerpack'),
						),
						'help'			=> __('Useful when there is only one item.', 'bb-powerpack')
					),
					'transition_speed' => array(
						'type'          => 'text',
						'label'         => __('Autoplay Timeout', 'bb-powerpack'),
						'default'       => '2',
						'size'          => '5',
						'description'   => _x( 'seconds', 'Value unit for form field of time in seconds. Such as: "5 seconds"', 'bb-powerpack' )
					),
					'slides_speed' => array(
						'type'          => 'text',
						'label'         => __('Slides Speed', 'bb-powerpack'),
						'default'       => '',
						'size'          => '5',
						'description'   => _x( 'seconds', 'Value unit for form field of time in seconds. Such as: "5 seconds"', 'bb-powerpack' )
					),
					'slide_loop'	=> array(
						'type'			=> 'pp-switch',
						'label'			=> __( 'Loop', 'bb-powerpack' ),
						'options'		=> array(
							'yes'			=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack'),
						),
						'default'		=> 'yes',
					),
				)
			),
			'controls'       => array(
				'title'         => __('Controls', 'bb-powerpack'),
				'collapsed'		=> true,
				'fields'        => array(
					'slider_pagination'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Navigation Dots?', 'bb-powerpack'),
						'default'       => 'yes',
						'options'       => array(
							'yes'       	=> __('Yes', 'bb-powerpack'),
							'no'			=> __('No', 'bb-powerpack'),
						),
						'toggle'	=> array(
							'yes'	=> array(
								'sections'	=> array('post_carousel_dot_style')
							)
						)
					),
					'slider_navigation'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Navigation Arrows?', 'bb-powerpack'),
						'default'       => 'no',
						'options'       => array(
							'yes'        	=> __('Yes', 'bb-powerpack'),
							'no'            => __('No', 'bb-powerpack'),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'sections'		=> array( 'arrow_style' )
							)
						)
					),
				)
			),
			'arrow_style'   => array(
				'title' => __('Carousel Navigation Arrow', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields' => array(
					'post_slider_arrow_font_size'   => array(
						'type'          => 'unit',
						'label'         => __('Arrow Size', 'bb-powerpack'),
						'units'   		=> array('px'),
						'slider'      	=> true,
						'default'       => '30',
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.pp-content-post-carousel .owl-theme .owl-nav button svg',
							'property'        => 'font-size',
							'unit'            => 'px'
						)
					),
					'arrow_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Arrow Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset'	=> true,
						'connections'	=> array('color')
					),
					'arrow_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Arrow Hover Color', 'bb-powerpack'),
						'default'		=> 'eeeeee',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'arrow_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Arrow Background Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'arrow_bg_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Arrow Background Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
					),
					'arrow_border'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-content-post-carousel .owl-theme .owl-nav button svg',
                            'property'        => 'border',
                        )
					),
					'arrow_border_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Border Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'arrow_padding'	=> array(
						'type'			=> 'dimension',
						'label'			=> __('Padding', 'bb-powerpack'),
						'default'		=> 10,
						'units'			=> array('px'),
						'slider'		=> true
					),
                )
            ),
            'post_carousel_dot_style'   => array(
				'title' => __('Carousel Navigation Dots', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields' => array(
                    'post_slider_dot_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'default'       => '666666',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
                            'selector'        => '.pp-content-post-carousel .owl-theme .owl-dots .owl-dot span',
                            'property'        => 'background',
						)
					),
                    'post_slider_dot_bg_hover'      => array(
						'type'          => 'color',
						'label'         => __('Active Color', 'bb-powerpack'),
						'default'       => '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
                            'type'          => 'css',
                            'selector'        => '.pp-content-post-carousel .owl-theme .owl-dots .owl-dot.active span',
                            'property'        => 'background',
						)
					),
                    'post_slider_dot_width'   => array(
                        'type'          => 'unit',
                        'label'         => __('Size', 'bb-powerpack'),
                        'units'   		=> array('px'),
						'slider'     	=> true,
                        'default'       => '10',
                        'preview'         => array(
                            'type'            => 'css',
                            'rules'           => array(
                               array(
                                   'selector'        => '.pp-content-post-carousel .owl-theme .owl-dots .owl-dot span',
                                   'property'        => 'width',
                                   'unit'            => 'px'
                               ),
                               array(
                                   'selector'        => '.pp-content-post-carousel .owl-theme .owl-dots .owl-dot span',
                                   'property'        => 'height',
                                   'unit'            => 'px'
                               ),
                           ),
                        )
                    ),
                    'post_slider_dot_border_radius'   => array(
                        'type'          => 'unit',
                        'label'         => __('Round Corners', 'bb-powerpack'),
                        'units'   		=> array('px'),
						'slider'     	=> true,
                        'default'       => '100',
                        'preview'       => array(
                            'type'            => 'css',
                            'selector'        => '.pp-content-post-carousel .owl-theme .owl-dots .owl-dot span',
                            'property'        => 'border-radius',
                            'unit'            => 'px'
                        )
                    ),
                )
            )
		)
	),
	'content'   => array( // Tab
		'title'         => __('Content', 'bb-powerpack'),
		'file'          => BB_POWERPACK_DIR . 'modules/pp-content-grid/includes/loop-settings.php',
	),
	'style'         => array( // Tab
		'title'         => __('Style', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
			'post_grid_general'   => array(
				'title'         => __('Structure', 'bb-powerpack'),
				'fields'        => array(
					'post_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> 'f7f7f7',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-content-post',
							'property'		=> 'background-color'
						),
					),
					'post_bg_color_hover'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Hover Color', 'bb-powerpack'),
						'default'		=> 'eeeeee',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'post_content_alignment'    => array(
                        'type'      	=> 'align',
                        'label'     	=> __('Text Alignment', 'bb-powerpack'),
                        'default'   	=> 'left',
                    ),
					'field_separator_1'  => array(
                        'type'                => 'pp-separator',
                        'color'               => 'eeeeee'
					),
					'post_grid_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Box Padding', 'bb-powerpack'),
						'default'			=> 10,
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'           => array(
							'type'				=> 'css',
							'selector'			=> '.pp-content-post',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
					'post_border_group'	=> array(
						'type'				=> 'border',
						'label'				=> __('Border', 'bb-powerpack'),
						'responsive'		=> true
					),
					'post_content_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Content Padding', 'bb-powerpack'),
						'default'			=> 10,
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'           => array(
							'type'				=> 'css',
							'selector'			=> '.pp-content-post .pp-content-body',
							'property'			=> 'padding',
							'unit'				=> 'px'
						)
					),
					'show_image_effect'		=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Show Image Effects', 'bb-powerpack'),
						'default'				=> 'no',
						'options'				=> array(
							'yes'					=> __('Yes', 'bb-powerpack'),
							'no'					=> __('No', 'bb-powerpack'),
						),
						'toggle'				=> array(
							'yes'				=> array(
								'sections'				=> array('image_effects','image_hover_effects')
							)
						)
					),
				)
			),
			'image_effects'		=> array(
				'title'				=> __('Image Effects', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> pp_image_effect_fields(),
			),
			'image_hover_effects'=> array(
				'title'				=> __('Image Effects on Hover', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> pp_image_effect_fields(true),
			),
			'divider_style'	=> array(
				'title'	=> __('Divider', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'post_title_divider_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'default'		=> '333333',
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post .pp-post-title-divider',
							'property'	=> 'background-color',
                        ),
                    ),
				)
			),
			'post_category_style'	=> array(
				'title'	=> __('Taxonomy', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'post_category_bg_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset' 	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post .pp-post-image .pp-content-category-list',
							'property'	=> 'background-color',
                        ),
                    ),
					'post_category_text_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Text Color', 'bb-powerpack'),
						'default'		=> 'ffffff',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post .pp-post-image .pp-content-category-list a, .pp-content-post .pp-post-image .pp-content-category-list',
							'property'	=> 'color',
                        ),
                    ),
					'post_category_position'	=> array(
						'type'          => 'pp-switch',
						'label'         => __('Position', 'bb-powerpack'),
						'default'       => 'left',
						'options'       => array(
							'left'          => __('Left', 'bb-powerpack'),
							'right'         => __('Right', 'bb-powerpack'),
						),
					),
				)
			),
			'post_title_style'	=> array(
				'title'	=> __('Title', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'post_title_overlay_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Overlay Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post .pp-post-image .pp-post-title',
							'property'	=> 'background',
                        ),
                    ),
					'post_title_overlay_opacity'   => array(
                        'type'          => 'text',
                        'label'         => __('Opacity', 'bb-powerpack'),
                        'description'   => '%',
						'size'      => 5,
                        'maxlength' => 3,
                        'default'       => '50',
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.pp-content-post .pp-post-image .pp-post-title',
                            'property'        => 'opacity',
                        )
                    ),
				)
			),
			'post_date_style'	=> array(
				'title'	=> __('Date', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'post_date_day_bg_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Day Background Color', 'bb-powerpack'),
						'default'		=> 'f9f9f9',
						'show_reset' 	=> true,
						'show_alpha' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-day',
							'property'	=> 'background-color',
                        ),
                    ),
					'post_date_day_text_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Day Text Color', 'bb-powerpack'),
						'default'		=> '888888',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-day',
							'property'	=> 'color',
                        ),
                    ),
					'post_date_month_bg_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Month Background Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset' 	=> true,
						'show_alpha' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-month',
							'property'	=> 'background-color',
                        ),
                    ),
					'post_date_month_text_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Month Text Color', 'bb-powerpack'),
						'default'		=> 'ffffff',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-month',
							'property'	=> 'color',
                        ),
                    ),
					'post_date_bg_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset' 	=> true,
						'show_alpha' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post.pp-grid-style-6 .pp-post-image .pp-content-post-date',
							'property'	=> 'background-color',
                        ),
                    ),
					'post_date_text_color'   => array(
                        'type'      => 'color',
                        'label'     => __('Color', 'bb-powerpack'),
						'default'		=> 'ffffff',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-post.pp-grid-style-6 .pp-post-image .pp-content-post-date',
							'property'	=> 'color',
                        ),
                    ),
					'post_date_border_radius'   => array(
                        'type'      => 'unit',
                        'label'     => __('Round Corners', 'bb-powerpack'),
						'units'		=> array('px'),
						'slider'	=> true,
                        'default'   => 2,
                        'description'   => 'px',
                        'preview'       => array(
                            'type'      => 'css',
							'rules' 	=> array(
								array(
									'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-day',
									'property'	=> 'border-top-left-radius',
									'unit'		=> 'px'
								),
								array(
									'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-day',
									'property'	=> 'border-top-right-radius',
									'unit'		=> 'px'
								),
								array(
									'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-month',
									'property'	=> 'border-bottom-left-radius',
									'unit'		=> 'px'
								),
								array(
									'selector'	=>'.pp-content-post.pp-grid-style-5 .pp-content-post-date span.pp-post-month',
									'property'	=> 'border-bottom-right-radius',
									'unit'		=> 'px'
								)
							)
                        ),
                    ),
				)
			),
			'product_info_style'	=> array(
				'title'	=> __('Product Info', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'product_rating_color'  => array(
						'type'          => 'color',
						'label'         => __('Rating Color', 'bb-powerpack'),
						'default'       => '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
                            'selector'        => '.pp-content-post .star-rating:before, .pp-content-post .star-rating span:before',
                            'property'        => 'color',
						)
					),
					'product_price_color'  => array(
						'type'          => 'color',
						'label'         => __('Price Color', 'bb-powerpack'),
						'default'       => '000000',
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'          => 'css',
                            'selector'        => '.pp-content-post .pp-product-price',
                            'property'        => 'color',
						)
					),
				)
			),
			'button_colors'	=> array(
				'title'	=> __('Read More Link/Button', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'button_width'    => array(
                        'type'      => 'pp-switch',
                        'label'     => __('Width', 'bb-powerpack'),
                        'default'   => 'default',
                        'options'   => array(
                            'default'  => __('Auto', 'bb-powerpack'),
                            'full'  => __('Full Width', 'bb-powerpack'),
                        ),
                    ),
					'button_bg_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Color', 'bb-powerpack'),
						'default'			=> '666666',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
					),
					'button_bg_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Hover Color', 'bb-powerpack'),
						'default'			=> '000000',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'none'
						)
					),
					'button_text_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Text Color', 'bb-powerpack'),
						'default'			=> 'ffffff',
						'show_reset'		=> true,
						'connections'		=> array('color'),
					),
					'button_text_hover_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Text Hover Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'none'
						)
					),
					'button_border_group'	=> array(
						'type'					=> 'border',
						'label'					=> __('Border', 'bb-powerpack'),
						'responsive'			=> true,
						'preview'       		=> array(
							'type'            		=> 'css',
							'selector'        		=> '.pp-content-post .pp-more-link-button',
                        ),
					),
					'button_border_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Border Hover Color', 'bb-powerpack'),
						'default'		=> 'eeeeee',
						'show_reset'	=> true,
						'connections'	=> array('color'),
					),
					'button_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> 10,
						'units'				=> array('px'),
						'slider'			=> true,
						'responsive'		=> true,
						'preview'       	=> array(
							'type'				=> 'css',
							'selector'        	=> '.pp-content-post .pp-more-link-button',
							'property'        	=> 'padding',
							'unit'            	=> 'px'
						),
					),
					'button_margin' 	=> array(
                    	'type' 				=> 'pp-multitext',
                    	'label' 			=> __('Margin', 'bb-powerpack'),
                        'description'   	=> __( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-powerpack' ),
                        'default'       	=> array(
                            'top' 				=> 10,
                            'bottom' 			=> 5,
                        ),
                    	'options' 		=> array(
                    		'top' 			=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-up',
								'preview'       => array(
									'selector'		=> '.pp-content-post .pp-content-grid-more-link',
									'property'      => 'margin-top',
									'unit'          => 'px'
		                        ),
                    		),
                            'bottom' 		=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-down',
								'preview'       => array(
									'selector'      => '.pp-content-post .pp-content-grid-more-link',
									'property'      => 'margin-bottom',
									'unit'          => 'px'
		                        ),
                    		),
                    	)
                    ),
				)
			),
		)
	),
	'filters_style'         => array( // Tab
		'title'         => __('Filter', 'bb-powerpack'), // Tab title
		'sections'      => array( // Tab Sections
			'filter_general_setting'	=> array(
				'title'	=> __('General', 'bb-powerpack'),
				'fields'	=> array(
					'responsive_filter'	=> array(
						'type'				=> 'select',
						'label'				=> __('Filter Toggle Breakpoint', 'bb-powerpack'),
						'default'			=> 'no',
						'options'			=> array(
							'no'				=> __('None', 'bb-powerpack'),
							'all'				=> __('All devices', 'bb-powerpack'),
							'large'				=> __('Large devices', 'bb-powerpack'),
							'large_medium'		=> __('Large & Medium devices', 'bb-powerpack'),
							'medium'			=> __('Medium devices', 'bb-powerpack'),
							'medium_small'		=> __('Medium & Small devices', 'bb-powerpack'),
							'yes'				=> __('Small devices', 'bb-powerpack')
						),
						'help'				=> __('By enabling this option will convert filters into a toggle. If you want to display the filters as they are appearing on desktop, keep it disabled.', 'bb-powerpack')
					),
					'filter_alignment'    => array(
                        'type'      => 'align',
                        'label'     => __('Alignment', 'bb-powerpack'),
                        'default'   => 'left',
					),
					'filter_margin' 	=> array(
						'type'      => 'unit',
                        'label'     => __('Spacing', 'bb-powerpack'),
                        'units'     => array('px'),
                        'slider' 	=> true,
                        'default'   => 10,
                        'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-post-filters li',
							'property'        => 'margin-right',
							'unit'            => 'px'
                        ),
                    ),
				)
			),
			'filter_colors'	=> array(
				'title'	=> __('Colors', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'filter_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> 'ul.pp-post-filters li',
							'property'		=> 'background'
						)
					),
					'filter_bg_color_active'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Active Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'default'		=> '',
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none'
						)
					),
					'filter_text_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '333333',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> 'ul.pp-post-filters li',
							'property'		=> 'color'
						)
					),
					'filter_text_color_active'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Active Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'none',
						)
					),
				),
			),
			'filter_border_setting'	=> array(
				'title'	=> __('Border & Padding', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'filter_border_group'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'responsive'	=> true,
						'preview'       => array(
							'type'            => 'css',
							'selector'        => '.pp-post-filters li',
							'property'        => 'border',
                        ),
					),
					'filter_border_hover_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Border Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css'
						)
					),
					'filter_padding'	=> array(
						'type'				=> 'dimension',
						'label'				=> __('Padding', 'bb-powerpack'),
						'default'			=> 8,
						'units'				=> array('px'),
						'slider'			=> true,
						'preview'       	=> array(
							'type'				=> 'css',
							'selector'        	=> '.pp-post-filters li',
							'property'        	=> 'padding',
							'unit'            	=> 'px'
						),
					)
				)
			),
			'filter_toggle'	=> array(
				'title'			=> __('Toggle', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'		=> array(
					'filter_toggle_bg'	=> array(
						'type'				=> 'color',
						'label'				=> __('Background Color', 'bb-powerpack'),
						'default'			=> 'ffffff',
						'show_reset'		=> true,
						'show_alpha'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-post-filters-toggle',
							'property'			=> 'background'
						)
					),
					'filter_toggle_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Text Color', 'bb-powerpack'),
						'default'			=> '444444',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-post-filters-toggle',
							'property'			=> 'color'
						)
					),
					'filter_toggle_border_group'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-post-filters-toggle',
							'property'		=> 'border',
						)
					),
				)
			)
		)
	),
	'pagination'	=> array(
		'title'			=> __('Pagination', 'bb-powerpack'),
		'sections'		=> array(
			'pagination'   => array(
				'title'         => __('General', 'bb-powerpack'),
				'fields'        => array(
					'pagination'     => array(
						'type'          => 'select',
						'label'         => __('Pagination Type', 'bb-powerpack'),
						'default'       => 'numbers',
						'options'       => array(
							'numbers'       => __('Numbers', 'bb-powerpack'),
							'scroll'        => __('Scroll', 'bb-powerpack'),
							'load_more'     => __('Load More Button', 'bb-powerpack'),
							'none'          => _x( 'None', 'Pagination style.', 'bb-powerpack' ),
						),
						'toggle'	=> array(
							'numbers'	=> array(
								'sections'	=> array('pagination_style', 'pagination_colors', 'pagination_border', 'pagination_typography'),
							),
							'load_more'	=> array(
								'fields'	=> array('load_more_text'),
								'sections'	=> array('pagination_style', 'pagination_colors', 'pagination_border', 'pagination_typography'),
							)
						)
					),
					'load_more_text'	=> array(
						'type'				=> 'text',
						'label'				=> __('Load More Text', 'bb-powerpack'),
						'default'			=> __('Load More', 'bb-powerpack'),
					),
					'no_results_message' => array(
						'type' 				=> 'text',
						'label'				=> __('No Results Message', 'bb-powerpack'),
						'default'			=> __('Sorry, we couldn\'t find any posts. Please try a different search.', 'bb-powerpack')
					),
					'show_search'    => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Search', 'bb-powerpack'),
						'default'       => 'yes',
						'options'       => array(
							'yes'          	=> __('Yes', 'bb-powerpack'),
							'no'          	=> __('No', 'bb-powerpack')
						),
						'help'          => __( 'Shows the search form if no posts are found.', 'bb-powerpack' )
					),
					'pagination_nofollow'	=> array(
						'type'					=> 'pp-switch',
						'label'					=> __('Pagination nofollow', 'bb-powerpack'),
						'default'				=> 'no',
						'options'				=> array(
							'yes'					=> __('Yes', 'bb-powerpack'),
							'no'					=> __('No', 'bb-powerpack'),
						)
					)
				)
			),
			'pagination_style'    => array(
				'title'         => __('Structure', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'        => array(
					'pagination_align'	=> array(
						'type'				=> 'align',
						'label'				=> __('Alignment', 'bb-powerpack'),
						'default'			=> 'center',
						'preview'			=> array(
							'type'				=> 'css',
							'rules'				=> array(
								array(
									'selector'			=> '.pp-content-grid-load-more',
									'property'			=> 'text-align'
								),
								array(
									'selector'			=> '.pp-content-grid-pagination',
									'property'			=> 'text-align'
								)
							)
						)
					),
					'pagination_spacing_v'   => array(
                        'type'      => 'unit',
                        'label'     => __('Spacing Vertical', 'bb-powerpack'),
						'units'		=> array('px'),
						'slider'	=> true,
                        'default'   => 15,
                        'preview'       => array(
                            'type'      => 'css',
							'rules'		=> array(
								array(
									'selector'	=>'.pp-content-grid-pagination.fl-builder-pagination',
									'property'	=> 'padding-top',
									'unit'		=> 'px'
								),
								array(
									'selector'	=>'.pp-content-grid-pagination.fl-builder-pagination',
									'property'	=> 'padding-bottom',
									'unit'		=> 'px'
								),
								array(
									'selector'	=> '.pp-content-grid-load-more',
									'property'	=> 'margin-top',
									'unit'		=> 'px'
								)
							)
                        ),
                    ),
					'pagination_spacing'   => array(
                        'type'      => 'unit',
                        'label'     => __('Spacing Horizontal', 'bb-powerpack'),
                        'units'		=> array('px'),
						'slider'	=> true,
                        'default'   => 5,
                        'preview'       => array(
                            'type'      => 'css',
							'selector'	=>'.pp-content-grid-pagination li .page-numbers',
							'property'	=> 'margin-right',
							'unit'		=> 'px'
						),
						'help'		=> __('It will only work for Numbers pagination.', 'bb-powerpack')
					),
					'pagination_padding'	=> array(
						'type'					=> 'dimension',
						'label'					=> __('Padding', 'bb-powerpack'),
						'units'					=> array('px'),
						'slider'				=> true,
						'default'				=> 10,
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-content-grid-pagination li a.page-numbers, .pp-content-grid-pagination li span.page-numbers, .pp-content-grid-load-more a',
							'property'				=> 'padding',
							'unit'					=> 'px'
						)
					),
				)
			),
			'pagination_colors'	=> array(
				'title'				=> __('Colors', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'pagination_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> 'ffffff',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.pp-content-grid-pagination li a.page-numbers, .pp-content-grid-pagination li span.page-numbers, .pp-content-grid-load-more a',
							'property'		=> 'background-color'
						)
					),
					'pagination_bg_color_hover'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Hover Color', 'bb-powerpack'),
						'default'		=> 'eeeeee',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'none',
						)
					),
					'pagination_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '000000',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.pp-content-grid-pagination li a.page-numbers, .pp-content-grid-pagination li span.page-numbers, .pp-content-grid-load-more a',
							'property'		=> 'color'
						)
					),
					'pagination_color_hover'	=> array(
						'type'			=> 'color',
						'label'			=> __('Text Hover Color', 'bb-powerpack'),
						'default'		=> '',
						'show_reset'	=> true,
						'show_alpha'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'none',
						)
					),
				)
			),
			'pagination_border'	=> array(
				'title'				=> __('Border', 'bb-powerpack'),
				'collapsed'			=> true,
				'fields'			=> array(
					'pagination_border_group'	=> array(
						'type'			=> 'border',
						'label'			=> __('Border', 'bb-powerpack'),
						'responsive'	=> true,
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.pp-content-grid-pagination li a.page-numbers, .pp-content-grid-pagination li span.page-numbers, .pp-content-grid-load-more a',
							'property'		=> 'border'
						)
					),
				)
			),
		)
	),
	'typography'	=> array( // Tab
		'title'			=> __('Typography', 'bb-powerpack'),
		'sections'		=> array(
			'title_typography'		=> array(
				'title'		=> __('Title', 'bb-powerpack'),
				'fields' 	=> array(
					'title_tag'		=> array(
						'type'		=> 'select',
						'label'		=> __('HTML Tag', 'bb-powerpack'),
						'options'	=> array(
							'h1'	=> 'H1',
							'h2'	=> 'H2',
							'h3'	=> 'H3',
							'h4'	=> 'H4',
							'h5'	=> 'H5',
							'h6'	=> 'H6',
							'p'		=> 'p',
							'span'	=> 'span',
							'div'	=> 'div'
						),
						'default'	=> 'h3',
						'help' 		=> __('Set the HTML tag for title output', 'bb-powerpack'),
					),
					'title_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'       	=> array(
							'type'				=> 'typography',
							'selector'        	=> '.pp-content-post .pp-post-title, .pp-content-post .pp-post-title a',
						),
					),
					'title_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'rules'           => array(
							   array(
								   'selector'        => '.pp-content-post .pp-post-title',
								   'property'        => 'color',
							   ),
							   array(
								   'selector'        => '.pp-content-post .pp-post-title a',
								   'property'        => 'color',
							   ),
						   ),
						),
					),
					'title_margin' 	=> array(
                    	'type' 				=> 'pp-multitext',
                    	'label' 			=> __('Margin', 'bb-powerpack'),
                        'description'   	=> 'px',
                        'default'       	=> array(
                            'top' 				=> 5,
                            'bottom' 			=> 5,
                        ),
                    	'options' 		=> array(
                    		'top' 			=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-up',
								'preview'       => array(
									'selector'		=> '.pp-content-post .pp-post-title',
									'property'      => 'margin-top',
									'unit'          => 'px'
		                        ),
                    		),
                            'bottom' 		=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-down',
								'preview'       => array(
									'selector'      => '.pp-content-post .pp-post-title',
									'property'      => 'margin-bottom',
									'unit'          => 'px'
		                        ),
                    		),
                    	)
                    ),
				)
			),
			'content_typography'		=> array(
				'title'		=> __('Description', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields' 	=> array(
					'content_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'       	=> array(
							'type'				=> 'typography',
							'selector'        	=> '.pp-content-post .pp-post-content',
						),
					),
					'content_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'show_reset'	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-content-post .pp-post-content',
							'property'      => 'color',
						),
					),
					'description_margin' 	=> array(
                    	'type' 				=> 'pp-multitext',
                    	'label' 			=> __('Margin', 'bb-powerpack'),
                        'description'   	=> 'px',
                        'default'       	=> array(
                            'top' 				=> 5,
                            'bottom' 			=> 5,
                        ),
                    	'options' 		=> array(
                    		'top' 			=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   => __('Top', 'bb-powerpack'),
                                'tooltip'       => __('Top', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-up',
								'preview'       => array(
									'selector'		=> '.pp-content-post .pp-post-content',
									'property'      => 'margin-top',
									'unit'          => 'px'
		                        ),
                    		),
                            'bottom' 		=> array(
                                'maxlength' 	=> 3,
                                'placeholder'   => __('Bottom', 'bb-powerpack'),
                                'tooltip'       => __('Bottom', 'bb-powerpack'),
                    			'icon'			=> 'fa-long-arrow-down',
								'preview'       => array(
									'selector'      => '.pp-content-post .pp-post-content',
									'property'      => 'margin-bottom',
									'unit'          => 'px'
		                        ),
                    		),
                    	)
                    ),
				)
			),
			'post_meta_typography'	=> array(
				'title' => __('Meta', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'meta_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'       	=> array(
							'type'				=> 'typography',
							'selector'        	=> '.pp-content-post .pp-post-meta',
						),
					),
					'post_meta_font_color' 		=> array(
						'type'			=> 'color',
						'label'			=> __('Text Color', 'bb-powerpack'),
						'default'		=> '606060',
						'show_reset' 	=> true,
						'connections'	=> array('color'),
						'preview'       => array(
							'type'		=> 'css',
							'rules'			  => array(
								array(
									'selector'        => '.pp-content-post .pp-post-meta',
									'property'        => 'color',
								),
								array(
									'selector'        => '.pp-content-post .pp-post-meta a',
									'property'        => 'color',
								)
							)
						),
					),
					'post_meta_bg_color'	=> array(
						'type'			=> 'color',
						'label'			=> __('Background Color', 'bb-powerpack'),
						'default'		=> '333',
						'show_reset' 	=> true,
						'show_alpha' 	=> true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-content-post .pp-post-meta span',
							'property'		=> 'background-color'
						)
					),
				)
			),
			'events_calendar_style'	=> array(
				'title'		=> __('The Events Calendar', 'bb-powerpack'),
				'collapsed'	=> true,
				'fields'	=> array(
					'event_date_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Date Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-post-event-calendar-date, .pp-post-event-calendar-date span',
							'property'			=> 'color'
						)
					),
					'event_date_case'	=> array(
						'type'				=> 'select',
						'label'				=> __('Text Transform', 'bb-powerpack'),
						'default'			=> 'default',
						'options'			=> array(
							'default'			=> __('Default', 'bb-powerpack'),
							'lowercase'			=> __('lowercase', 'bb-powerpack'),
							'uppercase'			=> __('UPPERCASE', 'bb-powerpack'),
						),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-post-event-calendar-date, .pp-post-event-calendar-date span',
							'property'			=> 'text-transform'
						)
					),
					'field_separator_e1'	=> array(
						'type'		=> 'pp-separator'
					),
					'event_venue_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Venue Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-post-event-calendar-venue, .pp-post-event-calendar-venue span.tribe-address',
							'property'			=> 'color'
						)
					),
					'field_separator_e2'	=> array(
						'type'		=> 'pp-separator'
					),
					'event_cost_color'	=> array(
						'type'				=> 'color',
						'label'				=> __('Cost Color', 'bb-powerpack'),
						'default'			=> '',
						'show_reset'		=> true,
						'connections'		=> array('color'),
						'preview'			=> array(
							'type'				=> 'css',
							'selector'			=> '.pp-post-event-calendar-cost, .pp-post-event-calendar-cost span.ticket-cost',
							'property'			=> 'color'
						)
					),
				)
			),
			'button_typography'  => array(
				'title' => __('Read More Link/Button', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'button_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'       	=> array(
							'type'				=> 'typography',
							'selector'        	=> '.pp-content-post .pp-more-link-button',
						),
					),
                ),
            ),
			'filter_typography'  => array(
				'title' => __('Filter', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'filter_typography'	=> array(
						'type'				=> 'typography',
						'label'				=> __('Typography', 'bb-powerpack'),
						'responsive'		=> true,
						'preview'       	=> array(
							'type'				=> 'typography',
							'selector'        	=> '.pp-post-filters li',
						),
					),
                ),
            ),
			'pagination_typography'  => array(
				'title' => __('Pagination', 'bb-powerpack'),
				'collapsed'	=> true,
                'fields'    => array(
					'pagination_font_size'	=> array(
						'type'			=> 'unit',
						'label'			=> __('Font Size', 'bb-powerpack'),
						'default'		=> 14,
						'responsive'	=> true,
						'units'			=> array('px'),
						'slider'		=> true,
						'preview'       => array(
							'type'			=> 'css',
							'selector'      => '.pp-content-grid-pagination li a.page-numbers, .pp-content-grid-pagination li span.page-numbers',
							'property'      => 'font-size',
							'unit'			=> 'px'
						),
					),
				)
			),
		)
	)
));
