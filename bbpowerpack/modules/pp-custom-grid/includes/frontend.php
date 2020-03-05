<?php

// Get the query data.
$query = FLBuilderLoop::query($settings);

// Render the posts.
if($query->have_posts()) :

do_action( 'pp_custom_grid_module_before_posts', $settings, $query );

$paged = ( FLBuilderLoop::get_paged() > 0 ) ? ' pp-paged-scroll-to' : '';

?>
<div class="pp-custom-<?php echo $module->get_layout_slug() . $paged; ?>" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<?php

	while($query->have_posts()) {

		$query->the_post();

	    ?>
		<?php if ( $settings->match_height ) : ?>
		<div class="pp-custom-grid-column">
		<?php endif; ?>

        <div <?php $module->render_post_class(); ?> itemscope itemtype="<?php PPCustomGridModule::schema_itemtype(); ?>">
        	<?php

        	PPCustomGridModule::schema_meta();

			$preset = $settings->preset;
			$preset_key = $preset . '_preset';

        	echo do_shortcode( FLThemeBuilderFieldConnections::parse_shortcodes( stripslashes( $settings->{$preset_key}->html ) ) );

        	?>
        </div>

		<?php if ( $settings->match_height ) : ?>
		</div>
		<?php endif; ?>
        <?php
	}

	?>
	<?php if ( '0' == $settings->match_height ) : ?>
	<div class="pp-custom-grid-sizer"></div>
	<?php endif; ?>
</div>
<div class="fl-clear"></div>
<?php endif; ?>
<?php

do_action( 'pp_custom_grid_module_after_posts', $settings );

// Render the pagination.
if($settings->pagination != 'none' && $query->have_posts()) :

?>
<div class="pp-custom-grid-pagination"<?php if($settings->pagination == 'scroll') echo ' style="display:none;"'; ?>>
	<?php FLBuilderLoop::pagination($query); ?>
</div>
<?php endif; ?>
<?php

// Render the empty message.
if(!$query->have_posts()) :

?>
<div class="fl-post-grid-empty">
	<p><?php echo $settings->no_results_message; ?></p>
	<?php if ( $settings->show_search ) : ?>
	<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php

endif;

wp_reset_postdata();

?>
