<?php
/**
 * Service
 * Classe responsável por gerenciar serviços da aplicação.
 *
 * @package WeFramework
 * @subpackage Config
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 02/09/2014
 *
 */

    namespace core\init;

    use helpers\weframework\classes\Singleton;

    class Service
    {

        use Singleton;
        /**
         * Variavel responsável por armaznar a fila de serviços
         *
         * @access private
         * @var array
         */
        private static $services = array();

        public function SetConfig(Config $config)
        {
            echo  'Carregando...';
        }
    }

// End of file Service.php
// Location: ./engine/core/init/Service.php

