<?php

/**
 * Class Package
 * Esta classe irá fazer o gerenciamento da camada MVC e fazer a interligação do back-end e front-end
 *
 * @package WeFramework
 * @subpackage Package
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 */

namespace core\package;

use helpers\weframework\classes\Singleton;

class Package
{
    use Singleton;
    /**
     * Pacote da aplicação
     * @access private
     * @var null
     */
    private $package = null;

    /**
     * Caminho do pacote
     * @access private
     * @var null
     */
    private $package_path = null;

    /**
     * Controlador
     * @access private
     * @var null
     */
    private $controller = null;

    /**
     * Caminho do controlador
     * @access private
     * @var null
     */
    private $controller_path = null;

    /**
     * Caminho do Model
     * @access private
     * @var null
     */
    private $model_path = null;

    /**
     * Arquivo Controlador
     * @access private
     * @var null
     */
    private static $controller_file = null;

    /**
     * Arquivo Model
     * @access private
     * @var null
     */
    private static $model_file = null;

    /**
     * CheckPackage
     * Verificamos o pacote back-end do tema
     *
     * @param $package
     * @param null $path
     * @return bool
     */
   public function SetPackage($package, $path = null)
   {
       $this->package = $package;
       /*
        * Verificamos se o diretório dos pacotes forão definidos,
        * se sim o caminho padrão do paco será alterado
        */
       if(isset($path))
       {
           $this->package_path = $path;
           return $this->IsDir($path . $package);
       }
       else
       {
           //A constante WE_PACKAGE_PATH existe?
           if(defined('WE_PACKAGE_PATH'))
           {
               $this->package_path = WE_PACKAGE_PATH;
               return $this->IsDir(WE_PACKAGE_PATH);
           }
           else
           {
               $path = APP_BASEPATH . 'package' . DS . $package;
               $this->package_path = $path;
               return $this->IsDir($path);
           }
       }

        return false;
   }

    /**
     * IsDir
     * Método responsável por verificar a existência de um diretório
     *
     * @access private
     * @param $path
     * @return bool
     */
   private function IsDir($path)
   {
        if(is_dir($path))
            return true;

        return false;
   }


    /**
     * SetControllerPath
     * Caminho do controlador
     *
     * @access public
     * @param $controller
     * @return bool
     */
    public function SetControllerPath($controller)
    {
       $this->controller = $controller;
       if(isset($this->package_path))
       {
           $this->controller_path = $this->package_path . $controller . DS . 'controller' . DS;
           $this->model_path = $this->package_path . $controller . DS . 'model' . DS;
           if($this->IsDir($this->controller_path))
           {
               $this->SetControllerFile();
               $this->SetModelFile();
               return true;
           }
       }
       return false;
    }

    /**
     * SetControllerFile
     * Caminho do arquivo de controlador
     *
     * @access private
     * @return bool
     */
    private function SetControllerFile()
    {
        $controller_file = $this->controller_path . ucfirst($this->controller) . '.php';
        if(is_file($controller_file))
        {
            self::$controller_file = $controller_file;
            return true;
        }
        return false;
    }

    /**
     * GetControllerFile
     * Retorna o caminho do arquivo controlador
     * @return null | string
     */
    public function GetControllerFile()
    {
        return self::$controller_file;
    }

    /**
     * SetControllerFile
     * Caminho do arquivo de controlador
     *
     * @access private
     * @return bool
     */
    private function SetModelFile()
    {
        $model_file = $this->model_path .ucfirst($this->controller) . '.php';
        if(is_file($model_file))
        {
            self::$model_file = $model_file;
            return true;
        }
        return false;
    }

    /**
     * GetControllerFile
     * Retorna o caminho do arquivo controlador
     * @return null | string
     */
    public function GetModelFile()
    {
        return self::$model_file;
    }

    /**
     * GetControllerPath
     * Retorna o caminho do controlador
     *
     * @access public
     * @return null | string
     */
    public function GetControllerPath()
    {
        return $this->controller_path;
    }


    /**
     * GetController
     * Retorna o nome do controlador
     * @access public
     * @return null | string
     */
    public function GetController()
    {
        return $this->controller;
    }
}