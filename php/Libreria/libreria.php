<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once "../../miAutoLoader.php";
class libreria
{
    public static function generaContasenya()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Genera la contraseña
        return substr(str_shuffle($permitted_chars), 0, 10);
        
    }
    public static function enviaEmail($asunto,$destinatario,$nombreCompleto,$texto, $adicional="",$rutaArchivoAdjunto="")
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 0;                          
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";                 
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;                 
        // introducir usuario de google
        $mail->Username   = "jc3550754@gmail.com"; 
        // introducir clave
        $mail->Password   = "PRUEBAPHP";       
        $mail->SetFrom("jc3550754@gmail.com", '');
        // asunto
        $mail->Subject    = utf8_decode($asunto);
        $mail->CharSet    = 'UTF-8';
        //Utilizamos una plantilla para enviar el correo
        $mensaje  = "<html><head><meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'></head><body>";
   
        $mensaje .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
        
        $mensaje .= "<tr><td>";
        
        $mensaje .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
            
        $mensaje .= "<thead>
        <tr height='80'>
        <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#333; font-size:34px;' >EMPRESA</th>
        </tr>
                    </thead>";
            
        $mensaje .= "<tbody>            
            <tr>
            <td colspan='4' style='padding:15px;'>
            <p style='font-size:20px;'>Estimado ".$nombreCompleto.",</p>
            <hr />
            <p style='font-size:25px;'>".$asunto."</p>
            <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'>".$texto.".</p>$adicional
            </td>
            </tr>
            
                    </tbody>";
            
        $mensaje .= "</table>";
        
        $mensaje .= "</td></tr>";
        $mensaje .= "</table>";
        
        $mensaje .= "</body></html>";
        // cuerpo
        $mail->MsgHTML($mensaje);
        // adjuntos
        $mail->addAttachment($rutaArchivoAdjunto);
        // destinatario
        $address = $destinatario;
        $mail->AddAddress($address, '');
        // enviar
        $resul = $mail->Send();
        if(!$resul) {
        echo "Error" . $mail->ErrorInfo;
        } else {
        echo "Enviado";
        }
    }
}
