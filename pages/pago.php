<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas
require_once '../includes/stripe-config.php';

// Obtener servicio de la URL y decodificarlo
$servicio = isset($_GET['servicio']) ? urldecode($_GET['servicio']) : '';
$precio = 0;

// Precios predefinidos (en céntimos)
$precios = [
    'Diseño Web Profesional' => 50000,
    'Diseño de Logotipos' => 20000,
    'Branding Completo' => 40000,
    'SEO' => 30000,
    'Mantenimiento Web' => 5000,
    'Community Management' => 25000,
    'Redes sociales' => 25000
];

// Verificar si el servicio existe en el array
if (isset($precios[$servicio])) {
    $precio = $precios[$servicio];
} else {
    echo "<!-- DEBUG: Servicio recibido = '$servicio' -->";
}

$monto_euros = $precio / 100;

$page_title = __('pago_titulo_pagina') . ' - GVR Web Studio';
include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1><?php echo __('pago_titulo'); ?></h1>
        <p><?php echo __('pago_subtitulo'); ?></p>
    </div>
</section>

<section class="payment-page">
    <div class="container">
        <div class="payment-wrapper">
            <div class="payment-summary">
                <h3><?php echo __('pago_resumen'); ?></h3>
                <div class="summary-item">
                    <span><?php echo __('pago_servicio'); ?></span>
                    <strong><?php echo htmlspecialchars($servicio); ?></strong>
                </div>
                <div class="summary-item total">
                    <span><?php echo __('pago_total'); ?></span>
                    <strong class="price"><?php echo number_format($monto_euros, 2); ?> €</strong>
                </div>
            </div>
            
            <div class="payment-form-container">
                <h3><?php echo __('pago_detalles'); ?></h3>
                <form id="payment-form">
                    <div class="form-group">
                        <label for="nombre"><?php echo __('pago_nombre'); ?> *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="<?php echo __('pago_nombre_placeholder'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><?php echo __('pago_email'); ?> *</label>
                        <input type="email" id="email" name="email" required placeholder="<?php echo __('pago_email_placeholder'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo __('pago_tarjeta'); ?> *</label>
                        <div id="card-element" class="stripe-card-element"></div>
                        <div id="card-errors" class="error-message"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large" id="submit-button">
                        <?php echo __('pago_boton', [number_format($monto_euros, 2)]); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.payment-page {
    padding: 60px 0;
    background: #f9fafb;
    min-height: 80vh;
}

.payment-wrapper {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.payment-summary, .payment-form-container {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.payment-summary h3, .payment-form-container h3 {
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #6366f1;
    font-size: 1.3rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.summary-item.total {
    border-bottom: none;
    margin-top: 0.5rem;
    font-size: 1.2rem;
}

.summary-item .price {
    color: #6366f1;
    font-size: 1.3rem;
    font-weight: 700;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #1f2937;
}

.form-group input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-group input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.stripe-card-element {
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    background: white;
    transition: all 0.3s ease;
    min-height: 48px;
}

.stripe-card-element:focus-within {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.error-message {
    color: #ef4444;
    margin-top: 0.5rem;
    font-size: 0.85rem;
}

#submit-button {
    width: 100%;
    margin-top: 1rem;
    cursor: pointer;
    font-size: 1.1rem;
    padding: 14px;
}

#submit-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .payment-wrapper {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Stripe iniciando...');
    
    const publicKey = '<?php echo $stripe_public_key; ?>';
    console.log('Clave pública:', publicKey.substring(0, 15) + '...');
    
    if (!publicKey || publicKey === 'pk_test_CAMBIA_ESTA_CLAVE') {
        document.getElementById('card-errors').textContent = '<?php echo __('pago_error_config'); ?>';
        return;
    }
    
    const stripe = Stripe(publicKey);
    const elements = stripe.elements();
    
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                fontFamily: 'Poppins, sans-serif',
                color: '#1f2937',
                '::placeholder': {
                    color: '#9ca3af'
                }
            },
            invalid: {
                color: '#ef4444',
                iconColor: '#ef4444'
            }
        },
        hidePostalCode: true
    });
    
    cardElement.mount('#card-element');
    console.log('Elemento de tarjeta montado');
    
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = '<?php echo __('pago_procesando'); ?>';
        
        const nombre = document.getElementById('nombre').value;
        const email = document.getElementById('email').value;
        const servicio = '<?php echo addslashes($servicio); ?>';
        const monto = <?php echo $precio; ?>;
        
        if (!nombre || !email) {
            document.getElementById('card-errors').textContent = '<?php echo __('pago_error_campos'); ?>';
            submitButton.disabled = false;
            submitButton.textContent = '<?php echo __('pago_boton', [number_format($monto_euros, 2)]); ?>';
            return;
        }
        
        console.log('Creando token...');
        const {token, error} = await stripe.createToken(cardElement, {
            name: nombre,
            email: email
        });
        
        if (error) {
            console.error('Error al crear token:', error);
            document.getElementById('card-errors').textContent = error.message;
            submitButton.disabled = false;
            submitButton.textContent = '<?php echo __('pago_boton', [number_format($monto_euros, 2)]); ?>';
        } else {
            console.log('Token creado:', token.id);
            
            const formData = new FormData();
            formData.append('stripeToken', token.id);
            formData.append('nombre', nombre);
            formData.append('email', email);
            formData.append('servicio', servicio);
            formData.append('monto', monto);
            
            fetch('procesar-pago.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                if (data.success) {
                    window.location.href = 'pago-exito.php?servicio=' + encodeURIComponent(servicio);
                } else {
                    document.getElementById('card-errors').textContent = data.error;
                    submitButton.disabled = false;
                    submitButton.textContent = '<?php echo __('pago_boton', [number_format($monto_euros, 2)]); ?>';
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                document.getElementById('card-errors').textContent = '<?php echo __('pago_error_procesar'); ?>';
                submitButton.disabled = false;
                submitButton.textContent = '<?php echo __('pago_boton', [number_format($monto_euros, 2)]); ?>';
            });
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>