<?php
namespace PaymentGateway;

class PaymentProcessor
{
    private $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processPayment(float $amount): string
    {
        return $this->gateway->pay($amount);
    }
}
