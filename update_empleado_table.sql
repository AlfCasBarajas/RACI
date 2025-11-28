-- Script para agregar el campo área a la tabla empleado existente
-- Ejecutar este script si la tabla empleado ya existe en la base de datos

-- Agregar la columna area_id_area a la tabla empleado
ALTER TABLE empleado 
ADD COLUMN area_id_area INT;

-- Agregar la restricción de clave foránea
ALTER TABLE empleado 
ADD FOREIGN KEY (area_id_area) REFERENCES area(id_area);

-- Verificar que el cambio se aplicó correctamente
DESCRIBE empleado;