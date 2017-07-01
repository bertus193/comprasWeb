<?php

require_once("user.php");
require_once("subasta.php");

class App extends CI_Model
{
    private $sql;
    private $config;

    public function __construct()
    {
        $this->load->database();
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

    public function getSubastasFinalizadas($total)
    {
        $subastas = array();
        $query = $this->db->query("SELECT id, compradorPjNombre , personaje, creditos, precioTipo, precio, fechaFin, compradorCuenta, now() as now FROM comercio WHERE fechaCompra is not null ORDER BY fechaCompra desc LIMIT 6");
        foreach ($query->result() as $oferta) {
            $oferta = new Subasta($oferta->id, $oferta->personaje, $oferta->creditos, $oferta->precioTipo, $oferta->precio, $oferta->fechaFin, $oferta->now);
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