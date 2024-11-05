<?php
namespace PaymentGateway;

/*
 * Service Locator Pattern
 * Pattern ini cocok jika paket Anda akan memiliki beberapa layanan tambahan, misalnya layanan otentikasi atau logging khusus untuk setiap gateway. ServiceLocator bertindak sebagai register pusat untuk menyimpan dan menyediakan layanan atau gateway yang berbeda.
 */

class ServiceLocator
{
    private static $services = [];

    public static function register($name, $service)
    {
        self::$services[$name] = $service;
    }

    public static function get($name)
    {
        if (!isset(self::$services[$name])) {
            throw new \Exception("Service $name tidak terdaftar.");
        }
        return self::$services[$name];
    }
}
/*
 * Usage : 
 * ServiceLocator::register('credit_card', new Gateways\CreditCard());
 * ServiceLocator::register('bank_transfer', new Gateways\BankTransfer());
 * PaymentProcessor kemudian dapat memanggil gateway melalui ServiceLocator::get('credit_card'
 * End of file ServiceLocator.php
 */