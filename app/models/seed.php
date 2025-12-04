<?php
require_once __DIR__ . '/../core/Database.php';

function crearUsuariosIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
    // Solo insertar si la tabla user está vacía
    $count = $conn->query('SELECT COUNT(*) FROM user')->fetchColumn();
    if ($count > 0) {
        echo "Tabla 'user' ya contiene datos. No se crearán usuarios iniciales.\n";
        return;
    }

    // Ajustar columnas al esquema de db.sql: usuario, contrasena
    $usuarios = [
        ['num_doc' => 1053349252, 'tipo_doc' => 'CC', 'usuario' => 'admin', 'rol' => 1, 'contrasena' => password_hash('admin123', PASSWORD_DEFAULT), 'telefono' => 123456789],
        ['num_doc' => 1156464465, 'tipo_doc' => 'CC', 'usuario' => 'super', 'rol' => 2, 'contrasena' => password_hash('456', PASSWORD_DEFAULT), 'telefono' => 234567890],
        ['num_doc' => 1546465465, 'tipo_doc' => 'CC', 'usuario' => 'coord', 'rol' => 3, 'contrasena' => password_hash('789', PASSWORD_DEFAULT), 'telefono' => 345678901],
        ['num_doc' => 3256464454, 'tipo_doc' => 'CC', 'usuario' => 'traba', 'rol' => 4, 'contrasena' => password_hash('369', PASSWORD_DEFAULT), 'telefono' => 456789012]
    ];
    foreach ($usuarios as $u) {
        $stmt = $conn->prepare('INSERT INTO user (num_doc, tipo_doc, usuario, rol, contrasena, telefono) VALUES (:num_doc, :tipo_doc, :usuario, :rol, :contrasena, :telefono)');
        $stmt->execute($u);
    }
}

function crearRolesIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
    // Solo insertar si la tabla rol está vacía
    $count = $conn->query('SELECT COUNT(*) FROM rol')->fetchColumn();
    if ($count > 0) {
        echo "Tabla 'rol' ya contiene datos. No se crearán roles iniciales.\n";
        return;
    }

    $roles = [
        ['nombre' => 'admin'],
        ['nombre' => 'supervisor'],
        ['nombre' => 'coordinador'],
        ['nombre' => 'trabajador']
    ];
    foreach ($roles as $r) {
        $stmt = $conn->prepare('INSERT INTO rol (nombre) VALUES (:nombre)');
        $stmt->execute($r);
    }
}


function poblarTablasRACI() {
    $db = new Database();
    $conn = $db->getConnection();

    // Solo poblar si las tablas están vacías
    $tablas = [
        'area', 'empleado', 'categoria', 'condicion_insegura', 'riesgo', 'incidente', 'accidente', 'inspeccion_locativa'
    ];
    $hayDatos = false;
    foreach ($tablas as $tabla) {
        $stmt = $conn->query("SELECT COUNT(*) FROM $tabla");
        if ($stmt->fetchColumn() > 0) {
            $hayDatos = true;
            break;
        }
    }
    if ($hayDatos) {
        echo "Las tablas ya tienen datos. No se insertó nada nuevo.\n";
        return;
    }

    // AREA - usar ids 1..8 para mayor variedad
    $conn->exec("INSERT INTO area (id_area, nombre, descripcion) VALUES
        (1, 'Administración', 'Área administrativa y financiera'),
        (2, 'Producción', 'Área de producción y manufactura'),
        (3, 'Mantenimiento', 'Área de mantenimiento industrial'),
        (4, 'Recursos Humanos', 'Área de gestión humana'),
        (5, 'Almacén', 'Área de almacenamiento y logística'),
        (6, 'Calidad', 'Área de control de calidad'),
        (7, 'Seguridad', 'Área de seguridad industrial'),
        (8, 'Cafetería', 'Área de alimentación y descanso')");

    // EMPLEADO - usar ids 1..10 para mayor variedad
    $conn->exec("INSERT INTO empleado (id_empleado, tipo_doc, nombres, apellidos, telefono, eps, arl, cargo_funcion, antig_cargo, rol, area_id_area) VALUES
        (1, 'CC', 'Juan', 'Pérez', 123456789, 'Sura', 'Colmena', 'Operario', '2 años', 4, 2),
        (2, 'CC', 'Ana', 'García', 234567890, 'Nueva EPS', 'Bolívar', 'Administrativa', '1 año', 1, 1),
        (3, 'CC', 'Luis', 'Martínez', 345678901, 'Sanitas', 'Sura', 'Técnico Mantenimiento', '3 años', 3, 3),
        (4, 'CC', 'Sofía', 'López', 456789012, 'Compensar', 'Colmena', 'Almacenista', '1 año', 2, 5),
        (5, 'CC', 'Carlos', 'Ramírez', 567890123, 'Famisanar', 'Bolívar', 'Jefe RRHH', '4 años', 1, 4),
        (6, 'CC', 'María', 'González', 678901234, 'Sura', 'Colmena', 'Operaria', '6 meses', 4, 2),
        (7, 'CC', 'Pedro', 'Jiménez', 789012345, 'Nueva EPS', 'Sura', 'Supervisor', '5 años', 2, 1),
        (8, 'CC', 'Laura', 'Hernández', 890123456, 'Sanitas', 'Bolívar', 'Técnica', '2 años', 3, 3),
        (9, 'CC', 'David', 'Morales', 901234567, 'Compensar', 'Colmena', 'Coordinador Almacén', '3 años', 3, 5),
        (10, 'CC', 'Carmen', 'Torres', 012345678, 'Famisanar', 'Sura', 'Analista RRHH', '1 año', 4, 4)");

    // CATEGORIA
    $conn->exec("INSERT INTO categoria (id_categoria, nombre, descripcion, area_id_area, user_num_doc, empleado_id_empleado) VALUES
        (1, 'Ergonomía', 'Riesgos ergonómicos y posturales', 1, 1053349252, 2),
        (2, 'Mecánica', 'Riesgos mecánicos en maquinaria', 2, 1156464465, 1),
        (3, 'Eléctrica', 'Riesgos eléctricos e instalaciones', 3, 1546465465, 3),
        (4, 'Química', 'Riesgos químicos y exposición', 5, 3256464454, 4),
        (5, 'Psicosocial', 'Riesgos psicosociales y estrés', 4, 1053349252, 5),
        (6, 'Física', 'Riesgos físicos y ambientales', 2, 1156464465, 6),
        (7, 'Biológica', 'Riesgos biológicos y contaminación', 8, 1546465465, 7),
        (8, 'Locativa', 'Riesgos de infraestructura', 1, 3256464454, 8),
        (9, 'Natural', 'Riesgos por fenómenos naturales', 7, 1053349252, 9),
        (10, 'Tecnológica', 'Riesgos por fallas tecnológicas', 6, 1156464465, 10)");

    // CONDICION_INSEGURA
    $conn->exec("INSERT INTO condicion_insegura (id_cond_inseg, nombre, descripcion, lugar, area_id_area) VALUES
        (1, 'Piso mojado', 'Riesgo de resbalón por superficie húmeda', 'Pasillo principal', 1),
        (2, 'Herramienta defectuosa', 'Herramientas en mal estado que pueden causar lesiones', 'Taller de mantenimiento', 3),
        (3, 'Cable suelto', 'Riesgo eléctrico por cableado expuesto', 'Oficina administrativa', 1),
        (4, 'Iluminación insuficiente', 'Fatiga visual por baja iluminación', 'Almacén general', 5),
        (5, 'Estante inestable', 'Riesgo de caída de objetos', 'Bodega de materiales', 5),
        (6, 'Máquina sin protección', 'Falta de guardas de seguridad', 'Área de producción', 2),
        (7, 'Ventilación deficiente', 'Acumulación de gases y vapores', 'Laboratorio de calidad', 6),
        (8, 'Escalera dañada', 'Peldaños sueltos o rotos', 'Acceso segundo piso', 1),
        (9, 'Extintor vencido', 'Equipo de emergencia no funcional', 'Pasillo de emergencia', 7),
        (10, 'Piso resbaladizo', 'Superficie con aceite o grasa', 'Cocina', 8),
        (11, 'Ruido excesivo', 'Niveles de ruido por encima del límite', 'Área de producción', 2),
        (12, 'Temperatura extrema', 'Calor excesivo en área de trabajo', 'Sala de calderas', 3)");
    // RIESGO
    $conn->exec("INSERT INTO riesgo (id_riesgo, tipo, descripcion, condicion_insegura_id_cond_inseg, area_id_area) VALUES
        (1, 'Caídas al mismo nivel', 'Riesgo de caídas por superficies resbaladizas', 1, 1),
        (2, 'Cortes y heridas', 'Riesgo de lesiones con herramientas', 2, 3),
        (3, 'Electrocución', 'Riesgo de descarga eléctrica', 3, 1),
        (4, 'Fatiga visual', 'Riesgo de daño ocular por mala iluminación', 4, 5),
        (5, 'Golpes por objetos', 'Riesgo de impacto por caída de objetos', 5, 5),
        (6, 'Atrapamiento', 'Riesgo de atrapamiento en maquinaria', 6, 2),
        (7, 'Intoxicación', 'Riesgo de exposición química', 7, 6),
        (8, 'Caídas a diferente nivel', 'Riesgo de caída en escaleras', 8, 1),
        (9, 'Incendio', 'Riesgo de propagación de fuego', 9, 7),
        (10, 'Quemaduras', 'Riesgo de quemaduras por líquidos calientes', 10, 8),
        (11, 'Hipoacusia', 'Riesgo de pérdida auditiva por ruido', 11, 2),
        (12, 'Golpe de calor', 'Riesgo de estrés térmico', 12, 3)");

    // INCIDENTE
    $conn->exec("INSERT INTO incidente (id_incidente, tipo, descripcion, fecha_hora, lugar, tipo_vinc_lab, jornada_laboral, turno_mom_inc, uso_epp, area_id_area, empleado_id_empleado) VALUES
        (1, 'Derrame menor', 'Derrame de líquido en el área de almacén', '2025-08-01 08:00:00', 'Almacén', 'Directo', 'Diurna', 'Mañana', 'Guantes', 5, 4),
        (2, 'Fallo eléctrico', 'Corte de energía en oficina administrativa', '2025-08-02 09:30:00', 'Oficina', 'Contratista', 'Nocturna', 'Noche', 'Casco', 1, 2),
        (3, 'Susto por caída', 'Casi accidente por piso mojado', '2025-08-03 10:15:00', 'Pasillo', 'Directo', 'Diurna', 'Tarde', 'Zapatos antideslizantes', 1, 2),
        (4, 'Golpe leve', 'Golpe con herramienta sin lesión', '2025-08-04 11:00:00', 'Taller', 'Contratista', 'Nocturna', 'Mañana', 'Guantes de seguridad', 2, 1),
        (5, 'Estrés laboral', 'Estrés por sobrecarga de trabajo', '2025-08-05 12:45:00', 'Oficina RRHH', 'Directo', 'Diurna', 'Tarde', 'Ninguno', 4, 5),
        (6, 'Resbalón menor', 'Resbalón en área de mantenimiento', '2025-08-06 14:20:00', 'Sala de máquinas', 'Directo', 'Diurna', 'Tarde', 'Botas antideslizantes', 3, 3),
        (7, 'Atrapamiento menor', 'Dedo atrapado en puerta', '2025-08-07 07:30:00', 'Entrada principal', 'Directo', 'Diurna', 'Mañana', 'Ninguno', 1, 2),
        (8, 'Exposición química', 'Exposición menor a productos de limpieza', '2025-08-08 16:15:00', 'Baños', 'Contratista', 'Diurna', 'Tarde', 'Guantes y mascarilla', 1, 2)");

    // ACCIDENTE
    $conn->exec("INSERT INTO accidente (id_accidente, tipo, descripcion, clasificacion, estado, fecha_hora, lugar, tipo_vinc_lab_, jornada_laboral, turno_mom_acc, uso_epp, consecuencias, gravedad, tipo_lesion, parte_cuerpo_afect, incapacidad_lab, aten_med_recibida, persona_informo, area_id_area, empleado_id_empleado) VALUES
        (1, 'Caída', 'Caída en pasillo por piso mojado', 'Leve', 'Cerrado', '2025-09-01 08:00:00', 'Pasillo principal', 'Directo', 'Diurna', 'Mañana', 'Zapatos antideslizantes', 'Contusión menor', 'Leve', 'Contusión', 'Pierna derecha', 'No', 'Observación médica', 'Juan Pérez', 1, 2),
        (2, 'Corte', 'Corte con herramienta defectuosa', 'Moderado', 'Abierto', '2025-09-02 09:30:00', 'Taller de mantenimiento', 'Contratista', 'Nocturna', 'Noche', 'Guantes de seguridad', 'Herida profunda', 'Moderada', 'Herida cortante', 'Mano izquierda', 'Sí', 'Sutura y antibióticos', 'Luis Martínez', 3, 3),
        (3, 'Golpe', 'Golpe con objeto en almacén', 'Leve', 'Cerrado', '2025-09-03 10:15:00', 'Almacén general', 'Directo', 'Diurna', 'Tarde', 'Casco de seguridad', 'Contusión leve', 'Leve', 'Contusión', 'Cabeza', 'No', 'Analgésicos', 'Sofía López', 5, 4),
        (4, 'Resbalón', 'Resbalón en oficina administrativa', 'Leve', 'Cerrado', '2025-09-04 11:00:00', 'Oficina administrativa', 'Directo', 'Diurna', 'Mañana', 'Zapatos de oficina', 'Contusión menor', 'Leve', 'Contusión', 'Brazo derecho', 'No', 'Hielo y reposo', 'Ana García', 1, 2),
        (5, 'Lesión ergonómica', 'Lesión muscular por mala postura', 'Moderado', 'Abierto', '2025-09-05 12:45:00', 'Oficina RRHH', 'Directo', 'Diurna', 'Tarde', 'Ninguno', 'Distensión muscular', 'Moderada', 'Distensión', 'Espalda baja', 'Sí', 'Fisioterapia y analgésicos', 'Carlos Ramírez', 4, 5),
        (6, 'Quemadura', 'Quemadura con líquido caliente', 'Leve', 'Cerrado', '2025-09-06 13:20:00', 'Cocina', 'Directo', 'Diurna', 'Tarde', 'Delantal', 'Quemadura primer grado', 'Leve', 'Quemadura', 'Antebrazo', 'No', 'Pomada y vendaje', 'Juan Pérez', 1, 1),
        (7, 'Atrapamiento', 'Dedo atrapado en maquinaria', 'Grave', 'Abierto', '2025-09-07 08:45:00', 'Área de producción', 'Directo', 'Diurna', 'Mañana', 'Guantes industriales', 'Fractura menor', 'Grave', 'Fractura', 'Dedo índice', 'Sí', 'Radiografía e inmovilización', 'Luis Martínez', 2, 1)");

    // INSPECCION_LOCATIVA
    $conn->exec("INSERT INTO inspeccion_locativa (id_insp_loc, tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, element_trab, observaciones, categoria_id_categoria, incidente_id_incidente, accidente_id_accidente, riesgo_id_riesgo, empleado_id_empleado, area_id_area) VALUES
        (1, 'General', '2025-07-01 08:00:00', 'Inspección rutinaria del área administrativa', 'Aprobada', 'Extintor', 'Extintores en buen estado', 1, 1, 1, 1, 2, 1),
        (2, 'Eléctrica', '2025-07-02 09:30:00', 'Revisión de instalaciones eléctricas', 'Pendiente', 'Cableado', 'Cable expuesto requiere protección', 3, 2, 4, 3, 3, 1),
        (3, 'Almacén', '2025-07-03 10:15:00', 'Revisión de estanterías y almacenamiento', 'Pendiente', 'Estanterías', 'Estante requiere refuerzo estructural', 4, 1, 3, 5, 4, 5),
        (4, 'Iluminación', '2025-07-04 11:00:00', 'Evaluación de niveles de iluminación', 'Pendiente', 'Lámparas', 'Instalar lámparas adicionales', 8, 5, 5, 4, 5, 4),
        (5, 'Maquinaria', '2025-07-05 12:45:00', 'Revisión de equipos de producción', 'Rechazada', 'Sierra circular', 'Falta protector de seguridad', 2, 4, 2, 6, 1, 2),
        (6, 'Seguridad', '2025-07-06 14:20:00', 'Revisión de equipos de emergencia', 'Aprobada', 'Botiquines', 'Equipos completos y vigentes', 9, NULL, NULL, 9, 9, 7),
        (7, 'Calidad del aire', '2025-07-07 07:30:00', 'Medición de calidad del aire', 'Pendiente', 'Ventilación', 'Mejorar sistema de ventilación', 7, NULL, NULL, 7, 8, 6),
        (8, 'Ruido', '2025-07-08 16:15:00', 'Medición de niveles de ruido', 'Aprobada', 'Proteón auditiva', 'Niveles dentro de límites permitidos', 6, NULL, NULL, 11, 6, 2),
        (9, 'Escaleras', '2025-07-09 08:45:00', 'Inspección de accesos verticales', 'Pendiente', 'Barandas', 'Reparar barandas dañadas', 8, 3, 1, 8, 7, 1),
        (10, 'Cocina', '2025-07-10 13:00:00', 'Revisión de área de alimentación', 'Aprobada', 'Campana extractora', 'Sistema de extracción funcionando correctamente', 10, NULL, 6, 10, 10, 8)");


    echo "Datos insertados correctamente.\n";
}

// INSTRUCCIONES DE USO:
// 1. Para crear roles iniciales, descomente la línea: crearRolesIniciales();
// 2. Para crear usuarios iniciales, descomente la línea: crearUsuariosIniciales();
// 3. Para poblar todas las tablas con datos de ejemplo, descomente la línea: poblarTablasRACI();

// CAMBIOS REALIZADOS EN LA REFACTORIZACIÓN Y ACTUALIZACIÓN:
// - Se agregaron los campos 'empleado_id_empleado' a las tablas: incidente y accidente
// - Se ampliaron las áreas de 5 a 8: Administración, Producción, Mantenimiento, RRHH, Almacén, Calidad, Seguridad, Cafetería
// - Se incrementó el número de empleados de 5 a 10 para mayor variedad
// - Se expandieron las categorías de 5 a 10: Ergonomía, Mecánica, Eléctrica, Química, Psicosocial, Física, Biológica, Locativa, Natural, Tecnológica
// - Se agregaron más condiciones inseguras (12 registros) y riesgos (12 registros)
// - Se incrementó el número de incidentes de 5 a 8 registros
// - Se incrementó el número de accidentes de 5 a 7 registros
// - Se ampliaron las inspecciones locativas de 5 a 10 registros
// - Todos los registros incluyen referencias válidas a empleados y mantienen integridad referencial
// - Las descripciones se hicieron más detalladas y realistas
// - Se distribuyeron los registros proporcionalmente entre las diferentes áreas

// Ejecutar solo una vez para poblar roles y usuarios
// crearRolesIniciales();
// crearUsuariosIniciales();
// poblarTablasRACI();

// Para ejecutar todo de una vez, descomente la siguiente línea:
// crearRolesIniciales(); crearUsuariosIniciales(); poblarTablasRACI();

echo "Script de seed completado. Para ejecutar, descomente las líneas correspondientes y ejecute: php seed.php\n";
