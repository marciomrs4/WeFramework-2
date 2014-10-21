<?php

/**
 * Class Controller
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage
 */
namespace mvc;

use core\router\Router;

abstract class Controller
{


    // array contem as classes-extensões
    /**
     * Variável para armazenar instâncias de classes
     * @var array
     */
    private static $_classes = array();

    /**
     * Variável responsável por verificar se o método Load foi acionado
     * @var bool
     */
    private $flag_load = false;

    /**
     * Armazena todas as açoes de carregamento Load()
     * @var array
     */
    private $flags_status = array();

    /**
     * Armazena erro gerado na classe
     * @var null
     */
    private $error = null;

    /**
     * Propriedades de models carregados
     * @var null
     */
    private $models_property = array();


    /**
     * GetError
     * Retorna erro capturado de uma execução mal executada.
     *
     * @access public
     * @return null
     */
    public function GetError()
    {
        return $this->error;
    }

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
     * SetStatus
     * Adiciona flag do carregamento em um array de status
     * @return void
     * @param $flag
     */
    private function SetStatus($flag)
    {
        if($flag === true || $flag == 1)
            $this->flags_status[] = 1;
        else
            $this->flags_status[] = 0;
    }

    /**
     * Loaded
     * Retorna status dos carregamentos
     * @return bool
     */
    public function Loaded()
    {
        if(in_array(0, $this->flags_status))
            return false;
        return true;
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
            $this->SetStatus(true);
            $mvc = new View();
            $mvc->SetView($view, $data);

        }
        else
        {
            $this->SetStatus(false);
            $this->error = 'Cannot call method View() without call method Load() first';
        }
    }

    /**
     * Model
     * Este método carrega Classes do tipo Model
     *
     * @access public
     * @param $model_name
     * @param $alias
     */
    public function Model($model_name, $alias = null)
    {
        if($this->flag_load === true)
        {
            //Verificamos se foi especificado o caminho do Model
            if(strpos($model_name, '/') !== false)
            {
                $class_namespace = ltrim(str_replace('/', '\\', $model_name), '\\');
            }
            else
            {
                $class_namespace = ltrim(WE_PACKAGE . '\\' . WE_CONTROLLER . '\\' . 'model\\' . ucfirst($model_name), '\\');
            }

            if(class_exists($class_namespace))
            {
                $class_obj = new $class_namespace;
                if(isset($alias))
                    $this->SetModelProperty($alias, $class_obj);
                else
                    $this->SetModelProperty($model_name, $class_obj);

                $this->SetStatus(true);
            }
            else
            {
                $this->SetStatus(false);
                $this->error = 'Class ' . $model_name . ' not found';
            }
        }
        else
        {
            $this->SetStatus(false);
            $this->error = 'Cannot call method Model() without call method Load() first';
        }
    }

    /**
     * Component
     * Este método carrega Classes do tipo Model
     *
     * @access public
     * @param $component_name
     * @param $alias
     */
    public function Component($component_name, $alias = null)
    {
        if($this->flag_load === true)
        {
            //Verificamos se foi especificado o caminho do Model
            if(strpos($component_name, '/') !== false)
            {
                $class_namespace = ltrim(str_replace('/', '\\', 'components/' . $component_name), '\\');
            }
            else
            {
                $class_namespace = ltrim('components' . '\\' . ucfirst($component_name), '\\');
            }

            if(class_exists($class_namespace))
            {
                $class_obj = new $class_namespace;
                if(isset($alias))
                    $this->SetModelProperty($alias, $class_obj);
                else
                    $this->SetModelProperty($component_name, $class_obj);

                $this->SetStatus(true);
            }
            else
            {
                $this->SetStatus(false);
                $this->error = 'Class ' . $component_name . ' not found';
            }
        }
        else
        {
            $this->SetStatus(false);
            $this->error = 'Cannot call method Component() without call method Load() first';
        }
    }


    /**
     * SetModelProperty
     * Adicionamos uma propriedade e a instância da classe carregada
     *
     * @param $property
     * @param $obj_class
     */
    private function SetModelProperty($property, $obj_class)
    {
        $this->models_property[$property] = $obj_class;
    }

    /**
     * __get
     *
     * @param $varname
     * @return mixed
     */
    public function __get($varname)
    {
        if(isset($this->models_property[$varname]))
            return $this->models_property[$varname];
    }

}