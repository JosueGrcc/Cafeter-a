// El carrito ahora es un objeto que guarda cada producto
let carrito = {}; 
categoriaActual = 'todas'; // Categoria default al cargar la página

function agregarAlCarrito(nombre, precio) {
    // Si el producto ya existe, sumamos 1 a la cantidad. Si no, lo creamos.
    if (carrito[nombre]) {
        carrito[nombre].cantidad++;
    } else {
        carrito[nombre] = { precio: precio, cantidad: 1 };
    }
    actualizarResumen();
    renderizarCarrito(); // Actualizamos la vista por si el modal está abierto
}

function cambiarCantidad(nombre, cantidadCambio) {
    if (carrito[nombre]) {
        carrito[nombre].cantidad += cantidadCambio;
        
        // Si la cantidad llega a 0 o menos, eliminamos el producto
        if (carrito[nombre].cantidad <= 0) {
            delete carrito[nombre];
        }
        actualizarResumen();
        renderizarCarrito();
    }
}

function eliminarDelCarrito(nombre) {
    delete carrito[nombre]; // Borra el producto por completo
    actualizarResumen();
    renderizarCarrito();
}

function actualizarResumen() {
    let total = 0;
    let contador = 0;
    
    for (let prod in carrito) {
        total += carrito[prod].precio * carrito[prod].cantidad;
        contador += carrito[prod].cantidad;
    }
    
    document.getElementById('total_pago').innerText = total.toFixed(2);
    document.getElementById('modal_total').innerText = total.toFixed(2);
    
    const textoItems = document.getElementById('lista_items');
    if (contador > 0) {
        // Texto simple, ya que el botón de al lado es el que abre el modal
        textoItems.innerText = contador + (contador === 1 ? " producto" : " productos");
    } else {
        textoItems.innerText = "Vacío";
    }
}

// ---- FUNCIONES DEL MODAL (VENTANA EMERGENTE) ---- //
function abrirCarrito() {
    document.getElementById('modal_carrito').style.display = 'flex';
    renderizarCarrito();
}

function cerrarCarrito() {
    document.getElementById('modal_carrito').style.display = 'none';
}

function renderizarCarrito() {
    const contenedor = document.getElementById('lista_carrito_detalles');
    contenedor.innerHTML = ''; // Limpiamos antes de dibujar
    
    if (Object.keys(carrito).length === 0) {
        contenedor.innerHTML = '<p style="text-align:center; color:#666;">Tu carrito está vacío.</p>';
        return;
    }

    // Dibujamos cada producto en el modal
    for (let prod in carrito) {
        const item = carrito[prod];
        const subtotal = item.precio * item.cantidad;
        
        const div = document.createElement('div');
        div.className = 'item_carrito';
        div.innerHTML = `
            <div class="item_info_carrito">
                <strong>${prod}</strong>
                <span class="precio_unitario">$${item.precio.toFixed(2)} c/u</span>
            </div>
            <div class="controles_cantidad">
                <button class="btn_circular" onclick="cambiarCantidad('${prod}', -1)">-</button>
                <span class="cantidad_texto">${item.cantidad}</span>
                <button class="btn_circular" onclick="cambiarCantidad('${prod}', 1)">+</button>
            </div>
            <div class="item_subtotal_carrito">
                <strong>$${subtotal.toFixed(2)}</strong>
                <button class="btn_basura" onclick="eliminarDelCarrito('${prod}')">🗑️</button>
            </div>
        `;
        contenedor.appendChild(div);
    }
}


// Se ejecuta al hacer clic en una categoría
function filtrar(clase) {
    categoriaActual = clase; // Actualizamos la categoría global
    
    // Cambiar estilo de botones
    document.querySelectorAll('.btn_cat').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');

    // Limpiamos el buscador al cambiar de categoría (opcional, pero recomendado)
    document.getElementById('buscador_productos').value = '';
    
    aplicarFiltros();
}

// Se ejecuta al escribir o al cambiar de categoría
function aplicarFiltros() {
    const textoBusqueda = document.getElementById('buscador_productos').value.toLowerCase();
    const productos = document.querySelectorAll('.tarjeta_producto');
    
    productos.forEach(p => {
        // Obtenemos el nombre del producto (dentro del h3)
        const nombreProducto = p.querySelector('h3').innerText.toLowerCase();
        
        // Verificamos si cumple con la categoría seleccionada
        const coincideCategoria = (categoriaActual === 'todas') || p.classList.contains(categoriaActual);
        
        // Verificamos si incluye el texto buscado
        const coincideTexto = nombreProducto.includes(textoBusqueda);
        
        // Solo mostramos el producto si cumple AMBAS condiciones
        if (coincideCategoria && coincideTexto) {
            p.style.display = 'flex';
        } else {
            p.style.display = 'none';
        }
    });
}

// Función para enviar los datos a PHP
async function enviarPedido() {
    if (Object.keys(carrito).length === 0) return alert("El carrito está vacío");

    const total = parseFloat(document.getElementById('total_pago').innerText);
    const datosEnvio = { total: total, items: carrito };

    try {
        const response = await fetch('../controllers/pedido/guardar_pedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datosEnvio)
        });

        const resultado = await response.json();

        if (resultado.success) {
            alert("¡Pedido #" + resultado.pedido_id + " guardado con éxito!");
            carrito = {}; 
            actualizarResumen();
            if(typeof cerrarCarrito === 'function') cerrarCarrito();
        } else {
            // Manejo de errores específicos
            if (resultado.error === 'SESION_NO_INICIADA') {
                alert(resultado.mensaje);
                window.location.href = 'login.html'; // Redirige a tu página de login
            } else {
                alert("Error: " + resultado.mensaje);
            }
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Hubo un problema al procesar el pedido.");
    }
}