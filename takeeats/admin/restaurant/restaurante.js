//? Si mon utilisateur n'est pas admin je redirige vers l'accueil
//if (user.admin == 0) window.location.replace("../../restaurant/restaurant.html");

/**
 * @desc Fait appel au php pour supprimer un restaurant
 * @param string id - Contient l'id de l'restaurant
 * @return void - Ne retourne rien
 */
function deleteRestaurant(id_restaurant) {
    $.ajax({
        url: "../../php/admin/restaurant.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: { // Donnée(s) à envoyer s'il y en a
            choice: "delete",
            id_restaurant
        },

        success: () => {
            $("#tr_" + id_restaurant).remove(); // Je retire la ligne du tableau associé au restaurant
        }
    });
}



$.ajax({
    url: "../../php/admin/restaurant.php", // URL cible
    type: "GET", // Type de méthode de requête HTTP
    dataType: "json", // Type de réponse attendue
    data: { // Donnée(s) à envoyer s'il y en a
        choice: "select"
    },
    success: (res) => {
        if (res.success) {
            //Je parcours "restaurants" pour affecter les differentes de données que je veux exploiter 
            //restaurants contient le tableau des restaurants récupérés du serveur
            res.restaurants.forEach(restaurant => {
                //restaurant pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque restaurant individuellement à l'intérieur de la boucle
                const tr = $("<tr></tr>"); // Je crée une nouvelle ligne
                tr.attr("id", "tr_" + restaurant.id) // J'ajoute un id à mon tr
                    // Je crée plusieurs cases
                const name = $("<td></td>").text(restaurant.name);
                const phone = $("<td></td>").text(restaurant.phone)
                const country = $("<td></td>").text(restaurant.country)
                const postal_code = $("<td></td>").text(restaurant.postal_code)
                const street_number = $("<td></td>").text(restaurant.street_number)
                const street_name = $("<td></td>").text(restaurant.street_name)
                const description = $("<td></td>").text(restaurant.description); // 
                const number_of_place = $("<td></td>").text(restaurant.number_of_place); //
                // const image = $("<td></td>").text(restaurant.image); //

                const imagectn = $("<td></td>"); // Je crée une case pour l'image
                let img = "Aucune image"; // Par défaut il n'y a aucune image
                //? S'il y a une image alors je crée un élement img et je lui affecte la source
                if (restaurant.image) img = $("<img>").attr("src", "../../assets/" + restaurant.image);
                imagectn.append(img); // J'ajoute mon image à mon td




                const updatectn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const updatebtn = $("<button></button>"); // Je crée le bouton pour la mise à jour
                updatebtn.addClass("btn ocean action_btn"); // J'ajoute des classes sur le bouton pour le style
                updatebtn.html("<i class='fa fa-pencil' aria-hidden='true'></i>"); // J'ajoute un texte au lien
                updatectn.append(updatebtn); // J'ajoute le boutton au td
                updatebtn.click(() => {
                    window.location.replace("manage_restaurant/manage_restaurant.html?id_restaurant=" + restaurant.id_restaurant);
                });

                const delctn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const delbtn = $("<button></button>"); // Je crée le bouton pour la suppression
                delbtn.html("<i class='fa fa-trash' aria-hidden='true'></i>"); // J'ajoute le contenu du bouton, ici une icone de poubelle
                delbtn.addClass("btn salmon action_btn"); // J'ajoute des classes sur le bouton pour le style
                delctn.append(delbtn);

                // J'ajoute un écouteur d'événement clic sur le bouton
                delbtn.click(() => {
                    if (confirm("Voulez-vous vraiment supprimer le restaurant ?")) {
                        // J'appelle la fonction wantToDelete pour demander la suppression de l'restaurant
                        deleteRestaurant(restaurant.id_restaurant);
                        tr.remove();
                    }
                });


                tr.append(name, country, phone, street_name, street_number, postal_code, number_of_place, description, updatectn, delctn, imagectn); // J'ajoute toutes mes cases dans ma ligne
                $("tbody").append(tr); // J'ajoute ma ligne à ma table
            });

            $("td").addClass("text-left"); // J'ajoute une classe à tous les td
        } else alert(res.error);
    }
});

// Au clic de la div "Ajouter un restaurant"
$(".add_resto").click(() => {
    // Je redirige vers la page du formulaire
    window.location.replace("manage_restaurant/manage_restaurant.html");
});