<?php
/**
* contacto.php
* @package WordPress
* @subpackage webmoderna
* @since webmoderna 3.0
* Text Domain: webmoderna
* Template Name: Contacto Platzi
*/
require "includes/form-recaptcha/enviar.php";

// Encabezado normal de la página
get_header();
// $errors = ['name_error', 'telefono_error', 'email_error', 'message_error' ];
?>
		<!-- Todo la parte central -->
		<div class="content con_barra">
			<main>
				<!-- La Página en si -->
				<section class="page">
					<article class="page__article">
						<header class="page__article__header">
							<h1 class="page__article__header__title">
								<?php the_title();?>
							</h1>
						</header>

						<?php rewind_posts(); if ( have_posts() ) : while ( have_posts() ) : the_post();?>

						<div class="page__article__content">
							<div class="respuesta"><?php if(isset($alerta)) echo $alerta;?></div>
							<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);?>" id="contact_form" accept-charset="utf-8" method="post">

								<input type="hidden" name="csrf" value="<?php echo $_SESSION["token"]; ?>">

								<!-- El nombre y su mensaje de control -->
								<div class="resultado"><?php // if(isset($_POST[ 'nombre' ])) echo $errors['name_error'];?></div>
								<input type="text" name="nombre" maxlength="50" placeholder="Nombre completo" value="<?php if(isset($_POST[ 'nombre' ])) echo htmlspecialchars($_POST[ 'nombre' ]);?>" />

								<!-- El teléfono y mensaje de error -->
								<div class="resultado"><?php // if(isset($_POST[ 'telefono' ])) echo $errors['telefono_error'];?></div>
								<input type="tel" name="telefono" maxlength="13" placeholder="Telefono de contacto" value="<?php if(isset($_POST[ 'telefono' ])) echo htmlspecialchars($_POST[ 'telefono' ]);?>" />

								<!-- El mail y mensaje de error -->
								<div class="resultado"><?php // if(isset($_POST[ 'correo' ])) echo $errors['email_error'];?></div>
								<input type="email" name="correo" maxlength="40" placeholder="Correo de contacto" value="<?php if(isset($_POST[ 'correo' ])) echo htmlspecialchars($_POST[ 'correo' ]);?>" />

								<!-- El mensaje y el error -->
								<div class="resultado"><?php // if( isset( $_POST['mensaje'] ) ) echo $errors['message_error'];?></div>
								<textarea maxlength="1000" name="mensaje" placeholder="Mensaje..." ><?php if(isset($_POST['mensaje'])) echo htmlspecialchars($_POST['mensaje']);?></textarea>
								<br />

								<!-- El google reCaptcha -->
								<div class="verificacion">
									<div class="respuesta"><?php if(isset($captcha_error)) echo $captcha_error;?></div>
									<div class="g-recaptcha" data-sitekey="<?php echo $yourpublickey;?>"></div>
								</div>

								<!-- Botón de enviar y reset -->
								<div class="alineacion__izquierda">
									<button type="submit">
										<span class="icon-check-alt icon-right"></span>
										<?php _e('Enviar', 'webmoderna');?>
									</button>
									<button type="reset">
										<span class="icon-x-altx-alt icon-right"></span>
										<?php _e('Limpiar', 'webmoderna');?>
									</button>
								</div>
							</form>

						<!-- Script para el reCaptcha 
						<script defer async type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>-->
						</div>

						<?php endwhile; else : ?>
							<div class="page__article__content">
								<?php _e('No hay nada publicado.', 'webmoderna');?>
							</div>
						<?php endif; ?>

					</article>
				</section>
			</main>
		</div>

<?php get_sidebar();?>
		<div class="separador"></div>
<?php get_footer();?>
