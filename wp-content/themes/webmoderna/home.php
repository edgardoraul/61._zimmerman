<?php
/**
* header.php
* @package WordPress
* @subpackage webmoderna
* @since webmoderna 3.0
* Text Domain: webmoderna
*/
?>

<?php get_header();

?>

		<!-- El Slider -->
		<div class="slider slider__home animated fadeInUpBig">
			<div id="owl-dos" class="owl-carousel">
		<?php

		// WP_Query arguments
		$args = array (
			'post_type'              => array( 'Sliders' ),
			'order'                  => 'ASC',
			'orderby'                => 'menu_order',
		);

		// The Query
		$sliders_home = new WP_Query( $args );

		// The Loop
		if ( $sliders_home->have_posts() )
		{
			while ( $sliders_home->have_posts() )
			{
				$sliders_home->the_post();?>

				<div class="slider__item">
					<figure>
						<?php
						$optional_size	= 'custom-thumb-600-250';
						$optional_size2	= 'custom-thumb-2400-1000';
						$img_id			= get_post_thumbnail_id( $post->ID );
						$image			= wp_get_attachment_image_src( $img_id, $optional_size );
						$image2			= wp_get_attachment_image_src( $img_id, $optional_size2 );
						$alt_text		= get_post_meta( $img_id , '_wp_attachment_image_alt', true );
						$perm			= get_permalink ($post->ID );
						if ( $image )
						{
							if ( wpmd_is_notphone() )
							{
								echo '<img src="#" data-src="' . $image2[0] . '" class="lazyOwl" alt="' . $alt_text . '" />';
							}
							else
							{
								echo '<img src="#" data-src="' . $image[0] . '" class="lazyOwl" alt="' . $alt_text . '" />';
							}
						}
						;?>
					</figure>
					<div class="slider__home__leyenda gradient">
						<?php echo titulo_corto('...', 50);?>
					</div>
				</div>

			<?php	;}
			} else { ?>

				<div class="slider__item">
					<figure>
						<img class="lazyOwl" src="<?php bloginfo('stylesheet_directory');?>/img/slide-2.jpg" alt="imagen" />
					</figure>
					<div class="slider__home__leyenda gradient">
						Algo para decir
					</div>
				</div>
				<div class="slider__item">
					<figure>
						<img class="lazyOwl" src="<?php bloginfo('stylesheet_directory');?>/img/slide-3.jpg" alt="imagen" />
					</figure>
					<div class="slider__home__leyenda gradient">
						Algo para decir
					</div>
				</div>

		<?php	}

		// Restore original Post Data
		wp_reset_postdata();?>

			</div>
		</div>
<?php //};?>
		<!-- Fin del Slider -->

		<!-- El englobador -->
		<div class="englobador">

		<!-- Contenido Centrales -->
		<section class="centrales">
		<?php centralCarteles(); ?>
		</section>

		<div class="clearboth"></div>

		<!-- La parte principal de la web -->
		<div class="content">
			<main>
				<!-- Los Artículos Cruzados -->
				<section class="cruzados">
				</section>
			</main>
		</div>

		<!-- La barra Lateral -->
		<?php //get_sidebar();?>

		<!-- El Slider -->
		<div class="slider animated fadeInDownBig">
		<?php // Variables
		$portfolio_home = of_get_option('portfolio_home','');
		$contenido_portfolio_home = of_get_option('contenido_portfolio_home',''); ?>
			<aside>
				<header class="slider__header">
					<h2 class="slider__header__title">
						<?php if ( $portfolio_home )
						{
							echo $portfolio_home;
						}
						else
						{
							echo 'Titular ejemplo...';
						}?>
					</h2>
					<blockquote>
						<?php if ( $contenido_portfolio_home )
						{
							echo $contenido_portfolio_home;
						}
						else
						{
							echo 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente sunt non expedita asperiores? Maiores corporis iure, ipsam.';
						}?>
					</blockquote>
				</header>
			    <div id="owl-uno" class="owl-carousel slider__secundario">
		<?php
		// ========================== El loop del slider ========================

		// WP_Query arguments
		$args = array (
			'post_type'              => array( 'post' ),
			'category_name'          => 'portafolio',
			'nopaging'               => false,
			'posts_per_page'         => '10',
			'orderby'                => 'rand',
		);

		// The Query
		$portafolio = new WP_Query( $args );

		// The Loop
		if ( $portafolio->have_posts() )
		{
			while ( $portafolio->have_posts() )
			{
				$portafolio->the_post();?>
					<div class="slider__item">
						<figure>
							<a class="gradient" href="<?php the_permalink();?>">
							<?php
								$optional_size	= 'custom-thumb-300-300';
								$img_id			= get_post_thumbnail_id( $post->ID );
								$image			= wp_get_attachment_image_src( $img_id, $optional_size );
								$alt_text		= get_post_meta( $img_id , '_wp_attachment_image_alt', true );
								$perm			= get_permalink ($post->ID );
								if ( $image )
								{
									echo '<img src="#" data-src="' . $image[0] . '" class="lazyOwl" alt="' . $alt_text . '" />';
								}
								else
								{
									echo '<img src="' . get_stylesheet_directory_uri() . '/img/client.jpg" alt="imagen" />';
								}
							;?>
							</a>
							<figcaption><?php echo titulo_corto('...', 40);?></figcaption>
						</figure>
					</div>

				<?php	}
				} else { ?>

					<div class="slider__item">
						<figure>
							<a class="gradient" href="single.html">
								<img src="<?php bloginfo('stylesheet_directory');?>/img/client.jpg" alt="imagen" />
							</a>
							<figcaption>Cliente</figcaption>
						</figure>
					</div>
					<div class="slider__item">
						<figure>
							<a class="gradient" href="single.html">
								<img src="<?php bloginfo('stylesheet_directory');?>/img/client.jpg" alt="imagen" />
							</a>
							<figcaption>Cliente</figcaption>
						</figure>
					</div>
					<div class="slider__item">
						<figure>
							<a class="gradient" href="single.html">
								<img src="<?php bloginfo('stylesheet_directory');?>/img/client.jpg" alt="imagen" />
							</a>
							<figcaption>Cliente</figcaption>
						</figure>
					</div>
					<div class="slider__item">
						<figure>
							<a class="gradient" href="single.html">
								<img src="<?php bloginfo('stylesheet_directory');?>/img/client.jpg" alt="imagen" />
							</a>
							<figcaption>Cliente</figcaption>
						</figure>
					</div>
					<div class="slider__item">
						<figure>
							<a class="gradient" href="single.html">
								<img src="<?php bloginfo('stylesheet_directory');?>/img/client.jpg" alt="imagen" />
							</a>
							<figcaption>Cliente</figcaption>
						</figure>
					</div>
					<div class="slider__item">
						<figure>
							<a class="gradient" href="single.html">
								<img src="<?php bloginfo('stylesheet_directory');?>/img/client.jpg" alt="imagen" />
							</a>
							<figcaption>Cliente</figcaption>
						</figure>
					</div>
					<?php	}
				// Restore original Post Data
				wp_reset_postdata();?>
				</div>
			</aside>
		</div>
<?php get_footer();?>
