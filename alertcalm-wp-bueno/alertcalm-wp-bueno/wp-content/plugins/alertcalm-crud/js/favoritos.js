document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-favorito');

    // Cargar favoritos del usuario uso wpApiSettings.root porque si lo pongo como ruta relativa no funciona
    fetch(`${wpApiSettings.root}musica_meditaciones/v1/favoritos_usuario`, {
        headers: {
            'X-WP-Nonce': wpApiSettings.nonce
        },
        credentials: 'same-origin' //ncesario para que se guarden las cookies del user registrado y el navegador sepa quien es
    })
    .then(res => res.json())
    .then(favoritos => {
        botones.forEach(boton => {
            const itemId = boton.dataset.elementoId;
            const tipo = boton.dataset.tipo;
            const icono = boton.querySelector('i');

            const esFavorito = favoritos.some(f => f.item_id == itemId && f.tipo === tipo);
            if (esFavorito) {
                icono.classList.add('activo');
                icono.style.color = '#9C27B0';
            } else {
                icono.classList.remove('activo');
                icono.style.color = '';
            }

            // Click para toggle favorito
            boton.addEventListener('click', function () {
                fetch(`${wpApiSettings.root}musica_meditaciones/v1/favorito`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': wpApiSettings.nonce
                    },
                    credentials: 'same-origin', 
                    body: JSON.stringify({ item_id: itemId, tipo: tipo })
                })
                .then(r => r.json())
                .then(result => {
                    if (result.message.includes('agregado')) {
                        icono.classList.add('activo');
                        icono.style.color = '#9C27B0';
                    } else if (result.message.includes('eliminado')) {
                        icono.classList.remove('activo');
                        icono.style.color = 'white';
                    }
                });
            });
        });
    });
});
