<?php

// Registrar menús
function mi_tema_menus() {
    register_nav_menus(array(
        'menu' => 'Menú Principal', // Asegúrate de que este es el nombre correcto del menú
    ));
}
add_action('after_setup_theme', 'mi_tema_menus');

// Soporte para logo personalizado
function alertcalm_theme_setup() {
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'alertcalm_theme_setup');

// Filtrar los elementos del menú según el estado de autenticación
add_filter('wp_nav_menu_items', 'alertcalm_enlaces_menu_auth', 10, 2);


wp_localize_script('favoritos-js', 'wpApiSettings', [
    'root'   => esc_url_raw(rest_url()),
    'nonce'  => wp_create_nonce('wp_rest'),
    'userLoggedIn' => is_user_logged_in()
]);

?>
