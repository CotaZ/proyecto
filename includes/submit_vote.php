<?php
// Verificar si se ha recibido una solicitud POST
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    require_once '../config/database.php';

    // Obtiene los datos del formulario
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
    $rut = isset($_POST["rut"]) ? $_POST["rut"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $region = isset($_POST["region"]) ? $_POST["region"] : "";
    $comuna = isset($_POST["comuna"]) ? $_POST["comuna"] : "";
    $candidato = isset($_POST["candidato"]) ? $_POST["candidato"] : "";
    $source = isset($_POST["source"]) ? implode(", ", $_POST["source"]) : "";

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO votes (name, alias, rut, email, region, comuna, candidato, source) VALUES ('$name', '$alias', '$rut', '$email', '$region', '$comuna', '$candidato', '$source')";

    if ($conn->query($sql) === TRUE) {
        echo "Voto registrado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No se han recibido datos POST.";
}
?>
