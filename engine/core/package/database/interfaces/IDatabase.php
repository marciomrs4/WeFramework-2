<?php

namespace core\package\database\interfaces;
/**
 * Interface IDatabase
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @package WeFramework
 * @subpackage Data Base
 */
interface IDatabase
{
    public function __construct($properties);
    public function Connection();
    public function CloseConnection();
    public function DBInstance();
    public function DBError();
}