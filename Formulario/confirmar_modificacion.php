<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuesta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$id_participante = $_POST['id_participante'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$frec_herram = $_POST['frec_herram'];
$funcion = $_POST['funcion'];  // Si es un array de checkboxes, usar implode() si es necesario
$tarea = $_POST['tarea'];
$version = $_POST['version'];

// Inicia una transacción
$conn->begin_transaction();

try {
    // Actualizar datos del participante
    $sql_participantes = "UPDATE participantes SET nombre = ?, apellido = ?, edad = ? WHERE id_participante = ?";
    $stmt1 = $conn->prepare($sql_participantes);
    $stmt1->bind_param("sssi", $nombre, $apellido, $edad, $id_participante);
    $stmt1->execute();

    // Actualizar respuestas del participante
    $sql_respuestas = "UPDATE respuestas SET frec_herram = ?, funcion = ?, tarea = ?, version = ? WHERE id_participante = ?";
    $stmt2 = $conn->prepare($sql_respuestas);
    $stmt2->bind_param("ssssi", $frec_herram, $funcion, $tarea, $version, $id_participante);
    $stmt2->execute();

    // Confirma la transacción
    $conn->commit();

    echo "Datos insertados correctamente. Redirigiendo...";
    echo "<meta http-equiv='refresh' content='3;url=index.html'>";
} catch (Exception $e) {
    // Revertir cambios en caso de error
    $conn->rollback();
    echo "Error al modificar los datos: " . $e->getMessage();
}

// Cierra las conexiones
$stmt1->close();
$stmt2->close();
$conn->close();
?>
