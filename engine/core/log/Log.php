<?php
namespace core\log;
use \helpers\weframework\classes\Config;
use \helpers\weframework\classes\Singleton;
/**
 * Class Log
 * Classe para gerenciamento de Logs da aplicação
 */
class Log
{
    use Config;
    use Singleton;

    private static $log_config = null;

    /**
     * Config
     * Parse do arquivo de configuração do Log
     */
    private static function Config()
    {
        if(!isset(self::$log_config))
            self::$log_config = Config::GetFileConfig('log.ini');
    }

    /**
     * LogPath
     * @return string
     */
    public static function LogPath()
    {
        self::Config();

        if(isset(self::$log_config['log_path']))
            return BASEPATH . trim(self::$log_config['log_path'], DS) . DS;

        return BASEPATH . 'application/logs' . DS;
    }

    /**
     * LogPHP
     * @return string
     */
    public static function LogPHP()
    {
        self::Config();

        if(isset(self::$log_config['log_php']))
            return self::$log_config['log_php'];

        return 'php.log';
    }

    /**
     * LogDataBase
     * @return string
     */
    public static function LogDataBase()
    {
        self::Config();

        if(isset(self::$log_config['log_database']))
            return self::$log_config['log_database'];

        return 'log_database.log';
    }

    /**
     * LogFramework
     * @return string
     */
    public static function LogFramework()
    {
        self::Config();

        if(isset(self::$log_config['log_framework']))
            return self::$log_config['log_framework'];

        return 'system.log';
    }

    /**
     * LogApplication
     * @return string
     */
    public static function LogApplication()
    {
        self::Config();

        if(isset(self::$log_config['log_application']))
            return self::$log_config['log_application'];

        return 'application.log';
    }

}
// End of file Log.php
// Location: ./engine/core/log/Log.php