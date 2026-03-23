<?php
require_once 'includes/config.php';

$sql = "SELECT * FROM servicios WHERE activo = 1 ORDER BY orden";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Servicios de GVR Web Studio</h1>";
    while($row = $result->fetch_assoc()) {
        echo "<h2>" . $row['titulo'] . "</h2>";
        echo "<p>" . $row['descripcion'] . "</p>";
        echo "<hr>";
    }
} else {
    echo "No hay servicios disponibles";
}
?>