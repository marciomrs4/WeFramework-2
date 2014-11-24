<?php

/**
 * Class Repository
 * Class responsável por carregar Repository
 *
 * @pakcage WeFramework
 * @subpackage MVC/Layers/Repository
 * @author diogo@weverest.com.br
 * @version 0.1 - 21/10/2014
 */
namespace mvc\loaders\layers;

use repositories\FirstRepo;

class Repository
{
    /**
     * Load
     * Este método carrega Classes do tipo Repository
     *
     * @access public
     * @param $repository_name
     * @return boll | object
     */
    public function Load($repository_name)
    {

        //Verificamos se foi especificado o caminho do Model
        if(strpos($repository_name, '/') !== false)
        {
            $class_namespace = ltrim(str_replace('/', '\\', 'repositories/' . $repository_name), '\\');
        }
        else
        {
            $class_namespace = ltrim('repositories' . '\\' . ucfirst($repository_name), '\\');
        }

        if(class_exists($class_namespace))
        {
            return new $class_namespace;
        }

        return false;
    }
}