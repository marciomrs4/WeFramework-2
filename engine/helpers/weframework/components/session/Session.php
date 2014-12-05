<?php
namespace helpers\weframework\components\session;
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
     * @return mixed
     */
    public static function Get($name)
    {
        if(isset($_SESSION[$name]))
            return $_SESSION[$name];

        return null;
    }

    /**
     * Set
     * Método reponsável por criar um sessão
     *
     * @param $name
     * @param $value
     * @return null
     */
    public static function Set($name, $value)
    {
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