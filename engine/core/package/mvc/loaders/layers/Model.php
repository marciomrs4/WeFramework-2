<?php

/**
 * Class ModelLayer
 * Class responsável por carregar Model
 *
 * @pakcage WeFramework
 * @subpackage MVC/Layers/Model
 * @author diogo@weverest.com.br
 * @version 0.1 - 21/10/2014
 */
    namespace mvc\loaders\layers;

    class Model
    {
        /**
         * Model
         * Este método carrega Classes do tipo Model
         *
         * @access public
         * @param $model_name
         * @return boll
         */
        public function Load($model_name)
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
                return new $class_namespace;
            }
            else
            {
               return false;
            }
        }
    }