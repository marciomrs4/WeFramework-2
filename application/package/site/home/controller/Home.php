<?php
    class Home extends \core\package\mvc\Controller
    {
        public function Index()
        {

        }

        public function Hello()
        {
            $this->Load()->View('home/hello', array('param1' => 1, 'param2' => 2));
        }

    }