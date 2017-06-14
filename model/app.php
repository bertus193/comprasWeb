<?php

require_once("config.php");
require_once("user.php");

class App
{
    private $sql;
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function getSql()
    {
        $sql = mysql_connect($this->config->getHost() . ':' . $this->config->dbport, $this->config->dbuser, $this->config->dbpass);
        mysql_select_db($config->database);
        mysql_query("SET NAMES 'utf8'", $sql);
        return $sql;
    }
}
