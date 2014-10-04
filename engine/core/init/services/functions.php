<?php
    /**
     * -------------------------------------------------------------------------
     * Start Service Functions
     * -------------------------------------------------------------------------
     * Este arquivo tem como responsabilidade iniciar os arquivos com funções
     */

    try
    {
        $func = new \core\init\Functions();
        $functions = $func->GetFunctions();

        //Incluindo arquivos
        if(is_array($functions) && count($functions) > 0)
        {
            foreach ($functions as $f)
            {
                 include_once $f;
            }
        }

    }
    catch (\core\exceptions\FunctionsException $e)
    {
        \core\init\Service::SetError('functions.php', $e->getMessage());
    }