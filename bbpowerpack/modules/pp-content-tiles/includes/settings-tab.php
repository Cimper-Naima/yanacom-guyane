<?php

FLBuilderModel::default_settings($settings, array(
	'post_type' 			=> 'post',
	'order_by'  			=> 'date',
	'order'     			=> 'DESC',
	'offset'    			=> 0,
	'no_results_message'	=> __('No result found.', 'bb-powerpack'),
	'users'     			=> '',
	'show_author'			=> '1',
	'show_date'				=> '1',
	'date_format'			=> 'default',
	'show_post_taxonomies'	=> '1',
	'post_taxonomies'		=> 'category',
	'meta_separator'		=> ' / ',
	'title_margin'			=> array(
		'top'					=> '0',
		'bottom'				=> '0'
	)
));

$settings = apply_filters( 'pp_content_tiles_settings', $settings );
do_action( 'pp_content_tiles_settings_before_form', $settings ); // e.g Add custom FLBuilder::render_settings_field()

?>
<div id="fl-builder-settings-section-image" class="fl-builder-settings-section">
	<h3 class="fl-builder-settings-title"><?php esc_html_e('Image', 'bb-powerpack'); ?></h3>
	<table class="fl-form-table">
	<?php
	// Image size
	FLBuilder::render_settings_field('image_size_large_tile', array(
		'type'          => 'photo-sizes',
		'label'         => __('Large Tile Image Size', 'bb-powerpack'),
		'default'		=> 'large'
	), $settings);

	FLBuilder::render_settings_field('image_size_medium_tile', array(
		'type'          => 'photo-sizes',
		'label'         => __('Medium Tile Image Size', 'bb-powerpack'),
		'default'		=> 'large'
	), $settings);

	FLBuilder::render_settings_field('image_size_small_tile', array(
		'type'          => 'photo-sizes',
		'label'         => __('Small Tile Image Size', 'bb-powerpack'),
		'default'		=> 'medium'
	), $settings);

	FLBuilder::render_settings_field( 'fallback_image', array(
		'type'		=> 'select',
		'label'		=> __('Fallback Image', 'bb-powerpack'),
		'default'	=> 'placeholder',
		'options'	=> array(
			'none'			=> __('None', 'bb-powerpack'),
			'placeholder'	=> __('Placeholder', 'bb-powerpack'),
			'custom'		=> __('Custom', 'bb-powerpack')
		),
		'toggle'	=> array(
			'custom'	=> array(
				'fields'	=> array('fallback_image_custom')
			)
		),
		'help'	=> __('If post does not have any image set, you can use this option to set placeholder or any custom image.', 'bb-powerpack')
	) );
	FLBuilder::render_settings_field( 'fallback_image_custom', array(
		'type'		=> 'photo',
		'label'		=> __('Fallback Image Custom', 'bb-powerpack')
	) );
	?>
	</table>
</div>
<div id="fl-builder-settings-section-meta" class="fl-builder-settings-section">
	<h3 class="fl-builder-settings-title"><?php esc_html_e('Meta', 'bb-powerpack'); ?></h3>
	<table class="fl-form-table">
	<?php

	// Show Author
	FLBuilder::render_settings_field('show_author', array(
		'type'          => 'pp-switch',
		'label'         => __('Author', 'bb-powerpack'),
		'default'       => '1',
		'options'       => array(
			'1'             => __('Yes', 'bb-powerpack'),
			'0'             => __('No', 'bb-powerpack')
		)
	), $settings);

	// Show Date
	FLBuilder::render_settings_field('show_date', array(
		'type'          => 'pp-switch',
		'label'         => __('Date', 'bb-powerpack'),
		'default'       => '1',
		'options'       => array(
			'1'             => __('Yes', 'bb-powerpack'),
			'0'             => __('No', 'bb-powerpack')
		),
		'toggle'        => array(
			'1'             => array(
				'fields'        => array('date_format')
			)
		)
	), $settings);

	// Date format
	FLBuilder::render_settings_field('date_format', array(
		'type'          => 'select',
		'label'         => __('Date Format', 'bb-powerpack'),
		'default'       => 'default',
		'options'       => array(
			'default'		=> __('Default', 'bb-powerpack'),
			'M j, Y'        => date('M j, Y'),
			'F j, Y'        => date('F j, Y'),
			'm/d/Y'         => date('m/d/Y'),
			'm-d-Y'         => date('m-d-Y'),
			'd M Y'         => date('d M Y'),
			'd F Y'         => date('d F Y'),
			'Y-m-d'         => date('Y-m-d'),
			'Y/m/d'         => date('Y/m/d'),
		)
	), $settings);

	// Show taxonomy
	FLBuilder::render_settings_field('show_post_taxonomies', array(
		'type'          => 'pp-switch',
		'label'         => __('Show Taxonomy', 'bb-powerpack'),
		'default'       => 'show',
		'options'       => array(
			'1'           => __('Yes', 'bb-powerpack'),
			'0'           => __('No', 'bb-powerpack')
		),
		'toggle'        => array(
			'1'           => array(
				'fields'        => array('post_taxonomies')
			)
		)
	), $settings);

	// Show taxonomy
	FLBuilder::render_settings_field('post_taxonomies', array(
		'type'          => 'select',
		'label'         => __('Select Taxonomy', 'bb-powerpack'),
		'default'       => 'none',
		'options'       => array(
			'none'          => __('None', 'bb-powerpack')
		)
	), $settings);

	// Separators
	FLBuilder::render_settings_field('meta_separator', array(
		'type'          => 'select',
		'label'         => __('Meta Separator', 'bb-powerpack'),
		'default'       => ' / ',
		'options'       => array(
			' / '          	=> ' / ',
			' | '			=> ' | ',
			' - '			=> ' - '
		)
	), $settings);

	?>
	</table>
</div>

<?php
do_action( 'pp_content_tiles_settings_after_form', $settings ); // e.g Add custom FLBuilder::render_settings_field()
?>

<script type="text/javascript">
	;(function($) {
		$('.fl-builder-pp-content-tiles-settings select[name="post_type"]').on('change', function() {
			var post_type_slug 		= $(this).val();
			var post_taxonomies 	= $('.fl-builder-pp-content-tiles-settings select[name="post_taxonomies"]');
			var selected_taxonomy 	= '<?php echo $settings->post_taxonomies; ?>';
			$.ajax({
				type: 'post',
				data: {action: 'ct_get_post_tax', post_type_slug: post_type_slug},
				url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				success: function(res) {
					if ( res !== 'undefined' || res !== '' ) {
						post_taxonomies.html(res);
						post_taxonomies.find('option[value="'+selected_taxonomy+'"]').attr('selected', 'selected');
					}
				}
			});
		});
	})(jQuery);
</script>