<?php
namespace helpers\weframework\components\encrypt;
/**
 * Class Encrypt
 * @package helpers\weframework\components\encrypt
 */
class Encrypt
{
    private static $key = null;

    private static $hash = null;

    /**
     * Key
     * @return null
     */
    public static function Key()
    {
        return self::$key;
    }

    /**
     * Hash
     * @return null
     */
    public static function Hash()
    {
        return self::$hash;
    }

    /**
     * Encrypt
     * @param $string
     * @return string
     */
    public static function Encrypt($string)
    {
        # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        # convert a string into a key
        # key is specified using hexadecimal
        $key = self::$key = pack('H*', sha1(uniqid(rand(), true)));

        # create a random IV to use with CBC encoding
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, md5($key), $string, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciphertext = $iv . $ciphertext;

        # encode the resulting cipher text so it can be represented by a string
        $ciphertext_base64 = base64_encode($ciphertext);

        return $ciphertext_base64;
    }

    /**
     * Decrypt
     * @param $hash
     * @return string
     */
    public static function Decrypt($hash)
    {
        $ciphertext_dec = base64_decode($hash);

        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);

        # may remove 00h valued characters from end of plain text
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, md5(self::$key), $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

        return $plaintext_dec;
    }
}