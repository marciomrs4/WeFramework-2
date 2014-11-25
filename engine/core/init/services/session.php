<?php
ob_start();
//Save Path
ini_set('session.save_path', ENGPATH . 'core' . DS . 'session');

if(!isset($_SESSION))
    session_start();
