<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class BankTransfer implements PaymentGatewayInterface
{
    public function pay(float $amount): string
    {
        // Logika untuk transfer bank
        return "Payment of $amount via Bank Transfer processed.";
    }
}
