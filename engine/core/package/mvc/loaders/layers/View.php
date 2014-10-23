<?php

/**
 * Class ComponentLayer
 * Class responsável por carregar Componentes
 *
 * @pakcage WeFramework
 * @subpackage MVC/Layers/Component
 * @author diogo@weverest.com.br
 * @version 0.1 - 21/10/2014
 */
namespace mvc\loaders\layers;


class View
{
    /**
     * Load
     * Este método tem como responsabilidade preaparar dados enviados para a view
     *
     * @param $view
     * @param $data
     */
    public function Load($view, $data)
    {
        $mvc = new \mvc\View();
        $mvc->SetView($view, $data);
    }
}