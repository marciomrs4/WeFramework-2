<?php
/**
 * Class Model
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 21/10/2014
 * @package WeFramework
 * @subpackage MVC/Model
 */
    namespace mvc;

    abstract class Model
    {
        public function Load()
        {
            return \mvc\loaders\ModelLoader::GetInstance()->Load();
        }

        public function Loaded()
        {
            return \mvc\loaders\ModelLoader::GetInstance()->Loaded();
        }

        public function __get($varname)
        {
            $properties = \mvc\loaders\ModelLoader::GetInstance()->GetProperties();
            if(isset($properties[$varname]))
                return $properties[$varname];
        }
    }