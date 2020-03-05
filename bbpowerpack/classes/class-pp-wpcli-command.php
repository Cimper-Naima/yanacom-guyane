<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Cli commands for PowerPack.
 */
class BB_PowerPack_WPCLI_Command extends WP_CLI_Command {
	/**
	 * Activate the PowerPack's license.
	 *
	 * ## OPTIONS
	 *
	 * [--deactivate]
	 * Deactivate the license.
	 *
	 * [--license]
	 * License key to use.
	 *
	 * ## EXAMPLES
	 *
	 * 1. wp powerpack register --license=01234567890
	 * 		- Register this domain using license 01234567890
	 * 2. wp powerpack register --deactivate
	 * 		- Removes domain from domain manager and clears saved license info.
	*/
	public function register( $args, $assoc_args ) {
		$license = '';

		if ( isset( $assoc_args['deactivate'] ) ) {
			$response = bb_powerpack_license( 'deactivate_license' );

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					WP_CLI::error( $response->get_error_message() );
				} else {
					WP_CLI::error( __( 'An error occurred, please try again.', 'bb-powerpack' ) );
				}
			} else {
				// decode the license data
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				// $license_data->license will be either "deactivated" or "failed"
				if ( 'deactivated' === $license_data->license || 'failed' === $license_data->license ) {
					bb_powerpack_delete( 'bb_powerpack_license_status' );
				}

				WP_CLI::success( $license_data->license );
			}

			return false;
		}

		if ( isset( $assoc_args['license'] ) && '' != $assoc_args['license'] ) {
			$license = $assoc_args['license'];
		}

		if ( ! $license ) {
			WP_CLI::error( 'No license info found.' );
		}

		WP_CLI::log( sprintf( 'Using license [ %s ] to register %s', $license, network_home_url() ) );

		bb_powerpack_update( 'bb_powerpack_license_key', $license );

		$response = bb_powerpack_license( 'activate_license', $license );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				WP_CLI::error( $response->get_error_message() );
			} else {
				WP_CLI::error( __( 'An error occurred, please try again.', 'bb-powerpack' ) );
			}
		} else {
			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {
				WP_CLI::error( bb_powerpack_license_messages( $license_data->error ) );
			} else {
				// $license_data->license will be either "valid" or "invalid"
				bb_powerpack_update( 'bb_powerpack_license_status', $license_data->license );

				if ( 'valid' === $license_data->license ) {
					WP_CLI::success( 'activated' );
				} else {
					WP_CLI::error( __( 'Invalid license.', 'bb-powerpack' ) );
				}
			}
		}
	}

	/**
	 * White Label branding.
	 *
	 * ## OPTIONS
	 *
	 * [--reset]
	 * Resets the branding.
	 *
	 * ## EXAMPLES
	 *
	 * 1. wp powerpack branding --reset
	 * 		- Reset the white label setting page and plugin visibility.
	*/
	public function branding( $args, $assoc_args ) {
		if ( isset( $assoc_args['reset'] ) ) {
			bb_powerpack_plugin_activation();
			WP_CLI::success( __( 'White Label branding has been reset successfully.', 'bb-powerpack' ) );
		}
	}

	/**
	 * Templates.
	 *
	 * ## OPTIONS
	 *
	 * [--reset]
	 * Clears the enabled templates data.
	 *
	 * ## EXAMPLES
	 *
	 * 1. wp powerpack templates --reset
	 * 		- Reset the enabled templates.
	*/
	public function templates( $args, $assoc_args ) {
		if ( isset( $assoc_args['reset'] ) ) {
			pp_clear_enabled_templates();
			WP_CLI::success( __( 'Templates have been reset successfully.', 'bb-powerpack' ) );
		}
	}
}

WP_CLI::add_command( 'powerpack', 'BB_PowerPack_WPCLI_Command' );
