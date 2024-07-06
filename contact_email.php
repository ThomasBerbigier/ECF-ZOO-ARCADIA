<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['submitContact'])) {

        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $userEmail = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

        $mail = new PHPMailer(true);

        try {
            // Configurations SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jose555.arcadia@gmail.com'; 
            $mail->Password = 'qypa zmrk nbog ytzm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Paramètres du mail
            $mail->setFrom($userEmail, 'Contact Form');
            $mail->addAddress('jose555.arcadia@gmail.com', 'Jose Arcadia');

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body    = nl2br("Title: $title\n\nDescription:\n$description");

            $mail->send();
            $_SESSION['message'] = "Votre message a bien été envoyé.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la soumission du formulaire. Erreur : {$mail->ErrorInfo}";
        }
    }
}
?>
