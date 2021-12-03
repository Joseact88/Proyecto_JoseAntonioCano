<?php
class Tematica implements JsonSerializable
{
    private $idTematica;
    private $descripcion;

    public function __construct($_descripcion) 
    {
        $this->descripcion = $_descripcion;
    }

    public function __get($variable) 
    {
        if(property_exists($this, $variable))
        {
            return $this->$variable;
        }
        
    }
    public function __set($variable, $valor) 
    {
        if(property_exists($this, $variable))
        {
            $this->$variable=$valor;
        }
    }
    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }
}