<?php
ob_start();

$save_path = ENGPATH . 'core' . DS . 'session';

if(is_dir($save_path))
{
    if(is_writable($save_path))
    {
        //Save Path
        ini_set('session.save_path', $save_path);
    }
    else
    {
        $template_log = '['.date('d-M-Y H:i:s').' '.date_default_timezone_get().'] Framework error: ./application/session is not writable. Can not session files.' . PHP_EOL;
        error_log($template_log, 0);
    }
}

if(!isset($_SESSION))
    session_start();
