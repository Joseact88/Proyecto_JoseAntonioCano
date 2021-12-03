<?php
require_once "../../miAutoLoader.php";
class GBD
{
    private static $conexion;
    //Abrir conexion
    public static function abreConexion()
    {
        self::$conexion= new PDO('mysql:host=localhost;dbname=autoescuela', 'root', '');
    }
    //Lee un usuario dado su nombre de usuario y su contraseña
    public static function leeUsuario($NombreUsuario, $password)
    {
        $consulta = self::$conexion->query("Select idUSuario, nombre, apellidos, password,fechaNac, idRol, activo, correo FROM usuario where nombre='$NombreUsuario' && password='$password'");
        $usuario=null;
        while ($registro = $consulta->fetch()) 
        {
            $usuario=new Usuario($registro['nombre'],$registro['apellidos'],$registro['password'],$registro['fechaNac'],$registro['idRol'],$registro['activo'], $registro['correo']);
            $usuario->idUsuario=$registro['idUSuario'];
        }
        
        return $usuario;
    }
    //Lee un usuario dado su nombre de usuario y su contraseña
    public static function leeNombreUsuario($idUsuario)
    {
        $idUsuario=intval($idUsuario);
        $consulta = self::$conexion->query("Select nombre FROM usuario where idUsuario=$idUsuario");
        while ($registro = $consulta->fetch()) 
        {
            $nombreUsuario=$registro['nombre'];
        }
        
        return $nombreUsuario;
    }
    //Insertamos un usuario
    public static function grabaUsuario(Usuario $a)
    {
        $nombre =$a->nombre;
        $apellidos =$a->apellidos;
        $password =md5($a->password);
        $fechaNac =$a->fechaNac;
        $idRol =$a->idRol;
        $activo =$a->activo;
        $correo =$a->correo;

        $consulta = self::$conexion->prepare("Insert into usuario (nombre, apellidos, password, fechaNac, idRol, activo, correo) VALUES (:nombre, :apellidos, :password, :fechaNac, :idRol, :activo, :correo)");
        
        $consulta->bindParam(':nombre',$nombre);
        $consulta->bindParam(':apellidos',$apellidos);
        $consulta->bindParam(':password',$password);
        $consulta->bindParam(':fechaNac',$fechaNac);
        $consulta->bindParam(':idRol',$idRol);
        $consulta->bindParam(':activo',$activo);
        $consulta->bindParam(':correo',$correo);
        
        $consulta->execute();
    }
    //Modificamos un usuario
    public static function modificaUsuario(Usuario $a)
    {
        $idUsuario=$a->idUsuario;
        $nombre =$a->nombre;
        $apellidos =$a->apellidos;
        $password =$a->password;
        $fechaNac =$a->fechaNac;
        $idRol =$a->idRol;
        $activo =$a->activo;
        $correo =$a->correo;

        $consulta = self::$conexion->prepare("Update usuario set nombre='$nombre', apellidos='$apellidos', password='$password', fechaNac='$fechaNac', idRol='$idRol' , activo='$activo',Correo='$correo' where idUsuario='$idUsuario'");
        
        $consulta->execute();
    }
    //Comprobamos si existe el usuario que nos pasa
    public static function existeUsuario($NombreUsuario, $password)
    {
        $usuario=null;
        $usuario=self::leeUsuario($NombreUsuario,$password);
        if($usuario!=null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
     //Método que obtiene el id del ultimo usuario añadido
     public static function obtieneUltimoIdUsuario()
     {
         $consulta = self::$conexion->query("Select idUsuario FROM usuario order by idUsuario desc limit 1");
         while ($registro = $consulta->fetch()) 
         {
             $idUsuario=$registro['idUsuario'];
         }
         
         return $idUsuario;
     }
    //Comprobamos si existe el alta que nos pasa
    public static function leeAltaPorConfirmar($idAltaPorConfirmar)
    {
        $consulta = self::$conexion->query("Select idUsuario FROM altasconfirmar where idAltaConfirmar='$idAltaPorConfirmar'");
        
        while ($registro = $consulta->fetch()) 
        {
            $idUsuario=$registro['idUsuario'];
        }
        return $idUsuario;
    }
    //Comprobamos si existe el usuario que nos pasa
    public static function insertaAltaPorConfirmar($idAltaPorConfirmar,$idUsuario)
    {
        $idUsuario=intval($idUsuario);
        $consulta = self::$conexion->prepare("Insert into altasconfirmar (idAltaConfirmar, idUsuario) VALUES ('$idAltaPorConfirmar', $idUsuario)");
        
        $consulta->execute();
    }
    //Leemos todos los usuarios con rol 2 (alumnos)
    public static function leeListaUsuarios()
    {
        $consulta = self::$conexion->query("Select idUSuario, nombre, apellidos, password,fechaNac, activo, correo FROM usuario where idRol='2'");
        $usuarios=array();
        while ($registro = $consulta->fetch()) 
        {
            $usuario=new Usuario($registro['nombre'],$registro['apellidos'],$registro['password'],$registro['fechaNac'],2,$registro['activo'], $registro['correo']);
            $usuario->idUsuario=$registro['idUSuario'];
            $usuarios[]=$usuario;
        }
        
        return $usuarios;
    }
    //Leemos todos los roles
    public static function leeListaRoles()
    {
        $consulta = self::$conexion->query("Select idRol, nombre FROM rol");
        $roles=array();
        while ($registro = $consulta->fetch()) 
        {
            $rol=new Rol($registro['nombre']);
            $rol->idRol=$registro['idRol'];
            $roles[]=$rol;
        }
        
        return $roles;
    }

    //Lee una tematica dado su id
    public static function leeTematica($idTematica)
    {
        $consulta = self::$conexion->query("Select descripcion FROM tematica where idTematica='$idTematica'");
        $tematica=null;
        while ($registro = $consulta->fetch()) 
        {
            $tematica=new Tematica($registro['descripcion']);
            $tematica->idTematica=$idTematica;
        }
        
        return $tematica;
    }
    //Insertamos una tematica
    public static function grabaTematica(Tematica $a)
    {
        $descripcion =$a->descripcion;

        $consulta = self::$conexion->prepare("Insert into tematica (descripcion) VALUES (:descripcion)");
        
        $consulta->bindParam(':descripcion',$descripcion);
        
        $consulta->execute();
    }
    //Modificamos una tematica
    public static function modificaTematica(Tematica $a)
    {
        $idTematica=$a->idTematica;
        $descripcion =$a->descripcion;

        $consulta = self::$conexion->prepare("Update tematica set descripcion='$descripcion' where idTematica='$idTematica'");
        
        $consulta->execute();
    }
    //Leemos todas las tematicas
    public static function leeListaTematicas()
    {
        $consulta = self::$conexion->query("Select idTematica, descripcion FROM tematica");
        $tematicas=array();
        while ($registro = $consulta->fetch()) 
        {
            $tematica=new Tematica($registro['descripcion']);
            $tematica->idTematica=$registro['idTematica'];
            $tematicas[]=$tematica;
        }
        
        return $tematicas;
    }

    //Preguntas
    //Lee una pregunta dado su id
    public static function leePregunta($idPregunta)
    {
        $consulta = self::$conexion->query("Select enunciado, idTematica, idRespuestaCorrecta, recurso FROM pregunta where idPregunta='$idPregunta'");
        $pregunta=null;
        while ($registro = $consulta->fetch()) 
        {
            $pregunta=new Pregunta($registro['enunciado'], $registro['idTematica'],$registro['idRespuestaCorrecta'],$registro['recurso']);
            $pregunta->idPregunta=$idPregunta;
        }
        
        return $pregunta;
    }
    //Insertamos una pregunta
    public static function grabaPregunta(Pregunta $a)
    {
        $enunciado =$a->enunciado;
        $idTematica =$a->idTematica;
        $idRespuestaCorrecta =$a->idRespuestaCorrecta;
        $recurso =$a->recurso;

        $consulta = self::$conexion->prepare("Insert into pregunta (enunciado, idTematica, idRespuestaCorrecta, recurso) VALUES (:enunciado, :idTematica, :idRespuestaCorrecta, :recurso)");
        
        $consulta->bindParam(':enunciado',$enunciado);
        $consulta->bindParam(':idTematica',$idTematica);
        $consulta->bindParam(':idRespuestaCorrecta',$idRespuestaCorrecta);
        $consulta->bindParam(':recurso',$recurso);
        
        $consulta->execute();
    }
    //Modificamos una pregunta
    public static function modificaPregunta(Pregunta $a)
    {
        $idPregunta=$a->idPregunta;
        $enunciado =$a->enunciado;
        $idTematica=$a->idTematica;
        $idRespuestaCorrecta=$a->idRespuestaCorrecta;
        $recurso=$a->recurso;

        $consulta = self::$conexion->prepare("Update pregunta set enunciado='$enunciado', idTematica='$idTematica', idRespuestaCorrecta='$idRespuestaCorrecta', recurso='$recurso' where idPregunta='$idPregunta'");
        
        $consulta->execute();
    }
    //Leemos todas las preguntas
    public static function leeListaPreguntas()
    {
        $consulta = self::$conexion->query("Select p.idPregunta, p.enunciado, p.idTematica,t.descripcion, p.idRespuestaCorrecta, p.recurso FROM pregunta as p, tematica as t where p.idTematica=t.idTematica");
        $preguntas=array();
        while ($registro = $consulta->fetch()) 
        {
            $pregunta=new Pregunta($registro['enunciado'], $registro['idTematica'], $registro['idRespuestaCorrecta'], $registro['recurso'], $registro['descripcion']);
            $pregunta->idPregunta=$registro['idPregunta'];
            $preguntas[]=$pregunta;
        }
        
        return $preguntas;
    }
    //Método que añade en la base de datos de una pregunta su respuesta correcta
    public static function anyadeRespuestaCorrecta($idPregunta, $idRespuestaCorrecta)
    {
        $consulta = self::$conexion->prepare("Update pregunta set idRespuestaCorrecta='$idRespuestaCorrecta' where idPregunta='$idPregunta'");
        
        $consulta->execute();
    }
    //Método que obtiene el id de la última pregunta añadida
    public static function obtieneUltimaIdPregunta()
    {
        $consulta = self::$conexion->query("Select idPregunta FROM pregunta order by idPregunta desc limit 1");
        while ($registro = $consulta->fetch()) 
        {
            $idPregunta=$registro['idPregunta'];
        }
        
        return $idPregunta;
    }

    //Respuestas
    //Lee una respuesta dado su id
    public static function leeRespuesta($idRespuesta)
    {
        $consulta = self::$conexion->query("Select idRespuesta, respuesta, idPregunta FROM respuesta where idRespuesta='$idRespuesta'");
        $respuesta=null;
        while ($registro = $consulta->fetch()) 
        {
            $respuesta=new Pregunta($registro['respuesta'], $registro['idPregunta']);
            $respuesta->idRespuesta=$registro['idRespuesta'];
        }
        
        return $respuesta;
    }
    //Insertamos una respuesta
    public static function grabaRespuesta(Respuesta $a)
    {
        $respuesta =$a->respuesta;
        $idPregunta =$a->idPregunta;

        $consulta = self::$conexion->prepare("Insert into respuesta (respuesta, idPregunta) VALUES (:respuesta, :idPregunta)");
        
        $consulta->bindParam(':respuesta',$respuesta);
        $consulta->bindParam(':idPregunta',$idPregunta);
        $consulta->execute();
    }
    //Modificamos una respuesta
    public static function modificaRespuesta(Respuesta $a)
    {
        $idRespuesta=$a->idRespuesta;
        $respuesta=$a->respuesta;
        $idPregunta=$a->idPregunta;

        $consulta = self::$conexion->prepare("Update respuesta set respuesta='$respuesta', idPregunta='$idPregunta' where idRespuesta='$idRespuesta'");
        
        $consulta->execute();
    }
    //Leemos todas las respuestas
    public static function leeListaRespuestas()
    {
        $consulta = self::$conexion->query("Select idRespuesta, respuesta, idPregunta FROM respuesta");
        $respuestas=array();
        while ($registro = $consulta->fetch()) 
        {
            $respuesta=new Respuesta($registro['respuesta'], $registro['idPregunta']);
            $respuesta->idPregunta=$registro['idRespuesta'];
            $respuestas[]=$respuesta;
        }
        
        return $respuestas;
    }
    //Método que obtiene el id de la última respuesta añadida
    public static function obtieneUltimaIdRespuesta()
    {
        $consulta = self::$conexion->query("Select idRespuesta FROM respuesta order by idRespuesta desc limit 1");
        while ($registro = $consulta->fetch()) 
        {
            $idRespuesta=$registro['idRespuesta'];
        }
        
        return $idRespuesta;
    }

    public static function altaPreguntaRespuestas($enunciado, $tematica, $imagen, $op, $correcta)
    {
        //Creamos la pregunta
        $pregunta=new Pregunta($enunciado,$tematica, null , $imagen, null);
        //Grabamos la pregunta
        GBD::grabaPregunta($pregunta);
        //Buscamos la ultima id añadida en preguntas
        $ultimaIdPregunta=GBD::obtieneUltimaIdPregunta();
        //Insertamos las 4 respuestas
        for($i=0;$i<4;$i++)
        {
            $respuesta=new Respuesta($op[$i], $ultimaIdPregunta);
            GBD::grabaRespuesta($respuesta);
            //Vemos si la respuesta[i] es la correcta
            if(($i+1)==$correcta)
            {
                //Si es la correcta sacamos la última id añadida en respuestas
                $respuestaCorrecta=GBD::obtieneUltimaIdRespuesta();
            }
        }
        //Añadimos la respuesta correcta a la pregunta insertada
        GBD::anyadeRespuestaCorrecta($ultimaIdPregunta, $respuestaCorrecta);
    }

    //Examenes
    //Lee un examen dado su id
    public static function leeExamen($idExamen)
    {
        $consulta = self::$conexion->query("Select descripcion, duracion, activo FROM examen where idExamen='$idExamen'");
        $examen=null;
        while ($registro = $consulta->fetch()) 
        {
            $examen=new Examen($registro['descripcion'], $registro['duracion'],$registro['activo']);
            $examen->idExamen=$idExamen;
        }
        
        return $examen;
    }
    //Insertamos un examen
    public static function grabaExamen(Examen $a)
    {
        $descripcion=$a->descripcion;
        $duracion=intval($a->duracion);
        $activo=$a->activo;

        $consulta = self::$conexion->prepare("Insert into examen (descripcion, duracion, activo) VALUES (:descripcion, $duracion, :activo)");
        
        $consulta->bindParam(':descripcion',$descripcion);
        $consulta->bindParam(':activo',$activo);
        
        $consulta->execute();
    }
    //Modificamos un examen
    public static function modificaExamen(Examen $a)
    {
        $idExamen=$a->idExamen;
        $descripcion=$a->descripcion;
        $duracion=$a->duracion;
        $activo=$a->activo;

        $consulta = self::$conexion->prepare("Update examen set descripcion='$descripcion', duracion='$duracion', activo='$activo' where idExamen='$idExamen'");
        
        $consulta->execute();
    }
    //Leemos todos los examenes
    public static function leeListaExamenes()
    {
        $consulta = self::$conexion->query("Select idExamen, descripcion, duracion,activo FROM examen");
        $examenes=array();
        while ($registro = $consulta->fetch()) 
        {
            $examen=new Examen($registro['enunciado'], $registro['descripcion'], $registro['duracion'], $registro['activo']);
            $examen->idExamen=$registro['idExamen'];
            $examenes[]=$pregunta;
        }
        
        return $examenes;
    }
    //Método que obtiene el id del último examen añadido
    public static function obtieneUltimoIdExamen()
    {
        $consulta = self::$conexion->query("Select idExamen FROM examen order by idExamen desc limit 1");
        while ($registro = $consulta->fetch()) 
        {
            $idExamen=$registro['idExamen'];
        }
        
        return $idExamen;
    }
    //Insertamos examen con sus preguntas
    public static function grabaPreguntasExamen($idExamen, $idPregunta)
    {
        $consulta = self::$conexion->prepare("Insert into preguntasexamen (idExamen, idPregunta) VALUES (:idExamen, :idPregunta)");
        
        $consulta->bindParam(':idExamen',$idExamen);
        $consulta->bindParam(':idPregunta',$idPregunta);
        
        $consulta->execute();
    }
    public static function altaPreguntasExamen($descripcion, $duracion, $preguntas)
    {
        //Creamos el examen
        $examen=new Examen($descripcion,$duracion, true);
        //Grabamos el examen
        GBD::grabaExamen($examen);
        //Buscamos la ultima id añadida en examen
        $ultimoIdExamen=GBD::obtieneUltimoIdExamen();
        //Insertamos las preguntas con la id del examen
        for($i=0;$i<count($preguntas);$i++)
        {
            GBD::grabaPreguntasExamen($ultimoIdExamen,$preguntas[$i]);
        }
    }
}
