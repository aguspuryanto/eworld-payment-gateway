<?php
namespace PaymentGateway;

interface PaymentGatewayInterface
{
    public function pay(float $amount): array;
}
