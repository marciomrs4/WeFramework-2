<?php
/**
 * -----------------------------------------------------
 * BASE
 * -----------------------------------------------------
 * Este arquivo de funções tem como responsabilidade gerenciar o corpa base da página HTML
 *
 * @package WeFramework
 * @subpackage Helpers/WeFramework/Functions
 * @auhor Diogo Brito
 * @version 0.1 - 04/10/2014
 */


/**
 * GlobalInclude
 * Inclui dentro do escopo as variávies globais
 *
 * @param $file_path
 * @return string
 */
function TemplateContent($file_path)
{
    return \core\package\mvc\View::GetInstance()->Compile($file_path, true);
}

/*
 * GetHead()
 * Inclusão de cabeçalho Html
 */
function GetHead()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirMainTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'head.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/*
 * GetHeader()
 * Inclusão de cabeçalho Html
 */
function GetHeader()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirMainTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'header.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/*
 * GetContent()
 * Inclusão de cabeçalho Html
 */
function GetContent()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirMainTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'content.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/*
 * GetLoop()
 * Conteúdo dinâmico da página
 */
function GetLoop()
{
    if(!\core\layout\Render::GetInstance()->Render())
    {
        header('Location: '.\core\router\Router::GetInstance()->BaseURL() . '404');
    }
    echo PHP_EOL;
}

/*
 * GetLoop()
 * Inclusão de cabeçalho Html
 */
function GetFooter()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirMainTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'footer.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/**
 * GetBaseThemePath()
 * Esta função retorna o caminho do tema atual
 *
 * @return string
 */
function GetBaseThemePath()
{
    if(defined('WE_THEME_PATH'))
    {
        return WE_THEME_PATH;
    }
    return '';
}

/**
 * PageIndex
 * @return string
 */
function PageIndex()
{
    if(defined('WE_THEME_PAGE_INDEX'))
    {
        return WE_THEME_PAGE_INDEX;
    }
    return '';
}

/**
 * BaseURL
 * @return string
 */
function BaseUrl()
{
    if(defined('WE_BASE_URL'))
    {
        return WE_BASE_URL;
    }
    return '';
}

/**
 * ThemeBaseUrl
 * Retorna  a URL do tema atual
 * @return string
 */
function ThemeBaseUrl()
{
    return 'http://'.$_SERVER['HTTP_HOST'].'/'.WE_REAL_BASE_URL.'/layout/themes/'.WE_THEME.'/';
}

/**
 * IncludeFile
 * Inclusão de um arquivo
 *
 * @return void
 * @param $file
 */
function IncludeFile($file)
{
    $file = GetBaseThemePath().$file;
    if(is_file($file))
        echo TemplateContent($file);
    else
        echo 'File not found: '.$file;
}

/**
 * RequirePage
 * Esta funcção testa a fágine e inclui um arquivo
 * @param $url_page
 * @param null $file
 * @return bool
 */
function RequirePage($url_page, $file = null)
{
    //URI da aplicação sem a URL base
    $uri = explode('/', WE_URI_PROJECT);
    //URL requisitada
    $url = explode('/', $url_page);
    //Variáveis de controle
    $flag = 0;
    $flag_final = false;

    //Verificamos se o tema atual é adicional e não o principal
    //Se sim, retiramos o primeiro elemento da URI
    if(WE_IS_HOT_THEME)
        unset($uri[0]);

    //Verificamos se o número da requisição é igual ao URI
    if(count($url) > 0 && count($url) == count($uri))
    {
        //Percorrendo URL
        foreach($url as $k => $page)
        {
            //Testando valores
            if($uri[$k] == $page || $page == '*')
            {
                $flag++;
            }
            else
            {
                break;
                $flag_final = false;
            }
        }

        if($flag > 0 && $flag == count($uri))
        {
            $flag_final = true;
        }
    }
    if(isset($file) && $flag_final === true)
    {
        IncludeFile($file);
    }
    return $flag_final;
}