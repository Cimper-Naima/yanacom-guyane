<?php
$source = isset( $settings->source ) ? $settings->source : 'manual';
?>

<div class="pp-table-wrap">
<?php
if ( 'csv_import' == $source ) {
	if ( isset( $settings->csv_import ) && ! empty( $settings->csv_import ) ) {
		$csv_import = (array) $settings->csv_import;
		if ( isset( $csv_import['filepath'] ) ) {
			$csv_filepath 	= $csv_import['filepath'];
			if ( file_exists( $csv_filepath ) ) {
				$csv_content 	= file_get_contents( $csv_filepath );
				if ( ! empty( $csv_content ) ) {
					$csv_rows 		= explode( "\n", $csv_content );
					$tableheaders 	= explode( ',', $csv_rows[0] );
					$tablerows 		= array();

					if ( isset( $settings->first_row_header ) && 'yes' === $settings->first_row_header ) {
						$i = 1;
					} else {
						$i = 0;
					}

					for ( ; $i < count( $csv_rows ); $i++ ) {
						$row 		= new stdClass();
						$row->cell 	= explode( ',', $csv_rows[ $i ] );
						$tablerows[] = $row;
					}
				}
			}
		}
	}
} else {
	$tableheaders = $settings->header;
	$tablerows = $settings->rows;
}

if ( ! empty( $tableheaders[0] ) ) {
	do_action( 'pp_before_table_module', $settings );
?>
<table class="pp-table-<?php echo $id; ?> pp-table-content tablesaw" <?php echo $settings->sortable; ?> data-tablesaw-mode="<?php echo $settings->scrollable; ?>" data-tablesaw-minimap>
	<?php if ( 'manual' === $source || ( isset( $settings->first_row_header ) && 'yes' === $settings->first_row_header ) ) { ?>
	<thead>
		<tr>
			<?php
			$i = 1;
			foreach ( $tableheaders as $tableheader ) {
				echo '<th id="pp-table-col-' . $i++ . '" class="pp-table-col" scope="col" data-tablesaw-sortable-col>';
					echo trim( $tableheader );
				echo '</th>';
			}
			$i = 0;
			?>
		</tr>
	</thead>
	<?php } ?>
	<tbody>
		<?php
		if ( ! empty( $tablerows[0] ) ) {
			foreach ( $tablerows as $tablerow ) {
				if ( count( $tablerow->cell ) !== 1 ) {
					echo '<tr class="pp-table-row">';
					foreach ( $tablerow->cell as $tablecell ) {
						echo '<td>' . trim( $tablecell ) . '</td>';
					}
					echo '</tr>';
				} else {
					if ( ! empty( trim( $tablerow->cell[0] ) ) ) {
						echo '<tr class="pp-table-row">';
						echo '<td>' . trim( $tablerow->cell[0] ) . '</td>';
						echo '</tr>';
					}
				}
			}
		}
		?>
	</tbody>
</table>
<?php if ( $settings->scrollable == 'swipe' && $settings->custom_breakpoint > 0 ) : ?>
	<script>
	if ( jQuery(window).width() >= <?php echo $settings->custom_breakpoint; ?> ) {
		jQuery(".fl-node-<?php echo $id; ?> table.pp-table-content").removeAttr('data-tablesaw-mode');
	}
	</script>
<?php endif;

do_action( 'pp_after_table_module', $settings );

} // End if().
?>
</div>
