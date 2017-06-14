<?php

class User
{
    private $name;
    private $creditos;

    public function __construct($name, $creditos)
    {
        $this->name = $name;
        $this->creditos = $creditos;
    }

    public function getName()
    {
        return $name;
    }

    public function getCreditos()
    {
        return $creditos;
    }
}
