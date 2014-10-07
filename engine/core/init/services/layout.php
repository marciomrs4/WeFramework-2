<?php

$layout = \core\layout\Layout::GetInstance();
try
{
    $layout->SetConfig('themes.ini');
    try
    {
        $layout->CheckLayout();
        $render = \core\layout\Render::GetInstance();
        $render->RenderQueueAdd($layout->GetIndexTheme());
    }catch (\core\exceptions\LayoutException $l)
    {
        \core\init\Service::SetError('layout.php', $l->getMessage());
    }
}
catch (\core\exceptions\ConfigException $e)
{
    \core\init\Service::SetError('layout.php', $e->getMessage());
}



// End of file layout.php
// Location: ./engine/core/init/services/layout.php