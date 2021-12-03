<?php
class ExamenesRealizados implements JsonSerializable
{
    private $idExamenRealizado;
    private $idExamen;
    private $idUsuario;
    private $fecha;
    private $ejecucion;

    public function __construct($_idExamen,$_idUsuario, $_fecha, $_ejecucion) 
    {
        $this->idExamen = $_idExamen;
        $this->idUsuario=$_idUsuario;
        $this->fecha = $_fecha;
        $this->ejecucion=$_ejecucion;
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