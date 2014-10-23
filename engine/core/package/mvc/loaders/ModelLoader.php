<?php

/**
 * Class Loader
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage
 */
namespace mvc\loaders;

use mvc\loaders\layers\Component;
use mvc\loaders\layers\Model;
use mvc\loaders\layers\Repository;
use helpers\weframework\classes\Singleton;

class ModelLoader
{
    use Singleton;
    /**
     * Variável responsável por verificar se o método Load foi acionado
     * @var bool
     */
    private $flag_load = false;

    /**
     * Armazena todas as açoes de carregamento Load()
     * @var array
     */
    private static $flags_status = array();

    /**
     * Armazena erro gerado na classe
     * @var null
     */
    private $error = null;

    /**
     * Propriedades de models carregados
     * @var null
     */
    private static $models_property = array();


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
            self::$flags_status[] = 1;
        else
            self::$flags_status[] = 0;
    }

    /**
     * Loaded
     * Retorna status dos carregamentos
     * @return bool
     */
    public function Loaded()
    {
        if(in_array(0, self::$flags_status))
            return false;
        return true;
    }

    /**
     * GetProperties
     * Retorna as instâncias e propriedades criadas
     *
     * @access public
     * @return null
     */
    public function GetProperties()
    {
        return self::$models_property;
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
            $layer = new Model();
            $class_obj = $layer->Load($model_name);

            if($class_obj)
            {
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
     * Este método carrega Classes do tipo Component
     *
     * @access public
     * @param $component_name
     * @param $alias
     */
    public function Component($component_name, $alias = null)
    {
        if($this->flag_load === true)
        {
            $layer = new Component();
            $class_obj = $layer->Load($component_name);

            if($class_obj)
            {
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
     * Repository
     * Este método carrega Classes do tipo Component
     *
     * @access public
     * @param $repository_name
     * @param $alias
     */
    public function Repository($repository_name, $alias = null)
    {
        if($this->flag_load === true)
        {
            $layer = new Repository();
            $class_obj = $layer->Load($repository_name);

            if($class_obj)
            {
                if(isset($alias))
                    $this->SetModelProperty($alias, $class_obj);
                else
                    $this->SetModelProperty($repository_name, $class_obj);

                $this->SetStatus(true);
            }
            else
            {
                $this->SetStatus(false);
                $this->error = 'Class ' . $repository_name . ' not found';
            }
        }
        else
        {
            $this->SetStatus(false);
            $this->error = 'Cannot call method Repository() without call method Load() first';
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
        self::$models_property[$property] = $obj_class;
    }

    /**
     * __get
     *
     * @param $varname
     * @return mixed
     */
    public function __get($varname)
    {
        if(isset(self::$models_property[$varname]))
            return self::$models_property[$varname];
    }

}