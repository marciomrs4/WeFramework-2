<?php

/**
 * Singleton
 * Esta trait tem como finalidade recuperar a instância de um certo objeto.
 *
 * @package WeFramework
 * @subpackage Singleton
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 01/09/2014
 */

    namespace helpers\weframework\classes;

    trait Singleton
    {
        /**
         * Variavel responsável por armaznar uma instância de um objeto
         * @access private
         * @var null | object
         */
        private static $instance = null;

        private static $called_classes = array();

        /**
         * __construct
         *
         * Consttrutor para evitar a criação de uma nova instância do via o operador `new` de fora dessa classe.
         *
         **/
//        protected function __construct()
//        {
//        }


        /**
         *  * GetInstance
         * Método responsável por retornar a instância de um objeto
         *
         * @param null $class_obj
         * @return null|static
         */
        public static function GetInstance($class_obj = null){
            /*
             * Verifica já existe uma instância, caso não exista uma nova instância será criada com base na classe que
             * está chamando a trait
             */

            if(isset($class_obj))
            {
                if(!isset(self::$instance) || $class_obj != self::$instance)
                {
                    self::$instance = $class_obj;
                }
            }
            else
            {
                self::$instance || self::$instance = new static();
            }

            return self::$instance;
        }


        /**
         * __clone
         * Método clone particular para impedir a clonagem da instância .
         *
         * @return void
         */
        private function __clone()
        {
        }

        /**
         * __wakeup
         * Unserialize método particular para impedir de unserializing da Instância.
         *
         * @return void
         */
        private function __wakeup()
        {
        }

    }

// End of file Singleton.php
// Location: ./engine/helpers/weframework/Singleton.php
