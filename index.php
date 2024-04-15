<?php
// Incluir archivo de conexión a la base de datos
require_once 'config/database.php';

// Obtener las regiones
$regiones = obtenerRegiones($conn);

// Obtener las comunas
$comunas = obtenerComunas($conn);

// Obtener los candidatos
$candidatos = obtenerCandidatos($conn);

function obtenerRegiones($conn) {
    $sql = "SELECT id, nombre FROM regiones";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result;
    } else {
        // Manejar error de consulta
        return null;
    }
}

function obtenerComunas($conn) {
    $sql = "SELECT c.id, c.nombre, r.id AS region_id, r.nombre AS region_nombre FROM comunas c JOIN regiones r ON c.region_id = r.id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result;
    } else {
        // Manejar error de consulta
        return null;
    }
}

function obtenerCandidatos($conn) {
    $sql = "SELECT ca.id, ca.nombre, c.id AS comuna_id, c.nombre AS comuna_nombre, r.id AS region_id, r.nombre AS region_nombre FROM candidatos ca JOIN comunas c ON ca.comuna_id = c.id JOIN regiones r ON c.region_id = r.id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result;
    } else {
        // Manejar error de consulta
        return null;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Votación</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body>
    <h1>Formulario de Votación</h1>
    <form id="voteForm">
        <label for="name">Nombre y Apellido:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="alias">Alias:</label>
        <input type="text" id="alias" name="alias" required>
        <br>
        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="region">Región:</label>
        <select id="region" name="region" required>
            <option value="">Seleccione una región</option>
            <?php 
            if ($regiones) {
                while ($region = $regiones->fetch_assoc()): ?>
                    <option value="<?php echo $region['id']; ?>"><?php echo $region['nombre']; ?></option>
                <?php endwhile;
            } ?>
        </select>
        <br>
        <label for="comuna">Comuna:</label>
        <select id="comuna" name="comuna" required>
            <option value="">Seleccione una comuna</option>
            <?php 
            if ($comunas) {
                while ($comuna = $comunas->fetch_assoc()): ?>
                    <option value="<?php echo $comuna['id']; ?>" data-region="<?php echo $comuna['region_id']; ?>"><?php echo $comuna['nombre']; ?> (<?php echo $comuna['region_nombre']; ?>)</option>
                <?php endwhile;
            } ?>
        </select>
        <br>
        <label for="candidato">Candidato:</label>
        <select id="candidato" name="candidato" required>
            <option value="">Seleccione un candidato</option>
            <?php 
            if ($candidatos) {
                while ($candidato = $candidatos->fetch_assoc()): ?>
                    <option value="<?php echo $candidato['id']; ?>" data-comuna="<?php echo $candidato['comuna_id']; ?>" data-region="<?php echo $candidato['region_id']; ?>"><?php echo $candidato['nombre']; ?> (<?php echo $candidato['comuna_nombre']; ?>, <?php echo $candidato['region_nombre']; ?>)</option>
                <?php endwhile;
            } ?>
        </select>
        <br>
        <label>¿Cómo se enteró de Nosotros?</label>
        <br>
        <input type="checkbox" id="web" name="source[]" value="Web">
        <label for="web">Web</label>
        <input type="checkbox" id="tv" name="source[]" value="TV">
        <label for="tv">TV</label>
        <input type="checkbox" id="redes_sociales" name="source[]" value="Redes Sociales">
        <label for="redes_sociales">Redes Sociales</label>
        <input type="checkbox" id="amigo" name="source[]" value="Amigo">
        <label for="amigo">Amigo</label>
        <br>
        <input type="submit" value="Votar">
    </form>
    <div id="result"></div>
    <script>
    $(document).ready(function() {
        $("#voteForm").submit(function(event) {
            event.preventDefault(); // Evita el envío del formulario por defecto

            const rut = $("#rut").val();
            console.log("RUT ingresado:", rut);

            if (!validateRutChileno(rut)) {
                alert("El RUT ingresado no es válido.");
                return; // Detiene el envío del formulario si el RUT no es válido
            }

            // Si el RUT es válido, continuar con el envío del formulario
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "includes/submit_vote.php",
                data: formData,
                success: function(response) {
                    $("#result").html(response);
                }
            });
        });
    });
</script>

</body>
</html>
