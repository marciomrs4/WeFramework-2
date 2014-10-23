<?php
/**
 * Class Home
 * Classe responsável por realizar operações da página Home
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @package WeFramewrok
 * @subpackage Package/Home
 * @version 0.1 - 23/10/2014
 */

    namespace home\controller;

    use \mvc\Controller;

    class Home extends Controller
    {
        /**
         * Index
         * Carregamento inicial - método pincipal
         *
         * @access public
         * @return void
         */
        public function Index()
        {
            /*
             * Exemplo de carregamento de outras camadas:
             *
             * Model
             * $this->Load()->Model('nome_do_arquivo', 'alias');
             *  - Usando
             *       $this->alias->Method;
             *
             * Component
             * $this->Load()->Component('nome_do_arquivo', 'alias');
             *  - Usando
             *       $this->alias->Method;
             *
             * View
             * $this->Load()->View('pagina', array('data1' => $dado1, 'data2' => $dado2));
             */


            $this->Load()->Model('Home', 'HomeModel');

            //Verifica se outras camadas foram carregadas
            if($this->Loaded())
            {
                $welcome_message = $this->HomeModel->Welcome();

                /*
                 * Enviando dados para a View
                 */
                $this->Load()->View('index|home', array('welcome_message' => $welcome_message));
            }
        }

        /**
         * Component
         * Carregamento de componente de teste
         *
         * @return void
         * @access public
         */
        public function Component()
        {
            $this->Load()->Component('test/Component', 'TComponent');

            if($this->Loaded())
            {
                $data_comp = $this->TComponent->HelloComponent();

                // Enviando para View
                $this->Load()->View('home/component', array('component_message' => $data_comp));
            }
            else
                die($this->Load()->GetError());
        }
    }