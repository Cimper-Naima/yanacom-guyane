<?php
/**
 * Handles logic for modules.
 *
 * @package BB_PowerPack
 * @since 2.6.10
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PPModuleExtend.
 */
final class PPModuleExtend {
	/**
	 * @since 2.7.0
	 * @return void
	 */
	static public function init() {
		// Filters.
		if ( class_exists( 'FLThemeBuilderLoader' ) ) {
			add_filter( 'fl_builder_register_settings_form',   	__CLASS__ . '::post_grid_settings', 10, 2 );
			add_filter( 'fl_builder_render_css',               	__CLASS__ . '::post_grid_css', 10, 2 );
			add_filter( 'pp_cg_module_layout_path', 			__CLASS__ . '::post_grid_layout_path', 10, 3 );
			add_filter( 'pp_post_custom_layout_html', 			__CLASS__ . '::post_custom_html_parse_shortcodes', 1 );
		}
		add_action( 'wp_head', __CLASS__ . '::render_faq_schema' );
	}

	static public function render_faq_schema() {
		if ( ! is_callable( 'FLBuilderModel::get_nodes' ) ) {
			return;
		}

		$nodes = FLBuilderModel::get_nodes();
		$modules = array();
		$schema = false;

		// @codingStandardsIgnoreStart.
		$schema_data = array(
			"@context" => "https://schema.org",
			"@type" => "FAQPage",
			"mainEntity" => array(),
		);
		// @codingStandardsIgnoreEnd.

		foreach ( $nodes as $node ) {
			if ( ! is_object( $node ) ) {
				continue;
			}

			if ( 'module' == $node->type && 'pp-faq' == $node->settings->type ) {
				$modules[] = $node;
			}

			if ( 'module' != $node->type && isset( $node->template_id ) ) {
				$template_id = $node->template_id;
				$template_node_id = $node->template_node_id;
				$post_id  = FLBuilderModel::get_node_template_post_id( $template_id );
				$data     = FLBuilderModel::get_layout_data( 'published', $post_id );

				foreach ( $data as $global_node ) {
					if ( 'module' == $global_node->type && 'pp-faq' == $global_node->settings->type ) {
						$modules[] = $global_node;
					}
				}
			}
		} // End foreach().

		if ( empty( $modules ) ) {
			return;
		}

		foreach ( $modules as $node ) {
			$settings = $node->settings;

			if ( isset( $settings->enable_schema ) && 'no' == $settings->enable_schema ) {
				continue;
			}

			if ( ! is_callable( 'FLBuilderModel::get_module' ) ) {
				continue;
			}

			$module = FLBuilderModel::get_module( $node );

			$items = $module->get_faq_items();

			for ( $i = 0; $i < count( $items ); $i++ ) {
				if ( ! is_object( $items[ $i ] ) ) {
					continue;
				}

				// @codingStandardsIgnoreStart.
				$item = (object) array(
					"@type" => "Question",
					"name" => $items[ $i ]->faq_question,
					"acceptedAnswer" => (object) array(
						"@type" => "Answer",
						"text" => $items[ $i ]->answer,
					),
				);
				// @codingStandardsIgnoreEnd.

				$schema_data['mainEntity'][] = $item;
			}
		} // End foreach().

		if ( ! empty( $schema_data['mainEntity'] ) ) {
			$schema_data = apply_filters( 'pp_faq_module_schema_markup', $schema_data );
			echo '<script type="application/ld+json">';
			echo json_encode( $schema_data );
			echo '</script>';
		}
	}

	/**
	 * Adds the custom code settings for custom post
	 * module layouts.
	 *
	 * @since 1.0
	 * @param array $form	Module setting form fields array.
	 * @param string $slug	Module slug.
	 * @return array
	 */
	static public function post_grid_settings( $form, $slug ) {
		if ( 'pp-content-grid' != $slug ) {
			return $form;
		}

		$form['layout']['sections']['layout_cg']['fields']['post_grid_style_select']['options']['custom'] = __( 'Custom', 'bb-powerpack' );
		$form['layout']['sections']['layout_cg']['fields']['post_grid_style_select']['toggle']['custom'] = array(
			'fields' => array( 'custom_layout' ),
		);

		$fields = $form['layout']['sections']['layout_cg']['fields'];
		$custom_layout = array(
			'type'          => 'form',
			'label'         => __( 'Custom Layout', 'bb-powerpack' ),
			'form'          => 'pp_post_custom_layout',
			'preview_text'  => null,
			'multiple'		=> false,
		);

		$position = array_search( 'match_height', array_keys( $fields ) );
		$fields = array_merge(
			array_slice( $fields, 0, $position ),
			array(
				'custom_layout' => $custom_layout,
			),
			array_slice( $fields, $position )
		);

		$form['layout']['sections']['layout_cg']['fields'] = $fields;

		FLBuilder::register_settings_form( 'pp_post_custom_layout', array(
			'title' => __( 'Customize Layout', 'bb-powerpack' ),
			'tabs'  => array(
				'html'          => array(
					'title'         => __( 'HTML', 'bb-powerpack' ),
					'sections'      => array(
						'html'          => array(
							'title'         => '',
							'fields'        => array(
								'html'          => array(
									'type'          => 'code',
									'editor'        => 'html',
									'label'         => '',
									'rows'          => '18',
									'default'       => self::get_preset_data( 'html' ),
									'preview'           => array(
										'type'              => 'none',
									),
									'connections'       => array( 'html', 'string', 'url' ),
								),
							),
						),
					),
				),
				'css'           => array(
					'title'         => __( 'CSS', 'bb-powerpack' ),
					'sections'      => array(
						'css'           => array(
							'title'         => '',
							'fields'        => array(
								'css'           => array(
									'type'          => 'code',
									'editor'        => 'css',
									'label'         => '',
									'rows'          => '18',
									'default'       => self::get_preset_data( 'css' ),
									'preview'           => array(
										'type'              => 'none',
									),
								),
							),
						),
					),
				),
			),
		));

		return $form;
	}

	/**
	 * Get content from Post module's HTML and CSS files.
	 *
	 * @since 1.0
	 * @param string $type	html or css.
	 * @return string
	 */
	static public function get_preset_data( $type ) {
		if ( ! in_array( $type, array( 'html', 'css' ) ) ) {
			return;
		}

		$file = BB_POWERPACK_DIR . 'includes/post-module-layout-' . $type . '.php';

		if ( file_exists( $file ) ) {
			return file_get_contents( $file );
		}
	}

	/**
	 * Renders custom CSS for the post grid module.
	 *
	 * @since 1.0
	 * @param string $css
	 * @param array  $nodes
	 * @return string
	 */
	static public function post_grid_css( $css, $nodes ) {
		// Better _supported_ Less compiler.
		if ( ( version_compare( PHP_VERSION, '5.3.0', '>' ) || ! defined( 'FL_THEMER_DEPRECATED_LESSC' ) )
			&& file_exists( FL_THEME_BUILDER_DIR . '/includes/vendor/Less/Autoloader.php' ) ) {

			require_once FL_THEME_BUILDER_DIR . '/includes/vendor/Less/Autoloader.php';
			Less_Autoloader::register();

			$parser = new Less_Parser( array(
				'compress' => true,
			) );

			foreach ( $nodes['modules'] as $module ) {

				if ( ! is_object( $module ) ) {
					continue;
				}

				if ( 'pp-content-grid' != $module->settings->type && 'pp-custom-grid' != $module->settings->type ) {
					continue;
				}

				$module_css = '';

				if ( 'pp-content-grid' == $module->settings->type ) {
					if ( 'custom' != $module->settings->post_grid_style_select ) {
						continue;
					}

					$module_css = $module->settings->custom_layout->css;
				}

				if ( 'pp-custom-grid' == $module->settings->type ) {
					if ( ! isset( $module->settings->preset ) || empty( $module->settings->preset ) ) {
						continue;
					}

					$preset = $module->settings->preset;
					$preset_form = $module->settings->{$preset . '_preset'};

					if ( ! isset( $preset_form->css ) ) {
						continue;
					}

					$module_css = $preset_form->css;
				}

				try {
					$custom  = '.fl-node-' . $module->node . ' { ';
					$custom .= $module_css;
					$custom .= ' }';
					$parser->parse( $custom );
					$css .= $parser->getCss();
				} catch ( Exception $e ) {
					@error_log( 'bb-powerpack: ' . $e ); // @codingStandardsIgnoreLine
					$css .= $module_css;
				}
			} // End foreach().
		} else {
			if ( ! class_exists( 'lessc' ) ) {
				require_once BB_POWERPACK_DIR . 'classes/class-lessc.php';
			}
			foreach ( $nodes['modules'] as $module ) {

				if ( ! is_object( $module ) ) {
					continue;
				}

				if ( 'pp-content-grid' != $module->settings->type && 'pp-custom-grid' != $module->settings->type ) {
					continue;
				}

				$module_css = '';

				if ( 'pp-content-grid' == $module->settings->type ) {
					if ( 'custom' != $module->settings->post_grid_style_select ) {
						continue;
					}

					$module_css = $module->settings->custom_layout->css;
				}

				if ( 'pp-custom-grid' == $module->settings->type ) {
					if ( ! isset( $module->settings->preset ) || empty( $module->settings->preset ) ) {
						continue;
					}

					$preset = $module->settings->preset;
					$preset_form = $module->settings->{$preset . '_preset'};

					if ( ! isset( $preset_form->css ) ) {
						continue;
					}

					$module_css = $preset_form->css;
				}

				try {
					$less    = new lessc;
					$custom  = '.fl-node-' . $module->node . ' { ';
					$custom .= $module_css;
					$custom .= ' }';
					$css    .= @$less->compile( $custom ); // @codingStandardsIgnoreLine
				} catch ( Exception $e ) {
					@error_log( 'bb-powerpack: ' . $e ); // @codingStandardsIgnoreLine
					$css .= $module_css;
				}
			} // End foreach().
		} // End if().

		return $css;
	}

	static public function post_grid_layout_path( $path, $layout, $settings ) {
		if ( 'custom' == $settings->post_grid_style_select ) {
			return BB_POWERPACK_DIR . 'includes/post-module-layout.php';
		}

		return $path;
	}

	static public function post_custom_html_parse_shortcodes( $content ) {
		return FLThemeBuilderFieldConnections::parse_shortcodes(
			$content,
			array(
				'wpbb-acf-flex',
				'wpbb-acf-repeater',
			)
		);
	}
}

PPModuleExtend::init();
