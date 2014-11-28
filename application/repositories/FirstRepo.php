<?php
    namespace repositories;

    use mvc\Repository;

    class FirstRepo extends Repository
    {
        public function RepositoryMethod()
        {

            /*
             * $sql = "SELECT * FROM tbl_test";
             * $stmt = $this->DB->prepare($sql);
             * $stmt->execute();
             * retrun $stmt->fetchAll(\PDO::FETCH_OBJ);
             */
        }
    }