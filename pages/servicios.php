<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas

// Obtener todos los servicios activos
$sql = "SELECT * FROM servicios WHERE activo = 1 ORDER BY orden";
$result = $conn->query($sql);

// Título de la página
$page_title = __('servicios_titulo_pagina') . ' - GVR Web Studio';

// Incluir header
include '../includes/header.php';
?>

<!-- HERO DE PÁGINA -->
<section class="page-hero">
    <div class="container">
        <h1><?php echo __('servicios_hero_titulo'); ?></h1>
        <p><?php echo __('servicios_hero_texto'); ?></p>
    </div>
</section>

<section class="services-page">
    <div class="container">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="services-grid">
                <?php while($servicio = $result->fetch_assoc()): ?>
                    <?php
                    // Mostrar título según idioma
                    $titulo_mostrar = ($idioma_actual == 'en' && !empty($servicio['titulo_en'])) 
                        ? $servicio['titulo_en'] 
                        : $servicio['titulo'];
                    
                    $descripcion_mostrar = ($idioma_actual == 'en' && !empty($servicio['descripcion_en'])) 
                        ? $servicio['descripcion_en'] 
                        : $servicio['descripcion'];
                    ?>
                    <div class="service-card service-card-full">
                        <div class="service-icon">
                            <i class="fas <?php echo htmlspecialchars($servicio['icono']); ?>"></i>
                        </div>
                         
                        <h2><?php echo htmlspecialchars($titulo_mostrar); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($descripcion_mostrar)); ?></p>
                        
                        <!-- Características por servicio -->
                        <?php 
                        $titulo = $servicio['titulo'];
                        
                        if($titulo == 'Diseño Web Profesional' || $titulo == 'Diseño Web'): ?>
                            <div class="service-features">
                                <h4><?php echo __('servicios_incluye'); ?></h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_web_responsive'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_web_seo'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_web_formulario'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_web_admin'); ?></li>
                                </ul>
                            </div>
                        
                        <?php elseif($titulo == 'Diseño de Logotipos'): ?>
                            <div class="service-features">
                                <h4><?php echo __('servicios_incluye'); ?></h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_logo_principal'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_logo_variantes'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_logo_monocromo'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_logo_archivos'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_logo_manual'); ?></li>
                                </ul>
                            </div>
                        
                        <?php elseif($titulo == 'Branding Completo'): ?>
                            <div class="service-features">
                                <h4><?php echo __('servicios_incluye'); ?></h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_branding_logo'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_branding_colores'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_branding_tipografia'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_branding_plantillas'); ?></li>
                                </ul>
                            </div>
                        
                        <?php elseif($titulo == 'SEO'): ?>
                            <div class="service-features">
                                <h4><?php echo __('servicios_incluye'); ?></h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_seo_palabras'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_seo_onpage'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_seo_contenidos'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_seo_console'); ?></li>
                                </ul>
                            </div>
                        
                        <?php elseif($titulo == 'Mantenimiento Web'): ?>
                            <div class="service-features">
                                <h4><?php echo __('servicios_incluye'); ?></h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_mantenimiento_backups'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_mantenimiento_seguridad'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_mantenimiento_monitorizacion'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_mantenimiento_modificaciones'); ?></li>
                                </ul>
                            </div>
                        
                        <?php elseif($titulo == 'Redes sociales'): ?>
                            <div class="service-features">
                                <h4><?php echo __('servicios_incluye'); ?></h4>
                                <ul>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_rrss_contenido'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_rrss_community'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_rrss_metricas'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php echo __('servicios_rrss_informe'); ?></li>
                                </ul>
                            </div>

                        <?php endif; ?>
                        
                        <div class="service-cta">
                            <a href="pago.php?servicio=<?php echo urlencode($servicio['titulo']); ?>" class="btn btn-primary">
                                <?php echo __('servicios_contratar'); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-data"><?php echo __('servicios_no_datos'); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="faq">
    <div class="container">
        <div class="section-header">
            <h2><?php echo __('faq_titulo'); ?></h2>
            <p><?php echo __('faq_subtitulo'); ?></p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo __('faq_tiempo'); ?></h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p><?php echo __('faq_tiempo_respuesta'); ?></p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo __('faq_programar'); ?></h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p><?php echo __('faq_programar_respuesta'); ?></p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo __('faq_mantenimiento'); ?></h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p><?php echo __('faq_mantenimiento_respuesta'); ?></p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo __('faq_logotipo'); ?></h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p><?php echo __('faq_logotipo_respuesta'); ?></p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo __('faq_seo'); ?></h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p><?php echo __('faq_seo_respuesta'); ?></p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo __('faq_pagos'); ?></h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p><?php echo __('faq_pagos_respuesta'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2><?php echo __('cta_titulo'); ?></h2>
            <p><?php echo __('cta_subtitulo'); ?></p>
            <a href="pago.php" class="btn btn-primary btn-large"><?php echo __('cta_boton'); ?></a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>s