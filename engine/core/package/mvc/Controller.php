<?php

/**
 * Class Controller
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage
 */
namespace core\package\mvc;

use core\router\Router;

abstract class Controller
{

    /**
     * Variavel responsavel por armzanar dados enviados para a view
     * @access private
     * @var array
     */
    private static $data_view = array();

    /**
     * Variável responsável por verificar se o método Load foi acionado
     * @var bool
     */
    private $flag_load = false;

    /**
     * Armazena erro gerado na classe
     * @var null
     */
    private $error = null;

    /**
     * Load
     * Carregamento de camadas
     *
     * @access public
     * @return object
     */
    public function Load()
    {
        $this->flag_load = true;
        return $this;
    }


    /**
     * View
     * Este método tem como responsabilidade preaparar dados enviados para a view
     *
     * @param $view
     * @param $data
     */
    public function View($view, $data)
    {
        if($this->flag_load === true)
        {
            $mvc = new View();
            $mvc->SetView($view, $data);
        }
        else
        {
            $this->error = 'Cannot call method View() without call method Load() first';
        }
    }
}