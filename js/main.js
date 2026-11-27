/* =========================================================
   KORA HAIR · Comportamiento del lado del cliente
   (carrito, filtros, calendario de turnos, test capilar)
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  const formatoPesos = (n) => '$' + n.toLocaleString('es-AR');

  /* ---------- Carrito (contador en el header, guardado en el navegador) ---------- */
  const badge = document.querySelector('[data-carrito-badge]');
  const leerCarrito = () => { try { return parseInt(localStorage.getItem('kora_carrito') ?? '1', 10) || 0; } catch { return 1; } };
  const guardarCarrito = (n) => { try { localStorage.setItem('kora_carrito', String(n)); } catch { /* sin almacenamiento */ } };
  const pintarBadge = () => { if (badge) { const n = leerCarrito(); badge.textContent = n; badge.hidden = n === 0; } };
  pintarBadge();

  // TP9: delegación de eventos -> también funciona con los productos creados dinámicamente por fetch
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-agregar]');
    if (!btn) return;
    const qty = btn.closest('.compra')?.querySelector('[data-valor]');
    guardarCarrito(leerCarrito() + (qty ? parseInt(qty.textContent, 10) : 1));
    pintarBadge();
  });

  /* ---------- Favoritos ---------- */
  document.addEventListener('click', (e) => {
    const b = e.target.closest('.producto__fav');
    if (!b) return;
    b.classList.toggle('activo');
    b.querySelector('i').className = b.classList.contains('activo') ? 'bi bi-heart-fill' : 'bi bi-heart';
    b.querySelector('i').style.color = b.classList.contains('activo') ? 'var(--k-rosa)' : '';
  });

  /* ---------- Selector de cantidad ---------- */
  const recalcularCarrito = () => {
    const items = document.querySelectorAll('.carrito-item');
    if (!items.length && !document.getElementById('subtotal')) return;
    let subtotal = 0, unidades = 0;
    items.forEach((it) => {
      const cant = parseInt(it.querySelector('[data-valor]').textContent, 10);
      const total = cant * parseInt(it.dataset.precio, 10);
      it.querySelector('[data-total-item]').textContent = formatoPesos(total);
      subtotal += total; unidades += cant;
    });
    document.getElementById('subtotal').textContent = formatoPesos(subtotal);
    document.getElementById('totalPedido').textContent = formatoPesos(subtotal);
    document.getElementById('carritoVacio').hidden = items.length > 0;
    guardarCarrito(unidades); pintarBadge();
  };

  document.querySelectorAll('[data-cantidad]').forEach((box) => {
    const valor = box.querySelector('[data-valor]');
    box.querySelector('[data-menos]').addEventListener('click', () => { valor.textContent = Math.max(1, parseInt(valor.textContent, 10) - 1); recalcularCarrito(); });
    box.querySelector('[data-mas]').addEventListener('click', () => { valor.textContent = Math.min(20, parseInt(valor.textContent, 10) + 1); recalcularCarrito(); });
  });
  document.querySelectorAll('[data-quitar]').forEach((b) => b.addEventListener('click', () => { b.closest('.carrito-item').remove(); recalcularCarrito(); }));

  /* ---------- Filtros de la boutique ---------- */
  // TP9: si la grilla es dinámica (data-dinamico), los filtros los maneja js/buscador.js con fetch
  const chips = document.querySelectorAll('[data-filtro]');
  const grillaDinamica = document.querySelector('#gridProductos[data-dinamico]');
  if (chips.length && !grillaDinamica) {
    chips.forEach((chip) => chip.addEventListener('click', () => {
      chips.forEach((c) => c.classList.remove('activo'));
      chip.classList.add('activo');
      let visibles = 0;
      document.querySelectorAll('#gridProductos .producto').forEach((p) => {
        const ok = chip.dataset.filtro === 'todos' || p.dataset.categoria === chip.dataset.filtro;
        p.classList.toggle('oculto', !ok);
        if (ok) visibles++;
      });
      document.getElementById('totalProductos').textContent = visibles + (visibles === 1 ? ' producto' : ' productos');
    }));
  }

  /* ---------- Calendario de turnos ---------- */
  const grid = document.getElementById('calGrid');
  if (grid) {
    const dias = ['LUN', 'MAR', 'MIÉ', 'JUE', 'VIE', 'SÁB', 'DOM'];
    const horas = ['08:30', '10:15', '12:00', '14:30', '16:00', '17:15'];
    const hoy = new Date(); hoy.setHours(0, 0, 0, 0);
    let vista = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    let diaSel = null, horaSel = null;
    const fmtLargo = (d) => d.toLocaleDateString('es-AR', { weekday: 'long', day: 'numeric', month: 'long' });

    const pintarHoras = () => {
      const lista = document.getElementById('horasLista');
      lista.innerHTML = '';
      horas.forEach((h) => {
        const b = document.createElement('button');
        b.type = 'button'; b.className = 'hora' + (h === horaSel ? ' sel' : ''); b.textContent = h;
        b.addEventListener('click', () => { horaSel = h; pintarHoras(); resumen(); });
        lista.appendChild(b);
      });
    };
    const resumen = () => {
      document.getElementById('horaFecha').textContent = diaSel ? fmtLargo(diaSel) : 'Elegí un día';
      document.getElementById('resFecha').textContent = diaSel ? fmtLargo(diaSel) : 'A seleccionar';
      document.getElementById('resHora').textContent = horaSel ? horaSel + ' hs' : 'A seleccionar';
    };
    const pintarCal = () => {
      const mes = vista.toLocaleDateString('es-AR', { month: 'long' });
      document.getElementById('calMes').textContent = mes.charAt(0).toUpperCase() + mes.slice(1) + ' ' + vista.getFullYear();
      grid.innerHTML = dias.map((d) => `<div class="cal__dow">${d}</div>`).join('');
      const primero = (new Date(vista.getFullYear(), vista.getMonth(), 1).getDay() + 6) % 7;
      const total = new Date(vista.getFullYear(), vista.getMonth() + 1, 0).getDate();
      for (let i = 0; i < primero; i++) grid.insertAdjacentHTML('beforeend', '<div></div>');
      for (let n = 1; n <= total; n++) {
        const f = new Date(vista.getFullYear(), vista.getMonth(), n);
        const dom = f.getDay() === 0, lun = f.getDay() === 1;
        const b = document.createElement('button');
        b.type = 'button'; b.className = 'cal__dia'; b.innerHTML = `<span>${n}</span>`;
        b.disabled = f < hoy || dom || lun;   // el salón abre de martes a sábado
        if (diaSel && f.getTime() === diaSel.getTime()) b.classList.add('sel');
        b.addEventListener('click', () => { diaSel = f; horaSel = null; pintarCal(); pintarHoras(); resumen(); });
        grid.appendChild(b);
      }
    };
    document.getElementById('calPrev').addEventListener('click', () => { vista = new Date(vista.getFullYear(), vista.getMonth() - 1, 1); pintarCal(); });
    document.getElementById('calNext').addEventListener('click', () => { vista = new Date(vista.getFullYear(), vista.getMonth() + 1, 1); pintarCal(); });
    pintarCal(); pintarHoras(); resumen();
  }

  /* ---------- Test: Tu brújula capilar ---------- */
  const opcionesBox = document.getElementById('testOpciones');
  if (opcionesBox) {
    const preguntas = [
      { t: '¿Cómo sentís tu cabello hoy?', s: 'Elegí la opción que más se acerque a vos.',
        o: [['Seco y opaco', 'nutricion'], ['Con frizz', 'hidratacion'], ['Débil o quebrado', 'reconstruccion'], ['Sin volumen', 'hidratacion']] },
      { t: '¿Con qué frecuencia usás calor?', s: 'Planchita, secador o buclera.',
        o: [['Casi nunca', 'hidratacion'], ['Una o dos veces por semana', 'nutricion'], ['Todos los días', 'reconstruccion'], ['Uso productos químicos', 'reconstruccion']] },
      { t: '¿Qué te gustaría lograr?', s: 'Pensá en tu cabello ideal.',
        o: [['Más brillo y suavidad', 'nutricion'], ['Más fuerza', 'reconstruccion'], ['Más movimiento', 'hidratacion'], ['Cuidar lo que ya tengo', 'nutricion']] },
    ];
    const resultados = {
      nutricion: ['nutrición profunda.', 'Por tus respuestas, recomendamos comenzar con un ritual de nutrición y sostenerlo con productos liviano en casa.'],
      hidratacion: ['hidratación + suavidad.', 'Por tus respuestas, recomendamos un ritual de hidratación y una rutina simple para mantener el movimiento natural.'],
      reconstruccion: ['reconstrucción + nutrición.', 'Por tus respuestas, recomendamos comenzar con un ritual reparador y sostenerlo con nutrición liviana en casa.'],
    };
    let paso = 0; const votos = {};
    const pintar = () => {
      const p = preguntas[paso];
      document.getElementById('testPaso').textContent = `Pregunta ${paso + 1} de ${preguntas.length}`;
      document.getElementById('testBarra').style.width = ((paso + 1) / preguntas.length * 100) + '%';
      document.getElementById('testTitulo').textContent = p.t;
      document.getElementById('testSub').textContent = p.s;
      opcionesBox.innerHTML = '';
      p.o.forEach(([txt, clave], i) => {
        const b = document.createElement('button');
        b.type = 'button'; b.className = 'opcion';
        b.innerHTML = `<b>${'ABCD'[i]}</b>${txt}<i class="bi bi-chevron-right"></i>`;
        b.addEventListener('click', () => {
          votos[clave] = (votos[clave] || 0) + 1; paso++;
          if (paso < preguntas.length) { pintar(); return; }
          const ganador = Object.entries(votos).sort((a, b2) => b2[1] - a[1])[0][0];
          document.getElementById('testPregunta').hidden = true;
          document.getElementById('testResultado').hidden = false;
          document.getElementById('testResTexto').textContent = resultados[ganador][0];
          document.getElementById('testResDesc').textContent = resultados[ganador][1];
        });
        opcionesBox.appendChild(b);
      });
    };
    pintar();
  }

  /* ---------- Formularios de demostración (el envío real se agrega con PHP) ---------- */
  document.querySelectorAll('[data-form-demo]').forEach((f) => {
    f.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!f.checkValidity()) { f.reportValidity(); return; }
      const ok = f.querySelector('.mensaje-ok');
      if (ok) ok.hidden = false;
      f.reset();
    });
  });
});
