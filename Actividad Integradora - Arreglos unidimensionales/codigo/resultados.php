<?php
/*
 * Descripción: Recupera los datos calculados en procesar.php desde la sesión
 *              y los presenta en una tabla HTML clara y ordenada.
 */

// ── 1. Iniciar sesión y recuperar datos ──────────────────────────────────────
session_start();

// Si no existe la sesión con inventario, redirigir al formulario
if (empty($_SESSION['inventario'])) {
    header('Location: index.php');
    exit;
}

// Extraer variables de la sesión para mayor legibilidad
$datos              = $_SESSION['inventario'];
$productos          = $datos['productos'];
$precios            = $datos['precios'];
$total              = $datos['total'];
$promedio           = $datos['promedio'];
$precio_max         = $datos['precio_max'];
$precio_min         = $datos['precio_min'];
$producto_mas_caro  = $datos['producto_mas_caro'];
$producto_mas_barato= $datos['producto_mas_barato'];
$cantidad           = $datos['cantidad'];

// Limpiar sesión después de leer (buena práctica: evitar datos obsoletos)
unset($_SESSION['inventario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TiendaPHP – Resultados del Inventario</title>
  <style>
    /* ── Variables de tema ── */
    :root {
      --bg:      #0f1117;
      --surface: #1a1d27;
      --surface2:#21263a;
      --border:  #2e3247;
      --accent:  #4f8ef7;
      --accent2: #a78bfa;
      --success: #34d399;
      --warning: #fbbf24;
      --danger:  #f87171;
      --text:    #e8eaf6;
      --muted:   #8b92b8;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 16px;
      gap: 28px;
    }

    /* ── Encabezado ── */
    header { text-align: center; }
    header h1 {
      font-size: 2rem;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    header p { color: var(--muted); font-size: .9rem; margin-top: 4px; }

    /* ── Contenedor principal ── */
    .container { width: 100%; max-width: 800px; display: flex; flex-direction: column; gap: 24px; }

    /* ── Sección genérica ── */
    .card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
    }

    .card-header {
      padding: 14px 24px;
      border-bottom: 1px solid var(--border);
      font-size: .8rem;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--accent);
      font-weight: 700;
    }

    /* ── Tabla de productos ── */
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead th {
      background: var(--surface2);
      padding: 12px 20px;
      text-align: left;
      font-size: .78rem;
      letter-spacing: .07em;
      text-transform: uppercase;
      color: var(--muted);
    }
    tbody tr {
      border-top: 1px solid var(--border);
      transition: background .15s;
    }
    tbody tr:hover { background: var(--surface2); }
    td {
      padding: 13px 20px;
      font-size: .95rem;
    }
    td.price { font-variant-numeric: tabular-nums; font-weight: 600; color: var(--success); }
    td.idx   { color: var(--muted); font-size: .8rem; }

    /* ── Insignias de máximo/mínimo ── */
    .badge {
      display: inline-block;
      font-size: .7rem;
      padding: 2px 8px;
      border-radius: 20px;
      font-weight: 700;
      margin-left: 8px;
      vertical-align: middle;
    }
    .badge-max { background: rgba(251,191,36,.15); color: var(--warning); }
    .badge-min { background: rgba(248,113,113,.15); color: var(--danger); }

    /* ── Tarjetas de estadísticas ── */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 16px;
      padding: 20px 24px;
    }
    .stat-card {
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .stat-label {
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .07em;
      color: var(--muted);
    }
    .stat-value {
      font-size: 1.35rem;
      font-weight: 700;
      font-variant-numeric: tabular-nums;
    }
    .stat-sub  { font-size: .78rem; color: var(--muted); }
    .color-total   { color: var(--accent); }
    .color-avg     { color: var(--accent2); }
    .color-max     { color: var(--warning); }
    .color-min     { color: var(--danger); }

    /* ── Botón volver ── */
    .btn-back {
      display: inline-block;
      padding: 12px 32px;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      color: #fff;
      font-weight: 700;
      text-decoration: none;
      font-size: .95rem;
      transition: opacity .2s, transform .15s;
    }
    .btn-back:hover { opacity: .85; transform: translateY(-1px); }

    footer { color: var(--muted); font-size: .78rem; text-align: center; }
  </style>
</head>
<body>

<header>
  <h1> Resultados del Inventario</h1>
  <p>TiendaPHP · <?= $cantidad ?> productos registrados</p>
</header>

<div class="container">

  <!-- ════════════════════════════════════════════
       SECCIÓN 1: Tabla de productos
  ═════════════════════════════════════════════ -->
  <div class="card">
    <div class="card-header">Lista de productos</div>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Producto</th>
          <th>Precio unitario</th>
        </tr>
      </thead>
      <tbody>
        <?php
        /*
         * Recorremos los arreglos paralelos $productos y $precios
         * usando el índice $i para acceder a ambos en sincronía.
         */
        for ($i = 0; $i < $cantidad; $i++):
            $nombre = $productos[$i];
            $precio = $precios[$i];

            // Determinar si es el más caro o el más barato
            $esCaro   = ($precio === $precio_max && $nombre === $producto_mas_caro);
            $esBarato = ($precio === $precio_min && $nombre === $producto_mas_barato);
        ?>
        <tr>
          <td class="idx"><?= $i + 1 ?></td>
          <td>
            <?= htmlspecialchars($nombre) ?>
            <?php if ($esCaro):   ?><span class="badge badge-max">Más caro</span><?php endif; ?>
            <?php if ($esBarato): ?><span class="badge badge-min">Más barato</span><?php endif; ?>
          </td>
          <td class="price">$<?= number_format($precio, 2) ?></td>
        </tr>
        <?php endfor; ?>
      </tbody>
    </table>
  </div>

  <!-- ════════════════════════════════════════════
       SECCIÓN 2: Estadísticas calculadas
  ═════════════════════════════════════════════ -->
  <div class="card">
    <div class="card-header">Estadísticas calculadas</div>
    <div class="stats-grid">

      <!-- Total (array_sum) -->
      <div class="stat-card">
        <span class="stat-label">Total inventario</span>
        <span class="stat-value color-total">$<?= number_format($total, 2) ?></span>
        <span class="stat-sub">array_sum($precios)</span>
      </div>

      <!-- Promedio -->
      <div class="stat-card">
        <span class="stat-label">Precio promedio</span>
        <span class="stat-value color-avg">$<?= number_format($promedio, 2) ?></span>
        <span class="stat-sub">total ÷ <?= $cantidad ?> productos</span>
      </div>

      <!-- Más caro (max) -->
      <div class="stat-card">
        <span class="stat-label">Producto más caro</span>
        <span class="stat-value color-max">$<?= number_format($precio_max, 2) ?></span>
        <span class="stat-sub"><?= htmlspecialchars($producto_mas_caro) ?></span>
      </div>

      <!-- Más barato (min) -->
      <div class="stat-card">
        <span class="stat-label">Producto más barato</span>
        <span class="stat-value color-min">$<?= number_format($precio_min, 2) ?></span>
        <span class="stat-sub"><?= htmlspecialchars($producto_mas_barato) ?></span>
      </div>

    </div>
  </div>

</div><!-- /.container -->

<a href="index.php" class="btn-back">← Registrar nuevo inventario</a>

<footer>Programación Orientada a Objetos · Ingeniería Informática</footer>

</body>
</html>