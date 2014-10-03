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

    use core\exceptions\ServiceException;
    use helpers\weframework\classes\Singleton;

    class Service
    {

        use Singleton;


        /**
         * Variável responsável por armazenar a instância da classe Config
         *
         * @access private
         * @var null
         */
        protected  $config = null;

        /**
         * Variavel responsável por armaznar a fila de serviços
         *
         * @access private
         * @var array
         */
        private static $services = array();
        /**
         * Variavel responsável por armazenar o status de cada serviço da aplição
         *  :1 - para serviço normal
         *  :0 - para serviço com falha (não iniciado)
         *
         * @access private
         * @var array
         */
        private $services_status = array();

        /**
         * Variavel responsável por armazenar as mensagens de falha para cada serviço
         *
         * @access private
         * @var array
         */
        private $failed_services_message = array(array());


        /**
         * Método responsável por receber e armazenar a instância da classe Config
         *
         * @access public
         * @param Config $config
         */
        public function SetConfiguration(Config $config)
        {
            $this->config = $config;
            self::$services = $config::$configuration['services'];
        }

        /**
         * Método responsável por retornar a instância da classe Config
         *
         * @access public
         * @return null
         */
        public function GetConfiguration()
        {
            return $this->config;
        }

        /**
         * Método responsável armazenar erros de outras classes ou de outros gêneros
         *
         * @param $service
         * @param $error_message
         * @access public
         * @return null
         */
        public function SetError($service, $error_message)
        {
            $this->services_status[$service] = 0;
            $this->failed_services_message[$service][] = $error_message;
        }


        /**
         * Iniciar os serviços que estão previamente definido no arquivo ./engine/core/config/we.ini [services]
         * @throws \core\exceptions\ServiceException
         */
        public function InitServices()
        {
            if(count(self::$services) > 0)
            {
                $service_path = __DIR__ . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR;
                foreach(self::$services as $service)
                {
                    $service_file = $service_path . $service;
                    if(file_exists($service_file))
                    {
                        $this->services_status[$service] = 1;
                        include_once $service_file;
                    }
                    else
                    {
                        $this->services_status[$service] = 0;
                        $this->failed_services_message[$service][] = 'Failed to load ' . $service;
                    }
                }

                if(count($this->services_status) > 0 && in_array(0, $this->services_status))
                {
                    end($this->services_status);
                    $last_error = key($this->services_status);
                    $last_message = $this->failed_services_message[$last_error][count($this->failed_services_message[$last_error]) - 1];
                    throw new ServiceException($last_message);
                }
            }
            else
            {
                throw new ServiceException('Fail to start services.');
            }
        }

        /**
         * ServicesStatus
         * Método para verificar os estatos de
         *
         * @throws \core\exceptions\ServiceException
         * @return bool
         */
        public function Start()
        {
            if(count($this->services_status) > 0 && in_array(0, $this->services_status))
            {
                end($this->services_status);
                $last_error = key($this->services_status);
                $last_message = $this->failed_services_message[$last_error][count($this->failed_services_message[$last_error]) - 1];
                throw new ServiceException($last_message);
            }

            return true;
        }
    }

// End of file Service.php
// Location: ./engine/core/init/Service.php

