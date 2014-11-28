<?php
namespace helpers\weframework\components\alert;
/**
 * Class Alert
 * @package helpers\weframework\components\request
 */
class Alert
{
    private static $messages = array(
        'success' => array(),
        'warning' => array(),
        'info' => array(),
        'error' => array(),
    );

    private static $title = null;

    /**
     * @param $message
     * @return string
     */
    public static function Success($message)
    {
        self::$messages['success'][] = $message;
    }

    /**
     * @param $message
     * @return string
     */
    public static function Warning($message)
    {
        self::$messages['warning'][] = $message;
    }

    /**
     * @param $message
     * @return string
     */
    public static function Info($message)
    {
        self::$messages['info'][] = $message;
    }

    /**
     * @param $message
     * @return string
     */
    public static function Error($message)
    {
        self::$messages['error'][] = $message;
    }


    /**
     * Alert
     * Html alert
     *
     * @return string
     */
    public static function Alert()
    {
        $alert = '';
        if(count(self::$messages) > 0)
        {
            //Success
            if(count(self::$messages['success']) > 0)
            {
                $messages = self::$messages['success'];
                ob_start();
                include_once 'templates/Success.php';
                $alert .= ob_get_clean();
            }

            //Warning
            if(count(self::$messages['warning']) > 0)
            {
                $messages = self::$messages['warning'];
                ob_start();
                include_once 'templates/Warning.php';
                $alert .= ob_get_clean();
            }

            //Info
            if(count(self::$messages['info']) > 0)
            {
                $messages = self::$messages['info'];
                ob_start();
                include_once 'templates/Info.php';
                $alert .= ob_get_clean();
            }

            //Error
            if(count(self::$messages['error']) > 0)
            {
                $messages = self::$messages['error'];
                ob_start();
                include_once 'templates/Error.php';
                $alert .= ob_get_clean();
            }
        }

        return $alert;
    }

    /**
     * Flush
     * @return void
     */
    public static function Flush()
    {
        foreach(self::$messages as $status => $m)
        {
            self::$messages[$status] = array();
        }
    }
}