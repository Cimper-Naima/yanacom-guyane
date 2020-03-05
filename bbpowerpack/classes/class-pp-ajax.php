<?php
/**
 * Handles logic for AJAX.
 *
 * @package BB_PowerPack
 * @since 1.0.0
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PowerPack AJAX handler.
 */
class BB_PowerPack_Ajax {
	/**
	 * Initializes actions.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function init() {
		add_action( 'wp', 										__CLASS__ . '::handle_ajax' );
		// add_action( 'pp_post_grid_ajax_before_query', 			__CLASS__ . '::loop_fake_actions' );
		add_action( 'wp_ajax_pp_get_taxonomies', 				__CLASS__ . '::get_post_taxonomies' );
		add_action( 'wp_ajax_nopriv_pp_get_taxonomies', 		__CLASS__ . '::get_post_taxonomies' );
		add_action( 'wp_ajax_pp_get_saved_templates', 			__CLASS__ . '::get_saved_templates' );
		add_action( 'wp_ajax_nopriv_pp_get_saved_templates', 	__CLASS__ . '::get_saved_templates' );
		add_action( 'wp_ajax_pp_notice_close', 					__CLASS__ . '::close_notice' );
	}

	/**
	 * Hooks for fake loop.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	static public function loop_fake_actions() {
		add_action( 'loop_start', __CLASS__ . '::fake_loop_true' );
		add_action( 'loop_end', __CLASS__ . '::fake_loop_false' );
	}

	/**
	 * Fake loop.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	static public function fake_loop_true() {
		global $wp_query;
		// Fake being in the loop.
		$wp_query->in_the_loop = true;
	}

	/**
	 * Reset fake loop.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	static public function fake_loop_false() {
		global $wp_query;
		// Stop faking being in the loop.
		$wp_query->in_the_loop = false;

		remove_action( 'loop_start', __CLASS__ . '::fake_loop_true' );
		remove_action( 'loop_end', __CLASS__ . '::fake_loop_false' );
	}

	/**
	 * Execute method based on action passed.
	 *
	 * @return void
	 */
	static public function handle_ajax() {
		if ( ! isset( $_POST['pp_action'] ) || empty( $_POST['pp_action'] ) ) {
			return;
		}

		$action = sanitize_text_field( wp_unslash( $_POST['pp_action'] ) );

		if ( ! method_exists( __CLASS__, $action ) ) {
			return;
		}

		// Tell WordPress this is an AJAX request.
		if ( ! defined( 'DOING_AJAX' ) ) {
			define( 'DOING_AJAX', true );
		}

		$method = $action;

		self::$method();
	}

	/**
	 * Logic to upload CSV file using Table module.
	 *
	 * @return void
	 */
	static public function table_csv_upload() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( __( 'Error uploading file.', 'bb-powerpack' ) );
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'pp_table_csv' ) ) { // input var okay.
			wp_send_json_error( __( 'Invalid request.', 'bb-powerpack' ) );
		}

		if ( ! isset( $_FILES['file'] ) ) {
			wp_send_json_error( __( 'Please provide CSV file.', 'bb-powerpack' ) );
		}

		$file = $_FILES['file'];

		// validate file type.
		if ( 'csv' !== strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) ) {
			wp_send_json_error( __( 'Invalid file type. Please provide CSV file.', 'bb-powerpack' ) );
		}

		$upload_dir = BB_PowerPack::$upload_dir;

		$source_path = $file['tmp_name'];
		$target_path = $upload_dir['path'] . $file['name'];

		if ( file_exists( $target_path ) ) {
			unlink( $target_path );
		}

		if ( move_uploaded_file( $source_path, $target_path ) ) {
			wp_send_json_success( array(
				'filename' 		=> $file['name'],
				'filepath'		=> $target_path,
				'upload_time'	=> isset( $_POST['time'] ) ? esc_attr( $_POST['time'] ) : current_time( 'timestamp' ),
			) );
		}

		wp_send_json_error( __( 'Error uploading file.', 'bb-powerpack' ) );
	}

	/**
	 * Logic to query posts for Content Grid.
	 *
	 * @return void
	 */
	static public function get_ajax_posts() {
		$is_error = false;

		if ( ! isset( $_POST['settings'] ) || empty( $_POST['settings'] ) ) {
			return;
		}

		$settings = (object) $_POST['settings'];
		$module_dir = pp_get_module_dir( 'pp-content-grid' );
		$module_url = pp_get_module_url( 'pp-content-grid' );

		$response = array(
			'data'  => '',
			'pagination' => false,
		);

		$post_type = $settings->post_type;

		global $wp_query;

		$args = array(
			'post_type'             => $post_type,
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => true,
			'pp_content_grid'       => true,
		);

		if ( 'custom_query' === $settings->data_source ) {

			if ( isset( $settings->posts_per_page ) ) {
				$args['posts_per_page'] = $settings->posts_per_page;
			}

			// posts filter.
			if ( isset( $settings->{'posts_' . $post_type} ) ) {

				$ids = $settings->{'posts_' . $post_type};
				$arg = 'post__in';

				if ( isset( $settings->{'posts_' . $post_type . '_matching'} ) ) {
					if ( ! $settings->{'posts_' . $post_type . '_matching'} ) {
						$arg = 'post__not_in';
					}
				}

				if ( ! empty( $ids ) ) {
					$args[ $arg ] = explode( ',', $ids );
				}
			}

			// author filter.
			if ( isset( $settings->users ) ) {

				$users = $settings->users;
				$arg = 'author__in';

				// Set to NOT IN if matching is present and set to 0.
				if ( isset( $settings->users_matching ) && ! $settings->users_matching ) {
					$arg = 'author__not_in';
				}

				if ( ! empty( $users ) ) {
					if ( is_string( $users ) ) {
						$users = explode( ',', $users );
					}

					$args[ $arg ] = $users;
				}
			}
		} // End if().

		if ( isset( $_POST['author_id'] ) && ! empty( $_POST['author_id'] ) ) {
			$args['author__in'] = array( absint( wp_unslash( $_POST['author_id'] ) ) );
		}

		if ( isset( $settings->post_grid_filters ) && 'none' !== $settings->post_grid_filters && isset( $_POST['term'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $settings->post_grid_filters,
					'field'    => 'slug',
					'terms'    => sanitize_text_field( wp_unslash( $_POST['term'] ) ),
				),
			);
		} else {
			if ( isset( $_POST['taxonomy'] ) && isset( $_POST['term'] ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => sanitize_text_field( wp_unslash( $_POST['taxonomy'] ) ),
						'field'    => 'slug',
						'terms'    => sanitize_text_field( wp_unslash( $_POST['term'] ) ),
					),
				);
			}
		}

		$taxonomies = FLBuilderLoop::taxonomies( $post_type );

		foreach ( $taxonomies as $tax_slug => $tax ) {

			$tax_value = '';
			$term_ids  = array();
			$operator  = 'IN';

			// Get the value of the suggest field.
			if ( isset( $settings->{'tax_' . $post_type . '_' . $tax_slug} ) ) {
				// New style slug.
				$tax_value = $settings->{'tax_' . $post_type . '_' . $tax_slug};
			} elseif ( isset( $settings->{'tax_' . $tax_slug} ) ) {
				// Old style slug for backwards compat.
				$tax_value = $settings->{'tax_' . $tax_slug};
			}

			// Get the term IDs array.
			if ( ! empty( $tax_value ) ) {
				$term_ids = explode( ',', $tax_value );
			}

			// Handle matching settings.
			if ( isset( $settings->{'tax_' . $post_type . '_' . $tax_slug . '_matching'} ) ) {

				$tax_matching = $settings->{'tax_' . $post_type . '_' . $tax_slug . '_matching'};

				if ( ! $tax_matching ) {
					// Do not match these terms.
					$operator = 'NOT IN';
				} elseif ( 'related' === $tax_matching ) {
					// Match posts by related terms from the global post.
					global $post;
					$terms 	 = wp_get_post_terms( $post->ID, $tax_slug );
					$related = array();

					foreach ( $terms as $term ) {
						if ( ! in_array( $term->term_id, $term_ids ) ) {
							$related[] = $term->term_id;
						}
					}

					if ( empty( $related ) ) {
						// If no related terms, match all except those in the suggest field.
						$operator = 'NOT IN';
					} else {

						// Don't include posts with terms selected in the suggest field.
						$args['tax_query'][] = array(
							'taxonomy'	=> $tax_slug,
							'field'		=> 'id',
							'terms'		=> $term_ids,
							'operator'  => 'NOT IN',
						);

						// Set the term IDs to the related terms.
						$term_ids = $related;
					}
				}
			} // End if().

			if ( ! empty( $term_ids ) ) {

				$args['tax_query'][] = array(
					'taxonomy'	=> $tax_slug,
					'field'		=> 'id',
					'terms'		=> $term_ids,
					'operator'  => $operator,
				);
			}
		} // End foreach().

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && 'product' === $post_type ) {
			$args['meta_query'][] = array(
				'key'       => '_stock_status',
				'value'     => 'instock',
				'compare'   => '=',
			);
		}

		if ( isset( $_POST['page'] ) ) {
			$args['paged'] = absint( wp_unslash( $_POST['page'] ) );
		}

		if ( 'custom_query' === $settings->data_source ) {
			// Offset.
			if ( isset( $settings->offset ) ) {
				$page = isset( $args['paged'] ) ? $args['paged'] : 1;
				$per_page = ( isset( $args['posts_per_page'] ) && $args['posts_per_page'] > 0 ) ? $args['posts_per_page'] : 10;
				if ( $page < 2 ) {
					$args['offset'] = absint( $settings->offset );
				} else {
					$args['offset'] = absint( $settings->offset ) + ( ( $page - 1 ) * $per_page );
				}
			}

			// Order by author.
			if ( 'author' === $settings->order_by ) {
				$args['orderby'] = array(
					'author' => $settings->order,
					'date' => $settings->order,
				);
			} else {
				$args['orderby'] = $settings->order_by;

				// Order by meta value arg.
				if ( strstr( $settings->order_by, 'meta_value' ) ) {
					$args['meta_key'] = $settings->order_by_meta_key;
				}

				if ( isset( $_POST['orderby'] ) ) {
					$orderby = esc_attr( wp_unslash( $_POST['orderby'] ) );

					$args = self::get_conditional_args( $orderby, $args );
				}

				if ( isset( $settings->order ) ) {
					$args['order'] = $settings->order;
				}
			}
		} // End if().

		$args = apply_filters( 'pp_post_grid_ajax_query_args', $args );

		do_action( 'pp_post_grid_ajax_before_query', $settings );

		$query = new WP_Query( $args );

		do_action( 'pp_post_grid_ajax_after_query', $settings );

		if ( $query->have_posts() ) :

			// create pagination.
			if ( $query->max_num_pages > 1 && 'none' !== $settings->pagination ) {
				$style = ( 'scroll' === $settings->pagination ) ? ' style="display: none;"' : '';
				ob_start();

				echo '<div class="pp-content-grid-pagination pp-ajax-pagination fl-builder-pagination"' . $style . '>';
				if ( 'scroll' === $settings->pagination && isset( $_POST['term'] ) ) {
					BB_PowerPack_Post_Helper::ajax_pagination(
						$query,
						$settings,
						esc_attr( wp_unslash( $_POST['current_page'] ) ),
						esc_attr( wp_unslash( $_POST['page'] ) ),
						sanitize_text_field( wp_unslash( $_POST['term'] ) ),
						esc_attr( wp_unslash( $_POST['node_id'] ) )
					);
				} else {
					BB_PowerPack_Post_Helper::ajax_pagination(
						$query,
						$settings,
						esc_attr( wp_unslash( $_POST['current_page'] ) ),
						esc_attr( wp_unslash( $_POST['page'] ) )
					);
				}
				echo '</div>';

				$response['pagination'] = ob_get_clean();
			}

			// posts query.
			while ( $query->have_posts() ) {

				$query->the_post();

				$terms_list = wp_get_post_terms( get_the_ID(), $settings->post_taxonomies );
				$post_id = get_the_ID();
				$permalink = get_permalink();

				ob_start();

				if ( 'custom' === $settings->post_grid_style_select ) {
					include BB_POWERPACK_DIR . 'includes/post-module-layout.php';
				} else {
					include apply_filters( 'pp_cg_module_layout_path', $module_dir . 'includes/post-grid.php', $settings->layout, $settings );
				}

				$response['data'] .= do_shortcode( wp_unslash( ob_get_clean() ) );
			}

			wp_reset_postdata();

		else :
			$response['data'] = '<div>' . esc_html__( 'No posts found.', 'bb-powerpack' ) . '</div>';
		endif;

		wp_reset_query();

		wp_send_json( $response );
	}

	/**
	 * Get conditional arguments for meta data.
	 *
	 * @param string $type	Type of the meta key.
	 * @param array  $args	WP query args.
	 * @return array
	 */
	static public function get_conditional_args( $type, $args ) {
		switch ( $type ) :
			case 'date':
				$args['orderby'] = 'date ID';
				$args['order'] = 'DESC';
				break;

			case 'price':
				$args['meta_key'] = '_price';
				$args['order'] = 'ASC';
				$args['orderby'] = 'meta_value_num';
				break;

			case 'price-desc':
				$args['meta_key'] = '_price';
				$args['order'] = 'DESC';
				$args['orderby'] = 'meta_value_num';
				break;

			default:
				break;

		endswitch;

		return $args;
	}

	/**
	 * Get taxonomies of a post type.
	 *
	 * @param string $post_type Post type.
	 */
	static public function get_post_taxonomies( $post_type = 'post' ) {
		if ( isset( $_POST['post_type'] ) && ! empty( $_POST['post_type'] ) ) {
			$post_type = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );
		}

		$taxonomies = FLBuilderLoop::taxonomies( $post_type );
		$html = '';

		foreach ( $taxonomies as $tax_slug => $tax ) {
			$html .= '<option value="' . $tax_slug . '">' . $tax->label . '</option>';
		}

		echo $html;
		die;
	}

	/**
	 * Get saved templates.
	 *
	 * @since 1.4
	 */
	static public function get_saved_templates() {
		$response = array(
			'success' => false,
			'data'	=> array(),
		);

		$args = array(
			'post_type' 		=> 'fl-builder-template',
			'orderby' 			=> 'title',
			'order' 			=> 'ASC',
			'posts_per_page' 	=> '-1',
		);

		if ( isset( $_POST['type'] ) && ! empty( $_POST['type'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy'		=> 'fl-builder-template-type',
					'field'			=> 'slug',
					'terms'			=> sanitize_text_field( wp_unslash( $_POST['type'] ) ),
				),
			);
		}

		$posts = get_posts( $args );

		$options = '';

		if ( count( $posts ) ) {
			foreach ( $posts as $post ) {
				$options .= '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
			}

			$response = array(
				'success' => true,
				'data' => $options,
			);
		} else {
			$response = array(
				'success' => true,
				'data' => '<option value="" disabled>' . __( 'No templates found!', 'bb-powerpack' ) . '</option>',
			);
		}

		echo json_encode( $response );
		die;
	}

	static public function close_notice() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'pp_notice' ) ) {
			wp_send_json_error( esc_html__( 'Action failed. Please refresh the page and retry.', 'bb-powerpack' ) );
		}
		if ( ! isset( $_POST['notice'] ) || empty( $_POST['notice'] ) ) {
			wp_send_json_error( esc_html__( 'Action failed. Please refresh the page and retry.', 'bb-powerpack' ) );
		}

		try {
			update_user_meta( get_current_user_id(), 'bb_powerpack_dismissed_latest_update_notice', true );
			wp_send_json_success();
		} catch ( Exception $e ) {
			wp_die( $e->getMessage() );
		}
	}
}

BB_PowerPack_Ajax::init();
