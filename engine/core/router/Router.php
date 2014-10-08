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

namespace core\router;

use core\exceptions\RouterException;
use core\layout\Layout;
use core\layout\Render;
use helpers\weframework\classes\Config;
use helpers\weframework\classes\Singleton;
use Slim\Slim;

class Router
{
    use Config;
    use Singleton;


    /**
     * Argumentos passados via URL. Nesta varável é armazenada todas as requisições via GET
     * @access public
     * @var array
     */
    private $args = array();

    /**
     * Istância do arquivo default.ini
     * @var null
     */
    private static $default_config = null;

    /**
     * Estado do cabeçãlho da página
     * @access private
     * @var bool
     */
    private static $status = true;

    /**
     * URL base da aplicação
     * @access private
     * @var null
     */
    private static $base_url = null;

    /**
     * Erro de rota
     * @access public
     * @var string
     */
    public $error = null;

    /**
     * Respostas HTTP códigos e mensagens
     * @access private
     * @var array
     */
    private $http_header_response = array(
                                        //Informational 1xx
                                        100 => '100 Continue',
                                        101 => '101 Switching Protocols',
                                        //Successful 2xx
                                        200 => '200 OK',
                                        201 => '201 Created',
                                        202 => '202 Accepted',
                                        203 => '203 Non-Authoritative Information',
                                        204 => '204 No Content',
                                        205 => '205 Reset Content',
                                        206 => '206 Partial Content',
                                        //Redirection 3xx
                                        300 => '300 Multiple Choices',
                                        301 => '301 Moved Permanently',
                                        302 => '302 Found',
                                        303 => '303 See Other',
                                        304 => '304 Not Modified',
                                        305 => '305 Use Proxy',
                                        306 => '306 (Unused)',
                                        307 => '307 Temporary Redirect',
                                        //Client Error 4xx
                                        400 => '400 Bad Request',
                                        401 => '401 Unauthorized',
                                        402 => '402 Payment Required',
                                        403 => '403 Forbidden',
                                        404 => '404 Not Found',
                                        405 => '405 Method Not Allowed',
                                        406 => '406 Not Acceptable',
                                        407 => '407 Proxy Authentication Required',
                                        408 => '408 Request Timeout',
                                        409 => '409 Conflict',
                                        410 => '410 Gone',
                                        411 => '411 Length Required',
                                        412 => '412 Precondition Failed',
                                        413 => '413 Request Entity Too Large',
                                        414 => '414 Request-URI Too Long',
                                        415 => '415 Unsupported Media Type',
                                        416 => '416 Requested Range Not Satisfiable',
                                        417 => '417 Expectation Failed',
                                        418 => '418 I\'m a teapot',
                                        422 => '422 Unprocessable Entity',
                                        423 => '423 Locked',
                                        //Server Error 5xx
                                        500 => '500 Internal Server Error',
                                        501 => '501 Not Implemented',
                                        502 => '502 Bad Gateway',
                                        503 => '503 Service Unavailable',
                                        504 => '504 Gateway Timeout',
                                        505 => '505 HTTP Version Not Supported'
                                    );



    /**
     * Varifica se o código do cabeçalho existe
     * @param $code
     * @return bool
     */
    public function CheckHtppResponse($code)
    {
        if(array_key_exists((int) $code, $this->http_header_response))
        {
            self::$status = false;
            return $this->http_header_response[$code];
        }
        return false;
    }

    /**
     * AddRoute
     * Adiciona rota para renderização
     *
     * @param $controller
     * @return void
     */
    public function AddRoute($controller)
    {


        //Instância do Layout
        $layout = Layout::GetInstance();
        //Instância do Render
        $render = Render::GetInstance();
        //Slim
        $slim = Slim::getInstance();
        //Diretório do tema
        $dir_theme = WE_THEME_DIR . WE_THEME . DS;
        //Verificando Resposta HTTP
        $checkHttp = $this->CheckHtppResponse($controller);


        if($checkHttp)
        {
            $fcontroller = 'error';
            $page = $dir_theme . 'pages' . DS . $fcontroller . DS . $controller .'.php';
            if(!file_exists($page))
            {
                $page = $checkHttp;
                //Erro
                $this->error = $checkHttp;
            }
            $render->RenderQueueAddError($page);
            //Novo cabeçalho
            $slim->response->setStatus(404);
        }
        elseif(!$controller)
        {
            $fcontroller = 'home';
            $controller = 'home';
            $page = $dir_theme . 'pages' . DS . $fcontroller . DS . $controller .'.php';
            $render->RenderQueueAdd($page);
        }
        else
        {
            $fcontroller = $controller;
            //página para ser renderizada
            $page = $dir_theme . 'pages' . DS . $fcontroller . DS . $controller .'.php';
            $render->RenderQueueAdd($page);
        }
    }

    /**
     * BaseURL
     * URL base da aplicação
     *
     * @access public
     * @return string
     */
    public function BaseURL()
    {
        if(!isset(self::$base_url) || isset(self::$default_config))
        {
            self::$default_config = $this->GetFileConfig('default.ini');
        }
        //wrapper protocol - http, https, ftp...
        $wrapper = (!empty(self::$default_config['wrapper']) ? self::$default_config['wrapper'] : 'http') . '://';
        //Url base
        $url = $wrapper . $_SERVER['HTTP_HOST'] . '/' . rtrim(self::$default_config['base_url'], '/') . '/';

        if(defined('WE_IS_HOT_THEME') && WE_IS_HOT_THEME)
        {
            if(defined('WE_THEME'))
            {
                $url = $url . WE_THEME . '/';
            }
        }

        return $url;
    }


    /**
     * GetStatus
     * Status da rota
     *
     * @access public
     * @return bool
     */
    public function GetStatus()
    {
        return self::$status;
    }

    /**
     * SetArgs
     * Registrando argumentos vindo da URL via GET
     *
     * @param $args
     * @return array
     * @throws \core\exceptions\RouterException
     */
    public function SetArgs($args)
    {

        if(gettype($args) == 'array')
        {
            //Limpando argumentos
            $this->args = array();

            if(isset($args[0]) && count($args[0]) > 0)
            {
                $this->args = $args[0];
                return $this->args;
            }
        }
        else
        {
            throw new RouterException('Arguments must be an array to Router.');
        }
    }


    /**
     * GetArg
     * Retorna valor da chave desejada passada como parâmetro
     * @param $key
     * @return mixed
     * @throws \core\exceptions\RouterException
     */
    public function GetArg($key)
    {
        if(count($this->args) > 0)
        {
            if(gettype($key) == 'integer')
            {
                if(isset($this->args[$key]))
                {
                    return $this->args[$key];
                }
                else
                {
                    return false;
                }
            }
            elseif(gettype($key) == 'string')
            {
                return in_array($key, $this->args);
            }
        }
        return false;
    }

    /**
     * GetArgs
     * Retorna os arrgumentos Registrados
     *
     * @return array
     * @throws \core\exceptions\RouterException
     */
    public function GetArgs()
    {
        if(count($this->args) == 0)
           return false;

        return $this->args;
    }

    /**
     * IsHotTheme
     * Método responsável por verificar o estado da aplicação está em um tema adicional
     *
     * @param $controller
     * @return bool
     */
    public function IsHotTheme($controller)
    {
        $flag = false;
        if(defined('WE_THEMES_INSTALLED') && defined('WE_THEME_SWITCH_MODE'))
        {
            if(WE_THEMES_INSTALLED > 1 && $controller != '' && WE_THEME_SWITCH_MODE)
            {
                if(is_dir(WE_THEME_DIR . $controller))
                {
                    //Constante para indicar que a aplicação está em um tema adicional
                    $flag = true;
                }
            }
        }
        return $flag;
    }



} 