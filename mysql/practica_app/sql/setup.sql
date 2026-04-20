-- ============================================================
--  PRÁCTICA: Agenda de Contactos  —  PHP + MySQL  —  SENA
-- ============================================================
--  Instrucciones para el estudiante:
--    1. Abre phpMyAdmin → pestaña SQL
--    2. Pega todo este script y ejecuta
--    3. Verifica que aparezca la BD "sena_contactos" con 8 contactos
-- ============================================================

CREATE DATABASE IF NOT EXISTS sena_contactos
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE sena_contactos;

DROP TABLE IF EXISTS contactos;
CREATE TABLE contactos (
    id         INT           AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100)  NOT NULL,
    email      VARCHAR(150)  NOT NULL UNIQUE,
    telefono   VARCHAR(20),
    categoria  ENUM('Amigo','Familiar','Trabajo','Otro') NOT NULL DEFAULT 'Otro',
    notas      TEXT,
    creado_en  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO contactos (nombre, email, telefono, categoria, notas) VALUES
('Ana García',      'ana.garcia@example.com',   '300-111-2233', 'Trabajo',   'Diseñadora UX en la empresa'),
('Carlos López',    'carlos.lopez@example.com', '310-222-3344', 'Amigo',     'Compañero de universidad'),
('María Rodríguez', 'maria.rod@example.com',    '320-333-4455', 'Familiar',  'Prima, vive en Medellín'),
('Juan Martínez',   'j.martinez@example.com',   '315-444-5566', 'Trabajo',   'Cliente principal proyecto X'),
('Laura Torres',    'laura.t@example.com',      NULL,           'Amigo',     'Conocida del bootcamp de PHP'),
('Pedro Sánchez',   'pedro.san@example.com',    '318-666-7788', 'Familiar',  'Hermano mayor'),
('Valentina Cruz',  'valen.cruz@example.com',   '305-777-8899', 'Trabajo',   'Profesora de inglés'),
('Diego Herrera',   'diego.h@example.com',      '312-888-9900', 'Otro',      'Técnico del servicio de internet');

-- Verifica el resultado:
SELECT id, nombre, email, categoria FROM contactos ORDER BY id;
