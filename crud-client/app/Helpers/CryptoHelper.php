<?php
namespace App\Helpers;

class CryptoHelper
{
    public static function encrypt(string $data): string
    {
        $key = env('AES_KEY');
        $iv = env('AES_IV');

        if (empty($iv)) {
            throw new \Exception("Clave no configurada");
        }

        return openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    }

    public static function decrypt(string $data): string
    {
        $key = env('AES_KEY');
        $iv = env('AES_IV');

        if (empty($iv)) {
            throw new \Exception("Clave no configurada");
        }

        return openssl_decrypt($data, 'AES-256-CBC', $key, 0, $iv);
    }
}
