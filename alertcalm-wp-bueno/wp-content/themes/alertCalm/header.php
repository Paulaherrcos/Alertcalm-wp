<!doctype html>
<!-- language_attributes va a mostrar los atributos del idioma -->
<html <?php language_attributes(); ?>>
<head>
	<!-- funcion bloginfo() muestra info sobre el sitio actual -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<!-- wp_head inserta código en el head -->
	<?php wp_head(); ?>
</head>
	
<!-- body_class se usa para añadir clases en el body -->
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="site-branding">
		
			<?php
			// función que muestra el logo siempre y si no hay nada pues no muestra nada
			the_custom_logo();
			$alertcalm_description = get_bloginfo( 'description');
			// condicion que si hay info en la descripción o se previsualiza el sitio devuelve un boolean e imprime la descripción
			if ( $alertcalm_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $alertcalm_description;?></p>
			<?php endif; ?>
		</div>

		<!-- Menú -->
		<nav id="site-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav>
		<?php
			if ( function_exists( 'the_custom_logo' ) ) {
				the_custom_logo();
			}
		?>
	</header>
