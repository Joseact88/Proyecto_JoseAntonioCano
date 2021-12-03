<?php
class Usuario
{
    private $idUsuario;
    private $nombre;
    private $apellidos;
    private $password;
    private $fechaNac;
    private $idRol;
    private $activo;
    private $correo;

    public function __construct($_nombre,$_apellidos, $_password, $_fechaNac, $_idRol, $_activo, $_correo) 
    {
        $this->nombre = $_nombre;
        $this->apellidos=$_apellidos;
        $this->password = $_password;
        $this->fechaNac=$_fechaNac;
        $this->idRol = $_idRol;
        $this->activo=$_activo;
        $this->correo=$_correo;
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
}