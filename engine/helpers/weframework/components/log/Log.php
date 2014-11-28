<?php
namespace helpers\weframework\components\log;
/**
 * Class Log
 * @package helpers\weframework\components\log
 */
use core\log\Log as CLog;

class Log
{
    public static function DataBase($message , $message_type = 3, $destination = null, $extra_headers = null)
    {
        if(!isset($destination))
            $destination = CLog::LogPath() . CLog::LogDataBase();

        $layout = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Database error: ' . $message;

        error_log($layout . PHP_EOL, $message_type, $destination, $extra_headers);
    }

    public static function LogWeFramework($message , $message_type = 3, $destination = null, $extra_headers = null)
    {
        if(!isset($destination))
            $destination = CLog::LogPath() . CLog::LogFramework();

        $layout = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Framework error: ' . $message;

        error_log($layout . PHP_EOL, $message_type, $destination, $extra_headers);
    }

    public static function LogApplication($message , $message_type = 3, $destination = null, $extra_headers = null)
    {
        if(!isset($destination))
            $destination = CLog::LogPath() . CLog::LogApplication();

        $layout = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Application: ' . $message;

        error_log($layout . PHP_EOL, $message_type, $destination, $extra_headers);
    }
}