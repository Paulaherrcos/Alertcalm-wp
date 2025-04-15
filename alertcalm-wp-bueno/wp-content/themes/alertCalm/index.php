<?php
    get_header();
?>

<main id="primary" class="site-main">
    <?php
    // si hay post subido saca el titulo
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_title('<h2>', '</h2>');
            // para poder usar elementor
            the_content();
        endwhile;
    else :
        echo '<p>No hay contenido</p>';
    endif;
    ?>
</main>

<?php
get_sidebar();
get_footer();
