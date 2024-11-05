<?php
namespace PaymentGateway\Gateways;

use PaymentGateway\PaymentGatewayInterface;

class MPGS implements PaymentGatewayInterface
{

    private $apiUrl = "https://ap-gateway.mastercard.com/api/rest/";
    //public $apiUrlDev = "https://ap-gateway.mastercard.com/api/rest/";
    private $apiVersion = "version/83";
    private $merchantId = "TEST001710000576";
    private $apiUsername = "operator";
    //private $apiPassword = '2d7a3dc466d1a385f0c357f57f82314b';
    private $apiPassword = "1ec32fbf4363833e80ef00af7c071fa3";
    private $currency = "PHP";
    public $payLoad;
    public $apiResponse;

    public function __construct($merchantId = null, $apiUsername = null, $apiPassword = null) {
        $this->merchantId = ($merchantId == null) ? $this->merchantId : $merchantId;
        $this->apiPassword = ($apiPassword == null) ? $this->apiPassword : $apiPassword;
        $this->apiUsername = ($apiUsername == null) ? $this->apiUsername : $apiUsername;
    }

    public function setApiUrl($apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    public function setApiVersion($apiVersion) {
        $this->apiVersion = $apiVersion;
    }

    public function createCheckoutSession($opt = []) {
        //https://ap-gateway.mastercard.com/api/rest/version/83/merchant/{merchantId}/session
        $url = $this->apiUrl . $this->apiVersion . "/merchant/" . $this->merchantId . "/session";

        $payload = array(
            'apiOperation' => 'INITIATE_CHECKOUT',
            'interaction' => [
                'operation' => 'PURCHASE',
                'returnUrl' => $opt['successUrl'],
                'cancelUrl' => $opt['cancelUrl'],
                'redirectMerchantUrl' => $opt['cancelUrl'],
                'merchant' => [
                    'name' => 'DXN INTERNATIONAL IPG'
                ]
            ],
            'order' => [
                'currency' => $opt['currency'],
                'amount' => $opt['amount'],
                'id' => $opt['invno'],
                'reference' => $opt['invno'],
                'description' => 'Payment for invoice #' . $opt['invno'],
                'notificationUrl' => $opt['notificationUrl'],
            ]
        );

        if ($opt['email']) {
            $payload['customer']['email'] = $opt['email'];
        }

        if ($opt['firstName'] && $opt['lastName']) {
            $payload['customer']['firstName'] = $opt['firstName'];
            $payload['customer']['lastName'] = $opt['lastName'];
        }
        
        $this->payLoad = json_encode($payload);
        //$auth_key = base64_encode('merchant.' . $this->merchantId . ':' . $this->apiPassword);
        $auth_key = base64_encode('merchant.' . $this->merchantId . ':' . $this->apiPassword);
        $curl_header = array(
            "Content-Type: text/plain",
            "Authorization: Basic " . $auth_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        /* // Tambahkan opsi untuk debugging
          curl_setopt($ch, CURLOPT_VERBOSE, true);
          $verbose = fopen('php://temp', 'w+');
          curl_setopt($ch, CURLOPT_STDERR, $verbose); */

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            // error_log("Curl error: " . curl_error($ch));
            return curl_error($ch);
        }
        else {
            $this->apiResponse = $response;
        }

        curl_close($ch);

        if ($httpCode == 201) {
            $responseData = json_decode($response, true);
            return $responseData['session']['id'];
        }
        else {
            // error_log("MPGS API Error: " . $response);
            return $response;
        }
    }

    // $initiatePayment = new GatewayMPGS($merchantId, $apiUsername, $apiPassword);
    public function pay(float $amount, array $params = [], string $turl = ''): array
    {
        // Step 1: Create Checkout Session
        $sessionId = $this->createCheckoutSession($params);

        // Step 2: Redirect to Checkout
        if($sessionId) {
            $success = true;
            $msg = "Payment of $amount processed successfully via Credit Card.";
            $sessionId = $sessionId;  // URL hasil transaksi atau URL untuk redirect
        } else {
            $success = false;
            $msg = "Payment of $amount failed.";
            $sessionId = null;
        }

        return [
            "success" => $success,
            "message" => $msg,
            "sessionId" => $sessionId
        ];
    }
}
