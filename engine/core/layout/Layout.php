<?php
/**
 * Layout
 * Esta classe é responsvel por manipular o template da aplicação.
 *
 * @package WeFramework
 * @subpackage Layout
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 03//09/2014
 *
 */
namespace core\layout;


use core\exceptions\LayoutException;
use helpers\weframework\classes\Config;

class Layout
{
    use Config;

    private $theme_config = null;
    private $themes = null;
    private $default = false;
    private $main_theme = null;

    public function SetConfig($config_file)
    {
        if(strpos($config_file, '.ini') !== false)
        {
            $this->theme_config = self::GetFileConfig($config_file);
        }
        else
        {
            throw new ConfigException('The config file must be .ini');
        }
    }

    private function SetThemes()
    {

        if(isset($this->theme_config))
        {
            $themes = $this->theme_config['themes'];

            //Verificando se existe mais de um tema
            if(is_array($themes))
            {
                if(count($themes) > 0 && !in_array('', $themes))
                {
                    $this->themes = $themes;
                }
            }
        }
    }

    public function StartMainTheme()
    {
        if(isset($this->theme_config))
        {
            $theme = $this->theme_config['main_theme'];

            //Verificando se existe mais de um tema
           if($theme == '')
            {
                $default = LAY_BASEPATH . 'themes' . DS . 'index.php';
                if(!file_exists($default))
                    throw new LayoutException('Nothing to show!');

                $this->main_theme = $default;
                $this->default = true;
            }
            else
            {
                if(strpos($theme, '.php') !== false)
                {
                    $default = LAY_BASEPATH . 'themes' . DS . $theme;
                }
                else
                {
                    $default = LAY_BASEPATH . 'themes' . DS . $theme . DS . 'index.php';
                    $this->default = true;

                }

                if(!file_exists($default))
                    throw new LayoutException('Nothing to show!');

                $this->main_theme = $default;
                $this->default = true;
            }
        }
        else
        {
            throw new LayoutException('Nothing to show!');
        }
    }

    public function GetIndexTheme()
    {
        if(isset($this->main_theme))
        {
            return $this->main_theme;
        }
        var_dump($this->main_theme);
        throw new LayoutException('Nothing to show!');
    }


    public function CheckLayout()
    {
        $this->SetThemes();
        $this->StartMainTheme();
    }
}

// End of file Layout.php
// Location: ./engine/core/layout/Layout.php


