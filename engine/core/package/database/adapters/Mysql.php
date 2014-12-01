<?php
namespace core\package\database\adapters;

use core\package\database\interfaces\IDatabase;
use helpers\weframework\components\log\Log;

/**
 * Class Myslq
 *
 * @author Diogo Brito
 * @package WeFramework
 * @subpackage Database/Adapters
 */
class Mysql implements IDatabase
{

    /**
     * Armezena propriedades de informações da base de dados
     * @access private
     * @var null
     */
    private $db_properties = null;

    /**
     * Instância da base de dados
     * @access private
     * @var null
     */
    private $db_instance = null;

    /**
     * Erros
     * @access private
     * @var null
     */
    private $db_error = null;

    /**
     * Constructor
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->db_properties = $properties;
    }

    /**
     * Connection
     * Conexão com bando de dados Mysql através do \PDO
     *
     * @access public
     * @return bool
     */
    public function Connection()
    {
        //Dados
        $db = $this->db_properties;

        //Dados de Conexão
        $dsn = $db['dsn'];
        $user = $db['user'];
        $password = $db['password'];
        $attributes = $db['attr'];
        $charset = $db['charset'];

        try
        {
            $pdo_attr = array();
            //Constantes do PDO
            if(count($attributes) > 0)
            {
                foreach($attributes as $pdo_constant)
                {
                    //Se a constante existir
                    if(defined($pdo_constant))
                    {
                        $pdo_attr[] = (string) $pdo_constant;
                    }
                }
            }

            $this->db_instance = new \PDO($dsn, $user, $password);
            if(count($pdo_attr) > 0)
            {
                $expression = '$this->db_instance->setAttribute('.implode(',' , $pdo_attr).');';
                eval($expression);
            }

            if(isset($charset) && is_string($charset))
                $this->db_instance->exec("SET NAMES ". $charset);
            return true;
        }
        catch (\PDOException $e)
        {
            $this->db_error = $e->getMessage();
            Log::DataBase($e->getMessage());
            return false;
        }
    }

    /**
     * CloseConnection
     *
     * @access public
     * @return void
     */
    public function CloseConnection()
    {
        $this->db_instance = null;
    }

    /**
     * DBInstance
     * instância de conexão
     * @access public
     * @return mixed
     */
    public function DBInstance()
    {
        return $this->db_instance;
    }

    /**
     * DBError
     * Erros
     *
     * @access public
     * @return null
     */
    public function DBError()
    {
        return $this->db_error;
    }
}