/*
Se crea la base de datos Spark con tres tablas. Usuario almacena la información de cada usuario y permite identificar su organizador mediante una relación consigo misma. 
Evento guarda los datos de cada evento y Asisten actúa como tabla intermedia registrando qué usuarios participan en cada evento.
 */

-- Primero creamos perfiles porque Usuario depende de ella
CREATE TABLE perfiles (
    id_perfil INT PRIMARY KEY AUTO_INCREMENT,
    nombre_perfil VARCHAR(50)
);

-- Ahora sí podemos crear Usuario
CREATE TABLE Usuario (
    Nombre_Usuario VARCHAR(50) PRIMARY KEY,
    Telefono INT UNIQUE,
    Contrasena VARCHAR(60),
    Nombre_Apellido VARCHAR(50),
    Correo VARCHAR(100) UNIQUE,
    Direccion VARCHAR(50),
    Id_organizador VARCHAR(50),
    id_perfil INT,

    CONSTRAINT fk_organizador 
    FOREIGN KEY (Id_organizador) 
    REFERENCES Usuario(Nombre_Usuario),

    CONSTRAINT fk_usuario_perfil
    FOREIGN KEY (id_perfil)
    REFERENCES perfiles(id_perfil)
);

CREATE TABLE Evento (
    Id_Evento INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_evento VARCHAR(200),
    Descripcion VARCHAR(100),
    Fecha_evento DATE,
    Ubicacion VARCHAR(50),
    Lat DECIMAL(10, 7),
    Lng DECIMAL(10, 7)
);

CREATE TABLE Asisten (
    Id_Asistencia INT PRIMARY KEY AUTO_INCREMENT,
    Nombre_Usuario VARCHAR(50),
    Id_Evento INT,

    CONSTRAINT fk_asisten_usuario
    FOREIGN KEY (Nombre_Usuario) REFERENCES Usuario(Nombre_Usuario),

    CONSTRAINT fk_asisten_evento
    FOREIGN KEY (Id_Evento) REFERENCES Evento(Id_Evento)
);
ALTER TABLE Usuario ADD COLUMN Imagen VARCHAR(255);

-- Insert de los tipos de perfiles 
INSERT INTO perfiles (id_perfil, nombre_perfil) VALUES
(1, 'Usuario'),
(2, 'Administrador'),
(3, 'Gerente');


-- Insert de usuarios de ejemplo
INSERT INTO Usuario (Nombre_Usuario, Telefono, Contrasena, Nombre_Apellido, Correo, Direccion, Id_organizador, id_perfil) VALUES
('carlos_mg',   612345678, '$2y$10$examplehash1111111111uABC123', 'Carlos Martínez García',    'carlos.mg@email.com',    'Calle Mayor 12, Madrid',        NULL,        1),
('laura_fp',    623456789, '$2y$10$examplehash2222222222uDEF456', 'Laura Fernández Pérez',      'laura.fp@email.com',     'Av. Diagonal 88, Barcelona',    NULL,        1),
('admin_spark',  634567890, '$2y$10$examplehash3333333333uGHI789', 'Ana López Ruiz',            'admin@spark.com',        'Gran Vía 45, Madrid',           NULL,        2),
('gerente_spark',645678901, '$2y$10$examplehash4444444444uJKL012', 'Pedro Sánchez Torres',      'gerente@spark.com',      'Paseo de Gracia 10, Barcelona', NULL,        3),
('miguel_rv',   656789012, '$2y$10$examplehash5555555555uMNO345', 'Miguel Romero Vega',         'miguel.rv@email.com',    'C/ Sierpes 7, Sevilla',         'admin_spark',1);

-- Insert de eventos de ejemplo
INSERT INTO Evento (Nombre_evento, Descripcion, Fecha_evento, Ubicacion, Lat, Lng) VALUES
('Concierto de Verano',       'Festival de música en vivo con varios artistas', '2026-07-15', 'Parque del Retiro, Madrid',        40.4153200, -3.6844500),
('Conferencia Tech 2026',     'Jornada de innovación y tendencias tecnológicas', '2026-09-10', 'Fira de Barcelona, Barcelona',    41.3733700,  2.1491200),
('Maratón Solidario',         'Carrera popular benéfica por el centro histórico', '2026-06-20', 'Plaza Mayor, Salamanca',         40.9651400, -5.6638000),
('Feria Gastronómica',        'Muestra de productos y cocina local',              '2026-08-05', 'Recinto Ferial, Valencia',       39.4699100, -0.3762900),
('Taller de Fotografía',      'Práctica de fotografía urbana y retrato',          '2026-07-01', 'Museo Reina Sofía, Madrid',      40.4081600, -3.6944800);

-- Insert de asistencias de ejemplo
INSERT INTO Asisten (Nombre_Usuario, Id_Evento) VALUES
('carlos_mg',    1),
('carlos_mg',    3),
('laura_fp',     1),
('laura_fp',     2),
('miguel_rv',    2),
('miguel_rv',    4),
('admin_spark',  5),
('gerente_spark',2);

/* */