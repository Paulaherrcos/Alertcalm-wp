<?php
// Carga el encabezado del sitio (header.php)
get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">

        <!-- Encabezado del error 404 -->
        <header class="page-header">
            <h1 class="page-title">
                <?php esc_html_e( 'Oops! Página no encontrada.', 'alertcalm' ); ?>
            </h1>
        </header>

        <!-- Contenido de la página 404 -->
        <div class="page-content">
            <p>
                <?php esc_html_e( 'Parece que esta página no existe. Prueba con una búsqueda.', 'alertcalm' ); ?>
            </p>

            <!-- Formulario-->
            <?php get_search_form(); ?>
        </div>

    </section>
</main>

<?php
// Carga el pie de página del sitio (footer.php)
get_footer();
?>
