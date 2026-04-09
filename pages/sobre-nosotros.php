<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas

$page_title = __('sobre_titulo_pagina') . ' - GVR Web Studio';

include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1><?php echo __('sobre_hero_titulo'); ?></h1>
        <p><?php echo __('sobre_hero_texto'); ?></p>
    </div>
</section>

<section class="about-intro">
    <div class="container">
        <div class="about-intro-content">
            <div class="about-intro-text">
                <h2><?php echo __('sobre_intro_titulo'); ?></h2>
                <p><?php echo __('sobre_intro_texto1'); ?></p>
                <p><?php echo __('sobre_intro_texto2'); ?></p>
            </div>
            <div class="about-intro-image">
                <img src="../assets/images/sobrenos.png" alt="<?php echo __('sobre_hero_titulo'); ?>">
            </div>
        </div>
    </div>
</section>

<section class="mission-vision">
    <div class="container">
        <div class="mv-grid">
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3><?php echo __('sobre_mision'); ?></h3>
                <p><?php echo __('sobre_mision_texto'); ?></p>
            </div>
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3><?php echo __('sobre_vision'); ?></h3>
                <p><?php echo __('sobre_vision_texto'); ?></p>
            </div>
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3><?php echo __('sobre_valores'); ?></h3>
                <ul>
                    <li><?php echo __('sobre_valor1'); ?></li>
                    <li><?php echo __('sobre_valor2'); ?></li>
                    <li><?php echo __('sobre_valor3'); ?></li>
                    <li><?php echo __('sobre_valor4'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="how-we-work">
    <div class="container">
        <div class="section-header">
            <h2><?php echo __('sobre_como_trabajamos'); ?></h2>
            <p><?php echo __('sobre_como_trabajamos_texto'); ?></p>
        </div>
        <div class="process-steps">
            <div class="step">
                <div class="step-number">01</div>
                <h3><?php echo __('sobre_paso1'); ?></h3>
                <p><?php echo __('sobre_paso1_texto'); ?></p>
            </div>
            <div class="step">
                <div class="step-number">02</div>
                <h3><?php echo __('sobre_paso2'); ?></h3>
                <p><?php echo __('sobre_paso2_texto'); ?></p>
            </div>
            <div class="step">
                <div class="step-number">03</div>
                <h3><?php echo __('sobre_paso3'); ?></h3>
                <p><?php echo __('sobre_paso3_texto'); ?></p>
            </div>
            <div class="step">
                <div class="step-number">04</div>
                <h3><?php echo __('sobre_paso4'); ?></h3>
                <p><?php echo __('sobre_paso4_texto'); ?></p>
            </div>
            <div class="step">
                <div class="step-number">05</div>
                <h3><?php echo __('sobre_paso5'); ?></h3>
                <p><?php echo __('sobre_paso5_texto'); ?></p>
            </div>
            <div class="step">
                <div class="step-number">06</div>
                <h3><?php echo __('sobre_paso6'); ?></h3>
                <p><?php echo __('sobre_paso6_texto'); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="why-us">
    <div class="container">
        <div class="section-header">
            <h2><?php echo __('sobre_porque_titulo'); ?></h2>
            <p><?php echo __('sobre_porque_texto'); ?></p>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <i class="fa-solid fa-paintbrush"></i>
                <h3><?php echo __('sobre_feature1_titulo'); ?></h3>
                <p><?php echo __('sobre_feature1_texto'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-mobile-alt"></i>
                <h3><?php echo __('sobre_feature2_titulo'); ?></h3>
                <p><?php echo __('sobre_feature2_texto'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-line"></i>
                <h3><?php echo __('sobre_feature3_titulo'); ?></h3>
                <p><?php echo __('sobre_feature3_texto'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-headset"></i>
                <h3><?php echo __('sobre_feature4_titulo'); ?></h3>
                <p><?php echo __('sobre_feature4_texto'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-clock"></i>
                <h3><?php echo __('sobre_feature5_titulo'); ?></h3>
                <p><?php echo __('sobre_feature5_texto'); ?></p>
            </div>
            <div class="feature-item">
                <i class="fas fa-hand-holding-heart"></i>
                <h3><?php echo __('sobre_feature6_titulo'); ?></h3>
                <p><?php echo __('sobre_feature6_texto'); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2><?php echo __('sobre_cta_titulo'); ?></h2>
            <p><?php echo __('sobre_cta_texto'); ?></p>
            <a href="contacto.php" class="btn btn-primary btn-large"><?php echo __('sobre_cta_boton'); ?></a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>