<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuesta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los registros
$sql = "
    SELECT p.id_participante, p.nombre, p.apellido, p.edad, r.frec_herram, r.funcion, r.tarea, r.version 
    FROM participantes AS p
    LEFT JOIN respuestas AS r ON p.id_participante = r.id_participante";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<h2>Lista de Participantes y Respuestas</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID Participante</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Frecuencia de Uso</th>
                <th>Funcionalidades</th>
                <th>Tipo de Tareas</th>
                <th>Interés en Versión Premium</th>
            </tr>";

    // Recorrer los resultados y mostrarlos en una tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id_participante']) . "</td>
                <td>" . htmlspecialchars($row['nombre']) . "</td>
                <td>" . htmlspecialchars($row['apellido']) . "</td>
                <td>" . htmlspecialchars($row['edad']) . "</td>
                <td>" . htmlspecialchars($row['frec_herram']) . "</td>
                <td>" . htmlspecialchars($row['funcion']) . "</td>
                <td>" . htmlspecialchars($row['tarea']) . "</td>
                <td>" . htmlspecialchars($row['version']) . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No se encontraron registros.</p>";
}

$conn->close();
?>
