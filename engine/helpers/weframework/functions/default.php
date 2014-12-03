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
 * GLOBALS VARS
 *
 */
static $CONTROLL_PAGE = array();




/**
 * GlobalInclude
 * Inclui dentro do escopo as variávies globais
 *
 * @param $file_path
 * @return string
 */
function TemplateContent($file_path)
{
    return mvc\View::GetInstance()->Compile($file_path, true);
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
    $main_theme = $lay->GetDirTheme();
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
    $main_theme = $lay->GetDirTheme();
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
    $main_theme = $lay->GetDirTheme();
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
    $file_loop = \core\layout\Render::GetInstance()->Render(true);
    if(!$file_loop)
    {
        header('Location: '.\core\router\Router::GetInstance()->BaseURL() . '404');
    }
    else
    {
        echo TemplateContent($file_loop);
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
    $main_theme = $lay->GetDirTheme();
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
    return 'http://'.$_SERVER['HTTP_HOST'].'/'.WE_REAL_BASE_URL.'/layout/themes/'.((WE_THEME != '') ? '/' : '');
}

/**
 * IncludeFile
 * Inclusão de um arquivo
 *
 * @return void
 * @param $file
 * @param $controll
 */
function IncludeFile($file, $controll = null)
{
    $file = GetBaseThemePath().$file;
    if(is_file($file))
    {
        if($controll === true)
            StatusPage(true);

        echo TemplateContent($file);
    }
    else
    {
        if($controll === true)
            StatusPage(false);

        echo 'File not found: '.$file;
    }
}

/**
 * RequirePage
 * Esta funcção testa a fágine e inclui um arquivo
 * @param $url_page
 * @param null $file
 * @param $controll
 * @return bool
 */
function RequirePage($url_page, $file = null, $controll = false)
{
    $flag = mvc\View::GetInstance()->RequirePage($url_page);
    if(isset($file) && $flag === true)
    {
        IncludeFile($file, $controll);
    }

    return $flag;
}


/**
 * ControllPage
 * Controle de requisições de páginas
 *
 * @param null $flag
 * @return bool
 */
function StatusPage($flag = null)
{
    return mvc\View::GetInstance()->ControllPage($flag);
}

/**
 * StatusPage
 * Verifica status da página e redireciona para o status correto
 *
 * @return void
 */
function ControllPage()
{
    $controll = StatusPage();

    if($controll === false)
        header('Location: ' . BaseURL() . '404');
}

/**
 * MenuActive
 *
 * @param $page
 * @param $class
 */
function MenuActive($page, $class)
{
    if(RequirePage($page))
        echo $class;
}