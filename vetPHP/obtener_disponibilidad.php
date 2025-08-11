<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    $fechaActual = date('Y-m-d H:i:s');
    
    // Consultar citas existentes para los proximos 30 dias
    $sql = "SELECT DATE(fecha_hora) as fecha, COUNT(*) as total_citas 
            FROM citas 
            WHERE fecha_hora >= ? AND fecha_hora <= DATE_ADD(?, INTERVAL 30 DAY)
            AND estado != 'cancelada'
            GROUP BY DATE(fecha_hora)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fechaActual, $fechaActual]);
    
    $citasExistentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $fechasOcupadas = [];
    foreach ($citasExistentes as $cita) {
        if ($cita['total_citas'] >= 8) {  // Maximo 8 citas por dia
            $fechasOcupadas[] = $cita['fecha'];
        }
    }
    
    // horarios ocupados para hoy
    $hoy = date('Y-m-d');
    $sqlHorarios = "SELECT TIME(fecha_hora) as hora 
                    FROM citas 
                    WHERE DATE(fecha_hora) = ? AND estado != 'cancelada'";
    
    $stmtHorarios = $pdo->prepare($sqlHorarios);
    $stmtHorarios->execute([$hoy]);
    
    $horariosOcupados = [];
    while ($horario = $stmtHorarios->fetch()) {
        $horariosOcupados[] = $horario['hora'];
    }
    
    echo json_encode([
        'success' => true,
        'fechas_ocupadas' => $fechasOcupadas,
        'horarios_ocupados' => $horariosOcupados,
        'horarios_disponibles' => [
            '08:00', '09:00', '10:00', '11:00', 
            '14:00', '15:00', '16:00', '17:00'
        ]
    ]);
    
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error al obtener disponibilidad: ' . $e->getMessage()
    ]);
}
?>
