<?php
get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		// Muestra el contenido de la página o entrada
		the_content();

		// Muestra los comentarios si están activados
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>
</main>

<?php
get_sidebar();
get_footer();
