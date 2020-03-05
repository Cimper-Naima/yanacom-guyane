<?php
// Header Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'header_padding',
	'selector' 		=> ".fl-node-$id .pp-table-content thead tr th,
						.fl-node-$id .pp-table-content.tablesaw-sortable th.tablesaw-sortable-head,
						.fl-node-$id .pp-table-content.tablesaw-sortable tr:first-child th.tablesaw-sortable-head",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'header_padding_top',
		'padding-right' 	=> 'header_padding_right',
		'padding-bottom' 	=> 'header_padding_bottom',
		'padding-left' 		=> 'header_padding_left',
	),
) );
// Rows Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'rows_padding',
	'selector' 		=> ".fl-node-$id .pp-table-content tbody tr td",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'rows_padding_top',
		'padding-right' 	=> 'rows_padding_right',
		'padding-bottom' 	=> 'rows_padding_bottom',
		'padding-left' 		=> 'rows_padding_left',
	),
) );
// Header Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'header_typography',
	'selector' 		=> ".fl-node-$id .pp-table-content thead tr th,
						.fl-node-$id .pp-table-content.tablesaw-sortable th.tablesaw-sortable-head,
						.fl-node-$id .pp-table-content.tablesaw-sortable tr:first-child th.tablesaw-sortable-head",
) );
// Row Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'row_typography',
	'selector' 		=> ".fl-node-$id .pp-table-content tbody tr td",
) );
?>
.fl-node-<?php echo $id; ?> .tablesaw-bar .tablesaw-advance a.tablesaw-nav-btn {
	float: none !important;
}

.fl-node-<?php echo $id; ?> .pp-table-content thead,
.fl-node-<?php echo $id; ?> .pp-table-content.tablesaw thead {
    background: <?php echo pp_get_color_value($settings->header_background); ?>;
	border: 0;
}

.fl-node-<?php echo $id; ?> .pp-table-content thead tr th,
.fl-node-<?php echo $id; ?> .pp-table-content.tablesaw-sortable th.tablesaw-sortable-head,
.fl-node-<?php echo $id; ?> .pp-table-content.tablesaw-sortable tr:first-child th.tablesaw-sortable-head {
    color: <?php echo pp_get_color_value($settings->header_font_color); ?>;
}

.fl-node-<?php echo $id; ?> .pp-table-content thead tr th {
	vertical-align: <?php echo $settings->header_vertical_alignment; ?>;
}

<?php if( $settings->sortable == 'data-tablesaw-sortable data-tablesaw-sortable-switch' ) { ?>
.fl-node-<?php echo $id; ?> .pp-table-content.tablesaw-sortable th.tablesaw-sortable-head button {
	<?php if( $settings->header_padding_right >= 0 ) { ?>
		padding-right: <?php echo $settings->header_padding_right; ?>px;
	<?php } ?>
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-table-content tbody {
	border-left: 1px solid <?php echo ( $settings->rows_border ) ? '#' . $settings->rows_border : 'transparent'; ?>;
	border-right: 1px solid <?php echo ( $settings->rows_border ) ? '#' . $settings->rows_border : 'transparent'; ?>;
	border-top: 1px solid <?php echo ( $settings->rows_border ) ? '#' . $settings->rows_border : 'transparent'; ?>;
	<?php if( $settings->cells_border == 'horizontal' || $settings->cells_border == 'vertical' ) { ?>
		border-left: 0;
		border-right: 0;
	<?php } ?>
	<?php if( $settings->cells_border == 'vertical' ) { ?>
		border-top: 0;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr {
	background: <?php echo pp_get_color_value($settings->rows_background); ?>;
	border-bottom: 1px solid <?php echo ( $settings->rows_border ) ? '#' . $settings->rows_border : 'transparent'; ?>;
	<?php if( $settings->cells_border == 'vertical' ) { ?>
		border-bottom: 0;
	<?php } ?>
}

<?php if( $settings->cells_border == 'horizontal' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-table-content tbody tr:last-child {
		border-bottom: 0;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr td {
    border-left: 1px solid <?php echo ( $settings->rows_border ) ? pp_get_color_value($settings->rows_border) : 'transparent'; ?>;
	<?php if( $settings->cells_border == 'horizontal' ) { ?>
		border-left: 0;
	<?php } ?>
	vertical-align: <?php echo $settings->rows_vertical_alignment; ?>;
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr td:first-child {
	border-left: 0;
}

.fl-node-<?php echo $id; ?> .pp-table-content thead tr:first-child th {
	border-style: solid;
	border-width: 1px;
	border-color: <?php echo ( $settings->header_border ) ? pp_get_color_value($settings->header_border) : 'transparent'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr td {
    color: <?php echo pp_get_color_value($settings->rows_font_color); ?>;
}

.fl-node-<?php echo $id; ?> .tablesaw-sortable .tablesaw-sortable-head button {
	<?php if ( isset( $settings->header_typography ) && is_array( $settings->header_typography ) ) { ?>
	text-align: <?php echo $settings->header_typography['text_align']; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr:nth-child(odd) {
    <?php if( $settings->rows_odd_background ) { ?>background: #<?php echo $settings->rows_odd_background; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr:nth-child(odd) td {
    <?php if( $settings->rows_font_odd ) { ?>color: #<?php echo $settings->rows_font_odd; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr:nth-child(even) {
    <?php if( $settings->rows_even_background ) { ?>background: #<?php echo $settings->rows_even_background; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-table-content tbody tr:nth-child(even) td {
    <?php if( $settings->rows_font_even ) { ?>color: #<?php echo $settings->rows_font_even; ?>;<?php } ?>
}


@media only screen and (max-width: 639px) {
	.fl-node-<?php echo $id; ?> .pp-table-content-cell-label {
		<?php if ( isset( $settings->header_typography_responsive ) ) { ?>
			<?php if ( isset( $settings->header_typography_responsive['font_size'] ) && '' != $settings->header_typography_responsive['font_size'] ) { ?>
				font-size: <?php echo $settings->header_typography_responsive['font_size']['length']; ?><?php echo $settings->header_typography_responsive['font_size']['unit']; ?>;
			<?php } ?>
			<?php if ( isset( $settings->header_typography_responsive['text_transform'] ) ) { ?>
			text-transform: <?php echo $settings->header_typography_responsive['text_transform']; ?>;
			<?php } ?>
		<?php } ?>
	}
}
