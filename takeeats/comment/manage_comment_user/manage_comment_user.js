//Dans cette page je vais initier l'insertion du commentaire pour l'utilisateur
$.ajax({
    url: "../../php/comment.php", //Page user/comment.php
    type: "GET",
    dataType: "json",
    data: {
        choice: "selector"
            //Dans ce choice je vais demander le nom et l'identifiant du restaurant de la table restaurant 
    },
    success: (res) => {
        //?Si l'operation est un succés je creer une variable "restaurants " dans laquelle je vais recuperer la response de ma requete 
        if (res.success) {
            const restaurants = res.comments;
            //?j'utilise la fonction sur la variable "restaurants"
            afficherOptions(restaurants);
        }
    }
});


//J'utilise un formData et je lui ajoute l'insertion 
function insertComment(fd) {
    fd.append("choice", "insert");
    $.ajax({
        url: "../../php/comment.php",
        type: "POST",
        dataType: "json",
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: (res) => {
            if (res.success) {
                window.location.replace("../comment.html");
            }
        }
    });
}
//Je créer une fonction afficherOptions qui va agir sur la variable restaurants 
function afficherOptions(restaurants) {
    //je creer un élément html 
    const select = $("<select></select>");
    //j'y ajoute par default le text tout les restaurants
    select.append("<option value=''>Tous les restaurants</option>");
    //Je parcours mes restaurants et j'initie restaurant qui va contenir une option 
    restaurants.forEach(restaurant => {
        const option = $("<option></option>")
            //j'ajoute a cette meme option l'id_restaurant ainsi que le name 
            .attr("value", restaurant.id_restaurant)
            .text(restaurant.name);

        select.append(option);
    });
    $("form").append(select);
    $("form").submit(event => {
        event.preventDefault();
        //J'initie le formData qui va me permettre de récuperer les données du formulaire et je le stock dans la variable fd  
        const fd = new FormData();
        //Je recupere la valeur de l'option 
        const selectedRestaurantId = $(select).val(); // Récupère l'ID du restaurant sélectionné
        fd.append("id_restaurant", selectedRestaurantId);
        fd.append("content", $("#content").val());
        insertComment(fd);
    });
}