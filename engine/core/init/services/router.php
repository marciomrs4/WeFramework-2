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

\Slim\Slim::registerAutoloader();
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
            //Instância do Layout
            $layout = core\layout\Layout::GetInstance();
            //Diretório do tema
            $dir_theme = $layout->GetDirMainTheme();
            //Verificando Resposta HTTP
            $checkHttp = $router->CheckHtppResponse($controller);
            //Verificando se controller não está definido
            if($checkHttp)
            {
                $fcontroller = 'error';
                $page = $dir_theme . 'pages' . DS . $fcontroller . DS . $controller .'.php';
                if(!file_exists($page))
                    $page = $checkHttp;
            }
            elseif(!$controller)
            {
                $fcontroller = 'home';
                $controller = 'home';
                $page = $dir_theme . 'pages' . DS . $fcontroller . DS . $controller .'.php';
            }
            else
            {
                $fcontroller = $controller;
                //página para ser renderizada
                $page = $dir_theme . 'pages' . DS . $fcontroller . DS . $controller .'.php';
            }


            //Adiciona página para renderização
            $render = \core\layout\Render::GetInstance();
            $render->FlushRender();
            $render->RenderQueueAdd($page);

        }
        //Verificamos se o header foi alterado para outro código após a verificação dos arquivos html
        if($http_header != 200)
        {
            $rs->redirect('http://localhost/dpg-framework-2/' . $http_header);
        }
    }
    catch(\core\exceptions\RouterException $re)
    {
        \core\init\Service::SetError('router.php', $re->getMessage());
    }

});

// POST route
$rs->post('/(:params+)', function() use ($app) {
    $args = func_get_args();
});

// PUT route
$rs->put('/(:params+)', function() use ($app) {
    $args = func_get_args();
});

// PATCH route
$rs->patch('/(:params+)', function() use ($app) {
    $args = func_get_args();
});

// DELETE route
$rs->delete('/(:params+)', function() use ($app) {
    $args = func_get_args();
});

$rs->run();

// End of file router.php
// Location: ./engine/core/init/services/router.php