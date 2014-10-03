<?php



    namespace core\environment;

    use core\exceptions\ServiceException;

    class Environment
    {

        private $flag = false;
        private $environment_status = array();


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
                $this->flag = true;
                return $this->flag;
            }
            $this->environment_status['CheckApplicationFolder'] = 0;
            throw new ServiceException('Failed to load directory <b>' . $app_path . '</b>. Environment cannot be started.');
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
                $this->flag = true;
                return $this->flag;
            }
            $this->environment_status['CheckLayoutFolder'] = 0;
            //Gerando erro do serviço
            throw new ServiceException('Failed to load directory <b>' . $lay_path . '</b>. Environment cannot be started.');
            return false;
        }

        /**
         * CheckEnvironment
         * @return bool
         * @throws \core\exceptions\ServiceException
         */
        public function CheckEnvironment()
        {
            if(in_array(0, $this->environment_status) && !$this->flag)
            {
                throw new ServiceException('Fail to load environment.');
            }
            $this->flag = true;
            return $this->flag;
        }
    }