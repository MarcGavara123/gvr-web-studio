<?php
require_once '../includes/config.php';

// Obtener todos los servicios activos
$sql = "SELECT * FROM servicios WHERE activo = 1 ORDER BY orden";
$result = $conn->query($sql);

// Título de la página
$page_title = "Servicios - GVR Web Studio";

// Incluir header (con ruta correcta)
include '../includes/header.php';
?>

<!-- HERO DE PÁGINA (pequeño) -->
<section class="page-hero">
    <div class="container">
        <h1>Nuestros Servicios</h1>
        <p>Soluciones digitales diseñadas para hacer crecer tu negocio</p>
    </div>
</section>

<section class="services-page">
    <div class="container">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="services-grid">
                <?php while($servicio = $result->fetch_assoc()): ?>
                    <div class="service-card service-card-full">
                        <div class="service-icon">
                            <i class="fas <?php echo htmlspecialchars($servicio['icono']); ?>"></i>
                        </div>
                        <h2><?php echo htmlspecialchars($servicio['titulo']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($servicio['descripcion'])); ?></p>
                        
                        
                        <?php if($servicio['titulo'] == 'Diseño Web'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Diseño responsive</li>
                                    <li><i class="fas fa-check"></i> Optimización SEO básica</li>
                                    <li><i class="fas fa-check"></i> Formulario de contacto</li>
                                    <li><i class="fas fa-check"></i> Panel de administración</li>
                                    <li><i class="fas fa-check"></i> Formación incluida</li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($servicio['titulo'] == 'Diseño de Logotipos'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Logotipo principal</li>
                                    <li><i class="fas fa-check"></i> Variantes de color</li>
                                    <li><i class="fas fa-check"></i> Archivos vectoriales</li>
                                    <li><i class="fas fa-check"></i> Manual de uso básico</li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($servicio['titulo'] == 'Branding Completo'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Logotipo y variantes</li>
                                    <li><i class="fas fa-check"></i> Paleta de colores</li>
                                    <li><i class="fas fa-check"></i> Tipografías corporativas</li>
                                    <li><i class="fas fa-check"></i> Papelería básica</li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div class="service-cta">
                            <a href="contacto.php?servicio=<?php echo urlencode($servicio['titulo']); ?>" class="btn btn-primary">
                                Solicitar presupuesto
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-data">No hay servicios disponibles en este momento.</p>
        <?php endif; ?>
    </div>
</section>

<section class="faq">
    <div class="container">
        <div class="section-header">
            <h2>Preguntas frecuentes</h2>
            <p>Si tienes otras preguntas contactanos.</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cuánto tiempo lleva crear una página web?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>El tiempo depende de la complejidad. Una web sencilla puede estar lista en 2 semanas.
                        Recuerda que lo importante es el resultado bien hecho.
                    </p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Necesito saber programar?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p> No, todas nuestras webs incluyen un panel de administración sencillo y estaremos disponible para realizar el mantenimiento.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué incluye el mantenimiento?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Copias de seguridad, actualizaciones y soporte técnico.</p>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2>¿Tienes un proyecto en mente?</h2>
            <p>Cuéntanos tu idea sin compromiso</p>
            <a href="contacto.php" class="btn btn-primary btn-large">Solicita presupuesto</a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>