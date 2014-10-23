<?php
    namespace repositories;

    use mvc\Repository;

    class FirstRepo extends Repository
    {
        public function Repo()
        {
            echo '<br>Repository Is Alive</br>';
            var_dump($this->DBConnect());
            var_dump($this->db);
            //$this->DBConnect();
        }
    }