<?php
require_once 'includes/config.php';
require_once 'includes/lang.php'; 

$sql_servicios = "SELECT * FROM servicios WHERE destacado = 1 AND activo = 1 ORDER BY orden LIMIT 6";
$result_servicios = $conn->query($sql_servicios);

$sql_portfolio = "SELECT * FROM portfolio WHERE destacado = 1 AND activo = 1 ORDER BY created_at DESC LIMIT 3";
$result_portfolio = $conn->query($sql_portfolio);

$sql_blog = "SELECT * FROM blog_posts WHERE publicado = 1 ORDER BY fecha_publicacion DESC LIMIT 3";
$result_blog = $conn->query($sql_blog);

$sql_count_servicios = "SELECT COUNT(*) as total FROM servicios WHERE activo = 1";
$result_count = $conn->query($sql_count_servicios);
$total_servicios = $result_count->fetch_assoc()['total'];

$sql_proyectos = "SELECT COUNT(*) as total FROM portfolio WHERE activo = 1";
$result_proyectos = $conn->query($sql_proyectos);
$total_proyectos = $result_proyectos->fetch_assoc()['total'];

$sql_clientes = "SELECT COUNT(DISTINCT cliente) as total FROM portfolio WHERE activo = 1";
$result_clientes = $conn->query($sql_clientes);
$total_clientes = $result_clientes->fetch_assoc()['total'];

$page_title = __('hero_title') . ' - GVR Web Studio';

include 'includes/header.php';
?>

<!-- SECCIÓN 1: HERO CON VIDEO A LA DERECHA -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo __('hero_title'); ?></h1>
            <p class="hero-subtitle"><?php echo __('hero_subtitle'); ?></p>
            <div class="hero-buttons">
                <a href="pages/contacto.php" class="btn btn-primary"><?php echo __('hero_btn_presupuesto'); ?></a>
                <a href="pages/portfolio.php" class="btn btn-secondary"><?php echo __('hero_btn_proyectos'); ?></a>
            </div>
        </div>

        <!-- VIDEO A LA DERECHA CON BORDE ESTÉTICO -->
        <div class="hero-image">
            <div class="video-frame" style="width: 100%; max-width: 1500px; position: relative; border-radius: 28px; overflow: hidden; box-shadow: 0 25px 40px -15px rgba(161, 80, 255, 0.4); padding: 3px; background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7); animation: floatVideo 6s ease-in-out infinite;">
                <video class="hero-video" style="width: 100%; height: auto; display: block; border-radius: 24px; background: #000;" autoplay loop muted playsinline>
                    <source src="assets/videos/hero-bg.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</section>

<section class="services">
    <div class="container">
        <div class="section-header">
            <h2><?php echo __('servicios_titulo'); ?></h2>
            <p><?php echo __('servicios_subtitulo'); ?></p>
        </div>
        
        <div class="services-grid" id="services-container">
            <?php if ($result_servicios && $result_servicios->num_rows > 0): ?>
                <?php while($servicio = $result_servicios->fetch_assoc()): ?>
                    <?php
                    $titulo_serv = ($idioma_actual == 'en' && !empty($servicio['titulo_en'])) 
                        ? $servicio['titulo_en'] 
                        : $servicio['titulo'];
                        
                    $descripcion_serv = ($idioma_actual == 'en' && !empty($servicio['descripcion_en'])) 
                        ? $servicio['descripcion_en'] 
                        : $servicio['descripcion'];
                    ?>
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas <?php echo htmlspecialchars($servicio['icono']); ?>"></i>
                        </div>
                        <h3><?php echo htmlspecialchars($titulo_serv); ?></h3>
                        <p><?php echo htmlspecialchars(substr($descripcion_serv, 0, 100)) . '...'; ?></p>
                        <a href="pages/servicios.php#<?php echo strtolower(str_replace(' ', '-', $servicio['titulo'])); ?>" class="service-link"><?php echo __('servicios_saber_mas'); ?> <i class="fas fa-arrow-right"></i></a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data"><?php echo __('servicios_no_datos'); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="section-footer">
            <a href="pages/servicios.php" class="btn btn-outline"><?php echo __('servicios_ver_todos'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <span class="section-tag"><?php echo __('sobre_tag'); ?></span>
                <h2><?php echo __('sobre_titulo'); ?></h2>
                <p><?php echo __('sobre_texto'); ?></p>
                
                <div class="features-list">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('sobre_feature1'); ?></span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('sobre_feature2'); ?></span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('sobre_feature3'); ?></span>
                    </div>
                </div>
                
                <a href="pages/sobre-nosotros.php" class="btn btn-link"><?php echo __('sobre_conocer_mas'); ?> <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="about-image">
                <img src="assets/images/Imagen1.png" alt="<?php echo __('sobre_tag'); ?>">
            </div>
        </div>
    </div>
</section>

<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number"><?php echo $total_proyectos; ?></span>
                <span class="stat-label"><?php echo __('stats_proyectos'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $total_clientes; ?></span>
                <span class="stat-label"><?php echo __('stats_clientes'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-number">2025</span>
                <span class="stat-label"><?php echo __('stats_anio'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $total_servicios; ?></span>
                <span class="stat-label"><?php echo __('stats_servicios'); ?></span>
            </div>
        </div>
    </div>
</section>

<section class="testimonials" style="display: none;">
</section>

<section class="blog">
    <div class="container">
        <div class="section-header">
            <h2><?php echo __('blog_titulo'); ?></h2>
            <p><?php echo __('blog_subtitulo'); ?></p>
        </div>
        
        <div class="blog-grid" id="blog-container">
            <?php if ($result_blog && $result_blog->num_rows > 0): ?>
                <?php while($post = $result_blog->fetch_assoc()): ?>
                    <?php
                    $titulo_blog_index = ($idioma_actual == 'en' && !empty($post['titulo_en'])) 
                        ? $post['titulo_en'] 
                        : $post['titulo'];
                        
                    $extracto_blog_index = ($idioma_actual == 'en' && !empty($post['extracto_en'])) 
                        ? $post['extracto_en'] 
                        : $post['extracto'];
                        
                    $categoria_blog_index = ($idioma_actual == 'en' && !empty($post['categoria_en'])) 
                        ? $post['categoria_en'] 
                        : $post['categoria'];
                    ?>
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="assets/images/<?php echo $post['imagen_destacada']; ?>" alt="...">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><?php echo date('d/m/Y', strtotime($post['fecha_publicacion'])); ?></span>
                                <span><?php echo htmlspecialchars($categoria_blog_index); ?></span>
                            </div>
                            <h3><?php echo htmlspecialchars($titulo_blog_index); ?></h3>
                            <p><?php echo htmlspecialchars(substr($extracto_blog_index, 0, 100)) . '...'; ?></p>
                            <a href="pages/blog.php?id=<?php echo $post['id']; ?>" class="blog-link"><?php echo __('blog_leer_mas'); ?> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data"><?php echo __('blog_no_datos'); ?></p> 
            <?php endif; ?>
        </div>
        <div class="section-footer">
            <a href="pages/blog.php" class="btn btn-outline"><?php echo __('blog_ver_todas'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2><?php echo __('cta_titulo'); ?></h2>
            <p><?php echo __('cta_subtitulo'); ?></p>
            <a href="pages/contacto.php" class="btn btn-primary btn-large"><?php echo __('cta_boton'); ?></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>