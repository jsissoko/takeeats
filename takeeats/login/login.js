const urlParams = new URLSearchParams(window.location.search); // Je récupère les paramètres de mon url

//? Si j'ai le paramètre logout dans mon url alors
if (urlParams.get("logout")) {
    // Je fais un appel AJAX pour la déconnexion
    $.ajax({
        url: "../php/logout.php", // URL cible
        type: "GET", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        success: () => {
            //! Je supprime l'utilisateur de mon localStorage car il s'est déconnecté
            localStorage.removeItem("user");
        }
    });
}

$("form").submit((event) => { // A la soumission du formulaire
    event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page

    $.ajax({
        url: "../php/login.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: { // Donnée(s) à envoyer s'il y en a
            email: $("#email").val(),
            password: $("#password").val()
        },
        success: (res) => {
            if (res.success) { //? Si la réponse est un succès alors
                // J'ajoute mon utilisateur dans mon localStorage
                console.log(res);
                window.location.replace("../accueil/accueil.html");
                localStorage.setItem("user", JSON.stringify(res.user)); // Je redirige mon utilisateur vers ma page d'accueil
            } else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur //! J'affiche une boite de dialogue avec l'erreur
            console.log(res)
        }

    });
});