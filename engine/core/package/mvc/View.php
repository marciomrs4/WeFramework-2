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

use core\layout\Template;
use core\router\Router;
use helpers\weframework\classes\Singleton;

class View
{
    use Singleton;
    /**
     * Variavel responsavel por armzanar dados enviados para a view
     * @access private
     * @var array
     */
    private static $data_view = array();

    /**
     * Conteúdo de renderização
     * $access private
     * @var null
     */
    private static $render_content = null;


    /**
     * Fila de conteúdo para renderização
     * @var array
     * @access private
     */

    private static $render_queue = array();
    /**
     * Armazena erro gerado na classe
     * @var null
     */
    private $error = null;

    /**
     * Armazena a URI da aplicação
     * @access private
     * @var null
     */
    private static $uri_project = null;


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
            unset($uri[$key]);
        }
        //Montamos a nova uri
        $uri = implode($uri, '/');
        self::$uri_project = $uri;

        //Comparamos agora a URI com a view
        if($uri == $view)
        {
            self::$data_view = $data;
        }
    }



    /**
     * TemplateQueue
     * Este método armazena dados para renderização
     *
     * @access public
     * @param $content
     * @param $is_file
     * @return void
     */
    public function Compile($content, $is_file = false)
    {
        if(!$is_file)
            self::$render_queue[] = $content;
        else
        {
            $template = new Template();
            return $template->Compile($content, $this->GetDataView());
        }
    }

    /**
     * GetDataView
     * Retorna os dados do controller para a view
     *
     * @access public
     * @return array
     */
    public function GetDataView()
    {
        return self::$data_view;
    }

}