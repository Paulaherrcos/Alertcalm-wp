<?php
get_header(); // cabecera

if ( have_posts() ) : ?>

    <div class="archive-posts">
        <?php
        // Bucle para mostrar los posts
        while ( have_posts() ) : the_post(); ?>

            <article class="post-item">
                <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="post-excerpt"><?php the_excerpt(); ?></div>
            </article>

        <?php endwhile; ?>
    </div>

    <?php
    // Navegación entre las páginas de archivo
    the_posts_navigation();

else : ?>

    <p><?php esc_html_e( 'No se encontraron publicaciones.', 'alertcalm' ); ?></p>

<?php endif;

get_footer();
