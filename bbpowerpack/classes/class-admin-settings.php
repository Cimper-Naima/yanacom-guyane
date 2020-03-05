<?php
/**
 * Handles logic for the admin settings page.
 *
 * @since 1.1.5
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class BB_PowerPack_Admin_Settings {
	/**
	 * Holds any errors that may arise from
	 * saving admin settings.
	 *
	 * @since 1.1.5
	 * @var array $errors
	 */
	static public $errors = array();

	/**
	 * Holds the templates count.
	 *
	 * @since 1.1.8
	 * @var array
	 */
	static public $templates_count;

	/**
	 * Initializes the admin settings.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	static public function init() {
		add_action( 'plugins_loaded', __CLASS__ . '::init_hooks' );
	}

	/**
	 * Adds the admin menu and enqueues CSS/JS if we are on
	 * the plugin's admin settings page.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	static public function init_hooks() {
		if ( ! is_admin() ) {
			return;
		}

		self::multisite_fallback();

		add_action( 'admin_menu',           	__CLASS__ . '::menu' );
		add_action( 'network_admin_menu',   	__CLASS__ . '::menu' );
		add_filter( 'all_plugins',          	__CLASS__ . '::update_branding' );
		add_action( 'admin_enqueue_scripts', 	__CLASS__ . '::enqueue_script' );
		add_action( 'admin_notices', 			__CLASS__ . '::render_latest_update_notice' );
		add_action( 'network_admin_notices', 	__CLASS__ . '::render_latest_update_notice' );

		if ( isset( $_GET['page'] ) && 'ppbb-settings' == $_GET['page'] ) {
			add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );
			self::save();
		}
	}

	/**
	 * Enqueues the needed CSS/JS for the admin settings page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function styles_scripts() {
		// Styles
		wp_enqueue_style( 'pp-admin-settings', BB_POWERPACK_URL . 'assets/css/admin-settings.css', array(), BB_POWERPACK_VER );
	}

	/**
	 * Enqueues the admin notice JS.
	 *
	 * @since 2.7.4
	 * @return void
	 */
	static public function enqueue_script() {
		wp_enqueue_script( 'pp-admin-notices', BB_POWERPACK_URL . 'assets/js/admin.js', array( 'jquery' ), BB_POWERPACK_VER, true );
	}

	static public function menu() {
		$admin_label = pp_get_admin_label();
		$callback = __CLASS__ . '::render';
		$slug = 'ppbb-settings';

		// Add menu in network admin settings - multisite.
		if ( current_user_can( 'manage_options' ) ) {
			add_submenu_page( 'options-general.php', $admin_label, $admin_label, 'manage_options', $slug, $callback );
		}

		// Add menu in network admin settings - multisite.
		if ( current_user_can( 'manage_network_plugins' ) ) {
			add_submenu_page( 'settings.php', $admin_label, $admin_label, 'manage_network_plugins', $slug, $callback );
		}
	}

	/**
	 * Renders the admin settings menu.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	static public function _menu() {
		$admin_label = pp_get_admin_label();
		$slug = 'ppbb-settings';

		// Add main menu.
		add_menu_page( $admin_label, $admin_label, 'edit_posts', $slug, __CLASS__ . '::render' );

		$tabs = self::get_tabs();

		foreach ( $tabs as $tab_key => $tab ) {
			$child_slug = 'admin.php?page=' . $slug . '&tab=' . $tab_key;
			$cap 		= ! isset( $tab['cap'] ) ? 'manage_options' : $tab['cap'];
			$render 	= ! isset( $tab['show'] ) ? true : $tab['show'];

			if ( $render ) {
				add_submenu_page( $slug, $tab['title'], $tab['title'], $cap, $child_slug );
			}
		}

		// Remove parent menu added as submenu.
		remove_submenu_page( $slug, $slug );

		// Set the correct parent_file to highlight the correct top level menu.
		add_filter( 'parent_file', __CLASS__ . '::parent_file' );

		// Add menu in network admin settings - multisite.
		if ( current_user_can( 'manage_network_plugins' ) ) {

			$title = $admin_label;
			$cap   = 'manage_network_plugins';
			$slug  = 'ppbb-settings';
			$func  = __CLASS__ . '::render';

			//add_submenu_page( 'settings.php', $title, $title, $cap, $slug, $func );
		}
	}

	/**
	 * Set the correct parent_file to highlight the correct top level menu
	 *
	 * @param string $parent_file The parent file.
	 *
	 * @return mixed|string
	 *
	 * @since 2.7.8
	 */
	static public function parent_file( $parent_file ) {
		global $submenu_file;

		if ( 'ppbb-settings' === $parent_file ) {
			if ( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ) {
				$submenu_file = 'admin.php?page=ppbb-settings&tab=' . sanitize_text_field( $_GET['tab'] );
			} else {
				$submenu_file = 'admin.php?page=ppbb-settings&tab=general';
			}
		}

		return $parent_file;
	}

	/**
	 * Renders the admin settings.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	static public function render() {
		include BB_POWERPACK_DIR . 'includes/admin-settings.php';
	}

	static public function render_setting_page() {
		$tabs = self::get_tabs();
		$current_tab = self::get_current_tab();

		if ( isset( $tabs[ $current_tab ] ) ) {
			$no_setting_file_msg = esc_html__( 'Setting page file could not be located.', 'bb-powerpack' );
			
			if ( ! isset( $tabs[ $current_tab ]['file'] ) || empty( $tabs[ $current_tab ]['file'] ) ) {
				echo $no_setting_file_msg;
				return;
			}

			if ( ! file_exists( $tabs[ $current_tab ]['file'] ) ) {
				echo $no_setting_file_msg;
				return;
			}

			$render = ! isset( $tabs[ $current_tab ]['show'] ) ? true : $tabs[ $current_tab ]['show'];
			$cap = 'manage_options';

			if ( isset( $tabs[ $current_tab ]['cap'] ) && ! empty( $tabs[ $current_tab ]['cap'] ) ) {
				$cap = $tabs[ $current_tab ]['cap'];
			} else {
				$cap = ! is_network_admin() ? 'manage_options' : 'manage_network_plugins';
			}

			if ( ! $render || ! current_user_can( $cap ) ) {
				esc_html_e( 'You do not have permission to view this setting.', 'bb-powerpack' );
				return;
			}

			include $tabs[ $current_tab ]['file'];
		}
	}

	/**
	 * Get tabs for admin settings.
	 *
	 * @since 1.2.7
	 * @return array
	 */
	static public function get_tabs() {
		return apply_filters( 'pp_admin_settings_tabs', array(
			'general'   => array(
				'title'     => esc_html__( 'General', 'bb-powerpack' ),
				'show'      => ( is_network_admin() || ! is_multisite() ),
				'cap'		=> ! is_network_admin() ? 'manage_options' : 'manage_network_plugins',
				'file'		=> BB_POWERPACK_DIR . 'includes/admin-settings-license.php',
				'priority'  => 50,
			),
			'white-label'   => array(
				'title'     => esc_html__( 'White Label', 'bb-powerpack' ),
				'show'      => ( is_network_admin() || ! is_multisite() ) && ( ! self::get_option( 'ppwl_hide_form' ) || self::get_option( 'ppwl_hide_form' ) == 0 ),
				'cap'		=> ! is_network_admin() ? 'manage_options' : 'manage_network_plugins',
				'file'		=> BB_POWERPACK_DIR . 'includes/admin-settings-wl.php',
				'priority'  => 100,
			),
			'templates' => array(
				'title'     => esc_html__( 'Templates', 'bb-powerpack' ),
				'show'      => ! self::get_option( 'ppwl_hide_templates_tab' ) || self::get_option( 'ppwl_hide_templates_tab' ) == 0,
				'cap'		=> 'edit_posts',
				'file'		=> BB_POWERPACK_DIR . 'includes/admin-settings-templates.php',
				'priority'  => 200,
			),
			'extensions' => array(
				'title'     => esc_html__( 'Extensions', 'bb-powerpack' ),
				'show'      => true,
				'cap'		=> ! is_network_admin() ? 'manage_options' : 'manage_network_plugins',
				'file'		=> BB_POWERPACK_DIR . 'includes/admin-settings-extensions.php',
				'priority'  => 250,
			),
			'integration'	=> array(
				'title'			=> esc_html__( 'Integration', 'bb-powerpack' ),
				'show'			=> ! self::get_option( 'ppwl_hide_integration_tab' ),
				'cap'			=> ! is_network_admin() ? 'manage_options' : 'manage_network_plugins',
				'file'			=> BB_POWERPACK_DIR . 'includes/admin-settings-integration.php',
				'priority'  	=> 300,
			),
		) );
	}

	/**
	 * Renders tabs for admin settings.
	 *
	 * @since 1.2.7
	 * @return void
	 */
	static public function render_tabs( $current_tab ) {
		$tabs = self::get_tabs();

		$sorted_data = array();

		foreach ( $tabs as $key => $data ) {
			$data['key'] = $key;
			$sorted_data[ $data['priority'] ] = $data;
		}

		ksort( $sorted_data );

		foreach ( $sorted_data as $data ) {
			if ( $data['show'] ) {
				if ( isset( $data['cap'] ) && ! current_user_can( $data['cap'] ) ) {
					continue;
				}
				?>
				<a href="<?php echo self::get_form_action( '&tab=' . $data['key'] ); ?>" class="nav-tab<?php echo ( $current_tab == $data['key'] ? ' nav-tab-active' : '' ); ?>"><?php echo $data['title']; ?></a>
				<?php
			}
		}
	}

	/**
	 * Get current tab.
	 *
	 * @since 1.2.7
	 * @return string
	 */
	static public function get_current_tab() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

		if ( ! isset( $_GET['tab'] ) ) {
			if ( is_multisite() && ! is_network_admin() ) {
				$current_tab = 'templates';
			}
		}

		return $current_tab;
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.1.5
	 * @return void
	 */
	static public function render_update_message() {
		if ( ! empty( self::$errors ) ) {
			foreach ( self::$errors as $message ) {
				echo '<div class="error"><p>' . $message . '</p></div>';
			}
		} elseif ( ! empty( $_POST ) && ! isset( $_POST['email'] ) ) {
			echo '<div class="updated"><p>' . esc_html__( 'Settings updated!', 'bb-powerpack' ) . '</p></div>';
		}
	}

	/**
	 * Renders the latest update post message.
	 *
	 * @since 2.7.4
	 * @return void
	 */
	static public function render_latest_update_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( is_multisite() && ( ! is_network_admin() || ! is_main_site() ) ) {
			return;
		}

		if ( ! self::get_option( 'ppwl_enable_latest_update_notice' ) ) {
			return;
		}

		if ( get_user_meta( get_current_user_id(), 'bb_powerpack_dismissed_latest_update_notice', true ) ) {
			return;
		}

		$latest_info = self::get_latest_update_info();
		if ( isset( $latest_info['error'] ) && $latest_info['error'] ) {
			if ( isset( $latest_info['message'] ) ) {
				// uncomment below condition for debug purpose.
				// self::add_error( $latest_info['message'] );
			}
			return;
		}

		?>
		<div
			class="notice notice-info pp-latest-update-notice"
			style="position: relative; background: #f0fbff;"
			data-nonce="<?php echo wp_create_nonce( 'pp_notice' ); ?>"
			>
			<p>
				<?php
					$pp_string = 'PowerPack v' . BB_POWERPACK_VER;
					// translators: %s is for PowerPack.
					echo sprintf( esc_html__( 'See what\'s new in %s', 'bb-powerpack' ), $pp_string );
				?> - <strong><?php echo $latest_info['title']; ?></strong>
				<a href="<?php echo $latest_info['link']; ?>" target="_blank">
				<?php echo __( 'Read More', 'bb-powerpack' ); ?>
				</a>
			</p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">Dismiss this notice.</span>
			</button>
		</div>
		<?php
		self::update_option( 'bb_powerpack_current_version', BB_POWERPACK_VER );
	}

	/**
	 * Get latest update info from remote server.
	 *
	 * @since 2.7.4
	 * @return array $data
	 */
	static private function get_latest_update_info() {
		$data = array(
			'error'	=> false,
			'message' => '',
		);

		$version = self::get_option( 'bb_powerpack_current_version' );

		if ( ! $version || version_compare( $version, BB_POWERPACK_VER, '<' ) ) {
			self::delete_option( 'bb_powerpack_latest_update_info' );
		} else {
			// Check and return if we've cached the response already.
			$db_latest_info = self::get_option( 'bb_powerpack_latest_update_info' );

			if ( is_array( $db_latest_info ) ) {
				$data = $db_latest_info;

				return $db_latest_info;
			}
		}

		// Get response from remote server.
		$response = wp_remote_post( 'https://wpbeaveraddons.com/', array(
			'timeout' => 15,
			'sslverify' => false,
			'body' => array(
				'ibx_action' => 'get_latest_update_info',
			),
		) );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$data['error'] = true;
			$data['message'] = $response->get_error_message();
		} else {
			$data['error'] = false;
			$data = (array) json_decode( wp_remote_retrieve_body( $response ) );
		}

		if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) {
			self::update_option( 'bb_powerpack_latest_update_info', $data );
		} else {
			$data['error'] = true;
			$data['message'] = __( 'Empty title', 'bb-powerpack' );
		}

		return $data;
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.1.5
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	static public function get_form_action( $type = '' ) {
		if ( is_network_admin() ) {
			return network_admin_url( '/settings.php?page=ppbb-settings' . $type );
		} else {
			return admin_url( '/options-general.php?page=ppbb-settings' . $type );
		}
	}

	static public function get_user_roles() {
		global $wp_roles;

		return $wp_roles->get_names();
	}

	/**
	 * Adds an error message to be rendered.
	 *
	 * @since 1.1.5
	 * @param string $message The error message to add.
	 * @return void
	 */
	static public function add_error( $message ) {
		self::$errors[] = $message;
	}

	static public function parse_error( $message ) {
		if ( false !== strpos( $message, 'wpbeaveraddons' ) ) {
			return esc_html__( 'Could not connect to the host.', 'bb-powerpack' );
		}

		return;
	}

	static public function is_network_admin() {
		if ( is_multisite() && isset( $_SERVER['HTTP_REFERER'] ) && preg_match( '#^' . network_admin_url() . '#i', $_SERVER['HTTP_REFERER'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns an option from the database for
	 * the admin settings page.
	 *
	 * @since 1.1.5
	 * @param string $key The option key.
	 * @param bool $network_override Multisite template override check.
	 * @return mixed
	 */
	static public function get_option( $key, $network_override = true ) {
		if ( is_network_admin() ) {
			$value = get_site_option( $key );
		} elseif ( ! $network_override && is_multisite() ) {
			$value = get_site_option( $key );
		} elseif ( $network_override && is_multisite() ) {
			$value = get_option( $key );
			$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) && get_option( 'bb_powerpack_override_ms' ) != 1 ) ) ? get_site_option( $key ) : $value;
		} else {
			$value = get_option( $key );
		}

		return $value;
	}

	/**
	 * Updates an option from the admin settings page.
	 *
	 * @since 1.1.5
	 * @param string $key The option key.
	 * @param mixed $value The value to update.
	 * @param bool $network_override Multisite template override check.
	 * @return mixed
	 */
	static public function update_option( $key, $value, $network_override = true ) {
		if ( is_network_admin() || self::is_network_admin() ) {
			update_site_option( $key, $value );
		} elseif ( $network_override && is_multisite() && ! isset( $_POST['bb_powerpack_override_ms'] ) ) {
			// Delete the option if network overrides are allowed and the override checkbox isn't checked.
			delete_option( $key );
		} else {
			update_option( $key, $value );
		}
	}

	/**
	 * Delete an option from the admin settings page.
	 *
	 * @since 1.1.5
	 * @param string $key The option key.
	 * @param mixed $value The value to delete.
	 * @return mixed
	 */
	static public function delete_option( $key ) {
		if ( is_network_admin() ) {
			delete_site_option( $key );
		} else {
			delete_option( $key );
		}
	}

	static public function has_license_key_defined() {
		return defined( 'BB_POWERPACK_LICENSE_KEY' );
	}

	/**
	 * Saves the admin settings.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function save() {
		// Only admins can save settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		self::save_license();
		self::save_integration();
		self::save_white_label();
		self::save_modules();
		self::save_templates();
		self::save_extensions();

		do_action( 'pp_admin_settings_save' );
	}

	/**
	 * Saves the license.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function save_license() {
		if ( isset( $_POST['bb_powerpack_license_key'] ) ) {

			$old = get_option( 'bb_powerpack_license_key' );
			$new = $_POST['bb_powerpack_license_key'];

			if ( $old && $old != $new ) {
				self::delete_option( 'bb_powerpack_license_status' ); // new license has been entered, so must reactivate
			}

			self::update_option( 'bb_powerpack_license_key', $new );
		}
	}

	/**
	 * Saves integrations.
	 *
	 * @since 2.4
	 * @access private
	 * @return void
	 */
	static private function save_integration() {
		if ( ! isset( $_POST['bb_powerpack_license_deactivate'] ) && ! isset( $_POST['bb_powerpack_license_activate'] ) ) {
			if ( isset( $_POST['bb_powerpack_fb_app_id'] ) ) {

				// Validate App ID.
				if ( ! empty( $_POST['bb_powerpack_fb_app_id'] ) ) {
					$response = wp_remote_get( 'https://graph.facebook.com/' . $_POST['bb_powerpack_fb_app_id'] );
					$error = '';

					if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
						// translators: %s is for API response.
						$error = sprintf( __( 'Facebook App ID is not valid. Error: %s', 'bb-powerpack' ), wp_remote_retrieve_response_message( $response ) );
					}

					if ( ! empty( $error ) ) {
						wp_die( $error, __( 'Facebook SDK', 'bb-powerpack' ), array(
							'back_link' => true,
						) );
					}
				}

				self::update_option( 'bb_powerpack_fb_app_id', trim( $_POST['bb_powerpack_fb_app_id'] ), false );
			}

			if ( isset( $_POST['bb_powerpack_google_api_key'] ) ) {
				self::update_option( 'bb_powerpack_google_api_key', trim( $_POST['bb_powerpack_google_api_key'] ), false );
			}
		}
	}

	/**
	 * Saves the white label settings.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function save_white_label() {
		if ( ! isset( $_POST['pp-wl-settings-nonce'] ) || ! wp_verify_nonce( $_POST['pp-wl-settings-nonce'], 'pp-wl-settings' ) ) {
			return;
		}
		if ( isset( $_POST['ppwl_plugin_name'] ) ) {
			self::update_option( 'ppwl_plugin_name', sanitize_text_field( $_POST['ppwl_plugin_name'] ) );
			self::update_option( 'ppwl_plugin_desc', esc_textarea( $_POST['ppwl_plugin_desc'] ) );
			self::update_option( 'ppwl_plugin_author', sanitize_text_field( $_POST['ppwl_plugin_author'] ) );
			self::update_option( 'ppwl_plugin_uri', esc_url( $_POST['ppwl_plugin_uri'] ) );
		}
		$admin_label            = isset( $_POST['ppwl_admin_label'] ) ? sanitize_text_field( $_POST['ppwl_admin_label'] ) : 'PowerPack';
		$category_label         = isset( $_POST['ppwl_builder_label'] ) ? sanitize_text_field( $_POST['ppwl_builder_label'] ) : 'PowerPack ' . __( 'Modules', 'bb-powerpack' );
		$tmpl_category_label    = isset( $_POST['ppwl_tmpcat_label'] ) ? sanitize_text_field( $_POST['ppwl_tmpcat_label'] ) : 'PowerPack Layouts';
		$row_templates_label    = isset( $_POST['ppwl_rt_label'] ) ? sanitize_text_field( $_POST['ppwl_rt_label'] ) : 'PowerPack ' . __( 'Row Templates', 'bb-powerpack' );
		$support_link           = isset( $_POST['ppwl_support_link'] ) ? esc_url_raw( $_POST['ppwl_support_link'] ) : 'httsp://wpbeaveraddons.com/contact/';
		$docs_link           	= isset( $_POST['ppwl_docs_link'] ) ? esc_url_raw( $_POST['ppwl_docs_link'] ) : 'httsp://wpbeaveraddons.com/docs/';
		$remove_license_link    = isset( $_POST['ppwl_remove_license_key_link'] ) ? absint( $_POST['ppwl_remove_license_key_link'] ) : 0;
		$remove_docs_link    	= isset( $_POST['ppwl_remove_docs_link'] ) ? absint( $_POST['ppwl_remove_docs_link'] ) : 0;
		$remove_support_link    = isset( $_POST['ppwl_remove_support_link'] ) ? absint( $_POST['ppwl_remove_support_link'] ) : 0;
		$enable_latest_notice  	= isset( $_POST['ppwl_enable_latest_update_notice'] ) ? absint( $_POST['ppwl_enable_latest_update_notice'] ) : 0;
		$list_modules_standard  = isset( $_POST['ppwl_list_modules_with_standard'] ) ? absint( $_POST['ppwl_list_modules_with_standard'] ) : 0;
		$hide_templates_tab     = isset( $_POST['ppwl_hide_templates_tab'] ) ? absint( $_POST['ppwl_hide_templates_tab'] ) : 0;
		$hide_extensions_tab    = isset( $_POST['ppwl_hide_extensions_tab'] ) ? absint( $_POST['ppwl_hide_extensions_tab'] ) : 0;
		$hide_integration_tab   = isset( $_POST['ppwl_hide_integration_tab'] ) ? absint( $_POST['ppwl_hide_integration_tab'] ) : 0;
		$hide_header_footer_tab = isset( $_POST['ppwl_hide_header_footer_tab'] ) ? absint( $_POST['ppwl_hide_header_footer_tab'] ) : 0;
		$hide_maintenance_tab   = isset( $_POST['ppwl_hide_maintenance_tab'] ) ? absint( $_POST['ppwl_hide_maintenance_tab'] ) : 0;
		$hide_wl_form           = isset( $_POST['ppwl_hide_form'] ) ? absint( $_POST['ppwl_hide_form'] ) : 0;
		$hide_plugin            = isset( $_POST['ppwl_hide_plugin'] ) ? absint( $_POST['ppwl_hide_plugin'] ) : 0;
		self::update_option( 'ppwl_admin_label', $admin_label );
		self::update_option( 'ppwl_builder_label', $category_label );
		self::update_option( 'ppwl_tmpcat_label', $tmpl_category_label );
		self::update_option( 'ppwl_rt_label', $row_templates_label );
		self::update_option( 'ppwl_support_link', $support_link );
		self::update_option( 'ppwl_docs_link', $docs_link );
		self::update_option( 'ppwl_remove_license_key_link', $remove_license_link );
		self::update_option( 'ppwl_remove_docs_link', $remove_docs_link );
		self::update_option( 'ppwl_remove_support_link', $remove_support_link );
		self::update_option( 'ppwl_enable_latest_update_notice', $enable_latest_notice );
		self::update_option( 'ppwl_list_modules_with_standard', $list_modules_standard );
		self::update_option( 'ppwl_hide_templates_tab', $hide_templates_tab );
		self::update_option( 'ppwl_hide_extensions_tab', $hide_extensions_tab );
		self::update_option( 'ppwl_hide_integration_tab', $hide_integration_tab );
		self::update_option( 'ppwl_hide_header_footer_tab', $hide_header_footer_tab );
		self::update_option( 'ppwl_hide_maintenance_tab', $hide_maintenance_tab );
		self::update_option( 'ppwl_hide_form', $hide_wl_form );
		self::update_option( 'ppwl_hide_plugin', $hide_plugin );
	}

	/**
	* Saves the modules settings.
	*
	* @since 1.0
	* @access private
	* @return void
	*/
	static private function save_modules() {
		if ( isset( $_POST['pp-modules-nonce'] ) && wp_verify_nonce( $_POST['pp-modules-nonce'], 'pp-modules' ) ) {

			if ( isset( $_POST['bb_powerpack_modules_all'] ) ) {
				self::update_option( 'bb_powerpack_modules_all', 1 );
			} else {
				self::update_option( 'bb_powerpack_modules_all', 2 );
			}

			$enabled_modules = self::get_option( '_fl_builder_enabled_modules', true );
			if ( ! $enabled_modules || false === $enabled_modules ) {
				$enabled_modules = FLBuilderModel::get_enabled_modules();
			}

			if ( isset( $_POST['bb_powerpack_modules'] ) && is_array( $_POST['bb_powerpack_modules'] ) ) {
				$modules = array_map( 'sanitize_text_field', $_POST['bb_powerpack_modules'] );
				self::update_option( 'bb_powerpack_modules', $modules );
			}
			if ( ! isset( $_POST['bb_powerpack_modules'] ) ) {
				self::update_option( 'bb_powerpack_modules', array( 'disabled' ) );
			}
		}
	}

	/**
	* Saves the templates settings.
	*
	* @since 1.0
	* @access private
	* @return void
	*/
	static private function save_templates() {
		if ( isset( $_POST['bb_powerpack_override_ms'] ) ) {
			update_option( 'bb_powerpack_override_ms', absint( $_POST['bb_powerpack_override_ms'] ) );
		}

		if ( isset( $_POST['bb_powerpack_row_templates_all'] ) ) {
			self::update_option( 'bb_powerpack_row_templates_all', absint( $_POST['bb_powerpack_row_templates_all'] ) );
		}

		if ( isset( $_POST['pp-row-templates-nonce'] ) && wp_verify_nonce( $_POST['pp-row-templates-nonce'], 'pp-row-templates' ) ) {

			if ( isset( $_POST['bb_powerpack_templates'] ) && is_array( $_POST['bb_powerpack_templates'] ) ) {
				$templates = array_map( 'sanitize_text_field', $_POST['bb_powerpack_templates'] );
				self::update_option( 'bb_powerpack_templates', $templates );

				if ( ! isset( $_POST['bb_powerpack_override_ms'] ) ) {
					delete_option( 'bb_powerpack_override_ms' );
				}
			}

			if ( ! isset( $_POST['bb_powerpack_templates'] ) ) {
				self::update_option( 'bb_powerpack_templates', array( 'disabled' ) );
			}
		}
	}

	/**
	* Saves the extensions settings.
	*
	* @since 1.1.6
	* @access private
	* @return void
	*/
	static private function save_extensions() {
		if ( isset( $_POST['pp-extensions-nonce'] ) && wp_verify_nonce( $_POST['pp-extensions-nonce'], 'pp-extensions' ) ) {

			if ( isset( $_POST['bb_powerpack_quick_preview'] ) ) {
				self::update_option( 'bb_powerpack_quick_preview', 1 );
			} else {
				self::update_option( 'bb_powerpack_quick_preview', 2 );
			}

			if ( isset( $_POST['bb_powerpack_search_box'] ) ) {
				self::update_option( 'bb_powerpack_search_box', 1 );
			} else {
				self::update_option( 'bb_powerpack_search_box', 2 );
			}

			if ( isset( $_POST['bb_powerpack_extensions'] ) && is_array( $_POST['bb_powerpack_extensions'] ) ) {
				self::update_option( 'bb_powerpack_extensions', $_POST['bb_powerpack_extensions'] );
			}

			if ( ! isset( $_POST['bb_powerpack_extensions'] ) ) {
				self::update_option( 'bb_powerpack_extensions', array( 'disabled' ), true );
			}
		}
	}

	/**
	* Returns an array of all PowerPack modules that are enabled.
	*
	* @since 1.1.5
	* @return array
	*/
	static public function get_enabled_modules() {
		$enabled_modules = self::get_option( 'bb_powerpack_modules', true );

		if ( ! ( $enabled_modules ) || false === $enabled_modules || ! is_array( $enabled_modules ) ) {

			$modules = pp_modules();

			foreach ( $modules as $slug => $title ) {
				$enabled_modules[] = $slug;
			}
		}

		return $enabled_modules;
	}

	/**
	* Returns an array of all PowerPack row templates that are enabled.
	*
	* @since 1.1.5
	* @return array
	*/
	static public function get_enabled_templates( $type = 'row' ) {
		return BB_PowerPack_Templates_Lib::get_enabled_templates( $type );
	}

	/**
	* Returns template type or scheme.
	*
	* @since 1.1.5
	* @return string
	*/
	static public function get_template_scheme() {
		return 'color';
	}

	/**
	* Returns an array of all PowerPack extensions which are enabled.
	*
	* @since 1.1.5
	* @return array
	*/
	static public function get_enabled_extensions() {
		$enabled_extensions = self::get_option( 'bb_powerpack_extensions', true );

		if ( is_array( $enabled_extensions ) ) {

			if ( ! isset( $enabled_extensions['row'] ) ) {
				$enabled_extensions['row'] = array();
			}
			if ( ! isset( $enabled_extensions['col'] ) ) {
				$enabled_extensions['col'] = array();
			}
		}

		if ( ! $enabled_extensions || ! is_array( $enabled_extensions ) ) {

			$enabled_extensions = pp_extensions();

			// lets unset some options as they are added in BB 2.2
			unset( $enabled_extensions['row']['gradient'] );
			unset( $enabled_extensions['col']['gradient'] );
			unset( $enabled_extensions['col']['corners'] );
			unset( $enabled_extensions['col']['shadow'] );

		}

		return $enabled_extensions;
	}

	/**
	* Update branding.
	*
	* @since 1.0.0
	* @return array
	*/
	static public function update_branding( $all_plugins ) {
		$pp_plugin_path = plugin_basename( BB_POWERPACK_DIR . 'bb-powerpack.php' );

		$all_plugins[ $pp_plugin_path ]['Name']           = self::get_option( 'ppwl_plugin_name' ) ? self::get_option( 'ppwl_plugin_name' ) : $all_plugins[ $pp_plugin_path ]['Name'];
		$all_plugins[ $pp_plugin_path ]['PluginURI']      = self::get_option( 'ppwl_plugin_uri' ) ? self::get_option( 'ppwl_plugin_uri' ) : $all_plugins[ $pp_plugin_path ]['PluginURI'];
		$all_plugins[ $pp_plugin_path ]['Description']    = self::get_option( 'ppwl_plugin_desc' ) ? self::get_option( 'ppwl_plugin_desc' ) : $all_plugins[ $pp_plugin_path ]['Description'];
		$all_plugins[ $pp_plugin_path ]['Author']         = self::get_option( 'ppwl_plugin_author' ) ? self::get_option( 'ppwl_plugin_author' ) : $all_plugins[ $pp_plugin_path ]['Author'];
		$all_plugins[ $pp_plugin_path ]['AuthorURI']      = self::get_option( 'ppwl_plugin_uri' ) ? self::get_option( 'ppwl_plugin_uri' ) : $all_plugins[ $pp_plugin_path ]['AuthorURI'];
		$all_plugins[ $pp_plugin_path ]['Title']          = self::get_option( 'ppwl_plugin_name' ) ? self::get_option( 'ppwl_plugin_name' ) : $all_plugins[ $pp_plugin_path ]['Title'];
		$all_plugins[ $pp_plugin_path ]['AuthorName']     = self::get_option( 'ppwl_plugin_author' ) ? self::get_option( 'ppwl_plugin_author' ) : $all_plugins[ $pp_plugin_path ]['AuthorName'];

		if ( self::get_option( 'ppwl_hide_plugin' ) == 1 ) {
			unset( $all_plugins[ $pp_plugin_path ] );
		}

		return $all_plugins;
	}

	static public function get_support_link() {
		$support_link = self::get_option( 'ppwl_support_link' );
		$support_link = ! empty( $support_link ) ? $support_link : 'https://wpbeaveraddons.com/contact/';

		return $support_link;
	}

	static public function get_docs_link() {
		$docs_link = self::get_option( 'ppwl_docs_link' );
		$docs_link = ! empty( $docs_link ) ? $docs_link : 'https://wpbeaveraddons.com/docs/';

		return $docs_link;
	}

	/**
	* Fallback for license key option for multisite.
	*
	* @since 1.1.5
	* @access private
	* @return mixed
	*/
	static private function multisite_fallback() {
		if ( is_multisite() && is_network_admin() ) {

			$license_key    = get_option( 'bb_powerpack_license_key' );
			$license_status = get_option( 'bb_powerpack_license_status' );

			if ( ! empty( $license_key ) ) {
				self::update_option( 'bb_powerpack_license_key', $license_key );
			}
			if ( ! empty( $license_status ) ) {
				self::update_option( 'bb_powerpack_license_status', $license_status );
			}
		}
	}
}

BB_PowerPack_Admin_Settings::init();
