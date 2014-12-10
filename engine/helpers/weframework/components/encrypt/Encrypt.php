<?php
namespace helpers\weframework\components\encrypt;
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
}