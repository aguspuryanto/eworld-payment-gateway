<?php
    /*
    // order = 1, CCD : Credit Card
    // order = 3, CSH : Cash On Delivery
    // order = 4, BTR : Bank Transfer
    // order = 5, PPL : PayPal
    // order = 6, EWL : Epoint
    // order = 8, B2C
    // order = 9, CLK : CIMB Clicks
    // order = 11, PNI : Network International
    // order = 12, SFT
    // order = 13, FPX
    // order = 14, TVB
    // order = 15, SQR
    // order = 16, TTR
    // order = 17, NSP
    // order = 18, OTP : OTP Bank
    // order = 19, ALP : Alpha Bank
    // order = 20, PPP : PayPal Plus
    // order = 21, COC : Cash On Counter
    // order = 22, GRT : Garanti Bank
    // order = 23, ESY : EasyPay
    // order = 24, ALPMP : MasterPass
    // order = 25, RDS : Redsys
    // order = 26, GRTP : Garanti Pay
    // order = 27, FDS : First Data
    // order = 28, INT : Interac Online Payment
    // order = 29, BRC : Borica
    // order = 30, BCL : Barclays Bank
    // order = 31, CSOB : CZ payment
    // order = 32, DTP : DotPay (PL payment)
    // order = 33, BBL : Bangkok Bank iPay
    // order = 34, CMI -> Morroco
    // order = 35, NGS -> N-Genius (AE)
    // order = 36, WLI : WL-IPG
    // order = 37, SIA : SIA VPOS
    // order = 38, MFT : MyFatoorah
    // order = 39, EBC : CyberSource
    // order = 41, SPP : SimplePay
    // order = 42, PYU : PayU India
    // order = 46, NTP : Netopia
    //
    // payflow = 1, Malaysia
    // payflow = 2, Gulf - UAE
    // payflow = 3, Slovakia and EU Networkers
    // payflow = 4, Germany (old - now not used)
    // payflow = 6, HongKong
    // payflow = 7, Spain
    // payflow = 8, Czek
    // payflow = 9, Austria
    // payflow = 10, UK/GB
    // payflow = 11-12, AU and NZ
    // payflow = 13, Mexico
    // payflow = 14, USA Networker
    // payflow = 15, Puerto Rico
    // payflow = 16, BG
    // payflow = 17, GR
    // payflow = 18, TR
    // payflow = 19, IT
    // payflow = 20, TH
    // payflow = 21, CA
    // payflow = 22, US
    // payflow = 23, PL
    // payflow = 24, HU
    // payflow = 25, SG
    // payflow = 26, CO (Columbia)
    // payflow = 27, MA (Marrocco)
    // payflow = 28, SE
    // payflow = 29, RO (Romania)
    // payflow = 30, PK (Pakistan)
    // payflow = 31, PA (Panama)
    // payflow = 32, DI (India)
    // payflow = 33, PH
    // payflow = 34, MN
    // payflow = 35, ZA (South Africa)
    // payflow = 36, EC
    // payflow = 37, NG (Panama)
    // payflow = 38, BO (Bolivia)
    // payflow = 39, PE
    // payflow = 40, KW
    // payflow = 41, SA
    // payflow = 42, BH
    // payflow = 51, AT
    // payflow = 52, NE
    // payflow = 53, CH
    // payflow = 54, LU
    // payflow = 55, NL
    // payflow = 56, DE
    // payflow = 57, KG
    // payflow = 58, BR
    // payflow = 99, ID
    */

return [
    'payflows' => [
        1 => [ // Malaysia
            'country' => 'Malaysia',
            'orders' => [
                1 => [
                    'gateway' => 'CreditCard',   // CCD
                    'bank_url' => 'https://bank.malaysia/ccd',
                    'return_url' => 'https://yourapp.com/payment/success',
                    'fail_url' => 'https://yourapp.com/payment/fail',
                    'cancel_url' => 'https://yourapp.com/payment/cancel',
                    'notify_url' => 'https://yourapp.com/payment/notify',
                ],
                9 => [
                    'gateway' => 'CIMBClicks',   // CLK
                    'bank_url' => 'https://cimbclicks.malaysia.com',
                    'return_url' => 'https://yourapp.com/payment/success',
                    'fail_url' => 'https://yourapp.com/payment/fail',
                    'cancel_url' => 'https://yourapp.com/payment/cancel',
                    'notify_url' => 'https://yourapp.com/payment/notify',
                ],
                13 => [
                    'gateway' => 'FPX',          // FPX
                    'bank_url' => 'https://fpx.malaysia.com',
                    'return_url' => 'https://yourapp.com/payment/success',
                    'fail_url' => 'https://yourapp.com/payment/fail',
                    'cancel_url' => 'https://yourapp.com/payment/cancel',
                    'notify_url' => 'https://yourapp.com/payment/notify',
                ],
                3 => 'CashOnDelivery',    // CSH
                4 => 'BankTransfer',      // BTR
                5 => 'PayPal',            // PPL
                6 => 'Epoint',            // EWL
                8 => 'B2C',               // B2C
            ],
        ],
        2 => [ // Gulf - UAE
            'country' => 'UAE',
            'orders' => [
                1 => 'CreditCard',          // CCD
                5 => 'PayPal',              // PPL
                11 => 'NetworkInternational', // PNI
                35 => 'NGenius',            // NGS
            ],
        ],
        3 => [ // Slovakia and EU Networkers
            'country' => 'Slovakia',
            'orders' => [
                18 => 'OTPBank',           // OTP
                19 => 'AlphaBank',         // ALP
                23 => 'EasyPay',           // ESY
            ],
        ],
        7 => [ // Spain
            'country' => 'Spain',
            'orders' => [
                25 => 'Redsys',            // RDS
                27 => 'FirstData',         // FDS
                30 => 'BarclaysBank',      // BCL
            ],
        ],
        10 => [ // UK/GB
            'country' => 'United Kingdom',
            'orders' => [
                1 => 'CreditCard',        // CCD
                28 => 'InteracOnline',    // INT
                20 => 'PayPalPlus',       // PPP
                30 => 'BarclaysBank',     // BCL
            ],
        ],
        11 => [ // AU and NZ
            'country' => 'Australia and New Zealand',
            'orders' => [
                1 => 'CreditCard',        // CCD
                5 => 'PayPal',            // PPL
                20 => 'PayPalPlus',       // PPP
                21 => 'CashOnCounter',    // COC
            ],
        ],
        32 => [ // India
            'country' => 'India',
            'orders' => [
                42 => 'PayU',             // PYU
                33 => 'DotPay',           // DTP
                6 => 'Epoint',            // EWL
            ],
        ],
        35 => [ // South Africa
            'country' => 'South Africa',
            'orders' => [
                36 => 'WLIPG',            // WLI
                38 => 'MyFatoorah',       // MFT
            ],
        ],
        // Tambahkan payflow lainnya di sini sesuai kebutuhan
        // ...
    ],
    'paypal' => [
        'client_id' => 'YOUR_PAYPAL_CLIENT_ID',
        'secret' => 'YOUR_PAYPAL_SECRET',
    ],
    'bank_transfer' => [
        'account_number' => 'YOUR_BANK_ACCOUNT',
        'swift_code' => 'YOUR_SWIFT_CODE',
    ],
    'api_key' => 'YOUR_API_KEY_HERE',  // API Key untuk beberapa gateway, jika diperlukan
    'default_notify_url' => 'https://yourapp.com/payment/notify',
];
