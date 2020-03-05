<?php
$image_alt = get_post_meta( $settings->image, '_wp_attachment_image_alt', true );

$currency_iso_code = '';
?>

<div class="pp-how-to-wrap pp-clearfix">
	<div class="pp-how-to-container pp-clearfix" itemscope itemtype="http://schema.org/HowTo">
		<<?php echo $settings->title_tag; ?> class="pp-how-to-title" itemprop="name"><?php echo $settings->title; ?></<?php echo $settings->title_tag; ?>>
		<div class="pp-how-to-description" itemprop="description"><?php echo $settings->description; ?></div>
		<?php if ( isset( $settings->image_src ) && ! empty( $settings->image_src ) ) { ?>
		<div class="pp-how-to-image">
			<img src="<?php echo $settings->image_src; ?>" alt="<?php echo $image_alt; ?>" itemprop="image" />
		</div>
		<?php } ?>
		<?php if ( 'yes' === $settings->show_advanced ) { ?>
			<div class="pp-how-to-slug">
				<?php
				if ( isset( $settings->total_time ) && ! empty( $settings->total_time ) ) {
					$total_time = $settings->total_time;
					?>
					<p class="pp-how-to-total-time" itemprop="totalTime" content="PT<?php echo $total_time; ?>M">
						<?php echo ! empty( $settings->total_time_text ) ? $settings->total_time_text : ''; ?><?php echo ' ' . $total_time; ?>minutes
					</p>
				<?php } ?>
				<?php if ( isset( $settings->estimated_cost ) && ! empty( $settings->estimated_cost ) ) { ?>
					<p class="pp-how-to-estimated-cost" itemprop="estimatedCost" itemscope itemtype="http://schema.org/MonetaryAmount">
						<meta itemprop="value" content="<?php echo $settings->estimated_cost; ?>"/>
						<?php if ( isset( $settings->currency_iso_code ) && ! empty( $settings->currency_iso_code ) ) { ?>
							<meta itemprop="currency" content="<?php echo $settings->currency_iso_code; ?>"/>
							<?php $currency_iso_code = $settings->currency_iso_code; ?>
						<?php } ?>

						<?php echo ! empty( $settings->estimated_cost_text ) ? $settings->estimated_cost_text : ''; ?>
						<span><?php echo $currency_iso_code . $settings->estimated_cost; ?></span>
					</p>
				<?php } ?>
			</div>

			<?php if ( 'yes' === $settings->add_supply ) { ?>
				<div class="pp-how-to-supply">
					<?php if ( isset( $settings->supply_title ) && ! empty( $settings->supply_title ) ) { ?>
						<<?php echo $settings->supply_title_tag; ?> class="pp-how-to-supply-title"><?php echo $settings->supply_title; ?></<?php echo $settings->supply_title_tag; ?>>
					<?php } ?>
					<?php
					if ( isset( $settings->pp_supply ) ) {
						foreach ( $settings->pp_supply as $key => $supply ) {
							?>
							<div class="pp-supply pp-supply-<?php echo $key + 1; ?>" itemprop="supply" itemscope itemtype="http://schema.org/HowToSupply">
								<span itemprop="name" ><?php echo $supply; ?></span>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php
			if ( 'yes' === $settings->add_tool ) {
				?>
				<div class="pp-how-to-tool">
					<?php if ( isset( $settings->tool_title ) && ! empty( $settings->tool_title ) ) { ?>
						<<?php echo $settings->tool_title_tag; ?> class="pp-how-to-tool-title"><?php echo $settings->tool_title; ?></<?php echo $settings->tool_title_tag; ?>>
					<?php } ?>
					<?php
					if ( isset( $settings->pp_tool ) ) {
						foreach ( $settings->pp_tool as $key => $tool ) {
							?>
							<div class="pp-tool pp-tool-<?php echo $key + 1; ?>" itemprop="tool" itemscope itemtype="http://schema.org/HowToTool">
								<span itemprop="name"><?php echo $tool; ?></span>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } // End if(). ?>
		<?php if ( isset( $settings->step_data ) ) { ?>
			<div class="pp-how-to-steps" id="step-<?php echo $id; ?>">
				<?php
				if ( isset( $settings->step_section_title ) && ! empty( $settings->step_section_title ) ) {
					?>
					<<?php echo $settings->step_section_title_tag; ?> class="pp-how-to-step-section-title" itemprop="name"><?php echo $settings->step_section_title; ?></<?php echo $settings->step_section_title_tag; ?>>
				<?php } ?>
				<?php
				foreach ( $settings->step_data as $key => $step ) {
					$target   = isset( $step->step_link_target ) ? ' target="' . $step->step_link_target . '"' : '';
					$nofollow = isset( $step->step_link_nofollow ) && 'yes' === $step->step_link_nofollow ? ' rel="nofollow"' : '';
					$step_id  = 'step-' . $id . '-' . ( $key + 1 );
					?>
					<div id="<?php echo $step_id; ?>" class="pp-how-to-step<?php echo isset( $step->step_image ) && ! empty( $step->step_image ) ? ' pp-has-img' : ' pp-no-img'; ?>" itemprop="step" itemscope itemtype="http://schema.org/HowToStep">
					<?php if ( isset( $step->step_link ) && ! empty( $step->step_link ) ) { ?>
						<meta itemprop="url" content="<?php echo $step->step_link; ?>"/>
					<?php } else { ?>
						<meta itemprop="url" content="<?php echo get_permalink() . '#' . $step_id; ?>"/>
					<?php } ?>

						<div class="pp-how-to-step-content">
						<?php if ( isset( $step->step_title ) && ! empty( $step->step_title ) ) { ?>
							<?php if ( isset( $step->step_link ) && ! empty( $step->step_link ) ) { ?>
								<a href="<?php echo $step->step_link; ?>"<?php echo $target; ?><?php echo $nofollow; ?>>
							<?php } ?>
								<div class="pp-how-to-step-title" itemprop="name"><?php echo $step->step_title; ?></div>
							<?php if ( isset( $step->step_link ) && ! empty( $step->step_link ) ) { ?>
								</a>
							<?php } ?>

							<?php if ( isset( $step->step_description ) && ! empty( $step->step_description ) ) { ?>
								<div class="pp-how-to-step-description" itemprop="text"><?php echo $step->step_description; ?></div>
							<?php } ?>

						<?php } else { ?>
							<?php if ( isset( $step->step_link ) && ! empty( $step->step_link ) ) { ?>
								<a href="<?php echo $step->step_link; ?>"<?php echo $target; ?><?php echo $nofollow; ?>>
							<?php } ?>
								<?php if ( isset( $step->step_description ) && ! empty( $step->step_description ) ) { ?>
									<div class="pp-how-to-step-description" itemprop="text"><?php echo $step->step_description; ?></div>
								<?php } ?>

							<?php if ( isset( $step->step_link ) && ! empty( $step->step_link ) ) { ?>
								</a>
							<?php } ?>

						<?php } ?>
						</div>
						<?php
						if ( isset( $step->step_image ) && ! empty( $step->step_image ) ) {
							$step_image_alt = get_post_meta( $step->step_image, '_wp_attachment_image_alt', true );
							?>
							<div class="pp-how-to-step-image">
								<img src="<?php echo $step->step_image_src; ?>" itemprop="image" alt="<?php echo $step_image_alt; ?>" />
							</div>
						<?php } ?>
					</div>
				<?php } // End foreach(). ?>
			</div>
		<?php } // End if(). ?>

	</div>
</div>
