<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Render
 * -------------------------------------------------------------------------
 *
 * Este serviço tem como responsabilidade renderizar arquivos e conteúdo
 * armazenado na classe Render
 */


//Carregando Rota
$router = \core\router\Router::GetInstance();
$rs = \Slim\Slim::getInstance();
$render = \core\layout\Render::GetInstance();

//Response 200
if($router->GetStatus())
{
    try
    {
        /*
         * Processo de Renderização
         */
        //Renderização do tema
        $render->SetTheme();
        $render->RenderApp();
    }
    catch(\core\exceptions\RenderException $e)
    {
        \core\init\Service::SetError('render.php', $e->getMessage());
    }

}
else
{
    if(isset($router->error))
        \core\init\Service::SetError('render.php', $router->error);
    elseif(count($render->QueueError()) > 0)
    {
        $render->RenderError();
    }
}

// End of file render.php
// Location: ./engine/core/init/services/render.php