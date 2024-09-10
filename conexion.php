<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Configuración de conexión a la base de datos
$servername = "netdreams.pe";
$username = "netdrepe_pruebas";
$password = "itIsnt4u";
$dbname = "netdrepe_pruebas";

try {
    // Crear conexión a la base de datos usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Registro de conexión exitosa en el log
    $log_message = "[" . date('Y-m-d H:i:s') . "] Conexión establecida correctamente a la base de datos.\n";
    registrarLog($log_message, 'conexion');

} catch(PDOException $e) {
    // Capturar y registrar errores de conexión en el log
    $error_message = "[" . date('Y-m-d H:i:s') . "] Error en la conexión a la base de datos: " . $e->getMessage() . "\n";
    registrarLog($error_message, 'conexion');

    // Terminar el script y mostrar mensaje de error
    die("Error en la conexión: " . $e->getMessage());
}

function registrarLog($mensaje, $tipoLog) {
    $ruta_logs = 'logs/' . $tipoLog . '/';
    $nombre_archivo = $tipoLog . '_' . date('Y-m-d') . '.log';
    $archivo_completo = $ruta_logs . $nombre_archivo;

    // Crear el directorio si no existe
    if (!file_exists($ruta_logs)) {
        mkdir($ruta_logs, 0777, true); // Crea directorio recursivamente
    }

    // Registrar el mensaje en el archivo de log
    error_log($mensaje, 3, $archivo_completo);
}
?>
