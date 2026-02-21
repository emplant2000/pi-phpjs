<?php
namespace PiApp;

class WalletServer
{
    private string $seed;
    private PaymentServer $paymentServer;

    public function __construct(string $seed, PaymentServer $paymentServer)
    {
        $this->seed = $seed;
        $this->paymentServer = $paymentServer;
    }

    public function submitBlockchainPayment(string $paymentId)
    {
        $payment = $this->paymentServer->getPayment($paymentId);

        $amount    = $payment['amount'];
        $toAddress = $payment['to_address'];
        $memo      = $payment['memo'] ?? '';

        // ★ Stellar SDK を使うべきだが、ここでは疑似コード
        $txid = "dummy_txid_" . time();

        // 成功したと仮定
        $this->paymentServer->completePayment($paymentId, $txid);

        return $txid;
    }
}
