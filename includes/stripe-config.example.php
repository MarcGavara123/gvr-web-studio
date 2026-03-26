<?php
require_once __DIR__ . '/../vendor/autoload.php';

// COPIA ESTE ARCHIVO COMO stripe-config.php Y AÑADE TUS CLAVES REALES
$stripe_secret_key = 'sk_test_CAMBIA_ESTA_CLAVE';
$stripe_public_key = 'pk_test_CAMBIA_ESTA_CLAVE';

\Stripe\Stripe::setApiKey($stripe_secret_key);
?>