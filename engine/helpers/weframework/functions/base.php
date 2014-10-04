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
function GlobalInclude($file_path) {
    // Verifica se o arquivo existe
    if (isset($file_path) && is_file($file_path))
    {
        // Extrai variáveis do escopo global
        extract($GLOBALS, EXTR_REFS);
        ob_start();
        include_once $file_path;
        return ob_get_clean();
    }
    else
    {
        ob_clean();
       exit('Failed to include ' . $file_path . '. File not found.');
    }
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
    echo GlobalInclude($file);
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
    echo GlobalInclude($file);
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
    echo GlobalInclude($file);
}

/*
 * GetLoop()
 * Inclusão de cabeçalho Html
 */
function GetLoop()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirMainTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'loop.php';
    //Imprimindo arquivo
    echo GlobalInclude($file);
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
    echo GlobalInclude($file);
}