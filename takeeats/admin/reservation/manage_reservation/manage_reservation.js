//? Si mon utilisateur n'est pas admin je redirige vers l'accueil
//if (user.admin == 0) window.location.replace("../../../reservation/reservation.html");

const urlParams = new URLSearchParams(window.location.search); // Je récupère les paramètres de mon url
const id_reservation = urlParams.get("id_reservation"); // Je récupère l'id de l'reservation à modifier dans l'url
console.log(urlParams)
console.log("ok")
console.log(id_reservation)
    /**
     * @desc Fait appel au php pour insérer un reservation
     * @param FormData fd - Contient les données du formulaire à envoyer
     * @return void - Ne retourne rien
     */

function insertReservation(fd) {
    fd.append("choice", "insert");

    $.ajax({
        url: "../../../php/admin/reservation.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue        
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: (res) => {
            if (res.success) window.location.replace("../reservation.html"); //? Si success alors je redirige vers la liste des reservations
            else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur
        }
    });
}

/**
 * @desc Fait appel au php pour mettre à jour un reservation
 * @param FormData fd - Contient les données du formulaire à envoyer
 * @return void - Ne retourne rien
 */ //
function updateReservation(fd) {

    fd.append("choice", "update");
    fd.append("id_reservation", id_reservation);

    console.log(fd);


    $.ajax({
        url: "../../../php/admin/reservation.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: (res) => {
            if (res.success) window.location.replace("../reservation.html"); //? Si success alors je redirige vers la liste des reservations
            else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur
        }
    });
}


$("form").submit(event => {
    event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page



    const fd = new FormData();
    // Je récupère les données du formulaire
    fd.append("name_reservation", $("#name_reservation").val());
    fd.append("date_reservation", $("#date_reservation").val());
    fd.append("id_restaurant", $("#id_restaurant").val());
    fd.append("number_of_People", $("#number_of_People").val());
    fd.append("id_users", $("#id_users").val());


    if (id_reservation) updateReservation(fd);
    else insertReservation(fd);
});