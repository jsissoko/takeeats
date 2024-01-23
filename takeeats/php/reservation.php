<?php

require_once('utils/db_connect.php');
require('utils/function.php');


isConnected();


if($_SERVER["REQUEST_METHOD"]=="POST") $method =$_POST ;
else $method = $_GET;



switch ($method['choice']) {


     case 'select':

        $req=$db->query("SELECT * FROM reservation");
        $reservations=$req->fetchALL(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "reservations" => $reservations]);
        break;


     case 'select_id':        

        // ('SELECT FROM reservation WHERE id_users=?');
        $req=$db->prepare  ('SELECT * FROM reservation WHERE id_users= ?');
        $req->execute([$_SESSION['user_id']]);

        $reservation=$req->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "reservation" => $reservation]);
        break;

     case 'insert':
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
                die;
            }
        
            if (!isset($method["id_restaurant"],$method["number_of_People"], $method["name_reservation"],$method["date_reservation"])) {
                echo json_encode(["success" => false, "error" => "Données manquantes"]);
                die;
            }
            if (
        /*  empty(trim($method["id_restaurant"]))  ||*/
          empty(trim($method["number_of_People"])) 
            ||empty(trim($method["name_reservation"]))
            ||empty(trim($method["date_reservation"]))
            ) {
                echo json_encode(["success" => false, "error" => "Champs vides"]);
                die;
                
            }



            // Vérifier si l'utilisateur a déjà une réservation
            $existingReservation = $db->prepare("SELECT * FROM reservation WHERE id_users = :id_users AND id_restaurant = :id_restaurant");
            $existingReservation->bindValue(":id_users", $_SESSION['user_id']);
            $existingReservation->bindValue(":id_restaurant", $method['id_restaurant']);
            $existingReservation->execute();

            if ($existingReservation->rowCount() > 0) {
                echo json_encode(["success" => false, "error" => "Vous avez déjà une réservation en cours."]);
                die;
            }


                $reservationDate = $method['date_reservation'];
                $idRestaurant = $method['id_restaurant'];
                // Compter le nombre de réservations existantes pour la journée donnée
                $countReservations = $db->prepare("SELECT COUNT(*) AS total_reservations FROM reservation WHERE id_restaurant = :id_restaurant AND date_reservation = :reservation_date");
                $countReservations->bindValue(":id_restaurant", $idRestaurant);
                $countReservations->bindValue(":reservation_date", $reservationDate);
                $countReservations->execute();
                $totalReservations = $countReservations->fetch(PDO::FETCH_ASSOC)['total_reservations'];
        
                // récupére le nombre maximum de places depuis la table restaurant
                $maxPlaces = $db->prepare("SELECT number_of_place FROM restaurant WHERE id_restaurant = :id_restaurant");
                $maxPlaces->bindValue(":id_restaurant", $idRestaurant);
                $maxPlaces->execute();
                $maxPlaces = $maxPlaces->fetch(PDO::FETCH_ASSOC)['number_of_place'];
            
                if ($totalReservations >= $maxPlaces) {
                    echo json_encode(["success" => false, "error" => "Le nombre de places est déjà complet pour cette journée."]);
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

        }