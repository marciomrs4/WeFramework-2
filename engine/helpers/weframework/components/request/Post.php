<?php
namespace helpers\weframework\components\request;
/**
 * Class Post
 * @package helpers\weframework\components\request
 */
class Post
{
    /**
     * IsPost
     * Método repossável para verificar se existe $_POST
     * @return bool
     */
    public function IsPost()
    {
        if($_POST)
            return true;

        return false;
    }

    /**
     * Get
     * Retorna valor de um determinado campo
     * @param $name
     * @return mixed
     */
    public function Get($name)
    {
        if(isset($_POST[$name]))
            return $_POST[$name];

        return null;
    }

    /**
     * GetAll
     * Retorna toddos os índices de POST
     * @return mixed
     */
    public function GetAll()
    {
        return $_POST;
    }
}