<?php

require_once('../utils/db_connect.php');
require('../utils/function.php');


isConnected();
isAdmin();

if($_SERVER["REQUEST_METHOD"]=="POST") $method =$_POST ;
else $method = $_GET;

switch ($method['choice']) {


     case 'select':

        $req=$db->query("SELECT * FROM reservation");
        $reservations=$req->fetchALL(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "reservations" => $reservations]);
        break;


     case 'select_id':        
        $req=$db->prepare('SELECT * FROM reservation WHERE id_reservation=?');
        $req->execute([$method['id_reservation']]);
        $reservation=$req->fetch(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "reservation" => $reservation]);
        break;

     case 'delete':
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
            die;
        }
        //?je vérifie si le paramètre "id" est présent et n'est pas vide dans $method. 
        //?Le paramètre "id_restaurant" représente l'identifiant du restaurant à supprimer. 
        //?Si l'id est manquant ou vide, j'envoie une réponse "erreur"
        if (!isset($method["id_reservation"]) || empty(trim($method["id_reservation"]))) {
            echo json_encode(["success" => false, "error" => "Id manquant"]);
            die; 
        }
        $req=$db->prepare('DELETE FROM reservation WHERE id_reservation=?');
        $req->execute([$method['id_reservation']]);
        echo json_encode(["success" => true]);
        
              break;
     case 'insert':

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
                die;
            }
        
            if (!isset($method["id_restaurant"], $method["number_of_People"], $method["name_reservation"], $method["date_reservation"], $method["date_reservation"])) {
                echo json_encode(["success" => false, "error" => "Données manquantes"]);
                die;
            }
        
            if (
              empty(trim($method["id_restaurant"])) 
            ||empty(trim($method["number_of_People"])) 
            ||empty(trim($method["name_reservation"]))
            ||empty(trim($method["date_reservation"]))
            ) {
                echo json_encode(["success" => false, "error" => "Champs vides"]);
                die;
            }
            
            $req = $db->prepare("INSERT INTO reservation (id_users, id_restaurant,date_reservation,number_of_People, name_reservation) VALUES (:id_users, :id_restaurant,:date_reservation,:number_of_People, :name_reservation)");
            $req->bindValue(":id_users", $_SESSION['user_id']);
            $req->bindValue(":id_restaurant", $method['id_restaurant']);
            $req->bindValue(":date_reservation",$method ['date_reservation']);
            $req->bindValue(":number_of_People", $method['number_of_People']);
            $req->bindValue(":name_reservation", $method['name_reservation']);
            $req->execute();


            echo json_encode(["success"=> true]);
            break ;



      case 'update':

                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
                    die;
                }
                if (!isset($method["id_restaurant"], $method["number_of_People"], $method["name_reservation"], $method["date_reservation"], $method["date_reservation"])) {
                    echo json_encode(["success" => false, "error" => "Données manquantes"]);
                    die;
                }
                if (
                empty(trim($method["id_restaurant"])) 
                ||empty(trim($method["name_reservation"]))
                ||empty(trim($method["number_of_People"])) 
                ||empty(trim($method["date_reservation"]))
                ) {
                    echo json_encode(["success" => false, "error" => "Champs vides"]);
                    die;
                }
            $req=$db->prepare("UPDATE reservation SET id_restaurant =:id_restaurant, number_of_People=:number_of_People,name_reservation=:name_reservation,date_reservation=:date_reservation WHERE id_reservation =:id_reservation");
            $req->bindValue(":id_restaurant",$method["id_restaurant"]);
            $req->bindValue("name_reservation",$method["name_reservation"]);
            $req->bindValue(":number_of_People",$method["number_of_People"]);
            $req->bindValue("date_reservation",$method["date_reservation"]);
            $req->bindValue("id_reservation",$method["id_reservation"]);
            $req->execute();
            
            echo json_encode(["success" => true ]);
            break;

            default:
            echo json_encode(["success" => false, "error" => "Ce choix n'existe pas"]);
            break;

       
}


?>