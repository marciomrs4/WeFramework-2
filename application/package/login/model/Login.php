<?php
namespace login\model;

use \mvc\Model;
use Respect\Validation\Validator;
use core\security\Auth;
use helpers\weframework\components\alert\Alert;
use helpers\weframework\components\request\Request;

class Login extends Model
{
    public function Auth()
    {
        $validate = Validator::key('user', Validator::string()->notEmpty()->length(3, 15))
            ->key('passwd', Validator::string()->notEmpty()->length(5, 10))
            ->validate(Request::Post()->GetAll());

        if($validate)
        {
            Auth::Active();
            Alert::Success('Parabéns! Vocês está logado.');
        }
        else
        {
            Alert::Error('Forneça os dados corretamente.');
        }
    }
}