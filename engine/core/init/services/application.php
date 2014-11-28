<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Application
 * -------------------------------------------------------------------------
 *
 * Este arquivo PHP tem como responsabilidade iniciar e configurar o
 * ambiente da aplição. Algumas de suas funcionalidades é criar constantes,
 * verificar diretórios e arquivos da aplicação
 */

//Instânciando classe Application.php
//Passando como parâmetro o caminho do diretório da aplicação
$app = new core\application\Application(APP_BASEPATH);

try
{
    $app->SetDefaultTimeZone();
}
catch (\core\exceptions\ApplicationException $e)
{
    \core\init\Service::SetError('application', $e->getMessage());
}

// End of file application.php
// Location: ./engine/core/application/services/application.php