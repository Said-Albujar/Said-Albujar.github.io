<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Incluir configuración de conexión a la base de datos
include 'conexion.php'; // Asegúrate de cambiar el nombre del archivo si lo has guardado con otro nombre

// Consulta SQL para obtener los top 10 puntajes ordenados por puntaje descendente
$sql = "SELECT nick, puntaje, telefono FROM puntaje ORDER BY puntaje DESC LIMIT 10";

try {
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Obtener resultados de la consulta
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Preparar respuesta en formato JSON
    $response = array(
        "status" => "ok",
        "message" => "Consulta de top 10 puntajes exitosa",
        "data" => $resultados
    );
    http_response_code(200); // OK

    // Registro de consulta de top 10 en el log
    $log_message = "[" . date('Y-m-d H:i:s') . "] Consulta de top 10 puntajes realizada exitosamente.\n";
    registrarLog($log_message, 'top');

} catch(PDOException $e) {
    // Capturar y registrar errores de consulta en el log
    $error_message = "[" . date('Y-m-d H:i:s') . "] Error al ejecutar la consulta de top 10 puntajes: " . $e->getMessage() . "\n";
    registrarLog($error_message, 'top');

    // Preparar respuesta de error en formato JSON
    $response = array(
        "status" => "failed",
        "message" => "Error al ejecutar la consulta de top 10 puntajes: " . $e->getMessage()
    );
    http_response_code(500); // Internal Server Error
}

// Devolver respuesta JSON
echo json_encode($response);

// Cerrar conexión a la base de datos (ya incluida en 'conexion.php')
?>
