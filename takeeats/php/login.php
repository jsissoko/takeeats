<?php
// Permet de démarrer la session sur ce fichier et donc d'utiliser la super globale $_SESSION
session_start();
require_once("utils/db_connect.php");
// Si je n'ai pas les paramètres "email" et "password" dans ma superglobale $_POST alors
if (!isset($_POST["email"], $_POST["password"])) {
    echo json_encode(["success" => false, "error" => "Des données sont manquantes"]);
    die; // J'arrête l'exécution du script
}
// Si les paramètres "email" et "password" dans ma superglobale $_POST sont vides alors
if (empty(trim($_POST["email"])) || empty(trim($_POST["password"]))) {
    echo json_encode(["success" => false, "error" => "Des données sont vides"]);
    die; // J'arrête l'exécution du script
}
// J'écris ma requête préparée pour séléctionner toutes les données de l'utilisateur par l'email
$req = $db->prepare("SELECT * FROM users WHERE email = ?");
$req->execute([$_POST["email"]]);
// J'affecte à ma variable $user le résultat de ma requete SQL
$user = $req->fetch(PDO::FETCH_ASSOC);
//fetch assoc poour un tableau associatif
// Si ma variable $user à une valeur ET que le mot de passe correspond au hash de celui de l'utilisateur alors
if ($user && password_verify($_POST["password"],
$user["pwd"])) {
     //La clé "connected" est définie à true, la clé "user_id" est définie avec l'ID de l'utilisateur, et la clé "admin" est définie en fonction de la valeur de la colonne admin dans la base de données. 
    $_SESSION["connected"] = true; 
    $_SESSION["user_id"] = $user["id_users"];
    $_SESSION["admin"] = $user["admin"];
// Le mot de passe hashé est retiré de la variable $user pour des raisons de sécurité.
    unset($user["password"]);

    // J'envoie une réponse avec un success true et les données de l'utilisateur
    echo json_encode(["success" => true, "user" => $user]);
} else {
    //  si l'authentification échoue, la session est vidée et détruite 
    $_SESSION = [];
    session_destroy();

    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Aucun utilisateur"]);
}
