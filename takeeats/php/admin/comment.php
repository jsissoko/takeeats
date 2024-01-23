<?php

require_once ('../utils/db_connect.php');
require('../utils/function.php');


isConnected();
isAdmin();



if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;


switch ($method['choice']) {
    case 'select':

        $req=$db->query('SELECT * FROM comment');
        $comments=$req->fetchALL(PDO::FETCH_ASSOC);
        echo json_encode (["success"=> true, "comments" => $comments] );
        break;

    case 'select_id':

        $req=$db->prepare('SELECT * FROM comment WHERE id_comment = ?');
        $req->execute([$method['id_comment']]);
        $comment=$req->fetchALL(PDO::FETCH_ASSOC);
        echo json_encode (["success"=> true, "comment" => $comment] );
        break;


    case 'delete':
    //Dans cette case je vais initialiser la possibilité de supprimer un restaurant 
    //j'ai à nouveau absolument besoin de la methode post

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
            die;
        }
        //?je vérifie si le paramètre "id" est présent et n'est pas vide dans $method. 
        //?Le paramètre "id_restaurant" représente l'identifiant du restaurant à supprimer. 
        //?Si l'id est manquant ou vide, j'envoie une réponse "erreur"
        if (!isset($method["id_comment"]) || empty(trim($method["id_comment"]))) {
            echo json_encode(["success" => false, "error" => "Id manquant"]);
            die; 
        }

            $req=$db->prepare('DELETE FROM comment WHERE id_comment =?');
            $req->execute([$method['id_comment']]);
            break;

    case 'insert': 

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
            die;
        }
        
        if (!isset($method['id_restaurant'],$method['content'])) 
        {// J'envoie une réponse avec un success false et un message d'erreur
            echo json_encode(["success" => false, "error" => "Données manquantes"]);
            die;
        }
        if
        (empty(trim($method['id_restaurant'])) ||
        empty(trim($method['content']))){

        echo json_encode(["success" => false, "error" => "Donnéees manquantes"]);
        die;
        }
        $req=$db->prepare("INSERT INTO comment (id_users,id_restaurant,content) VALUES (:id_users,:id_restaurant,:content)");
        $req->bindValue(':id_restaurant', $method['id_restaurant']);
        $req->bindValue(':content', $method['content']);
        $req->bindValue(':id_users', $_SESSION['user_id']);
        $req->execute();
        echo json_encode(["success" => true]);
        break;


        default:
        echo json_encode(["success" => false, "error" => "Méthode inconnue"]);
        break;
    
    }





?>