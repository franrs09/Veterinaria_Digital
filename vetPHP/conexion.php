<?php
$servidor = "localhost";
$usuario = "veterinaria_user";
$password = "veterinaria123";
$base_datos = "veterinaria_digital";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    
    // Configurar PDO para lanzar excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8");
    
} catch(PDOException $e) {
    // Si hay error en la conexion, mostrar mensaje y terminar ejecucion
    die("Error de conexión: " . $e->getMessage());
}
?>
