<?php
    $page_control = false;
    /*
     * Carregamento de conteúdo para a página inicial e home
     */
    if(RequirePage('index|home', 'pages/home/welcome_message.php'))
    {
    	$page_control = true;
    }

    /*
     * Carregamento de conteúdo para a página component
     */
    elseif(RequirePage('home/component', 'pages/home/component_message.php'))
    {
    	$page_control = true;
    }

    if($page_control === false)
    	header('Location: ' . BaseURL() . '404');
