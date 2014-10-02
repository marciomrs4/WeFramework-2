<?php
/**
 * --------------------------------------------------------------
 *  SETUP APPLICATION
 * --------------------------------------------------------------
 * Este arquivo é responsável por iniciar a aplicação,
 * modifique este arquivo somente se for necessário.
 *
 * @copyright       Copyright (c) Weverest Technology. (http://weverest.com.br)
 * @since           WeFramework(tm) v 0.1
 * @license         http://www.opensource.org/licenses/mit-license.php MIT License
 * @package         WeFramework
 * @version         2.0
 * @author          Diogo Brito <diogo@weverest.com.br>
 *
 */

/*
 * ---------------------------------------------------------------
 *  ENGINE PATH
 * ---------------------------------------------------------------
 *
 * Definição de uma constante para armazenar o diretório raiz da
 * aplicação.
 */
    $engine_path = 'engine';

/*
 * ---------------------------------------------------------------
 *  BASE PATH
 * ---------------------------------------------------------------
 *
 * Definição de uma constante para armazenar o caminho do
 * diretório raiz da aplicação.
 */
    define('DS', DIRECTORY_SEPARATOR);
    //Rais da aplpicação
    define('BASEPATH', dirname(__FILE__) . DS);

    if(defined('BASEPATH'))
    {
        if (realpath($engine_path) !== FALSE)
        {
            $engine_path = realpath($engine_path). DS;
        }

        // Certificando-se "/"
        $engine_path = rtrim($engine_path, DS). DS;

        // Verfica se p diretório $engine_path existe
        if ( ! is_dir($engine_path))
        {
            exit("Your system folder path does not appear to be set correctly. Please open the following file
                <b>" . pathinfo(__FILE__, PATHINFO_BASENAME) . "</b> and correct this");
        }
        else
        {
            //Definção do diretório do "motor" do framework
            define('ENGPATH', $engine_path);

            /*
             *
             * Iniciando o WeFramework...
             * Inclusão e execução do arquivo
             *
             */

            $initFile = ENGPATH . 'core' . DS . 'init' . DS . 'Init.php';
            if( is_file($initFile) )
            {
                include_once $initFile;
            }
            else
            {
                exit('The Framework cannot be started, <b>' . $initFile . '</b> was not found.');
            }
        }
    }
    else
    {
        exit('The Framework cannot be started, BASEPATH not defined.');
    }


// End of file index.php
// Location: ./index.php