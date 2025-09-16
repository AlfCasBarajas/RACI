-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS raci_db;
USE raci_db;

-- Tabla rol
CREATE TABLE rol (
    id_Rol INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla user
CREATE TABLE user (
    num_doc INT PRIMARY KEY,
    tipo_doc VARCHAR(20) NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    rol INT NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    telefono INT,
    FOREIGN KEY (rol) REFERENCES rol(id_Rol)
);

-- Tabla empleado
CREATE TABLE empleado (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    tipo_doc VARCHAR(20) NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono INT,
    eps VARCHAR(50),
    arl VARCHAR(50),
    cargo_funcion VARCHAR(100),
    antig_cargo VARCHAR(50),
    rol INT,
    FOREIGN KEY (rol) REFERENCES rol(id_Rol)
);

-- Tabla area
CREATE TABLE area (
    id_area INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla categoria
CREATE TABLE categoria (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    area_id_area INT,
    user_num_doc INT,
    empleado_id_empleado INT,
    FOREIGN KEY (area_id_area) REFERENCES area(id_area),
    FOREIGN KEY (user_num_doc) REFERENCES user(num_doc),
    FOREIGN KEY (empleado_id_empleado) REFERENCES empleado(id_empleado)
);

-- Tabla condicion_insegura
CREATE TABLE condicion_insegura (
    id_cond_inseg INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    lugar VARCHAR(100)
);

-- Tabla riesgo
CREATE TABLE riesgo (
    id_riesgo INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    condicion_insegura_id_cond_inseg INT,
    FOREIGN KEY (condicion_insegura_id_cond_inseg) REFERENCES condicion_insegura(id_cond_inseg)
);

-- Tabla incidente
CREATE TABLE incidente (
    id_incidente INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    fecha_hora DATETIME,
    lugar VARCHAR(100),
    tipo_vinc_lab VARCHAR(50),
    jornada_laboral VARCHAR(50),
    turno_mom_inc VARCHAR(50),
    uso_epp TEXT
);

-- Tabla accidente
CREATE TABLE accidente (
    id_accidente INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    clasificacion VARCHAR(50),
    estado VARCHAR(50),
    fecha_hora DATETIME,
    lugar VARCHAR(100),
    tipo_vinc_lab_ VARCHAR(50),
    jornada_laboral VARCHAR(50),
    turno_mom_acc VARCHAR(50),
    uso_epp TEXT,
    consecuencias VARCHAR(100),
    gravedad VARCHAR(50),
    tipo_lesion VARCHAR(50),
    parte_cuerpo_afect VARCHAR(50),
    incapacidad_lab VARCHAR(50),
    aten_med_recibida TEXT,
    persona_informo VARCHAR(100)
);

-- Tabla reporte
CREATE TABLE reporte (
    id_reporte INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla inspeccion_locativa
CREATE TABLE inspeccion_locativa (
    id_insp_loc INT PRIMARY KEY AUTO_INCREMENT,
    razon_social VARCHAR(100) NOT NULL,
    tipo_inspeccion VARCHAR(50),
    fecha_hora DATETIME,
    act_economica VARCHAR(100),
    descripcion TEXT,
    estado_inspeccion VARCHAR(50),
    element_trab TEXT,
    observaciones TEXT,
    categoria_id_categoria INT,
    incidente_id_incidente INT,
    accidente_id_accidente INT,
    riesgo_id_riesgo INT,
    reporte_id_reporte INT,
    FOREIGN KEY (categoria_id_categoria) REFERENCES categoria(id_categoria),
    FOREIGN KEY (incidente_id_incidente) REFERENCES incidente(id_incidente),
    FOREIGN KEY (accidente_id_accidente) REFERENCES accidente(id_accidente),
    FOREIGN KEY (riesgo_id_riesgo) REFERENCES riesgo(id_riesgo),
    FOREIGN KEY (reporte_id_reporte) REFERENCES reporte(id_reporte)
);