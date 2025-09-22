<?php
require_once __DIR__ . '/../core/Database.php';

class Accidente {
    public static function getFiltered($tipo = '', $fecha = '', $lugar = '', $orden = 'id_asc', $id = '') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM accidente';
        $where = [];
        $params = [];
        if ($id !== '' && is_numeric($id)) {
            $where[] = 'id_accidente = ?';
            $params[] = $id;
        }
        if ($tipo !== '') {
            $where[] = 'tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($fecha !== '') {
            $where[] = 'DATE(fecha_hora) = ?';
            $params[] = $fecha;
        }
        if ($lugar !== '') {
            $where[] = 'lugar LIKE ?';
            $params[] = "%$lugar%";
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY tipo DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY id_accidente DESC';
                break;
            default:
                $sql .= ' ORDER BY id_accidente ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM accidente');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM accidente WHERE id_accidente = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO accidente (tipo, descripcion, clasificacion, estado, fecha_hora, lugar, tipo_vinc_lab_, jornada_laboral, turno_mom_acc, uso_epp, consecuencias, gravedad, tipo_lesion, parte_cuerpo_afect, incapacidad_lab, aten_med_recibida, persona_informo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['tipo'], $data['descripcion'], $data['clasificacion'], $data['estado'], $data['fecha_hora'], $data['lugar'], $data['tipo_vinc_lab_'], $data['jornada_laboral'], $data['turno_mom_acc'], $data['uso_epp'], $data['consecuencias'], $data['gravedad'], $data['tipo_lesion'], $data['parte_cuerpo_afect'], $data['incapacidad_lab'], $data['aten_med_recibida'], $data['persona_informo']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE accidente SET tipo=?, descripcion=?, clasificacion=?, estado=?, fecha_hora=?, lugar=?, tipo_vinc_lab_=?, jornada_laboral=?, turno_mom_acc=?, uso_epp=?, consecuencias=?, gravedad=?, tipo_lesion=?, parte_cuerpo_afect=?, incapacidad_lab=?, aten_med_recibida=?, persona_informo=? WHERE id_accidente=?');
        $stmt->execute([
            $data['tipo'], $data['descripcion'], $data['clasificacion'], $data['estado'], $data['fecha_hora'], $data['lugar'], $data['tipo_vinc_lab_'], $data['jornada_laboral'], $data['turno_mom_acc'], $data['uso_epp'], $data['consecuencias'], $data['gravedad'], $data['tipo_lesion'], $data['parte_cuerpo_afect'], $data['incapacidad_lab'], $data['aten_med_recibida'], $data['persona_informo'], $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM accidente WHERE id_accidente = ?');
        $stmt->execute([$id]);
    }
}
