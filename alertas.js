console.log("El script de alertas se cargó correctamente");
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const cajaError = document.getElementById('mensaje-error');

    // Si existe el parámetro "error", mostramos la caja
    if (urlParams.has('error') && cajaError) {
        cajaError.style.display = 'block';

        // Opcional: Personalizar el texto
        if (urlParams.get('error') === 'password_incorrecto') {
            cajaError.innerHTML = "<strong>¡Error!</strong> Datos incorrectos.";
        }

        // Limpiar URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});