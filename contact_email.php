<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST['submitContact'])) {
        
        $title = filter_input(INPUT_POST,'title', FILTER_VALIDATE_INT);
        $description = filter_input(INPUT_POST,'description', FILTER_VALIDATE_INT);
        $userEmail = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
        
        $mail = new PHPMailer(true);
        
        if ((!empty($title)) && (!empty($description)) && (!empty($userEmail))) {
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
}

