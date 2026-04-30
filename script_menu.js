let total = 0;
let contador = 0;

function agregarAlCarrito(nombre, precio) {
    total += precio;
    contador++;
    
    document.getElementById('total_pago').innerText = total.toFixed(2);
    document.getElementById('lista_items').innerText = contador + " productos";
}

function filtrar(clase) {
    const productos = document.querySelectorAll('.tarjeta_producto');
    
    productos.forEach(p => {
        if (clase === 'todas') {
            p.style.display = 'flex';
        } else {
            // Comprueba si el div tiene la clase de la categoría
            p.style.display = p.classList.contains(clase) ? 'flex' : 'none';
        }
    });

    // Cambiar estilo de botones
    document.querySelectorAll('.btn_cat').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');
}