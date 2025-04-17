<?php
/**
 * Plugin Name: AlertCalm - crud
 * Description: Plugin para gestionar meditaciones y músicas desde el panel de WordPress.
 * Version: 1.0
 * Author: Paula Herrera
 */

function crear_tabla_musica_y_meditaciones() {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
    // Definir la estructura de la tabla
    $sql_musica = "CREATE TABLE $tabla_musica (
        id INT NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(255),
        categoria VARCHAR(255),
        file_url VARCHAR(255),
        duracion TIME,
        lenguaje VARCHAR(20),
        imagen_url VARCHAR(255),
        PRIMARY KEY (id)
    )";

    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $sql_meditaciones = "CREATE TABLE $tabla_meditaciones (
        id INT NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(255),
        categoria VARCHAR(255),
        file_url VARCHAR(255),
        duracion TIME,
        lenguaje VARCHAR(20),
        imagen_url VARCHAR(255),
        PRIMARY KEY (id)
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql_musica );
    dbDelta( $sql_meditaciones);
}
// Agregar la acción para crear la tabla de musica al activar el plugin
register_activation_hook( __FILE__, 'crear_tabla_musica_y_meditaciones' );

// Función para obtener una música por ID
function obtener_musica( $request ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
    $id = $request['id'];
    // Obtener la musica de la base de datos
    $musica = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $tabla_musica WHERE id = %d", $id ) );
    return $musica;
}

// Función para obtener una meditación por ID
function obtener_meditacion( $request ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $id = $request['id'];
    // Obtener la meditacion de la base de datos
    $meditacion = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $tabla_meditaciones WHERE id = %d", $id ) );
    return $meditacion;
}

// Función para listar todas las músicas con filtro por categorías
function listar_musicas_con_filtro( $categorias = '' ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';

    // Comienza la consulta SQL
    $sql = "SELECT * FROM $tabla_musica";

    // Si se pasa una categoría (o categorías), se filtra por ellas
    if ( ! empty( $categorias ) ) {
        // Divide las categorías en un array
        $categorias_array = array_map('trim', explode(',', $categorias));

        // Prepara placeholders para la consulta
        $placeholders = implode(',', array_fill(0, count($categorias_array), '%s'));

        // Añade la condición WHERE con IN para múltiples categorías
        $sql .= $wpdb->prepare( " WHERE categoria IN ($placeholders)", ...$categorias_array );
    }

    // Ejecuta la consulta y devuelve los resultados
    return $wpdb->get_results( $sql );
}


// Función para listar todas las meditaciones
function listar_meditaciones_con_filtro( $categoria = '' ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $sql = "SELECT * FROM $tabla_meditaciones";
    if ( ! empty( $categoria ) ) {
        $sql .= $wpdb->prepare( " WHERE categoria = %s", $categoria );
    }
    return $wpdb->get_results( $sql );
}

// Función para crear una música
function crear_musica( $request ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
    $musica = array(
        'titulo' => $request->get_param( 'titulo' ),
        'categoria' => $request->get_param( 'categoria' ),
        'file_url' => $request->get_param( 'file_url' ),
        'duracion' => $request->get_param( 'duracion' ),
        'lenguaje' => $request->get_param( 'lenguaje' ),
        'imagen_url' => $request->get_param( 'imagen_url' ),
    );
    // Insertar la música en la base de datos
    $wpdb->insert( $tabla_musica, $musica );
    // Devolver el ID de la nueva música
    return $wpdb->insert_id;
}

// Función para crear una meditación
function crear_meditacion( $request ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $meditacion = array(
        'titulo' => $request->get_param( 'titulo' ),
        'categoria' => $request->get_param( 'categoria' ),
        'file_url' => $request->get_param( 'file_url' ),
        'duracion' => $request->get_param( 'duracion' ),
        'lenguaje' => $request->get_param( 'lenguaje' ),
        'imagen_url' => $request->get_param( 'imagen_url' ),
    );
    // Insertar la meditacion en la base de datos
    $wpdb->insert( $tabla_meditaciones, $meditacion );
    // Devolver el ID de la nueva meditacion
    return $wpdb->insert_id;
}

// Función para actualizar una música por ID
function actualizar_musica( $request ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
    $id = $request['id'];
    $musica = array(
        'titulo' => $request->get_param( 'titulo' ),
        'categoria' => $request->get_param( 'categoria' ),
        'file_url' => $request->get_param( 'file_url' ),
        'duracion' => $request->get_param( 'duracion' ),
        'lenguaje' => $request->get_param( 'lenguaje' ),
        'imagen_url' => $request->get_param( 'imagen_url' ),
    );
    // Actualizar la música en la base de datos
    $wpdb->update( $tabla_musica, $musica, array( 'id' => $id ) );
    // Devolver la cantidad de filas afectadas
    return $wpdb->rows_affected;
}

// Función para actualizar una meditación por ID
function actualizar_meditacion( $request ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $id = $request['id'];
    $meditacion = array(
        'titulo' => $request->get_param( 'titulo' ),
        'categoria' => $request->get_param( 'categoria' ),
        'file_url' => $request->get_param( 'file_url' ),
        'duracion' => $request->get_param( 'duracion' ),
        'lenguaje' => $request->get_param( 'lenguaje' ),
        'imagen_url' => $request->get_param( 'imagen_url' ),
    );
    // Actualizar la meditación en la base de datos
    $wpdb->update( $tabla_meditaciones, $meditacion, array( 'id' => $id ) );
    // Devolver la cantidad de filas afectadas
    return $wpdb->rows_affected;
}

// Función para eliminar una música por ID
function eliminar_musica( $request ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
    $id = $request['id'];
    // Eliminar la música de la base de datos
    $wpdb->delete( $tabla_musica, array( 'id' => $id ) );
    // Devolver la cantidad de filas afectadas
    return $wpdb->rows_affected;
}

// Función para eliminar una meditación por ID
function eliminar_meditacion( $request ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $id = $request['id'];
    // Eliminar la meditación de la base de datos
    $wpdb->delete( $tabla_meditaciones, array( 'id' => $id ) );
    // Devolver la cantidad de filas afectadas
    return $wpdb->rows_affected;
}

// Funciones para listar todas las músicas y meditaciones
function listar_todas_musicas( $request ) {
    return listar_musicas_con_filtro();
}

function listar_todas_meditaciones( $request ) {
    return listar_meditaciones_con_filtro();
}

// Registrar los endpoints de la API REST
function registrar_endpoint_rest_musica_y_meditaciones() {
    // Rutas para la música
    register_rest_route( 'musica_meditaciones/v1', '/musica/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'obtener_musica',
        'args' => array(
            'id' => array(
                'validate_callback' => function( $param, $request, $key ) {
                    return is_numeric( $param );
                }
            ),
        ),
    ) );
    register_rest_route( 'musica_meditaciones/v1', '/musica', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'crear_musica',
    ) );
    register_rest_route( 'musica_meditaciones/v1', '/musica/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'actualizar_musica',
    ) );
    register_rest_route( 'musica_meditaciones/v1', '/musica/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'eliminar_musica',
    ) );

    // Rutas para las meditaciones
    register_rest_route( 'musica_meditaciones/v1', '/meditacion/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'obtener_meditacion',
        'args' => array(
            'id' => array(
                'validate_callback' => function( $param, $request, $key ) {
                    return is_numeric( $param );
                }
            ),
        ),
    ) );
    register_rest_route( 'musica_meditaciones/v1', '/meditacion', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'crear_meditacion',
    ) );
    register_rest_route( 'musica_meditaciones/v1', '/meditacion/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'actualizar_meditacion',
    ) );
    register_rest_route( 'musica_meditaciones/v1', '/meditacion/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'eliminar_meditacion',
    ) );
    
    // Listar todas las músicas
    register_rest_route( 'musica_meditaciones/v1', '/musicas', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'listar_todas_musicas',
    ) );

    // Listar todas las meditaciones
    register_rest_route( 'musica_meditaciones/v1', '/meditaciones', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'listar_todas_meditaciones',
    ) );
}
add_action( 'rest_api_init', 'registrar_endpoint_rest_musica_y_meditaciones' );

// Shortcode para mostrar las músicas
function shortcode_listar_musicas( $atts ) {
    $atts = shortcode_atts( array(
        'categoria' => '',  // Por defecto no se filtra por categoría
    ), $atts, 'listar_musicas' );
    
    // Verificar si se pasa el parámetro categoria
    error_log("Categoria en Shortcode Musicas: " . $atts['categoria']);

    // Obtener las músicas filtradas por la categoría proporcionada
    $musicas = listar_musicas_con_filtro( $atts['categoria'] );

    if (empty($musicas)) return '<p>No hay músicas disponibles.</p>';

    // Iniciar el HTML para las tarjetas
    $html = '<h3>Lista de Músicas</h3><div class="musica-cards-container">';

    foreach ($musicas as $musica) {
        $html .= "
            <div class='musica-card'>
                <h4>{$musica->titulo}</h4>
                <p><img src='{$musica->imagen_url}' alt='Imagen de {$musica->titulo}'></p>
                <p><strong>Categoría:</strong> {$musica->categoria}</p>
                <p><strong>Duración:</strong> {$musica->duracion}</p>
                <p><strong>Lenguaje:</strong> {$musica->lenguaje}</p>
                <a href='{$musica->file_url}' target='_blank' class='btn-escuchar'>Escuchar</a>
            </div>
        ";
    }
    
    $html .= '</div>';
    return $html;
}
add_shortcode('listar_musicas', 'shortcode_listar_musicas');

// Shortcode para mostrar las meditaciones
function shortcode_listar_meditaciones( $atts ) {
    $atts = shortcode_atts( array(
        'categoria' => '',  // Por defecto no se filtra por categoría
    ), $atts, 'listar_meditaciones' );

    // Obtener las meditaciones filtradas por la categoría proporcionada
    $meditaciones = listar_meditaciones_con_filtro( $atts['categoria'] );

    if (empty($meditaciones)) return '<p>No hay meditaciones disponibles.</p>';

    // Iniciar el HTML para las tarjetas
    $html = '<h3>Lista de Meditaciones</h3><div class="meditacion-cards-container">';

    foreach ($meditaciones as $meditacion) {
        $html .= "
            <div class='meditacion-card'>
                <h4>{$meditacion->titulo}</h4>
                <p><img src='{$meditacion->imagen_url}' alt='Imagen de {$meditacion->titulo}'></p>
                <p><strong>Categoría:</strong> {$meditacion->categoria}</p>
                <p><strong>Duración:</strong> {$meditacion->duracion}</p>
                <p><strong>Lenguaje:</strong> {$meditacion->lenguaje}</p>
                <a href='{$meditacion->file_url}' target='_blank' class='btn-escuchar'>Escuchar</a>
            </div>
        ";
    }
    
    $html .= '</div>';
    return $html;
}
add_shortcode('listar_meditaciones', 'shortcode_listar_meditaciones');

