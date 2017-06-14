<?php

class Config
{
    private $host = "127.0.0.1";
    private $dbport = 3306;
    private $dbuser = "root";
    private $dbpass = "";
    
    private $database = "local";

    public function getHost()
    {
        return $this->host;
    }

    public function getDBPort()
    {
        return $this->dbport;
    }

    public function getDBUser()
    {
        return $this->dbuser;
    }

    public function getDBPass()
    {
        return $this->dbpass;
    }

    public function getDB()
    {
        return $this->database;
    }
}
