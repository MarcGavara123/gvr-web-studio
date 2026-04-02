<?php
require_once '../includes/config.php';
require_once '../includes/lang.php'; // Añadido para idiomas
require_once '../includes/stripe-config.php';

header('Content-Type: application/json');

$token = $_POST['stripeToken'] ?? '';
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$servicio = $_POST['servicio'] ?? '';
$monto = intval($_POST['monto'] ?? 0);

if (!$token) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_token')]);
    exit;
}

if (!$nombre || !$email) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_datos')]);
    exit;
}

if ($monto <= 0) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_monto')]);
    exit;
}

try {
    $charge = \Stripe\Charge::create([
        'amount' => $monto,
        'currency' => 'eur',
        'description' => $servicio . ' - GVR Web Studio',
        'source' => $token,
        'receipt_email' => $email,
        'metadata' => [
            'servicio' => $servicio,
            'cliente' => $nombre,
            'email' => $email
        ]
    ]);
    
    $sql = "INSERT INTO pagos (servicio, monto, cliente_nombre, cliente_email, stripe_id, estado, created_at)
            VALUES (?, ?, ?, ?, ?, 'completado', NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsss", $servicio, $monto, $nombre, $email, $charge->id);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => __('procesar_exito')
        ]);
    } else {
        error_log("Pago Stripe ID: {$charge->id} no guardado en BD");
        echo json_encode([
            'success' => true,
            'charge_id' => $charge->id,
            'message' => __('procesar_exito_sin_guardar')
        ]);
    }
    
    $stmt->close();
    
} catch (\Stripe\Exception\CardException $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_tarjeta') . ' ' . $e->getMessage()]);
    
} catch (\Stripe\Exception\RateLimitException $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_limite')]);
    
} catch (\Stripe\Exception\InvalidRequestException $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_solicitud')]);
    
} catch (\Stripe\Exception\AuthenticationException $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_autenticacion')]);
    
} catch (\Stripe\Exception\ApiConnectionException $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_conexion')]);
    
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_servidor')]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => __('procesar_error_general') . ' ' . $e->getMessage()]);
}
?>