document.addEventListener("DOMContentLoaded", function () {
    const tipoCrear = document.getElementById("tipo_crear");
    const formularioMusica = document.getElementById("formulario_musica");
    const formularioMeditacion = document.getElementById("formulario_meditacion");

    if (tipoCrear && formularioMusica && formularioMeditacion) {
        tipoCrear.addEventListener("change", function () {
            console.log("Cambio detectado:", tipoCrear.value);
            if (tipoCrear.value === "musica") {
                formularioMusica.style.display = "block";
                formularioMeditacion.style.display = "none";
            } else if (tipoCrear.value === "meditacion") {
                formularioMusica.style.display = "none";
                formularioMeditacion.style.display = "block";
            }
        });
    }
});
