<?php
namespace PaymentGateway;

use PaymentGateway\Gateways\CreditCard;
use PaymentGateway\Gateways\BankTransfer;
use PaymentGateway\Gateways\Epoint;
use PaymentGateway\Gateways\MPGS;
use PaymentGateway\Gateways\PayPal;

class PaymentProcessor
{
    private $gateway;
    private $config;
    private $paymentParams;
    private $baseUrl = 'https://ew-dev.dxn2u.com/ajax-api/';

    private $mb_payflow;
    private $mb_order;

    public function __construct()
    {
        // Membaca konfigurasi umum dari config.php
        $this->config = require 'config.php';

        if(isset($this->config['baseUrl'])) {
            $this->baseUrl = $this->config['baseUrl'];
        }
    }

    public function setGatewayByPayflowOrder(int $payflow, int $order)
    {
        $this->mb_payflow = $payflow;
        $this->mb_order = $order;

        // Memeriksa apakah payflow dan order valid dalam konfigurasi
        if (isset($this->config['payflows'][$payflow])) {
            $payflowConfig = $this->config['payflows'][$payflow];
            
            if (isset($payflowConfig['orders'][$order])) {
                $gatewayName = $payflowConfig['orders'][$order];

                $this->setGateway($gatewayName);
            } else {
                throw new \Exception("Order tidak ditemukan untuk payflow: $payflow");
            }
        } else {
            throw new \Exception("Payflow tidak ditemukan.");
        }
    }

    public function setGateway($gatewayName, $opt = [])
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
            case 'Epoint':
                $this->gateway = new Epoint();
                break;
            case 'MPGS':
                $this->gateway = new MPGS($opt);
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

        // Membuat reference number acak
        $xrandom = $params['mb_invno'] . $this->RandomString(64);

        // MY 
        if ($this->mb_payflow == 1) {
            // MY - CCD
            if ($this->mb_order == 1) {
                $turl = $this->baseUrl . "payment/PBB/pbb_go.php?payref=$xrandom";
            }
        }

        // PH
        if ($this->mb_payflow == 33) {
            // PH - MPGS
            if ($this->mb_order == 45) {
                $turl = $this->baseUrl . "payment/MPGS/go_mpgs.php?ref=$xrandom";
            }
        }

        // Jalankan proses pembayaran dan dapatkan respon dari gateway
        $paymentResponse = $this->gateway->pay($amount, $params, $turl);

        // Menentukan status sukses atau gagal dan pesan yang sesuai
        $success = $paymentResponse['success'] ?? false;
        $msg = $paymentResponse['message'] ?? 'Payment processing failed';
        // $url = $paymentResponse['data_url'] ?? '';

        // Susun hasil JSON
        // $return = '{"success":' . $success . ', "msg":"' . $msg . '", "reff":"' . $xrandom . '", "data":"' . $url . '", "turl":"' . $turl . '"}';

        $return = json_encode([
            "success" => $success,
            "msg" => $msg,
            "reff" => $xrandom,
            "data" => $turl,
            "turl" => $turl
        ]);

        return $return;
    }

    public function RandomString($length) {
        $original_string = implode("", array_merge(range(0, 9), range('a', 'z'), range('A', 'Z')));

        return substr(str_shuffle($original_string), 0, $length);
    }
}
