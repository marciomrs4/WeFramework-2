<?php
/**
 * Class Template
 * Esta classse tem como responsabilidade compilar o HTML do tema
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 17/10/2014
 * @package WeFramework
 * @subpackage Template
 */
namespace core\layout;



class Template
{
    /**
     * Compile
     * Compila página HTML e retorna o conteúdo do arquivo
     * @param $file
     * @param null $data
     * @return string
     */
    public function Compile($file, $data = null)
    {
        if(is_file($file))
        {
            if(isset($data))
                extract($data, EXTR_REFS);

            ob_start();
            include_once $file;
            return ob_get_clean();
        }

        return '';
    }
}