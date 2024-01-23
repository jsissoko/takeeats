<?php
// J'utilise PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
// J'utilise les erreurs de PHPMailer
use PHPMailer\PHPMailer\Exception;

// J'intègre obligatoirement mon fichier autoload (du dossier vendor)
require("../../vendor/autoload.php");

/**
 * @desc Permet d'envoyer un mail
 * @param string $to - Destinataire du mail
 * @param string $subject - Sujet du mail
 * @param string $body - Corps du mail
 * @return void - Ne retourne rien
 */
function mailer($to, $subject, $body)
{
    // Je crée une nouvelle instance de PHPMailer
    $mail = new PHPMailer();

    //? J'exécute les instructions dans le try, si il y a une erreur elle est attrapée dans le catch qui va l'afficher
    try {
        $mail->IsSMTP(); // Simple Mail Transfer Protocol
        $mail->SMTPDebug = 0; // Débug
        $mail->SMTPAuth = true; // Authentification nécessaire
        $mail->SMTPSecure = "tls"; // Sécurité de la couche de transport 
        $mail->Host = "smtp-mail.outlook.com"; // Adresse du host
        $mail->Port = 587; // Port du host
        $mail->Username = "imiesissoko@gmail.com"; // Mail de connexion
        $mail->Password = "Imieparis.14092923"; // Mot de passe de connexion
        $mail->SetFrom("imiesissoko@gmail.com", "Sissoko Jeanke"); // Mail de l'expéditeur et Prénom Nom
        $mail->Subject = $subject; // Sujet du mail
        $mail->Body = $body; // Corps du mail
        $mail->AddAddress($to); // Ajout des destinataires

        // J'envoie le mail
        $mail->send();
    } catch (Exception $e) { //! Si erreur je la stocke dans la variable $e
        echo "error: $e"; // J'affiche l'erreur
    }
}