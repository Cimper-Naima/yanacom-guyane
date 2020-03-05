<?php

/**
 * @class PPCustomGridModule
 */
class PPCustomGridModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Custom Grid', 'bb-powerpack'),
			'description'   	=> __('Display a grid of your WordPress posts.', 'bb-powerpack'),
			'group'         	=> pp_get_modules_group(),
			'category'			=> pp_get_modules_cat( 'content' ),
            'dir'               => BB_POWERPACK_DIR . 'modules/pp-custom-grid/',
            'url'               => BB_POWERPACK_URL . 'modules/pp-custom-grid/',
			'editor_export' 	=> true,
			'partial_refresh'	=> true,
			'enabled'			=> true
		));

		add_filter( 'fl_builder_register_settings_form',   				__CLASS__ . '::presets_form_fields', 10, 2 );
		add_filter( 'fl_builder_after_control_pp-hidden-textarea',   	__CLASS__ . '::after_control', 10, 4 );
		//add_filter( 'fl_builder_render_css',               				__CLASS__ . '::custom_grid_css', 10, 2 );
	}
	
	public function filter_settings( $settings, $helper )
	{
		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'border_type'	=> array(
				'type'				=> 'style'
			),
			'border_size'	=> array(
				'type'				=> 'width'
			),
			'border_color'	=> array(
				'type'				=> 'color'
			),
			'post_shadow_options'		=> array(
				'type'				=> 'shadow',
				'condition'			=> ( isset( $settings->post_shadow ) && '1' == $settings->post_shadow )
			),
			'post_shadow_color'	=> array(
				'type'				=> 'shadow_color',
				'condition'			=> ( isset( $settings->post_shadow ) && '1' == $settings->post_shadow ),
			),
		), 'post_border' );

		// Handle old box border and radius fields.
		$settings = PP_Module_Fields::handle_border_field( $settings, array(
			'pagination_border_type'	=> array(
				'type'				=> 'style'
			),
			'pagination_border_size'	=> array(
				'type'				=> 'width'
			),
			'pagination_border_color'	=> array(
				'type'				=> 'color'
			),
			'pagination_border_radius'	=> array(
				'type'				=> 'radius'
			),
		), 'pagination_border' );

		return $settings;
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		$this->add_js('imagesloaded');

		if(FLBuilderModel::is_builder_active()) {
			$this->add_css(BB_POWERPACK()->fa_css);
		}
		if(FLBuilderModel::is_builder_active() || ! $this->settings->match_height) {
			$this->add_js('jquery-masonry');
		}
		if(FLBuilderModel::is_builder_active() || $this->settings->pagination == 'scroll') {
			$this->add_js('jquery-infinitescroll');
		}

		// Jetpack sharing has settings to enable sharing on posts, post types and pages.
		// If pages are disabled then jetpack will still show the share button in this module
		// but will *not* enqueue its scripts and fonts.
		// This filter forces jetpack to enqueue the sharing scripts.
		add_filter( 'sharing_enqueue_scripts', '__return_true' );
	}

	/**
	 * Returns the slug for the posts layout.
	 *
	 * @since 1.3
	 * @return string
	 */
	public function get_layout_slug()
	{
		return 'grid';
	}

	/**
	 * Renders the CSS class for each post item.
	 *
	 * @since 1.3
	 * @return void
	 */
	public function render_post_class()
	{
		$settings   = $this->settings;
		$layout     = $this->get_layout_slug();
		$show_image = has_post_thumbnail();
		$classes    = array( 'pp-custom-' . $layout . '-post' );

		$classes[] = 'pp-custom-align-' . $settings->post_align;
		$classes[] = 'pp-custom-grid-preset-' . $settings->preset;

		post_class( apply_filters( 'pp_custom_grid_module_classes', $classes, $settings ) );
	}

	/**
	 * Renders the_content for a post.
	 *
	 * @since 1.3
	 * @return void
	 */
	public function render_content()
	{
		ob_start();
		the_content();
		$content = ob_get_clean();

		if ( ! empty( $this->settings->content_length ) ) {
			$content = wp_trim_words( $content, $this->settings->content_length, '...' );
		}

		echo $content;
	}

	/**
	 * Renders the_excerpt for a post.
	 *
	 * @since 1.3
	 * @return void
	 */
	public function render_excerpt()
	{
		if ( ! empty( $this->settings->content_length ) ) {
			add_filter( 'excerpt_length', array( $this, 'set_custom_excerpt_length' ) );
		}

		the_excerpt();

		if ( ! empty( $this->settings->content_length ) ) {
			remove_filter( 'excerpt_length', array( $this, 'set_custom_excerpt_length' ) );
		}
	}

	/**
	 * Renders the excerpt for a post.
	 *
	 * @since 1.10
	 * @return void
	 */
	public function set_custom_excerpt_length( $length )
	{
		return $this->settings->content_length;
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

	/**
	 * Get presets directory path.
	 *
	 * @since 1.2.7
	 * @param string  $preset
	 * @return string
	 */
	static public function get_preset_dir( $preset = '' )
	{
		$presets_dir = BB_POWERPACK_DIR . 'modules/pp-custom-grid/includes/presets/';

		if ( empty( $preset ) ) {
			return $presets_dir;
		}
		else {
			return $presets_dir . $preset . '/';
		}
	}

	/**
	 * Get presets data from file.
	 *
	 * @since 1.2.7
	 * @param string  $preset
	 * @param int  $id	Preset ID or file number.
	 * @param string  $type	HTML or CSS.
	 * @return mixed
	 */
	static public function get_preset_data( $preset, $id, $type )
	{
		if ( ! $preset || empty( $preset ) ) {
			return;
		}
		if ( ! $id || empty( $id ) ) {
			return;
		}
		if ( ! $type || empty( $type ) || ! in_array( $type, array( 'html', 'css' ) ) ) {
			return;
		}

		$preset_dir = self::get_preset_dir( $preset );
		$preset_file = $preset_dir . $preset . '-' . $id . '-' . $type . '.php';

		if ( file_exists( $preset_file ) ) {
			return file_get_contents( $preset_file );
		}
	}

	/**
	 * Get presets default data from file.
	 *
	 * @since 1.2.7
	 * @param string  $preset
	 * @param int  $id	Preset ID or file number.
	 * @param string  $type	HTML or CSS.
	 * @return mixed
	 */
	static public function get_preset_default( $preset, $id, $type )
	{
		$data = self::get_preset_data( $preset, $id, $type );

		if ( $data && ! empty( $data ) ) {
			// JSON encode the value and fix encoding conflicts.
			$data = str_replace( "'", '&#39;', json_encode( $data ) );
			$data = str_replace( '<wbr \/>', '<wbr>', $data );
		} else {
			$data = '';
		}

		return $data;
	}

	/**
	 * Get all presets by its type.
	 *
	 * @since 1.2.7
	 * @param string  $type
	 * @return array
	 */
	static public function get_presets( $type = 'post' )
	{
		$presets = array(
			'post' => array(
				'post_1'		=> __('Post 1', 'bb-powerpack'),
				'post_2'		=> __('Post 2', 'bb-powerpack'),
				'post_3'		=> __('Post 3', 'bb-powerpack'),
				'post_4'		=> __('Post 4', 'bb-powerpack'),
				'post_5'		=> __('Post 5', 'bb-powerpack'),
			),
			'woocommerce' => array(
				'woo_1'			=> 'WooCommerce 1',
				'woo_2'			=> 'WooCommerce 2',
				'woo_3'			=> 'WooCommerce 3',
			),
			'edd' => array(
				'edd_1'			=> 'EDD 1',
				'edd_2'			=> 'EDD 2',
			)
		);


		if ( isset( $presets[$type] ) ) {
			return $presets[$type];
		}

		return $presets;
	}

	/**
	 * Create options for preset field.
	 *
	 * @since 1.2.7
	 * @return array
	 */
	static public function get_presets_options()
	{
		// Posts and Custom Posts.
		$options = array(
			'optgroup-1'	=> array(
				'label'			=> __('Post', 'bb-powerpack'),
				'options'		=> self::get_presets( 'post' )
			),
		);

		// WooCommerce support.
		if ( class_exists( 'WooCommerce' ) ) {
			$options['optgroup-2'] = array(
				'label'			=> 'WooCommerce',
				'options'		=> self::get_presets( 'woocommerce' )
			);
		}

		// EDD support.
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			$options['optgroup-3'] = array(
				'label'			=> 'Easy Digital Downloads',
				'options'		=> self::get_presets( 'edd' )
			);
		}

		return $options;
	}

	/**
	 * Adds the custom code settings for custom post
	 * module layouts.
	 *
	 * @since 1.2.7
	 * @param array  $form
	 * @param string $slug
	 * @return array
	 */
	static public function presets_form_fields( $form, $slug )
	{
		if ( 'pp-custom-grid' != $slug ) {
			return $form;
		}

		$toggles = array();

		foreach ( self::get_presets( 'post' ) as $preset_name => $preset ) {
			$form['layout']['sections']['general']['fields'][$preset_name . '_preset'] = array(
				'type'          => 'form',
				'label'         => __( 'Preset', 'bb-powerpack' ),
				'form'          => $preset_name . '_preset',
				'preview_text'  => null,
				'multiple'		=> false,
			);

			$toggles[$preset_name] = array(
				'fields'	=> array( $preset_name . '_preset' ),
			);
		}

		if ( class_exists( 'WooCommerce' ) ) {
			foreach ( self::get_presets( 'woocommerce' ) as $preset_name => $preset ) {
				$form['layout']['sections']['general']['fields'][$preset_name . '_preset'] = array(
					'type'          => 'form',
					'label'         => __( 'Preset', 'bb-powerpack' ),
					'form'          => $preset_name . '_preset',
					'preview_text'  => null,
					'multiple'		=> false,
				);

				$toggles[$preset_name] = array(
					'fields'	=> array( $preset_name . '_preset' ),
				);
			}
		}

		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			foreach ( self::get_presets( 'edd' ) as $preset_name => $preset ) {
				$form['layout']['sections']['general']['fields'][$preset_name . '_preset'] = array(
					'type'          => 'form',
					'label'         => __( 'Preset', 'bb-powerpack' ),
					'form'          => $preset_name . '_preset',
					'preview_text'  => null,
					'multiple'		=> false,
				);

				$toggles[$preset_name] = array(
					'fields'	=> array( $preset_name . '_preset' ),
				);
			}
		}

		$form['layout']['sections']['general']['fields']['preset']['toggle'] = $toggles;

		return $form;
	}

	/**
	 * Renders a custom field after a specific field.
	 *
	 * @since 1.2.7
	 * @param string $name
	 * @param mixed  $value
	 * @param array  $field
	 * @param object  $settings
	 * @return void
	 */
	static public function after_control( $name, $value, $field, $settings )
	{
		if ( $name == 'original_html' ) {
			?>
			<a href="javascript:void(0)" class="pp-custom-grid-reset-html"><?php esc_html_e('Restore Default'); ?></a>
			<script>
			jQuery('.pp-custom-grid-reset-html').on('click', function(e) {
				e.preventDefault();
				var res = confirm( "<?php esc_html_e('Original HTML will be restored once you click on OK.', 'bb-powerpack'); ?>" );
				if ( res === true ) {
					var original_html = JSON.parse( jQuery('#fl-field-original_html textarea').val() );
					var editor = ace.edit( jQuery('#fl-field-html .ace_editor')[0] );
					editor.getSession().setValue(original_html);
				}
			});
			</script>
			<?php
		}
		elseif ( $name == 'original_css' ) {
			?>
			<a href="javascript:void(0)" class="pp-custom-grid-reset-css"><?php esc_html_e('Restore Default'); ?></a>
			<script>
			jQuery('.pp-custom-grid-reset-css').on('click', function(e) {
				e.preventDefault();
				var res = confirm( "<?php esc_html_e('Original CSS will be restored once you click on OK.', 'bb-powerpack'); ?>" );
				if ( res === true ) {
					var original_css = JSON.parse( jQuery('#fl-field-original_css textarea').val() );
					var editor = ace.edit( jQuery('#fl-field-css .ace_editor')[0] );
					editor.getSession().setValue(original_css);
				}
			});
			</script>
			<?php
		}
		else {
			return;
		}
	}

	/**
	 * Renders custom CSS for the custom grid module.
	 *
	 * @since 1.2.7
	 * @param string $css
	 * @param array  $nodes
	 * @return string
	 */
	static public function custom_grid_css( $css, $nodes ) {
		$css = PPModuleExtend::post_grid_css( $css, $nodes );

		return $css;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('PPCustomGridModule', array(
	'layout'        => array(
		'title'         => __('Layout', 'bb-powerpack'),
		'description'	=> __('We recommend using <strong>Content Grid</strong> module with "Custom Layout" option to create custom layouts instead of this module.', 'bb-powerpack'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'preset'		=> array(
						'type'			=> 'select',
						'label'			=> __('Choose Preset', 'bb-powerpack'),
						'default'		=> 'post_1',
						'options'		=> PPCustomGridModule::get_presets_options(),
					),
				)
			),
			'posts'         => array(
				'title'         => __('Posts', 'bb-powerpack'),
				'fields'        => array(
					'match_height'  => array(
						'type'          => 'pp-switch',
						'label'         => __('Equal Heights', 'bb-powerpack'),
						'default'       => '0',
						'options'       => array(
							'1'             => __('Yes', 'bb-powerpack'),
							'0'             => __('No', 'bb-powerpack')
						),
						'toggle'		=> array(
							'1'				=> array(
								'fields'		=> array('post_columns')
							),
							'0'				=> array(
								'fields'		=> array('post_width')
							)
						)
					),
					'post_width'    => array(
						'type'          => 'unit',
						'label'         => __('Post Width', 'bb-powerpack'),
						'default'       => '300',
						'slider'		=> true,
						'units'		   	=> array( 'px' )
					),
					'post_columns'  => array(
						'type'          => 'unit',
						'label'         => __( 'Columns', 'bb-powerpack' ),
						'slider'		=> array(
							'min'			=> 1,
							'max'			=> 10,
							'step'			=> 1
						),
						'responsive'  => array(
							'default' 	  => array(
								'default'    => '3',
								'medium'     => '2',
								'responsive' => '1',
							)
						)
					),
					'post_spacing' => array(
						'type'          => 'unit',
						'label'         => __('Post Spacing', 'bb-powerpack'),
						'default'       => '30',
						'slider'		=> true,
						'units'		   	=> array( 'px' )
					),
					'post_align'    => array(
						'type'          => 'select',
						'label'         => __('Post Alignment', 'bb-powerpack'),
						'default'       => 'default',
						'options'       => array(
							'default'       => __('Default', 'bb-powerpack'),
							'left'          => __('Left', 'bb-powerpack'),
							'center'        => __('Center', 'bb-powerpack'),
							'right'         => __('Right', 'bb-powerpack')
						)
					),
				)
			),
		)
	),
	'content'   => array(
		'title'         => __('Content', 'bb-powerpack'),
		'file'          => FL_BUILDER_DIR . 'includes/loop-settings.php',
	),
	'pagination' => array(
		'title'      => __( 'Pagination', 'bb-powerpack' ),
		'sections'   => array(
			'pagination'   => array(
				'title'         => __('Pagination', 'bb-powerpack'),
				'fields'        => array(
					'pagination'     => array(
						'type'          => 'pp-switch',
						'label'         => __('Pagination Style', 'bb-powerpack'),
						'default'       => 'numbers',
						'options'       => array(
							'numbers'       => __('Numbers', 'bb-powerpack'),
							'scroll'        => __('Scroll', 'bb-powerpack'),
							'none'          => _x( 'None', 'Pagination style.', 'bb-powerpack' ),
						)
					),
					'posts_per_page' => array(
						'type'          => 'text',
						'label'         => __('Posts Per Page', 'bb-powerpack'),
						'default'       => '10',
						'size'          => '4'
					),
					'no_results_message' => array(
						'type' 				=> 'text',
						'label'				=> __('No Results Message', 'bb-powerpack'),
						'default'			=> __('Sorry, we couldn\'t find any posts. Please try a different search.', 'bb-powerpack')
					),
					'show_search'    => array(
						'type'          => 'pp-switch',
						'label'         => __('Show Search', 'bb-powerpack'),
						'default'       => '1',
						'options'       => array(
							'1'             => __('Show', 'bb-powerpack'),
							'0'             => __('Hide', 'bb-powerpack')
						),
						'help'          => __( 'Shows the search form if no posts are found.', 'bb-powerpack' )
					)
				)
			)
		)
	),
	'style'         => array(
		'title'         => __('Style', 'bb-powerpack'),
		'sections'      => array(
			'post_style'    => array(
				'title'         => __('Posts', 'bb-powerpack'),
				'fields'        => array(
					'bg_color'      => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-powerpack'),
						'show_alpha'	=> true,
						'show_reset'    => true,
						'connections'	=> array('color'),
						'preview'		=> array(
							'type'			=> 'css',
							'selector'		=> '.pp-custom-grid-post',
							'property'		=> 'background-color'
						)
					),
					'post_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-custom-grid-post',
                            'property'  	=> 'border',
                        ),
					),
				)
			),
			'pagination_style'	=> array(
				'title'         	=> __('Pagination', 'bb-powerpack'),
				'fields'        	=> array(
					'pagination_bg_color'	=> array(
						'type'					=> 'color',
						'label'					=> __('Background Color', 'bb-powerpack'),
						'default'				=> '',
						'show_alpha'			=> true,
						'show_reset'    		=> true,
						'connections'			=> array('color'),
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-custom-grid-pagination li a.page-numbers, .pp-custom-grid-pagination li span.page-numbers',
							'property'				=> 'background'
						)
					),
					'pagination_bg_color_h'	=> array(
						'type'					=> 'color',
						'label'					=> __('Background Hover Color', 'bb-powerpack'),
						'default'				=> '',
						'show_alpha'			=> true,
						'show_reset'    		=> true,
						'connections'			=> array('color'),
						'preview'				=> array(
							'type'					=> 'none',
						)
					),
					'pagination_text_color'	=> array(
						'type'					=> 'color',
						'label'					=> __('Text Color', 'bb-powerpack'),
						'default'				=> '',
						'show_reset'    		=> true,
						'connections'			=> array('color'),
						'preview'				=> array(
							'type'					=> 'css',
							'selector'				=> '.pp-custom-grid-pagination li a.page-numbers, .pp-custom-grid-pagination li span.page-numbers',
							'property'				=> 'color'
						)
					),
					'pagination_text_color_h'	=> array(
						'type'						=> 'color',
						'label'						=> __('Text Hover Color', 'bb-powerpack'),
						'default'					=> '',
						'show_reset'    			=> true,
						'connections'				=> array('color'),
						'preview'					=> array(
							'type'						=> 'none',
						)
					),
					'pagination_border'	=> array(
						'type'          => 'border',
						'label'         => __( 'Border', 'bb-powerpack' ),
						'responsive'	=> true,
						'preview'   	=> array(
                            'type'  		=> 'css',
                            'selector'  	=> '.pp-custom-grid-pagination li a.page-numbers, .pp-custom-grid-pagination li span.page-numbers',
                            'property'  	=> 'border',
                        ),
					),
				)
			)
		)
	),
));

include BB_POWERPACK_DIR . 'modules/pp-custom-grid/includes/settings-form.php';
