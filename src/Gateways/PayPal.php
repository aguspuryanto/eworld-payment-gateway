<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class PayPal implements PaymentGatewayInterface
{
    public function pay(float $amount): string
    {
        // Logika untuk PayPal (integrasi API PayPal)
        return "Payment of $amount via PayPal processed.";
    }
}
