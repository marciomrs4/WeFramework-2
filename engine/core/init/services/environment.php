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
    //Instância da Classe Service
    $service_inst = \core\init\Service::GetInstance();

    /*
     * Configuração do diretório "application"
     */

    $env->CheckApplicationFolder();
    $env->CheckLayoutFolder();
    $env->CheckEnvironment();






