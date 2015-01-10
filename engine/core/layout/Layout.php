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
    private static $themes_installed = 1;
    private static $themes_definitions = array();
    private static $themes_alias = array();
    private static $theme_alias = null;

    public function SetConfig($config_file, $flag = false)
    {
        if(strpos($config_file, '.ini') !== false)
        {
            $this->theme_config = self::GetFileConfig($config_file, $flag);
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
            foreach($this->theme_config as $k => $val)
            {
                $preg = preg_match('@^theme([0-9]?)$@', $k, $match);
                if($preg)
                {
                    $themes[] = $k;
                    $definitions = $this->theme_config[$k];
                    if(empty($definitions['theme']))
                        $theme = 'default';
                    else
                        $theme = $definitions['theme'];

                    self::$themes_definitions[$theme] = array(
                        'package' => $definitions['package'],
                        'page_index' => $definitions['page_index'],
                        'alias_theme' => $definitions['alias_theme'],
                        'auth' => (bool) $definitions['auth'],
                        'auth_page' => $definitions['auth_page'],
                        'auth_lazy_time' => $definitions['auth_lazy_time']
                    );
                    //Registrando Alias para performace do carregamento dos temas
                    self::$themes_alias[$theme] = $definitions['alias_theme'];
                }
            }
            //Verificando se existe mais de um tema
            if(is_array($themes))
            {
                if(count($themes) > 0 && !in_array('', $themes))
                {
                    self::$themes = $themes;
                    self::$themes_installed = count($themes);
                }
            }
        }
    }

    public function ThemesInstelled()
    {
        return self::$themes_installed;
    }

    public function GetConfiguration()
    {
        return $this->$theme_config;
    }

    public function SwitchMode()
    {
        if(strtolower($this->theme_config['main_theme']['switch_themes']) == 'on')
            return true;

        return false;
    }

    public function GetMainTheme()
    {
        return self::$main_theme;
    }

    public function StartMainTheme()
    {
        if(isset($this->theme_config))
        {
            $theme = $this->theme_config['main_theme']['main_theme'];

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
        if(defined('WE_THEME'))
        {
            return LAY_BASEPATH . 'themes' . DS . WE_THEME . DS . 'index.php';
        }
        elseif(isset(self::$main_theme_path) && is_file(self::$main_theme_path))
        {
            return self::$main_theme_path;
        }
        throw new LayoutException('Nothing to show!');
    }

    public function GetPageIndex()
    {
        $index = 'home';
        if(defined('WE_THEME'))
        {
            if(WE_THEME == '')
                $theme = 'default';
            else
                $theme = WE_THEME;

            if(isset(self::$themes_definitions[$theme]['page_index']) && self::$themes_definitions[$theme]['page_index'] != '')
            {
                $index = self::$themes_definitions[$theme]['page_index'];
            }
        }
        return $index;
    }

    public function GetPackage()
    {
        $package = '';
        if(defined('WE_THEME') && strlen(WE_THEME) > 0)
        {
            if(isset(self::$themes_definitions[WE_THEME]['package']))
            {
                $package = self::$themes_definitions[WE_THEME]['package'];
            }
        }
        else
        {
            if(isset(self::$themes_definitions['default']['package']))
            {
                $package = self::$themes_definitions['default']['package'];
            }
        }
        return $package;
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

    public function GetThemeByAlias($controller, $return_alias = false)
    {
        $alias = '';
        //Verifica se o alias já foi encontrado e armazenado
        if(!isset(self::$theme_alias) && $return_alias === false)
        {
            $k_alias = array_search($controller, self::$themes_alias);
            if($k_alias)
            {
                $alias = $k_alias;
                self::$theme_alias  = $alias;
            }

            elseif(isset(self::$themes_alias[$controller]))
            {
                $alias = $controller;
            }
        }
        elseif($return_alias === true)
        {
            $k_alias = array_search($controller, self::$themes_alias);
            if($k_alias)
            {
                $alias = self::$themes_alias[$k_alias];
            }
        }
        else
        {
            return self::$theme_alias;
        }

        return $alias;

    }

    public function GetProperties()
    {
        if(WE_THEME == '')
            $theme = 'default';
        else
            $theme = WE_THEME;

        return self::$themes_definitions[$theme];
    }

    public function GetDirTheme()
    {
        if(defined('WE_THEME_PATH'))
        {
            $path = WE_THEME_PATH;
            if(is_dir($path))
                return $path;
            else
                return null;
        }
        else
        {
            $this->GetDirMainTheme();
        }
    }

    public function CheckLayout()
    {
        $this->SetThemes();
        $this->StartMainTheme();
    }



}

// End of file Layout.php
// Location: ./engine/core/layout/Layout.php


