$.ajax({
    url: "../php/reservation.php", // URL cible
    type: "GET", // Type de méthode de requête HTTP
    dataType: "json", // Type de réponse attendue
    data: { // Donnée(s) à envoyer s'il y en a
        choice: "select_id"
    },
    success: (res) => {
        if (res.success) {

            // Accédez aux propriétés de la réservation renvoyée par le serveur avec res.reservation
            const division_box = $(".division_box"); // Je crée une nouvelle ligne


            //Je parcours "reservations" pour affecter les differentes de données que je veux exploiter 
            //reservations contient le tableau des reservations récupérés du serveur

            res.reservation.forEach((reservation) => {
                //reservation pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque reservation individuellement à l'intérieur de la boucle
                const division = $("<div></div>").addClass("division")
                const name_reservation = $("<p></p>").text(reservation.name_reservation); // Je crée une case pour le nom
                const number_of_People = $("<p></p>").text(reservation.number_of_People); // Je crée une case pour le nombre de personnes
                const date_reservation = $("<p></p>").text(reservation.date_reservation); // Je crée une case pour la date de réservation
                const restaurant_name = $("<p></p>").text(reservation.restaurant_name); //
                const image = $("<p></p>").text(reservation.image)


                division.append(name_reservation, number_of_People, date_reservation, restaurant_name, image);
                division_box.append(division)
                    // J'ajoute toutes mes cases dans ma ligne

            });

            // Vous pouvez afficher les réservations dans la console si nécessaire
        }

    }
});