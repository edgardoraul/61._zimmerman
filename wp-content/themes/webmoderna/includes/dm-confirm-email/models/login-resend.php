<?php
class DmConfirmEmail_Models_ResendEmailConfirmForm
{
	function __construct()
	{
		add_action('login_form_resendec', array($this, 'formResendEmailConfirm'));
	}

	/**
	 * Error checking
	 */
	private function formCheckErrors()
	{
		$errors = new WP_Error();

		if( empty( $_POST['user_login'] ) )
		{
			$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Ingresá una dirección de correo electrónico.', 'emyth' ) );
		}
		elseif( strpos( $_POST['user_login'], '@' ) )
		{
			$user = $this->resendConfirmationLink($_POST['user_login']);
			if( $user == false )
			{
				$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: Correo electrónico no existe.', 'emyth' ) );
			}
		}
		else
		{
			$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Correo electrónico inválido.', 'emyth' ) );
		}

		// If there are errors
		if ( $errors->get_error_code() )
			return $errors;

		return true;
	}

	/**
	 * Check if email exists
	 * @param string $email
	 * @return object|null
	 */
	private function confirmEmail($email)
	{
		global $wpdb;

		$result = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}" . DmConfirmEmail::PLUGIN_ALIAS . " WHERE user_email = %s",
				$email
			)
		);

		return $result;
	}

	/**
	 * Resend confirmation link
	 * @param string $email
	 * @return bool
	 */
	private function resendConfirmationLink( $email )
	{
		$sanitizedEmail = sanitize_email( $email );

		// Confirm email
		$user = $this->confirmEmail( $sanitizedEmail );

		// Check if email exist
		if( $user == null )
			return false;

		// Set data
		$options = get_option( DmConfirmEmail::PLUGIN_ALIAS );
		$send = new DmConfirmEmail_Models_Registration( $user->user_login, $user->user_email );
		$send->setUserKey( $user->user_key );
		// Send the confirmation
		$send->sendEmail( $options['email_subject'], $options['email_text'], $options['email_ishtml'] );

		return true;
	}

	/**
	 * Resend email confirmation link
	 */
	public function formResendEmailConfirm()
	{
		$errors = new WP_Error();
		$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
		if( $http_post )
		{
			$errors = $this->formCheckErrors();
			if ( !is_wp_error( $errors ) ) {
				$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
				wp_safe_redirect( $redirect_to );
				exit();
			}
		}

		login_header( __( 'Enviar de vuelta enlace de confirmación', 'emyth' ), '<p class="message">' . __( 'Porfavor, ingresá tu dirección de correo electrónico. Recibirás un enlace de confirmación en tu buzón de email.', 'emyth' ) . '</p>', $errors );
		?>
		<form name="resendec" id="resendec" action="<?php echo esc_url( site_url( 'wp-login.php?action=resendec', 'login_post' ) ); ?>" method="post">
			<p>
				<label for="user_login" ><?php _e( 'Correo electrónico', 'emyth' );?><br />
					<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(''); ?>" size="20" /></label>
			</p>
			<?php do_action('resendec_form'); ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( '' ); ?>" />
			<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Obtener enlace de confirmación', 'emyth');?>" /></p>
		</form>

		<p id="nav">
			<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e( 'Acceder', 'emyth' );?></a>
			<?php if ( get_option( 'users_can_register' ) ) : ?>
				| <?php echo apply_filters( 'register', sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Registrar', 'emyth' ) ) ); ?>
				| <a href="<?php echo site_url('wp-login.php?action=resendec'); ?>" title="<?php esc_attr_e( 'Enviar de vuelta enlace de confirmación', 'emyth' ); ?>"><?php _e( 'Enviar de vuelta enlace de confirmación', 'emyth' );?></a>
			<?php endif; ?>
		</p>
	<?php
		login_footer();
		exit();
	}
}