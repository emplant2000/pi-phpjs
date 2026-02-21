<?php
namespace PiApp;

class WebhookHandler
{
    private string $appSecret;

    public function __construct(string $appSecret)
    {
        $this->appSecret = $appSecret;
    }

    public function verifySignature(string $rawBody, string $signature): bool
    {
        $expected = hash_hmac('sha256', $rawBody, $this->appSecret);
        return hash_equals($expected, $signature);
    }
}
