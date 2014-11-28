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
use helpers\weframework\classes\Singleton;
use core\log\Log;

class Error
{
    use Config;
    use Singleton;


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

    /**
     * SetErrorLevel
     * Define nível de erro da aplicação
     *
     * @return void
     */
    public function SetErrorLevel()
    {
        ini_set("log_errors", 1);
        ini_set("error_log", Log::LogPath() . Log::LogPHP());

        $level = self::$configuration_error['level'];
        switch($level)
        {
            case 'development':
                ini_set('display_errors', 'On');
                error_reporting(-1);
                break;

            case 'production':
                ini_set('display_errors', 'Off');
                error_reporting(-1);
                break;
            case 'custom':
                if(isset(self::$configuration_error['display_custom_errors']))
                {
                    $display = self::$configuration_error['display_custom_errors'];
                    if(strtolower($display) == 'on')
                        ini_set('display_errors', 'On');
                    elseif(strtolower($display) == 'off')
                        ini_set('display_errors', 'Off');
                }

                $custom = self::$configuration_error['custom_level_error'];
                if(count($custom) > 0)
                {
                    $c_level = array();
                    foreach($custom as $c)
                    {
                        if(defined($c))
                        {
                            $c_level[] = $c;
                        }
                    }
                    $expression = 'error_reporting(' . implode(' | ', $c_level) . ');';
                    eval($expression);
                }
                break;
        }
    }
}
// End of file Error.php
// Location: ./engine/core/error/Error.php