<?php
/**
* footer.php
* @package WordPress
* @subpackage webmoderna
* @since webmoderna 2.0
* Text Domain: webmoderna
*/

// Variables a utilizar
$google_plus_contact	=	of_get_option( 'google_plus_contact', '' );
$facebook_contact		=	of_get_option( 'facebook_contact', '' );
$twitter_contact		=	of_get_option( 'twitter_contact', '' );
$linkedin_contact		=	of_get_option( 'linkedin_contact', '' );
$github_contact			=	of_get_option( 'github_contact', '' );
$add_this_script		=	of_get_option( 'add_this_script', '');
$google_analitycs		=	of_get_option( 'google_analitycs', '');

// Acá van las cuatro sidebar del footer.
$skype_contact		=	of_get_option( 'skype_contact', '');
$telefono_fijo		=	of_get_option( 'telefono_fijo', '' );
$telefono_celular	=	of_get_option( 'telefono_celular', '' );
$direccion_web		=	of_get_option( 'direccion_web', '' );
$localidad_web		=	of_get_option( 'localidad_web', '' );
$departamento_web	=	of_get_option( 'departamento_web', '' );
$provincia_web		=	of_get_option( 'provincia_web', '' );
$codigopostal_web	=	of_get_option( 'codigopostal_web', '' );
$pais_web			=	of_get_option( 'pais_web', '' );
$email_contact		=	of_get_option( 'email_contact', '' );
?>

			</div><!-- Fin del englobador -->
		</div>

		<!-- El footer de la página -->
		<footer class="footer">
			<!-- Redes sociales -->
			<div class="footer__redes_sociales">
				<ul class="footer__redes_sociales__list">
					<?php if ( $google_plus_contact )
					{
						echo '<li class="footer__redes_sociales__list__item"><a target="_blank" class="icon-google-plus" href="//' . $google_plus_contact . '" title="Google+"></a></li>';
					};
					if ( $facebook_contact )
					{
						echo '<li class="footer__redes_sociales__list__item"><a target="_blank" class="icon-facebook" href="' . $facebook_contact . '" title="Facebook"></a></li>';
					};
					if ( $twitter_contact )
					{
						echo '<li class="footer__redes_sociales__list__item"><a target="_blank" class="icon-twitter" href="//' . $twitter_contact . '" title="Twitter"></a></li>';
					};
					if ( $github_contact )
					{
						echo '<li class="footer__redes_sociales__list__item"><a target="_blank" class="icon-github" href="//' . $github_contact . '" title="GitHub"></a></li>';
					};?>

					<!-- <li class="footer__redes_sociales__list__item">
						<a href="<?php //bloginfo('rss2_url');?>" title="RSS" class="icon-rss"></a>
					</li> -->
				</ul>
			</div>

			<!-- Los datos de contacto -->
			<div itemscope itemtype="http://schema.org/LocalBusiness">
				<p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><?php if ( $direccion_web )
					{
						echo '<span itemprop="streetAddress">' . $direccion_web . '</span>';
						echo ' - <span itemprop="addressLocality">' . $localidad_web . '</span>';
						echo ' - <span itemprop="postalCode">CP: ' . $codigopostal_web . '</span>';
						echo ' - <span itemprop="addressRegion">' . $departamento_web . '</span>';
						echo ' - <span itemprop="addressRegion">' . $provincia_web . '</span>';
						echo ' - <span itemprop="addressCountry">' . $pais_web . '</span>';
					};
					if ( $telefono_fijo )
					{
						echo "<br /><span class='icon-phone'> </span>";
						echo '<span itemprop="telephone">' . $telefono_fijo . '</span>';
					};
					if ( $email_contact )
					{
						echo " - <span class='icon-mail2'> </span>";
						echo '<span itemprop="email">' . $email_contact . '</span>';
					}
					?>
				</p>
			</div>

			<!-- Derechos de copia -->
			<div class="footer__copyright">
				<p itemprop="name">&copy; <?php echo date("Y ");bloginfo("name"); ?> - <?php _e('Todos los derechos reservados', 'webmoderna');?></p>
			</div>

			<!-- Ir hacia arriba -->
			<div id="ir_arriba" class="gotop">
				<a href="#" class="icon-arrow-up icon-right" title="<?php _e('Ir hacia arriba', 'webmoderna');?>"></a>
			</div>
		</footer>

	<!--<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.min.js"></script>-->
	<!--<script type="text/javascript" defer src="//code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>-->
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" defer src="<?php bloginfo('stylesheet_directory');?>/js/jquery-1.12.4.min.js"><\/script>')</script>
	<script type="text/javascript" defer src="<?php bloginfo('stylesheet_directory');?>/js/scripts.min.js"></script>
	<?php

	// El script para compartir
	if ( $add_this_script )
	{
		// echo '<script type="text/javascript" async defer src="' . $add_this_script . '"></script>';
	};

	// El google Analitics
	if ( $google_analitycs )
	{
		// echo '<script type="text/javascript">' . $google_analitycs . '</script>';
	};
	wp_footer();?>
	<!--<script async defer src='https://www.google.com/recaptcha/api.js'></script>-->
</body>
</html>
