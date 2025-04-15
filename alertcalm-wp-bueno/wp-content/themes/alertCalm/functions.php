<?php
function mi_tema_menus() {
    register_nav_menus(array(
      'menu' => 'menu',
    ));
  }
  add_action('after_setup_theme', 'mi_tema_menus');


  function alertcalm_theme_setup() {
    add_theme_support( 'custom-logo' );
  }
  add_action( 'after_setup_theme', 'alertcalm_theme_setup' );

  // registro del footer
  register_nav_menus([
    'main-menu' => 'Menú Principal'
]);
  
?>

