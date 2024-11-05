<?php
namespace PaymentGateway;

use PaymentGateway\Gateways\BankTransfer;
use PaymentGateway\Gateways\CreditCard;
use PaymentGateway\Gateways\PayPal;

class PaymentProcessor
{
    private $gateway;
    private $config;
    private $paymentParams;

    private $payflows;
    private $payflows_orders;

    // public function __construct(PaymentGatewayInterface $gateway)
    // {
    //     $this->gateway = $gateway;
    // }
    
    public function __construct()
    {
        // Membaca konfigurasi dari config.php
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
                
                // Menentukan gateway berdasarkan nama dalam konfigurasi
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
                
                // Menyimpan parameter pembayaran tambahan
                $this->paymentParams = [
                    'bank_url' => $orderConfig['bank_url'],
                    'return_url' => $orderConfig['return_url'],
                    'fail_url' => $orderConfig['fail_url'],
                    'cancel_url' => $orderConfig['cancel_url'],
                    'notify_url' => $orderConfig['notify_url'],
                ];

                return "Selected payment gateway: $gatewayName for {$payflowConfig['country']}.";
            } else {
                throw new \Exception("Order tidak ditemukan untuk payflow: $payflow");
            }
        } else {
            throw new \Exception("Payflow tidak ditemukan.");
        }

        // Set payflow dan payflows_order
        // $this->payflows = $payflow;
        // $this->payflows_orders = $order;
    }

    public function processPayment(float $amount): string
    {
        // return $this->gateway->pay($amount);
        if ($this->gateway) {
            // Di sini kita dapat menggunakan parameter tambahan, misalnya:
            $bankUrl = $this->paymentParams['bank_url'];
            $returnUrl = $this->paymentParams['return_url'];
            $failUrl = $this->paymentParams['fail_url'];
            $cancelUrl = $this->paymentParams['cancel_url'];
            $notifyUrl = $this->paymentParams['notify_url'];

            // Misalnya, mengirimkan parameter ke gateway pembayaran
            return $this->gateway->pay($amount, [
                'bank_url' => $bankUrl,
                'return_url' => $returnUrl,
                'fail_url' => $failUrl,
                'cancel_url' => $cancelUrl,
                'notify_url' => $notifyUrl,
            ]);
        }
        
        throw new \Exception("Payment gateway belum diatur.");
    }
}
