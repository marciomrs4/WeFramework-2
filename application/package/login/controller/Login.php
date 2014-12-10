<?php
/**
 * Class Login
 * Classe responsável por realizar operações da página Login
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @package WeFramewrok
 * @subpackage Package/Home
 * @version 0.1 - 23/10/2014
 */

namespace login\controller;

use helpers\weframework\components\alert\Alert;
use helpers\weframework\components\request\Request;
use helpers\weframework\components\session\Session;
use \mvc\Controller;
use login\model\Login as mLogin;

class Login extends Controller
{

    public function Index()
    {
        if(Request::Post()->IsPost())
        {
            $login = new mLogin();
            $login->Auth();
        }
        else
        {
            if(Session::Get('WE_ERROR'))
            {
                Alert::Error(Session::Get('WE_ERROR'));
            }
        }

        $this->Load()->View('login', array('message' => Alert::Alert()));
    }
}