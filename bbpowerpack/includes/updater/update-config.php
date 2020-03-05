<?php

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'BEAVER_ADDONS_URL', 'https://wpbeaveraddons.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'BEAVER_ADDONS_ITEM_NAME', 'PowerPack for Beaver Builder' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

define( 'BEAVER_ADDONS_LICENSE_PAGE', BB_PowerPack_Admin_Settings::get_form_action( '&tab=general' ) );

if( !class_exists( 'PP_Plugin_Updater' ) ) {
	// load our custom updater
	include('class-plugin-updater.php' );
}

function bb_powerpack_get( $key ) {
	if ( is_network_admin() ) {
		return get_site_option( $key );
	} else {
		return get_option( $key );
	}
}

function bb_powerpack_update( $key, $value ) {
	if ( is_network_admin() ) {
		return update_site_option( $key, $value );
	} else {
		return update_option( $key, $value );
	}
}

function bb_powerpack_delete( $key ) {
	if ( is_network_admin() ) {
		return delete_site_option( $key );
	} else {
		return delete_option( $key );
	}
}

function bb_powerpack_get_license_key() {
	if ( defined( 'BB_POWERPACK_LICENSE_KEY' ) ) {
		return BB_POWERPACK_LICENSE_KEY ? trim( BB_POWERPACK_LICENSE_KEY ) : '';
	} else {
		return trim( bb_powerpack_get( 'bb_powerpack_license_key' ) );
	}
}

function bb_powerpack_license( $action = '', $license_key = '' ) {
	$license = trim( $license_key );

	if ( empty( $license ) ) {
		$license = bb_powerpack_get_license_key();
	}

	// data to send in our API request
	$api_params = array(
		'edd_action'=> $action,
		'license' 	=> $license,
		'item_name' => urlencode( BEAVER_ADDONS_ITEM_NAME ), // the name of our product in EDD
		'url'       => network_home_url()
	);

	// Call the custom API.
	$response = wp_remote_post( BEAVER_ADDONS_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

	return $response;
}

function bb_powerpack_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = bb_powerpack_get_license_key();

	// setup the updater
	$edd_updater = new PP_Plugin_Updater( BEAVER_ADDONS_URL, BB_POWERPACK_DIR . '/bb-powerpack.php', array(
			'version' 	=> BB_POWERPACK_VER, 					// current version number
			'license' 	=> $license_key, 						// license key (used bb_powerpack_get above to retrieve from DB)
			'item_name' => BEAVER_ADDONS_ITEM_NAME, 			// name of this plugin
			'author' 	=> 'IdeaBox Creations' 	// author of this plugin
		)
	);

}
add_action( 'admin_init', 'bb_powerpack_plugin_updater', 0 );

/***********************************************
* Activate license key.
***********************************************/
function bb_powerpack_activate_license() {

	if ( ! isset( $_POST['bb_powerpack_license_activate'] ) ) {
		return;
	}

	// run a quick security check
	if ( ! isset( $_POST['bb_powerpack_nonce'] ) || ! wp_verify_nonce( $_POST['bb_powerpack_nonce'], 'bb_powerpack_nonce' ) ) {
		return; // get out if we didn't click the Activate button
	}

	$license = '';

	if ( isset( $_POST['bb_powerpack_license_key'] ) ) {
		$license = trim( $_POST['bb_powerpack_license_key'] );
	} else {
		$license = bb_powerpack_get_license_key();
	}

	$response = bb_powerpack_license( 'activate_license', $license );

	// make sure the response came back okay
	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

		if ( is_wp_error( $response ) ) {
			$message = $response->get_error_message();
		} else {
			$message = __( 'An error occurred, please try again.', 'bb-powerpack' );
		}
	} else {
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( false === $license_data->success ) {
			$message = bb_powerpack_license_messages( $license_data->error );
		}
	}

	// Check if anything passed on a message constituting a failure
	if ( ! empty( $message ) ) {
		$base_url = BEAVER_ADDONS_LICENSE_PAGE;
		$redirect = add_query_arg( array(
				'sl_activation' => 'false',
				'message' => urlencode( $message ),
		), $base_url );

		wp_redirect( $redirect );
		exit();
	}

	// $license_data->license will be either "valid" or "invalid"

	bb_powerpack_update( 'bb_powerpack_license_status', $license_data->license );

	wp_redirect( BEAVER_ADDONS_LICENSE_PAGE );
	exit();
}
add_action( 'admin_init', 'bb_powerpack_activate_license' );

/***********************************************
* Deactivate license key.
***********************************************/
function bb_powerpack_deactivate_license() {

	// listen for our activate button to be clicked
	if ( isset( $_POST['bb_powerpack_license_deactivate'] ) ) {

		// run a quick security check
		if ( ! isset( $_POST['bb_powerpack_nonce'] ) || ! wp_verify_nonce( $_POST['bb_powerpack_nonce'], 'bb_powerpack_nonce' ) ) {
			return; // get out if we didn't click the Activate button
		}

		$license = bb_powerpack_get_license_key();

		$response = bb_powerpack_license( 'deactivate_license', $license );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'bb-powerpack' );
			}

			$redirect = add_query_arg( array(
				'sl_activation' => 'false',
				'message' => urlencode( $message ),
			), BEAVER_ADDONS_LICENSE_PAGE );

			wp_redirect( $redirect );
			exit();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if ( 'deactivated' === $license_data->license || 'failed' === $license_data->license ) {
			bb_powerpack_delete( 'bb_powerpack_license_status' );
		}

		wp_redirect( BEAVER_ADDONS_LICENSE_PAGE );
		exit();
	} // End if().
}
add_action( 'admin_init', 'bb_powerpack_deactivate_license' );

/************************************
* check if
* a license key is still valid
* so this is only needed if we
* want to do something custom
*************************************/

function bb_powerpack_check_license() {
	global $wp_version;

	$license = bb_powerpack_get_license_key();

	$api_params = array(
		'edd_action' => 'check_license',
		'license' 	=> $license,
		'item_name' => urlencode( BEAVER_ADDONS_ITEM_NAME ),
		'url'       => network_home_url(),
	);

	// Call the custom API.
	$response = wp_remote_post(
		BEAVER_ADDONS_URL,
		array(
			'timeout' => 15,
			'sslverify' => false,
			'body' => $api_params,
		)
	);

	if ( is_wp_error( $response ) ) {
		return array(
			'message' => $response->get_error_message(),
		);
	}

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if ( 'valid' === $license_data->license ) {
		return 'valid';
		// this license is still valid.
	} else {
		// this license is no longer valid
		// delete license status.
		bb_powerpack_delete( 'bb_powerpack_license_status' );

		if ( in_array( $license_data->license, array( 'site_inactive' ) ) ) {
			$response = bb_powerpack_license( 'activate_license' );

			if ( ! is_wp_error( $response ) ) {
				// decode the license data
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( 'valid' === $license_data->license ) {
					bb_powerpack_update( 'bb_powerpack_license_status', $license_data->license );
				}
			}
		}

		return $license_data->license;
	}
}

 /**
  * Show update message on plugins page
  */
function bb_powerpack_update_message( $plugin_data, $response ) {
	$status = bb_powerpack_check_license();

	if ( 'valid' != $status ) {

		if ( is_array( $status ) ) {
			$main_msg = $status['message'];
		} else {
			$main_msg = sprintf( __( 'Please activate the license to enable automatic updates for this plugin. License status: %s', 'bb-powerpack' ), $status );
		}

		$message  = '';
		$message .= '<p style="padding: 5px 10px; margin-top: 10px; background: #d54e21; color: #fff;">';
		$message .= __( '<strong>UPDATE UNAVAILABLE!</strong>', 'bb-powerpack' );
		$message .= '&nbsp;&nbsp;&nbsp;';
		$message .= $main_msg;
		$message .= ' <a href="' . BEAVER_ADDONS_URL . '" target="_blank" style="color: #fff; text-decoration: underline;">';
		$message .= __( 'Buy Now', 'bb-powerpack' );
		$message .= ' &raquo;</a>';
		$message .= '</p>';

		echo $message;
	}
}
add_action( 'in_plugin_update_message-' . BB_POWERPACK_PATH, 'bb_powerpack_update_message', 1, 2 );

function bb_powerpack_license_messages( $status ) {
	$message = '';

	switch ( $status ) {

		case 'expired' :

			$message = sprintf(
				__('Your license key expired on %s.', 'bb-powerpack'),
				date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
			);
			break;

		case 'revoked' :
		case 'disabled':

			$message = __('Your license key has been disabled.', 'bb-powerpack');
			break;

		case 'missing' :
		case 'invalid' :

			$message = __('Invalid license.', 'bb-powerpack');
			break;

		case 'site_inactive' :

			$message = __('Your license is not active for this URL.', 'bb-powerpack');
			break;

		case 'item_name_mismatch' :

			$message = sprintf(__('This appears to be an invalid license key for %s.', 'bb-powerpack'), BEAVER_ADDONS_ITEM_NAME);
			break;

		case 'no_activations_left':

			$message = __('Your license key has reached its activation limit.', 'bb-powerpack');
			break;

		default :
			// translators: %s for license status.
			$message = sprintf( __('An error occurred, please try again. Status: %s', 'bb-powerpack'), $status );
			break;
	}

	return $message;
}
