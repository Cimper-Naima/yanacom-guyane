<div class="fl-custom-query fl-loop-data-source" data-source="custom_query">
	<div id="fl-builder-settings-section-filter" class="fl-builder-settings-section">
		<h3 class="fl-builder-settings-title"></h3>

		<table class="fl-form-table fl-custom-query-filter fl-post_type-filter">
		<?php
		$post_types    = array();
		$post_slugs    = array();
		$taxonomy_type = array();

		foreach ( FLBuilderLoop::post_types() as $slug => $type ) {
			$post_slugs[] = $slug;
			$taxonomies   = FLBuilderLoop::taxonomies( $slug );

			if ( ! empty( $taxonomies ) ) {
				$post_types[ $slug ] = $type->label;

				foreach ( $taxonomies as $tax_slug => $tax ) {
					$taxonomy_type[ $slug ][ $tax_slug ] = $tax->label;
				}
			}
		}

		FLBuilder::render_settings_field(
			'sitemap_exclude',
			array(
				'type'     => 'suggest',
				'action'   => 'fl_as_posts',
				'data'     => $post_slugs,
				'label'    => __( 'Search & Select Posts Types', 'bb-powerpack' ),
				'matching' => true,
			),
			$settings
		);
		?>
		</table>

		<?php
		foreach ( $post_types as $slug => $label ) {
			foreach ( $taxonomy_type[ $slug ] as $tax_slug => $tax_label ) {
				$selected = isset( $settings->{'posts_' . $tax_slug . '_type'} ) ? $settings->{'posts_' . $tax_slug . '_type'} : 'post';
				?>
				<table class="fl-form-table fl-custom-query-filter fl-taxonomy-filter fl-tax-<?php echo $tax_slug; ?>-filter" >
					<?php
					FLBuilder::render_settings_field(
						'tax_' . $tax_slug,
						array(
							'type'     => 'suggest',
							'action'   => 'fl_as_terms',
							'data'     => $tax_slug,
							'label'    => $tax_label . ' ( ' . $tax_slug . ' ) ',
							/* translators: %s: tax label */
							'help'     => sprintf( __( 'Enter a list of %1$s.', 'bb-powerpack' ), $tax_label ),
							'matching' => true,
						),
						$settings
					);
					?>
				</table>
				<?php
			}
		}
		?>
	</div>
</div>
