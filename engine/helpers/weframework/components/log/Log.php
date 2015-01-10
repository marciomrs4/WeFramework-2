<?php
namespace helpers\weframework\components\log;
/**
 * Class Log
 * @package helpers\weframework\components\log
 */
use core\log\Log as CLog;

class Log
{
    /**
     * @param $message
     * @param int $message_type
     * @param null $destination
     * @param null $extra_headers
     */
    public static function DataBase($message , $message_type = 3, $destination = null, $extra_headers = null)
    {
        $layout = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Database error: ';

        if(isset($destination) && !is_writable($destination))
        {
            error_log($layout . './application/logs is not writable. Can not crate log files.', 0);
            error_log($layout . $message . PHP_EOL, 0);
        }
        else
        {
            if(!isset($destination))
                $destination = CLog::LogPath() . CLog::LogDataBase();

            error_log($layout . $message . PHP_EOL, $message_type, $destination, $extra_headers);
        }
    }

    /**
     * @param $message
     * @param int $message_type
     * @param null $destination
     * @param null $extra_headers
     */
    public static function LogWeFramework($message , $message_type = 3, $destination = null, $extra_headers = null)
    {
        $layout = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Framework error: ';

        if(isset($destination) && !is_writable($destination))
        {
            error_log($layout . './application/logs is not writable. Can not crate log files.', 0);
            error_log($layout . $message . PHP_EOL, 0);
        }
        else
        {
            if(!isset($destination))
                $destination = CLog::LogPath() . CLog::LogFramework();

            error_log($layout . $message . PHP_EOL, $message_type, $destination, $extra_headers);
        }
    }

    /**
     * @param $message
     * @param int $message_type
     * @param null $destination
     * @param null $extra_headers
     */
    public static function LogApplication($message , $message_type = 3, $destination = null, $extra_headers = null)
    {
        $layout = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Application error: ';

        if(isset($destination) && !is_writable($destination))
        {
            error_log($layout . './application/logs is not writable. Can not crate log files.', 0);
            error_log($layout . $message . PHP_EOL, 0);
        }
        else
        {
            if(!isset($destination))
                $destination = CLog::LogPath() . CLog::LogApplication();

            error_log($layout . $message . PHP_EOL, $message_type, $destination, $extra_headers);
        }
    }
}