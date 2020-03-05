<?php
if ( empty( $settings->list_items ) ) {
	return;
}
$sitemap_exclude = array();
$settings        = (array) $settings;
$label_tag       = $settings['label_tag'];
?>
<div class="pp-sitemap-content">
	<div class="pp-sitemap-wrapper">
		<?php
		foreach ( $settings['list_items'] as $sitemap_item ) {
			$sitemap_item = (array) $sitemap_item;
			$query_args   = [
				'has_password' => false,
			];
			if ( ! empty( $sitemap_item['sitemap_type'] ) ) {

				if ( 'taxonomy' === $sitemap_item['sitemap_type'] ) {
					if ( ! empty( $sitemap_item['sitemap_taxonomy_source'] ) ) {
						$var_tax          = 'tax_' . $sitemap_item['sitemap_taxonomy_source'];
						$var_tax_matching = 'tax_' . $sitemap_item['sitemap_taxonomy_source'] . '_matching';
						$sitemap_exclude  = explode( ',', $sitemap_item[ $var_tax ] );
						if ( ! empty( $sitemap_item[ $var_tax ] ) ) {
							if ( '1' === $sitemap_item[ $var_tax_matching ] ) {
								$query_args['include'] = $sitemap_exclude;
							} else {
								$query_args['exclude'] = $sitemap_exclude;
							}
						}
					}
					unset( $query_args['post__in'] );
					unset( $query_args['post__not_in'] );
				} else {
					if ( ! empty( $sitemap_item['sitemap_exclude'] ) ) {
						$sitemap_exclude = explode( ',', $sitemap_item['sitemap_exclude'] );
						if ( '0' === $sitemap_item['sitemap_exclude_matching'] ) {
							//exclude.
							$query_args['post__not_in'] = $sitemap_exclude;
						} else {
							//include.
							$query_args['post__in'] = $sitemap_exclude;
						}
					}
					unset( $query_args['exclude'] );
					unset( $query_args['include'] );
				}
				echo PPSiteMapModule::get_sitemap_content( $sitemap_item, $label_tag, $settings['no_follow'], $query_args );
			}
		} // End foreach().
		?>
	</div>
</div>
