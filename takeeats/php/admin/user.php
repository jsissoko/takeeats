<?php
//je vais initier la gestion des utilisateurs par l'administrateur
// C'est a dire la selection, la modification et la suppression de l'utilisateur
// integation du db_connect et du fichier function
require_once("../utils/db_connect.php");
require("../utils/function.php");


isConnected();
isAdmin();

//je vais initialiser une variable qui va me permettre de stocker la methode nécessaire 
//Si ma méthode de requête est POST alors j'affecte à ma variable $method le contenu de la superglobale $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
// Sinon j'affecte à ma variable $method le contenu de la superglobale $_GET
else $method = $_GET;


switch($method["choice"]) 
{
    case 'select':
        $req = $db->query("SELECT id_users, firstname, lastname, email FROM users");
        $users = $req->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "users" => $users]);
        break;



    case 'select_id':
        if (!isset($method["id_users"]) || empty(trim($method["id_users"]))) {
            echo json_encode(["success" => false, "error" => "Id manquant"]);
            die; 
        }

        // J'ai besoin de l'id
        $req = $db->prepare("SELECT id_users, firstname, lastname, email FROM users WHERE id_users = ?");
        $req->execute([$method["id_users"]]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        // J'envoie une réponse avec un success true ainsi que l'utilisateur
        echo json_encode(["success" => true, "user" => $user]);
        break;

    case 'update':
        //? Je fais la verification des parametres "firstname", "lastname", "email" et "id" OU qu'ils sont vides alors
        if (!isset($method["firstname"],
         $method["lastname"], $method["email"], $method["id_users"]) || empty(trim($method["firstname"])) || empty(trim($method["lastname"])) || empty(trim($method["email"])) || empty(trim($method["id_users"]))) {
            echo json_encode(["success" => false, "error" => "Données manquantes"]);
            die; 
        }

        $regex = "/^[a-zA-Z0-9-+._]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}$/";
        if (!preg_match($regex, $method["email"])) {
            // J'envoie une réponse avec un success false et un message d'erreur
            echo json_encode(["success" => false, "error" => "Email au mauvais format"]);
            die; 
        }

        // J'écris une requete préparée de mise à jour de l'utilisateur
        $req = $db->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id_users = :id_users");
        $req->bindValue(":firstname", $method["firstname"]);
        $req->bindValue(":lastname", $method["lastname"]);
        $req->bindValue(":email", $method["email"]);
        $req->bindValue(":id_users", $method["id_users"]);
        $req->execute();

        echo json_encode(["success" => true]);
        break;

        case 'delete':

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
                die;
            }
        //?je vérifie si le paramètre "id" est présent et n'est pas vide dans $method. 
        //?Le paramètre "id_restaurant" représente l'identifiant du restaurant à supprimer. 
        //?Si l'id est manquant ou vide, j'envoie une réponse "erreur"
    
        if (!isset($method["id_users"]) || empty(trim($method["id_users"]))) {
        
            echo json_encode(["success" => false, "error" => "Id manquant"]);
            die; 
        }
        // J'écris une requete préparée de suppression du restaurant en question
        $req = $db->prepare("DELETE FROM users WHERE id_users = ?"
        );
        $req->execute([$method["id_users"],]);
    
        //? Si j'ai 1 résultat avec c'est un succès
        if ($req->rowCount()) echo json_encode(["success" => true]);
        //? Sinon
        else echo json_encode(["success" => false, "error" => "Une erreur est survenue lors de la suppression"]);
        break;
    
}
