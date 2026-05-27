<?php
/*
 * Descripción: Recibe los datos enviados desde index.php (método POST),
 *              los almacena en dos arreglos paralelos ($productos y $precios),
 *              realiza los cálculos estadísticos requeridos y
 *              guarda todo en variables de sesión para pasarlos a resultados.php.
 */

// ── 1. Iniciar sesión para poder compartir datos entre páginas ──────────────
session_start();

// ── 2. Validación de servidor: verificar que los datos llegan por POST ───────
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || empty($_POST['nombre'])
    || empty($_POST['precio'])) {

    // Si alguien intenta acceder directamente, lo redirigimos al formulario
    header('Location: index.php');
    exit;
}

// ── 3. Recuperar los arreglos enviados por el formulario ─────────────────────
/*
 * Como el formulario usa name="nombre[]" y name="precio[]",
 * PHP los recibe automáticamente como arreglos indexados.
 */
$nombres_raw = $_POST['nombre']; // arreglo con los nombres (strings)
$precios_raw = $_POST['precio']; // arreglo con los precios  (strings numéricas)

// ── 4. Inicializar los arreglos paralelos de trabajo ────────────────────────
$productos = []; // almacenará los nombres saneados
$precios   = []; // almacenará los precios como floats válidos

// ── 5. Recorrer, sanear y poblar los arreglos ────────────────────────────────
/*
 * Iteramos con array_keys() para garantizar que usamos los índices
 * originales; así ambos arreglos siempre están sincronizados (paralelos).
 */
foreach (array_keys($nombres_raw) as $i) {

    // Sanear el nombre: eliminar espacios extra y caracteres peligrosos
    $nombre = trim(htmlspecialchars($nombres_raw[$i], ENT_QUOTES, 'UTF-8'));

    // Convertir el precio a float y verificar que sea un número positivo
    $precio = floatval($precios_raw[$i]);

    // Solo agregamos la fila si ambos campos son válidos
    if ($nombre !== '' && $precio > 0) {
        $productos[] = $nombre; // agregar al arreglo de nombres
        $precios[]   = $precio; // agregar al arreglo de precios
    }
}

// ── 6. Segunda validación: asegurarnos de tener al menos 1 producto válido ──
if (empty($productos)) {
    header('Location: index.php?error=datos_invalidos');
    exit;
}

// ── 7. Cálculos estadísticos ─────────────────────────────────────────────────

/*
 * array_sum($precios)
 * Suma todos los elementos del arreglo en una sola instrucción.
 * Es más eficiente y legible que un bucle for manual.
 */
$total = array_sum($precios);

/*
 * Promedio: total dividido entre la cantidad de productos.
 * count() devuelve el número de elementos del arreglo.
 */
$cantidad = count($precios);
$promedio = $total / $cantidad;

/*
 * max($precios) → devuelve el valor máximo del arreglo.
 * min($precios) → devuelve el valor mínimo del arreglo.
 */
$precio_max = max($precios);
$precio_min = min($precios);

/*
 * array_search() busca el primer índice cuyo valor coincida.
 * Así obtenemos el nombre del producto más caro y el más barato
 * usando el índice encontrado en el arreglo $productos (paralelo).
 */
$idx_max = array_search($precio_max, $precios);
$idx_min = array_search($precio_min, $precios);

$producto_mas_caro   = $productos[$idx_max];
$producto_mas_barato = $productos[$idx_min];

// ── 8. Guardar resultados en sesión para usarlos en resultados.php ───────────
$_SESSION['inventario'] = [
    'productos'           => $productos,
    'precios'             => $precios,
    'total'               => $total,
    'promedio'            => $promedio,
    'precio_max'          => $precio_max,
    'precio_min'          => $precio_min,
    'producto_mas_caro'   => $producto_mas_caro,
    'producto_mas_barato' => $producto_mas_barato,
    'cantidad'            => $cantidad,
];

// ── 9. Redirigir a la página de resultados ───────────────────────────────────
header('Location: resultados.php');
exit;