<?php
class Pregunta implements JsonSerializable
{
    private $idPregunta;
    private $enunciado;
    private $idTematica;
    private $idRespuestaCorrecta;
    private $recurso;
    private $tematica;

    public function __construct($_enunciado,$_idTematica, $_idRespuestaCorrecta, $_recurso, $_tematica) 
    {
        $this->enunciado = $_enunciado;
        $this->idTematica=$_idTematica;
        $this->idRespuestaCorrecta = $_idRespuestaCorrecta;
        $this->recurso=$_recurso;
        $this->tematica=$_tematica;
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