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
    use helpers\weframework\components\alert\Alert;
    use helpers\weframework\components\decrypt\Decrypt;
    use helpers\weframework\components\encrypt\Encrypt;
    use helpers\weframework\components\log\Log;
    use helpers\weframework\components\session\Session;
    use \mvc\Controller;

    class Home extends Controller
    {
        /**
         * Index
         * Carregamento inicial - método pincipal
         *
         * @access public
         * @return void
         * @example
         *
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
        public function Index()
        {
           
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
    }