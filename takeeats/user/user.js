$("form").submit(event => {
    event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page

    $.ajax({
        url: "../php/user.php",
        type: "POST",
        dataType: "json",
        data: {
            choice: "update",
            password: $("#password").val(),
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),



        },
        success: (res) => {
            if (res.success) window.location.replace("../accueil/accueil.html"); //? Si success alors je redirige vers la liste des utilisateurs
            else alert(res.error); // J'affiche une boite de dialogue avec l'erreur
        }
    });
});


$(document).ready(function() {
    // Récupérez l'objet utilisateur depuis le localStorage
    const user = JSON.parse(localStorage.getItem('user'));

    // Vérifiez si l'utilisateur n'est pas administrateur (admin === 0)
    if (user && user.admin === 0) {
        // Supprimez le bouton "Admin" en utilisant son texte ("Admin" dans ce cas)
        $('.admin').remove();
    }
});