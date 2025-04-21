<footer class="site-footer">
	<div class="menu-footer">
		<h3>Menú</h3>
	<?php
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'menu_id' => 'footer-menu',
                'container_class' => 'footer-navigation'
            ]);
        ?>
		</div>
		<div class="paginas-interes">
			<h3>Páginas de interés</h3>
			<ul>
				<li><a href="/alertas">Alertas en tiempo real</a></li>
				<li><a href="/meditaciones">Meditaciones para emergencias</a></li>
				<li><a href="/protocolos">Protocolos de actuación</a></li>
				<li><a href="/apoyo-emocional">Apoyo emocional</a></li>
			</ul>
		</div>
		<div>
			<!-- echo date('Y'); muestra año automaticamente -->
			<p>© <?php echo date('Y'); ?> AlertCalm - Todos los derechos reservados.</p>
		</div>
	
</footer>
</div>

	<?php wp_footer(); ?>
</body>
</html>
