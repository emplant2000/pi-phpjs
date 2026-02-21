<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PiApp\PiApi;
use PiApp\PaymentServer;

$PI_API_KEY = getenv('PI_API_KEY');

$api = new PiApi($PI_API_KEY);
$server = new PaymentServer($api);

$payment = $server->createPayment(
    uid: "test-user-123",
    amount: "1.5",
    memo: "PHP demo payment",
    metadata: ["orderId" => "ORDER-999"]
);

header('Content-Type: application/json');
echo json_encode($payment);
