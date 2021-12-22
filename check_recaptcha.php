<?php
    
    // require_once "send_mail.php";
    require_once "send_mail.php";
    
    function reCaptcha($recaptcha){
      $secret = "6LfjwBQdAAAAANu3lXkVbpsoCKNkULtkqpy938RF";
      $ip = $_SERVER['REMOTE_ADDR'];
    
      $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip);
      
      echo $response;
      
      return json_decode($response)->success;
    }
    
    if (isset($_POST)) {
        if(reCaptcha($_POST['g-recaptcha-response'])){
            if (SendEmail($_POST["from"], $_POST["name"], $_POST["to"], $_POST["subject"], $_POST["body"])) {
                echo "El mensaje se ha enviado correctamente.";
            } else {
                echo "Ha ocurrido un error enviando el mensaje.";
            }
        } else {
            echo "Ha ocurrido un error en la verificación de Google reCAPTCHA. Inténtalo de nuevo un poco más tarde.";   
        }
    } else {
        header("Location: /403");
        exit();
    }
?>