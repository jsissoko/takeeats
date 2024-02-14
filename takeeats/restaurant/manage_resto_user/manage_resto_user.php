<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../restaurant.css">
    <link rel="stylesheet" href="../../utils/style.css">
    <link rel="stylesheet" href="../../utils/stylo.css">
    <link rel="stylesheet" href="manage_resto_user.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../../utils/auth.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
 <!--    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <ul class="menu-items">
                <li><a href="../../restaurant/restaurant.html">Restaurants</a></li>
                <li><a href="../../comment/comment.html">Commentaires</a></li>
                <li><a href="../../contact/contact.html">Contact</a></li>
                <li><a href="../../user/user.html">Mon profil</a></li>
                <li><a href="../../reservation/reservation.html">Ma réservation</a></li>
                <li> <a href="../../login/login.html?logout=true"> Déconnexion</a></li>
            </ul>
            <h1 class="logo"><a href="../../accueil/accueil.html">Takeeats</a></h1>
        </div>
    </nav>


    <form>
        <div class="box">
            <div class="inputBox">
                <input type="text" id="name_reservation" required>
                <label for="name_reservation">Nom de réservation</label>
            </div>

            <div class="inputBox">
                <input type="number" id="number_of_People" required>
                <label for="number_of_People">Nombre de personnes</label>
            </div>

            <div class="inputBox">
                <input type="datetime-local" placeholder="Date and time" required name="date" id="date_reservation">
                <label for="date_reservation">Date et heure de la réservation</label>
                <div class="icon pop-up"></div>
            </div>

            <input id="submit" type="submit" value="Envoyer">
        </div>
    </form> -->



    <?php 
include '../../php/utils/db_connect.php'; // Assurez-vous que ce chemin est correct
include '../../php/utils/function.php';


// Récupération des restaurants
$restaurants = getRestaurants($db);

// Utilisation de $restaurants dans le carrousel
?>
<?php
// Vérifiez si l'ID du restaurant est présent dans l'URL
if (isset($_GET['id_restaurant'])) {
    // Récupérez l'ID du restaurant depuis l'URL
    $id_restaurant = $_GET['id_restaurant'];
    $req=$db->prepare("SELECT * FROM restaurant WHERE id_restaurant = :id_restaurant");
    $req->bindParam(':id_restaurant', $id_restaurant, PDO::PARAM_INT);
    $req->execute();
    $restaurant = $req->fetch(PDO::FETCH_ASSOC);
    // Vérifiez si des données ont été récupérées
    if ($restaurant) {
        // Affichez les informations du restaurant
        echo '<h2 class="restaurant-name">' . $restaurant['name'] . '</h2>';
        echo '<p class="restaurant-description">' . $restaurant['description'] . '</p>';
        echo '<img class="restaurant-image" src="../../assets/' . $restaurant['image'] . '" alt="Restaurant Image">';
        
        // Ajoutez d'autres informations que vous souhaitez afficher
    } else {
        // Le restaurant avec l'ID spécifié n'a pas été trouvé
        echo "Restaurant non trouvé.";
    }
} else {
    // L'ID du restaurant n'est pas présent dans l'URL
    echo "ID du restaurant non spécifié dans l'URL.";
}

?>

<?php
// Récupérer les commentaires associés à un restaurant
if (isset($_GET['id_restaurant'])) {
    $id_restaurant = $_GET['id_restaurant'];
    $query = $db->prepare("
        SELECT c.*, r.name as restaurant_name 
        FROM comment c
        INNER JOIN restaurant r ON c.id_restaurant = r.id_restaurant
        WHERE c.id_restaurant = :id_restaurant
    ");
    $query->bindParam(':id_restaurant', $id_restaurant, PDO::PARAM_INT);
    $query->execute();
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les commentaires
    if ($comments) {
        echo "<h2>Commentaires pour {$comments[0]['restaurant_name']}</h2>";
        echo "<ul>";
        foreach ($comments as $comment) {
            echo "<li>{$comment['content']} - {$comment['date_comment']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun commentaire pour ce restaurant.</p>";
    }
}
?>




    <script src="manage_resto_user.js"></script>

</body>

</html>