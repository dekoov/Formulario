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

    // Consulta SQL para obtener los datos del participante
    $sql = "SELECT * FROM participantes WHERE id_participante = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_participante); 
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el participante existe
    if ($result->num_rows > 0) {
        $participante = $result->fetch_assoc();

        echo "<h2>¿Estás seguro de que deseas eliminar este participante?</h2>";
        echo "<p><strong>Nombre:</strong> " . htmlspecialchars($participante['nombre']) . "</p>";
        echo "<p><strong>Apellido:</strong> " . htmlspecialchars($participante['apellido']) . "</p>";
        echo "<p><strong>Edad:</strong> " . htmlspecialchars($participante['edad']) . "</p>";

        echo "<form method='POST' action='eliminar_participante.php'>
                <input type='hidden' name='id_participante' value='" . $id_participante . "' />
                <input type='submit' name='confirmar' value='Eliminar' />
                <a href='index.php'>Cancelar</a>
              </form>";

    } else {
        echo "<p>No se encontró el participante con el ID proporcionado.</p>";
    }

    $stmt->close();

} elseif (isset($_POST['confirmar'])) {
    // Si se ha confirmado la eliminación
    if (isset($_POST['id_participante'])) {
        $id_participante = $_POST['id_participante'];

        // Eliminar primero las respuestas del participante
        $sql_respuestas = "DELETE FROM respuestas WHERE id_participante = ?";
        $stmt_respuestas = $conn->prepare($sql_respuestas);
        $stmt_respuestas->bind_param("i", $id_participante);
        $stmt_respuestas->execute();
        $stmt_respuestas->close();

        // Luego eliminar el participante
        $sql_participante = "DELETE FROM participantes WHERE id_participante = ?";
        $stmt_participante = $conn->prepare($sql_participante);
        $stmt_participante->bind_param("i", $id_participante);
        $stmt_participante->execute();
        $stmt_participante->close();

        echo "<p>El participante y sus respuestas han sido eliminados correctamente.</p>";
        echo "<a href='index.html'>Volver al inicio</a>";
    }

} else {
    echo "<p>Por favor, proporciona un ID de participante para eliminar.</p>";
}

$conn->close();
?>
