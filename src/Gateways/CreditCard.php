<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class CreditCard implements PaymentGatewayInterface
{
    public function pay(float $amount): string
    {
        // Logika pembayaran menggunakan kartu kredit
        return "Payment of $amount via Credit Card processed.";
    }
}
