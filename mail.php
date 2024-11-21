<?php


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2; 
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'goodnews.adewole9@gmail.com';
    $mail->Password = "dzcazwkjgccbnigo";
    $mail->SMTPSecure = 'tls'; // Use SSL instead of TLS
    $mail->Port = 587;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ),
    );

    $mail->setFrom('goodnews.adewole9@gmail.com', 'Goodnews');
    
    $mail->isHTML(true);

?>