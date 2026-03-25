<?php
require_once '../includes/config.php';

// Obtener el término de búsqueda
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$busqueda_segura = '%' . $conn->real_escape_string($busqueda) . '%';

// Buscar en título, extracto, contenido y tags
$sql = "SELECT * FROM blog_posts 
        WHERE publicado = 1 
        AND (titulo LIKE ? 
             OR extracto LIKE ? 
             OR contenido LIKE ? 
             OR tags LIKE ?)
        ORDER BY fecha_publicacion DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $busqueda_segura, $busqueda_segura, $busqueda_segura, $busqueda_segura);
$stmt->execute();
$result = $stmt->get_result();

// Contar resultados
$total_resultados = $result->num_rows;

$page_title = "Resultados de búsqueda - GVR Web Studio";

include '../includes/header.php';
?>
<style>
    /* Estilos para la página de resultados */
    .blog-hero {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        padding: 120px 0 80px;
        text-align: center;
        margin-top: 80px;
    }
    .blog-hero h1 {
        color: white;
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .blog-hero p {
        color: rgba(255,255,255,0.9);
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto 1rem;
    }
    .blog-search {
    max-width: 500px;
    margin: 2rem auto 0;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 15px 55px 15px 20px; /* Espacio a la derecha para el botón */
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    outline: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.search-btn {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%); /* Centra verticalmente */
    background: #6366f1;
    color: white;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-btn:hover {
    background: #4f46e5;
    transform: translateY(-50%) scale(1.05);
}
    .blog-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        margin-top: 3rem;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding: 0 1rem;
    }
    .blog-main {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .blog-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .blog-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid #e5e7eb;
        transition: transform 0.3s ease;
    }
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .blog-image {
        position: relative;
        height: 220px;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .blog-category-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #6366f1;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        z-index: 10;
    }
    .blog-content {
        padding: 1.5rem;
    }
    .blog-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
        font-size: 0.85rem;
        color: #6b7280;
    }
    .blog-meta i {
        color: #6366f1;
        margin-right: 0.3rem;
    }
    .blog-content h2 {
        font-size: 1.3rem;
        margin-bottom: 0.75rem;
        color: #1f2937;
    }
    .blog-content p {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .blog-tags {
        display: flex;
        gap: 0.5rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    }
    .tag {
        background: #f3f4f6;
        color: #6b7280;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
    }
    .blog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    .blog-author {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        color: #6b7280;
        font-size: 0.85rem;
    }
    .blog-read-more {
        color: #6366f1;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }
    .blog-read-more:hover {
        gap: 0.8rem;
    }
    .blog-sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    .sidebar-widget {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid #e5e7eb;
    }
    .sidebar-widget h3 {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #6366f1;
        color: #1f2937;
    }
    .sidebar-widget ul {
        list-style: none;
        padding: 0;
    }
    .sidebar-widget ul li {
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sidebar-widget ul li i {
        color: #6366f1;
    }
    .sidebar-newsletter input {
        width: 100%;
        padding: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-family: inherit;
    }
    .btn-block {
        width: 100%;
        padding: 12px;
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
    }
    .btn-block:hover {
        background: #4f46e5;
    }
    .no-data {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
    }
    .no-data i {
        color: #6366f1;
        opacity: 0.5;
        margin-bottom: 1rem;
    }
    .btn-primary {
        display: inline-block;
        padding: 12px 30px;
        background: #6366f1;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }
    .footer {
        background: #1f2937;
        color: white;
        padding: 60px 0 20px;
        margin-top: 60px;
    }
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    @media (max-width: 992px) {
        .blog-layout {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .blog-hero h1 { font-size: 2.5rem; }
        .blog-meta { flex-direction: column; gap: 0.3rem; }
        .blog-footer { flex-direction: column; gap: 1rem; align-items: flex-start; }
    }
</style>
<!-- HERO DE PÁGINA -->
<section class="page-hero blog-hero">
    <div class="container">
        <h1>Resultados de búsqueda</h1>
        <p><?php echo $total_resultados; ?> artículo(s) encontrado(s) para: <strong>"<?php echo htmlspecialchars($busqueda); ?>"</strong></p>
        
        <!-- Barra de búsqueda -->
        <div class="blog-search">
            <form action="buscar.php" method="GET">
                <input type="text" name="q" placeholder="Buscar artículos..." class="search-input" value="<?php echo htmlspecialchars($busqueda); ?>">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</section>

<!-- RESULTADOS -->
<section class="blog-page">
    <div class="container">
        <div class="blog-layout">
            <!-- COLUMNA PRINCIPAL -->
            <div class="blog-main">
                <?php if ($total_resultados > 0): ?>
                    <div class="blog-grid">
                        <?php while($post = $result->fetch_assoc()): ?>
                            <article class="blog-card">
                                <div class="blog-image">
                                    <?php if($post['imagen_destacada']): ?>
                                        <img src="../assets/images/<?php echo htmlspecialchars($post['imagen_destacada']); ?>" 
                                             alt="<?php echo htmlspecialchars($post['titulo']); ?>">
                                    <?php else: ?>
                                        <img src="../assets/images/ImagenNegra.png" alt="Blog">
                                    <?php endif; ?>
                                    
                                    <span class="blog-category-badge"><?php echo htmlspecialchars($post['categoria']); ?></span>
                                </div>
                                
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span class="blog-date">
                                            <i class="far fa-calendar-alt"></i> 
                                            <?php echo date('d/m/Y', strtotime($post['fecha_publicacion'])); ?>
                                        </span>
                                        <span class="blog-views">
                                            <i class="far fa-eye"></i> 
                                            <?php echo number_format($post['visitas']); ?> lecturas
                                        </span>
                                    </div>
                                    
                                    <h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
                                    
                                    <p><?php echo htmlspecialchars($post['extracto']); ?></p>
                                    
                                    <?php if($post['tags']): 
                                        $tags = json_decode($post['tags'], true);
                                        if(is_array($tags) && !empty($tags)): ?>
                                        <div class="blog-tags">
                                            <?php foreach(array_slice($tags, 0, 3) as $tag): ?>
                                                <span class="tag">#<?php echo htmlspecialchars($tag); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; endif; ?>
                                    
                                    <div class="blog-footer">
                                        <span class="blog-author">
                                            <i class="far fa-user"></i> 
                                            <?php echo htmlspecialchars($post['autor']); ?>
                                        </span>
                                        <a href="blog-detalle.php?id=<?php echo $post['id']; ?>" class="blog-read-more">
                                            Leer artículo <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-search fa-4x"></i>
                        <h3>No se encontraron resultados</h3>
                        <p>No encontramos artículos que coincidan con "<?php echo htmlspecialchars($busqueda); ?>"</p>
                        <a href="blog.php" class="btn btn-primary" style="margin-top: 1rem;">Volver al blog</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- SIDEBAR - BARRA LATERAL -->
            <aside class="blog-sidebar">
                <!-- Sobre el blog -->
                <div class="sidebar-widget about-widget">
                    <h3>Sobre el blog</h3>
                    <p>Compartimos conocimientos, tendencias y consejos sobre diseño web, branding, SEO y marketing digital.</p>
                </div>
                
                <!-- Consejo de búsqueda -->
                <div class="sidebar-widget">
                    <h3>Consejos de búsqueda</h3>
                    <ul style="list-style: none;">
                        <li><i class="fas fa-check-circle" style="color: #6366f1;"></i> Usa palabras clave</li>
                        <li><i class="fas fa-check-circle" style="color: #6366f1;"></i> Busca por temas: diseño web, SEO, branding</li>
                        <li><i class="fas fa-check-circle" style="color: #6366f1;"></i> Prueba con términos más generales</li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div class="sidebar-widget newsletter-widget">
                    <h3>Newsletter</h3>
                    <p>Recibe los mejores artículos directamente en tu email</p>
                    <form class="sidebar-newsletter">
                        <input type="email" placeholder="Tu email" required>
                        <button type="submit" class="btn-block">Suscribirme</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>