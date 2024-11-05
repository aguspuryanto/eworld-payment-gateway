<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class CashOnDelivery implements PaymentGatewayInterface
{
    public function pay(float $amount): string
    {
        // Logika untuk Cash On Delivery
        return "Payment of $amount via Cash on Delivery processed.";
    }
}
