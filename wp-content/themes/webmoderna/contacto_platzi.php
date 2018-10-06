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
?>
		<!-- Todo la parte central -->
		<div class="content con_barra">
			<main>
				<?php if(isset($alerta)) echo $alerta;  ?>
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
							<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);?>" id="contact_form" accept-charset="utf-8" method="post">
								<input type="hidden" name="csrf" value="<?php echo $_SESSION["token"]; ?>">
								<input type="text" name="nombre" placeholder="Nombre completo" />
								<input type="tel" name="telefono" placeholder="Telefono de contacto" />
								<input type="email" name="correo" placeholder="Correo de contacto" />
								<textarea name="mensaje" placeholder="Mensaje..." ></textarea>
								<?php  echo '<div class="g-recaptcha" data-sitekey="' . $yourpublickey . '"></div>';?>
								<br />
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
						<script defer async type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
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
