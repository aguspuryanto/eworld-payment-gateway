<?php
require_once 'vendor/autoload.php';

use PaymentGateway\PaymentProcessor;
use PaymentGateway\Gateways\CreditCard;

$processor = new PaymentProcessor(new CreditCard());
echo $processor->processPayment(100.0);
