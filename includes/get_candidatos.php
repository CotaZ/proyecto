<?php
require_once '../config/database.php';

if(isset($_GET['comuna_id'])) {
    $comunaId = $_GET['comuna_id'];
    $sql = "SELECT id, nombre FROM candidatos WHERE comuna_id = $comunaId";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<option value=''>Seleccione un candidato</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
        }
    } else {
        echo "<option value=''>No hay candidatos disponibles</option>";
    }
} else {
    echo "<option value=''>Seleccione una comuna válida</option>";
}
?>
