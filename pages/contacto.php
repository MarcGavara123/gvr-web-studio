<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas

$mensaje = '';
$error = '';
$exito = false;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $servicio = trim($_POST['servicio'] ?? '');
    $mensaje_texto = trim($_POST['mensaje'] ?? '');
    
    // Validaciones
    if (empty($nombre)) {
        $error = __('contacto_error_nombre');
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = __('contacto_error_email');
    } elseif (empty($mensaje_texto)) {
        $error = __('contacto_error_mensaje');
    } else {
        // Guardar en la base de datos
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $sql = "INSERT INTO mensajes_contacto (nombre, email, telefono, servicio_interes, mensaje, ip_address, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nombre, $email, $telefono, $servicio, $mensaje_texto, $ip);
        
        if ($stmt->execute()) {
            // Enviar correo de notificación
            $para = "gvrwebstudio@gmail.com";
            $asunto = __('contacto_email_asunto');
            
            $cuerpo = __('contacto_email_cuerpo') . "\n\n";
            $cuerpo .= __('contacto_email_nombre') . ": $nombre\n";
            $cuerpo .= __('contacto_email_email') . ": $email\n";
            $cuerpo .= __('contacto_email_telefono') . ": " . ($telefono ?: __('contacto_no_especificado')) . "\n";
            $cuerpo .= __('contacto_email_servicio') . ": " . ($servicio ?: __('contacto_no_especificado')) . "\n";
            $cuerpo .= __('contacto_email_mensaje') . ":\n$mensaje_texto\n\n";
            $cuerpo .= __('contacto_email_ip') . ": $ip\n";
            $cuerpo .= __('contacto_email_fecha') . ": " . date('d/m/Y H:i:s');
            
            $cabeceras = "From: $email\r\n";
            $cabeceras .= "Reply-To: $email\r\n";
            
            mail($para, $asunto, $cuerpo, $cabeceras);
            
            $exito = true;
            $mensaje = __('contacto_exito');
            $_POST = array();
        } else {
            $error = __('contacto_error_general');
        }
        $stmt->close();
    }
}

$servicio_seleccionado = isset($_GET['servicio']) ? htmlspecialchars($_GET['servicio']) : '';

$page_title = __('contacto_titulo_pagina') . ' - GVR Web Studio';

// Incluir header (con el menú hamburguesa)
include '../includes/header.php';
?>

<style>
    /* Estilos específicos de contacto */
    .contact-hero {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        padding: 120px 0 60px;
        text-align: center;
        margin-top: 80px;
    }
    
    .contact-hero h1 {
        color: white;
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .contact-hero p {
        color: rgba(255,255,255,0.9);
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .contact-page {
        padding: 60px 0;
        background: #f9fafb;
    }
    
    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
    
    .contact-info {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .contact-info h2 {
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    
    .contact-details {
        margin: 2rem 0;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .contact-item:hover {
        transform: translateX(5px);
        background: #f3f4f6;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        background: #6366f1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    .contact-text h4 {
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }
    
    .contact-text p {
        color: #6b7280;
        margin: 0;
    }
    
    .contact-hours {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .payment-methods {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .payment-methods h3 {
        margin-bottom: 1rem;
        font-size: 1.2rem;
        color: #1f2937;
    }
    
    .payment-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: #f9fafb;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .payment-item i {
        font-size: 1.5rem;
        color: #6366f1;
    }
    
    .payment-item strong {
        color: #1f2937;
    }
    
    .payment-item p {
        margin: 0;
        font-size: 0.85rem;
    }
    
    .payment-item small {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .contact-form {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #1f2937;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    
    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .contact-hero h1 { font-size: 2.5rem; }
        .contact-wrapper { grid-template-columns: 1fr; }
    }
</style>

<main>
    <section class="contact-hero">
        <div class="container">
            <h1><?php echo __('contacto_titulo'); ?></h1>
            <p><?php echo __('contacto_subtitulo'); ?></p>
        </div>
    </section>

    <section class="contact-page">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-info">
                    <h2><?php echo __('contacto_hablamos'); ?></h2>
                    <p><?php echo __('contacto_texto'); ?></p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">
                                <h4><?php echo __('contacto_telefono'); ?></h4>
                                <p><a href="tel:693376377">693 37 63 77</a> / <a href="tel:644848658">644 84 86 58</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h4><?php echo __('contacto_email'); ?></h4>
                                <p><a href="mailto:gvrwebstudio@gmail.com">gvrwebstudio@gmail.com</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <div class="contact-text">
                                <h4><?php echo __('contacto_instagram'); ?></h4>
                                <p><a href="https://instagram.com/gvr_webstudio" target="_blank">@gvr_webstudio</a></p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa-brands fa-facebook"></i>
                            </div>
                            <div class="contact-text">
                                <h4><?php echo __('contacto_facebook'); ?></h4>
                                <p><a href="https://www.facebook.com/people/GVR-Web-Studio/61583927649782/#" target="_blank">GVR Web Studio</a></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-hours">
                        <h4><?php echo __('contacto_horario'); ?></h4>
                        <p><?php echo __('contacto_horario_texto'); ?></p>
                        <p><?php echo __('contacto_horario_fin'); ?></p>
                    </div>
                    
                    <!-- FORMAS DE PAGO - BIZUM Y TRANSFERENCIA -->
                    <div class="payment-methods">
                        <h3><?php echo __('contacto_formas_pago'); ?></h3>
                        <div class="payment-item">
                            <i class="fas fa-mobile-alt"></i>
                            <div>
                                <strong>Bizum</strong>
                                <p>Envía tu pago al número: <strong>693 37 63 77</strong></p>
                                <small>Incluye tu nombre y concepto en el mensaje</small>
                            </div>
                        </div>
                        <div class="payment-item">
                            <i class="fas fa-university"></i>
                            <div>
                                <strong><?php echo __('contacto_transferencia'); ?></strong>
                                <p><?php echo __('contacto_transferencia_texto'); ?> <strong>gvrwebstudio@gmail.com</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h2><?php echo __('contacto_formulario'); ?></h2>
                    
                    <?php if ($exito): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <?php echo $mensaje; ?>
                        </div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nombre"><?php echo __('contacto_nombre'); ?> *</label>
                            <input type="text" id="nombre" name="nombre" required 
                                   value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email"><?php echo __('contacto_email_input'); ?> *</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="telefono"><?php echo __('contacto_telefono_input'); ?></label>
                            <input type="tel" id="telefono" name="telefono" 
                                   value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="servicio"><?php echo __('contacto_servicio'); ?></label>
                            <select id="servicio" name="servicio">
                                <option value="">-- <?php echo __('contacto_selecciona'); ?> --</option>
                                <option value="Diseño Web" <?php echo ($servicio_seleccionado == 'Diseño Web' || ($_POST['servicio'] ?? '') == 'Diseño Web') ? 'selected' : ''; ?>>Diseño Web</option>
                                <option value="Diseño de Logotipos" <?php echo ($servicio_seleccionado == 'Diseño de Logotipos' || ($_POST['servicio'] ?? '') == 'Diseño de Logotipos') ? 'selected' : ''; ?>>Diseño de Logotipos</option>
                                <option value="Branding Completo" <?php echo ($servicio_seleccionado == 'Branding Completo' || ($_POST['servicio'] ?? '') == 'Branding Completo') ? 'selected' : ''; ?>>Branding Completo</option>
                                <option value="SEO" <?php echo ($servicio_seleccionado == 'SEO' || ($_POST['servicio'] ?? '') == 'SEO') ? 'selected' : ''; ?>>SEO</option>
                                <option value="Mantenimiento Web" <?php echo ($servicio_seleccionado == 'Mantenimiento Web' || ($_POST['servicio'] ?? '') == 'Mantenimiento Web') ? 'selected' : ''; ?>>Mantenimiento Web</option>
                                <option value="Redes Sociales" <?php echo ($servicio_seleccionado == 'Redes Sociales' || ($_POST['servicio'] ?? '') == 'Redes Sociales') ? 'selected' : ''; ?>>Redes Sociales</option>
                                <option value="Otro" <?php echo ($servicio_seleccionado == 'Otro' || ($_POST['servicio'] ?? '') == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="mensaje"><?php echo __('contacto_mensaje'); ?> *</label>
                            <textarea id="mensaje" name="mensaje" rows="5" required><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn-submit"><?php echo __('contacto_enviar'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>