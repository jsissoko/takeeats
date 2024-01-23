//? Si mon utilisateur n'est pas admin je redirige vers l'accueil
//if (user.admin == 0) window.location.replace("../../article/article.html");

const urlParams = new URLSearchParams(window.location.search); // Je récupère les paramètres de mon url
const id_users = urlParams.get("id_users"); // Je récupère l'id de l'utilisateur à modifier dans l'url
/*
$.ajax({
    url: "../../../php/admin/user.php", // URL cible
    type: "GET", // Type de méthode de requête HTTP
    dataType: "json", // Type de réponse attendue
    data: { // Donnée(s) à envoyer s'il y en a
        choice: "select_id",
        id_users
    },
    success: (res) => {
        if (res.success) {
            // Je modifie mon titre du header avec le nom de mon utilisateur
            $("header h1").text("Utilisateur " + res.users.firstname + " " + res.users.lastname);

            // J'affecte au champs de mon formulaire les valeurs de mon utilisateur
            $("#firstname").val(res.users.firstname);
            $("#lastname").val(res.users.lastname);
            $("#email").val(res.users.email);
        } else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur
    }
});*/

$("form").submit(event => {
    event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page

    $.ajax({
        url: "../../../php/admin/user.php",
        type: "POST",
        dataType: "json",
        data: {
            choice: "update",
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            email: $("#email").val(),
            id_users

        },
        success: (res) => {
            if (res.success) window.location.replace("../user.html"); //? Si success alors je redirige vers la liste des utilisateurs
            else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur
        }
    });
});