<?php
/**
 * Class Repository
 * Classe abstrada para conexões com bases de dados.
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 21/10/2014
 * @package WeFramework
 * @subpackage MVC/Model
 */
namespace mvc;


use helpers\weframework\classes\Config;

abstract class Repository
{
    /**
     * Usando Trait para parse do arquivo database.ini
     */
    use Config;

    /**
     * Retorno do parse do arquivo database.ini
     * @var array
     */
    private static $db_config = array();

    /**
     * Instância do PDO
     * @var null
     */
    public $DB = null;

    /**
     * Instância do banco de dados
     * @var null
     */
    private static $db_instance = null;

    /**
     * Configurações de conexões por pacote
     * @var array
     */
    private static $package_connection = array();

    /**
     * Erro de conexão e erros da classe
     * @var null
     */
    private static $db_error = null;

    /**
     * Instãncia do Adapter
     * @var null
     */
    private static $adapter = null;


    /**
     * __construct
     *
     * Método Construtor da classe
     */
    public function __construct()
    {
        $this->DabaBaseConfig();
        $this->SetDataBase();
    }

    /**
     * DabaBaseConfig
     * Configurções do banco de dados no arquivo database.ini
     *
     * @access private
     * @return void
     */
    private function DabaBaseConfig()
    {
        if(count(self::$db_config) == 0)
        {
            self::$db_config = $this->GetFileConfig('database.ini', true);
        }
    }

    /**
     * SetDataBase
     * Configura conexões dos bancos de dados e se alguma configuração estiver definida para inicar automaticamente,
     * esse método irá realizar a conexão.
     *
     * @access private
     * @return void
     */
    private function SetDataBase()
    {
        //Verifica se já existe um instância do banco
        if(!isset(self::$db_instance))
        {
            //Conficarando conexões
            foreach(self::$db_config as $db)
            {
                //Verifica se a conexão está ativada definida no arquivo de configuração
                if(strtolower($db['connection']) == 'on')
                {
                    //String de conexão
                    $dsn = $db['adapter'].':dbname='.$db['database'].";host=".$db['host'];
                    //Usuário do banco de dados
                    $user = $db['username'];
                    //Senha do banco de dados
                    $password = $db['password'];
                    //Separando connexãoes por pacote
                    self::$package_connection[strtolower($db['package'])] = array(
                        'dsn' => $dsn,
                        'host' => $db['host'],
                        'adapter' => $db['adapter'],
                        'database' => $db['database'],
                        'user' => $user,
                        'password' => $password,
                        'attr' => $db['set_attribute'],
                        'p_connection' => strtolower($db['persistent_connection']),
                        'autostart' => strtolower($db['autostart']),
                        'error_redirect' => strtolower($db['error_redirect']),
                        'page_error' => strtolower($db['page_error']),
                        'charset' => $db['charset']
                    );
                }
            }

            /*
             * Verificamos conexões para se auto iniciar
             */
            //Conexões para todas as aplicações
            if(isset(self::$package_connection['all']))
            {
                //Verifica o autostart
                if(self::$package_connection['all']['autostart'] == 'on')
                    $this->ConnectionAll();
            }
            //Conexões para o pacote atual
            elseif(isset(self::$package_connection[WE_PACKAGE]))
            {
                //Verifica autostart
                if(self::$package_connection[WE_PACKAGE]['autostart'] == 'on')
                    $this->ConnectionPackage();
            }
            //Nenhuma conexão encontrada
            return false;

            //Caso nenhuma das validações acima seja verdade, a primeira connexção será inicializada coso o autostart
            //estja On
            /*else
            {
                if(count(self::$package_connection) > 0)
                {
                    $i = 0;
                    foreach(self::$package_connection as $package => $val)
                    {
                        if($i == 0)
                        {
                            if(self::$package_connection[$package]['autostart'] == 'on')
                                $this->ConnectionPackage($package);
                        }
                    }
                }
            }*/
        }
    }

    /**
     * ConnectionPackage
     * Conexão com a base dados por pacote
     *
     * @access private
     * @param null $package_name
     * @return bool
     */
    private function ConnectionPackage($package_name = null)
    {
        //Verifica se foi informado o nome do pacote
        if(isset($package_name))
            $dbp = self::$package_connection[$package_name];
        else
            $dbp = self::$package_connection[WE_PACKAGE];

        //Preparando Atributos do PDO
        $attr = array();
        if($dbp['p_connection'] == 'on')
            $attr[\PDO::ATTR_PERSISTENT] = true;

        //Junção da variável $attr com a $dbp
        if(count($dbp['attr']) > 0)
            $dbp['attr'] = array_merge($attr, $dbp['attr']);

        //Iniciando conexão
        if(!$this->Connection($dbp))
        {
            if($dbp['error_redirect'] == 'on')
                $this->Redirect($dbp['page_error']);
            else
                return false;
        }

        return true;
    }

    /**
     * ConnectionAll
     * Connexão para todos os pacotes
     *
     * @access private
     * @return bool
     */
    private function ConnectionAll()
    {
        //Dados de conexão
        $dbp = self::$package_connection['all'];

        //Preparando atributos de conexão
        $attr = array();
        if($dbp['p_connection'] == 'on')
            $attr[\PDO::ATTR_PERSISTENT] = true;

        //Constantes PDO
        for($i =0; $i < count($dbp['attr']); $i++)
        {
            $const_pdo = '\\' . $dbp['attr'][$i];
            $dbp['attr'][$i] = $const_pdo;
        }

        //Junção da variável $attr com a $dbp
        if(count($dbp['attr']) > 0)
            $dbp['attr'] = array_merge($attr, $dbp['attr']);


        //Iniciando Conexão
        if(!$this->Connection($dbp))
        {
            if($dbp['error_redirect'] == 'on')
                $this->Redirect($dbp['page_error']);
            else
                return false;
        }

        return true;
    }

    /**
     * Connection
     * Método responsável por realizar a conexão com a base de dados
     *
     * @param $properties
     * @return bool
     */
    private function Connection($properties)
    {
        //Adapter da base de dados
        $adpater = ucfirst($properties['adapter']);
        $adpater_class = '\\core\\package\\database\\adapters\\' . $adpater;
        if(class_exists($adpater_class))
        {

            //Instacia Adapter
            $adpater_obj = new $adpater_class($properties);
            self::$adapter = $adpater_obj;
            if($adpater_obj->Connection())
            {
                self::$db_instance = $adpater_obj->DBInstance();
                $this->DB = self::$db_instance;
                return true;
            }
            else
            {
                self::$db_error = $adpater_obj->DBError();
            }
        }
        else
        {
            self::$db_error = 'Adapter <b>' . ucfirst($adpater) . '</b> not exists.';
        }

        return false;
    }

    /**
     * DBConnect
     * Lazy Load - Conexão com o banco de dados quando o o autostart está desativado (Off)
     *
     * @param null $connection
     * @return bool
     */
    public function DBConnect($connection = null)
    {

        if(!isset($connection) && isset($this->DB))
            return true;

        //Verifica se a conexão foi definida
        if(isset($connection))
        {
            //É numérico ??
            if(is_numeric($connection))
            {
                //Ordenando posição do $connection
                //A conexão está ordenada de 0 a N, se for passado a conexão 1 o correto seria a conexão 0
                $pos_connection = (int) $connection;
                if($pos_connection > 0)
                    $pos_connection = $pos_connection - 1;

                //Controle do laço de repetição
                $i = 0;
                //Chave de conexão com o banco de dados
                $pk_connect = null;
                /*
                 * Verificando se o que o usuário informou está dentro do número de conexões definido no arquivo de
                 * configuração database.ini
                 */
                if(count(self::$package_connection) - 1 >= $pos_connection)
                {
                    //Loop...
                    foreach (self::$package_connection as $package => $val)
                    {
                        //Se o controlador for igual ao número da conexão
                        if($i == $pos_connection)
                        {
                            $pk_connect = $package;
                            break;
                        }
                        $i++;
                    }
                }
                //Após a conexão ter sido encontrada, verificamos qual é o tipo dela
                if(isset($pk_connect))
                {
                    if($pk_connect == 'all')
                        return $this->ConnectionAll();
                    else
                        return $this->ConnectionPackage($pk_connect);
                }
            }
            //Se a conexão não for numérica, tentamos a conexão por pacote informada como argumento
            elseif(is_string($connection))
            {
                //verificamos se a conexão existe
                if(isset(self::$package_connection[$connection]))
                {
                    //Se conexão é all
                    if($connection == 'all')
                        return $this->ConnectionAll();
                    //Conexão por pacote
                    else
                        return $this->ConnectionPackage($connection);
                }
            }
        }
        else
        {
            //Se nada for passado como argumento tentaremos a conexão all e a primeira conexão do arquivo
            if(isset(self::$package_connection['all']))
            {
                return $this->ConnectionAll();
            }

            //Conexão com a primeira conxão definida no arquivo
            /*else
            {
                if(count(self::$package_connection) > 0)
                {
                    $i = 0;
                    foreach(self::$package_connection as $package => $val)
                    {
                        if($i == 0)
                        {
                            return $this->ConnectionPackage($package);
                        }
                    }
                }
            }*/
        }

        return false;
    }

    /**
     * CloseConnection
     * Fechar conexão com o banco de dados
     *
     * @acces public
     * @return void
     */
    public function CloseConnection()
    {
        if(isset(self::$adapter))
        {
            self::$adapter->CloseConnection();
        }
        $this->DB = null;
    }

    /**
     * Redirect
     * Redireciona o usuário para uma página de erro
     *
     * @access private
     * @return void
     * @param $page
     */
    private function Redirect($page)
    {
        header('Location: ' . BaseUrl() . $page);
    }

    /**
     * GetError
     * Método responsável por retorna o erro da classe
     *
     * @access public
     * @return null
     */
    public function GetError()
    {
        return self::$db_error;
    }

}