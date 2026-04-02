<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas

// Obtener el ID del artículo desde la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Actualizar visitas
$conn->query("UPDATE blog_posts SET visitas = visitas + 1 WHERE id = $id");

// Obtener el post completo
$sql = "SELECT * FROM blog_posts WHERE id = $id AND publicado = 1";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

// Si no existe el post, redirigir al blog
if(!$post) {
    header('Location: blog.php');
    exit;
}

$page_title = $post['titulo'] . ' - GVR Web Studio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-content">
                    <a href="../index.php" class="logo">
                        <span class="logo-text">GVR Web Studio</span>
                    </a>
                    <ul class="nav-menu">
                        <li><a href="../index.php"><?php echo __('nav_inicio'); ?></a></li>
                        <li><a href="servicios.php"><?php echo __('nav_servicios'); ?></a></li>
                        <li><a href="portfolio.php"><?php echo __('nav_portfolio'); ?></a></li>
                        <li><a href="blog.php"><?php echo __('nav_blog'); ?></a></li>
                        <li><a href="contacto.php"><?php echo __('nav_contacto'); ?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- TÍTULO DEL ARTÍCULO -->
        <section class="page-hero" style="padding: 120px 0 40px;">
            <div class="container">
                <h1><?php echo htmlspecialchars($post['titulo']); ?></h1>
                <div style="display: flex; gap: 2rem; justify-content: center; color: white; margin-top: 1rem;">
                    <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['fecha_publicacion'])); ?></span>
                    <span><i class="far fa-user"></i> <?php echo htmlspecialchars($post['autor']); ?></span>
                    <span><i class="far fa-folder"></i> <?php echo htmlspecialchars($post['categoria']); ?></span>
                </div>
            </div>
        </section>

        <!-- CONTENIDO DEL ARTÍCULO -->
        <section class="blog-post-content" style="padding: 60px 0;">
            <div class="container" style="max-width: 800px;">
                <!-- Imagen destacada -->
                <div style="margin-bottom: 2rem; border-radius: 16px; overflow: hidden;">
                    <img src="../assets/images/<?php echo $post['imagen_destacada']; ?>" 
                         alt="<?php echo htmlspecialchars($post['titulo']); ?>"
                         style="width: 100%; height: auto; display: block;">
                </div>
                
                <!-- Contenido del artículo -->
                <div style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    <?php echo $post['contenido']; ?>
                </div>
                
                <!-- Tags -->
                <?php if($post['tags']): 
                    $tags = json_decode($post['tags'], true);
                    if(is_array($tags) && !empty($tags)): ?>
                    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                        <h3 style="margin-bottom: 1rem;"><?php echo __('blog_detalle_etiquetas'); ?></h3>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <?php foreach($tags as $tag): ?>
                                <span style="background: #f3f4f6; color: #6b7280; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">#<?php echo htmlspecialchars($tag); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; endif; ?>
                
                <!-- Botón volver -->
                <div style="margin-top: 3rem; text-align: center;">
                    <a href="blog.php" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-arrow-left"></i> <?php echo __('blog_detalle_volver'); ?>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h3>GVR Web Studio</h3>
                    <p><?php echo __('footer_descripcion'); ?></p>
                </div>
                <div class="footer-links">
                    <h4><?php echo __('footer_enlaces'); ?></h4>
                    <ul>
                        <li><a href="../index.php"><?php echo __('nav_inicio'); ?></a></li>
                        <li><a href="servicios.php"><?php echo __('nav_servicios'); ?></a></li>
                        <li><a href="portfolio.php"><?php echo __('nav_portfolio'); ?></a></li>
                        <li><a href="blog.php"><?php echo __('nav_blog'); ?></a></li>
                        <li><a href="contacto.php"><?php echo __('nav_contacto'); ?></a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4><?php echo __('footer_contacto'); ?></h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> 693 37 63 77</li>
                        <li><i class="fas fa-envelope"></i> gvrwebstudio@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 GVR Web Studio. <?php echo __('footer_derechos'); ?></p>
            </div>
        </div>
    </footer>
</body>
</html>