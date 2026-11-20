<?php
$titulo_pagina      = 'Boutique';
$descripcion_pagina = 'La boutique Kora: productos seleccionados para cuidar tu cabello en casa.';
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="boutique-hero">
      <div class="k-container boutique-hero__grid">
        <div style="padding-block:3rem">
          <span class="eyebrow eyebrow--claro" style="color:#fff">Boutique capilar</span>
          <h1 class="h-xl">Tu ritual Kora,<br><em>todos los días.</em></h1>
          <p>Una selección consciente para cuidar en casa lo que construimos en el salón.</p>
        </div>
        <div class="boutique-hero__frasco"><img class="boutique-hero__img" src="img/producto-reparador.jpg" alt="Reparador de Puntas, frasco violeta de 45 ml"></div></div>
      </div>
    </section>

    <section style="padding-bottom:5rem">
      <div class="k-container">
        <div class="filtros">
          <div class="filtros__chips" role="group" aria-label="Filtrar productos">
            <button class="chip activo" type="button" data-filtro="todos">Todos</button>
            <button class="chip" type="button" data-filtro="nutricion">Nutrición</button>
            <button class="chip" type="button" data-filtro="limpieza">Limpieza</button>
            <button class="chip" type="button" data-filtro="tratamiento">Tratamiento</button>
          </div>
          <span class="filtros__total" id="totalProductos">3 productos</span>
        </div>
        <div class="productos productos--3" id="gridProductos">
          <article class="producto" data-categoria="tratamiento">
            <a href="detalle-del-producto.php" class="producto__img producto__img--negro" aria-label="Ver Reparador de Puntas">
              <span class="producto__tag">Más vendido</span>
              <img src="img/producto-reparador.jpg" alt="Frasco de Reparador de Puntas Influencia Profesional de 45 ml" loading="lazy">
            </a>
            <button class="producto__fav" type="button" aria-label="Guardar en favoritos"><i class="bi bi-heart"></i></button>
            <div class="producto__info">
              <span class="producto__cat">Tratamiento</span>
              <h3><a href="detalle-del-producto.php">Reparador de Puntas</a></h3>
              <p class="producto__desc">Reparación &amp; brillo</p>
              <div class="producto__fila">
                <span class="producto__precio">$14.500</span>
                <button class="mas-btn" type="button" data-agregar aria-label="Agregar Reparador de Puntas al carrito"><i class="bi bi-plus"></i></button>
              </div>
            </div>
          </article>
          <article class="producto" data-categoria="limpieza">
            <a href="detalle-del-producto.php" class="producto__img producto__img--blanco" aria-label="Ver Shampoo Extra-Suave">
              <span class="producto__tag">Nuevo</span>
              <img src="img/producto-shampoo.jpg" alt="Shampoo Extra-Suave Ducray de 200 ml" loading="lazy">
            </a>
            <button class="producto__fav" type="button" aria-label="Guardar en favoritos"><i class="bi bi-heart"></i></button>
            <div class="producto__info">
              <span class="producto__cat">Limpieza</span>
              <h3><a href="detalle-del-producto.php">Shampoo Extra-Suave</a></h3>
              <p class="producto__desc">Limpieza delicada</p>
              <div class="producto__fila">
                <span class="producto__precio">$11.800</span>
                <button class="mas-btn" type="button" data-agregar aria-label="Agregar Shampoo Extra-Suave al carrito"><i class="bi bi-plus"></i></button>
              </div>
            </div>
          </article>
          <article class="producto" data-categoria="nutricion">
            <a href="detalle-del-producto.php" class="producto__img producto__img--foto" aria-label="Ver Máscara Nutritiva Keratina">
              <img src="img/producto-mascara.jpg" alt="Máscara Nutritiva con Keratina, jojoba y lino" loading="lazy">
            </a>
            <button class="producto__fav" type="button" aria-label="Guardar en favoritos"><i class="bi bi-heart"></i></button>
            <div class="producto__info">
              <span class="producto__cat">Nutrición</span>
              <h3><a href="detalle-del-producto.php">Máscara Nutritiva Keratina</a></h3>
              <p class="producto__desc">Nutrición profunda</p>
              <div class="producto__fila">
                <span class="producto__precio">$18.900</span>
                <button class="mas-btn" type="button" data-agregar aria-label="Agregar Máscara Nutritiva Keratina al carrito"><i class="bi bi-plus"></i></button>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
