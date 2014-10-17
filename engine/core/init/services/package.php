<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Package
 * -------------------------------------------------------------------------
 *
 * Este arquivo tem como fundamento iniciar gerenciar os pacotes de módulos,
 * além de montar a arquitetura MVC ele é responsável por fazer a interação
 * com o tema da aplicação.
 */

    //Classe Package
    $packege = new \core\package\Package();
    try
    {

    }
    catch(\core\exceptions\PackageException $e)
    {
        \core\init\Service::SetError('package.php', $e->getMessage());
    }