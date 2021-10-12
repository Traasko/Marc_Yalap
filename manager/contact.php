<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/autoload.php';


class Manager{
    public function contact($donnee){
      $bdd = new PDO ('mysql:host=localhost;dbname=expertimmo; charset=utf8','remax', 'remax95');
      $req = $bdd->prepare('INSERT into contact (nom, email, sujet, message) VALUES(:nom, :email, :sujet, :message)');
      $req -> execute(array(
        'nom'=>$donnee->getnom(),
        'email'=>$donnee->getemail(),
        'sujet'=>$donnee->getsujet(),
        'message'=>$donnee->getmessage()));
        $a = $req->fetchall();

      if (isset($_POST['nom']) && isset($_POST['email'])) {
        $nom     = $_POST['nom'];
        $email   = $_POST['email'];
        $sujet   = $_POST['sujet'];
        $message = $_POST['message'];

      $mail = new PHPMailer();
      $mail->SMTPDebug  = 3;
      $mail->isSMTP();
      $mail->Host       ='smtp.gmail.com';  
      $mail->SMTPAuth   = true;
      $mail->Username   = 'traskoverif@gmail.com';
      $mail->Password   = 'Traasko95410';
      $mail->SMTPSecure = 'TLS';
      $mail->Port       = 587;

      $mail->CharSet = "utf-8";
      $mail->setFrom($email, $nom);
      $mail->addAddress('thomas.yalap.pro@gmail.com');
      $mail->addReplyTo($donnee->getemail());

      $mail->isHTML(true);
      $mail->Subject = $sujet;
      $mail->Body    = $message;

      if(!$mail->Send()) {
        echo "n";;
      } else {
      echo "y";;
      }
    }
  }
}
?>
