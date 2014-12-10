<?php
namespace helpers\weframework\components\decrypt;
/**
 * Class Decrypt
 * @package helpers\weframework\components\decrypt
 */
class Decrypt
{

    /**
     * Blowfish
     * @param $string
     * @param $hash
     * @return bool
     */
    public static function Blowfish($string, $hash)
    {
        return password_verify($string, $hash);
    }

    /**
     * SHA256
     * @param $string
     * @param $hash
     * @return mixed
     */
    public static function SHA256($string, $hash)
    {
        if(function_exists('hash_equals'))
        {
            return hash_equals($hash, crypt($string, $hash));
        }

        return (crypt($string, $hash) === $hash);
    }
}