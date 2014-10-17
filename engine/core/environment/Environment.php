<?php
/**
 * Environment
 * Esta classe tem como papel verificar e definir os diretórios do framework
 *
 * @packege WeFramework
 * @subpackage Environment
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 03/10/20144
 */
    namespace core\environment;

    use core\exceptions\EnvironmentException;
    use core\init\Config;

    class Environment
    {

        /**
         * Variável responsável por armazenar o caminho do diretório da aplicação
         * O padrão do framework é ./application
         * @var null
         */
        private static $application_path = null;

        /**
         * Variável responsável por armazenar o caminho do diretório layout
         * O padrão do framework é ./layout
         * @var null
         */
        private static $layout_path = null;

        /**
         * Varíavel responsável por amrazenar o status do ambiente
         *  true - Ambiente Ok
         *  false - Falha no ambiente
         * @var bool
         */
        private $flag = false;

        /**
         * Variável responsável por armazenar o status de cada serviço relacionado ao ambiente
         * @var array
         */
        private $environment_status = array();

        /**
         * SetAppPath
         * Método responsável por definir o caminho aonde se encontra a aplicação
         *
         * @param $path
         * @return void
         */
        private function SetAppPath($path)
        {
            self::$application_path = $path;
        }

        /**
         * GetAppPath
         * Retorna o caminho do diretório da aplicação
         *
         * @return string
         */
        public function GetAppPath()
        {
            return self::$application_path;
        }

        /**
         * SetLayoutPath
         * Método responsável por definir o caminho aonde se encontra o frontend - layout
         *
         * @param $path
         * @return void
         */
        private function SetLayoutPath($path)
        {
            self::$layout_path = $path;
        }

        /**
         * GetLayoutPath
         * Método responsável por retornar o caminho aonde se encontra o diretório layout
         *
         * @return string
         */
        public function GetLayoutPath()
        {
            return self::$layout_path;
        }


        private function CheckCoreFiles()
        {
            $config = Config::GetInstance();
            $configuration = $config::$configuration;
            $core_files = $configuration['files'];

            if(count($core_files) > 0)
            {
                foreach($core_files as $f)
                {
                    $file = __DIR__ . DIRECTORY_SEPARATOR . '../../../' . $f;
                    if(!file_exists($file))
                    {
                        //Lançada uma exceção de erro do diretório inexistente
                        $this->environment_status['CheckCoreFiles'] = 0;
                        throw new EnvironmentException('Failed to load <b>' . $f . '</b>. Environment cannot be started.');
                        break;
                    }
                }
            }
            $this->flag = true;
            return $this->flag;
        }


        /**
         * CheckApplicationFolder
         * Método responsável por verificar e definir o diretório da aplicação
         *
         * @param null $path
         * @return bool
         * @throws \core\exceptions\EnvironmentException
         */
        private function CheckApplicationFolder($path = null)
        {
            //Verifica se o parâmetro foi definido, caso o contrário o diretório padrão será do framework será definido
            if(isset($path))
            {
                $app_path = self::$application_path = $path;
            }
            else
            {
                //Armazenando diretório definido no arquivo de configuração
                $config = Config::GetInstance();
                $configuration = $config::$configuration;
                self::$application_path = $configuration['application_path'];

                /*
                 * Criação do diretório padrão
                 */
                $app_path =  __DIR__;
                $app_path = explode(DIRECTORY_SEPARATOR, $app_path);
                //Eliminando os úlmitos 3 índices do array
                for($i = 0; $i < 3; $i++)
                {
                    unset($app_path[count($app_path) -1]);
                }
                //Definindo caminho do diretório
                $app_path = implode(DIRECTORY_SEPARATOR, $app_path);
                $app_path = $app_path . DIRECTORY_SEPARATOR . self::$application_path;
            }

            //Se o diretório existir?
            if(is_dir($app_path))
            {
                $this->SetAppPath($app_path . DS);
                $this->environment_status['CheckApplicationFolder'] = 1;
                $this->flag = true;
                return $this->flag;
            }
            //Lançada uma exceção de erro do diretório inexistente
            $this->environment_status['CheckApplicationFolder'] = 0;
            throw new EnvironmentException('Failed to load directory <b>' . $app_path . '</b>. Environment cannot be started.');
            return false;
        }

        /**
         * Método responsável por verificar e definir o diretório layout
         * @param null $path
         * @return bool
         * @throws \core\exceptions\EnvironmentException
         */
        private function CheckLayoutFolder($path = null)
        {
            //Verifica se o parâmetro foi definido, caso o contrário o diretório padrão será do framework será definido
            if(isset($path))
            {
                $lay_path = self::$layout_path = $path;
            }
            else
            {
                //Armazenando diretório definido no arquivo de configuração
                $config = Config::GetInstance();
                $configuration = $config::$configuration;
                self::$layout_path = $configuration['layout_path'];

                /*
                 * Criação do diretório padrão
                 */
                $lay_path =  __DIR__;
                $lay_path = explode(DIRECTORY_SEPARATOR, $lay_path);
                //Eliminando os úlmitos 3 índices do array
                for($i = 0; $i < 3; $i++)
                {
                    unset($lay_path[count($lay_path) -1]);
                }
                //Definindo caminho do diretório
                $lay_path = implode(DIRECTORY_SEPARATOR, $lay_path);
                $lay_path = $lay_path . DIRECTORY_SEPARATOR . self::$layout_path;
            }

            //Se o diretório existir?
            if(is_dir($lay_path))
            {
                $this->SetLayoutPath($lay_path . DS);
                $this->environment_status['CheckLayoutFolder'] = 1;
                $this->flag = true;
                return $this->flag;
            }
            //Lançada uma exceção de erro do diretório inexistente
            $this->environment_status['CheckLayoutFolder'] = 0;
            throw new EnvironmentException('Failed to load directory <b>' . $lay_path . '</b>. Environment cannot be started.');
            return false;
        }


        /**
         * CheckAppDirectories
         * Este método tem como funcionalidade verificar os diretórios da aplicação e cria-los caso não exista.
         * @param null $directories
         * @throws \core\exceptions\EnvironmentException
         * @return boll
         */
        public function CheckAppDirectories($directories = null)
        {
            $app_directories = null;
            if(isset($directories))
            {
                if(is_array($directories))
                {
                    $app_directories = $directories;
                }
                else
                {
                    $this->environment_status['CheckAppDirectories'] = 0;
                    throw new EnvironmentException('CheckAppDirectories() parameter must to be an array.');
                }
            }

            if(!isset($app_directories))
            {
                $config = Config::GetInstance();
                $configuration = $config::$configuration;
                $app_directories = $configuration['app_directories'];
            }

            if(count($app_directories) > 0)
            {
                foreach($app_directories as $d)
                {
                    if(!is_dir(self::$application_path . $d))
                    {
                        if(strtolower($configuration['auto_create_directories']) == 'on')
                        {
                            if(!mkdir(self::$application_path .$d))
                            {
                                $this->environment_status['CheckAppDirectories'] = 0;
                                throw new EnvironmentException('Could not find the directory <b>' . $d . '</b>.
                                We try to create the directory but something unexpected happened:');
                            }
                            touch(self::$application_path . $d . DIRECTORY_SEPARATOR . '.empty');
                        }
                        else
                        {
                            //Criando arquivo vazio
                            $this->environment_status['CheckAppDirectories'] = 0;
                            throw new EnvironmentException('Could not find the directory <b>' . $d . '</b>.');
                        }
                    }
                }
            }
            $this->flag = true;
            return $this->flag;
        }

        /**
         * CheckLayoutDirectories
         * Este método tem como funcionalidade verificar os diretórios da aplicação e cria-los caso não exista.
         * @param null $directories
         * @throws \core\exceptions\EnvironmentException
         * @return boll
         */
        public function CheckLayoutDirectories($directories = null)
        {
            $lay_directories = null;
            if(isset($directories))
            {
                if(is_array($directories))
                {
                    $lay_directories = $directories;
                }
                else
                {
                    $this->environment_status['CheckLayoutDirectories'] = 0;
                    throw new EnvironmentException('CheckAppDirectories() parameter must to be an array.');
                }
            }

            if(!isset($app_directories))
            {
                $config = Config::GetInstance();
                $configuration = $config::$configuration;
                $lay_directories = $configuration['lay_directories'];
            }

            if(count($lay_directories) > 0)
            {
                foreach($lay_directories as $d)
                {
                    if(!is_dir(self::$layout_path . $d))
                    {
                        if(strtolower($configuration['auto_create_directories']) == 'on')
                        {
                            if(!mkdir(self::$layout_path .$d))
                            {
                                $this->environment_status['CheckLayoutDirectories'] = 0;
                                throw new EnvironmentException('Could not find the directory <b>' . $d . '</b>.
                                We try to create the directory but something unexpected happened:');
                            }
                            //Criando arquivo vazio
                            touch(self::$layout_path . $d . DIRECTORY_SEPARATOR . '.empty');
                        }
                        else
                        {
                            $this->environment_status['CheckLayoutDirectories'] = 0;
                            throw new EnvironmentException('Could not find the directory <b>' . $d . '</b>.');
                        }
                    }
                }
            }
            $this->flag = true;
            return $this->flag;
        }

        public function GetMode()
        {
            $config = Config::GetInstance();
            $configuration = $config::$configuration;
            $mode = $configuration['mode'];

            return $mode;
        }

        /**
         * CheckEnvironment
         * @return bool
         * @throws \core\exceptions\EnvironmentException
         */
        public function CheckEnvironment()
        {
            $this->CheckCoreFiles();
            $this->CheckApplicationFolder();
            $this->CheckLayoutFolder();
            $this->CheckAppDirectories();
            $this->CheckLayoutDirectories();

            if(in_array(0, $this->environment_status) && !$this->flag)
            {
                throw new EnvironmentException('Fail to load environment.');
            }
            $this->flag = true;
            return $this->flag;
        }
    }

// End of file Environment.php
// Location: ./engine/core/environment/Environment.php