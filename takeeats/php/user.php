<?php

error_reporting(-1);
require_once("utils/db_connect.php");
require("utils/function.php");

isConnected();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
    die;
}

//? Si je n'ai les paramètres "firstname", "lastname" et "" OU qu'ils sont vides alors
if (!isset($_POST["firstname"], $_POST["lastname"],) || empty(trim($_POST["firstname"])) || empty(trim($_POST["lastname"]))) {
    echo json_encode(["success" => false, "error" => "Données manquantes ou vides"]);
    die; 
}

// Je déclare une variable $pwdchange afin de rajouter un bout de requête de mise à jour
$pwdchange = '';
//? Si j'ai le paramètre "password" et qu'il est non vide alors
if (isset($_POST["password"]) && !empty(trim($_POST["password"]))) {
    // J'affecte à ma variable $pwdchange le bout de requête de mise à jour pour le mot de passe
    $pwdchange = ", pwd = :pwd";

    //? Si le mot de passe ne correspond pas au format de l'ER alors
    $regex = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{10,14}$/";
    if (!preg_match($regex, $_POST["password"])) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Mot de passe au mauvais format"]);
        die; 
    }

    // Je hash le mot de passe avec la méthode par défaut
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
}

// J'écris une requete préparée de mise à jour de l'utilisateur
$req = $db->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname $pwdchange WHERE id_users = :id_users");
// J'affecte à chaque clé les valeurs correspondantes grâce au bindValue
$req->bindValue(":firstname", $_POST["firstname"]);
$req->bindValue(":lastname", $_POST["lastname"]);
$req->bindValue(":id_users", $_SESSION["user_id"]);
//? Si $pwdchange est non vide alors j'affecte à la clé du mot de passe le hash de celui passé en paramètre de la requête
if ($pwdchange != '') $req->bindValue(":pwd", $hash);
$req->execute(); // J'execute ma requete

// J'envoie une réponse avec un success true
echo json_encode(["success" => true]);
