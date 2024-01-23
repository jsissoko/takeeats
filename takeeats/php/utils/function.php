<?php
// Je démarre ma session
session_start();
//Dans cette page je vais écrire plusieurs fonctions qui vont me permettre de gagner du temps et d'avoir un code moins long et plus comprehensible 

/**
 * @desc Renvoie une erreur si l'utilisateur n'est pas connecté
 * @return void - Ne retourne rien
 */

 /*Je vais écrire une fonction qui se nomme isConnected qui va me permettre de determiner la connexion de l'utilisateur s'il est connecter ou non */ 
function isConnected()
{
    // Si la clé "connected" n'existe pas dans la superglobale SESSION OU que la valeur de "connected" dans la superglobale SESSION n'est pas vrai alors
    if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
        echo json_encode(["success" => false, "error" => "Vous n'êtes pas connecté"]);
        die;
    }
}

/**
 * @desc Renvoie une erreur si l'utilisateur n'est pas admin
 * @return void - Ne retourne rien
 */
function isAdmin()
{
    // Si la clé "admin" n'existe pas dans la superglobale SESSION OU que la valeur de "admin" dans la superglobale SESSION n'est pas vrai (!=1) alors
    if (!isset($_SESSION["admin"]) || !$_SESSION["admin"]) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Vous n'êtes pas autorisé"]);
        die; 
    }
}
/**
 * @desc Upload une image
 * @param array $file - Contient le fichier à upload
 * @return void - Retourne le nom du fichier upload sinon retourne false
 */
function upload($file)
{
    //? Si une image est transmise via le formulaire alors
    if (isset($file["picture"]["name"])) {
        //* Récupération du nom de fichier dans la superglobale FILES
        $filename = $file["picture"]["name"];

        //* Chemin du fichier
        $location = __DIR__ . "../../../assets/$filename";

        //* Récupération de l'extension du fichier
        $extension = pathinfo($location, PATHINFO_EXTENSION);
        //* Transformation de l'extension en minuscule
        $extension = strtolower($extension);

        if ($_FILES["picture"]["size"] > 500000) {
            echo "Fichier trop volumineux.";
            die;
          }

        //* Liste des extensions possibles
        $valid_extensions = ["jpg", "jpeg", "png"];

        //? Si l'extension du fichier appartient au tableau des extensions valides alors
        if (in_array($extension, $valid_extensions)) {
            //? Si le fichier est bien enregistré à l'endroit souhaité alors
      
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $location)) {
                return $filename; // ou le chemin complet selon vos besoins
            } else {
                return false;
            } 
       
    } else return false;
}

}


// J'initie une fonction php qui va me permettre de recuperer tous les restaurants 

function getRestaurants(PDO $db) {
    try {
        $req = $db->query("SELECT * FROM restaurant");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérer l'erreur ou la logger
        return []; // Retourner un tableau vide en cas d'erreur
    }
}
