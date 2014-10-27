<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Error
 * -------------------------------------------------------------------------
 *
 * Este arquivo tem como responsabilidade configurar o sistema de Erros
 * da aplicação.
 */

//Instânciando classe Error.php
$error = new \core\error\Error();

try
{


    $error->SetErrorLevel();

    die('Servico Error rodando!!');

}
catch (\core\exceptions\ErrorException $e)
{
    \core\init\Service::SetError('error.php', $e->getMessage());
}

// End of file environment.php
// Location: ./engine/core/init/environment.php






