/* =========================================================
   KORA HAIR · TP9 · Buscador de la boutique con Fetch API
   Evento (input / click) -> fetch() a la API PHP -> JSON -> DOM
   Sin recargar la página.
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  const grilla = document.getElementById('gridProductos');
  const input  = document.getElementById('inputBusqueda');
  const total  = document.getElementById('totalProductos');
  const chips  = document.querySelectorAll('[data-filtro]');
  if (!grilla || !input) return;                       // solo corre en la boutique

  const URL_API = 'api/buscar_productos.php';
  const formatoPesos = (n) => '$' + Number(n).toLocaleString('es-AR', { minimumFractionDigits: Number.isInteger(Number(n)) ? 0 : 2 });

  let categoria = 'todos';
  let temporizador = null;
  let controlador = null;                              // para cancelar la petición anterior

  /* ---------- 1) Pedir datos al servidor ---------- */
  async function cargarProductos() {
    // Si el usuario sigue escribiendo, se cancela la petición vieja (evita resultados desordenados)
    if (controlador) controlador.abort();
    controlador = new AbortController();

    const params = new URLSearchParams();
    if (input.value.trim() !== '') params.set('q', input.value.trim());
    if (categoria !== 'todos') params.set('categoria', categoria);

    mostrarMensaje('Buscando…');

    try {
      const respuesta = await fetch(`${URL_API}?${params}`, { signal: controlador.signal });
      const res = await respuesta.json().catch(() => null);   // si no es JSON válido -> null

      if (!respuesta.ok) {
        // 400, 404, 500... el servidor manda { status:'error', message:'...' }
        throw new Error(res?.message ?? `Error HTTP: ${respuesta.status}`);
      }
      if (res?.status === 'success') {
        renderizar(res.data);
      }
    } catch (error) {
      if (error.name === 'AbortError') return;         // cancelada a propósito: no es un error
      console.error('Error al realizar la petición:', error);
      mostrarMensaje('No pudimos cargar los productos. Probá de nuevo en un momento.', true);
    }
  }

  /* ---------- 2) Dibujar los resultados en el DOM ---------- */
  function renderizar(productos) {
    grilla.replaceChildren();                          // vacía solo esta sección

    total.textContent = productos.length + (productos.length === 1 ? ' producto' : ' productos');

    if (productos.length === 0) {
      mostrarMensaje('No encontramos productos con esa búsqueda.');
      return;
    }
    productos.map(crearTarjeta).forEach((tarjeta) => grilla.appendChild(tarjeta));
  }

  // Se arma con createElement + textContent (no innerHTML): evita XSS si un dato trae HTML
  function crearTarjeta(p) {
    const article = el('article', 'producto');
    article.dataset.categoria = p.categoria.toLowerCase();

    const enlaceImg = el('a', 'producto__img producto__img--foto');
    enlaceImg.href = 'detalle-del-producto.php';
    enlaceImg.setAttribute('aria-label', 'Ver ' + p.nombre);
    if (p.imagen) {
      const img = el('img');
      img.src = 'img/' + encodeURIComponent(p.imagen);
      img.alt = p.nombre;
      img.loading = 'lazy';
      img.addEventListener('error', () => img.remove());   // si la imagen no existe, no se ve rota
      enlaceImg.appendChild(img);
    }

    const fav = el('button', 'producto__fav');
    fav.type = 'button';
    fav.setAttribute('aria-label', 'Guardar en favoritos');
    fav.appendChild(el('i', 'bi bi-heart'));

    const info = el('div', 'producto__info');
    info.appendChild(el('span', 'producto__cat', p.categoria));

    const h3 = el('h3');
    const enlace = el('a', '', p.nombre);
    enlace.href = 'detalle-del-producto.php';
    h3.appendChild(enlace);
    info.appendChild(h3);

    info.appendChild(el('p', 'producto__desc', p.descripcion ?? ''));

    const fila = el('div', 'producto__fila');
    fila.appendChild(el('span', 'producto__precio', formatoPesos(p.precio)));
    const mas = el('button', 'mas-btn');
    mas.type = 'button';
    mas.setAttribute('data-agregar', '');
    mas.setAttribute('aria-label', 'Agregar ' + p.nombre + ' al carrito');
    mas.appendChild(el('i', 'bi bi-plus'));
    fila.appendChild(mas);
    info.appendChild(fila);

    article.append(enlaceImg, fav, info);
    return article;
  }

  function el(etiqueta, clases = '', texto = '') {
    const nodo = document.createElement(etiqueta);
    if (clases) nodo.className = clases;
    if (texto) nodo.textContent = texto;
    return nodo;
  }

  function mostrarMensaje(texto, esError = false) {
    const p = el('p', esError ? 'productos__mensaje productos__mensaje--error' : 'productos__mensaje', texto);
    p.setAttribute('role', esError ? 'alert' : 'status');
    grilla.replaceChildren(p);
  }

  /* ---------- 3) Eventos del usuario ---------- */
  // Escribir en el buscador: debounce de 300 ms para no pedir en cada tecla
  input.addEventListener('input', () => {
    clearTimeout(temporizador);
    temporizador = setTimeout(cargarProductos, 300);
  });

  // Chips de categoría
  chips.forEach((chip) => chip.addEventListener('click', () => {
    chips.forEach((c) => c.classList.remove('activo'));
    chip.classList.add('activo');
    categoria = chip.dataset.filtro;
    cargarProductos();
  }));

  cargarProductos();                                   // carga inicial desde la base de datos
});
