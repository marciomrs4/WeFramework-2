<?php

    namespace site\home\controller;

    use \mvc\Controller;

    class Home extends Controller
    {
        public function Index()
        {
            $this->Load()->Model('Home', 'HomeModel');
            $this->Load()->Model('Banner', 'BannerModel');
            $this->Load()->Component('test/Componente', 'Comp');
            //var_dump($this->GetError());
            if($this->Loaded())
            {
                $this->Comp->HelloComponent();
                $this->HomeModel->HelloModel();
                $this->BannerModel->HelloModelBanner();

            }
            $this->Load()->View('index', array('param1' => 1, 'param2' => 2));
        }

        public function Hello()
        {
            $this->Load()->View('home', array('param1' => 1, 'param2' => 2));
        }

    }