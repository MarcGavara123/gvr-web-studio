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
                        
                        <!-- Características por servicio -->
                        <?php 
                        $titulo = $servicio['titulo'];
                        
                        // Diseño Web
                        if($titulo == 'Diseño Web Profesional' || $titulo == 'Diseño Web'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Diseño responsive (móvil, tablet, escritorio)</li>
                                    <li><i class="fas fa-check"></i> Optimización SEO básica</li>
                                    <li><i class="fas fa-check"></i> Formulario de contacto</li>
                                    <li><i class="fas fa-check"></i> Panel de administración intuitivo</li>
                                </ul>
                            </div>
                        
                        <!-- Diseño de Logotipos -->
                        <?php elseif($titulo == 'Diseño de Logotipos'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Logotipo principal</li>
                                    <li><i class="fas fa-check"></i> 2 variantes de color</li>
                                    <li><i class="fas fa-check"></i> Versión simplificada (monocromo)</li>
                                    <li><i class="fas fa-check"></i> Archivos para web y redes sociales</li>
                                    <li><i class="fas fa-check"></i> Manual de uso básico</li>
                                </ul>
                            </div>
                        
                        <!-- Branding Completo -->
                        <?php elseif($titulo == 'Branding Completo'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Logotipo y todas sus variantes</li>
                                    <li><i class="fas fa-check"></i> Paleta de colores corporativos</li>
                                    <li><i class="fas fa-check"></i> Tipografías corporativas</li>
                                    <li><i class="fas fa-check"></i> Plantillas para redes sociales</li>
                                </ul>
                            </div>
                        
                        <!-- Posicionamiento SEO -->
                        <?php elseif($titulo == 'SEO'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Análisis de palabras clave</li>
                                    <li><i class="fas fa-check"></i> Optimización Página (títulos, meta descripciones)</li>
                                    <li><i class="fas fa-check"></i> Estrategia de contenidos</li>
                                    <li><i class="fas fa-check"></i> Configuración de Google Search Console</li>
                                </ul>
                            </div>
                        
                        <!-- Mantenimiento Web -->
                        <?php elseif($titulo == 'Mantenimiento Web'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Copias de seguridad semanales</li>
                                    <li><i class="fas fa-check"></i> Actualizaciones de seguridad</li>
                                    <li><i class="fas fa-check"></i> Monitorización</li>
                                    <li><i class="fas fa-check"></i> Pequeñas modificaciones de contenido</li>
                                </ul>
                            </div>
                        
                        <!-- Community Management -->
                        <?php elseif($titulo == 'Redes sociales'): ?>
                            <div class="service-features">
                                <h4>¿Qué incluye?</h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> Creación de contenido visual profesional</li>
                                    <li><i class="fas fa-check"></i> Community management (respuesta a comentarios)</li>
                                    <li><i class="fas fa-check"></i> Análisis de métricas</li>
                                    <li><i class="fas fa-check"></i> Informe mensual de resultados</li>
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
            <p>Resolvemos tus dudas sobre nuestros servicios</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cuánto tiempo lleva crear una página web?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>El tiempo depende de la complejidad del proyecto. Una web corporativa sencilla puede estar lista en 2-3 semanas, mientras que proyectos más complejos pueden llevar 4-6 semanas. Priorizamos la calidad, no la rapidez.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Necesito saber programar para gestionar mi web?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>No, todas nuestras webs incluyen un panel de administración intuitivo donde puedes actualizar contenidos fácilmente. Además, te formamos durante 1 hora para que te sientas cómodo gestionándola y estamos a tu disposición para cualquier duda.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué incluye el mantenimiento web?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Nuestros planes de mantenimiento incluyen: copias de seguridad semanales, actualizaciones de seguridad, monitorización 24/7, soporte técnico prioritario y modificaciones de contenido.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cómo funciona el proceso de diseño de logotipo?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Primero realizamos una reunión para conocer tu marca y valores, luego presentamos 3 propuestas iniciales, realizamos los ajustes que necesites, y entregamos los archivos finales en todos los formatos necesarios.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Ofrecen servicios de SEO por separado?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Sí, ofrecemos servicios de SEO tanto para webs nuevas como para las que ya están en funcionamiento. Incluye análisis de palabras clave, optimización técnica y estrategia de contenidos.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué formas de pago aceptan?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Aceptamos transferencia bancaria, bizum y pago con tarjeta a través de plataforma segura. Siempre con la opción que elija usted.</p>
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
            <p>Cuéntanos tu idea sin compromiso y te asesoramos</p>
            <a href="contacto.php" class="btn btn-primary btn-large">Solicita presupuesto</a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>