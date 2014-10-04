<?php
/**
 * Config
 * Classe responsável por ler o arquivo de configuração da aplicação ./application/configs/
 *
 * @package WeFramework
 * @subpackage Config
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 02/09/2014
 *
 */
namespace core\layout;

use core\exceptions\LayoutException;

class Render
{
    public static function RenderFile($html)
    {
        if(file_exists($html))
        {
            include_once $html;
        }
        else
        {
            throw new LayoutException('Failed to render a file <b>' . $html . '</b>');
        }
    }
}

// End of file Render.php
// Location: ./engine/core/layout/Render.php


