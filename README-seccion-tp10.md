## TRABAJO PRÁCTICO Nº 10 – Refactorización a MVC e implementación con Framework

**Unidad 5 – Interacción Avanzada y Frameworks** · Programación Web · Docente: Lic. Gabriel Artaza

### Objetivo
Aplicar el patrón **Modelo-Vista-Controlador (MVC)**: primero reorganizando un módulo propio en PHP puro (Parte A) y después construyendo un módulo nuevo con un framework profesional, **CodeIgniter 4** (Parte B).

| Capa | Responsabilidad |
|---|---|
| **Modelo** | Acceso a datos: todo el SQL (PDO / Query Builder). No conoce HTML ni `$_GET`/`$_POST`. |
| **Vista** | Marcado HTML. Solo muestra los datos que recibe. |
| **Controlador** | Recibe la solicitud, valida, le pide datos al modelo y elige la vista. |

---

## Parte A – Refactorización nativa (PHP puro)

**Módulo elegido:** catálogo de productos (el CRUD de administración del TP7, protegido por el login del TP8).

### Antes y después
| Antes (TP7) | Después (TP10) |
|---|---|
| `admin/index.php`, `crear.php`, `editar.php`, `eliminar.php` mezclaban SQL, validación y HTML en el mismo archivo | Cada archivo de `admin/` solo protege la página y llama al controlador (4 líneas) |
| `admin/_validar.php` y `admin/_form.php` | La validación pasó al controlador y el formulario a una vista parcial |

### Estructura
```
app/
├── autoload.php                      Carga automática de clases (App\Models\... -> app/Models/...)
├── Core/Controller.php               Controlador base: render() y redirigir()
├── Models/
│   ├── ProductoModel.php             SQL de productos (consultas preparadas)
│   └── CategoriaModel.php            SQL de categorías
├── Controllers/
│   └── ProductoController.php        index · crear · editar · eliminar
└── Views/productos/
    ├── listado.php                   Tabla de productos
    ├── crear.php / editar.php        Páginas de alta y modificación
    └── _formulario.php               Formulario compartido
admin/                                Puntos de entrada (index, crear, editar, eliminar)
```

### Flujo de una petición
```
admin/editar.php?id=3
   │  1. auth_guard.php  (¿hay sesión y es admin?)
   ▼
ProductoController::editar()      ← CONTROLADOR: valida el id y los datos
   │  2. pide el producto
   ▼
ProductoModel::buscarPorId(3)     ← MODELO: SELECT con PDO preparado
   │  3. devuelve los datos
   ▼
Views/productos/editar.php        ← VISTA: solo HTML con los datos
```

El comportamiento es idéntico al del TP7 (mismas validaciones, mensajes y protecciones); lo que cambió es **dónde vive cada responsabilidad**.

---

## Parte B – Módulo con framework (CodeIgniter 4)

**Módulo:** *Catálogo Kora Hair*, independiente del sitio, en la carpeta [`kora-framework/`](./kora-framework). Usa la misma base de datos `kora_hair` y tiene dos partes: páginas HTML y una **API REST** que devuelve JSON.

### Lo que se configuró en el framework
| Elemento | Archivo | Qué hace |
|---|---|---|
| **Routing** | `app/Config/Routes.php` | `catalogo`, `catalogo/(:num)`, `api/productos`, `api/productos/(:num)` |
| **Controlador** | `app/Controllers/Catalogo.php` | Páginas HTML (listado con filtro por categoría y detalle) |
| **Controlador** | `app/Controllers/ApiProductos.php` | Respuestas JSON con código 200 / 404 |
| **Modelo** | `app/Models/ProductoModel.php`, `CategoriaModel.php` | Extienden `CodeIgniter\Model`; consultas con el **Query Builder** (`select`, `join`, `where`, `selectCount`, `selectAvg`...) |
| **Vistas** | `app/Views/layouts/principal.php`, `catalogo/index.php`, `catalogo/detalle.php` | Motor de plantillas de CI4: `extend`, `section`, `renderSection`, `esc()` |

### URLs del módulo
| URL | Qué muestra |
|---|---|
| `/catalogo` | Listado de productos + reporte (total, stock, precio promedio) |
| `/catalogo?categoria=2` | Listado filtrado por categoría |
| `/catalogo/3` | Detalle de un producto (404 si no existe) |
| `/api/productos` | JSON con todos los productos activos |
| `/api/productos/3` | JSON de un producto (404 si no existe) |

### Cómo ejecutarlo
1. Descargar CodeIgniter 4 (instalación manual) desde <https://github.com/codeigniter4/framework/releases/latest> y extraerlo en `kora-framework/`.
2. Copiar encima los archivos de este módulo (`app/`, `public/`).
3. Copiar el archivo `env` como `.env` y configurar:
   ```
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   database.default.hostname = localhost
   database.default.database = kora_hair
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```
4. Con MySQL iniciado, desde `kora-framework/`: `C:\xampp\php\php.exe spark serve`
5. Abrir <http://localhost:8080/catalogo>

### Comparación: MVC nativo vs. framework
| | PHP puro (Parte A) | CodeIgniter 4 (Parte B) |
|---|---|---|
| Rutas | Un archivo por página (`admin/editar.php`) | Tabla de rutas centralizada (`Routes.php`) |
| Carga de clases | `spl_autoload_register` escrito a mano | Autoload del framework por namespaces |
| Acceso a datos | PDO con SQL escrito a mano | Query Builder del framework |
| Vistas | `require` de archivos PHP | Plantillas con layouts y secciones |
| Respuestas JSON / 404 | `header()` + `json_encode()` manual | `$this->response->setJSON()`, excepciones de 404 |
| Seguridad | Se programa cada protección | El framework aporta `esc()`, filtros, CSRF configurable |

### Capturas
