<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuesta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID del participante
if (isset($_GET['id_participante']) && !empty($_GET['id_participante'])) {
    $id_participante = $_GET['id_participante'];

    // Consulta SQL para obtener los datos del participante y sus respuestas
    $sql = "
        SELECT p.nombre, p.apellido, p.edad, r.frec_herram, r.funcion, r.tarea, r.version 
        FROM participantes AS p
        LEFT JOIN respuestas AS r ON p.id_participante = r.id_participante
        WHERE p.id_participante = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_participante); 
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el participante existe
    if ($result->num_rows > 0) {
        $participante = $result->fetch_assoc();

        echo "<h2>Datos del Participante</h2>";
        echo "<p><strong>Nombre:</strong> " . $participante['nombre'] . "</p>";
        echo "<p><strong>Apellido:</strong> " . $participante['apellido'] . "</p>";
        echo "<p><strong>Edad:</strong> " . $participante['edad'] . "</p>";

        echo "<h3>Respuestas de la Encuesta:</h3>";
        echo "<p><strong>Frecuencia de uso de herramientas:</strong> " . $participante['frec_herram'] . "</p>";
        echo "<p><strong>Funcionalidades valoradas:</strong> " . $participante['funcion'] . "</p>";
        echo "<p><strong>Tipo de tareas monitoreadas:</strong> " . $participante['tarea'] . "</p>";
        echo "<p><strong>Interés en versión premium:</strong> " . $participante['version'] . "</p>";
    } else {
        echo "<p>No se encontraron datos para el ID proporcionado.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Por favor ingresa un ID de participante.</p>";
}

$conn->close();
?>
