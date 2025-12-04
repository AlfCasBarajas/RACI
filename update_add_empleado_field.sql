-- Script para agregar el campo empleado a las tablas incidente y accidente
-- Ejecutar este script en la base de datos existente

-- Agregar columna empleado_id_empleado a la tabla incidente
ALTER TABLE incidente 
ADD COLUMN empleado_id_empleado INT,
ADD CONSTRAINT FK_incidente_empleado 
    FOREIGN KEY (empleado_id_empleado) 
    REFERENCES empleado(id_empleado);

-- Agregar columna empleado_id_empleado a la tabla accidente  
ALTER TABLE accidente 
ADD COLUMN empleado_id_empleado INT,
ADD CONSTRAINT FK_accidente_empleado 
    FOREIGN KEY (empleado_id_empleado) 
    REFERENCES empleado(id_empleado);