<?php
/**
 * Config
 * Classe responsável por ler arquivos de configuração .ini
 *
 * @package WeFramework
 * @subpackage Helpers/Config
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 02/09/2014
 *
 */
namespace helpers\weframework\classes;

use core\exceptions\ConfigException;

trait Config
{
    /**
     * @var array|null
     */
    public static $configuration = null;

    /**
     * GetFileConfig
     * Método construtor que possuí um parâmetro opcional que indica o local aonde se encontra o arquivo
     * @param $config_path
     * @param bool $flag
     * @return array
     * @throws \core\exceptions\ConfigException
     */
    public static function GetFileConfig($config_path, $flag = false)
    {

       if(strpos($config_path, '/') === false && defined('APP_BASEPATH'))
       {
           $config_path = APP_BASEPATH . 'configs' . DS . $config_path;
       }
       if(strpos($config_path, '.ini') !== false)
       {
           if(file_exists($config_path))
           {
               self::$configuration = parse_ini_file($config_path, $flag);
               return self::$configuration;
           }
           else
           {
               throw new ConfigException('Config file ' . $config_path . ' not found.');
           }
       }
       else
       {
           throw new ConfigException('invalid config file! The config file must be .ini');
       }
    }
}

// End of file Config.php
// Location: ./engine/helpers/weframework/classes/Config.php


