-- ============================================================
-- schema.sql  ·  TP6 · Programación Web
-- Proyecto: Kora Hair – Tu Brújula Capilar (salón y boutique)
-- Motor: MySQL / MariaDB (XAMPP, Laragon, phpMyAdmin)
-- ============================================================

-- 1) Base de datos -------------------------------------------
CREATE DATABASE IF NOT EXISTS kora_hair
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE kora_hair;

-- Para poder re-ejecutar el script sin errores (borra en orden inverso a las FK)
DROP TABLE IF EXISTS detalle_pedidos;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS turnos;
DROP TABLE IF EXISTS consultas;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS servicios;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS estados_pedido;
DROP TABLE IF EXISTS estados_turno;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS roles;

-- 2) Tablas maestras -----------------------------------------

-- Roles de usuario (admin, usuario...)
CREATE TABLE roles (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nombre      VARCHAR(30)  NOT NULL UNIQUE,
  descripcion VARCHAR(150) NULL
) ENGINE=InnoDB;

-- Categorías de la boutique (Tratamiento, Protección, Nutrición...)
CREATE TABLE categorias (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nombre      VARCHAR(60)  NOT NULL UNIQUE,
  descripcion VARCHAR(200) NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Estados posibles de un turno (pendiente, confirmado, cancelado, realizado)
CREATE TABLE estados_turno (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Estados posibles de un pedido (pendiente, pagado, enviado, entregado, cancelado)
CREATE TABLE estados_pedido (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 3) Usuarios -------------------------------------------------
CREATE TABLE usuarios (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  rol_id     INT          NOT NULL,
  nombre     VARCHAR(100) NOT NULL,
  apellido   VARCHAR(50)  NULL,
  email      VARCHAR(120) NOT NULL UNIQUE,      -- se usa para el login
  password   VARCHAR(255) NOT NULL,             -- hash (password_hash), nunca texto plano
  telefono   VARCHAR(25)  NULL,
  activo     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_usuarios_rol FOREIGN KEY (rol_id) REFERENCES roles(id)
) ENGINE=InnoDB;

-- 4) Catálogo: servicios y productos --------------------------
CREATE TABLE servicios (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nombre       VARCHAR(80)   NOT NULL,
  descripcion  TEXT          NULL,
  duracion_min INT           NOT NULL,          -- duración en minutos
  precio       DECIMAL(10,2) NOT NULL,
  activo       TINYINT(1)    NOT NULL DEFAULT 1,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE productos (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  categoria_id INT           NOT NULL,
  nombre       VARCHAR(100)  NOT NULL,
  descripcion  TEXT          NULL,
  precio       DECIMAL(10,2) NOT NULL,
  stock        INT           NOT NULL DEFAULT 0,
  imagen       VARCHAR(200)  NULL,              -- nombre del archivo en /img
  activo       TINYINT(1)    NOT NULL DEFAULT 1,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_productos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB;

-- 5) Turnos (reserva de un servicio por un usuario) -----------
CREATE TABLE turnos (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id  INT      NOT NULL,
  servicio_id INT      NOT NULL,
  estado_id   INT      NOT NULL,
  fecha_hora  DATETIME NOT NULL,
  notas       VARCHAR(255) NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_turnos_usuario  FOREIGN KEY (usuario_id)  REFERENCES usuarios(id),
  CONSTRAINT fk_turnos_servicio FOREIGN KEY (servicio_id) REFERENCES servicios(id),
  CONSTRAINT fk_turnos_estado   FOREIGN KEY (estado_id)   REFERENCES estados_turno(id)
) ENGINE=InnoDB;

-- 6) Pedidos de la boutique y su detalle (relación N:M) -------
CREATE TABLE pedidos (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT           NOT NULL,
  estado_id  INT           NOT NULL,
  total      DECIMAL(10,2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_pedidos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  CONSTRAINT fk_pedidos_estado  FOREIGN KEY (estado_id)  REFERENCES estados_pedido(id)
) ENGINE=InnoDB;

-- Un pedido tiene muchos productos y un producto está en muchos pedidos
CREATE TABLE detalle_pedidos (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id       INT           NOT NULL,
  producto_id     INT           NOT NULL,
  cantidad        INT           NOT NULL DEFAULT 1,
  precio_unitario DECIMAL(10,2) NOT NULL,       -- precio al momento de la compra
  CONSTRAINT fk_detalle_pedido   FOREIGN KEY (pedido_id)   REFERENCES pedidos(id)   ON DELETE CASCADE,
  CONSTRAINT fk_detalle_producto FOREIGN KEY (producto_id) REFERENCES productos(id),
  CONSTRAINT uq_detalle UNIQUE (pedido_id, producto_id)  -- no repetir el mismo producto en un pedido
) ENGINE=InnoDB;

-- 7) Consultas recibidas desde el formulario de contacto (TP5) -
CREATE TABLE consultas (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(50)  NOT NULL,
  apellido   VARCHAR(50)  NOT NULL,
  email      VARCHAR(120) NOT NULL,
  motivo     VARCHAR(30)  NOT NULL,             -- asesoramiento | turno | producto | otro
  mensaje    TEXT         NOT NULL,
  leida      TINYINT(1)   NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 8) Índices de rendimiento ----------------------------------
-- Filtrar productos por categoría (la boutique lo hace todo el tiempo)
CREATE INDEX idx_productos_categoria ON productos (categoria_id);
-- Buscar productos por nombre (buscador del TP5)
CREATE INDEX idx_productos_nombre ON productos (nombre);
-- Agenda: buscar turnos por fecha
CREATE INDEX idx_turnos_fecha ON turnos (fecha_hora);
-- Historial de pedidos / turnos de un usuario
CREATE INDEX idx_pedidos_usuario ON pedidos (usuario_id);
CREATE INDEX idx_turnos_usuario ON turnos (usuario_id);
-- (usuarios.email ya tiene índice automático por ser UNIQUE)
