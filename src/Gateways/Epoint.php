<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class Epoint implements PaymentGatewayInterface
{
    public function pay(float $amount, array $params = [], string $turl = ''): array
    {
        // Misalnya, pembayaran berhasil
        $success = true;
        $msg = "Payment of $amount processed successfully via Credit Card.";
        $dataUrl = $turl;  // URL hasil transaksi atau URL untuk redirect

        return [
            "success" => $success,
            "message" => $msg,
            "data_url" => $dataUrl
        ];
    }
}