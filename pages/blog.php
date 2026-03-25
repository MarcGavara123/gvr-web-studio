<?php
require_once '../includes/config.php';

// Obtener todos los posts publicados
$sql = "SELECT * FROM blog_posts WHERE publicado = 1 ORDER BY fecha_publicacion DESC";
$result = $conn->query($sql);

// Obtener categorías únicas para el filtro
$sql_categorias = "SELECT DISTINCT categoria FROM blog_posts WHERE publicado = 1 ORDER BY categoria";
$result_categorias = $conn->query($sql_categorias);

// Obtener posts populares (más visitados)
$sql_populares = "SELECT id, titulo, visitas, fecha_publicacion FROM blog_posts WHERE publicado = 1 ORDER BY visitas DESC LIMIT 5";
$result_populares = $conn->query($sql_populares);

// Obtener posts recientes para el sidebar
$sql_recientes = "SELECT id, titulo, fecha_publicacion FROM blog_posts WHERE publicado = 1 ORDER BY fecha_publicacion DESC LIMIT 5";
$result_recientes = $conn->query($sql_recientes);

// Título de la página
$page_title = "Blog - GVR Web Studio";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- CSS DIRECTAMENTE AQUÍ -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* CSS DE RESPALDO POR SI EL ARCHIVO EXTERNO FALLA */
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
            margin: 0 auto 2rem;
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
        }
        .blog-content h2 {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            color: #1f2937;
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
        .categories-list {
            list-style: none;
        }
        .categories-list li {
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 0.75rem;
        }
        .categories-list li:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .categories-list a {
            color: #333;
            text-decoration: none;
            display: block;
        }
        .popular-list, .recent-list {
            list-style: none;
        }
        .popular-list li, .recent-list li {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .popular-list li:last-child, .recent-list li:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .popular-list a, .recent-list a {
            color: #333;
            text-decoration: none;
            display: block;
        }
        .popular-title {
            font-weight: 500;
            display: block;
            margin-bottom: 0.25rem;
        }
        .popular-meta {
            font-size: 0.8rem;
            color: #6b7280;
            display: flex;
            gap: 1rem;
        }
        .popular-meta i {
            margin-right: 0.25rem;
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
        .social-sidebar {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: transform 0.3s;
        }
        .social-link:hover {
            transform: translateY(-3px);
        }
        .social-link.instagram { background: linear-gradient(45deg, #f09433, #d62976, #962fbf); }
        .social-link.facebook { background: #1877f2; }
        .social-link.twitter { background: #1da1f2; }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }
        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: white;
            color: #333;
            text-decoration: none;
            border: 1px solid #e5e7eb;
        }
        .page-link:hover {
            background: #f3f4f6;
        }
        .page-link.active {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
        }
        .page-link.next {
            width: auto;
            padding: 0 1rem;
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
        .suggestion-box {
            margin-top: 2rem;
            padding: 2rem;
            background: #f9fafb;
            border-radius: 16px;
        }
        .mini-newsletter {
            display: flex;
            gap: 1rem;
            max-width: 400px;
            margin: 1rem auto 0;
        }
        .mini-newsletter input {
            flex: 1;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        @media (max-width: 992px) {
            .blog-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .blog-hero h1 { font-size: 2.5rem; }
            .blog-meta { flex-direction: column; gap: 0.3rem; }
            .blog-footer { flex-direction: column; gap: 1rem; align-items: flex-start; }
            .mini-newsletter { flex-direction: column; }
        }
    </style>
</head>
<body>
    <!-- HEADER SIMPLE -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-content">
                    <a href="../index.php" class="logo">
                        <span class="logo-text">GVR Web Studio</span>
                    </a>
                    <ul class="nav-menu">
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="portfolio.php">Portfolio</a></li>
                        <li><a href="blog.php" class="active">Blog</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                        <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- HERO DE PÁGINA MEJORADO -->
        <section class="blog-hero">
            <div class="container">
                <h1>Blog</h1>
                <p>Consejos, tendencias y novedades sobre diseño web, branding y marketing digital</p>
                
                <!-- Barra de búsqueda -->
                <div class="blog-search">
                    <form action="buscar.php" method="GET">
                        <input type="text" name="q" placeholder="Buscar artículos..." class="search-input">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </section>

        <!-- BLOG CONTENT -->
        <section class="blog-page">
            <div class="container">
                <div class="blog-layout">
                    <!-- COLUMNA PRINCIPAL - POSTS -->
                    <div class="blog-main">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <div class="blog-grid">
                                <?php while($post = $result->fetch_assoc()): ?>
                                    <article class="blog-card">
                                        <div class="blog-image">
                                            <img src="../assets/images/<?php echo htmlspecialchars($post['imagen_destacada']); ?>" 
                                                 alt="<?php echo htmlspecialchars($post['titulo']); ?>"
                                                 onerror="this.onerror=null; this.src='../assets/images/Gvrblog.png';">
                                            
                                            <!-- Categoría como badge -->
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
                                            
                                            <!-- Tags si existen -->
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
                                <i class="fas fa-newspaper fa-4x"></i>
                                <h3>Próximamente artículos</h3>
                                <p>Estamos preparando contenido interesante sobre diseño web, branding y marketing digital para ti. ¡Vuelve pronto!</p>
                                
                                <!-- Sugerir suscripción -->
                                <div class="suggestion-box">
                                    <h4>¿Quieres ser el primero en leer nuestros artículos?</h4>
                                    <p>Déjanos tu email y te avisaremos cuando publiquemos</p>
                                    <form class="mini-newsletter">
                                        <input type="email" placeholder="Tu email">
                                        <button type="submit" class="btn btn-primary">Avisarme</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- SIDEBAR - BARRA LATERAL -->
                    <aside class="blog-sidebar">
                        <!-- Sobre el blog -->
                        <div class="sidebar-widget about-widget">
                            <h3>Sobre el blog</h3>
                            <p>Compartimos conocimientos, tendencias y consejos sobre diseño web, branding, SEO y marketing digital para ayudarte a hacer crecer tu negocio.</p>
                        </div>
                        
                        <!-- Categorías -->
                        <?php if ($result_categorias && $result_categorias->num_rows > 0): ?>
                        <div class="sidebar-widget categories-widget">
                            <h3>Categorías</h3>
                            <ul class="categories-list">
                                <?php while($categoria = $result_categorias->fetch_assoc()): ?>
                                    <li>
                                        <a href="?categoria=<?php echo urlencode($categoria['categoria']); ?>">
                                            <?php echo htmlspecialchars($categoria['categoria']); ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Posts populares -->
                        <?php if ($result_populares && $result_populares->num_rows > 0): ?>
                        <div class="sidebar-widget popular-widget">
                            <h3>Artículos populares</h3>
                            <ul class="popular-list">
                                <?php while($popular = $result_populares->fetch_assoc()): ?>
                                    <li>
                                        <a href="blog-detalle.php?id=<?php echo $popular['id']; ?>">
                                            <span class="popular-title"><?php echo htmlspecialchars($popular['titulo']); ?></span>
                                            <span class="popular-meta">
                                                <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($popular['fecha_publicacion'])); ?>
                                                <i class="far fa-eye"></i> <?php echo number_format($popular['visitas']); ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Posts recientes -->
                        <?php if ($result_recientes && $result_recientes->num_rows > 0): ?>
                        <div class="sidebar-widget recent-widget">
                            <h3>Recientes</h3>
                            <ul class="recent-list">
                                <?php while($reciente = $result_recientes->fetch_assoc()): ?>
                                    <li>
                                        <a href="blog-detalle.php?id=<?php echo $reciente['id']; ?>">
                                            <?php echo htmlspecialchars($reciente['titulo']); ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                       
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h3>GVR Web Studio</h3>
                    <p>Diseño web, logotipos y branding para negocios que quieren destacar.</p>
                </div>
                <div class="footer-links">
                    <h4>Enlaces rápidos</h4>
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="portfolio.php">Portfolio</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                        <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
                    
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contacto</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> <a href="tel:693376377">693 37 63 77</a></li>
                        <li><i class="fas fa-phone"></i> <a href="tel:644848658">644 84 86 58</a></li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:gvrwebstudio@gmail.com">gvrwebstudio@gmail.com</a></li>
                        <li><i class="fas fa-clock"></i> L-V 9:00-14:00 y 15:00-18:00</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 GVR Web Studio. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../assets/js/main.js"></script>
</body>
</html>