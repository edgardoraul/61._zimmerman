<?php 
// Los carteles centrales
function centralCarteles()
{
		// El enlazador
		$webmoderna_select	= rwmb_meta('webmoderna_select', '');


		// Reemplazando con un loop especial
		$args = array (
			'post_type'	=>	array( 'carteles_post_type' ),
			'order'		=>	'ASC',
			'orderby'	=>	'menu_order',
		);
		// The Query
		$carteles_home = new WP_Query( $args );

		// The Loop
		if ( $carteles_home->have_posts() )
		{
			while ( $carteles_home->have_posts() )
			{
				$carteles_home->the_post();?>

			<article class="centrales__article">
				<figure class="centrales__article__figure">
					<header class="centrales__article__header">
						<h2 class="centrales__article__header__title">
							<?php echo titulo_corto('...', 50);?>
						</h2>
					</header>
					<?php the_post_thumbnail('custom-thumb-300-300');?>
				</figure>
				<div class="centrales__article__content">
					<?php the_content(); echo $webmoderna_select;?>
				</div>
			</article>

			<?php };
		};
		// Restore original Post Data
		wp_reset_postdata();
}

?>