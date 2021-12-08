<?php
class Examen implements JsonSerializable
{
    private $idExamen;
    private $descripcion;
    private $duracion;
    private $activo;
    private $numPreguntas;

    public function __construct($_descripcion,$_duracion, $_activo, $_numPreguntas) 
    {
        $this->descripcion = $_descripcion;
        $this->duracion=$_duracion;
        $this->activo = $_activo;
        $this->numPreguntas = $_numPreguntas;
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