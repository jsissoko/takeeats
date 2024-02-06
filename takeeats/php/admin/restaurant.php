
<?php
//Je vais dans cette page php pour effectuer le crud de mon site c'est a dire donner la possibilité à l'administratur de  selectionner creer mofifier et supprimer pour la page restaurant .php 
//qui va contribuer au fait de selectionner d'inserer ,de mettre a jour et de supprimer des restauant de mon site web d'une part la partie admin et d'autre part la partie utilisateur
// Permet l'affichage des erreurs
error_reporting(-1);
// J'intègre obligatoirement (une fois) le contenu de mon fichier de connexion à ma bdd
require_once __DIR__ . '/../utils/db_connect.php';



//Dans ce fichier je vais devoir utiliser les fonction isAdmin et isConnceted definis dans le fichier function.php
// J'intègre donc ses 2 fonctions qui vont me permettre d'une part pour isAdmin de savoir si je suis admin et isConnected de savoir si je suis connecté
require_once __DIR__.'/../utils/function.php';
isConnected();
//upload($file);
isAdmin();

//je vais initialiser une variable qui va me permettre de stocker la methode nécessaire 
//Si ma méthode de requête est POST alors j'affecte à ma variable $method le contenu de la superglobale $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
// Sinon j'affecte à ma variable $method le contenu de la superglobale $_GET
else $method = $_GET;

// $method['choice'] = 'asilwemba';
switch ($method["choice"]  ?? null ) {
    case 'select':
        // Dans cette case je récupère tous les restaurants 
        $req = $db->query("SELECT * FROM restaurant ");
        // $req->execute([$method['id_restaurant']]);

        // J'affecte la totalité de mes résultats à la variable $restaurants
        $restaurants = $req->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "restaurants" => $restaurants]);
        break;

    case 'select_id':

        $req = $db->prepare("SELECT * FROM restaurant WHERE id_restaurant= ?");
        $req->execute([$method['id_restaurant']]);
        $restaurant = $req->fetch(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "restaurant" => $restaurant]);
        break;
       
        case 'insert':
            // Vérification de la méthode POST
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
                die;
            }        
                   
        if (!isset($_FILES['picture']) || $_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
            var_dump($_FILES['picture']);
            echo json_encode(["success" => false, "error" => "Une image doit être fournie"]);
            die;
        }

        $imgPath = upload($_FILES); // Tentative d'upload et récupération du chemin
        if (!$imgPath) {
            echo json_encode(["success" => false, "error" => "Échec de l'upload de l'image"]);
            die;
        }
        
            // Requête préparée d'insertion des données dans la table restaurant
            $req = $db->prepare("INSERT INTO restaurant (name, country, street_number, street_name, postal_code, description, phone, number_of_place, image)
                VALUES (:name, :country, :street_number, :street_name, :postal_code, :description, :phone, :number_of_place, :image)");
        
            // Liaison des valeurs
            $req->bindValue(":name", $method["name"]);
            $req->bindValue(":country", $method["country"]);
            $req->bindValue(":street_number", $method["street_number"]);
            $req->bindValue(":street_name", $method["street_name"]);
            $req->bindValue(":postal_code", $method["postal_code"]);
            $req->bindValue(":description", $method["description"]);
            $req->bindValue(":phone", $method["phone"]);
            $req->bindValue(":number_of_place", $method["number_of_place"]);
            $req->bindValue(":image", $imgPath); // Chemin de l'image téléchargée ou null
        
            // Exécution de la requête
            $req->execute();
        
            // Réponse JSON de succès
            echo json_encode(["success" => true]);
        
            break;
        

case'delete':
    
   //Dans cette case je vais initialiser la possibilité de supprimer un restaurant 
    //j'ai à nouveau absolument besoin de la methode post
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
            die;
        }
    //?je vérifie si le paramètre "id" est présent et n'est pas vide dans $method. 
    //?Le paramètre "id_restaurant" représente l'identifiant du restaurant à supprimer. 
    //?Si l'id est manquant ou vide, j'envoie une réponse "erreur"

    if (!isset($method["id_restaurant"]) || empty(trim($method["id_restaurant"]))) {
    
        echo json_encode(["success" => false, "error" => "Id manquant"]);
        die; 
    }
    // J'écris une requete préparée de suppression du restaurant en question
    $req = $db->prepare("DELETE FROM restaurant WHERE id_restaurant = ?"
    );
    $req->execute([$method["id_restaurant"],]);

    //? Si j'ai 1 résultat avec c'est un succès
    if ($req->rowCount()) echo json_encode(["success" => true]);
    //? Sinon
    else echo json_encode(["success" => false, "error" => "Une erreur est survenue lors de la suppression"]);
    break;



    case 'update':
        //Dans cette case je vais initialiser la possibilité de supprimer un restaurant 
       //j'ai à nouveau absolument besoin de la methode post
   
       if ($_SERVER["REQUEST_METHOD"] != "POST") {
           echo json_encode(["success" => false, "error" => "La méthode utilisée n'est pas la bonne"]);
           die;
       }
   
       if (
           !isset(
               $method["name"],
               $method["country"],
               $method["street_number"],
               $method["street_name"],
               $method["postal_code"],
               $method["number_of_place"],
               $method["description"],
               $method["phone"]
           )
   
   
           || empty(trim($method["name"]))
           || empty(trim($method["country"]))
           || empty(trim($method["street_number"]))
           || empty(trim($method["street_name"]))
           || empty(trim($method["postal_code"]))
           || empty(trim($method["number_of_place"]))
           || empty(trim($method["description"]))
           || empty(trim($method["phone"]))
       ) {
           //Un success false et message d'erreur
           echo json_encode(["success" => false, "error" => "Données manquanteeees"]);
           die;
       }
    
        // J'écris une requete préparée de modification de mes données dans la table restaurant
        $req = $db->prepare("UPDATE restaurant SET name = :name ,country = :country, street_number = :street_number, street_name = :street_name,
       postal_code = :postal_code, description = :description ,phone =:phone, number_of_place =:number_of_place  WHERE id_restaurant = :id_restaurant");
        // J'affecte à chaque clé les valeurs correspondantes grâce au bindValue
      
   
        $req->bindValue(":name", $method["name"]);
        $req->bindValue(":country", $method["country"]);
        $req->bindValue(":street_number", $method["street_number"]);
        $req->bindValue(":street_name", $method["street_name"]);
        $req->bindValue(":postal_code", $method["postal_code"]);
        $req->bindValue(":description", $method["description"]);
        $req->bindValue(":phone", $method["phone"]);
        $req->bindValue(":number_of_place",$method["number_of_place"]);
        $req->bindValue(":id_restaurant", $method["id_restaurant"]);
   
    
           $req->execute();
   
   
   
       // J'envoie une réponse avec success
       echo json_encode(["success" => true]);
   
       break;
   
}
