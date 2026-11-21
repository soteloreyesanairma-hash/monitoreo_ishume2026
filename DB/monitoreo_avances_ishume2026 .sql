CREATE DATABASE monitoreo_avances_ishume2026;
USE monitoreo_avances_ishume2026;

CREATE TABLE practicantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    DNI CHAR(8),
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    telefono CHAR(9),
    carrera VARCHAR(100)
);

CREATE TABLE colegios (
    id_colegio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    nivel VARCHAR(20) NULL,           -- INICIAL, PRIMARIA, SECUNDARIA, SUPERIOR
    anio_promocion YEAR NULL          -- año de la promoción del colegio
);

-- Podemos utilizarla mas adelante.
CREATE TABLE calificacion (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    calificacion_actual DECIMAL(10, 2),
    calificacion_desaprobatoria DECIMAL(10, 2),
    resultado DECIMAL(10, 2)
);

CREATE TABLE sesion (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    tipo_sesion VARCHAR(100),
    id_colegio INT,
    CONSTRAINT FK_sesion_colegio FOREIGN KEY (id_colegio)
	REFERENCES colegios(id_colegio)
);

CREATE TABLE seguimiento (
    id_seguimiento INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(20),
    fecha_inicio DATE,
    fecha_limite DATE,
    fecha_fin DATE NULL,
    id_practicante INT,
    id_colegio INT,
    id_calificacion INT NULL,
    id_sesion INT NULL,
    CONSTRAINT FK_seguimiento_practicante FOREIGN KEY (id_practicante)
	REFERENCES practicantes(id),
    CONSTRAINT FK_seguimiento_colegio FOREIGN KEY (id_colegio)
	REFERENCES colegios(id_colegio),
    CONSTRAINT FK_seguimiento_calificacion FOREIGN KEY (id_calificacion)
	REFERENCES calificacion(id_calificacion),
    CONSTRAINT FK_seguimiento_sesion FOREIGN KEY (id_sesion)
	REFERENCES sesion(id_sesion)
);

-- fecha_entrega y limite_recojo = fechas planificadas.
-- fecha_impreso, fecha_armado, fecha_entregado_cliente = fechas reales
-- (si es NULL, ese paso todavía no se hizo).
CREATE TABLE materiales (
    id_material INT AUTO_INCREMENT PRIMARY KEY,
    estado_material VARCHAR(30),
    fecha_entrega DATE,
    limite_recojo DATE,
    fecha_impreso DATE NULL,
    fecha_armado DATE NULL,
    fecha_entregado_cliente DATE NULL,
    id_seguimiento INT,
    CONSTRAINT FK_materiales_seguimiento FOREIGN KEY (id_seguimiento)
	REFERENCES seguimiento(id_seguimiento)
);

-- DATOS

INSERT INTO practicantes(DNI, nombres, apellidos, telefono, carrera) VALUES
('61341087', 'VALERY FABIANA', 'FÉLIX MORALES', '962986673', 'DISEÑO'),
('62585703', 'SALMA ELIZABETH ESTHER', 'APARCANA SOTO', '936597091', 'DISEÑO'),
('61385889', 'AXEL FERNANDO', 'FLORES CARBALLO', '906094776', 'DISEÑO'),
('60886640', 'JEFFERSON LEONEL', 'CASTILLA APARI', '936245476', 'DISEÑO'),
('75218512', 'MILENCO XAVIER', 'GARCIA MUÑOZ', '975732643', 'DISEÑO'),
('72858203', 'AMÓS GIUSEPHI JESHUA', 'AMORETTI BAUTISTA', '920864865', 'DISEÑO'),
('61060348', 'ANAHI JIMENA', 'CRISOSTOMO MAGALLANES', '957498653', 'DISEÑO'),
('74958993', 'ABIGAIL', 'ALMEYDA MARCOS', '923284369', 'DISEÑO'),
('73880857', 'FLAVIO CRISTIAN', 'PACHAS CHOQUEZ', '977431955', 'DISEÑO'),
('72195623', 'CARLOS JOEL', 'NIMA PACHAS', '919738473', 'DISEÑO'),
('75323929', 'NALLELY ALEXANDRA', 'ÑAHUI CHONTA', '992772102', 'DISEÑO'),
('60807214', 'DAYANA ISMEAL', 'QUISPE TORRES', '904267844', 'DISEÑO'),
('60985094', 'GISSELL ALEXANDRA', 'OCHOA TRILLO', '936054390', 'DISEÑO'),
('74210421', 'JOSÉ OMAR', 'QUISPE GARCÍA', '906624236', 'DISEÑO'),
('61870606', 'CECIA NOEMI', 'TRILLO CURACA', '931844660', 'DISEÑO'),
('72793049', 'GIAN CARLOS SAMIR', 'TORRES MESÍAS', '991090143', 'DISEÑO'),
('61215405', 'ITZELJANAIRIZ YATZIRIU', 'HUEZA SALVADOR', '923148310', 'DISEÑO'),
('61060554', 'TATIANA KATIUSKA', 'PACHAS PECHO', '945694338', 'DISEÑO'),
('62346019', 'GÉNESIS FRANSHESCA', 'RIVERA CONDE', '919493592', 'DISEÑO'),
('60887167', 'LETICIA NOELIA', 'GARCÍA AQUIJE', '987280520', 'DISEÑO'),
('72165116', 'KENY FABRICIO', 'CÁRDENAS AMORETTI', '925580236', 'DISEÑO'),
('76169694', 'LILIANA CECILIA', 'LEVANO HUAMAN', '913794946', 'DISEÑO'),
('73261096', 'KATHYA DANIELA', 'MATEO ANTON', '927159095', 'DISEÑO');

INSERT INTO colegios(nombre, nivel, anio_promocion) VALUES
('BENEDICTO INICIAL', 'INICIAL', 2026),
('22268 PRIMARIA 6TO B', 'PRIMARIA', 2026),
('ARBOLITO', 'INICIAL', 2026),
('22230 INICIAL', 'INICIAL', 2026),
('DIVINO NIÑO INICIAL', 'INICIAL', 2026),
('BEATITA MELCHORITA PARTICULAR INICIAL', 'INICIAL', 2026),
('22268 PRIMARIA 6TO C', 'PRIMARIA', 2026),
('MELCHORITA SARAVIA PRIMARIA', 'PRIMARIA', 2026),
('MARÍA TERESA', 'PRIMARIA', 2026),
('DIVINO NIÑO', 'SECUNDARIA', 2026),
('SAN ANTONIO DE PADUA', 'PRIMARIA', 2026),
('22236 SEXTO A', 'PRIMARIA', 2026),
('FE Y ALEGRIA', 'INICIAL', 2026),
('22264 INICIAL', 'INICIAL', 2026),
('COLEGIO WIRACOCHA', 'PRIMARIA', 2026),
('TUPAC AMARU', 'INICIAL', 2026),
('PAULINO REATEGUI', 'INICIAL', 2026),
('MELCHORITA 411', 'INICIAL', 2026),
('PARDO 6TO B', 'PRIMARIA', 2026),
('CHACARITA 249 - AULA NARANJA', 'INICIAL', 2026),
('COLEGIO VIRGEN DEL PILAR', 'PRIMARIA', 2026),
('22268 6TO D', 'PRIMARIA', 2026),
('PRONOEI - ARDILLITAS', 'PRONOEI', 2026),
('JOSÉ CARLOS MARIATEGUI', 'PRIMARIA', 2026),
('PAULINO REATEGUI', 'PRIMARIA', 2026),
('HORACIO ZEVALLOS INICIAL', 'INICIAL', 2026),
('INSTITUTO TECNOLOGICO', 'SUPERIOR', 2026),
('SAN PEDRO COPRODELI', 'INICIAL', 2026),
('SANTA LUISA', 'INICIAL', 2026),
('COLEGIO WIRACOCHA INICIAL', 'INICIAL', 2026),
('COLEGIO HUAYABO', 'INICIAL', 2026),
('COLEGIO SAN ANTONIO DE PADUA', 'INICIAL', 2026),
('CHACARITA 249', 'INICIAL', 2026),
('CHINCHAYSUYO 5 AÑOS B', 'INICIAL', 2026),
('22236 SEXTO D', 'PRIMARIA', 2026),
('ROSEDAL INICIAL', 'INICIAL', 2026),
('SEÑOR DE LOS MILAGROS', 'SECUNDARIA', 2026),
('JOSE YATACO PACHAS 5TO B', 'SECUNDARIA', 2026),
('JUAN VELAZCO ALVARADO', 'INICIAL', 2026),
('PARDO 5TO B', 'SECUNDARIA', 2026),
('SAN MARTIN 22260', 'INICIAL', 2026),
('PESCHIERA', 'INICIAL', 2026),
('COLEGIO PRONOEI RAYITOS DEL SOL', 'INICIAL', 2026),
('COLEGIO TUPAC ZONA A', 'INICIAL', 2026),
('COLEGIO 22264 PRIMARIA', 'PRIMARIA', 2026),
('COLEGIO JOSE PARDO Y BARREDA 6TO D', 'PRIMARIA', 2026),
('MELCHORITA SARAVIA 5TO A', 'SECUNDARIA', 2026),
('PRONOEI LOS CARIÑOSITOS', 'INICIAL', 2026),
('COLEGIO FE Y ALEGRIA SECUNDARIA', 'SECUNDARIA', 2026),
('CANYAR NATALI', 'INICIAL', 2026),
('LEADER KIDS', 'NIDO', 2026),
('JOSÉ YATACO PACHAS 6TO B', 'PRIMARIA', 2026),
('COLEGIO LINCONLN INIICIAL', 'INICIAL', 2026),
('JUAN VELAZCO ALVARADO', 'PRIMARIA', 2026),
('COLEGIO JHON F KENEDY', 'SECUNDARIA', 2026),
('9 DICIEMBRE', 'SECUNDARIA', 2026),
('SAN ANTONIO DE SALAS', 'PRIMARIA', 2026),
('VIRGEN DEL PILAR 5TO UNICO', 'SECUNDARIA', 2026),
('22228 INICIAL', 'INICIAL', 2026),
('COLEGIO CABEZA DE TORO', 'INICIAL', 2026),
('YESHUA PRIMARIA', 'PRIMARIA', 2026),
('YESHUIA SECUNDARIA', 'SECUNDARIA', 2026),
('22280', 'PRIMARIA', 2026),
('COLEGIO SANTA ANITA', 'INICIAL', 2026),
('COLEGIO 22268 6TO A', 'PRIMARIA', 2026),
('22268 SECUNDARIA 5TO B', 'SECUNDARIA', 2026),
('CANYAR PRIMARIA', 'PRIMARIA', 2026),
('FE Y ALEGRIA 5C', 'SECUNDARIA', 2026),
('COLEGIO SAN MIGUEL PISCO', 'SECUNDARIA', 2026),
('COLEGIO 22280 INICIAL', 'INICIAL', 2026),
('LINCON SECUNDARIA', 'SECUNDARIA', 2026),
('I.E 912 INCIIAL', 'INICIAL', 2026),
('PRONOEI LOMO LARGO MI DULCE HOGAR', 'INICIAL', 2026),
('MARIA PARADO DE BELLIDO', 'SECUNDARIA', 2026),
('PARDO 5 AÑOS A', 'INICIAL', 2026),
('PARDO 5TO F', 'SECUNDARIA', 2026),
('JOSE CARLOS MARIATEGUI PISCO SAN CLEMENTE', 'SECUNDARIA', 2026),
('CANYAR PRONOEI', 'INICIAL', 2026),
('COLEGIO PARACAS INCIIAL', 'INICIAL', 2026),
('LUDER SAN AGUSTIN', 'INICIAL', 2026),
('PACHACUTEC', 'INICIAL', 2026),
('MARIATERESA', NULL, 2026),
('SANTO DOMINGO SABIO', NULL, 2026);

INSERT INTO sesion(tipo_sesion, id_colegio) VALUES
('PLAYA, PARQUE, COLEGIO', 1),
('PLAYA, PARQUE, COLEGIO', 2),
('PLAYA, PARQUE, COLEGIO', 3),
('APOYO', 4),
('PLAYA, PARQUE, COLEGIO', 5),
('PLAYA, PARQUE, COLEGIO', 6),
('PLAYA, PARQUE, COLEGIO', 7),
('PLAYA, PARQUE, COLEGIO', 8),
('PLAYA, PARQUE, COLEGIO', 9),
('PLAYA, PARQUE, COLEGIO', 10),
('PLAYA, PARQUE, COLEGIO', 11),
('PLAYA, PARQUE, COLEGIO', 12),
('PLAYA, PARQUE, COLEGIO', 13),
('PLAYA, PARQUE, COLEGIO', 14),
('PLAYA, PARQUE, COLEGIO', 15),
('PLAYA, PARQUE, COLEGIO', 16),
('PLAYA, PARQUE, COLEGIO', 17),
('PLAYA, PARQUE, COLEGIO', 18),
('PLAYA, PARQUE, COLEGIO', 19),
('PLAYA, PARQUE, COLEGIO', 20),
('PLAYA, PARQUE, COLEGIO', 21),
('PLAYA, PARQUE, COLEGIO', 22),
('PLAYA, PARQUE, COLEGIO', 23);

-- id_calificacion no se llena por ahora (queda en NULL).
INSERT INTO seguimiento
(estado, fecha_inicio, fecha_limite, id_practicante, id_colegio, id_sesion)
VALUES
('PENDIENTE', '2026-08-19', '2026-09-07', 1, 1, 1),
('PENDIENTE', '2026-08-19', '2026-09-07', 2, 2, 2),
('PENDIENTE', '2026-08-19', '2026-09-08', 3, 3, 3),
('PENDIENTE', '2026-08-19', NULL, 4, 4, 4),
('PENDIENTE', '2026-08-19', '2026-09-08', 5, 5, 5),
('PENDIENTE', '2026-08-19', '2026-09-09', 6, 6, 6),
('PENDIENTE', '2026-08-19', '2026-09-08', 7, 7, 7),
('PENDIENTE', '2026-08-19', '2026-09-07', 8, 8, 8),
('PENDIENTE', '2026-08-19', '2026-09-07', 9, 9, 9),
('PENDIENTE', '2026-08-19', '2026-09-08', 10, 10, 10),
('PENDIENTE', '2026-08-19', '2026-09-07', 11, 11, 11),
('PENDIENTE', '2026-08-19', '2026-09-07', 12, 12, 12),
('PENDIENTE', '2026-08-19', '2026-09-07', 13, 13, 13),
('PENDIENTE', '2026-08-19', '2026-09-08', 14, 14, 14),
('PENDIENTE', '2026-08-19', '2026-09-07', 15, 15, 15),
('PENDIENTE', '2026-08-19', '2026-09-07', 16, 16, 16),
('PENDIENTE', '2026-08-19', '2026-09-07', 17, 17, 17),
('PENDIENTE', '2026-08-19', '2026-09-07', 18, 18, 18),
('PENDIENTE', '2026-08-19', '2026-09-08', 19, 19, 19),
('PENDIENTE', '2026-08-19', '2026-09-07', 20, 20, 20),
('PENDIENTE', '2026-08-19', '2026-09-08', 21, 21, 21),
('PENDIENTE', '2026-08-19', '2026-09-07', 22, 22, 22),
('PENDIENTE', '2026-08-19', '2026-09-07', 23, 23, 23);

INSERT INTO materiales
(estado_material, fecha_entrega, limite_recojo, id_seguimiento)
VALUES
('PROCESO DE EDICIÓN', '2026-12-07', '2026-12-14', 1),
('PROCESO DE EDICIÓN', '2026-12-06', '2026-12-13', 2),
('PROCESO DE EDICIÓN', '2026-12-01', '2026-12-08', 3),
('PROCESO DE EDICIÓN', NULL, NULL, 4),
('PROCESO DE EDICIÓN', '2026-11-22', '2026-11-29', 5),
('PROCESO DE EDICIÓN', '2026-12-02', '2026-12-09', 6),
('PROCESO DE EDICIÓN', '2026-12-07', '2026-12-14', 7),
('PROCESO DE EDICIÓN', '2026-11-07', '2026-11-14', 8),
('PROCESO DE EDICIÓN', '2026-11-19', '2026-11-26', 9),
('PROCESO DE EDICIÓN', '2026-11-07', '2026-11-14', 10),
('PROCESO DE EDICIÓN', '2026-11-25', '2026-12-02', 11),
('PROCESO DE EDICIÓN', '2026-11-22', '2026-11-29', 12),
('PROCESO DE EDICIÓN', '2026-11-22', '2026-11-29', 13),
('PROCESO DE EDICIÓN', NULL, NULL, 14),
('PROCESO DE EDICIÓN', '2026-11-24', '2026-12-01', 15),
('PROCESO DE EDICIÓN', '2026-11-17', '2026-11-24', 16),
('PROCESO DE EDICIÓN', '2026-11-30', '2026-12-07', 17),
('PROCESO DE EDICIÓN', '2026-11-22', '2026-11-29', 18),
('PROCESO DE EDICIÓN', '2026-12-12', '2026-12-19', 19),
('PROCESO DE EDICIÓN', '2026-11-22', '2026-11-29', 20),
('PROCESO DE EDICIÓN', '2026-10-22', '2026-10-29', 21),
('PROCESO DE EDICIÓN', '2026-11-27', '2026-12-04', 22),
('PROCESO DE EDICIÓN', '2026-12-07', '2026-12-14', 23);

-- ---------------------------------------------------------------------
-- CONSULTAS ÚTILES PARA EL SISTEMA
-- ---------------------------------------------------------------------

-- 1) Completar el nivel de un colegio (ejemplos)
-- UPDATE colegios SET nivel = 'PRIMARIA'   WHERE id_colegio = 6;
-- UPDATE colegios SET nivel = 'INICIAL'    WHERE id_colegio = 5;

-- 2) Información del practicante con sus colegios actuales
SELECT CONCAT(p.nombres, ' ', p.apellidos) AS practicante,
       c.nombre AS colegio, c.nivel,
       s.estado, s.fecha_inicio, s.fecha_limite
FROM seguimiento s
JOIN practicantes p ON p.id = s.id_practicante
JOIN colegios c ON c.id_colegio = s.id_colegio
WHERE s.estado IN ('PENDIENTE', 'EN PROCESO');

-- 3) Historial de un practicante (colegios que ya terminó)
SELECT c.nombre AS colegio, c.nivel, s.fecha_inicio, s.fecha_fin
FROM seguimiento s
JOIN colegios c ON c.id_colegio = s.id_colegio
WHERE s.id_practicante = 1 AND s.estado = 'COMPLETADO'
ORDER BY s.fecha_fin;

-- 4) Asignar un nuevo colegio a un practicante
-- (primero crea el colegio con INSERT INTO colegios, luego:)
-- INSERT INTO seguimiento (estado, fecha_inicio, fecha_limite, id_practicante, id_colegio)
-- VALUES ('EN PROCESO', CURDATE(), '2026-12-15', 1, 24);

-- 5) Etapa de producción de cada colegio
SELECT c.nombre AS colegio,
       m.fecha_impreso, m.fecha_armado, m.fecha_entregado_cliente,
       CASE
         WHEN m.fecha_entregado_cliente IS NOT NULL THEN 'ENTREGADO'
         WHEN m.fecha_armado IS NOT NULL THEN 'ARMADO'
         WHEN m.fecha_impreso IS NOT NULL THEN 'IMPRESO'
         ELSE 'EN EDICIÓN'
       END AS etapa
FROM materiales m
JOIN seguimiento s ON s.id_seguimiento = m.id_seguimiento
JOIN colegios c ON c.id_colegio = s.id_colegio;

SELECT * FROM practicantes;
SELECT * FROM colegios;
SELECT * FROM calificacion;
SELECT * FROM sesion;
SELECT * FROM seguimiento;
SELECT * FROM materiales;
