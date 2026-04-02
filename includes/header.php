<?php
require_once __DIR__ . '/lang.php';

$ruta_raiz = '';
if (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) {
    $ruta_raiz = '../';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'GVR Web Studio'; ?></title>
    
    <!-- CSS con ruta automática -->
    <link rel="stylesheet" href="<?php echo $ruta_raiz; ?>assets/css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-content">
                    <a href="<?php echo $ruta_raiz; ?>index.php" class="logo">
                        <span class="logo-text">GVR Web Studio</span>
                    </a>
             <!-- Selector de idioma -->
<div style="display: flex; align-items: center; gap: 0.5rem; margin-left: 1.5rem;">
    <a href="<?php echo url_idioma('es'); ?>" style="display: flex; align-items: center; gap: 0.3rem; text-decoration: none; padding: 0.3rem 0.5rem; border-radius: 8px; background: <?php echo $idioma_actual == 'es' ? '#6366f1' : 'transparent'; ?>; color: <?php echo $idioma_actual == 'es' ? 'white' : '#1f2937'; ?>; font-size: 0.9rem; font-weight: 500;">
        <img src="<?php echo $ruta_raiz; ?>assets/images/flags/es.png" alt="ES" style="width: 20px; height: 20px; border-radius: 2px;">
        <span>ES</span>
    </a>
    <span style="color: #e5e7eb;">|</span>
    <a href="<?php echo url_idioma('en'); ?>" style="display: flex; align-items: center; gap: 0.3rem; text-decoration: none; padding: 0.3rem 0.5rem; border-radius: 8px; background: <?php echo $idioma_actual == 'en' ? '#6366f1' : 'transparent'; ?>; color: <?php echo $idioma_actual == 'en' ? 'white' : '#1f2937'; ?>; font-size: 0.9rem; font-weight: 500;">
        <img src="<?php echo $ruta_raiz; ?>assets/images/flags/en.png" alt="EN" style="width: 20px; height: 20px; border-radius: 2px;">
        <span>EN</span>
    </a>
</div>
                    <button class="hamburger" id="hamburger">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <ul class="nav-menu" id="nav-menu">
                        <li><a href="<?php echo $ruta_raiz; ?>index.php">Inicio</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/servicios.php">Servicios</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/portfolio.php">Portfolio</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/blog.php">Blog</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/contacto.php">Contacto</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/sobre-nosotros.php">Sobre Nosotros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>