<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas

// Obtener todos los proyectos del portfolio
$sql = "SELECT * FROM portfolio WHERE activo = 1 ORDER BY destacado DESC, fecha_proyecto DESC";
$result = $conn->query($sql);

// Obtener categorías únicas para filtros
$sql_categorias = "SELECT DISTINCT categoria FROM portfolio WHERE activo = 1 ORDER BY categoria";
$result_categorias = $conn->query($sql_categorias);

// Título de la página
$page_title = __('portfolio_titulo_pagina') . ' - GVR Web Studio';
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
    
    <style>
        .portfolio-hero {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            padding: 120px 0 60px;
            text-align: center;
            margin-top: 80px;
        }
        
        .portfolio-hero h1 {
            color: white;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .portfolio-hero p {
            color: rgba(255,255,255,0.9);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .portfolio-filters {
            text-align: center;
            margin: 3rem 0;
        }
        
        .filter-btn {
            background: transparent;
            border: 2px solid #e5e7eb;
            padding: 0.6rem 1.5rem;
            margin: 0 0.3rem;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #4b5563;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: #6366f1;
            border-color: #6366f1;
            color: white;
        }
        
        .portfolio-grid-page {
            padding: 40px 0 80px;
            background: #f9fafb;
        }
        
        .portfolio-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .portfolio-item {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .portfolio-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -12px rgba(0,0,0,0.2);
        }
        
        .portfolio-item-image {
            position: relative;
            height: 250px;
            overflow: hidden;
            background: #f3f4f6;
        }
        
        .portfolio-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .portfolio-item:hover .portfolio-item-image img {
            transform: scale(1.05);
        }
        
        .portfolio-category-tag {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(99, 102, 241, 0.9);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            z-index: 2;
        }
        
        .portfolio-item-info {
            padding: 1.5rem;
        }
        
        .portfolio-item-info h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #1f2937;
        }
        
        .portfolio-item-info p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .portfolio-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .tech-badge {
            background: #f3f4f6;
            color: #4b5563;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .portfolio-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .portfolio-link-btn {
            color: #6366f1;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: gap 0.3s ease;
        }
        
        .portfolio-link-btn:hover {
            gap: 0.6rem;
        }
        
        .no-data {
            text-align: center;
            padding: 4rem;
            background: white;
            border-radius: 16px;
        }
        
        @media (max-width: 768px) {
            .portfolio-hero h1 { font-size: 2.5rem; }
            .portfolio-items { grid-template-columns: 1fr; }
        }
    </style>
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
                        <li><a href="portfolio.php" class="active"><?php echo __('nav_portfolio'); ?></a></li>
                        <li><a href="blog.php"><?php echo __('nav_blog'); ?></a></li>
                        <li><a href="contacto.php"><?php echo __('nav_contacto'); ?></a></li>
                        <li><a href="sobre-nosotros.php"><?php echo __('nav_sobre_nosotros'); ?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="portfolio-hero">
            <div class="container">
                <h1><?php echo __('portfolio_hero_titulo'); ?></h1>
                <p><?php echo __('portfolio_hero_texto'); ?></p>
            </div>
        </section>

        <section class="portfolio-grid-page">
            <div class="container">
                <div class="portfolio-filters">
                    <button class="filter-btn active" data-filter="all"><?php echo __('portfolio_filtro_todos'); ?></button>
                    <?php if ($result_categorias && $result_categorias->num_rows > 0): ?>
                        <?php while($cat = $result_categorias->fetch_assoc()): ?>
                            <button class="filter-btn" data-filter="<?php echo strtolower($cat['categoria']); ?>">
                                <?php echo htmlspecialchars($cat['categoria']); ?>
                            </button>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                
                <div class="portfolio-items" id="portfolioItems">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($proyecto = $result->fetch_assoc()): ?>
                            <?php
                            // Mostrar según idioma
                            $titulo_proy = ($idioma_actual == 'en' && !empty($proyecto['titulo_en'])) 
                                ? $proyecto['titulo_en'] 
                                : $proyecto['titulo'];
                                
                            $descripcion_proy = ($idioma_actual == 'en' && !empty($proyecto['descripcion_en'])) 
                                ? $proyecto['descripcion_en'] 
                                : $proyecto['descripcion'];
                                
                            $categoria_proy = ($idioma_actual == 'en' && !empty($proyecto['categoria_en'])) 
                                ? $proyecto['categoria_en'] 
                                : $proyecto['categoria'];
                            ?>
                            <div class="portfolio-item" data-category="<?php echo strtolower($categoria_proy); ?>">
                                <div class="portfolio-item-image">
                                    <img src="../assets/images/<?php echo $proyecto['imagen_principal']; ?>" 
                                        alt="<?php echo htmlspecialchars($titulo_proy); ?>"
                                        onerror="this.src='../assets/images/ImagenNegra.png'">
                                    <span class="portfolio-category-tag"><?php echo htmlspecialchars($categoria_proy); ?></span>
                                </div>
                                <div class="portfolio-item-info">
                                    <h3><?php echo htmlspecialchars($titulo_proy); ?></h3>
                                    <p><?php echo htmlspecialchars(substr($descripcion_proy, 0, 120)) . '...'; ?></p>
                                    
                                    <?php 
                                    $tecnologias = json_decode($proyecto['tecnologias'], true);
                                    if(is_array($tecnologias) && !empty($tecnologias)): ?>
                                    <div class="portfolio-tech">
                                        <?php foreach(array_slice($tecnologias, 0, 4) as $tech): ?>
                                            <span class="tech-badge"><?php echo htmlspecialchars($tech); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="no-data">
                            <i class="fas fa-images fa-3x" style="color: #6366f1; opacity: 0.5; margin-bottom: 1rem;"></i>
                            <h3><?php echo __('portfolio_no_datos_titulo'); ?></h3>
                            <p><?php echo __('portfolio_no_datos_texto'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

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
                        <li><i class="fas fa-phone"></i> <a href="tel:693376377">693 37 63 77</a></li>
                        <li><i class="fas fa-phone"></i> <a href="tel:644848658">644 84 86 58</a></li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:gvrwebstudio@gmail.com">gvrwebstudio@gmail.com</a></li>
                        <li><i class="fas fa-clock"></i> L-V 9:00-14:00 y 15:00-18:00</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 GVR Web Studio. <?php echo __('footer_derechos'); ?></p>
            </div>
        </div>
    </footer>

    <script>
        const filterButtons = document.querySelectorAll('.filter-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const filterValue = button.getAttribute('data-filter');
                
                portfolioItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>