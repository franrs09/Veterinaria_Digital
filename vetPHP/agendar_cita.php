<?php
require_once 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
    exit;
}

try {
    $raw = file_get_contents('php://input');
    $datos = json_decode($raw, true);
    if (!is_array($datos)) {
        $datos = $_POST;
    }

    // Validación de campos 
    $requeridos = ['nombreDueno','telefono','nombreMascota','tipoMascota','fechaCita','servicio','motivo'];
    foreach ($requeridos as $campo) {
        if (empty($datos[$campo])) {
            echo json_encode(['success' => false, 'mensaje' => 'Faltan campos obligatorios']);
            exit;
        }
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT usuario_id FROM usuarios WHERE telefono = ?");
    $stmt->execute([$datos['telefono']]);
    $usr = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usr) {
        $usuarioId = (int)$usr['usuario_id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_completo, telefono, email, contrasena) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $datos['nombreDueno'],
            $datos['telefono'],
            $datos['email'] ?? '',
            password_hash('temporal123', PASSWORD_DEFAULT)
        ]);
        $usuarioId = (int)$pdo->lastInsertId();
    }

    // Tipo de mascota: obtener o crear
    $stmt = $pdo->prepare("SELECT tipo_id FROM tipos_mascota WHERE nombre = ?");
    $stmt->execute([$datos['tipoMascota']]);
    $tipo = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($tipo) {
        $tipoId = (int)$tipo['tipo_id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO tipos_mascota (nombre) VALUES (?)");
        $stmt->execute([$datos['tipoMascota']]);
        $tipoId = (int)$pdo->lastInsertId();
    }

    // Mascota: obtener o crear por usuario + nombre
    $stmt = $pdo->prepare("SELECT mascota_id FROM mascotas WHERE usuario_id = ? AND nombre = ?");
    $stmt->execute([$usuarioId, $datos['nombreMascota']]);
    $mas = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($mas) {
        $mascotaId = (int)$mas['mascota_id'];
    } else {
        $edad = null;
        if (!empty($datos['edad'])) {
            $edadNum = filter_var($datos['edad'], FILTER_SANITIZE_NUMBER_INT);
            if ($edadNum !== '' && $edadNum !== null) {
                $edad = (int)$edadNum;
            }
        }
        $stmt = $pdo->prepare("INSERT INTO mascotas (usuario_id, nombre, tipo_id, edad, alergias, condiciones_especiales) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $usuarioId,
            $datos['nombreMascota'],
            $tipoId,
            $edad,
            $datos['alergias'] ?? '',
            ''
        ]);
        $mascotaId = (int)$pdo->lastInsertId();
    }

    // Servicio: obtener o crear
    $stmt = $pdo->prepare("SELECT servicio_id FROM servicios WHERE nombre = ?");
    $stmt->execute([$datos['servicio']]);
    $srv = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($srv) {
        $servicioId = (int)$srv['servicio_id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO servicios (nombre, descripcion, precio) VALUES (?, ?, ?)");
        $stmt->execute([$datos['servicio'], 'Servicio agregado automáticamente', 0]);
        $servicioId = (int)$pdo->lastInsertId();
    }

    // Normalizar fecha/hora a formato DATETIME de MySQL
    $fechaHora = (string)$datos['fechaCita'];
    $fechaHora = str_replace('T', ' ', $fechaHora);
    if (strlen($fechaHora) === 16) { // yyyy-mm-dd hh:mm
        $fechaHora .= ':00';
    }

    // Crear cita en estado pendiente
    $stmt = $pdo->prepare("INSERT INTO citas (usuario_id, mascota_id, servicio_id, fecha_hora, motivo_consulta, estado) VALUES (?, ?, ?, ?, ?, 'pendiente')");
    $stmt->execute([$usuarioId, $mascotaId, $servicioId, $fechaHora, $datos['motivo']]);
    $citaId = (int)$pdo->lastInsertId();

    $pdo->commit();

    echo json_encode(['success' => true, 'mensaje' => 'Cita agendada exitosamente', 'cita_id' => $citaId]);
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => 'Error al agendar cita: ' . $e->getMessage()]);
}
?>
