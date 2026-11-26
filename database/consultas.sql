-- ============================================================
-- consultas.sql  ·  TP6 · Pruebas CRUD – Kora Hair
-- Ejecutar DESPUÉS de schema.sql (con la base kora_hair elegida)
-- ============================================================
USE kora_hair;

-- ------------------------------------------------------------
-- C · CREATE  (insertar datos)
-- ------------------------------------------------------------

-- Tablas maestras
INSERT INTO roles (nombre, descripcion) VALUES
  ('admin',   'Administra el sitio, productos y turnos'),
  ('usuario', 'Usuario que compra y reserva turnos');

INSERT INTO categorias (nombre, descripcion) VALUES
  ('Tratamiento', 'Reparadores y tratamientos intensivos'),
  ('Limpieza',    'Shampoos y limpieza delicada'),
  ('Nutrición',   'Máscaras y baños de crema');

INSERT INTO estados_turno (nombre) VALUES
  ('pendiente'), ('confirmado'), ('cancelado'), ('realizado');

INSERT INTO estados_pedido (nombre) VALUES
  ('pendiente'), ('pagado'), ('enviado'), ('entregado'), ('cancelado');

-- Usuarios (la contraseña de ejemplo es Kora1234! guardada como hash)
INSERT INTO usuarios (rol_id, nombre, apellido, email, password, telefono) VALUES
  (1, 'Admin Kora', NULL,   'admin@korahair.test',   '$2y$10$P1/zrv6tWj/L2FGDM.3j/uwM.NMrPp83LpWON8Sn4wUNS4I3SDxvG', '3870000000'),
  (2, 'Abigail Aramayo', NULL,'abigail@correo.test',   '$2y$10$P1/zrv6tWj/L2FGDM.3j/uwM.NMrPp83LpWON8Sn4wUNS4I3SDxvG', '3871111111');

INSERT INTO servicios (nombre, descripcion, duracion_min, precio) VALUES
  ('Nutrición',      'Devolvemos lípidos y flexibilidad al cabello seco.',    75, 38000.00),
  ('Hidratación',    'Recuperamos agua, suavidad y movimiento natural.',      60, 32000.00),
  ('Reconstrucción', 'Fortalecemos la fibra dañada desde el interior.',       90, 46000.00),
  ('Alisados',       'Control y brillo con fórmulas de alto rendimiento.',   210, 70000.00);

-- Tabla principal: productos (vinculan la FK categoria_id)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, imagen) VALUES
  (1, 'Reparador de Puntas',        'Reparación y brillo en puntas · 45 ml', 14500.00, 30, 'producto-reparador.jpg'),
  (2, 'Shampoo Extra-Suave',        'Limpieza delicada · 200 ml',            11800.00, 25, 'producto-shampoo.jpg'),
  (3, 'Máscara Nutritiva Keratina', 'Nutrición profunda con keratina',       18900.00, 20, 'producto-mascara.jpg');

-- Tabla principal: turnos (vinculan usuario, servicio y estado)
INSERT INTO turnos (usuario_id, servicio_id, estado_id, fecha_hora, notas) VALUES
  (2, 1, 1, '2026-12-03 10:00:00', 'Primera visita'),
  (2, 3, 2, '2026-12-10 15:30:00', 'Cabello teñido');

-- Pedido con su detalle (relación N:M)
INSERT INTO pedidos (usuario_id, estado_id, total) VALUES (2, 2, 45200.00);
INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario) VALUES
  (1, 1, 1, 14500.00),
  (1, 2, 1, 11800.00),
  (1, 3, 1, 18900.00);

-- Consulta recibida por el formulario de contacto
INSERT INTO consultas (nombre, apellido, email, motivo, mensaje) VALUES
  ('Lucía', 'Gómez', 'lucia@correo.test', 'asesoramiento', 'Quiero saber qué tratamiento me conviene.');

-- ------------------------------------------------------------
-- R · READ  (consultas)
-- ------------------------------------------------------------

-- 1) WHERE + ORDER BY: productos de más de $12.000 ordenados por precio (mayor a menor)
SELECT id, nombre, precio, stock
FROM productos
WHERE precio > 12000
ORDER BY precio DESC;

-- 2) INNER JOIN (productos + categorías)
SELECT p.nombre AS producto, c.nombre AS categoria, p.precio
FROM productos p
INNER JOIN categorias c ON c.id = p.categoria_id
ORDER BY c.nombre, p.nombre;

-- 3) INNER JOIN de 4 tablas: agenda de turnos con cliente, servicio y estado
SELECT t.id, t.fecha_hora,
       u.nombre AS cliente,
       s.nombre AS servicio,
       e.nombre AS estado
FROM turnos t
INNER JOIN usuarios u       ON u.id = t.usuario_id
INNER JOIN servicios s      ON s.id = t.servicio_id
INNER JOIN estados_turno e  ON e.id = t.estado_id
WHERE t.fecha_hora >= '2026-12-01'
ORDER BY t.fecha_hora ASC;

-- 4) Detalle de un pedido (N:M): qué productos compró cada cliente
SELECT ped.id AS pedido, u.email, pr.nombre AS producto,
       d.cantidad, d.precio_unitario, (d.cantidad * d.precio_unitario) AS subtotal
FROM pedidos ped
INNER JOIN usuarios u         ON u.id = ped.usuario_id
INNER JOIN detalle_pedidos d  ON d.pedido_id = ped.id
INNER JOIN productos pr       ON pr.id = d.producto_id
WHERE ped.id = 1;

-- ------------------------------------------------------------
-- U · UPDATE  (siempre con WHERE)
-- ------------------------------------------------------------

-- Cambiar el precio de un producto específico
UPDATE productos
SET precio = 15500.00
WHERE id = 1;

-- Confirmar un turno (pasa de pendiente a confirmado)
UPDATE turnos
SET estado_id = 2
WHERE id = 1;

-- Comprobar los cambios
SELECT id, nombre, precio, updated_at FROM productos WHERE id = 1;

-- ------------------------------------------------------------
-- D · DELETE  (siempre con WHERE)
-- ------------------------------------------------------------

-- Dar de baja la consulta de prueba
DELETE FROM consultas
WHERE id = 1;

-- Comprobar que ya no existe (debe devolver 0 filas)
SELECT * FROM consultas WHERE id = 1;
