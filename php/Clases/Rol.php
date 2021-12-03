<?php
class Rol implements JsonSerializable
{
    private $idRol;
    private $nombre;

    public function __construct($_nombre) 
    {
        $this->nombre = $_nombre;
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