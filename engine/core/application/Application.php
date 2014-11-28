<?php
/**
 * Class Application
 * Esta classe tem como responsbilidade, verificar se o diretório da aplicação está configurado corretamente. Uma de
 * suas funções é capturar os arquivos de configurações e armazenalas.
 *
 * @package WeFramework
 * @subpackage Application
 * @version 0.1 03/10/2014
 * @author Diogo Brito <diogo@weverest.com.br>
 *
 */
    namespace core\application;
    use helpers\weframework\classes\Config;
    use helpers\weframework\classes\Singleton;

    class Application
    {
        use Singleton;
        use Config;
        /**
         * Armazena o caminho do diretório da aplicação
         * @var string
         */
        private $app_path = null;

        /**
         * Construtor - Como parâmetro o diretório da aplicação
         * @param $app_path
         */
        public function __construtc($app_path)
        {
            $this->app_path = $app_path;
        }

        public function SetDefaultTimeZone()
        {
            $default = $this->GetFileConfig('default.ini');
            if(isset($default['datetimezone']))
            {
                date_default_timezone_set($default['datetimezone']);
            }
        }
    }