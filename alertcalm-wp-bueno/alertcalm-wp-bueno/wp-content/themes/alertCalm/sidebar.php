<?php
// Verifica si el área de widgets 'sidebar-1' está activa, es decir si tiene widgets
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return; // Si no hay widgets no devolverá nada
}
?>
<!-- Área lateral (sidebar) donde se cargan los widgets -->
<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
