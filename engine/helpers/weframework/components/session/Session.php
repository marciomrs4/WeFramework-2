<?php
namespace helpers\weframework\components\session;
use helpers\weframework\components\decrypt\Decrypt;
use helpers\weframework\components\encrypt\Encrypt;

/**
 * Class Session
 * @author Diogo Brito
 */
class Session
{
    private static $instante = null;
    /**
     * Get
     * Retorna o valor da sessão específicada
     * @param $name
     * @param $encrypt
     * @return mixed
     */
    public static function Get($name, $encrypt = false)
    {
        if(isset($_SESSION[$name]))
        {
            if($encrypt === true)
                return Decrypt::Decrypt($_SESSION[$name]);

            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * Set
     * Método reponsável por criar um sessão
     *
     * @param $name
     * @param $value
     * @param $encrypt
     * @return null
     */
    public static function Set($name, $value, $encrypt = false)
    {
        if($encrypt === true)
            $_SESSION[$name] = Encrypt::Encrypt($value);
        else
            $_SESSION[$name] = $value;

        return self::GetInstance();
    }

    /**
     * Add
     * Adiciona itens em uma sessão já criada
     *
     * @param $name
     * @param $value
     * @param null $key
     * @return Session|null
     */
    public static function Add($name, $value, $key = null)
    {
        if(isset($key))
            $_SESSION[$name][$key] = $value;
        else
            $_SESSION[$name][] = $value;

        return self::GetInstance();
    }

    /**
     * GetInstance
     * Instância Session
     * @return Session|null
     */
    private static function GetInstance()
    {
        if(!isset(self::$instante))
            self::$instante = new Session();

        return self::$instante;
    }

    /**
     * Destroy
     * Apagar dados de uma sessão ou todas
     * @param $name
     * @return bool
     */
    public static function Destroy($name)
    {
        if($name != '*')
        {
            if(isset($_SESSION[$name]))
            {
                unset($_SESSION[$name]);
                return true;
            }
        }
        else
        {
            self::DestroyAll();
            return true;
        }

        return false;
    }

    /**
     * DestroyAll
     * Destruindo todas as sessões
     *
     * @return void
     */
    public static function DestroyAll()
    {
        session_destroy();
        session_start();
    }
}