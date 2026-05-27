<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TiendaPHP – Registro de Inventario</title>
  <style>
    /* ── Variables de color ── */
    :root {
      --bg:      #0f1117;
      --surface: #1a1d27;
      --border:  #2e3247;
      --accent:  #4f8ef7;
      --accent2: #a78bfa;
      --text:    #e8eaf6;
      --muted:   #8b92b8;
      --danger:  #f87171;
      --success: #34d399;
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
    }

    /* ── Encabezado ── */
    header {
      text-align: center;
      margin-bottom: 36px;
    }
    header h1 {
      font-size: 2rem;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 6px;
    }
    header p { color: var(--muted); font-size: .95rem; }

    /* ── Tarjeta del formulario ── */
    .card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 36px 40px;
      width: 100%;
      max-width: 680px;
      box-shadow: 0 8px 40px rgba(0,0,0,.45);
    }

    .card h2 {
      font-size: 1.1rem;
      color: var(--accent);
      margin-bottom: 24px;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    /* ── Fila de producto ── */
    .product-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 18px;
      align-items: start;
    }

    .field-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    label {
      font-size: .8rem;
      color: var(--muted);
      letter-spacing: .06em;
      text-transform: uppercase;
    }

    input[type="text"],
    input[type="number"] {
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 8px;
      color: var(--text);
      padding: 10px 14px;
      font-size: .95rem;
      transition: border-color .2s;
      width: 100%;
    }
    input:focus {
      outline: none;
      border-color: var(--accent);
    }
    input:invalid:not(:placeholder-shown) {
      border-color: var(--danger);
    }

    .row-number {
      font-size: .75rem;
      color: var(--accent2);
      font-weight: 700;
      margin-bottom: 6px;
    }

    .divider {
      border: none;
      border-top: 1px solid var(--border);
      margin: 8px 0 20px;
    }

    /* ── Boton de envío ── */
    .btn-submit {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      color: #fff;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: .05em;
      cursor: pointer;
      transition: opacity .2s, transform .15s;
      margin-top: 8px;
    }
    .btn-submit:hover { opacity: .88; transform: translateY(-1px); }
    .btn-submit:active { transform: translateY(0); }

    footer {
      margin-top: 28px;
      color: var(--muted);
      font-size: .78rem;
      text-align: center;
    }
  </style>
</head>
<body>

<header>
  <h1> TiendaPHP</h1>
  <p>Módulo de Gestión de Inventario · Actividad Integradora POO</p>
</header>

<!--
  El formulario envía los datos mediante POST hacia procesar.php.
  La validación básica se realiza con los atributos HTML5:
    required → campo obligatorio
    min      → precio mínimo permitido ($0.01)
    step     → acepta decimales
-->
<div class="card">
  <h2>Registro de productos</h2>

  <form action="procesar.php" method="POST">

    <?php
    /*
     * Generamos dinámicamente 5 filas de productos
     * usando un bucle for, así el código no se repite.
     */
    for ($i = 1; $i <= 5; $i++):
    ?>

    <div class="row-number">Producto <?= $i ?></div>

    <div class="product-row">

      <!-- Campo: nombre del producto -->
      <div class="field-group">
        <label for="nombre_<?= $i ?>">Nombre</label>
        <input
          type="text"
          id="nombre_<?= $i ?>"
          name="nombre[]"
          placeholder="Escribe un producto"
          required
          maxlength="60"
        />
      </div>

      <!-- Campo: precio del producto -->
      <div class="field-group">
        <label for="precio_<?= $i ?>">Precio ($)</label>
        <input
          type="number"
          id="precio_<?= $i ?>"
          name="precio[]"
          placeholder="0.00"
          required
          min="0.01"
          step="0.01"
        />
      </div>

    </div><!-- /.product-row -->

    <?php if ($i < 5): ?>
      <hr class="divider" />
    <?php endif; ?>

    <?php endfor; ?>

    <button type="submit" class="btn-submit">
      ▶ Procesar inventario
    </button>

  </form>
</div>

<footer>
  Programación Orientada a Objetos · Ingeniería Informática
</footer>

</body>
</html>
