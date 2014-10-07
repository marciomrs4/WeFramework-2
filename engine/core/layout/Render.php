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
use core\exceptions\ServiceException;
use helpers\weframework\classes\Singleton;

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
     * @throws \core\exceptions\LayoutException
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
    public function Render()
    {
       if(count(self::$render_queue) > 0)
       {
           $i = 0;
           foreach(self::$render_queue as $item)
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
     * @param Layout $layout
     * @return void
     */
    public function SetTheme(Layout $layout)
    {
        self::$render_theme = $layout->GetIndexTheme();
    }

    public function RenderTheme()
    {
        if(isset(self::$render_theme))
        {
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


