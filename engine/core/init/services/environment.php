<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Environment
 * -------------------------------------------------------------------------
 *
 * Este arquivo PHP tem como responsabilidade iniciar e configurar o
 * ambiente da aplição. Algumas de suas funcionalidades é criar constantes,
 * verificar diretórios base do framework, tais como application e layout.
 */

    //Instânciando classe Environment.php
    $env = new \core\environment\Environment();

    /*
     * Configuração do diretório "application"
     */

    try
    {
        $env->CheckApplicationFolder();
        $env->CheckLayoutFolder();
        $env->CheckEnvironment();

        //Definição de Constantes
        define('APP_BASEPATH', $env->GetAppPath());
        define('LAY_BASEPATH', $env->GetLayoutPath());
    }
    catch (\core\exceptions\EnvironmentException $e)
    {
        \core\init\Service::SetError('environment', $e->getMessage());
    }







