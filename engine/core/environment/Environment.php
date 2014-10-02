<?php



    namespace core\environment;

    class Environment
    {

        private $flag = false;
        private $environment_status = array();
        private $app_path = null;
        private $lay_path = null;


        private function SetAppPath($path)
        {
            $this->app_path = $path;
        }

        public function GetAppPath()
        {
            return $this->app_path;
        }

        private function SetLayoutPath($path)
        {
            $this->app_path = $path;
        }

        public function GetLayoutPath()
        {
            return $this->app_path;
        }

        public function CheckApplicationFolder($path = null)
        {
            if(isset($path))
            {
                $app_path = $path;
            }
            else
            {
                $app_path = BASEPATH . 'application';
            }

            if(is_dir($app_path))
            {
                $this->SetLayoutPath($app_path . DS);
                $this->environment_status['CheckApplicationFolder'] = 1;
                return true;
            }
            $this->environment_status['CheckApplicationFolder'] = 0;
            return false;
        }


        public function CheckLayoutFolder($path = null)
        {
            if(isset($path))
            {
                $lay_path = $path;
            }
            else
            {
                $lay_path = BASEPATH . 'layout';
            }

            if(is_dir($lay_path))
            {
                $this->SetLayoutPath($lay_path . DS);
                $this->environment_status['CheckLayoutFolder'] = 1;
                return true;
            }
            $this->environment_status['CheckLayoutFolder'] = 0;
            return false;
        }

        public function CheckEnvironment()
        {
            if()
        }
    }