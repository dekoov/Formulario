<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Confirmar Información</title>
</head>
<body>
    <main class="main-container">
        <header>
            <h1>Confirmar Información</h1>
            <p>Por favor, revisa la información proporcionada. Si es correcta, haz clic en "Confirmar".</p>
        </header>
        <form method="POST" action="procesar_formulario.php">
            <fieldset>
                <legend>Datos proporcionados</legend>
                <div class="pregunta">
                    <label>Nombre:</label>
                    <p><?= htmlspecialchars($_POST['nombre']) ?></p>
                    <input type="hidden" name="nombre" value="<?= htmlspecialchars($_POST['nombre']) ?>">

                    <label>Apellido:</label>
                    <p><?= htmlspecialchars($_POST['apellido']) ?></p>
                    <input type="hidden" name="apellido" value="<?= htmlspecialchars($_POST['apellido']) ?>">
                </div>
                <div class="pregunta">
                    <label>Rango de edad:</label>
                    <p><?= htmlspecialchars($_POST['edad']) ?></p>
                    <input type="hidden" name="edad" value="<?= htmlspecialchars($_POST['edad']) ?>">
                </div>
                <div class="pregunta">
                    <label>Frecuencia de uso de herramientas:</label>
                    <p><?= htmlspecialchars($_POST['frec_herram']) ?></p>
                    <input type="hidden" name="frec_herram" value="<?= htmlspecialchars($_POST['frec_herram']) ?>">
                </div>
                <div class="pregunta">
                    <label>Funcionalidades valoradas:</label>
                    <ul>
                        <?php foreach ($_POST['funcion'] as $funcion): ?>
                            <li><?= htmlspecialchars($funcion) ?></li>
                            <input type="hidden" name="funcion[]" value="<?= htmlspecialchars($funcion) ?>">
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="pregunta">
                    <label>Tipo de tareas a monitorear:</label>
                    <p><?= htmlspecialchars($_POST['tarea']) ?></p>
                    <input type="hidden" name="tarea" value="<?= htmlspecialchars($_POST['tarea']) ?>">
                </div>
                <div class="pregunta">
                    <label>Disposición a pagar versión premium:</label>
                    <p><?= htmlspecialchars($_POST['version']) ?></p>
                    <input type="hidden" name="version" value="<?= htmlspecialchars($_POST['version']) ?>">
                </div>
            </fieldset>
            <div class="botones">
                <button class="boton-enviar" type="button" onclick="history.back()">Editar</button>
                <input class="boton-enviar" type="submit" value="Confirmar">
            </div>
        </form>
    </main>
</body>
</html>
