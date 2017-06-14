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
}
