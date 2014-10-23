<?php

/**
 * Class Controller
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage MVC/Controller
 */
namespace mvc;

abstract class Controller
{
    public function Load()
    {
        return \mvc\loaders\ControllerLoader::GetInstance()->Load();
    }

    public function Loaded()
    {
        return \mvc\loaders\ControllerLoader::GetInstance()->Loaded();
    }

    public function __get($varname)
    {
        $properties = \mvc\loaders\ControllerLoader::GetInstance()->GetProperties();
        if(isset($properties[$varname]))
            return $properties[$varname];
    }

}