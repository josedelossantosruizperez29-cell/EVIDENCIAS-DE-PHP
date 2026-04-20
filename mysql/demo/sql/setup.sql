-- ============================================================
--  DEMO: Tienda de Gadgets  —  PHP + MySQL  —  SENA 3066552
-- ============================================================
--  Instrucciones:
--    1. Abre phpMyAdmin o la consola de MySQL
--    2. Ejecuta todo este script
--    3. Verifica que la BD "sena_tienda" aparezca con 10 productos
-- ============================================================

-- 1. Crear la base de datos
CREATE DATABASE IF NOT EXISTS sena_tienda
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE sena_tienda;

-- 2. Crear la tabla de productos
DROP TABLE IF EXISTS productos;
CREATE TABLE productos (
    id          INT           AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100)  NOT NULL,
    descripcion TEXT,
    precio      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    categoria   VARCHAR(50)   NOT NULL,
    stock       INT           NOT NULL DEFAULT 0,
    activo      TINYINT(1)    NOT NULL DEFAULT 1,
    creado_en   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Insertar datos de prueba
INSERT INTO productos (nombre, descripcion, precio, categoria, stock) VALUES
('Laptop Lenovo IdeaPad 3',
 'Procesador Intel Core i5-1135G7, 8 GB RAM DDR4, 256 GB SSD NVMe, pantalla 15.6" Full HD.',
 2899000, 'Computadores', 15),

('Mouse Inalámbrico Logitech M185',
 'Receptor USB nano, clic silencioso, batería AA con duración de 12 meses, 3 botones.',
 89000, 'Periféricos', 50),

('Teclado Mecánico Redragon K552',
 'Switches Outemu Blue táctiles, retroiluminación LED roja, compacto TKL, USB-A.',
 199000, 'Periféricos', 30),

('Monitor LG 24" Full HD',
 'Panel IPS 1920×1080, 75 Hz, tiempo de respuesta 5 ms, HDMI + VGA, bajo consumo.',
 749000, 'Monitores', 12),

('Auriculares Sony WH-CH520',
 'Bluetooth 5.2, cancelación de ruido, hasta 50 h de batería, plegable, micrófono integrado.',
 299000, 'Audio', 25),

('Webcam Logitech C505',
 '720p HD, micrófono con reducción de ruido, compatible con Windows/Mac/Linux/ChromeOS.',
 149000, 'Periféricos', 40),

('Disco Externo Seagate 1 TB',
 'Expansión portátil, conector USB 3.0, compatible con Windows, Mac y Xbox. Sin fuente externa.',
 199000, 'Almacenamiento', 20),

('Hub USB-C Anker 7 en 1',
 'HDMI 4K@30Hz, USB-A 3.0 ×3, lector SD/microSD, PD 100W. Plug-and-play sin drivers.',
 129000, 'Accesorios', 60),

('Tablet Samsung Galaxy Tab A8',
 'Pantalla 10.5" TFT, procesador Unisoc T618, 3 GB RAM, 32 GB, WiFi + LTE, batería 7040 mAh.',
 999000, 'Tablets', 18),

('Silla de Oficina Ergonómica OFX',
 'Soporte lumbar ajustable, reposabrazos 3D, base nylon 5 ruedas, asiento espuma HD, hasta 120 kg.',
 1299000, 'Mobiliario', 8);

-- 4. (Opcional) Crear usuario específico para la app
-- Si no quieres usar root, ejecuta esto:
-- CREATE USER IF NOT EXISTS 'sena_user'@'localhost' IDENTIFIED BY 'sena2024';
-- GRANT ALL PRIVILEGES ON sena_tienda.* TO 'sena_user'@'localhost';
-- FLUSH PRIVILEGES;

-- ¡Listo! Verifica con:
SELECT id, nombre, precio, categoria, stock FROM productos ORDER BY id;
