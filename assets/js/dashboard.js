// =============================================
//  DASHBOARD.JS — Octava Café Admin Panel
// =============================================

// ── ESTADO GLOBAL ──────────────────────────
let tabActual = null; // 'agregar' | 'productos' | 'pedidos' | 'editar'

// ── POPUP PERSONALIZADO ────────────────────
/**
 * Muestra un popup de confirmación o de aviso.
 * @param {object} opts
 *   tipo:       'confirm' | 'success' | 'error'
 *   titulo:     string
 *   mensaje:    string
 *   labelOk:    string  (solo confirm)
 *   labelCance: string  (solo confirm)
 *   onOk:       function (solo confirm)
 */
function mostrarPopup({ tipo = 'confirm', titulo, mensaje, labelOk = 'Confirmar', labelCance = 'Cancelar', onOk }) {
    // Eliminar popup previo si existe
    const prev = document.getElementById('popup_overlay');
    if (prev) prev.remove();

    const overlay = document.createElement('div');
    overlay.id = 'popup_overlay';
    overlay.className = 'popup_overlay';

    const iconos = { confirm: '⚠️', success: '✅', error: '❌' };
    const colores = { confirm: 'var(--dorado)', success: '#2e7d32', error: '#c62828' };

    overlay.innerHTML = `
        <div class="popup_caja" role="dialog" aria-modal="true">
            <div class="popup_icono" style="color:${colores[tipo]}">${iconos[tipo]}</div>
            <h3 class="popup_titulo">${titulo}</h3>
            <p class="popup_mensaje">${mensaje}</p>
            <div class="popup_acciones">
                ${tipo === 'confirm'
                    ? `<button class="popup_btn popup_btn_cancel" id="popup_cancel">${labelCance}</button>
                       <button class="popup_btn popup_btn_ok" id="popup_ok" style="background:${colores[tipo]}">${labelOk}</button>`
                    : `<button class="popup_btn popup_btn_ok" id="popup_ok" style="background:${colores[tipo]}">Aceptar</button>`
                }
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    // Animación entrada
    requestAnimationFrame(() => overlay.classList.add('popup_visible'));

    const cerrar = () => {
        overlay.classList.remove('popup_visible');
        overlay.addEventListener('transitionend', () => overlay.remove(), { once: true });
    };

    document.getElementById('popup_ok').addEventListener('click', () => {
        cerrar();
        if (tipo === 'confirm' && typeof onOk === 'function') onOk();
    });

    const btnCancel = document.getElementById('popup_cancel');
    if (btnCancel) btnCancel.addEventListener('click', cerrar);

    overlay.addEventListener('click', e => { if (e.target === overlay) cerrar(); });
}

// ── TABS ───────────────────────────────────
function cambiarTab(btn, tab) {
    tabActual = tab;
    document.getElementById('bienvenida').style.display = 'none';

    // Ocultar tab de editar si existe y no vamos a él
    const tabEditarBtn = document.getElementById('tab_btn_editar');
    if (tab !== 'editar' && tabEditarBtn) {
        tabEditarBtn.style.display = 'none';
    }

    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab_btn').forEach(b => b.classList.remove('active'));
    document.getElementById('panel_' + tab).classList.add('active');
    btn.classList.add('active');
}

function irATab(tab) {
    const btn = document.querySelector(`.tab_btn[data-tab="${tab}"]`);
    if (btn) cambiarTab(btn, tab);
}

// ── EDITAR PRODUCTO (panel temporal) ───────
function abrirEditar(id, nombre, descripcion, precio, categoriaId) {
    // Solo una edición a la vez
    const tabEditarBtn = document.getElementById('tab_btn_editar');

    // Rellenar el formulario
    document.getElementById('edit_id').value          = id;
    document.getElementById('edit_nombre').value      = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('edit_precio').value      = precio;
    document.getElementById('edit_categoria_id').value = categoriaId;

    // Mostrar el tab si estaba oculto
    tabEditarBtn.style.display = 'inline-flex';
    tabActual = 'editar';

    // Activar visualmente
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab_btn').forEach(b => b.classList.remove('active'));
    document.getElementById('panel_editar').classList.add('active');
    tabEditarBtn.classList.add('active');
    document.getElementById('bienvenida').style.display = 'none';
}

function cerrarEditar() {
    const tabEditarBtn = document.getElementById('tab_btn_editar');
    tabEditarBtn.style.display = 'none';
    tabEditarBtn.classList.remove('active');
    document.getElementById('panel_editar').classList.remove('active');
    // Regresar a productos
    irATab('productos');
}

// ── GUARDAR PRODUCTO (form agregar) ────────
function confirmarGuardarProducto(e) {
    e.preventDefault();
    const form = e.target;
    mostrarPopup({
        tipo: 'confirm',
        titulo: 'Guardar producto',
        mensaje: `¿Deseas guardar el producto <strong>${form.nombre.value}</strong>?`,
        labelOk: '💾 Guardar',
        onOk: () => enviarFormulario(form, 'productos', '¡Producto guardado correctamente!')
    });
}

// ── GUARDAR EDICIÓN ────────────────────────
function confirmarEditarProducto(e) {
    e.preventDefault();
    const form = e.target;
    mostrarPopup({
        tipo: 'confirm',
        titulo: 'Guardar cambios',
        mensaje: `¿Confirmas los cambios en <strong>${form.nombre.value}</strong>?`,
        labelOk: '✏️ Guardar cambios',
        onOk: () => {
            enviarFormulario(form, null, '¡Producto actualizado correctamente!', () => {
                cerrarEditar();
                // Recargar datos de la tabla sin recargar la página
                recargarTablaProductos();
            });
        }
    });
}

// ── ELIMINAR PRODUCTO ──────────────────────
function confirmarEliminar(id, nombre) {
    mostrarPopup({
        tipo: 'confirm',
        titulo: 'Eliminar producto',
        mensaje: `¿Estás seguro de eliminar <strong>${nombre}</strong>? Esta acción no se puede deshacer.`,
        labelOk: '🗑️ Eliminar',
        onOk: () => {
            fetch(`../controllers/eliminar.php?id=${id}&ajax=1`)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // Eliminar fila de la tabla
                        const fila = document.querySelector(`#tabla_productos tr[data-id="${id}"]`);
                        if (fila) fila.remove();
                        actualizarContadorProductos();
                        mostrarPopup({ tipo: 'success', titulo: 'Eliminado', mensaje: 'El producto fue eliminado correctamente.' });
                    } else {
                        mostrarPopup({ tipo: 'error', titulo: 'Error', mensaje: data.mensaje || 'No se pudo eliminar el producto.' });
                    }
                })
                .catch(() => mostrarPopup({ tipo: 'error', titulo: 'Error de red', mensaje: 'No se pudo conectar con el servidor.' }));
        }
    });
}

// ── CAMBIAR ESTADO PEDIDO ──────────────────
function confirmarCambioEstado(e, form) {
    e.preventDefault();
    const pedidoId  = form.querySelector('[name="pedido_id"]').value;
    const nuevoEstado = form.querySelector('[name="nuevo_estado"]').value;
    const estadosLabel = { pendiente: 'Pendiente', en_proceso: 'En proceso', entregado: 'Entregado', cancelado: 'Cancelado' };

    mostrarPopup({
        tipo: 'confirm',
        titulo: 'Cambiar estado',
        mensaje: `¿Cambiar el pedido <strong>#${pedidoId}</strong> a <strong>${estadosLabel[nuevoEstado]}</strong>?`,
        labelOk: '✓ Confirmar',
        onOk: () => {
            const fd = new FormData(form);
            fetch('../controllers/pedido/actualizar_estado.php', { method: 'POST', body: new URLSearchParams(fd) })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar badge en la fila sin recargar
                        const fila = form.closest('tr');
                        fila.dataset.estado = nuevoEstado;
                        const badge = fila.querySelector('.badge');
                        badge.className = `badge badge-${nuevoEstado}`;
                        badge.textContent = estadosLabel[nuevoEstado];
                        mostrarPopup({ tipo: 'success', titulo: 'Estado actualizado', mensaje: `Pedido #${pedidoId} actualizado a <strong>${estadosLabel[nuevoEstado]}</strong>.` });
                    } else {
                        mostrarPopup({ tipo: 'error', titulo: 'Error', mensaje: data.mensaje || 'No se pudo actualizar el estado.' });
                    }
                })
                .catch(() => mostrarPopup({ tipo: 'error', titulo: 'Error de red', mensaje: 'No se pudo conectar con el servidor.' }));
        }
    });
}

// ── HELPERS ────────────────────────────────
function enviarFormulario(form, tabDestino, mensajeExito, callback) {
    const fd = new FormData(form);
    fetch(form.action, { method: 'POST', body: new URLSearchParams(fd) })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                form.reset();
                mostrarPopup({ tipo: 'success', titulo: '¡Listo!', mensaje: mensajeExito });
                recargarTablaProductos();
                if (typeof callback === 'function') callback(data);
                else if (tabDestino) irATab(tabDestino);
            } else {
                mostrarPopup({ tipo: 'error', titulo: 'Error', mensaje: data.mensaje || 'Ocurrió un error.' });
            }
        })
        .catch(() => mostrarPopup({ tipo: 'error', titulo: 'Error de red', mensaje: 'No se pudo conectar con el servidor.' }));
}

function actualizarContadorProductos() {
    const visibles = document.querySelectorAll('#tabla_productos tbody tr:not([style*="display: none"])').length;
    const total    = document.querySelectorAll('#tabla_productos tbody tr').length;
    document.getElementById('count_productos').textContent = `(${total})`;
}

function recargarTablaProductos() {
    // Recargar solo la tabla via fetch (simple: recargar la página en el tab actual)
    // Para evitar complejidad, hacemos un soft-reload manteniendo el tab
    window.location.href = window.location.pathname + '?tab=productos';
}

// ── FILTROS ────────────────────────────────
function filtrarProductos() {
    const texto  = document.getElementById('buscar_productos').value.toLowerCase();
    const catId  = document.getElementById('filtro_cat').value;
    const filas  = document.querySelectorAll('#tabla_productos tbody tr');
    let visibles = 0;
    filas.forEach(f => {
        const ok = (f.dataset.nombre.includes(texto) || f.dataset.desc.includes(texto))
                && (!catId || f.dataset.cat === catId);
        f.style.display = ok ? '' : 'none';
        if (ok) visibles++;
    });
    document.getElementById('count_productos').textContent = `(${visibles})`;
    document.getElementById('msg_productos').textContent   = texto || catId ? `${visibles} resultado${visibles !== 1 ? 's' : ''}` : '';
    document.getElementById('empty_productos').style.display = visibles === 0 ? 'block' : 'none';
}

function filtrarPedidos() {
    const texto  = document.getElementById('buscar_pedidos').value.toLowerCase();
    const estado = document.getElementById('filtro_estado').value;
    const filas  = document.querySelectorAll('#tabla_pedidos tbody tr');
    let visibles = 0;
    filas.forEach(f => {
        const ok = (f.dataset.cliente.includes(texto) || f.dataset.id.includes(texto))
                && (!estado || f.dataset.estado === estado);
        f.style.display = ok ? '' : 'none';
        if (ok) visibles++;
    });
    document.getElementById('count_pedidos').textContent = `(${visibles})`;
    document.getElementById('msg_pedidos').textContent   = texto || estado ? `${visibles} resultado${visibles !== 1 ? 's' : ''}` : '';
    document.getElementById('empty_pedidos').style.display = visibles === 0 ? 'block' : 'none';
}

// ── INIT ───────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const tp = document.querySelectorAll('#tabla_productos tbody tr').length;
    const td = document.querySelectorAll('#tabla_pedidos tbody tr').length;
    document.getElementById('count_productos').textContent = `(${tp})`;
    document.getElementById('count_pedidos').textContent   = `(${td})`;

    // Si la URL tiene ?tab=productos (post-edición) abrir ese tab
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab')) {
        const tabParam = params.get('tab');
        const btn = document.querySelector(`.tab_btn[data-tab="${tabParam}"]`);
        if (btn) cambiarTab(btn, tabParam);
        window.history.replaceState({}, '', window.location.pathname);
    }
});