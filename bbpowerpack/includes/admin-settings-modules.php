<?php
/**
 * PowerPack admin settings modules tab.
 *
 * @since 1.0.0
 * @package bb-powerpack
 */

?>

<p style="max-width: 800px;">
    <?php
    $settings_page = is_network_admin() ? 'settings.php' : 'options-general.php';
    $builder_label = FLBuilderModel::get_branding();
    $builder_label = ( ! $builder_label || '' == $builder_label ) ? 'Builder' : $builder_label;
    ?>
    You can manage <?php echo BB_POWERPACK_CAT; ?> from <a href="<?php echo admin_url( $settings_page . '?page=fl-builder-settings#modules' ); ?>"><?php echo $builder_label; ?> settings</a>
</p>
