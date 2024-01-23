//? Si mon utilisateur n'est pas admin je redirige vers l'accueil
// if (user.admin == 0) window.location.replace("../../../restaurant/restaurant.html");

const urlParams = new URLSearchParams(window.location.search); // Je récupère les paramètres de mon url
const id_restaurant = urlParams.get("id_restaurant"); // Je récupère l'id de l'restaurant à modifier dans l'url

/**
 * @desc Fait appel au php pour insérer un restaurant
 * @param FormData fd - Contient les données du formulaire à envoyer
 * @return void - Ne retourne rien
 */

function insertRestaurant(fd) {
    fd.append("choice", "insert");

    $.ajax({
        url: "../../../php/admin/restaurant.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue        
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: (res) => {
            if (res.success) window.location.replace("../restaurant.html");
            else alert(res.error);
        }
    });
}

/**
 * @desc Fait appel au php pour mettre à jour un restaurant
 * @param FormData fd - Contient les données du formulaire à envoyer
 * @return void - Ne retourne rien
 */ //
function updateRestaurant(fd) {

    fd.append("choice", "update");
    fd.append("id_restaurant", id_restaurant);

    console.log(fd);


    $.ajax({
        url: "../../../php/admin/restaurant.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: (res) => {
            if (res.success) window.location.replace("../restaurant.html");
        }
    });
}


$("form").submit(event => {
    event.preventDefault();

    const fd = new FormData();
    // Je récupère les données du formulaire
    fd.append("name", $("#name").val());
    fd.append("country", $("#country").val());
    fd.append("street_name", $("#street_name").val());
    fd.append("street_number", $("#street_number").val());
    fd.append("phone", $("#phone").val());
    fd.append("number_of_place", $("#number_of_place").val());
    fd.append("postal_code", $("#postal_code").val());
    fd.append("description", $("#description").val());
    // fd.append("picture", $("#picture")[0].files[0].val());
    fd.append("picture", $('#picture')[0].files[0]);



    console.log(fd);

    if (id_restaurant) updateRestaurant(fd);
    else insertRestaurant(fd);
});

console.log("image")