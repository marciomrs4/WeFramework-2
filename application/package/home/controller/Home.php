<?php

    namespace home\controller;

    use \core\package\mvc\Controller;

    class Home extends Controller
    {
        public function Index()
        {
            echo 'here';
            $this->Load()->Model('Home');
            $this->Home->HelloModel();
            //var_dump($this->Home);
            $this->Load()->View('index', array('param1' => 1, 'param2' => 2));
        }

        public function Hello()
        {
            $this->Load()->View('home', array('param1' => 1, 'param2' => 2));
        }

    }