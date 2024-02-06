
<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Takeats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="accueil.css" />
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <ul class="menu-items">
         

                <li><a href="../restaurant/restaurant.html">Restaurants</a></li>
                <li><a href="../comment/comment.html">Commentaires</a></li>
                <li><a href="../contact/contact.html">Contact</a></li>
                <li><a href="../user/user.html">Mon Profil</a></li>
                <li><a href="../reservation/reservation.html">Ma réservation</a></li>


            </ul>
            <h1 class="logo">Takeeats</h1>
        </div>
    </nav>
    <center>
        <img src="../assets/takeeats.png" alt="">

    </center>
    <section id="about">
        <div class="about-wrapper container">
            <div class="about-text">
                <p class="small">A propos de nous </p>
                <h2>Bienvenue chez Takeeats</h2>

                <p>Bien plus qu'une simple plateforme de réservation : une invitation à un périple gustatif inédit.Notre passion pour la cuisine nous pousse à vous présenter les trésors cachés et les joyaux culinaires de chaque quartier. Avec GastronoVoyage,
                    vous pouvez non seulement réserver dans les restaurants les plus en vogue.
            </div>

            <div class="about-img">
                <img src="../assets/menu4.jpg" alt="food" />
            </div>
        </div>
    </section>
    <?php 
include '../php/utils/db_connect.php'; // Assurez-vous que ce chemin est correct
require_once __DIR__ . '/../php/utils/function.php';


// Récupération des restaurants
$restaurants = getRestaurants($db);

// Utilisation de $restaurants dans le carrousel
?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($restaurants as $index => $restaurant): ?>
            <div class="carousel-item <?= ($index === 0) ? 'active' : '' ?>">
            <img class="d-block w-100" src="../assets/<?= htmlspecialchars($restaurant['image']) ?>" alt="<?= htmlspecialchars($restaurant['description']) ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?= htmlspecialchars($restaurant['name']) ?></h5> <!-- Assurez-vous que 'name' est la clé correcte -->
                    <p><?= htmlspecialchars($restaurant['description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div  class="acces">
    <button> <a href="../restaurant/restaurant.html">Accèdez à nos restaurants </a></button>
</div>

<!-- Liste des services -->


<div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="../assets/pexels-andrea-piacquadio-3785419.jpg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <h5 class="card-title">Avis et évaluations</h5>
                        <p class="card-text">Les avis et évaluations jouent un rôle essentiel sur notre plateforme, offrant une transparence totale et des retours d'expérience authentiques. Après chaque repas, les clients sont encouragés à laisser un commentaire et à noter leur expérience, ce qui aide les futurs clients à faire des choix éclairés et les restaurants à améliorer continuellement leurs services.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="../assets/pexels-jep-gambardella-7689746.jpg" class="card-img-top" alt="Image 2">
                    <div class="card-body">
                        <h5 class="card-title">Services</h5>
                        <p class="card-text">Notre service d'assistance clientèle est le pilier de l'expérience utilisateur sur notre plateforme. Disponible 24/7, notre équipe dédiée est toujours prête à aider, que ce soit pour répondre à des questions, résoudre des problèmes ou simplement guider les utilisateurs à travers les fonctionnalités de la plateforme. </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="../assets/pexels-cottonbro-studio-4669113.jpg" class="card-img-top" alt="Image 3">
                    <div class="card-body">
                        <h5 class="card-title">Une Largesse de Choix</h5>
                        <p class="card-text">Ce qui distingue notre plateforme est la diversité et la richesse de l'offre que nous proposons. Des bistros locaux aux établissements étoilés, des cuisines de rue aux expériences gastronomiques de haut vol, nous avons quelque chose pour tous les goûts et tous les budgets.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="../assets/pexels-ryutaro-tsukata-5745034.jpg" class="card-img-top" alt="Image 4">
                    <div class="card-body">
                        <h5 class="card-title">Réservation en temps réel</h5>
                        <p class="card-text">Notre plateforme offre un service de réservation en temps réel qui garantit une expérience fluide et sans accrocs pour le client. Avec une interface intuitive, les utilisateurs peuvent consulter les disponibilités des tables en direct et réserver instantanément, sans avoir à attendre une confirmation du restaurant..</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer id="footer">
        <h2>Takeeats &copy; all rights reserved</h2>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
