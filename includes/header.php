<?php
// Detectar si estamos en la raíz o en subcarpeta
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
                    
                    <button class="hamburger" id="hamburger">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <ul class="nav-menu" id="nav-menu">
                        <li><a href="<?php echo $ruta_raiz; ?>index.php">Inicio</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/servicios.php">Servicios</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/portfolio.php">Portfolio</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/blog.php">Blog</a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/contacto.php">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>