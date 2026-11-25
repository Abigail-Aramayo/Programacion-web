# Programacion-web
Trabajo Práctico de Diseño UI/UX realizado en Figma.
## Descripción del Proyecto
# Kora Hair - Tu Brújula Capilar
Diseño completo de interfaz de usuario para la plataforma web del salón capilar y boutique Kora Hair. El proyecto incluye las 12 secciones principales maquetadas:
- Inicio
- Sobre mí
- Servicios
- Detalle de Servicio
- Agendar Turnos
- Boutique
- Detalle de Producto
- Carrito
- Test
- Contacto
- Login
- Registro

TRABAJO PRACTICO NRO 3
# Kora Hair - Sitio Web

Sitio web desarrollado para el salón de estética capilar **Kora Hair**. El proyecto combina diseño UI/UX personalizado (Figma) con un desarrollo web responsivo, optimizado y accesible.

## 🚀 Tecnologías Utilizadas
* **HTML5** (Estructura semántica de vistas)
* **Bootstrap 5.3** (Framework CSS y componentes responsivos)
* **CSS3 Custom Properties** (Estilos y paleta de colores de marca)
* **Git & GitHub** (Control de versiones, ramas y Pull Requests)

## 📱 Vistas del Proyecto
El sitio cuenta con 10 vistas maquetadas:
1. `index.html` (Inicio / Hero principal)
2. `servicios.html` (Catálogo de tratamientos capilares)
3. `detalle-servicio.html` (Información detallada de un servicio)
4. `boutique.html` (Tienda online de productos capilares)
5. `detalle-producto.html` (Vista individual de producto)
6. `carrito.html` (Gestión de compras)
7. `turnos.html` (Sistema de reserva de turnos)
8. `test.html` (Brújula capilar / Test interactivo)
9. `sobre-mi.html` (Presentación y bioseguridad del salón)
10. `contacto.html` (Medios de contacto y ubicación)

## 📊 Auditoría y Rendimiento (Lighthouse)
<img width="1314" height="635" alt="image" src="https://github.com/user-attachments/assets/7ec74cdb-516e-47cd-b9b9-d9153883173f" />
## Sitio de produccion estatica GitHub Pages
https://abigail-aramayo.github.io/Programacion-web/

---

# TRABAJO PRACTICO NRO 4
## Migración a PHP, Modularización (SSI) y SSR

Se evolucionó la maqueta estática del TP3 (HTML + Bootstrap) a una aplicación PHP:

- Las 12 pantallas pasaron de `.html` a `.php`.
- El `<head>`, el menú de navegación y el pie de página se extrajeron a plantillas reutilizables en `includes/` y se incluyen con `require_once` (Server Side Includes).
- El título de cada página (`<title>`) y el ítem activo del menú se generan dinámicamente desde el servidor (SSR).
- Los datos globales (nombre de la empresa, email de contacto y entorno) se leen de un archivo `.env` que **no se sube a Git**; el repositorio incluye `.env.example` como plantilla.

### Estructura del proyecto

```text
Programacion-web/
├── config/
│   └── env.php          
├── includes/
│   ├── header.php        
│   ├── nav.php          
│   └── footer.php        
├── css/  js/  img/  docs/capturas/
├── index.php  sobre-mi.php  servicios.php  detalle-servicios.php
├── turnos.php  boutique.php  detalle-del-producto.php  carrito.php
├── test.php  contacto.php  login.php  registro.php
├── .env                  
├── .env.example         
├── .gitignore
└── .htaccess          
```

### Instalación y ejecución local

1. Instalar [XAMPP](https://www.apachefriends.org/) (con PHP 8.x).
2. Clonar el repositorio dentro de `C:\xampp\htdocs`:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/Abigail-Aramayo/Programacion-web.git
   cd Programacion-web
   ```
3. Crear el archivo de variables de entorno:
   ```bash
   copy .env.example .env
   ```
4. Iniciar **Apache** desde el Panel de Control de XAMPP.
5. Abrir **http://localhost/Programacion-web/index.php**

### Variables de entorno

| Variable    | Descripción                       | Ejemplo                |
|-------------|-----------------------------------|------------------------|
| `APP_NAME`  | Nombre de la empresa / aplicación | `Kora Hair`            |
| `APP_EMAIL` | Email de soporte / contacto       | `contacto@ejemplo.com` |
| `APP_ENV`   | Entorno de ejecución              | `local`                |

### Evidencia de funcionamiento

**Servidor local ejecutándose**
![Sitio corriendo en localhost](docs/capturas/01-servidor-local.png)

**Estructura modular (SSI)**
![Carpeta includes](docs/capturas/02-estructura-modular.png)
![Código de una página usando require_once](docs/capturas/03-codigo-pagina.png)

**Navegación dinámica (título de pestaña y clase `active`)**
![Título dinámico y menú activo](docs/capturas/04-navegacion-dinamica.png)

**Variables de entorno**
![Archivo .env.example en el repositorio](docs/capturas/05-env-example.png)

### Flujo de trabajo con Git
- Rama de trabajo: `feature/migracion-php-ssi`, integrada a `main` mediante Pull Request.
- Commits atómicos y descriptivos.

### TRABAJO PRACTICO NRO 5

# CLASE 5 – Procesamiento de Formularios y Seguridad Web

**Unidad 4 – Programación del Lado Servidor (PHP)** · Programación Web · Profesor: Lic. Gabriel Artaza

## 1. Objetivo

Sobre el proyecto **Kora Hair** (maquetación responsive + estructura modular en PHP), se agregó la lógica del lado del servidor para **recibir y procesar datos de formularios** con los métodos **POST** y **GET**, aplicando **sanitización** y **validación** para prevenir ataques **XSS** (OWASP Top 10).

Todo el desarrollo de esta entrega está en la carpeta [`clase5/`](./clase5).

## 2. Formularios creados

| | Formulario de contacto | Buscador |
|---|---|---|
| **Método** | **POST** | **GET** |
| **Archivo** | [`clase5/contacto.php`](./clase5/contacto.php) | [`clase5/buscar.php`](./clase5/buscar.php) |
| **Para qué sirve** | Enviar una consulta al salón | Buscar servicios y productos del sitio |
| **Campos** | Nombre, Apellido, Email, Motivo de consulta, Mensaje | Texto a buscar (`q`) y Categoría |
| **Por qué ese método** | Los datos viajan en el cuerpo de la petición (no se ven en la URL) y el envío es una acción | Una búsqueda no modifica nada y el resultado se puede copiar y compartir como link (`buscar.php?q=nutri`) |

### 2.1 Formulario de contacto (POST)

Validaciones que se hacen en el servidor:

| Campo | Regla |
|---|---|
| Nombre y Apellido | Obligatorios, de 2 a 50 caracteres, solo letras y espacios |
| Email | Obligatorio y con formato válido (`filter_var` con `FILTER_VALIDATE_EMAIL`) |
| Motivo | Debe ser una de las opciones de la lista |
| Mensaje | Obligatorio, de 10 a 1000 caracteres |

### 2.2 Buscador (GET)

| Campo | Regla |
|---|---|
| Texto (`q`) | Obligatorio, de 2 a 50 caracteres |
| Categoría | Debe ser `todos`, `servicios` o `productos`; si llega otro valor se usa `todos` |

El buscador busca el texto dentro de los servicios y productos (`config/catalogo.php`) y muestra la cantidad de resultados.

## 3. Cómo se procesan los datos (seguridad)

Cada formulario sigue el mismo recorrido:

1. **Capturar:** se verifica el método (`$_SERVER['REQUEST_METHOD']`) y se leen los datos con `isset()` y `trim()`.
2. **Sanitizar:** se limpian las entradas con `strip_tags()` y `filter_var(..., FILTER_SANITIZE_EMAIL)`.
3. **Validar:** se comprueba con `empty()`, largo mínimo/máximo, `FILTER_VALIDATE_EMAIL` y listas de valores permitidos.
4. **Responder:** se muestra un mensaje de éxito o la lista de errores.
5. **Escapar al mostrar:** todo dato del usuario que se imprime pasa por `htmlspecialchars()`.

| Función de PHP | Para qué se usa en el proyecto |
|---|---|
| `trim()` | Quitar espacios al inicio y al final de lo que escribe el usuario |
| `isset()` / `empty()` | Verificar que el campo exista y que no llegue vacío |
| `strip_tags()` | Eliminar etiquetas HTML (por ejemplo `<script>`) de los textos |
| `filter_var()` | Sanitizar y validar el email |
| `htmlspecialchars()` | Convertir caracteres especiales en texto inofensivo al mostrarlos (función `e()`) |

Las funciones propias están en [`clase5/includes/formularios.php`](./clase5/includes/formularios.php) (`capturar()`, `sanitizar_texto()`, `largo()`) y `e()` está en `clase5/config/env.php`.

**Prevención de XSS – ejemplo:** si alguien escribe `<script>alert(1)</script>` en un campo, el script **no se ejecuta**: primero se eliminan las etiquetas y, además, al imprimir se escapan los caracteres especiales. Se ve en la captura 4.

## 4. Mensajes y persistencia

- **Mensajes:** si el envío es correcto aparece un mensaje verde; si hay errores aparece un cuadro rojo con la lista de lo que hay que corregir y los campos con error se resaltan.
- **Persistencia:** si hay un error, los campos conservan lo que el usuario ya escribió (`value="<?= e($datos['nombre']) ?>"`), para no tener que volver a escribir todo.
- Se usa `novalidate` en los formularios para que la validación que responda sea la del servidor (PHP) y no solo la del navegador.

## 5. Capturas de pantalla

**1. Formulario de contacto (POST)**
![Formulario de contacto vacío](clase5/docs/capturas/01-contacto.png)

**2. Validación: errores en pantalla y campos conservados**
![Errores de validación](clase5/docs/capturas/02-contacto-errores.png)

**3. Envío exitoso: mensaje de confirmación**
![Envío exitoso](clase5/docs/capturas/03-contacto-exito.png)

**4. Prevención de XSS: el script ingresado no se ejecuta**
![XSS bloqueado](clase5/docs/capturas/04-xss-bloqueado.png)

**5. Buscador (GET): resultados y parámetros en la URL (`?q=nutri`)**
![Buscador con resultados](clase5/docs/capturas/05-buscador-resultados.png)

**6. Buscador: validación de búsqueda inválida**
![Error del buscador](clase5/docs/capturas/06-buscador-error.png)


## TRABAJO PRÁCTICO Nº 6 – Bases de Datos: Normalización y SQL

Diseño de la base de datos de **Kora Hair** (turnos y boutique), aplicando normalización y comandos SQL (DDL y CRUD) en MySQL.

### Archivos
| Archivo | Contenido |
|---|---|
| `tp6/NORMALIZACION.md` | Tabla sin normalizar, proceso 1FN → 2FN → 3FN y listado final de tablas |
| `tp6/schema.sql` | DDL: creación de la base, las 11 tablas, claves, relaciones e índices |
| `tp6/consultas.sql` | DML: CRUD completo (INSERT, SELECT, UPDATE, DELETE) |

### 1. Normalización
Se partió de una tabla de pedidos con campos multivalorados (productos, cantidades y precios en una sola celda) y se normalizó:
- **1FN:** un valor por celda, una fila por producto del pedido.
- **2FN:** se eliminan dependencias parciales → `pedidos`, `productos`, `detalle_pedidos`.
- **3FN:** se eliminan dependencias transitivas → `categorias`, `usuarios`, `roles`, `estados_pedido`.

Resultado: **11 tablas** — `roles`, `usuarios`, `categorias`, `productos`, `servicios`, `estados_turno`, `turnos`, `estados_pedido`, `pedidos`, `detalle_pedidos` y `consultas`.

Relaciones principales:
- 1:N: categoría → productos, usuario → turnos, usuario → pedidos, rol → usuarios.
- N:M: pedidos ↔ productos, resuelta con la tabla intermedia `detalle_pedidos`.

![Diagrama de relaciones](docs/capturas/tp6-01-diagrama.png)

### 2. Creación de la base (DDL)
`schema.sql` crea la base `kora_hair` (utf8mb4) y las tablas con clave primaria autoincremental, claves foráneas, restricciones `NOT NULL` y `UNIQUE`, campos `created_at` / `updated_at` e índices.

![Creación de tablas](docs/capturas/tp6-02-creacion.png)

### 3. CRUD (DML)
**Create (INSERT):** carga de roles, categorías, estados, usuarios, productos, turnos, un pedido con su detalle y una consulta de prueba. Las contraseñas se guardan como hash.

![Datos cargados](docs/capturas/tp6-03-insert.png)

**Read (SELECT):**
1. `WHERE` + `ORDER BY`: productos de más de $12.000, del más caro al más barato.
2. `INNER JOIN`: productos con su categoría.
3. `INNER JOIN` de 4 tablas: turnos con cliente, servicio y estado.
4. Detalle de un pedido (relación N:M) con subtotal.

![Consulta 1](docs/capturas/tp6-04-select-where.png)
![Consulta 2](docs/capturas/tp6-05-join-productos.png)
![Consulta 3](docs/capturas/tp6-06-join-turnos.png)
![Consulta 4](docs/capturas/tp6-07-detalle-pedido.png)

**Update:** cambio de precio de un producto y confirmación de un turno, siempre con `WHERE`.

![Update comprobado](docs/capturas/tp6-08-update.png)

**Delete:** baja de una consulta de prueba con `WHERE`; la comprobación devuelve 0 filas.

![Delete comprobado](docs/capturas/tp6-09-delete.png)

### Cómo reproducirlo
1. Iniciar Apache y MySQL en XAMPP y abrir `http://localhost/phpmyadmin`.
2. Pestaña **SQL**: ejecutar `tp6/schema.sql`.
3. Ejecutar `tp6/consultas.sql` por bloques (C, R, U, D).