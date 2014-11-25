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

    namespace test\controller;

    use helpers\weframework\components\request\Request;
    use \mvc\Controller;
    use Respect\Validation\Validator;

    class Test extends Controller
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
            $message = null;
            $status = null;
            if(Request::Post()->IsPost())
            {
                $validate = Validator::key('email', Validator::string()->email())
                                     ->key('passwd', Validator::string()->notEmpty()->length(5, 10))
                                     ->validate(Request::Post()->GetAll());
                if($validate)
                {
                    $status = true;
                    $message = 'Muito Bom! tudo certinho!!';
                }
                else
                {
                    $status = false;
                    $message = 'Algo está errado!';
                }
            }
            $this->Load()->View('test', array('message' => $message, 'status' => $status));
        }
    }