<?php
/**
 * Environment
 * Esta classe tem como papel verificar e definir os diretórios do framework
 *
 * @packege WeFramework
 * @subpackage Environment
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 03/10/20144
 */
namespace core\error;

use core\exceptions\ConfigException;
use core\exceptions\ErrorException;
use helpers\weframework\classes\Config;

class Error
{
    use Config;

    /**
     * Variável que armazena o arquivo error.ini
     * @access private
     * @var null
     */
    private static $configuration_error = null;

    /**
     * __construct
     * Método construtor para ler o arquivo de configuração
     *
     * @param null $config
     */
    public function __construct($config = null)
    {
        $this->LoadConfig($config);
    }

    /**
     * LoadConfig
     * Carrega o arquivo de configuração error.ini
     *
     * @param null $config
     * @return void
     * @throws \core\exceptions\ErrorException
     */
    private function LoadConfig($config = null)
    {
        if(!isset(self::$configuration_error))
        {
            if(!isset($config))
            {
                $config_file = 'error.ini';
            }
            else
            {
                $config_file = BASEPATH . $config;
            }
        }

        try
        {
            self::$configuration_error = $this->GetFileConfig($config_file);
        }
        catch (ConfigException $e )
        {
            throw new ErrorException($e->getMessage());
        }
    }

    public function SetErrorLevel()
    {
        var_dump(self::$configuration_error);
    }

}

// End of file Error.php
// Location: ./engine/core/error/Error.php