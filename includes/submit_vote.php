<?php
// Verificar si se ha recibido una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    require_once '../config/database.php';

    // Obtener los datos del formulario
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
    $rut = isset($_POST["rut"]) ? $_POST["rut"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $region = isset($_POST["region"]) ? $_POST["region"] : "";
    $comuna = isset($_POST["comuna"]) ? $_POST["comuna"] : "";
    $candidato = isset($_POST["candidato"]) ? $_POST["candidato"] : "";
    $source = isset($_POST["source"]) ? implode(", ", $_POST["source"]) : "";

    // Verificar si el RUT ya existe en la base de datos
    $rutExistsQuery = "SELECT COUNT(*) AS count FROM votes WHERE rut = '$rut'";
    $rutExistsResult = $conn->query($rutExistsQuery);
    $rutExistsRow = $rutExistsResult->fetch_assoc();
    if ($rutExistsRow['count'] > 0) {
        echo "Error: El RUT ya ha sido registrado.";
        exit; // Salir del script si el RUT ya existe
    }

    // Verificar si el email ya existe en la base de datos
    $emailExistsQuery = "SELECT COUNT(*) AS count FROM votes WHERE email = '$email'";
    $emailExistsResult = $conn->query($emailExistsQuery);
    $emailExistsRow = $emailExistsResult->fetch_assoc();
    if ($emailExistsRow['count'] > 0) {
        echo "Error: El email ya ha sido registrado.";
        exit; // Salir del script si el email ya existe
    }

    // Verificar si el dominio del correo electrónico es válido
    $allowedDomains = array(
        "gmail.com",
        "yahoo.com",
        "outlook.com",
        "hotmail.com",
        "aol.com",
        "apple.com",
        "ibm.com",
        "microsoft.com",
        "amazon.com",
        "facebook.com",
        "twitter.com",
        "linkedin.com",
        "uber.com",
        "airbnb.com",
        "netflix.com",
        "spotify.com",
        "paypal.com",
        "visa.com",
        "mastercard.com",
        "americanexpress.com",
        "bankofamerica.com",
        "chase.com",
        "wellsfargo.com",
        "citi.com",
        "capitalone.com",
        "att.com",
        "verizon.com",
        "comcast.net",
        "sprint.com",
        "tmobile.com",
        "sony.com",
        "nintendo.com",
        "samsung.com",
        "lg.com",
        "toyota.com",
        "honda.com",
        "bmw.com",
        "mercedes-benz.com",
        // Dominios .cl
        "entel.cl",
        "lan.cl",
        "latam.cl",
        "movistar.cl",
        "ripley.cl",
        "falabella.cl",
        "sodimac.cl",
        "cencosud.cl",
        "paris.cl",
        "bci.cl",
        "bancoestado.cl",
        "santander.cl",
        "bci.cl",
        "ripley.cl",
        "falabella.cl",
        "paris.cl",
        "latam.cl",
        "uco.cl",
        // Agrega más dominios aquí según consideres empresas legítimas
    );

    $emailParts = explode("@", $email);
    $domain = end($emailParts);
    if (!in_array($domain, $allowedDomains)) {
        echo "Error: El dominio del correo electrónico no es válido.";
        exit; // Salir del script si el dominio del correo electrónico no es válido
    }

    // Insertar los datos en la base de datos
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
