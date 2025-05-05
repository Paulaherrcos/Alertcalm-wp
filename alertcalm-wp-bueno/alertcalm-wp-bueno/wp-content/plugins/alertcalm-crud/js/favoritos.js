document.addEventListener('DOMContentLoaded', function () {
    // Verifica si el usuario está logueado al cargar la página
    if (wpApiSettings.userLoggedIn === 'false') {
        // Bloqueamos la interactividad con los botones de favoritos
        const botones = document.querySelectorAll('.btn-favorito');
        botones.forEach(boton => {
            boton.disabled = true; // Deshabilita el botón
        });
        return; // Detenemos la ejecución del código si no está logueado
    }

    // Si el usuario está logueado, continúa con la lógica de los botones de favoritos
    const botones = document.querySelectorAll('.btn-favorito');

    fetch(`${wpApiSettings.root}musica_meditaciones/v1/favoritos_usuario`, {
        method: 'GET',
        headers: {
            'X-WP-Nonce': wpApiSettings.nonce
        },
        credentials: 'same-origin'
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
    })
    .catch(err => console.error('Error al obtener favoritos:', err));
});
