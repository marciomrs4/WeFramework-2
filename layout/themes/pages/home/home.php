<?php
    /*
     * Carregamento de conteúdo para a página inicial e home
     */
    RequirePage('index|home', 'pages/home/welcome_message.php', true);

    /*
     * Controle da página
     * Caso Require page retorne um erro, a página será redirecionada para 404 - Not Found
     */
    ControllPage();