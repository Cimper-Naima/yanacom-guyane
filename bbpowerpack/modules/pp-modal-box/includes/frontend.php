<?php if ( 'onclick' == $settings->modal_load ) { ?>
<div class="pp-modal-button">
	<a href="#" id="trigger-<?php echo $module->node; ?>" class="pp-modal-trigger modal-<?php echo $module->node; ?>" data-modal="<?php echo $module->node; ?>" data-node="<?php echo $module->node; ?>">
		<?php if ( 'button' == $settings->button_type ) { ?>
			<?php if ( '' != $settings->button_icon_src && 'before' == $settings->button_icon_pos ) { ?>
				<span class="pp-button-icon pp-button-icon-before <?php echo $settings->button_icon_src; ?>"></span>
			<?php } ?>
				<span class="pp-modal-trigger-text"><?php echo $settings->button_text; ?></span>
			<?php if ( '' != $settings->button_icon_src && 'after' == $settings->button_icon_pos ) { ?>
				<span class="pp-button-icon pp-button-icon-after <?php echo $settings->button_icon_src; ?>"></span>
			<?php } ?>
		<?php } ?>
		<?php if ( 'image' == $settings->button_type ) { ?>
			<img src="<?php echo $settings->image_source_src; ?>" class="pp-modal-trigger-image" />
		<?php } ?>
		<?php if ( 'icon' == $settings->button_type ) { ?>
			<span class="<?php echo $settings->icon_source; ?> pp-modal-trigger-icon"></span>
		<?php } ?>
	</a>
</div>
<?php } else { ?>
	<?php if ( FLBuilderModel::is_builder_active() ) { ?>
	<div class="pp-helper" style="text-align: center;">
		<h4><?php echo $module->name; ?></h4>
		<h5>modal-<?php echo $module->node; ?></h5>
		<?php _e('Click here to edit the "modal-box" settings. This text is only for editing and will not appear after you publish the changes.', 'bb-powerpack'); ?>
	</div>
	<?php } ?>
<?php } ?>
<div id="modal-<?php echo $module->node; ?>" class="pp-modal-wrap">
	<div class="pp-modal-container">
		<div class="pp-modal-overlay"></div>
		<?php if ( 'win-top-right' == $settings->close_btn_position || 'win-top-left' == $settings->close_btn_position ) { ?>
			<div class="pp-modal-close <?php echo $settings->close_btn_position; ?>">
				<div class="bar-wrap">
					<span class="bar-1"></span>
					<span class="bar-2"></span>
				</div>
			</div>
		<?php } ?>
		<div class="pp-modal layout-<?php echo $settings->modal_layout; ?>">
			<?php if ( FLBuilderModel::is_builder_active() ) { ?>
			<div style="position: absolute; top: -35px; color: #235425; text-transform: uppercase; background: #c6e4a4; border-radius: 2px; padding: 3px 10px;">Preview</div>
			<div style="position: absolute; top: -35px; left: 85px; color: #000000; text-transform: lowercase; background: #dedede; border-radius: 2px; padding: 3px 10px;">modal-<?php echo $module->node; ?></div>
			<?php } ?>
			<div class="pp-modal-body">
				<?php if ( 'no' == $settings->modal_title_toggle ) { ?>
					<?php if ( 'win-top-right' != $settings->close_btn_position && 'win-top-left' != $settings->close_btn_position ) { ?>
						<div class="pp-modal-close <?php echo $settings->close_btn_position; ?> no-modal-header">
							<div class="bar-wrap">
								<span class="bar-1"></span>
								<span class="bar-2"></span>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
				<?php if ( 'yes' == $settings->modal_title_toggle ) { ?>
				<div class="pp-modal-header">
					<?php if ( 'box-top-right' == $settings->close_btn_position ) { ?>
					<h2 class="pp-modal-title"><?php echo $settings->modal_title; ?></h2>
					<?php } ?>
					<?php if ( 'win-top-right' != $settings->close_btn_position && 'win-top-left' != $settings->close_btn_position ) { ?>
						<div class="pp-modal-close <?php echo $settings->close_btn_position; ?>">
							<div class="bar-wrap">
								<span class="bar-1"></span>
								<span class="bar-2"></span>
							</div>
						</div>
					<?php } ?>
					<?php if ( 'box-top-left' == $settings->close_btn_position ) { ?>
					<h2 class="pp-modal-title"><?php echo $settings->modal_title; ?></h2>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="pp-modal-content<?php echo ('url' == $settings->modal_type || 'video' == $settings->modal_type) ? ' pp-modal-frame' : '' ;?>">
					<div class="pp-modal-content-inner">
						<?php echo $module->get_modal_content( $settings ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
