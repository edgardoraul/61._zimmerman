<?php
/**
* page.php
* @package WordPress
* @subpackage webmoderna
* @since webmoderna 3.0
* Text Domain: webmoderna
*/

get_header();
?>
		<!-- para que ocupe todo el ancho -->
		<div class="encabezador">
			<header class="page__article__header page__background__ocupador">
				<h1 class="page__article__header__title">
					<?php the_title();?>
				</h1>
			</header>
			<?php 
				$optional_size	= 'custom-thumb-900-x';
				$optional_size2	= 'custom-thumb-1800-x';
				$img_id			= get_post_thumbnail_id( $post->ID );
				$image			= wp_get_attachment_image_src( $img_id, $optional_size );
				$image2			= wp_get_attachment_image_src( $img_id, $optional_size2 );
				echo '<style type="text/css">';
				if ( $image )
				{
					echo '.page__background__ocupador {
						background-image: url("' . $image[0] . '");
					}
					@media all and (min-width: 900px) {
						.page__background__ocupador {
						background-image: url("' . $image2[0] . '");
						}
					}
					';
				}
				else
				{
					echo '.page__background__ocupador {
						background-image: url("' . get_stylesheet_directory_uri() . '/img/p5.jpg");
					}';
				}
				echo '</style>';
			?>
		</div>
		<!-- Fin del para que ocupe todo el ancho -->

		<!-- Todo la parte central -->
		<div class="content con_barra animated fadeInLeftBig">
			<main>

				<!-- La Página en si -->
				<section class="page">
					<article class="page__article">

						<?php rewind_posts(); if ( have_posts() ) : while ( have_posts() ) : the_post();?>

						<div class="page__article__content">
							<!-- <figure class="page__article__figure">
								<?php /*
								$optional_size	= 'custom-thumb-400-300';
								$optional_size2	= 'custom-thumb-1800-x';
								$img_id			= get_post_thumbnail_id( $post->ID );
								$image			= wp_get_attachment_image_src( $img_id, $optional_size );
								$image2			= wp_get_attachment_image_src( $img_id, $optional_size2 );
								$alt_text		= get_post_meta( $img_id , '_wp_attachment_image_alt', true );
								$perm			= get_permalink ($post->ID );
								if ( $image )
								{
									echo '<a href="' . $image2[0] . '" class="swipebox" title="' . $alt_text . '">';
									// echo '<img src="' . $image[0] . '" alt="' . $alt_text . '" />';
									the_post_thumbnail('custom-thumb-400-300');
									echo '</a>';
									if ( $alt_text )
									{
										echo '<figcaption>' . $alt_text . '</figcaption>';
									}
								}
								else
								{
									echo '<img src="' . get_stylesheet_directory_uri() . '/img/p5.jpg" alt="imagen" /><figcaption>' . __('Contenido', 'webmoderna') . '</figcaption>';
								} */?>
							</figure> -->
							<div class="page__article__contenido">
								<?php the_content();?>
							</div>
							<div class="separador"></div>


							<!-- Un slider para lo producido -->
							<div id="owl-galeria" class="owl-carousel slider__secundario">
							<?php 

							$images = rwmb_meta( 'webmoderna_imagenes', 'size=custom-thumb-300-300' );

							if ( !empty( $images ) )
							{
								foreach ( $images as $image )
								{
									echo '<div class="slider__item">
											<figure>';
									echo "<a rel='index' class='gradient swipebox' href='{$image['custom-thumb-1200-x']}'>";
									echo "<img src='#' class='lazyOwl' data-src='{$image['url']}' alt='{$image['alt']}' />";
									echo '</a>';
									echo '</figure>
										</div>';
								}
							}?>
									
							</div>
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
