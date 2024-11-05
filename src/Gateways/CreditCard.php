<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class CreditCard implements PaymentGatewayInterface
{
    public function pay(float $amount, array $params = [], string $turl = ''): array
    {
        // $invoiceNo = $params['invoice_no'] ?? null;
        // $buyerEmail = $params['buyer_email'] ?? null;

        // Logika pembayaran menggunakan kartu kredit dengan URL yang telah disusun
        // return "Redirect to payment URL: $turl for invoice $invoiceNo.";

        // Proses pembayaran menggunakan kartu kredit
        // Misalnya, pembayaran berhasil
        $success = true;
        $msg = "Payment of $amount processed successfully via Credit Card.";
        $dataUrl = $turl;  // URL hasil transaksi atau URL untuk redirect

        return [
            "success" => $success,
            "message" => $msg,
            "data_url" => $dataUrl
        ];
    }
}
