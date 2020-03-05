<?php
/**
* Functions file for Gravity Form module
*/

function __gf_module_form_titles() {

	$options = array( '' => __( 'None', 'bb-powerpack' ) );

	if ( class_exists( 'GFForms' ) ) {
		$forms = RGFormsModel::get_forms( null, 'title' );
		if ( count( $forms ) ) {
			foreach ( $forms as $form ) {
				$options[ $form->id ] = $form->title;
			}
		}
	}

	return $options;
}

function pp_gf_module_form_titles() {

	$options = array( '' => __( 'None', 'bb-powerpack' ) );

	global $wpdb;

	if ( class_exists( 'GFForms' ) ) {
		$form_table_name = GFFormsModel::get_form_table_name();
		$id              = 0;
		$forms           = $wpdb->get_results( $wpdb->prepare( 'SELECT id, title FROM ' . $form_table_name . ' WHERE id != %d', $id ), object );
		if ( ! is_wp_error( $forms ) ) {
			foreach ( $forms as $form ) {
				$options[ $form->id ] = $form->title;
			}
		}
	}

	return $options;
}
