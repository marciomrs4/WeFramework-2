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

    try
    {
        //Realizando checagem do ambiente
        $env->CheckEnvironment();

        /*
         * Definição de Constantes
         */
        // Diretório da aplicação
        define('APP_BASEPATH', $env->GetAppPath());
        //Diretório de layout
        define('LAY_BASEPATH', $env->GetLayoutPath());
        //Mode
        define('WE_MODE', $env->GetMode());

        /*
         * Set Enviorement Erros
         */
        try
        {
            //Error Level
            $error = new \core\error\Error();
            $error->SetErrorLevel();
        }
        catch(\core\exceptions\ErrorException $e)
        {
            $error = $e->getMessage();
        }

        define('ENVIRONMENT', \core\error\Error::$configuration['level']);

    }
    catch (\core\exceptions\EnvironmentException $e)
    {
        \core\init\Service::SetError('environment.php', $e->getMessage());
    }

// End of file environment.php
// Location: ./engine/core/init/environment.php






