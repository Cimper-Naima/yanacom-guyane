<?php

/**
 * Advanced Custom Field String
 */
FLPageData::add_archive_property( 'acf', array(
	'label'  => __( 'ACF Archive Field', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_post_property( 'acf', array(
	'label'  => __( 'ACF Post Field', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_post_property( 'acf_author', array(
	'label'  => __( 'ACF Post Author Field', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_site_property( 'acf_user', array(
	'label'  => __( 'ACF User Field', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_site_property( 'acf_option', array(
	'label'  => __( 'ACF Option Field', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

$form = array(
	'type'            => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'             => __( 'Text', 'fl-theme-builder' ),
			'textarea'         => __( 'Textarea', 'fl-theme-builder' ),
			'number'           => __( 'Number', 'fl-theme-builder' ),
			'email'            => __( 'Email', 'fl-theme-builder' ),
			'url'              => __( 'URL', 'fl-theme-builder' ),
			'password'         => __( 'Password', 'fl-theme-builder' ),
			'wysiwyg'          => __( 'WYSIWYG', 'fl-theme-builder' ),
			'oembed'           => __( 'oEmbed', 'fl-theme-builder' ),
			'image'            => __( 'Image', 'fl-theme-builder' ),
			'file'             => __( 'File', 'fl-theme-builder' ),
			'select'           => __( 'Select', 'fl-theme-builder' ),
			'checkbox'         => __( 'Checkbox', 'fl-theme-builder' ),
			'radio'            => __( 'Radio', 'fl-theme-builder' ),
			'page_link'        => __( 'Page Link', 'fl-theme-builder' ),
			'google_map'       => __( 'Google Map', 'fl-theme-builder' ),
			'date_picker'      => __( 'Date Picker', 'fl-theme-builder' ),
			'date_time_picker' => __( 'Date Time Picker', 'fl-theme-builder' ),
			'time_picker'      => __( 'Time Picker', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'image'    => array(
				'fields' => array( 'image_size' ),
			),
			'checkbox' => array(
				'fields' => array( 'checkbox_format' ),
			),
			'select'   => array(
				'fields' => array( 'select_format' ),
			),
		),
	),
	'name'            => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'image_size'      => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
	'checkbox_format' => array(
		'type'    => 'select',
		'label'   => __( 'Format', 'fl-theme-builder' ),
		'default' => 'string',
		'options' => array(
			'text' => __( 'Text', 'fl-theme-builder' ),
			'ol'   => __( 'Ordered List', 'fl-theme-builder' ),
			'ul'   => __( 'Unordered List', 'fl-theme-builder' ),
		),
	),
	'select_format'   => array(
		'type'    => 'select',
		'label'   => __( 'Format', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text' => __( 'Text', 'fl-theme-builder' ),
			'ol'   => __( 'Ordered List', 'fl-theme-builder' ),
			'ul'   => __( 'Unordered List', 'fl-theme-builder' ),
		),
	),
);

FLPageData::add_archive_property_settings_fields( 'acf', $form );
FLPageData::add_post_property_settings_fields( 'acf', $form );
FLPageData::add_post_property_settings_fields( 'acf_author', $form );
FLPageData::add_site_property_settings_fields( 'acf_user', $form );
FLPageData::add_site_property_settings_fields( 'acf_option', $form );

/**
 * Advanced Custom Field URL
 */
FLPageData::add_archive_property( 'acf_url', array(
	'label'  => __( 'ACF Archive Field - URL', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_post_property( 'acf_url', array(
	'label'  => __( 'ACF Post Field - URL', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_post_property( 'acf_author_url', array(
	'label'  => __( 'ACF Post Author Field - URL', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_site_property( 'acf_user_url', array(
	'label'  => __( 'ACF User Field - URL', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_site_property( 'acf_option_url', array(
	'label'  => __( 'ACF Option Field - URL', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

$form = array(
	'type'       => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'      => __( 'Text', 'fl-theme-builder' ),
			'url'       => __( 'URL', 'fl-theme-builder' ),
			'image'     => __( 'Image', 'fl-theme-builder' ),
			'file'      => __( 'File', 'fl-theme-builder' ),
			'select'    => __( 'Select', 'fl-theme-builder' ),
			'radio'     => __( 'Radio', 'fl-theme-builder' ),
			'page_link' => __( 'Page Link', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'image' => array(
				'fields' => array( 'image_size' ),
			),
		),
	),
	'name'       => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'image_size' => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_url', $form );
FLPageData::add_post_property_settings_fields( 'acf_url', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_url', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_url', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_url', $form );

/**
 * Advanced Custom Field Photo
 */
FLPageData::add_archive_property( 'acf_photo', array(
	'label'  => __( 'ACF Archive Field - Photo', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_post_property( 'acf_photo', array(
	'label'  => __( 'ACF Post Field - Photo', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_post_property( 'acf_author_photo', array(
	'label'  => __( 'ACF Post Author Field - Photo', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_site_property( 'acf_user_photo', array(
	'label'  => __( 'ACF User Field - Photo', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_site_property( 'acf_option_photo', array(
	'label'  => __( 'ACF Option Field - Photo', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

$form = array(
	'type'           => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'   => __( 'Text', 'fl-theme-builder' ),
			'url'    => __( 'URL', 'fl-theme-builder' ),
			'image'  => __( 'Image', 'fl-theme-builder' ),
			'select' => __( 'Select', 'fl-theme-builder' ),
			'radio'  => __( 'Radio', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'image' => array(
				'fields' => array( 'image_size', 'image_fallback' ),
			),
		),
	),
	'name'           => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'image_fallback' => array(
		'type'        => 'photo',
		'label'       => __( 'Fallback Image', 'fl-theme-builder' ),
		'show_remove' => true,
	),
	'image_size'     => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_photo', $form );
FLPageData::add_post_property_settings_fields( 'acf_photo', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_photo', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_photo', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_photo', $form );

/**
 * Advanced Custom Field Multiple Photos
 */
FLPageData::add_archive_property( 'acf_gallery', array(
	'label'  => __( 'ACF Archive Field - Gallery', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_post_property( 'acf_gallery', array(
	'label'  => __( 'ACF Post Field - Gallery', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_post_property( 'acf_author_gallery', array(
	'label'  => __( 'ACF Post Author Field - Gallery', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_site_property( 'acf_user_gallery', array(
	'label'  => __( 'ACF User Field - Gallery', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_site_property( 'acf_option_gallery', array(
	'label'  => __( 'ACF Option Field - Gallery', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

$form = array(
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Gallery Field Name', 'fl-theme-builder' ),
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_gallery', $form );
FLPageData::add_post_property_settings_fields( 'acf_gallery', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_gallery', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_gallery', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_gallery', $form );

/**
 * Advanced Custom Field Color
 */
FLPageData::add_archive_property( 'acf_color', array(
	'label'  => __( 'ACF Archive Field - Color', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_post_property( 'acf_color', array(
	'label'  => __( 'ACF Post Field - Color', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_post_property( 'acf_author_color', array(
	'label'  => __( 'ACF Post Author Field - Color', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_site_property( 'acf_user_color', array(
	'label'  => __( 'ACF User Field - Color', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_site_property( 'acf_option_color', array(
	'label'  => __( 'ACF Option Field - Color', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

$form = array(
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_color', $form );
FLPageData::add_post_property_settings_fields( 'acf_color', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_color', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_color', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_color', $form );

/**
 * Advanced Custom Field Relational
 */
FLPageData::add_post_property( 'acf_relational', array(
	'label'  => __( 'ACF Relational', 'fl-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::relational_field',
) );

$form = array(
	'type'         => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'user',
		'options' => array(
			'user'        => __( 'User', 'fl-theme-builder' ),
			'post_object' => __( 'Post Object', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'user' => array(
				'fields' => array( 'display_type', 'link', 'link_type' ),
			),
		),
	),
	'name'         => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'display_type' => array(
		'type'    => 'select',
		'label'   => __( 'Display Type', 'fl-theme-builder' ),
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
	'link'         => array(
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
		'help'    => __( 'Link to the archive or website for this author.', 'fl-theme-builder' ),
	),
	'link_type'    => array(
		'type'    => 'select',
		'label'   => __( 'Link Type', 'fl-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'fl-theme-builder' ),
			'website' => __( 'Website', 'fl-theme-builder' ),
		),
	),
);

FLPageData::add_post_property_settings_fields( 'acf_relational', $form );
