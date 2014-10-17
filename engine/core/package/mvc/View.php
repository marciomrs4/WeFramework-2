<?php

/**
 * Class View
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage MVC/View
 */
namespace core\package\mvc;

use core\router\Router;

class View
{

    /**
     * Variavel responsavel por armzanar dados enviados para a view
     * @access private
     * @var array
     */
    private static $data_view = array();


    /**
     * Armazena erro gerado na classe
     * @var null
     */
    private $error = null;


    /**
     * View
     * Este método tem como responsabilidade preaparar dados enviados para a view
     *
     * @param $view
     * @param $data
     */
    public function SetView($view, $data)
    {
        //URI
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $uri = explode('/', $uri);
        //URL Base
        $url_base = Router::GetInstance()->BaseURL(false);
        //Veiricamos se na URI existe a url base, se sim, retiramos
        if(in_array($url_base, $uri))
        {
            $key = array_search($url_base, $uri);
            unset($uri[0]);
        }
        //Montamos a nova uri
        $uri = implode($uri, '/');

        //Comparamos agora a URI com a view
        if($uri == $view)
        {
            self::$data_view = $data;
        }
    }
}