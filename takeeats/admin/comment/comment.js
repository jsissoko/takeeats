function deleteComment(id_comment) {
    $.ajax({
        url: "../../php/admin/comment.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: { // Donnée(s) à envoyer s'il y en a
            choice: "delete",
            id_comment
        },
        success: () => {
            $("#tr_" + id_comment).remove(); // Je retire la ligne du tableau associé à l'comment
        }
    });
}

$.ajax({
    url: "../../php/admin/comment.php", // URL cible
    type: "GET", // Type de méthode de requête HTTP
    dataType: "json", // Type de réponse attendue
    data: { // Donnée(s) à envoyer s'il y en a
        choice: "select"
    },
    success: (res) => {
        if (res.success) {
            //Je parcours "comments" pour affecter les differentes de données que je veux exploiter 
            //comments contient le tableau des commentaires récupérés du serveur
            res.comments.forEach(comment => {
                console.log(comment);
                //comment pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque commentaire individuellement à l'intérieur de la boucle
                const tr = $("<tr></tr>"); // Je crée une nouvelle ligne

                const date_comment = $("<td></td>").text(comment.date_comment); // Je crée une case pour la date
                const id_users = $("<td></td>").text(comment.id_users); //Je crée une case pour l'id_users
                const content = $("<td</td>").text(comment.content); // Je crée une case pour le contetnu
                const id_restaurant = $("<td></td>").text(comment.id_restaurant);


                const delctn = $("<td></td>"); // Je crée une case pour contenir mon bouton
                const delbtn = $("<button></button>"); // Je crée le bouton pour la suppression
                delbtn.html("<i class='fa fa-trash' aria-hidden='true'></i>"); // J'ajoute le contenu du bouton, ici une icone de poubelle
                delbtn.addClass("btn salmon action_btn"); // J'ajoute des classes sur le bouton pour le style
                delctn.append(delbtn);

                // J'ajoute un écouteur d'événement clic sur le bouton
                delbtn.click(() => {

                    if (confirm("Voulez-vous vraiment supprimer le commentaire ?")) {
                        // J'appelle la fonction deleteComment pour demander la suppression de l'comment
                        deleteComment(comment.id_comment);
                        tr.remove();
                    }
                });
                tr.addClass("comment")
                tr.append(content, date_comment, id_restaurant, id_users, delctn);
                $("tbody").append(tr); // J'ajoute ma ligne à ma table
            });

            $("td").addClass("text-left"); // J'ajoute une classe à tous les td
        } else alert(res.error);
    }
});

// Au clic de la div "Ajouter un comment"
$(".add_comment").click(() => {
    // Je redirige vers la page du formulaire
    window.location.replace("manage_comment/manage_comment.html");
});