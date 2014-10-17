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
    $package = new \core\package\Package();
    //Consistência de ações
    try
    {
        if(WE_MODE == 'application')
        {
            if($package->SetPackage(WE_PACKAGE))
            {
                $package->SetControllerPath(WE_CONTROLLER);
            }
        }
    }
    catch(\core\exceptions\PackageException $e)
    {
        \core\init\Service::SetError('package.php', $e->getMessage());
    }