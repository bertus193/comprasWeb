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

    public function __construct($id, $personaje, $creditos, $precioTipo, $precio, $fechaInicio, $fechaFin)
    {
        $this->setId($id);
        $this->setPersonaje($personaje);
        $this->setCreditos($creditos);
        $this->setPrecioTipo($precioTipo);
        $this->setPrecio($precio);
        $this->setFechaInicio($fechaInicio);
        $this->setFechaFin($fechaFin);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPersonaje()
    {
        return $this->personaje;
    }

    public function getCreditos()
    {
        return $this->creditos;
    }

    public function getPrecioTipo()
    {
        return $this->precioTipo;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function getFechaFin()
    {
        return $this->fechaFin;
    }


    public function setId($id)
    {
        $this->id = $id;
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
