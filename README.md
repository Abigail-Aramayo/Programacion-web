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
