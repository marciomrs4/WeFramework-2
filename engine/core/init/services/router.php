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
$rs->get('/(:params+)', function() use ($rs) {
    $args = func_get_args();
    $layout = \core\layout\Layout::GetInstance();
    $theme = $layout->GetDirMainTheme();
    if(count($args) > 0)
    {
        if(file_exists($theme . 'pages' . DS . $args[0][0] . DS . $args[0][0] . '.php'))
        {
            include_once $theme . 'pages' . DS . $args[0][0] . DS . $args[0][0] . '.php';
        }
        else
        {
            $rs->response->setStatus(404);
            if($args[0][0] != '404' || ($args[0][0] == '404' && count($args[0]) > 1))
            {
                echo 'here';
                if($rs->response->getStatus() == 404)
                {
                    $rs->redirect('http://localhost/dpg-framework-2/404');
                }
            }
        }
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