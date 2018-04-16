<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */

get_header(); ?>

			<h1 class="page-title"><?php printf( esc_attr__( 'Search Results for: %s', 'storefront' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

		<?php if ( have_posts() ) : ?>

			<?php
	while ( have_posts() ) : the_post();

		/**
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		//get_template_part( 'content', get_post_format() );

	endwhile;

		else :

			?>
			<p>No tenemos productos relacionados con la búsqueda, por favor, introduzca otro producto</p>
			<?php

		endif; ?>

<?php
get_footer();
