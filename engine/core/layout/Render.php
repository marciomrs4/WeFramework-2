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

use core\exceptions\LayoutException;
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
     * RenderQueueAdd
     * Este método armazena um arquivo para a renderização
     *
     * @access public
     * @param $file
     * @return void
     */
    public function RenderQueueAdd($file)
    {
        self::$render_queue[] = $file;
    }

    /**
     * ClearRender
     * Reinicia vaíravel $pre_render_file ao seu estado original
     *
     * @access public
     * @return void
     */
    public function FlushRender()
    {
        self::$render_queue = array();
    }
}

// End of file Render.php
// Location: ./engine/core/layout/Render.php


