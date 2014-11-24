<?php
    namespace home\model;

    use \mvc\Model;

    class Home extends Model
    {
        public function Welcome()
        {
            /*
             * Exemplo da camada Repository (Banco de Dados)
             *
             * $this->Load()->Repository('FirstRepo', 'Repo');
             * $data = $this->Repo->RepositoryMethod();
             * var_dump($data);
             *
             * Exemplo de carregamento de outros models
             * $this->Load()->Model('AnotherModel', 'AModel');
             * $this->BannerModel->HelloAnotherModel();
             *
             */

            return 'Home is Alive!';
        }
    }