<?php
require_once 'vendor/autoload.php';

use PaymentGateway\PaymentProcessor;
use PaymentGateway\Gateways\CreditCard;
use PaymentGateway\Gateways\CashOnDelivery;
use PaymentGateway\Gateways\BankTransfer;
use PaymentGateway\Gateways\PayPal;

$processor = new PaymentProcessor();

try {
    // Set Gateway berdasarkan payflow dan order
    // echo $processor->setGatewayByPayflowOrder(1, 13); // Akan memilih FPX untuk Malaysia

    // Set Gateway yang akan digunakan
    // $processor->setGateway('CreditCard');

    // Memproses pembayaran
    // echo $processor->processPayment(100.0);

    // Proses pembayaran dengan parameter dinamis
    // echo $processor->processPayment(100.0, [
    //     'invoice_no' => 'INV123456',
    //     'code' => 'CC01',
    //     'lang' => 'EN',
    //     'buyer_email' => 'buyer@example.com',
    //     'buyer_fullname' => 'John Doe',
    //     'buyer_address' => '123 Main Street',
    //     'buyer_state' => 'Selangor',
    //     'buyer_city' => 'Shah Alam',
    //     'bank_url' => 'https://bank.example.com/creditcard',
    //     'return_url' => 'https://yourapp.com/payment/success',
    //     'fail_url' => 'https://yourapp.com/payment/fail',
    //     'cancel_url' => 'https://yourapp.com/payment/cancel',
    //     'notify_url' => 'https://yourapp.com/payment/notify',
    // ]);

    // MY - CCD
    // echo $processor->setGatewayByPayflowOrder(1, 1);

    // Set Gateway yang akan digunakan
    $processor->setGateway('CreditCard');

    // Proses pembayaran dengan parameter dinamis
    $jsonResponse = $processor->processPayment(100.0, [
        'invoice_no' => 'INV123456',
        'code' => 'CC01',
        'buyer_country_id' => 'MY',
        'buyer_cctype' => 'VISA',
    ]);

    // Output JSON response
    echo $jsonResponse;
} catch (Exception $e) {
    // echo "Error: " . $e->getMessage();
    echo json_encode([
        "success" => false,
        "msg" => $e->getMessage(),
        "reff" => null,
        "data" => null,
        "turl" => null
    ]);
}

// Contoh pemakaian dengan metode Credit Card
// $creditCardGateway = new CreditCard();
// $processor = new PaymentProcessor($creditCardGateway);
// echo $processor->processPayment(100.0); // Output: Payment of 100 via Credit Card processed.

// Contoh pemakaian dengan metode Cash On Delivery
// $cashOnDeliveryGateway = new CashOnDelivery();
// $processor = new PaymentProcessor($cashOnDeliveryGateway);
// echo $processor->processPayment(50.0); // Output: Payment of 50 via Cash on Delivery processed.

// Contoh pemakaian dengan metode Bank Transfer
// $bankTransferGateway = new BankTransfer();
// $processor = new PaymentProcessor($bankTransferGateway);
// echo $processor->processPayment(250.0); // Output: Payment of 250 via Bank Transfer processed.

// Contoh pemakaian dengan metode PayPal
// $paypalGateway = new PayPal();
// $processor = new PaymentProcessor($paypalGateway);
// echo $processor->processPayment(300.0); // Output: Payment of 300 via PayPal processed.
