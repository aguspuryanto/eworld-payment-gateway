<?php
require_once 'vendor/autoload.php';

use PaymentGateway\PaymentProcessor;

$processor = new PaymentProcessor();

try {

    /*
     * Skenario untuk PH - CCD
     * Payflow: 33
     * Order: 45
     * Gateway: MPGS
     * Order: 48
     * Gateway: GCash
     */

    // Set Gateway yang akan digunakan, berdasarkan payflow dan order
    echo $processor->setGatewayByPayflowOrder(33, 45);

    $config = require 'config.php';
    $baseUrl = $config['baseUrl'];

    // Set Gateway yang akan digunakan
    $processor->setGateway('MPGS');

    // Proses pembayaran dengan parameter dinamis
    $myArray = [
        'amount' => 100,
        'invno' => '2404230019',
    ];

    $myArray['successUrl'] = $baseUrl . "payment/MPGS/return_success.php";
    $myArray['notificationUrl'] = $baseUrl . "payment/MPGS/return_notify.php";
    $myArray['redirectMerchantUrl'] = $baseUrl . "payment/MPGS/return_redirect.php";
    $myArray['cancelUrl'] = $baseUrl . "payment/MPGS/return_cancel.php";
    
    $params = [
        'currency' => 'PHP',
        'amount' => $myArray['amount'],
        'mb_invno' => $myArray['invno'],
        'invno' => $myArray['invno'],
        'successUrl' => $myArray['successUrl'],
        'cancelUrl' => $myArray['cancelUrl']."?invoice=".$myArray['invno'],
        'timeoutUrl' => $myArray['cancelUrl']."?invoice=".$myArray['invno'],
        'redirectMerchantUrl' => $myArray['redirectMerchantUrl'],
        'notificationUrl' => $myArray['notificationUrl']
    ];

    // for Visa
    // device.ipAddress, device.browserDetails.screenWidth, device.browserDetails.screenHeight
    $params['email'] = '8Hk7x@example.com';
    $params['firstName'] = 'John';
    $params['lastName'] = 'Doe';

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

    $jsonResponse = $processor->processPayment($params['amount'], $params);

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