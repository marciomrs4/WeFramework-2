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
$rs->get('/(:params+)', function() use ($app) {
    $args = func_get_args();
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