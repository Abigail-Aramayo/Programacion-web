-- ============================================================
-- Kora Hair · TP8 · Ajustes de base de datos para el login
-- Ejecutar UNA vez en phpMyAdmin (pestaña SQL), con la base kora_hair elegida.
-- ============================================================

-- 1) El formulario de registro pide "nombre y apellido" en un solo campo,
--    así que "apellido" pasa a ser opcional y "nombre" admite 100 caracteres.
ALTER TABLE usuarios
  MODIFY nombre   VARCHAR(100) NOT NULL,
  MODIFY apellido VARCHAR(50)  NULL;

-- 2) El rol por defecto de quien se registra se llama "usuario".
UPDATE roles SET nombre = 'usuario' WHERE nombre = 'cliente';
