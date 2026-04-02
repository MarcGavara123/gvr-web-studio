<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas

$servicio = isset($_GET['servicio']) ? $_GET['servicio'] : '';
$page_title = __('pago_exito_titulo_pagina') . ' - GVR Web Studio';
include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1><?php echo __('pago_exito_titulo'); ?></h1>
        <p><?php echo __('pago_exito_mensaje', [htmlspecialchars($servicio)]); ?></p>
    </div>
</section>

<section class="success-page">
    <div class="container">
        <div class="success-card">
            <i class="fas fa-check-circle success-icon"></i>
            <h2><?php echo __('pago_exito_gracias'); ?></h2>
            <p><?php echo __('pago_exito_texto1', [htmlspecialchars($servicio)]); ?></p>
            <p><?php echo __('pago_exito_texto2'); ?></p>
            <p><?php echo __('pago_exito_texto3'); ?> <a href="contacto.php"><?php echo __('pago_exito_contacto'); ?></a></p>
            <div class="success-buttons">
                <a href="../index.php" class="btn btn-primary"><?php echo __('pago_exito_volver'); ?></a>
                <a href="servicios.php" class="btn btn-secondary"><?php echo __('pago_exito_servicios'); ?></a>
            </div>
        </div>
    </div>
</section>

<style>
.success-page {
    padding: 60px 0;
    min-height: 60vh;
    display: flex;
    text-align: center;
}

.success-card {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    border-radius: 24px;
    padding: 3rem;
    text-align: center;
    box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
}

.success-icon {
    font-size: 5rem;
    color: #10b981;
    margin-bottom: 1.5rem;
}

.success-card h2 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
}

.success-card p {
    line-height: 1.6;
    color: #6b7280;
    margin-bottom: 1rem;
}

.success-card a {
    color: #6366f1;
    text-decoration: none;
}

.success-card a:hover {
    text-decoration: underline;
}

.success-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.success-buttons .btn-secondary {
    background: transparent;
    color: #4b5563;
    border: 2px solid #e5e7eb;
}

.success-buttons .btn-secondary:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

@media (max-width: 768px) {
    .success-card {
        padding: 2rem;
        margin: 0 1rem;
    }    
    .success-buttons {
        flex-direction: column;
        gap: 0.75rem;    
    }
    .success-buttons .btn {
        width: 100%;
    }
}
</style>

<?php include '../includes/footer.php'; ?>