<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuesta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$frec_herram = $_POST['frec_herram'];
$funcion = implode(", ", $_POST['funcion']); 
$tarea = $_POST['tarea'];
$version = $_POST['version'];

$conn->begin_transaction();

try {
    // Insertar datos en la tabla participantes
    $sql_participantes = "INSERT INTO participantes (nombre, apellido, edad) VALUES (?, ?, ?)";
    $stmt1 = $conn->prepare($sql_participantes);
    $stmt1->bind_param("sss", $nombre, $apellido, $edad);
    $stmt1->execute();
    
    // Obtiene el ID del participante recién insertado
    $id_participante = $conn->insert_id;

    // Insertar datos en la tabla respuestas
    $sql_respuestas = "INSERT INTO respuestas (id_participante, frec_herram, funcion, tarea, version) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql_respuestas);
    $stmt2->bind_param("issss", $id_participante, $frec_herram, $funcion, $tarea, $version);
    $stmt2->execute();

    $conn->commit();

    echo "Datos insertados correctamente. Redirigiendo...";
    echo "<meta http-equiv='refresh' content='3;url=index.html'>";
} catch (Exception $e) {
    // Revertir cambios en caso de error
    $conn->rollback();
    echo "Error al insertar los datos: " . $e->getMessage();
}

$stmt1->close();
$stmt2->close();
$conn->close();
?>