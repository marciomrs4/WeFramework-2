<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Router
 * -------------------------------------------------------------------------
 *
 * Este arquivo PHP tem como responsabilidade configurar rotas do framework,
 * gerenciar requisições HTTP do tipo get, post, put, delete e patch.
 * Será usado o Slim Framework como componente do Router
 */

$router = \core\router\Router::GetInstance();
$rs = new \Slim\Slim();

// GET route
$rs->get('/(:params+)', function() use ($rs, $router) {
    try
    {
        // Header HTTP
        $http_header = $rs->response->getStatus();
        if($http_header == 200)
        {
            //Argumentos da URL
            $args = func_get_args();
            //Registrando argumentos
            $router->SetArgs($args);
            //Controller View
            $controller = $router->GetArg(0);
            //Varificando temas adicionais
            /*
             * Constantes
             */
            define('WE_IS_HOT_THEME', $router->IsHotTheme($controller));
            //Definido tema atual
            define('WE_THEME', (WE_IS_HOT_THEME) ? $controller : WE_MAIN_THEME);
            //Definindo caminho do tema atual
            define('WE_THEME_PATH', WE_THEME_DIR . WE_THEME . DS);
            //Definindo pacote do back-end do tema
            define('WE_PACKAGE', \core\layout\Layout::GetInstance()->GetPackage());
            //Definindo caminho do pacote da aplicação
            define('WE_PACKAGE_PATH', APP_BASEPATH . 'package' . DS . ((!empty(WE_PACKAGE)) ? WE_PACKAGE . DS : ''));

            //Walking URL - Caso seja um tema, descartamos o controller
            if(WE_IS_HOT_THEME)
            {
                array_shift($args[0]);
                $router->SetArgs($args);
                $controller = $router->GetArg(0);
            }
            //Adiciona Rota
            $router->AddRoute($controller);

            //Definindo constante para controlador
            define('WE_CONTROLLER', (!$controller) ? \core\layout\Layout::GetInstance()->GetPageIndex() : $controller);
        }
        //Verificamos se o header foi alterado para outro código após a verificação dos arquivos html
        if($http_header != 200)
        {
            $rs->redirect($router->BaseURL() . $http_header);
        }
    }
    catch(\core\exceptions\RouterException $re)
    {
        \core\init\Service::SetError('router.php', $re->getMessage());
    }
});

// POST route
$rs->post('/(:params+)', function() use ($rs, $router) {
    $args = func_get_args();
});

//// PUT route
//$rs->put('/(:params+)', function() use ($app) {
//    $args = func_get_args();
//});
//
//// PATCH route
//$rs->patch('/(:params+)', function() use ($app) {
//    $args = func_get_args();
//});
//
//// DELETE route
//$rs->delete('/(:params+)', function() use ($app) {
//    $args = func_get_args();
//});

$rs->run();

// End of file router.php
// Location: ./engine/core/init/services/router.php