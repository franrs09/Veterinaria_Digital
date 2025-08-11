<?php
require_once 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
    exit;
}

try {
    // FILTRO
    $fechaDesde = $_GET['fecha_desde'] ?? date('Y-m-d');
    $fechaHasta = $_GET['fecha_hasta'] ?? date('Y-m-d', strtotime('+7 days'));
    $estado = $_GET['estado'] ?? 'todas';

    $sql = "SELECT 
                c.cita_id,
                c.fecha_hora,
                c.motivo_consulta,
                c.estado,
                c.fecha_creacion,
                u.nombre_completo as dueno,
                u.telefono,
                u.email,
                m.nombre as mascota,
                tm.nombre as tipo_mascota,
                s.nombre as servicio,
                s.precio
            FROM citas c
            INNER JOIN usuarios u ON c.usuario_id = u.usuario_id
            INNER JOIN mascotas m ON c.mascota_id = m.mascota_id
            INNER JOIN tipos_mascota tm ON m.tipo_id = tm.tipo_id
            INNER JOIN servicios s ON c.servicio_id = s.servicio_id
            WHERE DATE(c.fecha_hora) BETWEEN ? AND ?";

    $params = [$fechaDesde, $fechaHasta];

    if ($estado !== 'todas') {
        $sql .= " AND c.estado = ?";
        $params[] = $estado;
    }

    $sql .= " ORDER BY c.fecha_hora ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formateos de salida para el frontend
    foreach ($citas as &$cita) {
        $fecha = new DateTime($cita['fecha_hora']);
        $cita['fecha_formateada'] = $fecha->format('d/m/Y');
        $cita['hora_formateada'] = $fecha->format('H:i');
        $cita['precio_formateado'] = '₡' . number_format((float)$cita['precio'], 0, ',', '.');
    }

    echo json_encode([
        'success' => true,
        'citas' => $citas,
        'total' => count($citas)
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error al consultar citas: ' . $e->getMessage()
    ]);
}
?>
