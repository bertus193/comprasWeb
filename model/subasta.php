<?php

class Subasta
{
    private $id;
    private $personaje;
    private $creditos;
    private $precioTipo;
    private $precio;

    private $fechaInicio;
    private $fechaFin;

    public function getId()
    {
        return $id;
    }

    public function getPersonaje()
    {
        return $personaje;
    }

    public function getCreditos()
    {
        return $creditos;
    }

    public function getPrecioTipo()
    {
        return $precioTipo;
    }

    public function getPrecio()
    {
        return $precio;
    }

    public function getFechaInicio()
    {
        return $fechaInicio;
    }

    public function getFechaFin()
    {
        return $fechaFin;
    }


    public function setId($id)
    {
        return $id;
    }

    public function setPersonaje($personaje)
    {
        $this->personaje = $personaje;
    }

    public function setCreditos($creditos)
    {
        $this->creditos = $creditos;
    }

    public function setPrecioTipo($precioTipo)
    {
        $this->precioTipo = $precioTipo;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }
}
