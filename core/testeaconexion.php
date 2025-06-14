<?php

require_once(__DIR__ . '/Conexion.php');

// Usamos reflexión para acceder a las propiedades privadas
function mostrarCredenciales($conexion) {
    $ref = new ReflectionClass($conexion);
    $userProp = $ref->getProperty('user');
    $userProp->setAccessible(true);
    $passProp = $ref->getProperty('pass');
    $passProp->setAccessible(true);

    echo "Usuario recibido: " . $userProp->getValue($conexion) . "\n";
    echo "Contraseña recibida: " . $passProp->getValue($conexion) . "\n";
}

try {
    $conexion = new Conexion();
    mostrarCredenciales($conexion);
    if ($conexion->getConexion()) {
        echo "Conexión exitosa a la base de datos.\n";
    } else {
        echo "No se pudo conectar a la base de datos.\n";
    }
    $conexion->close();
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
    echo "Asegúrate de que el archivo de configuración 'config.php' existe y contiene las credenciales correctas.\n";
}
?>