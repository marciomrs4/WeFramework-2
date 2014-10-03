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


        public function CheckCoreFiles()
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
        public function CheckApplicationFolder($path = null)
        {
            //Verifica se o parâmetro foi definido, caso o contrário o diretório padrão será do framework será definido
            if(isset($path))
            {
                $app_path = self::$application_path = $path;
            }
            else
            {
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
        public function CheckLayoutFolder($path = null)
        {
            //Verifica se o parâmetro foi definido, caso o contrário o diretório padrão será do framework será definido
            if(isset($path))
            {
                $lay_path = self::$layout_path = $path;
            }
            else
            {
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
         * CheckEnvironment
         * @return bool
         * @throws \core\exceptions\EnvironmentException
         */
        public function CheckEnvironment()
        {
            $this->CheckCoreFiles();
            $this->CheckApplicationFolder();
            $this->CheckLayoutFolder();

            if(in_array(0, $this->environment_status) && !$this->flag)
            {
                throw new EnvironmentException('Fail to load environment.');
            }
            $this->flag = true;
            return $this->flag;
        }
    }