<?php
/**
 * Plugin Name: AlertCalm - crud
 * Description: Plugin para gestionar meditaciones y músicas desde el panel de WordPress.
 * Version: 1.0
 * Author: Paula Herrera
 */


 //FUNCIÓN PARA QUE APAREZCA EL PLUGIN UNA VEZ SE ACTIVE EN LA PARTE DEL BACKEND

 add_action('admin_menu', 'alertcalm_crud_menu');

function alertcalm_crud_menu() {
    //para qeu aparezca el menu princiapl en mi wordpress 
    add_menu_page(
        'AlertCalm CRUD',
        'AlertCalm CRUD',
        'manage_options',
        'alertcalm_crud',
        'alertcalm_crud__todos_panel',
        'dashicons-heart',
        6
    );
        
    // Submenús
    add_submenu_page(
        'alertcalm_crud',
        'Ver todos',
        'Ver todos',
        'manage_options',
        'alertcalm_crud_todos',
        'alertcalm_crud_todos_panel'
    );

    add_submenu_page(
        'alertcalm_crud',
        'Crear',
        'Crear',
        'manage_options',
        'alertcalm_crud_crear',
        'alertcalm_crud_crear'
    );

    add_submenu_page(
        'alertcalm_crud',
        'Editar',
        'Editar',
        'manage_options',
        'alertcalm_crud_editar',
        'alertcalm_crud_editar'
    );

    add_submenu_page(
        'alertcalm_crud',
        'Eliminar',
        'Eliminar',
        'manage_options',
        'alertcalm_crud_eliminar',
        'alertcalm_crud_eliminar'
    );
}

function alertcalm_crud_panel(){
    echo "Bienvenido";
}

//función que muestra las músicas y meditaciones guardadas en la bd
function alertcalm_crud_todos_panel() {
    $musicas = listar_musicas_con_filtro();

    echo '<h1>Listado de músicas</h1>';

    if (empty($musicas)) {
        echo '<p>No hay músicas registradas.</p>';
    } else {
        echo '<table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Duración</th>
                        <th>Lenguaje</th>
                        <th>Imagen</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($musicas as $musica) {
            echo '<tr>
                    <td>' . esc_html($musica->titulo) . '</td>
                    <td>' . esc_html($musica->categoria) . '</td>
                    <td>' . esc_html($musica->duracion) . '</td>
                    <td>' . esc_html($musica->lenguaje) . '</td>
                    <td><img src="' . esc_url($musica->imagen_url) . '" alt="Imagen" width="100"></td>
                    <td><a href="' . esc_url($musica->file_url) . '" target="_blank">Ver archivo</a></td>
                  </tr>';
        }
        echo '</tbody></table>';
    }

    echo '<h1>Listado de meditaciones</h1>';

    $meditaciones = listar_meditaciones_con_filtro();

    if (empty($meditaciones)) {
        echo '<p>No hay meditaciones registradas.</p>';
    } else {
        echo '<table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Duración</th>
                        <th>Lenguaje</th>
                        <th>Imagen</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($meditaciones as $meditacion) {
            echo '<tr>
                    <td>' . esc_html($meditacion->titulo) . '</td>
                    <td>' . esc_html($meditacion->categoria) . '</td>
                    <td>' . esc_html($meditacion->duracion) . '</td>
                    <td>' . esc_html($meditacion->lenguaje) . '</td>
                    <td><img src="' . esc_url($meditacion->imagen_url) . '" alt="Imagen" width="100"></td>
                    <td><a href="' . esc_url($meditacion->file_url) . '" target="_blank">Ver archivo</a></td>
                  </tr>';
        }
        echo '</tbody></table>';
    }
}




function alertcalm_crud_crear() {
    $mensaje = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $file_url = $_POST['file_url'] ?? '';
        $duracion = $_POST['duracion'] ?? '';
        $lenguaje = $_POST['lenguaje'] ?? '';
        $imagen_url = $_POST['imagen_url'] ?? '';

        if ($titulo && $categoria && $file_url && $duracion && $lenguaje && $imagen_url && $tipo) {
            $datos = [
                'titulo' => $titulo,
                'categoria' => $categoria,
                'file_url' => $file_url,
                'duracion' => $duracion,
                'lenguaje' => $lenguaje,
                'imagen_url' => $imagen_url,
                'tipo' => $tipo,
            ];
            crear_contenido_desde_formulario($datos); // función que decides abajo
            $mensaje = '<p style="color: green;">¡Contenido creado con éxito!</p>';
        } else {
            $mensaje = '<p style="color: red;">Faltan campos por rellenar.</p>';
        }
    }

    echo <<<HTML
    <h1>Elija el tipo de contenido que desee crear:</h1>
    $mensaje
    <select name="tipo_crear" id="tipo_crear">
        <option value="musica">Música</option>
        <option value="meditacion">Meditación</option>
    </select>

    <div id="formulario_musica" style="display: block; margin-top: 20px;">
        <form action="" method="POST">
            <input type="hidden" name="tipo" value="musica">
            <input type="text" name="titulo" placeholder="Título de la música">
            <select name="categoria">
                <option value="relajación">Relajación</option>
                <option value="activación">Activación</option>
                <option value="dormir">Dormir</option>
            </select>
            <input type="text" name="file_url" placeholder="file_url">
            <input type="text" name="duracion" placeholder="duración">
            <input type="text" name="lenguaje" placeholder="lenguaje">
            <input type="text" name="imagen_url" placeholder="imagen_url">
            <input type="submit" value="Crear música">
        </form>
    </div>

    <div id="formulario_meditacion" style="display: none; margin-top: 20px;">
        <form action="" method="POST">
            <input type="hidden" name="tipo" value="meditacion">
            <input type="text" name="titulo" placeholder="Título de la meditación">
            <select name="categoria">
                <option value="relajación">Relajación</option>
                <option value="activación">Activación</option>
                <option value="dormir">Dormir</option>
            </select>
            <input type="text" name="file_url" placeholder="file_url">
            <input type="text" name="duracion" placeholder="duración">
            <input type="text" name="lenguaje" placeholder="lenguaje">
            <input type="text" name="imagen_url" placeholder="imagen_url">
            <input type="submit" value="Crear meditación">
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('tipo_crear');
        const formularioMusica = document.getElementById('formulario_musica');
        const formularioMeditacion = document.getElementById('formulario_meditacion');

        selector.addEventListener('change', function() {
            if (this.value === 'musica') {
                formularioMusica.style.display = 'block';
                formularioMeditacion.style.display = 'none';
            } else {
                formularioMusica.style.display = 'none';
                formularioMeditacion.style.display = 'block';
            }
        });
    });
    </script>
    HTML;
}


//vincular con el js

function alertcalm_crud_enqueue_scripts($hook) {
    if ($hook !== 'alertcalm-crud_page_alertcalm_crud_crear') return;
    wp_enqueue_script('formulario-crear-js', plugin_dir_url(__FILE__) . 'js/formularios_crear.js', [], false, true);
}
add_action('admin_enqueue_scripts', 'alertcalm_crud_enqueue_scripts');




function alertcalm_crud_eliminar() {
    echo '<h1>Selecciona lo que deseas eliminar</h1><br>';

    $tipo = $_POST['tipo'] ?? 'musica';
    $filtro_categoria = $_POST['filtro_categoria'] ?? '';
    $filtro_titulo = $_POST['filtro_titulo'] ?? '';

    // Eliminar si se ha enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id']) && isset($_POST['tipo'])) {
        if ($_POST['tipo'] === 'musica' && function_exists('eliminar_musica')) {
            eliminar_musica(['id' => intval($_POST['eliminar_id'])]);
            echo '<div style="color: green;">Música eliminada con éxito.</div>';
        } elseif ($_POST['tipo'] === 'meditacion' && function_exists('eliminar_meditacion')) {
            eliminar_meditacion(['id' => intval($_POST['eliminar_id'])]);
            echo '<div style="color: green;">Meditación eliminada con éxito.</div>';
        }
    }

    // Formulario de filtros
    echo '
    <form action="" method="POST">
        <select name="tipo" onchange="this.form.submit()">
            <option value="musica" ' . ($tipo === 'musica' ? 'selected' : '') . '>Música</option>
            <option value="meditacion" ' . ($tipo === 'meditacion' ? 'selected' : '') . '>Meditación</option>
        </select>
        <select name="filtro_categoria">
            <option value="">-- Todas las categorías --</option>
            <option value="relajación" ' . ($filtro_categoria === 'relajación' ? 'selected' : '') . '>Relajación</option>
            <option value="activación" ' . ($filtro_categoria === 'activación' ? 'selected' : '') . '>Activación</option>
            <option value="dormir" ' . ($filtro_categoria === 'dormir' ? 'selected' : '') . '>Dormir</option>
        </select>
        <input type="text" name="filtro_titulo" placeholder="Título" value="' . esc_attr($filtro_titulo) . '">
        <button type="submit">Buscar</button>
    </form>
    
    <br>';

    // Obtener los datos según el tipo
    if ($tipo === 'musica' && function_exists('listar_musicas_con_filtro')) {
        $items = listar_musicas_con_filtro($filtro_categoria, $filtro_titulo);
    } elseif ($tipo === 'meditacion' && function_exists('listar_meditaciones_con_filtro')) {
        $items = listar_meditaciones_con_filtro($filtro_categoria, $filtro_titulo);
    } else {
        echo '<div style="color: red;">No se puede mostrar la lista.</div>';
        return;
    }

    // Tabla
    echo '
    <table border="1" cellpadding="5px">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>ID</th>
                <th>Duración</th>
                <th>Lenguaje</th>
                <th>Imagen</th>
                <th>File</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($items as $item) {
        echo "
        <tr>
            <td>{$item->titulo}</td>
            <td>{$item->categoria}</td>
            <td>{$item->id}</td>
            <td>{$item->duracion}</td>
            <td>{$item->lenguaje}</td>
            <td><img src='{$item->imagen_url}' width='100px'></td>
            <td>{$item->file_url}</td>
            <td>
                <form action='' method='POST'>
                    <input type='hidden' name='eliminar_id' value='{$item->id}'>
                    <input type='hidden' name='tipo' value='{$tipo}'>
                    <button type='submit'>Eliminar</button>
                </form>
            </td>
        </tr>";
    }

    echo '</tbody></table>';
}




function alertcalm_crud_editar(){
    echo '<h1>EDITAR</h1>';
}



//prefix: devuelve el prefijo actual de la base de datos (wp_)
function crear_tabla_musica_y_meditaciones() {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
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

  // Tabla de favoritos
  
  $tabla_favoritos = $wpdb->prefix . 'favoritos';
  $sql_favoritos = "CREATE TABLE $tabla_favoritos (
    id INT NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    tipo ENUM('musica', 'meditacion') NOT NULL,
    item_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES {$wpdb->prefix}users(ID) ON DELETE CASCADE
)";


    // Incluye el archivo necesario para ejecutar dbDelta()
    //es una función de wordpress que crea la bd si no existe y si ya está creada la actualliza
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_musica );
    dbDelta( $sql_meditaciones);
    dbDelta( $sql_favoritos);
}
// Agregar la acción para crear la tabla de musica al activar el plugin
//Una vez activo el plugin alertcalm-crud se ejecuta la function crear_tabla_musica_y_meditaciones, si no activo el plugin no
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

function obtener_meditacion( $request ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $id = $request['id'];
    $meditacion = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $tabla_meditaciones WHERE id = %d", $id ) );
    return $meditacion;
}

// Función para listar todas las músicas con filtro por categorías
function listar_musicas_con_filtro( $categorias = '', $titulo = '' ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';

    $sql = "SELECT * FROM $tabla_musica WHERE 1=1";
    $params = [];

    // Si se pasa una o más categorías
    if ( ! empty( $categorias ) ) {
        $categorias_array = array_map( 'trim', explode( ',', $categorias ) );
        $placeholders = implode( ',', array_fill( 0, count( $categorias_array ), '%s' ) );
        $sql .= " AND categoria IN ($placeholders)";
        $params = array_merge( $params, $categorias_array );
    }

    // Si se pasa un título
    if ( ! empty( $titulo ) ) {
        $sql .= " AND titulo LIKE %s";
        $params[] = '%' . $wpdb->esc_like( $titulo ) . '%';
    }

    // Ejecutar la consulta preparada si hay parámetros, si no, ejecutar sin prepare
    if ( ! empty( $params ) ) {
        return $wpdb->get_results( $wpdb->prepare( $sql, ...$params ) );
    } else {
        return $wpdb->get_results( $sql );
    }
}



// Función para listar todas las meditaciones
function listar_meditaciones_con_filtro( $categorias = '' ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $sql = "SELECT * FROM $tabla_meditaciones";
    if ( ! empty( $categorias ) ) { $categorias_array = array_map('trim', explode(',', $categorias));

        // Prepara placeholders para la consulta
        $placeholders = implode(',', array_fill(0, count($categorias_array), '%s'));

        $sql .= $wpdb->prepare( " WHERE categoria IN ($placeholders)", ...$categorias_array );
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

    //insertamos en la tabla_musica la nueva música
    $wpdb->insert( $tabla_musica, $musica );
    //se ha autoincrementado el id
    return $wpdb->insert_id;
}

//para crear desde el formulario no tengo que pasar get_paam ya que eto es para hacerlo desde thunder client

function crear_contenido_desde_formulario($datos) {
    global $wpdb;

    $tabla = $datos['tipo'] === 'musica' ? $wpdb->prefix . 'musica' : $wpdb->prefix . 'meditaciones';

    $wpdb->insert($tabla, [
        'titulo' => $datos['titulo'],
        'categoria' => $datos['categoria'],
        'file_url' => $datos['file_url'],
        'duracion' => $datos['duracion'],
        'lenguaje' => $datos['lenguaje'],
        'imagen_url' => $datos['imagen_url'],
    ]);
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
    $wpdb->insert( $tabla_meditaciones, $meditacion );
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
    $wpdb->update( $tabla_musica, $musica, array( 'id' => $id ) );
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
    $wpdb->update( $tabla_meditaciones, $meditacion, array( 'id' => $id ) );
    return $wpdb->rows_affected;
}

// Función para eliminar una música por ID
function eliminar_musica( $request ) {
    global $wpdb;
    $tabla_musica = $wpdb->prefix . 'musica';
    $id = $request['id'];
    $wpdb->delete( $tabla_musica, array( 'id' => $id ) );
    return $wpdb->rows_affected;
}

// Función para eliminar una meditación por ID
function eliminar_meditacion( $request ) {
    global $wpdb;
    $tabla_meditaciones = $wpdb->prefix . 'meditaciones';
    $id = $request['id'];
    $wpdb->delete( $tabla_meditaciones, array( 'id' => $id ) );
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
        'categoria' => '',  
    ), $atts, 'listar_musicas' );
    
    // Verificar si se pasa el parámetro categoria
    error_log("Categoria en Shortcode Musicas: " . $atts['categoria']);

    // Obtener las músicas filtradas por la categoría proporcionada
    $musicas = listar_musicas_con_filtro( $atts['categoria'] );

    if (empty($musicas)) return '<p>No hay músicas disponibles.</p>';

    // Iniciar el HTML para las tarjetas
    $html = '<h3>Lista de Música</h3><div class="musica-cards-container">';

    foreach ($musicas as $musica) {
        $html .= "
            <div class='musica-card'>
                <h4>{$musica->titulo}</h4>
                <p><img src='{$musica->imagen_url}' alt='Imagen de {$musica->titulo}'></p>
                <p><strong>Categoría:</strong> {$musica->categoria}</p>
                <p><strong>Duración:</strong> {$musica->duracion}</p>
                <p><strong>Lenguaje:</strong> {$musica->lenguaje}</p>
                <a href='{$musica->file_url}' target='_blank' class='btn-escuchar'>Escuchar</a>
                <button class='btn-favorito' data-elemento-id='{$musica->id}' data-tipo='musica'>
                    <i class='fas fa-heart'></i>
                </button>
            </div>
        ";
    }
    
    $html .= '</div>';
    
    // Agregado el JavaScript para manejar el clic en el corazón
    $html .= "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const favoritos = document.querySelectorAll('.btn-favorito');
                
                favoritos.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        // Alternar la clase 'favorito' para cambiar el color
                        btn.classList.toggle('favorito');
                    });
                });
            });
        </script>
    ";

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
    //html para tarjetas
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
                <button class='btn-favorito' data-elemento-id='{$meditacion->id}' data-tipo='meditacion'>
                    <i class='fas fa-heart'></i>
                </button>
            </div>
        ";
    }
    
    $html .= '</div>';
    return $html;
}
add_shortcode('listar_meditaciones', 'shortcode_listar_meditaciones');




// FUNCIONALIDAD PARA AGREGAR FAVORITO SI ESTOY INICIADO SESIÓN SINO QUE SALTE MENSAJE
function agregar_favorito( $request ) {
    if ( ! is_user_logged_in() ) {
        return new WP_REST_Response( 'Debes iniciar sesión para agregar a favoritos.', 401 );
    }

    global $wpdb;
    $tabla_favoritos = $wpdb->prefix . 'favoritos';
    $user_id = get_current_user_id();
    $tipo = $request->get_param( 'tipo' ); // 'musica' o 'meditacion'
    $item_id = $request->get_param( 'item_id' ); // ID de la música o meditación

    // Verificar si ya está en favoritos
    $favorito_existente = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM $tabla_favoritos WHERE user_id = %d AND tipo = %s AND item_id = %d",
        $user_id, $tipo, $item_id
    ));

    if ( $favorito_existente > 0 ) {
        // Si ya está en favoritos, eliminarlo
        $wpdb->delete( $tabla_favoritos, array(
            'user_id' => $user_id,
            'tipo' => $tipo,
            'item_id' => $item_id
        ));
        return new WP_REST_Response( ['message' => 'Elemento eliminado de favoritos correctamente.'], 200 );
    }

    // Si no está en favoritos, agregarlo
    $wpdb->insert( $tabla_favoritos, array(
        'user_id' => $user_id,
        'tipo' => $tipo,
        'item_id' => $item_id
    ));

    // Responder con éxito
    return new WP_REST_Response( ['message' => 'Elemento agregado a favoritos correctamente.'], 200 );
}

// Registrar el endpoint para agregar a favoritos

add_action( 'rest_api_init', 'registrar_endpoint_favorito' );
function registrar_endpoint_favorito() {
    register_rest_route( 'musica_meditaciones/v1', '/favorito', array(
        'methods' => 'POST',
        'callback' => 'agregar_favorito',
        'permission_callback' => function() {
            return is_user_logged_in();//si el usuario esta logueado
        },
    ) );
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('favoritos-js', plugin_dir_url(__FILE__) . 'js/favoritos.js', [], null, true);

    // Localizar el script y agregar la URL de la API REST, el nonce y la información de sesión
    wp_localize_script('favoritos-js', 'wpApiSettings', [
        'root'   => esc_url_raw(rest_url()), // URL base de la API REST
        'nonce'  => wp_create_nonce('wp_rest'), // Nonce para la seguridad
        'userLoggedIn' => is_user_logged_in() ? 'true' : 'false' // Convertir a cadena
    ]);
});


// para que se cargen todos los favoritos una vez hemos iniciados eison.
//al poner 'permission_callback' solo funcionará el agregar favorito cuadno según los privilegios del rol

add_action('rest_api_init', function() {
    register_rest_route('musica_meditaciones/v1', '/favoritos_usuario', [
        'methods' => 'GET',
        'callback' => 'obtener_favoritos_usuario',
        'permission_callback' => function() {
            return is_user_logged_in();
        }
    ]);
});

function obtener_favoritos_usuario() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'favoritos';
    $user_id = get_current_user_id();

    $resultados = $wpdb->get_results($wpdb->prepare(
        "SELECT tipo, item_id FROM $tabla WHERE user_id = %d", $user_id
    ), ARRAY_A);

    return new WP_REST_Response($resultados, 200);
}