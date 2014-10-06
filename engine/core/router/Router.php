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
use helpers\weframework\classes\Singleton;

class Router
{
    use Singleton;

    /**
     * Argumentos passados via URL. Nesta varável é armazenada todas as requisições via GET
     * @access public
     * @var array
     */
    private $args = array();

    /**
     * Respostas HTTP códigos e mensagens
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


    public function CheckHtppResponse($code)
    {
        if(array_key_exists((int) $code, $this->http_header_response))
        {
            return $this->http_header_response[$code];
        }
        return false;
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



} 