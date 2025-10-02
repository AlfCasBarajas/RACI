<?php
require_once __DIR__ . '/../core/Database.php';

function crearUsuariosIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
    $usuarios = [
        ['num_doc' => 1, 'tipo_doc' => 'CC', 'nombres' => 'admin', 'apellidos' => 'Administrador', 'rol' => 1, 'contraseña' => password_hash('admin123', PASSWORD_DEFAULT), 'telefono' => 123456789],
        ['num_doc' => 2, 'tipo_doc' => 'CC', 'nombres' => 'super', 'apellidos' => 'Supervisor', 'rol' => 2, 'contraseña' => password_hash('456', PASSWORD_DEFAULT), 'telefono' => 234567890],
        ['num_doc' => 3, 'tipo_doc' => 'CC', 'nombres' => 'coord', 'apellidos' => 'Coordinador', 'rol' => 3, 'contraseña' => password_hash('789', PASSWORD_DEFAULT), 'telefono' => 345678901],
        ['num_doc' => 4, 'tipo_doc' => 'CC', 'nombres' => 'traba', 'apellidos' => 'Trabajador', 'rol' => 4, 'contraseña' => password_hash('369', PASSWORD_DEFAULT), 'telefono' => 456789012]
    ];
    foreach ($usuarios as $u) {
        $stmt = $conn->prepare('INSERT INTO user (num_doc, tipo_doc, nombres, apellidos, rol, contraseña, telefono) VALUES (:num_doc, :tipo_doc, :nombres, :apellidos, :rol, :contraseña, :telefono)');
        $stmt->execute($u);
    }
}

function crearRolesIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
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

    // AREA
    $conn->exec("INSERT INTO area (id_area, nombre, descripcion) VALUES
        (1, 'Administración', 'Área administrativa'),
        (2, 'Producción', 'Área de producción'),
        (3, 'Mantenimiento', 'Área de mantenimiento'),
        (4, 'Recursos Humanos', 'Área de RRHH'),
        (5, 'Almacén', 'Área de almacén')");

    // EMPLEADO
    $conn->exec("INSERT INTO empleado (id_empleado, tipo_doc, nombres, apellidos, telefono, eps, arl, cargo_funcion, antig_cargo, rol) VALUES
        (1, 'CC', 'Juan', 'Pérez', 123456789, 'Sura', 'Colmena', 'Operario', '2 años', 4),
        (2, 'CC', 'Ana', 'García', 234567890, 'Nueva EPS', 'Bolívar', 'Administrativa', '1 año', 1),
        (3, 'CC', 'Luis', 'Martínez', 345678901, 'Sanitas', 'Sura', 'Técnico', '3 años', 3),
        (4, 'CC', 'Sofía', 'López', 456789012, 'Compensar', 'Colmena', 'Almacenista', '1 año', 2),
        (5, 'CC', 'Carlos', 'Ramírez', 567890123, 'Famisanar', 'Bolívar', 'RRHH', '4 años', 1)");

    // CATEGORIA
    $conn->exec("INSERT INTO categoria (id_categoria, nombre, descripcion, area_id_area, user_num_doc, empleado_id_empleado) VALUES
        (1, 'Ergonomía', 'Riesgos ergonómicos', 1, 1053349252, 1),
        (2, 'Mecánica', 'Riesgos mecánicos', 2, 1156464465, 3),
        (3, 'Eléctrica', 'Riesgos eléctricos', 3, 1546465465, 2),
        (4, 'Química', 'Riesgos químicos', 4, 3256464454, 4),
        (5, 'Psicosocial', 'Riesgos psicosociales', 5, 1053349252, 5)");

    // CONDICION_INSEGURA
    $conn->exec("INSERT INTO condicion_insegura (id_cond_inseg, nombre, descripcion, lugar) VALUES
        (1, 'Piso mojado', 'Riesgo de resbalón', 'Pasillo'),
        (2, 'Herramienta defectuosa', 'Puede causar lesiones', 'Taller'),
        (3, 'Cable suelto', 'Riesgo eléctrico', 'Oficina'),
        (4, 'Iluminación insuficiente', 'Fatiga visual', 'Almacén'),
        (5, 'Estante inestable', 'Riesgo de caída', 'Bodega')");

    // RIESGO
    $conn->exec("INSERT INTO riesgo (id_riesgo, tipo, descripcion, condicion_insegura_id_cond_inseg) VALUES
        (1, 'Caídas', 'Riesgo de caídas', 1),
        (2, 'Cortes', 'Riesgo de cortes', 2),
        (3, 'Electrocución', 'Riesgo eléctrico', 3),
        (4, 'Estrés', 'Riesgo psicosocial', 4),
        (5, 'Postura', 'Riesgo ergonómico', 5)");

    // INCIDENTE
    $conn->exec("INSERT INTO incidente (id_incidente, tipo, descripcion, fecha_hora, lugar, tipo_vinc_lab, jornada_laboral, turno_mom_inc, uso_epp) VALUES
        (1, 'Derrame menor', 'Derrame de líquido', '2025-08-01 08:00:00', 'Almacén', 'Directo', 'Diurna', 'Mañana', 'Guantes'),
        (2, 'Fallo eléctrico', 'Corte de energía', '2025-08-02 09:30:00', 'Oficina', 'Contratista', 'Nocturna', 'Noche', 'Casco'),
        (3, 'Susto por caída', 'Casi accidente', '2025-08-03 10:15:00', 'Pasillo', 'Directo', 'Diurna', 'Tarde', 'Zapatos'),
        (4, 'Golpe leve', 'Golpe sin lesión', '2025-08-04 11:00:00', 'Taller', 'Contratista', 'Nocturna', 'Mañana', 'Guantes'),
        (5, 'Estrés laboral', 'Estrés por carga', '2025-08-05 12:45:00', 'Oficina', 'Directo', 'Diurna', 'Tarde', 'Ninguno')");

    // ACCIDENTE
    $conn->exec("INSERT INTO accidente (id_accidente, tipo, descripcion, clasificacion, estado, fecha_hora, lugar, tipo_vinc_lab_, jornada_laboral, turno_mom_acc, uso_epp, consecuencias, gravedad, tipo_lesion, parte_cuerpo_afect, incapacidad_lab, aten_med_recibida, persona_informo) VALUES
        (1, 'Caída', 'Caída en pasillo', 'Leve', 'Cerrado', '2025-09-01 08:00:00', 'Pasillo', 'Directo', 'Diurna', 'Mañana', 'Guantes', 'Contusión', 'Leve', 'Contusión', 'Pierna', 'No', 'No requirió', 'Juan Pérez'),
        (2, 'Corte', 'Corte con herramienta', 'Moderado', 'Abierto', '2025-09-02 09:30:00', 'Taller', 'Contratista', 'Nocturna', 'Noche', 'Guantes', 'Herida', 'Moderada', 'Herida', 'Mano', 'Sí', 'Sutura', 'Luis Martínez'),
        (3, 'Golpe', 'Golpe en almacén', 'Leve', 'Cerrado', '2025-09-03 10:15:00', 'Almacén', 'Directo', 'Diurna', 'Tarde', 'Casco', 'Contusión', 'Leve', 'Contusión', 'Cabeza', 'No', 'No requirió', 'Sofía López'),
        (4, 'Resbalón', 'Resbalón en oficina', 'Leve', 'Cerrado', '2025-09-04 11:00:00', 'Oficina', 'Contratista', 'Nocturna', 'Mañana', 'Zapatos', 'Contusión', 'Leve', 'Contusión', 'Brazo', 'No', 'No requirió', 'Ana García'),
        (5, 'Lesión por postura', 'Lesión muscular', 'Leve', 'Cerrado', '2025-09-05 12:45:00', 'Oficina', 'Directo', 'Diurna', 'Tarde', 'Ninguno', 'Distensión', 'Leve', 'Distensión', 'Espalda', 'Sí', 'Fisioterapia', 'Carlos Ramírez')");

    // INSPECCION_LOCATIVA
    $conn->exec("INSERT INTO inspeccion_locativa (id_insp_loc, tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, element_trab, observaciones, categoria_id_categoria, incidente_id_incidente, accidente_id_accidente, riesgo_id_riesgo) VALUES
        (1, 'General', '2025-07-01 08:00:00', 'Todo en orden', 'Aprobada', 'Extintor', 'Sin observaciones', 1, 1, 1, 1),
        (2, 'Eléctrica', '2025-07-02 09:30:00', 'Detectado cable suelto', 'Pendiente', 'Cable', 'Reparar cable', 2, 2, 2, 2),
        (3, 'Almacén', '2025-07-03 10:15:00', 'Estante requiere ajuste', 'Pendiente', 'Estante', 'Ajustar estante', 3, 3, 3, 3),
        (4, 'Iluminación', '2025-07-04 11:00:00', 'Iluminación baja', 'Pendiente', 'Lámpara', 'Instalar lámpara', 4, 4, 4, 4),
        (5, 'Herramientas', '2025-07-05 12:45:00', 'Herramienta defectuosa', 'Pendiente', 'Herramienta', 'Reemplazar herramienta', 5, 5, 5, 5);");


    echo "Datos insertados correctamente.\n";
}

// Ejecutar solo una vez para poblar roles y usuarios
// crearRolesIniciales();
// crearUsuariosIniciales();
//poblarTablasRACI();
