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
    //Leemos un usuario dado su correo
    public static function existeCorreo($correo)
    {
        $consulta = self::$conexion->query("Select idUSuario, nombre, apellidos,fechaNac, idRol, activo, correo FROM usuario where correo='$correo'");
        while ($registro = $consulta->fetch()) 
        {
            $usuario=new Usuario($registro['nombre'],$registro['apellidos'],null,$registro['fechaNac'],$registro['idRol'],$registro['activo'], $registro['correo']);
            $usuario->idUsuario=$registro['idUSuario'];
        }
        
        return $usuario;
    }
    //Insertamos un usuario
    public static function grabaUsuario(Usuario $a)
    {
        try {  
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
            self::$conexion->beginTransaction();

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
            $idAltaPorConfirmar=md5(libreria::generaContasenya());
            self::insertaAltaPorConfirmar($idAltaPorConfirmar,self::obtieneUltimoIdUsuario());
            $enlace="<a href='http://localhost/Proyecto_JoseAntonioCano/php/formularios/confimacionContrasenia.php?idAltaPorConfirmar=$idAltaPorConfirmar'>Restablecer Contraseña</a>";
            Libreria::enviaEmail('Escribe la contraseña',$correo,$nombre,"Porfavor cambie la contraseña en el siguiente enlace:<br>$enlace");
    
            self::$conexion->commit();
            
          } catch (Exception $e) {
            self::$conexion->rollBack();
        }
    }
    //Modificamos un usuario
    public static function modificaUsuario(Usuario $a)
    {
        $idUsuario=intval($a->idUsuario);
        $nombre =$a->nombre;
        $apellidos =$a->apellidos;
        $password =$a->password;
        $fechaNac =$a->fechaNac;
        $idRol =intval($a->idRol);
        $activo =intval($a->activo);
        $correo =$a->correo;

        $consulta = self::$conexion->prepare("Update usuario set nombre='$nombre', apellidos='$apellidos', password='$password', fechaNac='$fechaNac', idRol=$idRol , activo=$activo,correo='$correo' where idUsuario=$idUsuario");
        
        $consulta->execute();
    }
    //Eliminar un usuario
    public static function eliminaUsuario($idUsuario)
    {
        $idUsuario=intval($idUsuario);
        $consulta = self::$conexion->prepare("Delete from usuario where idUsuario='$idUsuario'");
        
        $consulta->execute();
    }
    //Modificamos la contraseña de un usuario
    public static function cambiaContrasenia($contrasena, $nombre, $idUsuario)
    {
        $idUsuario=intval($idUsuario);
        $contrasena=md5($contrasena);
        $consulta = self::$conexion->prepare("Update usuario set nombre='$nombre', password='$contrasena' where idUsuario=$idUsuario");
        
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
    //Eliminamos el alta por confirmar ya confirmado
    public static function eliminaAltaConfirmar($idAltaConfirmar)
    {
        $consulta = self::$conexion->prepare("Delete from altasconfirmar where idAltaConfirmar='$idAltaConfirmar'");
        
        $consulta->execute();
    }
    //Comprobamos si existe el usuario que nos pasa
    public static function insertaAltaPorConfirmar($idAltaPorConfirmar,$idUsuario)
    {
        $idUsuario=intval($idUsuario);
        $consulta = self::$conexion->prepare("Insert into altasconfirmar (idAltaConfirmar, idUsuario) VALUES ('$idAltaPorConfirmar', $idUsuario)");
        
        $consulta->execute();
    }
    //Leemos todos los usuarios con rol 2 (alumnos)
    public static function leeListaUsuarios($filas, $pagina)
    {
        $filas=intval($filas);
        $pagina=intval($pagina);
        $consulta = self::$conexion->query("Select idUSuario, nombre, apellidos, password,fechaNac, activo, correo FROM usuario where idRol=2");
        $usuarios=array();
        $usuarios =$consulta->fetchAll();
        $total = count($usuarios);
        $paginas = ceil($total /$filas);
        $usuarios = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $consulta= self::$conexion->query("Select idUSuario, nombre, apellidos, password,fechaNac, activo, correo FROM usuario where idRol=2 limit $inicio, $filas");
            $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        return $usuarios;
    }
    //Contamos el número de usuarios que hay
    public static function numeroUsuarios()
    {
        $consulta = self::$conexion->query("Select count(idUSuario) FROM usuario where idRol=2");
        while ($registro = $consulta->fetch()) 
        {
            $numUsuarios=$registro['count(idUsuario)'];
        }
        
        return $usuarios;
    }
    //Insertamos un usuario de forma masiva
    public static function grabaUsuarioMasiva($nombre,$correo)
    {
        $password=md5(libreria::generaContasenya());
        $rol=2;
        $activo=1;
        $consulta = self::$conexion->prepare("Insert into usuario (nombre, password, activo,idRol, correo) VALUES (:nombre, '$password', $activo,$rol, :correo)");
        
        $consulta->bindParam(':nombre',$nombre);
        $consulta->bindParam(':correo',$correo);
        
        $consulta->execute();
        $idAltaPorConfirmar=md5(libreria::generaContasenya());
        self::insertaAltaPorConfirmar($idAltaPorConfirmar,self::obtieneUltimoIdUsuario());
        $enlace="<a href='http://localhost/Proyecto_JoseAntonioCano/php/formularios/confimacionContrasenia.php?idAltaPorConfirmar=$idAltaPorConfirmar'>Restablecer Contraseña</a>";
        Libreria::enviaEmail('Escribe la contraseña',$correo,$nombre,"Porfavor cambie la contraseña en el siguiente enlace:<br>$enlace");
        
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
    //Leemos todos las tematicas
    public static function leeListaTematicasPaginator($filas, $pagina)
    {
        $filas=intval($filas);
        $pagina=intval($pagina);
        $consulta = self::$conexion->query("Select idTematica, descripcion FROM tematica");
        $tematicas=array();
        $tematicas =$consulta->fetchAll();
        $total = count($tematicas);
        $paginas = ceil($total /$filas);
        $tematicas = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $consulta= self::$conexion->query("Select idTematica, descripcion FROM tematica limit $inicio, $filas");
            $tematicas = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        return $tematicas;
    }
    //Eliminar una temática
    public static function eliminaTematica($id)
    {
        $id=intval($id);
        $consulta = self::$conexion->prepare("Delete from tematica where idTematica='$id'");
        
        $consulta->execute();
    }
    //Preguntas
    //Eliminar una pregunta
    public static function eliminaPregunta($id)
    {
        $id=intval($id);
        $consulta = self::$conexion->prepare("Delete from pregunta where idPregunta='$id'");
        
        $consulta->execute();
    }
    //Lee una pregunta dado su id
    public static function leePregunta($idPregunta)
    {
        $consulta = self::$conexion->query("Select enunciado, idTematica, idRespuestaCorrecta, recurso FROM pregunta where idPregunta='$idPregunta'");
        $pregunta=null;
        while ($registro = $consulta->fetch()) 
        {
            $pregunta=new Pregunta($registro['enunciado'], $registro['idTematica'],$registro['idRespuestaCorrecta'],$registro['recurso'], null);
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
    //Leemos todos las Preguntas
    public static function leeListaPreguntasPaginator($filas, $pagina)
    {
        $filas=intval($filas);
        $pagina=intval($pagina);
        $consulta = self::$conexion->query("Select p.idPregunta, p.enunciado, p.idTematica,t.descripcion, p.recurso FROM pregunta as p, tematica as t where p.idTematica=t.idTematica");
        $preguntas=array();
        $preguntas =$consulta->fetchAll();
        $total = count($preguntas);
        $paginas = ceil($total /$filas);
        $preguntas = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $consulta= self::$conexion->query("Select p.idPregunta, p.enunciado, p.idTematica,t.descripcion, p.recurso FROM pregunta as p, tematica as t where p.idTematica=t.idTematica limit $inicio, $filas");
            $preguntas = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        return $preguntas;
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
    //Leemos todas las respuestas de una pregunta
    public static function leeRespuestasPregunta($idPregunta)
    {
        $consulta = self::$conexion->query("Select idRespuesta, respuesta FROM respuesta where idPregunta=$idPregunta");
        $respuestas=array();
        while ($registro = $consulta->fetch()) 
        {
            $respuesta=new Respuesta($registro['respuesta'], $idPregunta);
            $respuesta->idRespuesta=$registro['idRespuesta'];
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
    //Función que da de alta a una pregunta junto a sus respuestas
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
    //Eliminar una examen
    public static function eliminaExamen($id)
    {
        $id=intval($id);
        $consulta = self::$conexion->prepare("Delete from examen where idExamen='$id'");
        
        $consulta->execute();
    }
    //Lee un examen dado su id
    public static function leeExamen($idExamen)
    {
        $consulta = self::$conexion->query("Select descripcion, duracion, activo, numPreguntas FROM examen where idExamen='$idExamen'");
        $examen=null;
        while ($registro = $consulta->fetch()) 
        {
            $examen=new Examen($registro['descripcion'], $registro['duracion'],$registro['activo'],$registro['numPreguntas']);
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
        $numPreguntas=intval($a->numPreguntas);

        $consulta = self::$conexion->prepare("Insert into examen (descripcion, duracion, activo, numPreguntas) VALUES (:descripcion, $duracion, :activo, $numPreguntas)");
        
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
    public static function leeListaExamenes($filas, $pagina)
    {
        $filas=intval($filas);
        $pagina=intval($pagina);
        $consulta = self::$conexion->query("Select idExamen, descripcion, duracion, activo, numPreguntas FROM examen");
        $examenes=array();
        $examenes =$consulta->fetchAll();
        $total = count($examenes);
        $paginas = ceil($total /$filas);
        $examenes = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $consulta= self::$conexion->query("Select idExamen, descripcion, duracion, activo, numPreguntas FROM examen limit $inicio, $filas");
            $examenes = $consulta->fetchAll(PDO::FETCH_ASSOC);
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
    //Función que da de alta las preguntas de un examen
    public static function altaPreguntasExamen($descripcion, $duracion, $preguntas, $numPreguntas)
    {
        //Creamos el examen
        $examen=new Examen($descripcion,$duracion, true, $numPreguntas);
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
    //Lee las preguntas de un examen dado su id
    public static function leePreguntasExamen($idExamen)
    {
        $consulta = self::$conexion->query("Select idPregunta FROM preguntasexamen where idExamen='$idExamen'");
        $preguntas=array();
        $respuestas=array();
        while ($registro = $consulta->fetch()) 
        {
            $preguntas[]=self::leePregunta($registro['idPregunta']);
        }
        for($i=0;$i<count($preguntas);$i++)
        {
            $respuestas[$i]=self::leeRespuestasPregunta($preguntas[$i]->idPregunta);
        }
        $preguntasyrespuestas[]=$preguntas;
        $preguntasyrespuestas[]=$respuestas;
        return $preguntasyrespuestas;
    }
}
