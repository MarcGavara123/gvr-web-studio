<?php
// Gestor de idiomas

// Idiomas disponibles
$idiomas_disponibles = ['es', 'en'];
$idioma_por_defecto = 'es';

// Detectar idioma desde GET o sesión
$idioma = isset($_GET['lang']) ? $_GET['lang'] : '';

if ($idioma && in_array($idioma, $idiomas_disponibles)) {
    $_SESSION['lang'] = $idioma;
    $idioma_actual = $idioma;
} elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $idiomas_disponibles)) {
    $idioma_actual = $_SESSION['lang'];
} else {
    // Detectar idioma del navegador
    $idioma_navegador = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $idioma_actual = in_array($idioma_navegador, $idiomas_disponibles) ? $idioma_navegador : $idioma_por_defecto;
}

// Cargar archivo de idioma
$lang_file = __DIR__ . '/../lang/' . $idioma_actual . '.php';
if (file_exists($lang_file)) {
    include $lang_file;
} else {
    include __DIR__ . '/../lang/es.php';
}

// Función para obtener texto traducido
function __($key) {
    global $lang;
    return isset($lang[$key]) ? $lang[$key] : $key;
}

// Función para cambiar idioma manteniendo la página actual
function url_idioma($idioma) {
    $url = $_SERVER['PHP_SELF'];
    $query = $_GET;
    $query['lang'] = $idioma;
    return $url . '?' . http_build_query($query);
}
?>