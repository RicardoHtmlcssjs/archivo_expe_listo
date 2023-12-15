<?php
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;
class Email{      
  public function enviar_email($nueva_con_ne, $usu, $correo){
      

      //Load Composer's autoloader
      // require 'vendor/autoload.php';

      // utilizando archivos estaticos
      require 'PHPMailer-master/src/Exception.php';
      require 'PHPMailer-master/src/PHPMailer.php';
      require 'PHPMailer-master/src/SMTP.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        setlocale(LC_ALL,'sp');

        $mail->CharSet = "ISO-8859-1";
        $mail->IsHTML(true);
        //$mail->Timeout   = 1000000;
        $mail->SMTPDebug = 0; // Visualizar Errores 2
        $mail->Username   = "soticminec@gmail.com";
        $mail->Password   = "ovdneqbisusrugat";
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';

        
          $mail->SMTPSecure = 'ssl';
          $mail->Host = 'ssl://smtp.gmail.com';
          $mail->Port = 465;

        $mail->From     = "soticminec@gmail.com";
        $mail->FromName = "Minec expedientes";
        $mail->Subject  = utf8_decode("Cambio de contraseña");

        $mail->Body     = utf8_decode($usu . " Tu nueva contraseña es: " . $nueva_con_ne);
        $mail->AltBody  = utf8_decode("body alternativo");
        $mail->AddAddress($correo);

        if (!$mail->send()){
          // $res = "Tratando de enviar el Mensaje al Correo.<br>".$mail->ErrorInfo;
          $res = 0;
        }else{
          // $res = "Cambio exitos";
          $res = 1;
        }  
        return $res;
        
  }
}  
  

?>