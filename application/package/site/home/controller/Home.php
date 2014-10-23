<?php

    namespace site\home\controller;

    use \mvc\Controller;

    class Home extends Controller
    {
        public function Index()
        {
            $this->Load()->Model('Home', 'HomeModel');
            $this->Load()->Component('test/Componente', 'Comp');

            if($this->Loaded())
            {
                $this->HomeModel->HelloModel();
                $this->Comp->HelloComponent();
            }

            $this->Load()->View('index', array('param1' => 1, 'param2' => 2));
        }


        public function Hello()
        {
            $this->Load()->View('home', array('param1' => 1, 'param2' => 2));
        }

    }