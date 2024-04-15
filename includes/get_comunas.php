<?php
require_once '../config/database.php';

if(isset($_GET['region_id'])) {
    $regionId = $_GET['region_id'];
    $sql = "SELECT id, nombre FROM comunas WHERE region_id = $regionId";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<option value=''>Seleccione una comuna</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
        }
    } else {
        echo "<option value=''>No hay comunas disponibles</option>";
    }
} else {
    echo "<option value=''>Seleccione una región válida</option>";
}
?>
