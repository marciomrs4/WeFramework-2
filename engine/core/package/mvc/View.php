<?php

/**
 * Class View
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage MVC/View
 */
namespace mvc;

use core\layout\Template;
use core\router\Router;
use helpers\weframework\classes\Singleton;

class View
{
    use Singleton;

    /**
     * Controle de requisição de páginas
     *
     * @access private
     * @var array
     */
    private static $controll_page = array();
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
        if($this->RequirePage($view))
        {
            self::$data_view = $data;
        }
    }

    public function RequirePage($url_page)
    {
        $original_uri = strtolower(WE_URI_PROJECT);

        //Verificamos se a requisão é para a página inicial
        if($url_page == 'index' && $original_uri == '')
            return true;

        if(strpos($url_page, '|') ==! false)
        {
            $conditions = explode('|', $url_page);
            foreach($conditions as $page)
            {
                if($page == 'index' && $original_uri == '')
                {
                    return true;
                }
                elseif($page == $original_uri)
                {
                    $url_page = $page;
                    break;
                }
                elseif(strpos($page, '/'))
                {
                    $url_page = $page;
                    break;
                }
            }
        }

        //URI da aplicação sem a URL base
        $uri = explode('/', $original_uri);
        //URL requisitada
        $url = explode('/', $url_page);

        //Variáveis de controle
        $flag = 0;
        $flag_final = false;

        //Verificamos se o tema atual é adicional e não o principal
        //Se sim, retiramos o primeiro elemento da URI

        if(WE_IS_HOT_THEME && isset($uri[0]))
        {
            unset($uri[0]);
            $uri = array_values($uri);

            //Verificamos se o array está vazio e colocamos uma chave com valor vazio
            if(count($uri) == 0)
                $uri[0] = '';
        }

        //Verificamos se o número da requisição é igual ao URI
        if(count($url) > 0 && count($url) == count($uri))
        {
            //Percorrendo URL
            foreach($url as $k => $page)
            {
                //Testando valores
                if($uri[$k] == $page || $page == '*')
                {
                    $flag++;
                }
                else
                {
                    break;
                    $flag_final = false;
                }
            }

            if($flag > 0 && $flag == count($uri))
            {
                $flag_final = true;
            }
        }
        return $flag_final;
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


    /**
     * ControllPage
     * Controle de requisição de páginas
     *
     * @param null $flag
     * @return bool
     */
    public static function ControllPage($flag = null)
    {
        if(isset($flag))
            self::$controll_page[] = ($flag === true) ? 1 : 0 ;

        echo '<pre>';
        print_r(self::$controll_page);
        echo '</pre>';
        if(!in_array(1, self::$controll_page))
            return false;

        return true;
    }

}