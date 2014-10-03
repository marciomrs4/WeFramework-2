<?php
/**
 * Config
 * Classe responsável por ler o arquivo de configuração do Framework
 *
 * @package WeFramework
 * @subpackage Config
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 02/09/2014
 *
 */
namespace core\init;

use core\exceptions\ConfigException;
use helpers\weframework\classes\Singleton;

class Config
{
    use Singleton;

    /**
     * @var array|null
     */
    public static $configuration = null;

    /**
     * Método construtor que possuí um parâmetro opcional que indica o local aonde se encontra o arquini mi.ini
     * @access public
     * @param null $file_path
     * @throws ConfigException
     */
    public function __construct($file_path = null)
    {
       if(!isset($config))
       {
           if(!isset($file_path))
           {
               $file_path = ENGPATH . DS . 'core' . DS . 'config' . DS . 'we.ini';
           }

           if(file_exists($file_path))
           {
               self::$configuration = parse_ini_file($file_path);
           }
           else
           {
               throw new ConfigException('The Framework cannot be started! The Config file is missing.');
           }
       }
    }
}

// End of file Config.php
// Location: ./engine/core/init/Config.php


