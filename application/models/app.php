<?php

require_once("user.php");
require_once("subasta.php");

class App extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getSubastas($start, $per_page)
    {
        $subastas = array();
        $sql = 'SELECT * FROM comercio WHERE fechaFin > now() AND finalizada = 0 ORDER BY (precio/creditos),id ASC LIMIT ?, ?';
        $query = $this->db->query($sql, array($start, $per_page));
        foreach ($query->result() as $oferta) {
            $oferta = new Subasta($oferta->id, $oferta->personaje, $oferta->creditos, $oferta->precioTipo, $oferta->precio, $oferta->fechaInicio, $oferta->fechaFin, $oferta->compradorPjNombre);
            array_push($subastas, $oferta);
        }

        return $subastas;
    }

    public function getSubastasFinalizadas($total)
    {
        $subastas = array();
        $sql = "SELECT * FROM comercio WHERE fechaCompra is not null ORDER BY fechaCompra desc LIMIT ?";
        $query = $this->db->query($sql, array($total));
        foreach ($query->result() as $oferta) {
            $oferta = new Subasta($oferta->id, $oferta->personaje, $oferta->creditos, $oferta->precioTipo, $oferta->precio, $oferta->fechaInicio, $oferta->fechaFin, $oferta->compradorPjNombre);
            array_push($subastas, $oferta);
        }

        return $subastas;
    }

    public function getRowsSUbastas()
    {
        $query = $this->db->query("SELECT count(*) as total FROM comercio WHERE fechaFin > now() AND finalizada = 0");

        foreach ($query->result() as $result) {
            return $result->total;
        }
    }
}
