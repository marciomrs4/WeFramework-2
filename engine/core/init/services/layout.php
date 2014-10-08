<?php

$layout = \core\layout\Layout::GetInstance();
try
{
    $layout->SetConfig('themes.ini');
    try
    {
        $layout->CheckLayout();
        /*
         * Criação de constantes
         */
        define('WE_THEMES_INSTALLED', $layout->ThemesInstelled());
        define('WE_MAIN_THEME', $layout->GetMainTheme());
        define('WE_THEME_SWITCH_MODE', $layout->SwitchMode());
        define('WE_THEME_DIR', LAY_BASEPATH . 'themes' . DS);

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