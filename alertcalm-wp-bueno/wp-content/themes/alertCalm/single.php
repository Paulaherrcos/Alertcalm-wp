<?php
// Carga el header 
get_header();
?>

<main id="primary" class="site-main">

	<?php
	// Bucle que mostrará el contenido del post actual
	while ( have_posts() ) :
		the_post();
	?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>

		<?php
		// Navegación entre posts anteriores y siguientes
		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Anterior:', 'alertcalm' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Siguiente:', 'alertcalm' ) . '</span> <span class="nav-title">%title</span>',
			)
		);

		// Si los comentarios están abiertos o hay al menos uno, mostrará el formulario y comentarios
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // Fin del loop
	?>

</main>

<?php
// Carga el sidebar
get_sidebar();

// Carga el footer
get_footer();
?>
