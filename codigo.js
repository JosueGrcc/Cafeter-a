
document.addEventListener("DOMContentLoaded", function() {
   
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('error') === 'email_existente') {
        const cajaError = document.getElementById('mensaje-error');
        if (cajaError) {
            cajaError.style.display = 'block';
        }
    }
});