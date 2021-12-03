<?php
class Respuesta implements JsonSerializable
{
    private $idRespuesta;
    private $respuesta;
    private $idPregunta;

    public function __construct($_respuesta,$_idPregunta) 
    {
        $this->respuesta = $_respuesta;
        $this->idPregunta=$_idPregunta;
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