<?php

ob_start();
tribe_the_notices();
$notices = ob_get_clean();

if ( ! $notices ) {

	if ( FLBuilderModel::is_builder_active() ) {
		?>
		<div class="tribe-events-notices">
			<ul>
				<li><?php _e( 'Event notices will appear here.', 'fl-theme-builder' ); ?></li>
			</ul>
		</div>
		<?php
	} else {
		?>
		<style>
		.fl-node-<?php echo $id; ?> {
			display:none;
		}
		</style>
		<?php
	}
} else {
	echo $notices;
}
