<?php if ( ! $settings->match_height ) : ?>
.fl-node-<?php echo $id; ?> .pp-custom-grid-post {
    margin-bottom: <?php echo $settings->post_spacing; ?>px;
    width: <?php echo $settings->post_width; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-custom-grid-sizer {
    width: <?php echo $settings->post_width; ?>px;
}
@media screen and (max-width: <?php echo $settings->post_width + $settings->post_spacing; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-custom-grid,
	.fl-node-<?php echo $id; ?> .pp-custom-grid-post,
	.fl-node-<?php echo $id; ?> .pp-custom-grid-sizer {
		width: 100% !important;
	}
}
<?php endif; ?>
<?php if ( $settings->match_height ) : ?>
.fl-node-<?php echo $id; ?> .pp-custom-grid {
	margin-left: -<?php echo $settings->post_spacing / 2; ?>px;
	margin-right: -<?php echo $settings->post_spacing / 2; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-custom-grid-column {
	padding-bottom: <?php echo $settings->post_spacing; ?>px;
	padding-left: <?php echo $settings->post_spacing / 2; ?>px;
	padding-right: <?php echo $settings->post_spacing / 2; ?>px;
	width: <?php echo 100 / $settings->post_columns; ?>%;
}
.fl-node-<?php echo $id; ?> .pp-custom-grid-column:nth-child(<?php echo $settings->post_columns; ?>n + 1) {
	clear: both;
}
@media screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-custom-grid-column {
		width: <?php echo 100 / $settings->post_columns_medium; ?>%;
	}
	.fl-node-<?php echo $id; ?> .pp-custom-grid-column:nth-child(<?php echo $settings->post_columns; ?>n + 1) {
		clear: none;
	}
	.fl-node-<?php echo $id; ?> .pp-custom-grid-column:nth-child(<?php echo $settings->post_columns_medium; ?>n + 1) {
		clear: both;
	}
}
@media screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-custom-grid-column {
		width: <?php echo 100 / $settings->post_columns_responsive; ?>%;
	}
	.fl-node-<?php echo $id; ?> .pp-custom-grid-column:nth-child(<?php echo $settings->post_columns_medium; ?>n + 1) {
		clear: none;
	}
	.fl-node-<?php echo $id; ?> .pp-custom-grid-column:nth-child(<?php echo $settings->post_columns_responsive; ?>n + 1) {
		clear: both;
	}
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .pp-custom-grid-post {

	<?php if ( isset( $settings->bg_color ) && ! empty( $settings->bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->bg_color ); ?>;
	<?php } ?>

	<?php if( $settings->post_align != 'default' ) : ?>
	text-align: <?php echo $settings->post_align; ?>;
	<?php endif; ?>

}

<?php if ( 'right' == $settings->post_align ) { ?>
.fl-node-<?php echo $id; ?> .pp-custom-align-right .pp-custom-grid-separator {
	margin-right: 0;
    margin-left: auto;
}
.fl-node-<?php echo $id; ?> .pp-custom-align-center .pp-custom-grid-post-image + .pp-custom-grid-post-terms {
	right: 0;
}
<?php } ?>

<?php if ( 'center' == $settings->post_align ) { ?>
.fl-node-<?php echo $id; ?> .pp-custom-align-center .pp-custom-grid-separator {
	margin-right: auto;
    margin-left: auto;
}
.fl-node-<?php echo $id; ?> .pp-custom-align-center .pp-custom-grid-post-image + .pp-custom-grid-post-terms {
	left: 50%;
    transform: translateX(-50%);
}
<?php } ?>

<?php
	// Post - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'post_border',
		'selector' 		=> ".fl-node-$id .pp-custom-grid-post",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-custom-grid-pagination li a.page-numbers,
.fl-node-<?php echo $id; ?> .pp-custom-grid-pagination li span.page-numbers {
	<?php if ( isset( $settings->pagination_bg_color ) && ! empty( $settings->pagination_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->pagination_bg_color ); ?>;
	<?php } ?>
    <?php if ( $settings->pagination_text_color ) : ?>
        color: #<?php echo $settings->pagination_text_color; ?>;
    <?php endif; ?>
}

<?php
	// Pagination - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'pagination_border',
		'selector' 		=> ".fl-node-$id .pp-custom-grid-pagination li a.page-numbers, .fl-node-$id .pp-custom-grid-pagination li span.page-numbers",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-custom-grid-pagination li a.page-numbers:hover,
.fl-node-<?php echo $id; ?> .pp-custom-grid-pagination li span.current {
	<?php if ( isset( $settings->pagination_bg_color_h ) && ! empty( $settings->pagination_bg_color_h ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->pagination_bg_color_h ); ?>;
	<?php } ?>
    <?php if ( $settings->pagination_text_color_h ) : ?>
        color: #<?php echo $settings->pagination_text_color_h; ?>;
    <?php endif; ?>
}
