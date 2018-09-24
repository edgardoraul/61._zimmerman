<?php // Las migajas de pan cordero, chicharrón y un poco de casero

function the_breadcrums()
{
// Defino la ubicación como una variable; así la puedo cargar en la función del breadcrums.
	// $ubicacion = __('Ud. está aquí: ', 'webmoderna');
	echo '<div class="breadcrums"><ul class="breadcrums__list" itemscope itemtype="http://schema.org/BreadcrumbList">';
	if ( !is_home() )
	{
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrums__list__item">' . __('Tu estás aquí: ', 'webmoderna') . '</li>';
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrums__list__item"><a itemprop="item" href="' . get_option('home') . '">' . __('Inicio', 'webmoderna') . '</a></li>';

		if ( is_category() )
		{
			echo single_cat_title( '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"  class="breadcrums__list__item">', true, '</li>' );
		};

		if ( is_tag() )
		{
			echo single_tag_title( '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"  class="breadcrums__list__item">', true, '</li>' );
		};

		if ( is_single() )
		{
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"  class="breadcrums__list__item">';
			the_category('</li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">', 'single', false);
			echo '</li>';
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"  class="breadcrums__list__item">';
			echo the_title();
			echo '</li>';
		};

		if ( is_page() )
		{
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"  class="breadcrums__list__item">';
			echo the_title();
			echo '</li>';
		};
	};
echo '</ul></div>';
};

;?>