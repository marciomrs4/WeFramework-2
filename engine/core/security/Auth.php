<?php
/**
 * Class Router
 * Classe responsável por gerenciar as rotas e requisições HTTP
 *
 * @packege WeFramework
 * @subpackage Router
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 03/10/2014
 */

namespace core\security;

use core\layout\Layout;
use helpers\weframework\components\clientinfo\ClientInfo;
use helpers\weframework\components\encrypt\Encrypt;
use helpers\weframework\components\decrypt\Decrypt;
use helpers\weframework\components\session\Session;

class Auth
{
    /**
     * Configuração de Autenticação
     * Retorna o valor configurado em themes.ini
     * @return mixed
     */
    public function GetAuth()
    {
        $layout = Layout::GetInstance();
        $config = $layout->GetProperties();

        return $config['auth'];
    }

    /**
     * Configuração de Autenticação
     * Retorna o valor configurado em themes.ini
     * @return mixed
     */
    public function GetAuthPage()
    {
        $layout = Layout::GetInstance();
        $config = $layout->GetProperties();

        return $config['auth_page'];
    }

    /**
     * Configuração de Autenticação
     * Retorna o valor configurado em themes.ini
     * @return mixed
     */
    public function GetAuthLazyTime()
    {
        $layout = Layout::GetInstance();
        $config = $layout->GetProperties();

        return $config['auth_lazy_time'];
    }

    public static function Active()
    {
        if(defined('WE_SECURITY_AUTH') && defined('WE_SECURITY_AUTH_PAGE'))
        {
            if(WE_SECURITY_AUTH)
            {
                Session::Set('WE_AUTH_USER_LOGOUT', false);
                //Hash Blowfish
                $hash_blowfish = Encrypt::Blowfish(self::GenerateHashString(), array('cost' => 4));
                Session::Set('WE_AUTH_TOKEN', $hash_blowfish);
            }
        }
    }

    /**
     * GenerateHashString()
     * Geração de string para gerar a criptografia
     * @return string
     */
    private static function GenerateHashString()
    {
        //Gerando informações para compor o hash com Blowfish
        //Dados do navegador
        $binfo = ClientInfo::BrowserInfo();
        //Ip do cliente
        $client_ip = ClientInfo::GetIP();
        //Host do servidor de hospedagem
        $host = $_SERVER['SERVER_NAME'];
        //Usuário ou hostname do cliente
        $client_host = gethostname();

        //Unificando informações em uma string de hash
        $hash_string = $binfo . $client_ip . $host . $client_host;

        return $hash_string;
    }

    public static function Authenticate()
    {
        if(WE_SECURITY_AUTH)
        {
            if(self::Auth() && Session::Get('WE_AUTH_ERROR'))
                Session::Destroy('WE_AUTH_ERROR');

            if(strtolower(WE_SECURITY_AUTH_LAZY_TIME) !== 'off')
            {
                if(Session::Get('WE_AUTH_TIME') !== null)
                {
                    if (time() > Session::Get('WE_AUTH_TIME') || Session::Get('WE_AUTH_TIME') > (time() + 86400))
                    {
                        Session::Destroy('WE_AUTH_TOKEN');
                    }
                }
                Session::Set('WE_AUTH_TIME', (time() + (int) WE_SECURITY_AUTH_LAZY_TIME));
            }

            if(!self::Auth() && !RequirePage(WE_SECURITY_AUTH_PAGE))
            {
                if(Session::Get('WE_AUTH_USER_LOGOUT') === false && Session::Get('WE_AUTH_TIME') < (time() + 86400))
                    Session::Set('WE_AUTH_ERROR', 'Sessão expirada.');

                header('Location: ' . BaseUrl() . WE_SECURITY_AUTH_PAGE);
            }
            elseif(self::Auth() && RequirePage(WE_SECURITY_AUTH_PAGE) && WE_SECURITY_AUTH_PAGE != WE_THEME_PAGE_INDEX)
            {
                header('Location: ' . BaseUrl() . WE_THEME_PAGE_INDEX);
            }
        }
    }

    /**
     * Logout
     */
    public function Logout()
    {
        Session::Destroy('WE_AUTH_ERROR');
        Session::Destroy('WE_AUTH_TIME');
        Session::Destroy('WE_AUTH_TOKEN');
        Session::Set('WE_AUTH_USER_LOGOUT', true);

        if(WE_SECURITY_AUTH)
        {
            header('Location: ' . BaseUrl() . WE_SECURITY_AUTH_PAGE);
        }
    }

    /**
     * @return bool
     */
    private static function Auth()
    {
        if(defined('WE_SECURITY_AUTH') && defined('WE_SECURITY_AUTH_PAGE'))
        {
            if(WE_SECURITY_AUTH && Session::Get('WE_AUTH_TOKEN') !== null)
            {
                return Decrypt::Blowfish(self::GenerateHashString(), Session::Get('WE_AUTH_TOKEN'));
            }
        }

        return false;
    }
}