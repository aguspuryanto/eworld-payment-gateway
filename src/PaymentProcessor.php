<?php
namespace PaymentGateway;

use PaymentGateway\Gateways\CreditCard;
use PaymentGateway\Gateways\BankTransfer;
use PaymentGateway\Gateways\PayPal;

class PaymentProcessor
{
    private $gateway;
    private $config;
    private $paymentParams;

    public function __construct()
    {
        // Membaca konfigurasi umum dari config.php
        $this->config = require 'config.php';
    }

    public function setGatewayByPayflowOrder(int $payflow, int $order)
    {
        // Memeriksa apakah payflow dan order valid dalam konfigurasi
        if (isset($this->config['payflows'][$payflow])) {
            $payflowConfig = $this->config['payflows'][$payflow];
            
            if (isset($payflowConfig['orders'][$order])) {
                $orderConfig = $payflowConfig['orders'][$order];
                $gatewayName = $payflowConfig['orders'][$order];

                $this->setGateway($gatewayName);
                
                // Menyimpan parameter pembayaran tambahan
                $this->paymentParams = [
                    'bank_url' => $orderConfig['bank_url'],
                    'return_url' => $orderConfig['return_url'],
                    'fail_url' => $orderConfig['fail_url'],
                    'cancel_url' => $orderConfig['cancel_url'],
                    'notify_url' => $orderConfig['notify_url'],
                ];
            } else {
                throw new \Exception("Order tidak ditemukan untuk payflow: $payflow");
            }
        } else {
            throw new \Exception("Payflow tidak ditemukan.");
        }
    }

    public function setGateway($gatewayName)
    {
        // Menentukan gateway berdasarkan nama
        switch ($gatewayName) {
            case 'CreditCard':
                $this->gateway = new CreditCard();
                break;
            case 'BankTransfer':
                $this->gateway = new BankTransfer();
                break;
            case 'PayPal':
                $this->gateway = new PayPal();
                break;
            default:
                throw new \Exception("Gateway tidak dikenal: $gatewayName");
        }
    }

    public function processPayment(float $amount, array $params): string
    {
        if (!$this->gateway) {
            throw new \Exception("Payment gateway belum diatur.");
        }

        // Menentukan nilai default base_url
        $baseUrl = $this->config['base_url'] ?? 'https://defaulturl.com/';

        // Menyusun parameter ke dalam query string
        $queryParams = [
            'invNo' => $params['invoice_no'] ?? '',
            'amt' => $amount,
            'memcode' => $params['code'] ?? '',
            'cn_id' => $params['buyer_country_id'] ?? '',
            'cctype' => $params['buyer_cctype'] ?? '',
        ];

        // Membuat reference number acak
        $xrandom = rand(100000, 999999);

        //MY 
        if ($mb_payflow == 1) {
            // MY - CCD
            if ($mb_order == 1) {
                // Menggabungkan query string dan URL
                $turl = $baseUrl . "payment/PBB/pbb_go.php?" . http_build_query($queryParams) . "&payref=$xrandom";
            }
        }

        // Jalankan proses pembayaran dan dapatkan respon dari gateway
        $paymentResponse = $this->gateway->pay($amount, $params, $turl);

        // Menentukan status sukses atau gagal dan pesan yang sesuai
        $success = $paymentResponse['success'] ?? false;
        $msg = $paymentResponse['message'] ?? 'Payment processing failed';
        $url = $paymentResponse['data_url'] ?? '';

        // Susun hasil JSON
        $return = json_encode([
            "success" => $success,
            "msg" => $msg,
            "reff" => $xrandom,
            "data" => $url,
            "turl" => $turl
        ]);

        return $return;
    }
}
