<?php
namespace PiApp;

class PaymentServer
{
    private PiApi $api;

    public function __construct(PiApi $api)
    {
        $this->api = $api;
    }

    public function createPayment(string $uid, string $amount, string $memo, array $metadata): array
    {
        return $this->api->request('POST', 'payments', [
            'amount'   => $amount,
            'memo'     => $memo,
            'metadata' => $metadata,
            'uid'      => $uid,
        ]);
    }

    public function getPayment(string $paymentId): array
    {
        return $this->api->request('GET', "payments/{$paymentId}");
    }

    public function completePayment(string $paymentId, string $txid): array
    {
        return $this->api->request('POST', "payments/{$paymentId}/complete", [
            'txid' => $txid,
        ]);
    }

    public function cancelPayment(string $paymentId, string $reason): array
    {
        return $this->api->request('POST', "payments/{$paymentId}/cancel", [
            'reason' => $reason,
        ]);
    }
}
