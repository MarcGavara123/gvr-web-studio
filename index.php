<?php
require_once 'includes/config.php';

$sql_servicios = "SELECT * FROM servicios WHERE destacado = 1 AND activo = 1 ORDER BY orden LIMIT 6";
$result_servicios = $conn->query($sql_servicios);

$sql_portfolio = "SELECT * FROM portfolio WHERE destacado = 1 AND activo = 1 ORDER BY created_at DESC LIMIT 3";
$result_portfolio = $conn->query($sql_portfolio);

$sql_blog = "SELECT * FROM blog_posts WHERE publicado = 1 ORDER BY fecha_publicacion DESC LIMIT 3";
$result_blog = $conn->query($sql_blog);

$sql_count_servicios = "SELECT COUNT(*) as total FROM servicios WHERE activo = 1";
$result_count = $conn->query($sql_count_servicios);
$total_servicios = $result_count->fetch_assoc()['total'];

$total_proyectos = 1; 
$total_clientes = 1;

$page_title = "GVR Web Studio - Diseño Web, Logotipos y Branding";

include 'includes/header.php';
?>

<!-- SECCIÓN 1: HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Creamos la <span class="highlight">identidad digital</span> de tu negocio</h1>
            <p class="hero-subtitle">Diseño web profesional, logotipos únicos y estrategias de branding que conectan con tu audiencia.</p>
            <div class="hero-buttons">
                <a href="pages/contacto.php" class="btn btn-primary">Solicita presupuesto</a>
                <a href="pages/portfolio.php" class="btn btn-secondary">Ver proyectos</a>
            </div>
        </div>

        <!-- IMAGEN ESTÁTICA -->
        
    </div>
</section>
</div>
    </div>
</section>

<section class="services">
    <div class="container">
        <div class="section-header">
            <h2>¿Qué podemos hacer por ti?</h2>
            <p>Servicios diseñados para impulsar tu presencia digital</p>
        </div>
        
        <div class="services-grid" id="services-container">
            <?php if ($result_servicios && $result_servicios->num_rows > 0): ?>
                <?php while($servicio = $result_servicios->fetch_assoc()): ?>
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas <?php echo htmlspecialchars($servicio['icono']); ?>"></i>
                        </div>
                        <h3><?php echo htmlspecialchars($servicio['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($servicio['descripcion'], 0, 100)) . '...'; ?></p>
                        <a href="pages/servicios.php#<?php echo strtolower(str_replace(' ', '-', $servicio['titulo'])); ?>" class="service-link">Saber más <i class="fas fa-arrow-right"></i></a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">No hay servicios destacados disponibles</p>
            <?php endif; ?>
        </div>
        
        <div class="section-footer">
            <a href="pages/servicios.php" class="btn btn-outline">Ver todos los servicios <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <span class="section-tag">Sobre GVR Studio</span>
                <h2>Pasión por el diseño digital</h2>
                <p>En GVR Web Studio creemos que cada negocio merece una presencia online única y profesional. Trabajamos de forma cercana para entender tus necesidades y transformarlas en soluciones digitales efectivas.</p>
                
                <div class="features-list">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Diseños 100% personalizados</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Enfoque en resultados y conversión</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Soporte continuo y cercano</span>
                    </div>
                </div>
                
                <a href="pages/sobre-nosotros.php" class="btn btn-link">Conoce más sobre nosotros <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="about-image">
                <img src="assets/images/Imagen1.png" alt="Equipo GVR Web Studio">
            </div>
        </div>
    </div>
</section>

<section class="portfolio">
    <div class="container">
        <div class="section-header">
            <h2>Proyectos recientes</h2>
            <p>Algunos de los trabajos que hemos realizado</p>
        </div>
        
        <div class="portfolio-grid" id="portfolio-container">
            <?php if ($result_portfolio && $result_portfolio->num_rows > 0): ?>
                <?php while($proyecto = $result_portfolio->fetch_assoc()): ?>
                    <div class="portfolio-card">
                        <div class="portfolio-image">
                            <img src="assets/images/portfolio/<?php echo $proyecto['imagen_principal']; ?>" alt="<?php echo htmlspecialchars($proyecto['titulo']); ?>">
                            <div class="portfolio-overlay">
                                <span class="portfolio-category"><?php echo ucfirst($proyecto['categoria']); ?></span>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h3><?php echo htmlspecialchars($proyecto['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($proyecto['descripcion'], 0, 80)) . '...'; ?></p>
                            <?php if($proyecto['url_demo']): ?>
                                <a href="<?php echo $proyecto['url_demo']; ?>" target="_blank" class="portfolio-link">Ver proyecto <i class="fas fa-external-link-alt"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">Próximamente más proyectos</p>
            <?php endif; ?>
        </div>
        
        <div class="section-footer">
            <a href="pages/portfolio.php" class="btn btn-outline">Ver portfolio completo <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number"><?php echo $total_proyectos; ?></span>
                <span class="stat-label">Proyectos completados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $total_clientes; ?></span>
                <span class="stat-label">Clientes satisfechos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">2025</span>
                <span class="stat-label">Año de fundación</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $total_servicios; ?></span>
                <span class="stat-label">Servicios ofrecidos</span>
            </div>
        </div>
    </div>
</section>

<section class="testimonials" style="display: none;">
</section>

<section class="blog">
    <div class="container">
        <div class="section-header">
            <h2>Últimas del blog</h2>
            <p>Consejos y tendencias en diseño web</p>
        </div>
        
        <div class="blog-grid" id="blog-container">
            <?php if ($result_blog && $result_blog->num_rows > 0): ?>
                <?php while($post = $result_blog->fetch_assoc()): ?>
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="assets/images/blog/<?php echo $post['imagen_destacada']; ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><?php echo date('d/m/Y', strtotime($post['fecha_publicacion'])); ?></span>
                                <span><?php echo htmlspecialchars($post['categoria']); ?></span>
                            </div>
                            <h3><?php echo htmlspecialchars($post['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($post['extracto'], 0, 100)) . '...'; ?></p>
                            <a href="pages/blog.php?id=<?php echo $post['id']; ?>" class="blog-link">Leer más <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">Próximamente artículos del blog</p>
            <?php endif; ?>
        </div>
        
        <div class="section-footer">
            <a href="pages/blog.php" class="btn btn-outline">Ver todas las entradas <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2>¿Listo para tu próximo proyecto?</h2>
            <p>Cuéntanos tu idea y la haremos realidad</p>
            <a href="pages/contacto.php" class="btn btn-primary btn-large">Solicita tu presupuesto gratis</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
