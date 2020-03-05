<?php

/**
 * Error messages.
 *
 * @since 1.2.0
 * @return mixed
 */
function pp_set_error( $key )
{
	$errors = array(
		'fetch_error'      	=> esc_html__( 'Unable to fetch template data. Please click on the "Reload" button.', 'bb-powerpack' ),
		'connection_lost'	=> esc_html__( 'Error donwloading template data. Please check your internet connection and click on the "Reload" button.', 'bb-powerpack' ),
	);
	if ( isset( $errors[$key] ) && ! isset( BB_PowerPack::$errors[$key] ) ) {
		BB_PowerPack::$errors[$key] = $errors[$key];
	}
}

/**
 * Checks to see if the site has SSL enabled or not.
 *
 * @since 1.2.1
 * @return bool
 */
function pp_is_ssl()
{
	if ( is_ssl() ) {
		return true;
	}
	else if ( 0 === stripos( get_option( 'siteurl' ), 'https://' ) ) {
		return true;
	}
	else if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
		return true;
	}

	return false;
}

/**
 * Returns an array of paths for the upload directory
 * of the current site.
 *
 * @since 1.1.7
 * @return array
 */
function pp_get_upload_dir()
{
	$wp_info = wp_upload_dir();

	// Get main upload directory for every sub-sites.
    if ( is_multisite() ) {
        switch_to_blog(1);
        $wp_info = wp_upload_dir();
        restore_current_blog();
    }

	$dir_name = basename( BB_POWERPACK_DIR );

	// SSL workaround.
	if ( pp_is_ssl() ) {
		$wp_info['baseurl'] = str_ireplace( 'http://', 'https://', $wp_info['baseurl'] );
	}

	// Build the paths.
	$dir_info = array(
		'path'	 => $wp_info['basedir'] . '/' . $dir_name . '/',
		'url'	 => $wp_info['baseurl'] . '/' . $dir_name . '/'
	);

	// Create .htaccess file for security.
	$htaccess = '<FilesMatch "\.(php|php\.)$">';
	$htaccess .= "\n\r";
	$htaccess .= 'Order Allow,Deny';
	$htaccess .= "\n\r";
	$htaccess .= 'Deny from all';
	$htaccess .= "\n\r";
	$htaccess .= '</FilesMatch>';

	// Create the upload dir if it doesn't exist.
	if ( function_exists( 'fl_builder_filesystem' ) ) {
		if ( ! fl_builder_filesystem()->file_exists( $dir_info['path'] ) ) {

			// Create the directory.
			fl_builder_filesystem()->mkdir( $dir_info['path'] );

			// Add an index file for security.
			fl_builder_filesystem()->file_put_contents( $dir_info['path'] . 'index.html', '' );
		}

		if ( fl_builder_filesystem()->file_exists( $dir_info['path'] ) ) {
			// Add .htaccess file.
			fl_builder_filesystem()->file_put_contents( $dir_info['path'] . '.htaccess', $htaccess );
		}
	} else {
		if ( ! file_exists( $dir_info['path'] ) ) {

			// Create the directory.
			mkdir( $dir_info['path'] );

			// Add an index file for security.
			file_put_contents( $dir_info['path'] . 'index.html', '' );
		}

		if ( file_exists( $dir_info['path'] ) ) {
			// Add .htaccess file.
			file_put_contents( $dir_info['path'] . '.htaccess', $htaccess );
		}
	}

	return $dir_info;
}

/**
 * Row templates categories
 */
function pp_row_templates_categories()
{
    $cats = array(
        'pp-contact-blocks'     => __('Contact Blocks', 'bb-powerpack'),
        'pp-contact-forms'      => __('Contact Forms', 'bb-powerpack'),
        'pp-call-to-action'     => __('Call To Action', 'bb-powerpack'),
        'pp-hero'               => __('Hero', 'bb-powerpack'),
        'pp-heading'            => __('Heading', 'bb-powerpack'),
        'pp-subscribe-forms'    => __('Subscribe Forms', 'bb-powerpack'),
        'pp-content'            => __('Content', 'bb-powerpack'),
        'pp-blog-posts'         => __('Blog Posts', 'bb-powerpack'),
        'pp-lead-generation'    => __('Lead Generation', 'bb-powerpack'),
        'pp-logos'              => __('Logos', 'bb-powerpack'),
        'pp-faq'              	=> __('FAQ', 'bb-powerpack'),
        'pp-team'               => __('Team', 'bb-powerpack'),
        'pp-testimonials'       => __('Testimonials', 'bb-powerpack'),
        'pp-features'           => __('Features', 'bb-powerpack'),
        'pp-services'           => __('Services', 'bb-powerpack'),
        'pp-header'           	=> __('Header', 'bb-powerpack'),
        'pp-footer'           	=> __('Footer', 'bb-powerpack'),
    );

	if ( is_array( $cats ) ) {
    	ksort($cats);
	}

    return $cats;
}

/**
 * Templates categories
 */
function pp_templates_categories( $type )
{
	$templates = BB_PowerPack_Templates_Lib::get_templates_data( $type );
	$data = array();

	if ( is_array( $templates ) ) {
		foreach ( $templates as $cat => $info ) {
			$data[$cat] = array(
				'title'		=> $info['name'],
				'type'		=> $info['type'],
			);
			if ( isset( $info['count'] ) ) {
				$data[$cat]['count'] = $info['count'];
			}
		}

    	$data = array_reverse($data);
	}

    return $data;
}

/**
 * Templates filters
 */
function pp_template_filters()
{
	$filters = array(
		'all'				=> __( 'All', 'bb-powerpack' ),
		'home'				=> __( 'Home', 'bb-powerpack' ),
		'about'				=> __( 'About', 'bb-powerpack' ),
		'contact'			=> __( 'Contact', 'bb-powerpack' ),
		'landing'			=> __( 'Landing', 'bb-powerpack' ),
		'sales'				=> __( 'Sales', 'bb-powerpack' ),
		'coming-soon'		=> __( 'Coming Soon', 'bb-powerpack' ),
	);

	return $filters;
}

/**
 * Templates source URL
 */
function pp_templates_src( $type = 'page', $category = '' )
{
	if ( ! is_admin() ) {
		return;
	}

	$src = array();
	$url = 'https://ppbeaver.s3.amazonaws.com/data/';

	if ( $type == 'row' ) {
		$mode 	= 'color';
		$url 	= $url . $mode . '/';
	}

	foreach ( pp_templates_categories( $type ) as $slug => $title ) {
		$src[$slug] = $url . $slug . '.dat';
	}

	if ( '' != $category && isset( $src[$category] ) ) {
		return $src[$category];
	}

	return $src;
}

/**
 * Templates demo source URL
 */
function pp_templates_preview_src( $type = 'page', $category = '' )
{
    $url = 'https://wpbeaveraddons.com/page-templates/';

	$templates = BB_PowerPack_Templates_Lib::get_templates_data( $type );
	$data = array();

	if ( is_array( $templates ) ) {

		foreach ( $templates as $cat => $info ) {
			$data[$cat] = $info['slug'];
		}

	}

    if ( '' == $category ) {
        return $data;
    }

    if ( isset( $data[$category] ) ) {
        return $data[$category];
    }

    return $url;
}

function pp_get_template_screenshot_url( $type, $category, $mode = '' )
{
	$url = 'https://ppbeaver.s3.amazonaws.com/assets/400x400/';

	return $url . $category . '.jpg';
}

/**
 * Modules
 */
function pp_modules()
{
    // $categories = FLBuilderModel::get_categorized_modules( true );
    // $modules    = array();
	//
    // foreach ( $categories[BB_POWERPACK_CAT] as $title => $module ) {
    //     $slug = is_object( $module ) ? $module->slug : $module['slug'];
    //     $modules[$slug] = $title;
    // }
	foreach(FLBuilderModel::$modules as $module) {
		if ( $module->category == BB_POWERPACK_CAT ) {
			$slug = is_object( $module ) ? $module->slug : $module['slug'];
			$modules[$slug] = $module->name;
		}
	}

    return $modules;
}

/**
 * Row and Column Extensions
 */
function pp_extensions()
{
	$extensions = array(
		'row'       => array(
			'separators'    	=> array(
				'label'				=> __('Separators', 'bb-powerpack'),
				'description'		=> __('Row separators can be added to the top, bottom or both the ends of a row.', 'bb-powerpack'),
			),
			'overlay'       	=> array(
				'label'				=> __('Overlay Style', 'bb-powerpack'),
				'description'		=> __('Choose overlay pattern among Half Overlay Left or Right, Vertical Angled Left or Right.', 'bb-powerpack'),
			),
			'expandable'		=> array(
				'label'				=> __('Expandable', 'bb-powerpack'),
				'description'		=> __('This feature lets you toggle the entire row on just a single click.', 'bb-powerpack'),
			),
			'downarrow'     	=> array(
				'label'				=> __('Down Arrow', 'bb-powerpack'),
				'description'		=> __('This feature will add an arrow icon button at the bottom of a row which let users jump to the next row by clicking on it.', 'bb-powerpack'),
			),
			'background_effect'	=> array(
				'label'				=> __('Background Effects', 'bb-powerpack'),
				'description'		=> __('This feature includes 13 types of amazing animated background for row. These animations consist of an extensive list of styling options.', 'bb-powerpack'),
			),
		),
		'col'       => array(
			'separators'    => array(
				'label'			=> __('Separators', 'bb-powerpack'),
				'description'	=> __('Just like row separators, this feature adds various shapes for column.', 'bb-powerpack'),
			),
		)
	);

    return $extensions;
}

/**
 * Hex to Rgba
 */
function pp_hex2rgba( $hex, $opacity = 1 )
{
	if ( false !== strpos( $hex, 'rgb' ) ) {
		return $hex;
	}
	
	$hex = str_replace( '#', '', $hex );

	if ( strlen($hex) == 3 ) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$opacity = ( $opacity > 1 ) ? ( $opacity / 100 ) : $opacity;
	$rgba = array($r, $g, $b, $opacity);

	return 'rgba(' . implode(', ', $rgba) . ')';
}

/**
 * Get color value hex or rgba
 */
function pp_get_color_value( $color )
{
    if ( $color == '' || ! $color ) {
        return;
    }
    if ( false === strpos( $color, 'rgb' ) ) {
        return '#' . $color;
    } else {
        return $color;
    }
}

/**
 * Returns long day format.
 *
 * @since 1.2.2
 * @param string $day
 * @return mixed
 */
function pp_long_day_format( $day = '' )
{
	$days = array(
		'Sunday'        => __('Sunday', 'bb-powerpack'),
		'Monday'        => __('Monday', 'bb-powerpack'),
		'Tuesday'       => __('Tuesday', 'bb-powerpack'),
		'Wednesday'     => __('Wednesday', 'bb-powerpack'),
		'Thursday'      => __('Thursday', 'bb-powerpack'),
		'Friday'        => __('Friday', 'bb-powerpack'),
		'Saturday'      => __('Saturday', 'bb-powerpack'),
	);

	if ( isset( $days[$day] ) ) {
		return $days[$day];
	}
	else {
		return $days;
	}
}

/**
 * Returns short day format.
 *
 * @since 1.2.2
 * @param string $day
 * @return string
 */
function pp_short_day_format( $day )
{
	$days = array(
		'Sunday'        => __('Sun', 'bb-powerpack'),
		'Monday'        => __('Mon', 'bb-powerpack'),
		'Tuesday'       => __('Tue', 'bb-powerpack'),
		'Wednesday'     => __('Wed', 'bb-powerpack'),
		'Thursday'      => __('Thu', 'bb-powerpack'),
		'Friday'        => __('Fri', 'bb-powerpack'),
		'Saturday'      => __('Sat', 'bb-powerpack'),
	);

	if ( isset( $days[$day] ) ) {
		return $days[$day];
	}
}

/**
 * Returns user agent.
 *
 * @since 1.2.4
 * @return string
 */
function pp_get_user_agent()
{
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	if (stripos( $user_agent, 'Chrome') !== false)
	{
	    return 'chrome';
	}
	elseif (stripos( $user_agent, 'Safari') !== false)
	{
	   return 'safari';
	}
	elseif (stripos( $user_agent, 'Firefox') !== false)
	{
	   return 'firefox';
	}
	elseif (stripos( $user_agent, 'MSIE') !== false)
	{
	   return 'ie';
	}
	elseif (stripos( $user_agent, 'Trident/7.0; rv:11.0' ) !== false)
	{
	   return 'ie';
	}

	return;
}

function pp_get_client_details()
{
	$ip = $_SERVER['REMOTE_ADDR'];

	if ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER ) ) {
		$ip = array_pop( explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
	}

	$user_agent = pp_get_user_agent();

	return array(
		'ip'			=> $ip,
		'user_agent'	=> $user_agent
	);
}

function pp_get_modules_categories( $cat = '' )
{
	$admin_label = pp_get_admin_label();

	$cats = array(
		'creative'		=> sprintf( __('Creative Modules%s', 'bb-powerpack'), ' - ' . $admin_label ),
		'content'		=> sprintf( __('Content Modules%s', 'bb-powerpack'), ' - ' . $admin_label ),
		'lead_gen'		=> sprintf( __('Lead Generation Modules%s', 'bb-powerpack'), ' - ' . $admin_label ),
		'form_style'	=> sprintf( __('Form Styler Modules%s', 'bb-powerpack'), ' - ' . $admin_label ),
	);

	if ( empty( $cat ) ) {
		return $cats;
	}

	if ( isset( $cats[$cat] ) ) {
		return $cats[$cat];
	} else {
		return $cat;
	}
}

/**
 * Returns modules category name for Beaver Builder 2.0 compatibility.
 *
 * @since 1.3
 * @return string
 */
function pp_get_modules_cat( $cat )
{
	return class_exists( 'FLBuilderUIContentPanel' ) ? pp_get_modules_categories( $cat ) : BB_POWERPACK_CAT;
}

/**
 * Returns admin label for PowerPack settings.
 *
 * @since 1.3
 * @return string
 */
function pp_get_admin_label()
{
	$admin_label = BB_PowerPack_Admin_Settings::get_option( 'ppwl_admin_label' );
	$admin_label = trim( $admin_label ) !== '' ? trim( $admin_label ) : 'PowerPack';

	return $admin_label;
}

/**
 * Returns group name for BB 2.x.
 *
 * @since 1.5
 * @return string
 */
function pp_get_modules_group()
{
	$list_with_standard = BB_PowerPack_Admin_Settings::get_option( 'ppwl_list_modules_with_standard' );

	if ( $list_with_standard ) {
		return '';
	}

	$group_name = BB_PowerPack_Admin_Settings::get_option( 'ppwl_builder_label' );
	$group_name = trim( $group_name ) !== '' ? trim( $group_name ) : 'PowerPack ' . __('Modules', 'bb-powerpack');

	return $group_name;
}

/**
 * Returns path of the module.
 *
 * @since 2.3
 * @return string
 */
function pp_get_module_dir( $module = '' )
{
	if ( empty( $module ) ) {
		return;
	}

	$theme_dir = '';
	$module_dir = '';
	$module_path = 'modules/' . $module;

	if ( is_child_theme() ) {
		$theme_dir = get_stylesheet_directory();
	} else {
		$theme_dir = get_template_directory();
	}

	if ( file_exists( $theme_dir . '/bb-powerpack/' . $module_path ) ) {
		$module_dir = $theme_dir . '/bb-powerpack/' . $module_path;
	}
	elseif ( file_exists( $theme_dir . '/bbpowerpack/' . $module_path ) ) {
		$module_dir = $theme_dir . '/bbpowerpack/' . $module_path;
	}
	else {
		$module_dir = BB_POWERPACK_DIR . $module_path;
	}

	return $module_dir . '/';
}

/**
 * Returns URL of the module.
 *
 * @since 2.3
 * @return string
 */
function pp_get_module_url( $module = '' )
{
	if ( empty( $module ) ) {
		return;
	}

	$theme_dir = '';
	$theme_url = '';
	$module_url = '';
	$module_path = 'modules/' . $module;

	if ( is_child_theme() ) {
		$theme_dir = get_stylesheet_directory();
		$theme_url = get_stylesheet_directory_uri();
	} else {
		$theme_dir = get_template_directory();
		$theme_url = get_template_directory_uri();
	}

	if ( file_exists( $theme_dir . '/bb-powerpack/' . $module_path ) ) {
		$module_url = trailingslashit( $theme_url ) . 'bb-powerpack/' . $module_path;
	}
	elseif ( file_exists( $theme_dir . '/bbpowerpack/' . $module ) ) {
		$module_url = trailingslashit( $theme_url ) . 'bbpowerpack/' . $module_path;
	}
	else {
		$module_url = BB_POWERPACK_URL . $module_path;
	}

	return trailingslashit( $module_url );
}

/**
 * Returns Facebook App ID stored in options.
 *
 * @since 2.4
 * @return mixed
 */
function pp_get_fb_app_id()
{
	$app_id = BB_PowerPack_Admin_Settings::get_option( 'bb_powerpack_fb_app_id' );

	return $app_id;
}

/**
 * Build the URL of Facebook SDK.
 *
 * @since 2.4
 * @return string
 */
function pp_get_fb_sdk_url()
{
	$app_id = pp_get_fb_app_id();
	
	if ( $app_id && ! empty( $app_id ) ) {
		return sprintf( 'https://connect.facebook.net/%s/sdk.js#xfbml=1&version=v2.12&appId=%s', get_locale(), $app_id );
	}

	return sprintf( 'https://connect.facebook.net/%s/sdk.js#xfbml=1&version=v2.12', get_locale() );
}

function pp_get_fb_app_settings_url()
{
	$app_id = pp_get_fb_app_id();

	if ( $app_id ) {
		return sprintf( 'https://developers.facebook.com/apps/%d/settings/', $app_id );
	} else {
		return 'https://developers.facebook.com/apps/';
	}
}

function pp_get_fb_module_desc()
{
	$app_id = pp_get_fb_app_id();

	if ( ! $app_id ) {
		// translators: %s: Setting Page link
		return sprintf( __( 'You can set your Facebook App ID in the <a href="%s" target="_blank">Integrations Settings</a>', 'bb-powerpack' ), BB_PowerPack_Admin_Settings::get_form_action() );
	} else {
		// translators: %1$s: app_id, %2$s: Setting Page link.
		return sprintf( __( 'You are connected to Facebook App %1$s, <a href="%2$s" target="_blank">Change App</a>', 'bb-powerpack' ), $app_id, BB_PowerPack_Admin_Settings::get_form_action() );
	}
}
function pp_get_google_api_key() {
	return BB_PowerPack_Admin_Settings::get_option( 'bb_powerpack_google_api_key' );
}

function pp_get_google_api_url() {
	$key = pp_get_google_api_key();
	if ( ! empty( $key ) ) {
		return "https://maps.googleapis.com/maps/api/js?key={$key}";
	}
	
	return false;
}
function pp_clear_enabled_templates()
{
	BB_PowerPack_Admin_Settings::update_option( 'bb_powerpack_page_templates', array('disabled') );
	BB_PowerPack_Admin_Settings::update_option( 'bb_powerpack_templates', array('disabled') );
	BB_PowerPack_Admin_Settings::delete_option( 'bb_powerpack_row_templates_type' );
	BB_PowerPack_Admin_Settings::delete_option( 'bb_powerpack_row_templates_all' );
	BB_PowerPack_Admin_Settings::delete_option( 'bb_powerpack_override_ms' );
}

function pp_get_image_alt( $img_id = false, $default = '' ) {
	if ( ! $img_id || ! absint( $img_id ) ) {
		return;
	}
	if ( ! class_exists( 'FLBuilderPhoto' ) ) {
		return;
	}
	
	$img_id = absint( $img_id );
	$attachment_data = FLBuilderPhoto::get_attachment_data( $img_id );
	$image_alt = ( ! empty( $default ) ) ? $default : '';
	
	if ( is_object( $attachment_data ) ) {
		$image_alt = $attachment_data->alt;
		if ( empty( $image_alt ) ) {
			$image_alt = $attachment_data->caption;
			if ( empty( $image_alt ) ) {
				$image_alt = $attachment_data->title;
			}
		}
	}

	return $image_alt;
}

function pp_gradient_angle_to_direction( $angle = 45 ) {
	$direction = 'top_right_diagonal';
	
	// Top to Bottom.
	if ( 180 == $angle ) {
		$direction = 'bottom';
	}
	// Left to Right.
	if ( 90 == $angle ) {
		$direction = 'right';
	}
	// Bottom Left to Top Right.
	if ( 45 == $angle ) {
		$direction = 'top_right_diagonal';
	}
	// Bottom Right to Top Left.
	if ( 315 == $angle ) {
		$direction = 'top_left_diagonal';
	}
	// Top Left to Bottom Right.
	if ( 135 == $angle ) {
		$direction = 'bottom_right_diagonal';
	}
	// Top Right to Bottom Left.
	if ( 225 == $angle ) {
		$direction = 'bottom_left_diagonal';
	}

	return $direction;
}

function pp_image_effect_fields( $hover = false ) {
	$suffix = $hover ? '_hover' : '';

	return array(
		'image_effect_opacity'.$suffix		=> array(
			'type'						=> 'unit',
			'label'						=> __('Opacity', 'bb-powerpack'),
			'property'					=> 'opacity',
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 1,
				'step'						=> 0.1
			),
		),
		'image_effect_brightness'.$suffix	=> array(
			'type'						=> 'unit',
			'label'						=> __('Brightness', 'bb-powerpack'),
			'property'					=> 'brightness',
			'units'						=> array('%'),
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 200,
				'step'						=> 1
			),
		),
		'image_effect_contrast'.$suffix		=> array(
			'type'						=> 'unit',
			'label'						=> __('Contrast', 'bb-powerpack'),
			'property'					=> 'contrast',
			'units'						=> array('%'),
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 200,
				'step'						=> 1
			),
		),
		'image_effect_saturate'.$suffix		=> array(
			'type'						=> 'unit',
			'label'						=> __('Saturate', 'bb-powerpack'),
			'property'					=> 'saturate',
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 1,
				'step'						=> 0.1
			),
		),
		'image_effect_hue_rotate'.$suffix	=> array(
			'type'						=> 'unit',
			'label'						=> __('Hue Rotate', 'bb-powerpack'),
			'property'					=> 'hue-rotate',
			'units'						=> array('deg'),
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 360,
				'step'						=> 1
			),
		),
		'image_effect_grayscale'.$suffix	=> array(
			'type'						=> 'unit',
			'label'						=> __('Grayscale', 'bb-powerpack'),
			'property'					=> 'grayscale',
			'units'						=> array( '%' ),
			'slider'					=> true,
		),
		'image_effect_blur'.$suffix			=> array(
			'type'						=> 'unit',
			'label'						=> __('Blur', 'bb-powerpack'),
			'property'					=> 'blur',
			'units'						=> array( 'px' ),
			'slider'					=> array(
				'min'						=> 1,
				'max'						=> 30,
				'step'						=> 1
			),
		),
		'image_effect_sepia'.$suffix		=> array(
			'type'						=> 'unit',
			'label'						=> __('Sepia', 'bb-powerpack'),
			'property'					=> 'sepia',
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 1,
				'step'						=> 0.1
			),
		),
		'image_effect_invert'.$suffix		=> array(
			'type'						=> 'unit',
			'label'						=> __('Invert', 'bb-powerpack'),
			'property'					=> 'invert',
			'units'						=> array('%'),
			'slider'					=> array(
				'min'						=> 0,
				'max'						=> 100,
				'step'						=> 1
			),
		),
	);
}

function pp_image_effect_render_style( $settings, $selector, $is_hover = false ) {
    $fields 		= pp_image_effect_fields( $is_hover );
	
	$css 			= "\n $selector {";
	$css			.= "\n\t cursor: pointer;\n";

	$webkit_props = array();
	$filter_props = array();

	foreach ( $fields as $name => $field ) {
        $unit = isset( $field['units'] ) ? $field['units'][0] : '';
        if ( isset( $settings->{$name} ) && '' != $settings->{$name} ) {
			$webkit_props[] = $field['property']."(" . $settings->{$name} . $unit .")";
			$filter_props[] = $field['property']."(" . $settings->{$name} . $unit .")";
        }
    }

	if ( ! empty( $webkit_props ) ) {
		$css .= "\n\t" . '-webkit-filter: ' . implode( ' ', $webkit_props ) . ';';
	}
	if ( ! empty( $filter_props ) ) {
		$css .= "\n\t" . 'filter: ' . implode( ' ', $filter_props ) . ';';
	}
    $css .= "\n" . '}';

    return $css;
}