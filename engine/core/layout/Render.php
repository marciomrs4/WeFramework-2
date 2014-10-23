<?php
/**
 * Class Render
 * Classe responsácel por redenrizar conteúdos ou arquivos .php
 *
 * @package WeFramework
 * @subpackage Render
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 02/09/2014
 *
 */
namespace core\layout;


use core\exceptions\RenderException;
use mvc\View;
use core\router\Router;
use helpers\weframework\classes\Singleton;
use core\package\Package;

class Render
{
    use Singleton;
    /**
     * Fila de arquivos para serem renderizado
     * @access private
     * @var array
     */
    private static  $render_queue = array();

    /**
     * Fila de arquivos para serem renderizado de erro
     * @access private
     * @var array
     */
    private static  $render_queue_error = array();

    /**
     * Enderço do tema principal
     * #access private
     * @var null
     */
    private static $render_theme = null;

    /**
     * Esta vaíavel indica se algo já foi renderizado
     * @access private
     * @var bool
     */
    private static $rendered = false;


    /**
     * IsRendered
     * Retorna o estado de renderização
     *
     * @access public
     * @return bool
     */
    public static function IsRendered()
    {
        return self::$rendered;
    }


    /**
     * RenderFile
     * Renderiza um arquivo .php
     *
     * @access public
     * @param $html
     * @throws LayoutException
     * @return void
     */
    public static function RenderFile($html)
    {
        if(file_exists($html))
        {
            self::$rendered = true;
            include_once $html;
        }
        else
        {
            throw new LayoutException('Failed to render a file <b>' . $html . '</b>');
        }
    }

    /**
     * Render
     * Renderiza arquivos na fila
     *
     * @access public
     * @return bool
     */
    public function Render($get_file = false)
    {
        return $this->DefaultRender($get_file);
    }

    /**
     * DefaultRender
     * Renerização padrão
     *
     * @access private
     * @return bool
     */
    private function DefaultRender($file = false)
    {
        if(count(self::$render_queue) > 0)
        {
            $i = 0;
            foreach(self::$render_queue as $item)
            {
                if(file_exists($item))
                {
                    self::$rendered = true;
                    if($file === false)
                        include_once $item;
                    else
                        return $item;
                    $i++;
                }
                elseif(strpos($item, DS) === false)
                {
                    self::$rendered = true;
                    echo $item;
                    $i++;
                }
                else
                {
                    if($i == 0)
                        self::$rendered = false;

                    return false;
                }
            }
            $this->FlushRender();
        }
        return true;
    }

    /**
     * Render
     * Renderiza arquivos na fila de erro
     *
     * @access public
     * @return bool
     */
    public function RenderError()
    {
        if(count(self::$render_queue_error) > 0)
        {
            $i = 0;
            foreach(self::$render_queue_error as $item)
            {
                if(file_exists($item))
                {
                    self::$rendered = true;
                    include_once $item;
                    $i++;
                }
                elseif(strpos($item, DS) === false)
                {
                    self::$rendered = true;
                    echo $item;
                    $i++;
                }
                else
                {
                    if($i == 0)
                        self::$rendered = false;

                    return false;
                }
            }
            $this->FlushRenderError();
        }
        return true;
    }

    /**
     * SetTheme
     * Prepara Renderização do tema principal
     *
     * @return void
     */
    public function SetTheme()
    {
        if(defined('WE_THEME'))
        {
            $theme_path = WE_THEME_DIR . WE_THEME . DS . 'index.php';
        }
        self::$render_theme = $theme_path;
    }

    public function RenderApp()
    {
        /*
         * MC - Model & Controller
         */
        if(WE_MODE == 'application')
        {

            //Controller
            if(is_file(Package::GetInstance()->GetControllerFile()))
            {
                if(defined('WE_CONTROLLER'))
                {
                    //Renderizando MVC
                    $controller_class = ltrim(WE_PACKAGE . '\\' . WE_CONTROLLER . '\\' . 'controller\\' . ucfirst(WE_CONTROLLER), '\\');

                    if(class_exists($controller_class))
                    {
                        //Controller
                        $controller = new $controller_class();
                        $reflection = new \ReflectionClass($controller);

                        //Método index
                        //Ex: http://dominio.com.br
                        if(!Router::GetInstance()->GetArg(0) && !Router::GetInstance()->GetArg(1))
                        {
                            if($reflection->hasMethod('Index'))
                            {
                                $reflection_method = $reflection->getMethod('Index');
                                if($reflection_method->isPublic() && $reflection_method->class == $controller_class)
                                {
                                    $controller->Index();
                                }
                            }
                        }
                        //Ex: http://dominio.com.br/controller
                        elseif(Router::GetInstance()->GetArg(0)
                            && ucfirst(Router::GetInstance()->GetArg(0)) == ucfirst(WE_CONTROLLER)
                            && !Router::GetInstance()->GetArg(1)
                        )
                        {

                            if($reflection->hasMethod('Index'))
                            {

                                $reflection_method = $reflection->getMethod('Index');
                                if($reflection_method->isPublic() && $reflection_method->class == $controller_class)
                                {
                                    $controller->Index();
                                }
                            }
                        }
                        //Ex: http://dominio.com.br/controller/method
                        elseif(Router::GetInstance()->GetArg(0)
                            && Router::GetInstance()->GetArg(1)
                            && ucfirst(Router::GetInstance()->GetArg(0)) == ucfirst(WE_CONTROLLER)
                        )
                        {
                            $method = ucfirst(Router::GetInstance()->GetArg(1));
                            if($reflection->hasMethod($method))
                            {
                                $reflection_method = $reflection->getMethod($method);
                                if($reflection_method->isPublic() && $reflection_method->class == $controller_class)
                                {

                                    $controller->$method();
                                }
                            }
                        }
                    }
                }
            }

        }

        //Theme template index
        if(isset(self::$render_theme))
        {
            $data_view = View::GetInstance()->GetDataView();
            if(count($data_view) > 0)
                extract($data_view);

            include_once self::$render_theme;
        }
        else
        {
            throw new RenderException('Fail to render theme. Theme not defined.');
        }
    }

    /**
     * RenderQueueAdd
     * Este método armazena um arquivo para a renderização
     *
     * @access public
     * @param $content
     * @return void
     */
    public function RenderQueueAdd($content)
    {
        self::$render_queue[] = $content;
    }

    /**
     * Fila de mensagens de erro
     * @access public
     * @param $content
     * @return void
     */
    public function RenderQueueAddError($content)
    {
        self::$render_queue_error[] = $content;
    }

    /**
     * Queue
     * Retorna a fila de renderização
     *
     * @return array
     */
    public function Queue()
    {
        return self::$render_queue;
    }

    /**
     * QueueError
     * Retorna a fila de renderização de erro
     *
     * @return array
     */
    public function QueueError()
    {
        return self::$render_queue_error;
    }

    /**
     * FlushRender
     * Reinicia vaíravel $render_queue ao seu estado original
     *
     * @access public
     * @return void
     */
    public function FlushRender()
    {
        self::$render_queue = array();
    }


    /**
     * FlushRenderError
     * Reinicia vaíravel $render_queue_error ao seu estado original
     *
     * @access public
     * @return void
     */
    public function FlushRenderError()
    {
        self::$render_queue_error = array();
    }
}

// End of file Render.php
// Location: ./engine/core/layout/Render.php


