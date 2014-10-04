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
     * SetFileCongig
     * Método construtor que possuí um parâmetro opcional que indica o local aonde se encontra o arquivo
     * @access public
     * @param string $config_path
     * @throws ConfigException
     */
    public static function GetFileConfig($config_path)
    {

       if(strpos($config_path, '/') === false)
       {
           $config_path = APP_BASEPATH . 'configs' . DS . $config_path;
       }

       if(strpos($config_path, '.ini') !== false)
       {
           if(file_exists($config_path))
           {
               self::$configuration = parse_ini_file($config_path);
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

