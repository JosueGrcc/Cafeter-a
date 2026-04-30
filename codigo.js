document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('error') === 'email_existente') {
        const cajaError = document.getElementById('mensaje-error');
        if (cajaError) {
            // 1. Mostramos el error
            cajaError.style.display = 'block';

            // 2. Limpiamos la URL sin recargar la página
            const nuevaUrl = window.location.pathname;
            window.history.replaceState({}, document.title, nuevaUrl);
        }
        setTimeout(() => {
                cajaError.style.display = 'none';
            }, 5000);
    }
});