<?php
/**
 * -------------------------------------------------------------------------
 * Start Service Render
 * -------------------------------------------------------------------------
 *
 * Este serviço tem como responsabilidade renderizar arquivos e conteúdo
 * armazenado na classe Render
 */

$render = \core\layout\Render::GetInstance();
//Renderiza
if(!$render->Render())
{
    header('Location: http://localhost/dpg-framework-2/404');
}

// End of file render.php
// Location: ./engine/core/init/services/render.php