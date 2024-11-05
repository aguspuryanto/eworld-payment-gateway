<?php
require_once 'vendor/autoload.php';

use PaymentGateway\PaymentProcessor;
use PaymentGateway\Gateways\CreditCard;
use PaymentGateway\Gateways\CashOnDelivery;
use PaymentGateway\Gateways\BankTransfer;
use PaymentGateway\Gateways\PayPal;

$processor = new PaymentProcessor();

try {

    /*
     * Skenario untuk MY - CCD
     * Payflow: 1
     * Order: 1
     * Gateway: CreditCard
     */

    // Set Gateway yang akan digunakan, berdasarkan payflow dan order
    echo $processor->setGatewayByPayflowOrder(1, 1);

    // Set Gateway yang akan digunakan
    // $processor->setGateway('CreditCard');

    // Proses pembayaran dengan parameter dinamis
    $params = [
        'mb_edisc_amt' => 100,
        'mb_invno' => '2404230019',
        'mb_code' => '826278698',
        'mb_shipcnt' => 'MY',
        'mb_cctype' => 'VISA'
    ];

    // Save into database, network.payment_redirection
    // $payRe = new paymentRedirection();
    // $payRe->memcode = $mb_code;
    // $payRe->trcd = $mb_invno;
    // $payRe->payment_method = $mb_order;
    // $payRe->response_url = $return_url;
    // $payRe->goto_url = $go_url;
    // $payRe->bank_url = $bank_url;
    // $payRe->reff_code = $xrandom;
    // $payRe->amount = $mb_edisc_amt;
    // $payRe->param = $params;
    // $payRe->country = $mb_shipcnt;
    // $payRe->cctype = $mb_cctype;

    $jsonResponse = $processor->processPayment($params['mb_edisc_amt'], $params);

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
