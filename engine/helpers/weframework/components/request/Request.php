<?php
namespace helpers\weframework\components\request;
/**
 * Class Request
 * Classe para manipulação de Requests, POST, GET
 * @package helpers\weframework\components\request
 * @author Diogo Brito <diogo@weverest.com.br>
 */
class Request
{
    public static function Post()
    {
        return new Post();
    }

    public static function Get()
    {
        return new Get();
    }
}