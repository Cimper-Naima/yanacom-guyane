<?php

/**
 * Post Title
 */
FLPageData::add_post_property( 'title', array(
	'label'       => __( 'Post Title', 'fl-theme-builder' ),
	'group'       => 'posts',
	'type'        => 'string',
	'getter'      => 'get_the_title',
	'placeholder' => 'Lorem Ipsum Dolor',
) );

/**
 * Post ID
 */
FLPageData::add_post_property( 'id', array(
	'label'  => __( 'Post ID', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_id',
) );

/**
 * Post Excerpt
 */
FLPageData::add_post_property( 'excerpt', array(
	'label'       => __( 'Post Excerpt', 'fl-theme-builder' ),
	'group'       => 'posts',
	'type'        => 'string',
	'getter'      => 'FLPageDataPost::get_excerpt',
	'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
) );

FLPageData::add_post_property_settings_fields( 'excerpt', array(
	'length' => array(
		'type'        => 'text',
		'label'       => __( 'Length', 'fl-theme-builder' ),
		'default'     => '55',
		'size'        => '5',
		'description' => __( 'Words', 'fl-theme-builder' ),
		'placeholder' => '55',
	),
	'more'   => array(
		'type'        => 'text',
		'label'       => __( 'More Text', 'fl-theme-builder' ),
		'placeholder' => '...',
	),
) );

/**
 * Post Content
 */
FLPageData::add_post_property( 'content', array(
	'label'       => __( 'Post Content', 'fl-theme-builder' ),
	'group'       => 'posts',
	'type'        => 'string',
	'getter'      => 'FLPageDataPost::get_content',
	'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tempor arcu nisl. Sed ac tempus nulla.',
) );

/**
 * Post Link
 */
FLPageData::add_post_property( 'link', array(
	'label'  => __( 'Post Link', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataPost::get_link',
) );

FLPageData::add_post_property_settings_fields( 'link', array(
	'text'        => array(
		'type'    => 'select',
		'label'   => __( 'Link Text', 'fl-theme-builder' ),
		'default' => 'title',
		'options' => array(
			'title'  => __( 'Post Title', 'fl-theme-builder' ),
			'custom' => __( 'Custom', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'custom' => array(
				'fields' => array( 'custom_text' ),
			),
		),
	),
	'custom_text' => array(
		'type'    => 'text',
		'label'   => __( 'Custom Text', 'fl-theme-builder' ),
		'default' => __( 'Read More...', 'fl-theme-builder' ),
	),
) );

/**
 * Post URL
 */
FLPageData::add_post_property( 'url', array(
	'label'  => __( 'Post URL', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => array( 'url' ),
	'getter' => 'get_permalink',
) );

/**
 * Post ID
 */
FLPageData::add_post_property( 'slug', array(
	'label'  => __( 'Post Slug', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_slug',
) );

/**
 * Post Date
 */
FLPageData::add_post_property( 'date', array(
	'label'  => __( 'Post Date', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_date',
) );

FLPageData::add_post_property_settings_fields( 'date', array(
	'format' => array(
		'type'    => 'select',
		'label'   => __( 'Date Format', 'fl-theme-builder' ),
		'default' => '',
		'options' => array(
			''       => __( 'Default', 'fl-theme-builder' ),
			'M j, Y' => date( 'M j, Y' ),
			'F j, Y' => date( 'F j, Y' ),
			'm/d/Y'  => date( 'm/d/Y' ),
			'm-d-Y'  => date( 'm-d-Y' ),
			'd M Y'  => date( 'd M Y' ),
			'd F Y'  => date( 'd F Y' ),
			'Y-m-d'  => date( 'Y-m-d' ),
			'Y/m/d'  => date( 'Y/m/d' ),
		),
	),
) );

/**
 * Post Modified Date
 */
FLPageData::add_post_property( 'modified_date', array(
	'label'  => __( 'Post Modified Date', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_modified_date',
) );

FLPageData::add_post_property_settings_fields( 'modified_date', array(
	'format' => array(
		'type'    => 'select',
		'label'   => __( 'Modified Date Format', 'fl-theme-builder' ),
		'default' => '',
		'options' => array(
			''       => __( 'Default', 'fl-theme-builder' ),
			'M j, Y' => date( 'M j, Y' ),
			'F j, Y' => date( 'F j, Y' ),
			'm/d/Y'  => date( 'm/d/Y' ),
			'm-d-Y'  => date( 'm-d-Y' ),
			'd M Y'  => date( 'd M Y' ),
			'd F Y'  => date( 'd F Y' ),
			'Y-m-d'  => date( 'Y-m-d' ),
			'Y/m/d'  => date( 'Y/m/d' ),
			'human'  => __( '3 days ago', 'fl-theme-builder' ),
		),
	),
) );

/**
 * Post Featured Image
 */
FLPageData::add_post_property( 'featured_image', array(
	'label'  => __( 'Post Featured Image', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_featured_image',
) );

FLPageData::add_post_property_settings_fields( 'featured_image', array(
	'size'    => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
	'display' => array(
		'type'    => 'select',
		'label'   => __( 'Display', 'fl-theme-builder' ),
		'default' => 'tag',
		'options' => array(
			'tag'         => __( 'Image Tag', 'fl-theme-builder' ),
			'url'         => __( 'URL', 'fl-theme-builder' ),
			'title'       => __( 'Title', 'fl-theme-builder' ),
			'caption'     => __( 'Caption', 'fl-theme-builder' ),
			'description' => __( 'Description', 'fl-theme-builder' ),
			'alt'         => __( 'Alt Text', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'tag' => array(
				'fields' => array( 'linked', 'align', 'size' ),
			),
			'url' => array(
				'fields' => array( 'size' ),
			),
		),
	),
	'align'   => array(
		'type'    => 'select',
		'label'   => __( 'Alignment', 'fl-theme-builder' ),
		'default' => 'default',
		'options' => array(
			'default' => __( 'Default', 'fl-theme-builder' ),
			'left'    => __( 'Left', 'fl-theme-builder' ),
			'center'  => __( 'Center', 'fl-theme-builder' ),
			'right'   => __( 'Right', 'fl-theme-builder' ),
		),
	),
	'linked'  => array(
		'type'    => 'select',
		'label'   => __( 'Linked', 'fl-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'fl-theme-builder' ),
			'no'  => __( 'No', 'fl-theme-builder' ),
		),
		'help'    => __( 'Link the image to the post.', 'fl-theme-builder' ),
	),
) );

/**
 * Post Featured Image URL
 */
FLPageData::add_post_property( 'featured_image_url', array(
	'label'  => __( 'Post Featured Image', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'photo',
	'getter' => 'FLPageDataPost::get_featured_image_url',
) );

FLPageData::add_post_property_settings_fields( 'featured_image_url', array(
	'size'        => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
	'default_img' => array(
		'type'  => 'photo',
		'label' => __( 'Default Image', 'fl-theme-builder' ),
	),
) );

/**
 * Post Attached Images
 */
FLPageData::add_post_property( 'attached_images', array(
	'label'  => __( 'Post Attached Images', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataPost::get_attached_images',
) );

/**
 * Post Terms List
 */
FLPageData::add_post_property( 'terms_list', array(
	'label'  => __( 'Post Terms List', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataPost::get_terms_list',
) );

FLPageData::add_post_property_settings_fields( 'terms_list', array(
	'taxonomy'  => array(
		'type'    => 'select',
		'label'   => __( 'Taxonomy', 'fl-theme-builder' ),
		'default' => 'category',
		'options' => FLPageDataPost::get_taxonomy_options(),
	),
	'html_list' => array(
		'type'    => 'select',
		'label'   => __( 'Layout', 'fl-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'no'  => __( 'Use Separator', 'fl-theme-builder' ),
			'ol'  => __( 'Ordered List', 'fl-theme-builder' ),
			'ul'  => __( 'Unordered List', 'fl-theme-builder' ),
			'div' => __( 'Div / Spans', 'fl-theme-builder' ),
		),
		'toggle'  => array(
			'no' => array(
				'fields' => array( 'separator' ),
			),
		),
	),
	'separator' => array(
		'type'    => 'text',
		'label'   => __( 'Separator', 'fl-theme-builder' ),
		'default' => __( ', ', 'fl-theme-builder' ),
	),
	'limit'     => array(
		'type'        => 'text',
		'placeholder' => '3',
		'label'       => __( 'Limit', 'fl-theme-buider' ),
		'default'     => '',
		'help'        => __( 'Limit number of terms returned.', 'fl-theme-builder' ),
	),
	'linked'    => array(
		'type'    => 'select',
		'label'   => __( 'Linked', 'fl-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'fl-theme-builder' ),
			'no'  => __( 'No', 'fl-theme-builder' ),
		),
		'help'    => __( 'Link terms to their archive page.', 'fl-theme-builder' ),
	),
) );

/**
 * Comments Number
 */
FLPageData::add_post_property( 'comments_number', array(
	'label'  => __( 'Comments Number', 'fl-theme-builder' ),
	'group'  => 'comments',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_comments_number',
) );

FLPageData::add_post_property_settings_fields( 'comments_number', array(
	'link'      => array(
		'type'    => 'select',
		'label'   => __( 'Link', 'fl-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'fl-theme-builder' ),
			'no'  => __( 'No', 'fl-theme-builder' ),
		),
		'help'    => __( 'Link the comments text to the comments section for this post.', 'fl-theme-builder' ),
	),
	'none_text' => array(
		'type'    => 'text',
		'label'   => __( 'No Comments Text', 'fl-theme-builder' ),
		'default' => __( 'No Comments', 'fl-theme-builder' ),
	),
	'one_text'  => array(
		'type'    => 'text',
		'label'   => __( 'One Comment Text', 'fl-theme-builder' ),
		'default' => __( '1 Comment', 'fl-theme-builder' ),
	),
	'more_text' => array(
		'type'    => 'text',
		'label'   => __( 'Comments Text', 'fl-theme-builder' ),
		'default' => __( '% Comments', 'fl-theme-builder' ),
	),
) );

/**
 * Comments URL
 */
FLPageData::add_post_property( 'comments_url', array(
	'label'  => __( 'Comments URL', 'fl-theme-builder' ),
	'group'  => 'comments',
	'type'   => array( 'url' ),
	'getter' => 'FLPageDataPost::get_comments_url',
) );

/**
 * Author Name
 */
FLPageData::add_post_property( 'author_name', array(
	'label'  => __( 'Author Name', 'fl-theme-builder' ),
	'group'  => 'author',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_author_name',
) );

FLPageData::add_post_property_settings_fields( 'author_name', array(
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
		'help'    => __( 'Link to the archive or website for this author.', 'fl-theme-builder' ),
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
 * Author Bio
 */
FLPageData::add_post_property( 'author_bio', array(
	'label'  => __( 'Author Bio', 'fl-theme-builder' ),
	'group'  => 'author',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_author_bio',
) );

/**
 * Author URL
 */
FLPageData::add_post_property( 'author_url', array(
	'label'  => __( 'Author URL', 'fl-theme-builder' ),
	'group'  => 'author',
	'type'   => array( 'url' ),
	'getter' => 'FLPageDataPost::get_author_url',
) );

FLPageData::add_post_property_settings_fields( 'author_url', array(
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
 * Author Picture
 */
FLPageData::add_post_property( 'author_profile_picture', array(
	'label'  => __( 'Author Picture', 'fl-theme-builder' ),
	'group'  => 'author',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataPost::get_author_profile_picture',
) );

FLPageData::add_post_property_settings_fields( 'author_profile_picture', array(
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
		'help'    => __( 'Link to the archive or website for this author.', 'fl-theme-builder' ),
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
 * Author Picture URL
 */
FLPageData::add_post_property( 'author_profile_picture_url', array(
	'label'  => __( 'Author Picture', 'fl-theme-builder' ),
	'group'  => 'author',
	'type'   => array( 'photo' ),
	'getter' => 'FLPageDataPost::get_author_profile_picture_url',
) );

FLPageData::add_post_property_settings_fields( 'author_profile_picture_url', array(
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
 * Author Meta
 */
FLPageData::add_post_property( 'author_meta', array(
	'label'  => __( 'Author Meta', 'fl-theme-builder' ),
	'group'  => 'author',
	'type'   => 'all',
	'getter' => 'FLPageDataPost::get_author_meta',
) );

FLPageData::add_post_property_settings_fields( 'author_meta', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'fl-theme-builder' ),
	),
) );

/**
 * Custom Field
 */
FLPageData::add_post_property( 'custom_field', array(
	'label'  => __( 'Post Custom Field', 'fl-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'all',
	'getter' => 'FLPageDataPost::get_custom_field',
) );

FLPageData::add_post_property_settings_fields( 'custom_field', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'fl-theme-builder' ),
	),
) );
