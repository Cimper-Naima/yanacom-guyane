<?php
$current_url 			= remove_query_arg( 'fake_arg' );
$redirect_url 			= $current_url;
$logout_redirect_url 	= $current_url;
$show_label				= 'yes' == $settings->show_labels;
$show_lost_password		= 'yes' == $settings->show_lost_password;
$show_register 			= 'yes' == $settings->show_register && get_option( 'users_can_register' );
$is_logged_in			= is_user_logged_in();
$is_builder_active		= FLBuilderModel::is_builder_active();

if ( 'yes' == $settings->redirect_after_login && ! empty( $settings->redirect_url ) ) {
	$redirect_url = $settings->redirect_url;
}
if ( 'yes' == $settings->redirect_after_logout && ! empty( $settings->redirect_logout_url ) ) {
	$logout_redirect_url = $settings->redirect_logout_url;
}

?>
<div class="pp-login-form-wrap">
	<?php if ( $is_logged_in && ! $is_builder_active ) {
		if ( 'yes' == $settings->show_logged_in_message ) { $current_user = wp_get_current_user(); ?>
			<div class="pp-login-message">
				<?php
				// translators: Here %1$s is for current user's display name and %2$s is for logout URL.
				$msg = sprintf( __( 'You are Logged in as %1$s (<a href="%2$s">Logout</a>)', 'bb-powerpack' ), $current_user->display_name, wp_logout_url( $logout_redirect_url ) );
				echo apply_filters( 'pp_login_form_logged_in_message', $msg, $current_user->display_name, wp_logout_url( $logout_redirect_url ) );
				?>
			</div>
		<?php }
	} ?>
	<?php if ( ! $is_logged_in || $is_builder_active ) { ?>
	<form class="pp-login-form" method="post" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>">
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_url ); ?>">
		<div class="pp-login-form-fields">
			<div class="pp-login-form-field pp-field-group pp-field-type-text">
				<?php if ( $show_label ) { ?>
				<label for="user"><?php echo $settings->username_label; ?></label>
				<?php } ?>
				<input size="1" type="text" name="log" id="user" placeholder="<?php echo $settings->username_placeholder; ?>" class="pp-login-form--input" />
			</div>

			<div class="pp-login-form-field pp-field-group pp-field-type-text">
				<?php if ( $show_label ) { ?>
				<label for="password"><?php echo $settings->password_label; ?></label>
				<?php } ?>
				<input size="1" type="password" name="pwd" id="password" placeholder="<?php echo $settings->password_placeholder; ?>" class="pp-login-form--input" />
			</div>

			<?php if ( 'yes' == $settings->show_remember_me ) { ?>
			<div class="pp-login-form-field pp-field-group pp-field-type-checkbox">
				<label for="pp-login-remember-me">
					<input type="checkbox" name="rememberme" id="pp-login-remember-me" class="pp-login-form--checkbox" />
					<span class="pp-login-remember-me"><?php echo ! empty( $settings->remember_me_text ) ? $settings->remember_me_text : __( 'Remember Me', 'bb-powerpack' ); ?></span>
				</label>
			</div>
			<?php } ?>

			<div class="pp-field-group pp-field-type-submit">
				<button type="submit" name="wp-submit" class="pp-login-form--button">
					<span class="pp-login-form--button-text"><?php echo $settings->button_text; ?></span>
				</button>
			</div>

			<?php if ( $show_lost_password || $show_register ) { ?>
			<div class="pp-field-group pp-field-type-link">
				<?php if ( $show_lost_password ) { ?>
					<a class="pp-login-lost-password" href="<?php echo wp_lostpassword_url( $redirect_url ); ?>">
						<?php echo ! empty( $settings->lost_password_text ) ? $settings->lost_password_text : __( 'Lost your password?', 'bb-powerpack' ); ?>
					</a>
				<?php } ?>
				<?php if ( $show_register ) { ?>
					<?php if ( $show_lost_password ) { ?>
						<span class="pp-login-separator"> | </span>
					<?php } ?>
					<a class="pp-login-register" href="<?php echo wp_registration_url(); ?>">
						<?php _e( 'Register', 'bb-powerpack' ); ?>
					</a>
				<?php } ?>
			</div>
			<?php } ?>

		</div>
	</form>
	<?php } ?>
</div>