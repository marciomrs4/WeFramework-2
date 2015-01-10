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
    //Raiz da aplicação
    define('BASEPATH', dirname(__FILE__) . DS);

    /*
     * Constate CRASH_TEMPLATE_PATH
     * Diretório para manitpulação de erros encontrados durante a renderização da aplicação
     */
    define('CRASH_TEMPLATE_PATH', 'layout' . DS . 'framework' . DS);

    /*
     * Templates de erros
     */
    $template_errors = array(
        'crash' => 'crash-system.html',
        'version' => 'version.html'
    );

    /**
     * CrashHendler
     * Função para manupular erros internos encontrado durante a execução da aplicação
     *
     * @param $error
     * @param null $log
     * @param null $destination
     */
    function CrashHendler($error, $log, $destination)
    {
        global $template_errors;

        if(isset($log) && $destination)
        {
            $template_log = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Framework error: ';

            //Verifica se o diretório tem permissão de escrita
            if(is_writable($destination))
            {
                error_log($template_log . $log . PHP_EOL, 3, $destination);
            }
            //Caso contrário, o log será registrado no sistema de log do PHP
            else
            {
                error_log($template_log .'./application/logs is not writable. Can not crate log files.' . PHP_EOL, 0);
                error_log($template_log . $log . PHP_EOL, 0);
            }
        }
        if(isset($template_errors[$error]))
            include CRASH_TEMPLATE_PATH . $template_errors[$error];

        die();
    }

    /*
     * PHP Version 5.4 +
     */
    if (version_compare(PHP_VERSION, '5.4.0') >= 0)
    {
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
                    $error = 'The Framework cannot be started, <b>' . $initFile . '</b> was not found.';
                    CrashHendler('crash', $error, 'application/logs/system.log');
                }
            }
        }
        else
        {
            $error = 'The Framework cannot be started, BASEPATH not defined.';
            CrashHendler('crash', $error, 'application/logs/system.log');
        }
    }
    else
    {
        $error = 'Version ' . PHP_VERSION . ' is not compatible with framework';
        CrashHendler('version', $error, 'application/logs/system.log');
    }

// End of file index.php
// Location: ./index.php