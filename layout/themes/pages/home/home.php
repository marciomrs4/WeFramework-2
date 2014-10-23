<?php
    /*
     * Carregamento de conteúdo para a página inicial e home
     */
    RequirePage('index|home', 'pages/home/welcome_message.php');

    /*
     * Carregamento de conteúdo para a página component
     */
    RequirePage('home/component', 'pages/home/component_message.php');