<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($recipientEmail) {
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jose555.arcadia@gmail.com'; // Remplacez par votre email SMTP
        $mail->Password   = 'qypa zmrk nbog ytzm '; // Remplacez par votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinataire
        $mail->setFrom('jose555.arcadia@gmail.com', 'Zoo Arcadia');
        $mail->addAddress($recipientEmail);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Bienvenue chez Zoo Arcadia';
        $mail->Body    = '<h1>Bienvenue!</h1><p>Votre compte a été créé avec succès.</p><p>Votre nom d\'utilisateur pour vous connecter est votre mail. Pour le mot de passe, veuillez vous rapprocher de José afin qu\'il vous le communique.<br>Cordialement,<br> Zoo Arcadia.</p>';
        $mail->AltBody = 'Votre compte a été créé avec succès. ';

        $mail->send();
    } catch (Exception $e) {
        echo "L'email n'a pas pu être envoyé. Erreur de PHPMailer: {$mail->ErrorInfo}";
    }
}
?>
