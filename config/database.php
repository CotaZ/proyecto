<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Ajusta según tu configuración de XAMPP
$password = ""; // Ajusta según tu configuración de XAMPP
$dbname = "voting_system";

$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar la conexión
if ($conn->connect_error) {
    // En caso de error, mostrar un mensaje y terminar el script
    die("Error en la conexión: " . $conn->connect_error);
} else {
    // Si la conexión es exitosa, mostrar un mensaje de éxito
    echo "Conexión exitosa a la base de datos.";
}

// Cerrar la conexión
