<?php
require_once "../../miAutoLoader.php";
class Login
{
    public static function identificaUsuario(string $usuario,string $password,bool $recuerdame)
    {
        //Comprobamos si existe el usuario
        if(self::existeUsuario($usuario,$password))
        {
            //Iniciamos la sesion y metemos dentro el usuario
            Sesion::iniciar();
            Sesion::escribir('login',$usuario); 
            //Vemos si quiere que le recordemos la sesión
            if($recuerdame)
            {
                $nombrePass=array();
                $nombrePass[]=$usuario;
                $nombrePass[]=$password;
                //Creamos una cookie con el nombre de usuario
                setcookie('recuerdame',json_encode($nombrePass),time()+30*24*60*60);
            }
            return true;
        }
        return false;
    }
    public static function existeUsuario($usuario, $password)
    {
        
        //Comprobamos si existe el usuario
        GBD::abreConexion();
        return GBD::existeUsuario($usuario, $password);
    }
    public static function estaLogueado()
    {
        $cookie=json_decode($_COOKIE['recuerdame']);
        $usuario=$cookie[0];
        $password=$cookie[1];
        //Comprobamos si existe la sesion login
        if(Sesion::leer('login'))
        {
            return true;
        }
        elseif(isset($_COOKIE['recuerdame']) && self::ExisteUsuario($usuario,$password));
        {
            //Iniciamos la sesion y la creamos(recuerdame)
            Sesion::iniciar();
            Sesion::escribir('login',$_COOKIE['recuerdame']);
            return true;
        }
        return false;
    }
}
