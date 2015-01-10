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

    /**
     * Decrypt
     * @param $encrypted_string
     * @return string
     */
    public static function Decrypt($encrypted_string)
    {
        if(defined('WE_ENCRYPTION_KEY'))
        {
            $decrypt = function ($string) use (&$decrypt)
            {
                return is_array($string) ? array_map($decrypt, $string) : self::DecryptString($string);
            };

            return $decrypt($encrypted_string);
        }

        Log::LogWeFramework('WE_ENCRYPTION_KEY not defined. Imposible to encrypt value.');
        return null;
    }

    /**
     * DecryptString
     * @param $encrypted_string
     * @return string
     */
    public static function DecryptString($encrypted_string)
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, WE_ENCRYPTION_KEY, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return utf8_decode($decrypted_string);
    }
}