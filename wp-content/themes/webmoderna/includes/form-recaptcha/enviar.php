<?php
session_destroy();
session_start();

$_SESSION["token"] = md5(uniqid(mt_rand(), true));

require "config.php";

ini_set( 'display_errors', 1 );  error_reporting( E_ALL );

if( !empty( $_POST["csrf"] ) && !empty( $_POST[ "csrf" ] ) == $_SESSION[ "token" ] )
{
	$userIP 			= $_SERVER["REMOTE_ADDR"];
	$recaptchaResponse 	= $_POST['g-recaptcha-response'];
	$secretKey 			= $yoursecretkey;
	$request 			= file_get_contents(	"https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}"	);

	if(	!strstr( $request, "true" ) )
	{
		// echo '<script>alert("Hay un problema! por favor completa correctamente el captcha...");</script>';
		$captcha_error = '<span class="respuesta--mal">' . __('Te faltó marcar que no eres un robot, o falló la comprobación', 'webmoderna') . '</span>';

		// Nombre corto y error
		if ( strlen( $_POST[ 'nombre' ] ) < 3 )
		{
			$errors['name_error'] = '<span class="respuesta--mal">'.__('Debes completar tu nombre y apellido', 'webmoderna').'</span>';
		}

		// Teléfono corto y error
		if ( strlen( $_POST[ 'telefono' ] ) < 8 )
		{
			$errors['telefono_error'] = '<span class="respuesta--mal">'.__('Debes completar tu teléfono.', 'webmoderna').'</span>';
		}

		// Campo de email vacío
		if ( strlen( $_POST['correo'] ) == 0 )
		{
			$errors['email_error'] = '<span class="respuesta--mal">'.__('Debes completar tu dirección de correo eletrónico', 'webmoderna').'</span>';
		}
		if ( !preg_match( '/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $_POST['correo'] ) )
		{
			// Formato de email inválido
			$errors['email_error'] = '<span class="respuesta--mal">'.__('La dirección de correo electrónico es inválida.', 'webmoderna').'</span>';
		}

		// Mensaje demasiado corto
		if ( strlen( $_POST['mensaje'] ) <= 20 )
		{
			$errors['message_error'] = '<span class="respuesta--mal">'.__('Tienes que ingresar un mensaje.', 'webmoderna').'</span>';
		}
	}



	else
	{
		if( isset( $_POST[ 'nombre' ] ) && isset( $_POST[ 'correo' ] ) && isset( $_POST[ 'telefono' ] ) ) 
		{
			$message =
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<!-- UTF-8 Charset -->
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>Formulario de Contacto</title>

				<!-- Responsive Viewport -->
				<meta name="viewport" content="width=device-width, initial-scale=1.0" />

				<!-- Prevent IE/Windows Phone QuirksMode -->
				<!-- Soluciona la ausencia de Media Queries en Windows Phone -->
				<meta http-equiv="X-UA-Compatible" content="IE=edge" />

				<!-- Prevent devices to change telephone styles -->
				<meta name="format-detection" content="telephone=no" />
				<style type="text/css">
					#outlook a{
						padding:3px;
					}
					<!-- Live.com & Outlook.com -->
					.ReadMsgBody{
						width:100%;
					}
					.ExternalClass{
						width:100%;
					}
					.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
						line-height:100%;
					}

					body,table,td,p,a,li,blockquote{
						-webkit-text-size-adjust:100%;
						-ms-text-size-adjust:100%;
						padding: 5px;
					}
					table td{
						border-collapse:collapse !important;
					}
					table,td{
						mso-table-lspace:0pt;
						mso-table-rspace:0pt;
					}
					p{
						margin:5px;
						padding:5px;
					}
					<!-- https://css-tricks.com/ie-fix-bicubic-scaling-for-images/ -->
					img{
						-ms-interpolation-mode:bicubic;
					}
					* {
						font-family: Helvetica, Verdana, Arial, serif;
						font-size: 20px;
						font-color: #0B060C;
					}
				</style>
			</head>
			<body>
			<h1 align="center"><img alt="'.get_bloginfo("name").'" src="'.$logo_uploader.'" width="100%" style="max-width:500px" />
			</h1>
			<p><strong>Nombre:</strong> ' . $_POST['nombre'] . '</p>
			<p><strong>Telefono:</strong>  ' . $_POST['telefono'] . '</p>
			<p><strong>Correo:</strong>  ' . $_POST['correo'] . '</p>
			<p><strong>Mensaje:</strong>   ' . $_POST['mensaje'] . ' </p><hr />
			<p><strong>Datos de envio</strong>:</p>
			<p><strong>Enviado desde:</strong> ' . $_SERVER['HTTP_HOST'] . ' </p>
			<p><strong>IP:</strong> ' . $userIP . '</p></body></html>
			';
			require "mailer/class.phpmailer.php";
			$mail = new PHPMailer();  
			$mail->IsSMTP();
			$mail->SMTPAuth 		= true;
			$mail->SMTPSecure 		= "tls";
			$mail->Host 			= $host;
			$mail->Port 			= 587;
			$mail->Encoding 		= '7bit';
			$mail->CharSet 			= 'UTF-8';
			$mail->Username   		= $senderEmail;
			$mail->Password   		= $senderPassword;
			$mail->SetFrom( $_POST[ 'correo' ], $_POST[ 'nombre' ] );
			$mail->AddReplyTo( $_POST[ 'correo' ], $_POST[ 'nombre'] );
			$mail->Subject 			= __("Consulta Web | ", "webmoderna") . get_bloginfo('name'); 
			$mail->MsgHTML( $message );
			$mail->AddAddress( "$receiver", $receiverName );
			$result 				= $mail->Send();
			// $alerta 				= $result ? '<script>alert("Hemos recibido tu mensaje, nos pondremos en contacto contigo a la brevedad posible.");</script>' : '<script>alert("Hubo un error y no hemos podido entregar tu mensaje, vuelve a intentarlo.");</script>';
			$alerta 				= $result ? '<span class="respuesta--ok">' . __('Formulario enviado exitosamente :-D', 'webmoderna') . '</span>' : '<span class="respuesta--error">' . __('Hubo un error al enviar el mensaje :-(', 'webmoderna') . '</span>';
			session_destroy();
			unset( $mail );
		}
	}
}
?>
