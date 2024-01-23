function insertComment(fd) {
    fd.append("choice", "insert");

    $.ajax({
        url: "../../../php/admin/comment.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue        
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: (res) => {
            if (res.success) window.location.replace("../comment.html"); //? Si success alors je redirige vers la liste des restaurants
            else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur
        }
    });
}

$("form").submit(event => {
    event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page



    const fd = new FormData();
    // Je récupère les données du formulaire
    fd.append("id_restaurant", $("#id_restaurant").val());
    fd.append("content", $("#content").val());
    console.log(fd);

    insertComment(fd);
});