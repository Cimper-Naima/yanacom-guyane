<?php
$map_error = false;
$style     = '';
$api_url   = pp_get_google_api_url();

if ( empty( $api_url ) ) {
	$map_error = true;
	$style     = ' style="position: relative"';
}
?>

<div class="pp-google-map-wrapper"<?php echo $style; ?>>
	<div class="pp-google-map">
	<?php if ( true === $map_error ) { ?>
	<div class='pp-google-map-error' style="line-height: 1.5em;padding: 50px;text-align: center;position: absolute;top: 50%;width: 90%;left: 50%;transform: translate(-50%,-50%);">
		<span style=" line-height: 1.45em;"> 
			<?php _e( 'It seems that there is no API key for Google Maps. First of all, you can set an API key from the general settings and you will be able to display Google Maps on your website.', 'bb-powerpack' ); ?> 
			<a href="<?php echo admin_url( 'options-general.php?page=ppbb-settings&tab=integration' ); ?>" class="pp-google-map-notice" target="_blank" rel="noopener">
				<span style="font-weight:bold;"><?php _e( 'Click Here', 'bb-powerpack' ); ?>
				</span>
			</a>
		</span>
	</div>
	<?php } ?>
	</div>
</div>
