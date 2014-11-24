<?php
namespace core\package\database\adapters;

use core\package\database\interfaces\IDatabase;

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
            $this->db_instance = new \PDO($dsn, $user, $password, $attributes);
            if(isset($charset) && is_string($charset))
                $this->db_instance->exec("SET NAMES ". $charset);
            return true;
        }
        catch (\PDOException $e)
        {
            $this->db_error = $e->getMessage();
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