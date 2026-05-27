<?php
require_once 'Calculo/IntegradorNumerico.php';
use App\Calculo\IntegradorNumerico;

$resultadoJoules = null;
$resultadoKWh = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $integrador = new IntegradorNumerico(
            (float)$_POST['t_inicio'],
            (float)$_POST['t_fin'],
            (int)$_POST['precision'],
            $_POST['perfil']
        );
        $resultadoJoules = $integrador->calcularEnergiaTotal();
        $resultadoKWh = $integrador->calcularEnergiaKWh();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cloud Energy Monitor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Monitor de Energía (DataCenter)</h1>
        
        <form method="POST">
            <div class="form-group">
                <label>Perfil de Consumo:</label>
                <select name="perfil" required>
                    <option value="IDLE">IDLE (Inactivo)</option>
                    <option value="AVERAGE">AVERAGE (Promedio)</option>
                    <option value="STRESS" selected>STRESS (Carga Máxima)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tiempo Inicial (s): </label>
                <input type="number" name="t_inicio" step="0.1" value="0" required>
            </div>
            
            <div class="form-group">
                <label>Tiempo Final (s): </label>
                <input type="number" name="t_fin" step="0.1" value="10" required>
            </div>
            
            <div class="form-group">
                <label>Precisión (n subintervalos): </label>
                <input type="number" name="precision" value="1000" required>
            </div>
            
            <button type="submit">Calcular Consumo</button>
        </form>

        <?php if ($resultadoJoules !== null): ?>
            <div class="result">
                <h3>Resultados:</h3>
                <p><strong>Consumo en Joules:</strong> <?php echo number_format($resultadoJoules, 4); ?> J</p>
                <p><strong>Consumo en kWh:</strong> <?php echo number_format($resultadoKWh, 10); ?> kWh</p>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"> Error: <?php echo $error; ?></div>
        <?php endif; ?>

        <hr>

        <h2>Análisis de Precisión (Perfil STRESS en [0, 10])</h2>
        <p>Valor real exacto: <strong>433.33 Joules</strong></p>
        <table>
            <thead>
                <tr>
                    <th>Subintervalos ($n$)</th>
                    <th>Aproximación Numérica (Trapecio)</th>
                    <th>Diferencia vs Real</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>$n=10$</td>
                    <td>435.0000 J</td>
                    <td>+1.6667 J</td>
                </tr>
                <tr>
                    <td>$n=100$</td>
                    <td>433.3500 J</td>
                    <td>+0.0167 J</td>
                </tr>
                <tr>
                    <td>$n=1000$</td>
                    <td>433.3335 J</td>
                    <td>+0.0002 J</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>