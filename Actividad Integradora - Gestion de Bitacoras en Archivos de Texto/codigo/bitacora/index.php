<?php
// inicializamos las variables para mensajes
$mensaje = "";
$tipo_mensaje = "";
$archivo = "bitacora.txt";

//1. Procesamos el formulario al enviar (Validacion y Escritura)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = trim($_POST["descripcion"]);
    $responsable = trim($_POST["responsable"]);
    $fecha = trim($_POST["fecha"]);

    // validamos que no se agreguen campos vacios
    if (empty($descripcion) || empty($responsable) || empty($fecha)) {
        $mensaje = "Error: Todos los campos son obligatorios.";
        $tipo_mensaje = "error";
    } else {
        // sanitizar entradas para evitar inyeccion de codigo
        $descripcion = htmlspecialchars($descripcion);
        $responsable = htmlspecialchars($responsable);

        // formato requerido para guardar
        $registro = "Fecha: " . $fecha . "\n";
        $registro .= "Actividad: " . $descripcion . "\n";
        $registro .= "Responsable: " . $responsable . "\n";
        $registro .= "-----------------------------\n";

        // creamos o abrimos en modo append
        if  (file_put_contents($archivo, $registro, FILE_APPEND | LOCK_EX)) {
            $mensaje = "Registro agregado exitosamente.";
            $tipo_mensaje = "exito";
        } else {
            $mensaje = "Error: No se pudo escribir en el archivo.";
            $tipo_mensaje = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion De Bitacoras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .formulario, .bitacora { margin-bottom: 30px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .error { color: red; font-weight: bold; }
        .exito { color: green; font-weight: bold; }
        label { display: block; margin-top: 10px; }
        input[type="text"], input[type="date"] { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 15px; cursor: pointer; }
        pre { background: #f4f4f4; padding: 15px; border: 1px solid #ddd; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Registro de Actividades Diarias</h1>
    
    <?php if (!empty($mensaje)): ?>
        <p class="<?php echo $tipo_mensaje; ?>"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <div class="formulario">
        <form method="POST" action="">
            <label for="descripcion">Descripcion de la actividad:</label>
            <input type="text" id="descripcion" name="descripcion" required>

            <label for="responsable">Responsable:</label>
            <input type="text" id="responsable" name="responsable" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <button type="submit">Registrar Actividad</button>
        </form>
    </div>

    <div class="bitacora">
        <h2>Bitacora de Registrada</h2>
        <?php
        [cite_start] //2. Leemos el archivo para mostrar la bitacora
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            // mostrar dentro de un <pre> para mantener formato, y usar htmlspecialchars para evitar inyeccion de codigo
            echo "<pre>" . htmlspecialchars($contenido) . "</pre>";
        } else {
            echo "<p>La bitacora está vacía. Registra la primera actividad.</p>";
        }
        ?>
    </div>
</body>
</html>