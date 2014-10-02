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

    }

// End of file Autoloader.php
// Location: ./engine/core/autoload/Autoloader.php


