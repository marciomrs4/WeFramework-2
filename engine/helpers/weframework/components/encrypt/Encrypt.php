<?php
namespace helpers\weframework\components\encrypt;
use helpers\weframework\components\log\Log;

/**
 * Class Encrypt
 * @package helpers\weframework\components\encrypt
 */
class Encrypt
{
    /**
     * Blowfish
     * @param $string
     * @param array $options
     * @return bool|null|string
     */
    public static function Blowfish($string, $options = array('cost' => 10))
    {
        return password_hash($string, PASSWORD_BCRYPT, $options);
    }

    /**
     * SHA256
     * @param $string
     * @param string $string_salt
     * @param int $rounds
     * @return string
     */
    public static function SHA256($string, $rounds = 5000, $string_salt = 'weframeworkstringtosaltsha256')
    {
        return crypt($string, '$5$rounds='.$rounds.'$'.$string_salt.'$');
    }

    /**
     * @param $string
     * @return null|string
     */
    public static function Encrypt($string)
    {
        if(defined('WE_ENCRYPTION_KEY'))
        {
            $encrypt = function ($string) use (&$encrypt)
            {
                return is_array($string) ? array_map($encrypt, $string) : self::EncryptString($string);
            };

            return $encrypt($string);
        }
        Log::LogWeFramework('WE_ENCRYPTION_KEY not defined. Imposible to encrypt value.');
        return null;
    }

    /**
     * EncryptString
     * @param $string
     * @return string
     */
    private static function EncryptString($string)
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, WE_ENCRYPTION_KEY, utf8_encode($string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }
}