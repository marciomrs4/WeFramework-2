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

class Component
{
    /**
     * Load
     * Este método carrega Classes do tipo Component
     *
     * @access public
     * @param $component_name
     * @return boll
     */
    public function Load($component_name)
    {

        if(strpos($component_name, '/') !== false)
        {
            $class_namespace = ltrim(str_replace('/', '\\', 'components/' . $component_name), '/');
        }
        else
        {
            $class_namespace = ltrim('components' . '\\' . $component_name, '\\');
        }

        if(class_exists($class_namespace))
        {
            return new $class_namespace;
        }

        return false;
    }
}