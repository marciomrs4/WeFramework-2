<?php
    /**
     * Autoloader
     * Classe responsável para realizar o carregamento de Classes da aplicação.
     *
     * @package WeFramework
     * @subpackage Autoloader
     * @author Diogo Brito <diogo@weverest.com.br>
     * @version 0.1 - 01/09/2014
     *
     */
    namespace core\autoload;

    class Autoloader
    {

        public function __construct()
        {
            $this->CoreLoader();
            $this->AppLoader();
            $this->PackageLoader();
            $this->MVCLoader();
        }


        /**
         * CoreLoader
         * Carrega class do "Core" do Framework
         *
         * @access private
         * @param $class
         * @return void
         */
        private function CoreAutoloader($class)
        {
            $file = str_replace('\\', DS, $class);

            $file = ENGPATH . $file . '.php';
            if(file_exists($file))
            {
                include_once $file;
            }
        }


        /**
         * AppAutoloader
         * Carrega classes da pasta application
         *
         * @access private
         * @param $class
         * @return void
         */
        private function AppAutoloader($class)
        {
            $file = str_replace('\\', DS, $class);

            $file = APP_BASEPATH . $file . '.php';
            if(file_exists($file))
            {
                include_once $file;
            }
        }

        /**
         * PackageAutoload
         * Carrega classes package
         *
         * @access private
         * @param $class
         * @return void
         */
        private function PackageAutoload($class)
        {
            $file = str_replace('\\', DS, $class);

            $file = APP_BASEPATH . 'package' . DS . $file . '.php';
            if(file_exists($file))
            {
                include_once $file;
            }
        }

        /**
         * MVCAutoload
         * Carrega classes package
         *
         * @access private
         * @param $class
         * @return void
         */
        private function MVCAutoload($class)
        {
            $file = str_replace('\\', DS, $class);

            $file = ENGPATH . 'core' . DS . 'package' . DS . $file . '.php';
            if(file_exists($file))
            {
                include_once $file;
            }
        }


        /**
         * CoreLoader
         * Registra método CoreAutoloader() na SPL
         *
         * @access private
         * @return void
         */
        private function CoreLoader()
        {
            spl_autoload_register(array($this, 'CoreAutoloader'));
        }

        /**
         * AppLoader
         * Registra método AppAutoloader() na SPL
         *
         * @access private
         * @return void
         */
        private function AppLoader()
        {
            spl_autoload_register(array($this, 'AppAutoloader'));
        }

        /**
         * PackageLoader
         * Registra método PackageAutoload() na SPL
         *
         * @access private
         * @return void
         */
        private function PackageLoader()
        {
            spl_autoload_register(array($this, 'PackageAutoload'));
        }

        /**
         * MVCLoader
         * Registra método MVCAutoload() na SPL
         *
         * @access private
         * @return void
         */
        private function MVCLoader()
        {
            spl_autoload_register(array($this, 'MVCAutoload'));
        }

    }

// End of file Autoloader.php
// Location: ./engine/core/autoload/Autoloader.php


