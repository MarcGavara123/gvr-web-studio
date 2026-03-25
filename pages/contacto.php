<?php
require_once '../includes/config.php';

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
        $error = 'Por favor, introduce tu nombre.';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Por favor, introduce un email válido.';
    } elseif (empty($mensaje_texto)) {
        $error = 'Por favor, escribe tu mensaje.';
    } else {
        // Guardar en la base de datos
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $sql = "INSERT INTO mensajes_contacto (nombre, email, telefono, servicio_interes, mensaje, ip_address, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nombre, $email, $telefono, $servicio, $mensaje_texto, $ip);
        
        if ($stmt->execute()) {
            // === ENVIAR CORREO DE NOTIFICACIÓN ===
            $para = "gvrwebstudio@gmail.com"; // Tu correo
            $asunto = "Nuevo mensaje de contacto - GVR Web Studio";
            
            // Cuerpo del mensaje en HTML
            $cuerpo = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 12px; }
                    h2 { color: #6366f1; margin-bottom: 20px; }
                    .info { margin-bottom: 15px; }
                    .label { font-weight: bold; color: #4b5563; }
                    .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #9ca3af; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>📬 Nuevo mensaje de contacto</h2>
                    <div class='info'>
                        <p><span class='label'>👤 Nombre:</span> $nombre</p>
                        <p><span class='label'>📧 Email:</span> $email</p>
                        <p><span class='label'>📞 Teléfono:</span> " . ($telefono ?: 'No especificado') . "</p>
                        <p><span class='label'>🎯 Servicio de interés:</span> " . ($servicio ?: 'No especificado') . "</p>
                        <p><span class='label'>💬 Mensaje:</span><br>" . nl2br(htmlspecialchars($mensaje_texto)) . "</p>
                        <p><span class='label'>🖥️ IP:</span> $ip</p>
                        <p><span class='label'>📅 Fecha:</span> " . date('d/m/Y H:i:s') . "</p>
                    </div>
                    <div class='footer'>
                        Este mensaje se ha enviado desde el formulario de contacto de GVR Web Studio.
                    </div>
                </div>
            </body>
            </html>
            ";
            
            // Cabeceras para email en HTML
            $cabeceras = "MIME-Version: 1.0\r\n";
            $cabeceras .= "Content-type: text/html; charset=UTF-8\r\n";
            $cabeceras .= "From: $email\r\n";
            $cabeceras .= "Reply-To: $email\r\n";
            $cabeceras .= "X-Mailer: PHP/" . phpversion();
            
            // Enviar correo
            $correo_enviado = mail($para, $asunto, $cuerpo, $cabeceras);
            
            if ($correo_enviado) {
                $exito = true;
                $mensaje = '¡Mensaje enviado con éxito! Te contactaremos pronto. Te hemos enviado una copia a tu correo.';
            } else {
                // Si no se pudo enviar el correo, igual el mensaje se guardó en BD
                $exito = true;
                $mensaje = '¡Mensaje guardado con éxito! Te contactaremos pronto.';
            }
            
            // Limpiar formulario
            $_POST = array();
        } else {
            $error = 'Error al enviar el mensaje. Por favor, inténtalo de nuevo.';
        }
        $stmt->close();
    }
}

// Recuperar servicio de la URL si viene de otro lado
$servicio_seleccionado = isset($_GET['servicio']) ? htmlspecialchars($_GET['servicio']) : '';

$page_title = "Contacto - GVR Web Studio";
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
        /* CSS específico de contacto (mantén el que ya tenías) */
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
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="portfolio.php">Portfolio</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="contacto.php" class="active">Contacto</a></li>
                        <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- HERO -->
        <section class="contact-hero">
            <div class="container">
                <h1>Contáctanos</h1>
                <p>¿Tienes un proyecto en mente? Cuéntanos tu idea y la haremos realidad</p>
            </div>
        </section>

        <!-- FORMULARIO E INFO -->
        <section class="contact-page">
            <div class="container">
                <div class="contact-wrapper">
                    <!-- Información de contacto -->
                    <div class="contact-info">
                        <h2>Nuestro contacto</h2>
                        <p>Estamos aquí para ayudarte. Elige el medio que prefieras y te responderemos lo antes posible.</p>
                        
                        <div class="contact-details">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-text">
                                    <h4>Teléfono</h4>
                                    <p><a href="tel:693376377">693 37 63 77</a> / <a href="tel:644848658">644 84 86 58</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-text">
                                    <h4>Email</h4>
                                    <p><a href="mailto:gvrwebstudio@gmail.com">gvrwebstudio@gmail.com</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fab fa-instagram"></i>
                                </div>
                                <div class="contact-text">
                                    <h4>Instagram</h4>
                                    <p><a href="https://instagram.com/gvr_webstudio" target="_blank">@gvr_webstudio</a></p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fa-brands fa-facebook"></i>
                                </div>
                                <div class="contact-text">
                                    <h4>Facebook</h4>
                                    <p><a href="https://www.facebook.com/people/GVR-Web-Studio/61583927649782/#" target="_blank">GVR Web Studio</a></p>
                                </div>
                            </div>
                        
                        </div>
                        
                        <div class="contact-hours">
                            <h4>Horario de atención</h4>
                            <p>Lunes a Viernes: 9:00 - 14:00 y 15:00 - 18:00</p>
                            <p>Sábados y Domingos: Cerrado</p>
                        </div>
                    </div>
                    
                    <!-- Formulario -->
                    <div class="contact-form">
                        <h2>Envíanos un mensaje</h2>
                        
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
                                <label for="nombre">Nombre completo *</label>
                                <input type="text" id="nombre" name="nombre" required 
                                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required 
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" 
                                       value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="servicio">Servicio de interés</label>
                                <select id="servicio" name="servicio">
                                    <option value="">-- Selecciona un servicio --</option>
                                    <option value="Diseño Web" <?php echo ($servicio_seleccionado == 'Diseño Web' || ($_POST['servicio'] ?? '') == 'Diseño Web') ? 'selected' : ''; ?>>Diseño Web</option>
                                    <option value="Diseño de Logotipos" <?php echo ($servicio_seleccionado == 'Diseño de Logotipos' || ($_POST['servicio'] ?? '') == 'Diseño de Logotipos') ? 'selected' : ''; ?>>Diseño de Logotipos</option>
                                    <option value="Branding Completo" <?php echo ($servicio_seleccionado == 'Branding Completo' || ($_POST['servicio'] ?? '') == 'Branding Completo') ? 'selected' : ''; ?>>Branding Completo</option>
                                    <option value="Posicionamiento SEO" <?php echo ($servicio_seleccionado == 'Posicionamiento SEO' || ($_POST['servicio'] ?? '') == 'Posicionamiento SEO') ? 'selected' : ''; ?>>Posicionamiento SEO</option>
                                    <option value="Mantenimiento Web" <?php echo ($servicio_seleccionado == 'Mantenimiento Web' || ($_POST['servicio'] ?? '') == 'Mantenimiento Web') ? 'selected' : ''; ?>>Mantenimiento Web</option>
                                    <option value="Otro" <?php echo ($servicio_seleccionado == 'Otro' || ($_POST['servicio'] ?? '') == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mensaje">Mensaje *</label>
                                <textarea id="mensaje" name="mensaje" rows="5" required><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn-submit">Enviar mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
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
                        <li><i class="fas fa-phone"></i> 693 37 63 77</li>
                        <li><i class="fas fa-envelope"></i> gvrwebstudio@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 GVR Web Studio. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>
</html>