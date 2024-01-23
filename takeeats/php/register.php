<?php

//J'ai besoin du fichier de connexion a la base de donnees
require_once("utils/db_connect.php");


// Je vais initialiser la methode de transmission du formulaire c'est a dire POST ou GET 
//J'ai absolument besoin de la methode POST car je vais transmettre des donnees sensibles qui ont besoin de securité
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
    die;
}


 
//je continue par la verification premierement par l'existence des parametres qui précede a un message d'erreur si n'existent pas 
if (isset($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"])) {
    echo json_encode(["success" => false, "error" => "Veuillez compléter votre saisie"]);

    die;
}


// Deuxièmement Supprimer les espaces en début et fin de chaîne et verifier que le champ ne soit pas vides
if (
    empty(trim($_POST["firstname"])) ||
    empty(trim($_POST["lastname"])) ||
    empty(trim($_POST["email"])) ||
    empty(trim($_POST["pwd"]))) 

    {echo json_encode(["success" => false, "error" => "Veuillez vérifier votre saisie"]);
   
    die;}

//Il est tant de determiner les caracteres possibles dans la saisie des informations 
//L'email
$er = "/^[a-zA-Z0-9-+._]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}$/";
if (!preg_match($er, $_POST["email"])) {
    echo json_encode(["success" => false, "error" => "Email au mauvais format"]);
    
    die;
}


//Il est tant de determiner les caracteres possibles dans la saisie des informations 
//Le mot de passe
// entre 10 et 14 caracteres contea
$er= "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{10,14}$/";
if (!preg_match($er, $_POST["pwd"])) {

    echo json_encode(["success" => false, "error" => "Mot de passe au mauvais format"]);
    die;
}

// Je hash le mot de passe avec la méthode par défaut ce qui va me permettre de respecter les normes de sécurite
$hashpwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
// à present je vais initier l'insertion d'un nouvel utilisateur dans la base de données 
// cette requete va me permettre d'inserer les donnes de l'utilisateur pour qu'il puisse etre reconnu
$asked = $db->prepare("INSERT INTO users(firstname,lastname,email,pwd) VALUES (:firstname, :lastname, :email, :pwd)");
// J'affecte à chaque clé les valeurs correspondantes grâce au bindValue
$asked->bindValue(":firstname", $_POST["firstname"]);
$asked->bindValue(":lastname", $_POST["lastname"]);
$asked->bindValue(":email", $_POST["email"]);
$asked->bindValue(":pwd", $hashpwd);
$asked->execute();
//e mail deja utilise
//if ($asked->rowcount(())) echo json_encode(["success"=> true])
// J'envoie une réponse avec un success true
echo json_encode(["success" => true]);




