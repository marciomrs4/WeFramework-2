<?php
/**
 * Functions
 * Classe responsável por gerenciar or arquivos de funções do framework.
 *
 * @package WeFramework
 * @subpackage Functions
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 02/09/2014
 *
 */

namespace core\init;

use core\exceptions\FunctionsException;
use core\exceptions\ServiceException;
use helpers\weframework\classes\Singleton;

class Functions
{

    use Singleton;

    /**
     * Propriedade responsável por armazenar a instância da classe Config
     *
     * @access protected
     * @var null
     */
    protected  $configuration = null;

    /**
     * Propriendade para armazenar as funções definidas no arquivo de configuração
     *
     * @access protected
     * @var array
     */
    protected $functions = array();

    public function GetFunctions()
    {
        $config = Config::GetInstance();
        $func = $this->configuration = $config::$configuration['functions'];
        if(is_array($func) && count($func) > 0)
        {
            foreach($func as $f)
            {
                if(!is_file(BASEPATH . $f))
                    throw new FunctionsException('File not found ' . $f);
                else
                    $this->functions[] = BASEPATH . $f;
            }
        }

        return $this->functions;
    }

}

// End of file Service.php
// Location: ./engine/core/init/Service.php

