<?php
ob_start();

$save_path = ENGPATH . 'core' . DS . 'session';

if(is_dir($save_path))
{
    chown($save_path, get_current_user());

    if(is_writable($save_path))
    {
        //Save Path
        ini_set('session.save_path', $save_path);
    }
    elseif(chmod($save_path, 0600))
    {
        //Save Path
        ini_set('session.save_path', $save_path);
    }

}

if(!isset($_SESSION))
    session_start();
