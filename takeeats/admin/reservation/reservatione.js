function deleteReservation(id_reservation) {
    $.ajax({

        url: "../../php/admin/reservation.php",
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: { // Donnée(s) à envoyer s'il y en a
            choice: "delete",
            id_reservation
        },

        success: () => {
            $("#tr_" + id_reservation).remove(); // Je retire la ligne du tableau associé au restaurant
        }
    });
}

$.ajax({
    url: "../../php/admin/reservation.php", // URL cible
    type: "GET", // Type de méthode de requête HTTP
    dataType: "json", // Type de réponse attendue
    data: { // Donnée(s) à envoyer s'il y en a
        choice: "select"
    },
    success: (res) => {
        if (res.success) {
            //Je parcours "reservations" pour affecter les differentes de données que je veux exploiter 
            //reservations contient le tableau des reservations récupérés du serveur
            res.reservations.forEach(reservation => {
                console.log(reservation);
                const tr = $("<tr></tr>"); // Je crée une nouvelle ligne
                //reservation pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque reservation individuellement à l'intérieur de la boucle

                const name_reservation = $("<td></td>").text(reservation.name_reservation); // Je crée une case pour le nom
                const number_of_People = $("<td></td>").text(reservation.number_of_People);
                const date_reservation = $("<td></td>").text(reservation.date_reservation); // Je crée une case pour la date
                const id_users = $("<td></td>").text(reservation.id_users);
                const id_restaurant = $("<td></td>").text(reservation.id_restaurant);

                const updatectn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const updatebtn = $("<button></button>"); // Je crée le bouton pour la mise à jour
                updatebtn.addClass("btn ocean action_btn"); // J'ajoute des classes sur le bouton pour le style
                updatebtn.html("<i class='fa fa-pencil' aria-hidden='true'></i>"); // J'ajoute un texte au lien
                updatectn.append(updatebtn); // J'ajoute le boutton au td
                updatebtn.click(() => {
                    window.location.replace("manage_reservation/manage_reservation.html?id_reservation=" + reservation.id_reservation); // Je redirige vers la page du formulaire avec paramètre id de mon reservation sur lequel j'itère en paramètre
                });

                const delctn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const delbtn = $("<button></button>"); // Je crée le bouton pour la suppression
                delbtn.html("<i class='fa fa-trash' aria-hidden='true'></i>"); // J'ajoute le contenu du bouton, ici une icone de poubelle
                delbtn.addClass("btn salmon action_btn"); // J'ajoute des classes sur le bouton pour le style
                delctn.append(delbtn);

                // J'ajoute un écouteur d'événement clic sur le bouton
                delbtn.click(() => {
                    if (confirm("Voulez-vous vraiment supprimer l'reservation ?")) {
                        // J'appelle la fonction wantToDelete pour demander la suppression de l'reservation
                        deleteReservation(reservation.id_reservation);
                        tr.remove();
                    }
                });



                tr.append(id_users, date_reservation, id_restaurant, name_reservation, number_of_People, updatectn, delctn);
                $("tbody").append(tr); // J'ajoute ma ligne à ma table
            });

            $("td").addClass("text-left"); // J'ajoute une classe à tous les td
        } else alert(res.error);
    }
});

// Au clic de la div "Ajouter un restaurant"
$(".add_reservation").click(() => {
    // Je redirige vers la page du formulaire
    window.location.replace("manage_reservation/manage_reservation.html");
});