<?php

require_once('utils/db_connect.php');
require('utils/function.php');


isConnected();



if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;


switch ($method['choice']) {
   /* case 'select':

        $req=$db->query('SELECT r.name,r.id_restaurant  AS restaurant_name, u.firstname, u.lastname, c.content, c.date_comment
        FROM comment c
        JOIN restaurant r ON c.id_restaurant = r.id_restaurant
        JOIN users u ON c.id_users = u.id_users;
        
        ');
        $comments=$req->fetchALL(PDO::FETCH_ASSOC);
        echo json_encode (["success"=> true, "comments" => $comments] );
        break;*/

    case 'select_id':

        $req=$db->prepare('SELECT * FROM comment WHERE id_comment = ?');
        $req->execute([$method['id_comment']]);
        $comment=$req->fetchALL(PDO::FETCH_ASSOC);
        echo json_encode (["success"=> true, "comment" => $comment] );
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
        
        
        echo json_encode(["success" => false, "error" => "Données manquantes"]);
        die;
        }
        $req=$db->prepare("INSERT INTO comment (id_users,id_restaurant,content) VALUES (:id_users,:id_restaurant,:content)");
        $req->bindValue(':id_users', $_SESSION['user_id']);
        $req->bindValue(':id_restaurant', $method['id_restaurant']);
        $req->bindValue(':content', $method['content']);
        $req->execute();
        echo json_encode(["success" => true]);
        break;
        
    default:
        echo json_encode(["success" => false, "error" => "Méthode inconnue"]);
        break;


        case "selector":
      
            $req = $db->query("SELECT DISTINCT restaurant.name,restaurant.id_restaurant 
            FROM restaurant
            
             ");
            
        
            $comments = $req->fetchAll(PDO::FETCH_ASSOC);
        
            echo json_encode(["success" => true, "comments" => $comments]);
            break;




        case "comment":
                // Exemple de comment.php (partie de récupération des commentaires avec noms de restaurants)
        
                //je selectione le nom du restaurant,l'identifiant du restaurant,le nom et prenom de l'utilisateur le contenu du commentaire et la du commentaire 

            // j'effectue une jointure entre la table "comment" (alias "c") et la table "restaurant" (alias "r") en utilisant les colonnes "id_restaurant" des deux tables comme clés de jointure. Cela permet de lier les commentaires aux restaurants correspondants en fonction de leur ID de restaurant.
                    $req = $db->query('SELECT r.name AS restaurant_name, r.id_restaurant, u.firstname, u.lastname, c.content, c.date_comment
                                    FROM comment c
                                    JOIN restaurant r ON c.id_restaurant = r.id_restaurant
                                    JOIN users u ON c.id_users = u.id_users');

            //j'effectue une autre jointure, cette fois entre la table "comment" (alias "c") et la table "users" (alias "u"). j' utilise les colonnes "id_users" des deux tables comme clés de jointure, permettant ainsi de lier les commentaires aux utilisateurs qui les ont créés en fonction de leur ID d'utilisateur
                    $comments = $req->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode(["success" => true, "comments" => $comments]);
                    break;
                
        
    
    }


?>