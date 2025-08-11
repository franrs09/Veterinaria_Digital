<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    // Obtener todos los servicios x consulta 
    $sql = "SELECT servicio_id, nombre, descripcion, precio FROM servicios ORDER BY nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'servicios' => $servicios
    ]);
    
} catch(Exception $e) {
    // En caso de error
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error al obtener servicios: ' . $e->getMessage()
    ]);
}
?>
