<?php
    $page_control = false;
    /*
     * Carregamento de conteúdo para a página inicial e home
     */
    if(RequirePage('index|home', 'pages/home/welcome_messag.php', true))
    {
        $page_control = true;
    }

    /*
     * Carregamento de conteúdo para a página component
     */
    elseif(RequirePage('home/component', 'pages/home/component_message.php', true))
    {
    	$page_control = true;
    }

    //var_dump(ControllPage());
    //die();

    if($page_control === false)
    	header('Location: ' . BaseURL() . '404');
