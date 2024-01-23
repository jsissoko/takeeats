<?php
//Paramètres de connexion à la base de données
$host = "localhost"; // Contient le nom d'hôte ou l'adresse IP du serveur de base de données MySQL
$username = "root"; // Utilisateur root
$password = ""; // Vide si pas de mot de passe
$dbname= "takeeats"; // Nom de la base de données 


// Le try va me servir a éxecuter les instructions,
// le catch va stocker l'erreur si il y en a une qui sera potentiellement va l'afficher
try {
// j'utilise différents parametre qui vont me permettre d'etablir une connexion à ma base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (ErrorException $e) {
    echo $e;
}
