<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuesta";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir el ID del participante (supón que el ID se pasa como parámetro GET)
$id_participante = $_GET['id_participante'];

// Buscar los datos del participante
$sql_participante = "SELECT * FROM participantes WHERE id_participante = ?";
$stmt1 = $conn->prepare($sql_participante);
$stmt1->bind_param("i", $id_participante);
$stmt1->execute();
$result1 = $stmt1->get_result();

// Verifica si existe el participante
if ($result1->num_rows > 0) {
    $participante = $result1->fetch_assoc();
    
    // Buscar las respuestas del participante
    $sql_respuestas = "SELECT * FROM respuestas WHERE id_participante = ?";
    $stmt2 = $conn->prepare($sql_respuestas);
    $stmt2->bind_param("i", $id_participante);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    // Verifica si existen respuestas
    if ($result2->num_rows > 0) {
        $respuestas = $result2->fetch_assoc();
    }
} else {
    echo "No se encontró el participante con ese ID.";
    exit;
}

$stmt1->close();
$stmt2->close();
$conn->close();
?>

<!-- Formulario para modificar los datos -->
<form action="confirmar_modificacion.php" method="POST">
    <h3>Modificar Participante y Respuestas</h3>

    <input type="hidden" name="id_participante" value="<?php echo $participante['id_participante']; ?>">

    <!-- Datos del participante -->
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $participante['nombre']; ?>" required><br>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" value="<?php echo $participante['apellido']; ?>" required><br>

    <label for="edad">Edad:</label>
    <input type="number" name="edad" value="<?php echo $participante['edad']; ?>" required><br>

    <!-- Respuestas del participante -->
    <label for="frec_herram">Frecuencia Herramientas:</label>
    <input type="text" name="frec_herram" value="<?php echo $respuestas['frec_herram']; ?>" required><br>

    <label for="funcion">Función:</label>
    <input type="text" name="funcion" value="<?php echo $respuestas['funcion']; ?>" required><br>

    <label for="tarea">Tarea:</label>
    <input type="text" name="tarea" value="<?php echo $respuestas['tarea']; ?>" required><br>

    <label for="version">Versión:</label>
    <input type="text" name="version" value="<?php echo $respuestas['version']; ?>" required><br>

    <input type="submit" value="Modificar Registro">
</form>
