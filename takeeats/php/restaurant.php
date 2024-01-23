<?php
//Je vais dans cette page php pour effectuer le crud de mon site c'est a dire donner la possibilité à l'administratur de  selectionner creer mofifier et supprimer pour la page restaurant .php 
//qui va contribuer au fait de selectionner d'inserer ,de mettre a jour et de supprimer des restauant de mon site web d'une part la partie admin et d'autre part la partie utilisateur
// Permet l'affichage des erreurs
error_reporting(-1);
// J'intègre obligatoirement (une fois) le contenu de mon fichier de connexion à ma bdd
require_once("utils/db_connect.php");
//Dans ce fichier je vais devoir utiliser les fonction isAdmin et isConnceted definis dans le fichier function.php
// J'intègre donc ses 2 fonctions qui vont me permettre d'une part pour isAdmin de savoir si je suis admin et isConnected de savoir si je suis connecté
require("utils/function.php");
isConnected();



//je vais initialiser une variable qui va me permettre de stocker la methode nécessaire 
//Si ma méthode de requête est POST alors j'affecte à ma variable $method le contenu de la superglobale $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
// Sinon j'affecte à ma variable $method le contenu de la superglobale $_GET
else $method = $_GET;

switch ($method["choice"]) {
    case 'select':
        // Dans cette case je récupère tous les restaurants 
        $req = $db->query("SELECT * FROM restaurant ");

        // J'affecte la totalité de mes résultats à la variable $restaurants
        $restaurants = $req->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "restaurants" => $restaurants]);
        break;

   case 'select_id':

            $req = $db->prepare("SELECT id_restaurant,name FROM restaurant WHERE id_restaurant= ?");
            $req->execute([$method['id_restaurant']]);
            $restaurant = $req->fetch(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "restaurant" => $restaurant]);
            break;

    };
    