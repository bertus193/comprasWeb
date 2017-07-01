<?php

require_once("config.php");
require_once("user.php");
require_once("subasta.php");

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
        $sql = mysql_connect($this->config->getHost() . ':' . $this->config->getDBPort(), $this->config->getDBUser(), $this->config->getDBPass());
        mysql_select_db($this->config->getDB());
        mysql_query("SET NAMES 'utf8'", $sql);
        return $sql;
    }

    public function getSubastas($start, $per_page)
    {
        $subastas = array();
        $query = mysql_query("SELECT id, personaje, creditos, precioTipo, precio, fechaFin, now() as now FROM comercio WHERE fechaFin > now() AND finalizada = 0 ORDER BY (precio/creditos),id ASC LIMIT $start, $per_page");

        while ($oferta = mysql_fetch_array($query)) {
            $oferta = new Subasta($oferta["id"], $oferta["personaje"], $oferta["creditos"], $oferta["precioTipo"], $oferta["precio"], $oferta["fechaFin"], $oferta["now"]);
            array_push($subastas, $oferta);
        }

        return $subastas;
    }

    public function getRowsSUbastas()
    {
        $query = mysql_query("SELECT count(*) as total FROM comercio WHERE fechaFin > now() AND finalizada = 0");

        while ($result = mysql_fetch_array($query)) {
            return $result["total"];
        }
    }
}
