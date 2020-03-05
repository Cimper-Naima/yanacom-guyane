<?php

/**
 * Site Title
 */
FLPageData::add_site_property( 'title', array(
	'label'  => __( 'Site Title', 'fl-theme-builder' ),
	'group'  => 'site',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_title',
) );

/**
 * Site Tagline
 */
FLPageData::add_site_property( 'tagline', array(
	'label'  => __( 'Site Tagline', 'fl-theme-builder' ),
	'group'  => 'site',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_description',
) );

/**
 * Site URL
 */
FLPageData::add_site_property( 'url', array(
	'label'  => __( 'Site URL', 'fl-theme-builder' ),
	'group'  => 'site',
	'type'   => 'url',
	'getter' => 'FLPageDataSite::get_url',
) );

/**
 * User Name
 */
FLPageData::add_site_property( 'user_name', array(
	'label'  => __( 'User Name', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_user_name',
) );

FLPageDataSite::add_user_settings_fields( 'user_name', array(
	'type'      => array(
		'type'    => 'select',
		'label'   => __( 'Type', 'fl-theme-builder' ),
		'default' => 'display',
		'options' => array(
			'display'   => __( 'Display Name', 'fl-theme-builder' ),
			'first'     => __( 'First Name', 'fl-theme-builder' ),
			'last'      => __( 'Last Name', 'fl-theme-builder' ),
			'firstlast' => __( 'First &amp; Last Name', 'fl-theme-builder' ),
			'lastfirst' => __( 'Last, First Name', 'fl-theme-builder' ),
			'nickname'  => __( 'Nickname', 'fl-theme-builder' ),
			'username'  => __( 'Username', 'fl-theme-builder' ),
		),
	),
	'link'      => array(
		'type'    => 'select',
		'label'   => __( 'Link', 'fl-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'yes' => __( 'Yes', 'fl-theme-builder' ),
			'no'  => __( 'No', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'yes' => array(
				'fields' => array( 'link_type' ),
			),
		),
		'help'    => __( 'Link to the archive or website for this user.', 'fl-theme-builder' ),
	),
	'link_type' => array(
		'type'    => 'select',
		'label'   => __( 'Link Type', 'fl-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'fl-theme-builder' ),
			'website' => __( 'Website', 'fl-theme-builder' ),
		),
	),
) );

/**
 * User Bio
 */
FLPageData::add_site_property( 'user_bio', array(
	'label'  => __( 'User Bio', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_user_bio',
) );

FLPageDataSite::add_user_settings_fields( 'user_bio' );

/**
 * User URL
 */
FLPageData::add_site_property( 'user_url', array(
	'label'  => __( 'User URL', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => array( 'url' ),
	'getter' => 'FLPageDataSite::get_user_url',
) );

FLPageDataSite::add_user_settings_fields( 'user_url', array(
	'type' => array(
		'type'    => 'select',
		'label'   => __( 'Type', 'fl-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'fl-theme-builder' ),
			'website' => __( 'Website', 'fl-theme-builder' ),
		),
	),
) );

/**
 * User Picture
 */
FLPageData::add_site_property( 'user_profile_picture', array(
	'label'  => __( 'User Picture', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataSite::get_user_profile_picture',
) );

FLPageDataSite::add_user_settings_fields( 'user_profile_picture', array(
	'link'      => array(
		'type'    => 'select',
		'label'   => __( 'Link', 'fl-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'yes' => __( 'Yes', 'fl-theme-builder' ),
			'no'  => __( 'No', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'yes' => array(
				'fields' => array( 'link_type' ),
			),
		),
		'help'    => __( 'Link to the archive or website for this user.', 'fl-theme-builder' ),
	),
	'link_type' => array(
		'type'    => 'select',
		'label'   => __( 'Link Type', 'fl-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'fl-theme-builder' ),
			'website' => __( 'Website', 'fl-theme-builder' ),
		),
	),
	'size'      => array(
		'type'        => 'text',
		'label'       => __( 'Size', 'fl-theme-builder' ),
		'default'     => '100',
		'size'        => '5',
		'description' => 'px',
		'placeholder' => '512',
	),
) );

/**
 * User Picture URL
 */
FLPageData::add_site_property( 'user_profile_picture_url', array(
	'label'  => __( 'User Picture', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => array( 'photo' ),
	'getter' => 'FLPageDataSite::get_user_profile_picture_url',
) );

FLPageDataSite::add_user_settings_fields( 'user_profile_picture_url', array(
	'size'        => array(
		'type'        => 'text',
		'label'       => __( 'Size', 'fl-theme-builder' ),
		'default'     => '100',
		'size'        => '5',
		'description' => 'px',
		'placeholder' => '512',
	),
	'default_img' => array(
		'type'  => 'photo',
		'label' => __( 'Default Image', 'fl-theme-builder' ),
	),
) );

/**
 * User Meta
 */
FLPageData::add_site_property( 'user_meta', array(
	'label'  => __( 'User Meta', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => 'all',
	'getter' => 'FLPageDataSite::get_user_meta',
) );

FLPageDataSite::add_user_settings_fields( 'user_meta', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'fl-theme-builder' ),
	),
) );

/**
 * Is current user logged in
 * @since 1.1
 */
FLPageData::add_site_property( 'logged_in', array(
	'label'  => __( 'User Logged In', 'fl-theme-builder' ),
	'group'  => 'user',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::is_user_logged_in',
) );

FLPageDataSite::add_user_settings_fields( 'logged_in', array(
	'role' => array(
		'type'  => 'text',
		'label' => __( 'Role/Roles', 'fl-theme-builder' ),
		'help'  => __( 'Comma separated list of WordPress roles, lowercase. This connection returns true or false, best used as a conditional shortcode.', 'fl-theme-builder' ),
	),
) );

/**
 * Site year
 * @since 1.1
 */
FLPageData::add_site_property( 'year', array(
	'label'  => __( 'Current Year', 'fl-theme-builder' ),
	'group'  => 'site',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_year',
) );
FLPageData::add_site_property_settings_fields( 'year', array(
	'format' => array(
		'type'    => 'text',
		'label'   => __( 'Format', 'fl-theme-builder' ),
		'default' => 'Y',
	),
) );
