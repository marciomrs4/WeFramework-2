<?php
/**
 * We-JS
 * Este serviço tem como objetivo criar algumas funções para javascript
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 */

//Pasta que irá ser gerado o arquivo
$jsPath = WE_THEME_PATH . 'assets' . DS . 'js' . DS . 'scripts' . DS . 'weframework' . DS;

if(is_writable(WE_THEME_PATH . 'assets' . DS))
{
    //Nome do arquivo
    $filename = 'weframework.js';
    //Verifica se o arquivo existe
    if(!file_exists($jsPath . $filename))
    {
        //Verifica se o diretório existe, caso contrário cria-se
        if(!is_dir($jsPath))
            mkdir($jsPath, 0755, true);

        //O dire´torio existe?
        if(is_dir($jsPath))
        {
            //Nome do Arquivo
            $jsFile = $jsPath . $filename;
            //Criação do arquivo
            touch($jsFile);

            if(is_file($jsFile))
            {
                //Conteúdo do arquivo
                //Comentários - START
                $jsContent = "/*" . PHP_EOL;
                $jsContent .= "# WeFramework helper base functions". PHP_EOL;
                $jsContent .= "# File update at " . date('Y-m-d H:i:s') . PHP_EOL;
                $jsContent .= "*/" . PHP_EOL . PHP_EOL . PHP_EOL;
                //Comentários - END

                //Função BaseUrl()- START
                $jsContent .= "function BaseUrl()". PHP_EOL;
                $jsContent .= "{". PHP_EOL;
                $jsContent .= "\t";
                $jsContent .= "return \"" . WE_BASE_URL . "\";" . PHP_EOL;
                $jsContent .= "}". PHP_EOL;
                //Quebra de conteúdo
                $jsContent .= PHP_EOL;
                //Função BaseUrl()- END

                //Função ThemeBaseUrl()- START
                $jsContent .= "function ThemeBaseUrl()". PHP_EOL;
                $jsContent .= "{". PHP_EOL;
                $jsContent .= "\t";
                $jsContent .= "return \"http://" . $_SERVER['HTTP_HOST'] . "/" . WE_REAL_BASE_URL . "/layout/themes/" . ((WE_THEME != '') ? WE_THEME . "/" : '') . "\";" . PHP_EOL;
                $jsContent .= "}". PHP_EOL;
                //Quebra de conteúdo
                $jsContent .= PHP_EOL;
                //Função ThemeBaseUrl()- END

                //Iniciando escrita
                file_put_contents($jsFile, $jsContent);
            }
        }
    }
}