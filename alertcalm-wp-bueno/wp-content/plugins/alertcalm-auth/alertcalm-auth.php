<?php
/**
 * Plugin Name: AlertCalm - auth
 * Description: Plugin para gestionar el login/registro de usuarios con estilo personalizado.
 * Version: 1.1
 * Author: Paula Herrera
 */


//  Para que carge la pagina princiapl una vez inicia sesión 
ob_start();
// Cargar estilos del formulario
add_action('wp_enqueue_scripts', 'alertcalm_auth_styles');
function alertcalm_auth_styles()
{
    wp_enqueue_style('alertcalm-auth-css', plugin_dir_url(__FILE__) . 'css/alertcalm-auth.css');
}
// Registro de usuario
function alertcalm_registrar_usuario()
{
    $mensaje = '';

    if (isset($_POST['alertcalm_registro_nonce']) && wp_verify_nonce($_POST['alertcalm_registro_nonce'], 'alertcalm_registro_nonce_accion')) {
        $nombre_usuario = sanitize_text_field($_POST['nombre_usuario']);
        $email = sanitize_email($_POST['email']);
        $contrasena = $_POST['contrasena'];

        if (!isset($_POST['politica_privacidad'])) {
            $mensaje = '<p class="alertcalm-mensaje error">Debes aceptar la política de privacidad.</p>';
            return $mensaje;
        }

        if (!username_exists($nombre_usuario) && !email_exists($email)) {
            $user_id = wp_create_user($nombre_usuario, $contrasena, $email);

            if (!is_wp_error($user_id)) {
                wp_update_user(array('ID' => $user_id, 'role' => 'regular'));
                $mensaje = '<p class="alertcalm-mensaje success">Usuario registrado con éxito.</p>';
            } else {
                $mensaje = '<p class="alertcalm-mensaje error">Error al registrar usuario.</p>';
            }
        } else {
            $mensaje = '<p class="alertcalm-mensaje error">El usuario o correo electrónico ya está registrado.</p>';
        }
    }
    return $mensaje;
}

function alertcalm_formulario_registro()
{
?>
    <form method="post" class="alertcalm-form">
        <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <label class="alertcalm-checkbox">
            <input type="checkbox" id="cuadradocheckbox" name="politica_privacidad" required>
            <p id="politica">Acepto la <a href="<?php echo esc_url(site_url('/politica-de-privacidad')); ?>" target="_blank">política de privacidad</a></p>
        </label>
        <?php wp_nonce_field('alertcalm_registro_nonce_accion', 'alertcalm_registro_nonce');?>
        <button type="submit">Registrarse</button>
    </form>
<?php
}

function alertcalm_shortcode_registro()
{
    ob_start();
    echo alertcalm_registrar_usuario();
    alertcalm_formulario_registro();
    return ob_get_clean();
}
add_shortcode('alertcalm_registro', 'alertcalm_shortcode_registro');

// Login de usuario
function alertcalm_iniciar_sesion()
{
    $mensaje = '';

    if (isset($_POST['alertcalm_login_nonce']) && wp_verify_nonce($_POST['alertcalm_login_nonce'], 'alertcalm_login_nonce_accion')) {
        $nombre_usuario = sanitize_text_field($_POST['nombre_usuario']);
        $contrasena = $_POST['contrasena'];

        $credenciales = array(
            'user_login' => $nombre_usuario,
            'user_password' => $contrasena,
            'remember' => true
        );

        $usuario = wp_signon($credenciales, false);
        if (!is_wp_error($usuario)) {
            error_log('Usuario autenticado correctamente');
            wp_redirect(home_url());
            exit;
        } else {
            error_log('Error en el login: ' . $usuario->get_error_message());
            $mensaje = '<p class="alertcalm-mensaje error">Error en el nombre de usuario o la contraseña.</p>';
        }
    }

    return $mensaje;
}

function alertcalm_formulario_login()
{
?>
    <form method="post" class="alertcalm-form">
        <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <?php wp_nonce_field('alertcalm_login_nonce_accion', 'alertcalm_login_nonce');?>
        <button type="submit">Iniciar sesión</button>
    </form>
<?php
}

function alertcalm_shortcode_login()
{
    ob_start();
    echo alertcalm_iniciar_sesion();
    alertcalm_formulario_login();
    return ob_get_clean();
}
add_shortcode('alertcalm_login', 'alertcalm_shortcode_login');

// Cambian los enlaces del menu cuando se inicia sesión para que aparezca cerrar sesión
add_filter('wp_nav_menu_items', 'alertcalm_enlaces_menu_auth', 10, 2);

function alertcalm_enlaces_menu_auth($items, $args) {
    if ($args->theme_location === 'menu') {
        if (is_user_logged_in()) {
            // Elimina cualquier enlace que lleve a "iniciar-sesion" o "registrarse"
            $items = preg_replace('#<li[^>]*>\s*<a[^>]*href="[^"]*login[^"]*"[^>]*>.*?</a>\s*</li>#i', '', $items);
            $items = preg_replace('#<li[^>]*>\s*<a[^>]*href="[^"]*registro[^"]*"[^>]*>.*?</a>\s*</li>#i', '', $items);

            //wp_logout_url es un enlace que cierra sesión
            $logout_url = wp_logout_url(home_url());
            $items .= '<li><a id="btn_cerrarsesion" href="' . esc_url($logout_url) . '">Cerrar sesión</a></li>';
        }
    }
    return $items;
}


