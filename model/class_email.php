<?php
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;
class Email{
  public function enviar_email($nueva_con_ne, $nom, $correo){

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

        $mail->Body     = utf8_decode("<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
        </head>
        <body>
                <div style='background: #267239; text-align: center;'>
                  <div>
                  <img src='https://www.oceanexpert.org/uploads/institutes/22186/instituteLogo.jpg' alt='Logo minec' width='200px' style='border-radius: 1rem;'>
                  </div>
                  <div width='200px' style='background: #fff; color: #000; border: 1px solid #000;'>
                    <h1><i>Archivos de Expediente</i></h1>
                    <h3>$nom tu usuario y contraseña es: $nueva_con_ne</h3>
                  </div>
                  <div></div>
                </div>
        </body>
        </html>");
        $mail->AltBody  = utf8_decode("body alternativo");
        $mail->AddAddress($correo);

        if (!$mail->send()){
          $res = 0;
        }else{
          $res = 1;
        }
        return $res;
  }
}
?>