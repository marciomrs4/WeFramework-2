<?php
namespace helpers\weframework\components\clientinfo;

/**
 * Class ClientInfo
 */
class ClientInfo
{
    /**
     * GetIP
     * Retorna o IP do cliente
     * @return null|string
     */
    public static function GetIP()
    {
        $ipaddress = null;
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /**
     * BrowserInfo
     * Retorna dados do navegador do cliente
     * @param $info
     * @return mixed
     */
    public static function BrowserInfo($info = null)
    {

        if(function_exists('get_browser'))
        {
            $binfo = @get_browser(null, true);

            if($binfo !== false)
            {
                if(isset($info) && isset($binfo[$info]))
                    return $binfo[$info];
                else
                    $binfo;
            }
            else
            {
                $binfo = $_SERVER['HTTP_USER_AGENT'];
            }
        }
        else
        {
            $binfo = $_SERVER['HTTP_USER_AGENT'];
        }

        return $binfo;
    }

    /**
     * Referer
     * @return mixed
     */
    public static function Referer()
    {
        if(!isset($_SERVER['HTTP_REFERER']))
            return $_SERVER['HTTP_HOST'];

        return $_SERVER['HTTP_REFERER'];
    }
}