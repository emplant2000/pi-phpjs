<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PiApp\PiApi;
use PiApp\PaymentServer;
use PiApp\WebhookHandler;
use PiApp\WalletServer;

$PI_API_KEY    = getenv('PI_API_KEY');
$PI_APP_SECRET = getenv('PI_APP_SECRET');
$WALLET_SEED   = getenv('PI_WALLET_SEED');

$rawBody   = file_get_contents('php://input');
$headers   = getallheaders();
$signature = $headers['X-Pi-Signature'] ?? '';

$webhook = new WebhookHandler($PI_APP_SECRET);

if (!$webhook->verifySignature($rawBody, $signature)) {
    http_response_code(401);
    echo "Invalid signature";
    exit;
}

$payload = json_decode($rawBody, true);
$payment = $payload['payment'];
$status  = $payment['status'];
$paymentId = $payment['identifier'];

$api = new PiApi($PI_API_KEY);
$server = new PaymentServer($api);
$wallet = new WalletServer($WALLET_SEED, $server);

if ($status === 'approved') {
    $wallet->submitBlockchainPayment($paymentId);
}

echo "OK";
