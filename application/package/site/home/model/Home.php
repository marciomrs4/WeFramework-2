<?php
    namespace site\home\model;

    use \mvc\Model;

    class Home extends Model
    {
        public function HelloModel()
        {
              echo '<br/>Hello<br/>';
              $this->Load()->Repository('FirstRepo', 'Repo');
              $this->Repo->Repo();
//            $this->Load()->Model('Banner', 'BannerModel');
//            $this->BannerModel->HelloModelBanner();
            //echo 'Hello Model';
        }
    }