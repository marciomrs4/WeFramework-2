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
use helpers\weframework\classes\Singleton;

class Layout
{
    use Config;
    use Singleton;

    private $theme_config = null;
    private static $themes = null;
    private static $default = false;
    private static $main_theme = null;
    private static $main_theme_path = null;

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
                    self::$themes = $themes;
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

                self::$main_theme_path = $default;
                self::$main_theme = '';
                self::$default = true;
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
                    self::$default = true;

                }

                if(!file_exists($default))
                    throw new LayoutException('Nothing to show!');

                self::$main_theme_path = $default;
                self::$main_theme = $theme;
                self::$default = true;
            }
        }
        else
        {
            throw new LayoutException('Nothing to show!');
        }
    }

    public function GetIndexTheme()
    {
        if(isset(self::$main_theme_path) && is_file(self::$main_theme_path))
        {
            return self::$main_theme_path;
        }
        throw new LayoutException('Nothing to show!');
    }

    public function GetDirMainTheme()
    {
        $path = LAY_BASEPATH . 'themes' . DS;
        if(!isset(self::$main_theme) || self::$main_theme == '')
        {
            return $path;
        }
        else
        {
            if(is_dir($path . self::$main_theme))
            {
                return $path . self::$main_theme . DS;
            }
        }
        return false;
    }


    public function CheckLayout()
    {
        $this->SetThemes();
       // $this->StartMainTheme();
    }
}

// End of file Layout.php
// Location: ./engine/core/layout/Layout.php


