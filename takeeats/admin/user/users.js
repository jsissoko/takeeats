//? Si mon utilisateur n'est pas admin je redirige vers l'accueil
//if (user.admin == 0) window.location.replace("../../article/article.html");
function deleteUsers(id_users) {
    $.ajax({

        url: "../../php/admin/user.php",
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: { // Donnée(s) à envoyer s'il y en a
            choice: "delete",
            id_users
        },

        success: () => {
            $("#tr_" + id_users).remove(); // Je retire la ligne du tableau associé au restaurant
        }
    });
}



$.ajax({
    url: "../../php/admin/user.php",
    type: "GET",
    dataType: "json",
    data: {
        choice: "select"
    },
    success: (res) => {
        if (res.success) {
            res.users.forEach(users => {
                //Je parcours "users" pour affecter les differentes de données que je veux exploiter 
                //users contient le tableau des users récupérés du serveur
                //user pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque user individuellement à l'intérieur de la boucle
                const tr = $("<tr></tr>"); // Je crée une nouvelle ligne

                const lastname = $("<td></td>").text(users.lastname); // Je crée une case pour le nom
                const firstname = $("<td></td>").text(users.firstname); // Je crée une case pour le prénom
                const email = $("<td></td>").text(users.email); // Je crée une case pour l'email

                const updatectn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const updatebtn = $("<button></button>"); // Je crée le bouton pour la mise à jour
                updatebtn.addClass("btn ocean action_btn"); // J'ajoute des classes sur le bouton pour le style
                updatebtn.html("<i class='fa fa-pencil' aria-hidden='true'></i>"); // J'ajoute un texte au lien
                updatectn.append(updatebtn); // J'ajoute le boutton au td

                updatebtn.click(() => {
                    window.location.replace("manage_user/manage_user.html?id_users=" + users.id_users); // Je redirige vers la page du formulaire avec paramètre id de mon article sur lequel j'itère en paramètre
                });

                const delctn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const delbtn = $("<button></button>"); // Je crée le bouton pour la suppression
                delbtn.html("<i class='fa fa-trash' aria-hidden='true'></i>"); // J'ajoute le contenu du bouton, ici une icone de poubelle
                delbtn.addClass("btn salmon action_btn"); // J'ajoute des classes sur le bouton pour le style
                delctn.append(delbtn);

                delbtn.click(() => {

                    if (confirm("Etes vous sur de vouloir supprimer l'utilisateur ")) {

                        deleteUsers(users.id_users);
                        tr.remove();
                    }
                });
                tr.append(lastname, firstname, email, updatectn, delctn); // J'ajoute toutes mes cases dans ma ligne
                $("tbody").append(tr); // J'ajoute ma ligne à ma table
            });

            $("td").addClass("text-left"); // J'ajoute une classe à tous les td
        } else alert(res.error);
    }
});
console.log("ok")