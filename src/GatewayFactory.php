<?php
namespace PaymentGateway;

class GatewayFactory
{
    public static function createGateway(string $gatewayName): PaymentGatewayInterface
    {
        switch ($gatewayName) {
            case 'CreditCard':
                return new Gateways\CreditCard();
            case 'BankTransfer':
                return new Gateways\BankTransfer();
            case 'PayPal':
                return new Gateways\PayPal();
            default:
                throw new \Exception("Gateway tidak dikenal: $gatewayName");
        }
    }
}
