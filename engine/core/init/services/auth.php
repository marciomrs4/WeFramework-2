<?php

$auth = new \core\security\Auth();

try
{
    /*
     * Constantes
     */
    define("WE_ENCRYPTION_KEY", "!@#$%^&*");
    define('WE_SECURITY_AUTH', $auth->GetAuth());
    define('WE_SECURITY_AUTH_PAGE', $auth->GetAuthPage());
    define('WE_SECURITY_AUTH_LAZY_TIME', $auth->GetAuthLazyTime());

    //Autenticação do usuário
    $auth::Authenticate();
}
catch(\core\exceptions\AuthException $e)
{
    \core\init\Service::SetError('auth.php', $e->getMessage());
}