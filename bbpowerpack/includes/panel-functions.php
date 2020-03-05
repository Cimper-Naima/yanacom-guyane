<?php

/**
 * Row templates data exclude
 */
function pp_templates_exclude( $data )
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return $data;
    }
    if ( isset( $data['categorized'] ) ) { //print_r($data['categorized']);

        $cats = pp_row_templates_categories();

        foreach ( $cats as $cat => $name ) {
            if ( isset( $data['categorized'][$cat] ) ) {
                unset( $data['categorized'][$cat] );
            }
        }

        if ( isset( $data['categorized']['powerpack-templates'] ) ) {
            unset( $data['categorized']['powerpack-templates'] );
        }
        if ( isset( $data['categorized']['uncategorized'] ) ) {
            unset( $data['categorized']['uncategorized'] );
        }
    }

    return $data;
}
add_filter( 'fl_builder_row_templates_data', 'pp_templates_exclude', 50 );

/**
 * Row templates selector data exclude
 */
function pp_templates_selector_data_exclude( $data, $type )
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return $data;
    }
    if ( isset( $data['categorized'] ) ) {

        $cats = pp_row_templates_categories();

        foreach ( $cats as $cat => $name ) {
            if ( isset( $data['categorized'][$cat] ) ) {
                unset( $data['categorized'][$cat] );
            }
        }

        if ( isset( $data['categorized']['powerpack-templates'] ) ) {
            unset( $data['categorized']['powerpack-templates'] );
        }
        if ( isset( $data['categorized']['uncategorized'] ) ) {
            unset( $data['categorized']['uncategorized'] );
        }
    }

    return $data;
}
add_filter( 'fl_builder_template_selector_data', 'pp_templates_selector_data_exclude', 50, 2 );

/**
 * Remove main category PowerPack Templates from templates data.
 *
 * @since 1.3
 */
function pp_template_details( $data, $template )
{
	if ( isset( $data['category'] ) ) {
		if ( is_array($data['category']) && isset( $data['category']['powerpack-templates'] ) ) {

			$scheme = BB_PowerPack_Admin_Settings::get_template_scheme();

			if ( strstr( $template->image, '://' ) ) {
				$image = $template->image;
			}
			else {
				$image_name = preg_replace( '/\s+/', '-', strtolower( $template->name ) );
				$image_name = $image_name . '.jpg';
				$image_path = BB_POWERPACK_DIR . 'template-assets/' . $scheme . '/' . $image_name;

				if ( file_exists( $image_path ) ) {
					$image = BB_POWERPACK_URL . 'template-assets/' . $scheme . '/' . $image_name;
				}
				elseif ( file_exists( BB_POWERPACK_DIR . 'template-assets/greyscale/' . $image_name ) ) {
					$image = BB_POWERPACK_URL . 'template-assets/greyscale/' . $image_name;
				}
				else {
					$image = BB_POWERPACK_URL . 'template-assets/blank-template.jpg';
				}
			}

			$data['image'] = $image;

			// Remove the main category from data.
			unset($data['category']['powerpack-templates']);
		}
		
		$cat_label = BB_PowerPack_Admin_Settings::get_option( 'ppwl_tmpcat_label' );
		
		if ( ! empty( $cat_label ) ) {
			if ( is_array( $data['category'] ) && isset( $data['category']['powerpack-layouts'] ) ) {
				$data['category']['powerpack-layouts'] = $cat_label;
				if ( isset( $data['category']['free-templates'] ) ) {
					unset( $data['category']['free-templates'] );
				}
			}
			elseif ( 'powerpack-layouts' == $data['category'] ) {
				$data['category'] = $cat_label;
			}
		}
    }

    return $data;
}
add_filter( 'fl_builder_template_details', 'pp_template_details', 50, 2 );

/**
 * Get template data
 */
function pp_templates_get_data()
{
    $categorized = array();
    $parent = get_term_by( 'slug', 'powerpack-templates', 'fl-builder-template-category' );

    if ( !is_object( $parent ) ) {
        return;
    }

    $cats = get_term_children( $parent->term_id, 'fl-builder-template-category' );

    foreach ( $cats as $cat ) {
        $term = get_term_by( 'id', $cat, 'fl-builder-template-category' );
        $data = get_posts( array(
            'post_type'     => 'fl-builder-template',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'tax_query'         => array(
                array(
                    'taxonomy'      => 'fl-builder-template-category',
                    'field'         => 'slug',
                    'terms'         => array($term->slug)
                )
            )
        ) );

        $categorized['categorized'][$term->slug]['name'] = $term->name;

        foreach ( $data as $template ) {
            $categorized['categorized'][$term->slug]['templates'][] = array(
                'id'    => $template->ID,
                'name'  => $template->post_title,
                'image' => wp_get_attachment_url( get_post_thumbnail_id($template->ID) ),
                'type'  => 'user'
            );
        }
    }

    return $categorized;
}

/**
 * Returns data for all core or third party templates.
 *
 * @since 1.1.5
 * @return array
 */
function pp_get_templates()
{
    $templates = FLBuilderModel::get_templates('row');

    return $templates;
}


/**
 * Returns template data needed for the template selector.
 *
 * @since 1.1.5
 * @param string $type row
 * @return array
 */
function pp_get_template_selector_data( $type = 'row' )
{
	$categorized     = array();
	$templates       = array();
    $scheme	         = BB_PowerPack_Admin_Settings::get_template_scheme();

	// Build the templates array.
	foreach( pp_get_templates() as $key => $template ) {

        if ( isset( $template->categories ) && ! isset( $template->categories['powerpack-templates'] ) ) {
            continue;
        }

		if ( strstr( $template->image, '://' ) ) {
			$image = $template->image;
		}
		else {
            $image_name = preg_replace( '/\s+/', '-', strtolower( $template->name ) );
            $image_name = $image_name . '.jpg';
            $image_path = BB_POWERPACK_DIR . 'template-assets/' . $scheme . '/' . $image_name;

            if ( file_exists( $image_path ) ) {
                $image = BB_POWERPACK_URL . 'template-assets/' . $scheme . '/' . $image_name;
            }
            elseif ( file_exists( BB_POWERPACK_DIR . 'template-assets/greyscale/' . $image_name ) ) {
                $image = BB_POWERPACK_URL . 'template-assets/greyscale/' . $image_name;
            }
            else {
			    $image = BB_POWERPACK_URL . 'template-assets/blank-template.jpg';
            }
		}

		$templates[] = array(
			'id' 		=> $key,
			'name'  	=> $template->name,
			'image' 	=> $image,
			'category'	=> isset( $template->category ) ? $template->category : $template->categories,
			'type'      => 'core'
		);
	}

	// Build the categorized templates array.
	foreach( $templates as $template ) {

		if ( is_array( $template['category'] ) ) {

			foreach ( $template['category'] as $cat_key => $cat_label ) {

				if ( ! isset( $categorized[ $cat_key ] ) ) {
					$categorized[ $cat_key ] = array(
						'name'		=> $cat_label,
						'templates'	=> array()
					);
				}

				$categorized[ $cat_key ]['templates'][] = $template;
			}
		}
	}

	// Return both the templates and categorized templates array.
	return array(
		'templates'  	=> $templates,
		'categorized' 	=> $categorized
	);
}

/**
 * Row templates panel
 */
function pp_templates_ui_panel()
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return;
    }

    if ( FLBuilderModel::is_builder_active() ) {

        $row_templates = pp_get_template_selector_data();

        if ( version_compare( FL_BUILDER_VERSION, '1.10', '<' ) ) {
            $render_panel = ! FLBuilderModel::current_user_has_editing_capability();
        } else {
            $render_panel = FLBuilderUserAccess::current_user_can('unrestricted_editing');
        }

		if ( $render_panel ) {
			include BB_POWERPACK_DIR . 'includes/ui-panel.php';
		}

    }
}
add_action( 'wp_footer', 'pp_templates_ui_panel' );

/**
 * Custom button in UI bar
 */
function pp_templates_ui_bar_button( $buttons )
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return $buttons;
    }

    $enabled_row_templates = BB_PowerPack_Admin_Settings::get_enabled_templates( 'row' );

    if ( version_compare( FL_BUILDER_VERSION, '1.10', '<' ) ) {
        $simple_ui = ! FLBuilderModel::current_user_has_editing_capability();
    } else {
        $simple_ui = ! FLBuilderUserAccess::current_user_can('unrestricted_editing');
    }

    $content_button = array();

    if ( isset( $buttons['add-content'] ) ) {
        $content_button = $buttons['add-content'];
        unset( $buttons['add-content'] );
    }

    if ( is_array( $enabled_row_templates ) && !in_array( 'disabled', $enabled_row_templates ) ) {
        $buttons['pp-add-template'] = array(
    		'label' => __( 'Row Templates', 'bb-powerpack' ),
            'class' => 'pp-add-template-button',
    		'show'	=> ! $simple_ui
    	);
    }

    if ( count( $content_button ) ) {
        $buttons['add-content'] = $content_button;
    }

    return $buttons;
}
add_filter( 'fl_builder_ui_bar_buttons', 'pp_templates_ui_bar_button' );

/**
 * Custom panel button for Row templates panel
 */
function pp_templates_panel_control()
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return;
    }

    if ( FLBuilderModel::is_builder_active() ) {

        $enabled_row_templates = BB_PowerPack_Admin_Settings::get_enabled_templates( 'row' );

        if ( is_array( $enabled_row_templates ) && !in_array( 'disabled', $enabled_row_templates ) ) {

            $label = BB_PowerPack_Admin_Settings::get_option( 'ppwl_rt_label' );
            $label = ( !$label || '' == trim($label) ) ? 'PowerPack ' . __( 'Row Templates', 'bb-powerpack' ) : $label;

    ?>

        <div id="fl-builder-blocks-templates" class="fl-builder-blocks-section pp-builder-blocks-template">
    		<span class="fl-builder-blocks-section-title">
    			<?php echo $label; ?> <i class="fa fa-chevron-right"></i>
    		</span>
        </div>

    <?php
        }
    }
}
add_action( 'fl_builder_ui_panel_after_rows', 'pp_templates_panel_control' );

/**
 * Panel search
 */
function pp_panel_search()
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return;
    }

    $panel_search = BB_PowerPack_Admin_Settings::get_option('bb_powerpack_search_box');

    if ( $panel_search === false ) {
        BB_PowerPack_Admin_Settings::update_option('bb_powerpack_search_box', 1);
        $panel_search = 1;
    }

    return $panel_search;
}

/**
 * Preview button on frontend
 */
function pp_preview_button()
{
    if ( class_exists( 'FLBuilderUIContentPanel' ) ) {
        return;
    }

    $quick_preview = BB_PowerPack_Admin_Settings::get_option('bb_powerpack_quick_preview');

    if ( $quick_preview === false ) {
        BB_PowerPack_Admin_Settings::update_option('bb_powerpack_quick_preview', 1);
        $quick_preview = 1;
    }

    if ( FLBuilderModel::is_builder_active() && $quick_preview == 1 ) {
    ?>

    <div class="pp-preview-button" title="<?php esc_html_e( 'Preview', 'bb-powerpack' ); ?>">
        <div class="pp-preview-button-wrap">
            <span class="pp-preview-trigger fa fa-eye"></span>
        </div>
    </div>

    <?php
    }
}
add_action( 'wp_footer', 'pp_preview_button' );

/**
 * Template Category White Labeling
 */
function pp_wl_template_category_label( $data )
{
    if ( is_array( $data ) && isset( $data['powerpack-layouts'] ) ) {
        $cat_label = BB_PowerPack_Admin_Settings::get_option( 'ppwl_tmpcat_label' );
        if ( $cat_label && ! empty( $cat_label ) ) {
            $data['powerpack-layouts'] = $cat_label;
        }
    }

    return $data;
}
add_filter( 'fl_builder_template_selector_filter_data', 'pp_wl_template_category_label', 10, 1 );
