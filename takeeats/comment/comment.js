$.ajax({
    url: "../php/comment.php",
    type: "GET",
    dataType: "json",
    data: {
        choice: "comment"
    },
    success: (res) => {
        if (res.success) {
            const productContainer = $(".product-container"); // Sélectionnez le conteneur une seule fois


            //Je parcours "comments" pour affecter les differentes de données que je veux exploiter 
            //comments contient le tableau des commentaires récupérés du serveur

            res.comments.forEach(comment => {
                //comment pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque commentaire individuellement à l'intérieur de la boucle
                const productBox = $("<div>").addClass("product-box");
                const content = $("<p></p>").text(comment.content);
                const date_comment = $("<p></p>").text(comment.date_comment)
                const restaurant_name = $("<p></p>").text(comment.restaurant_name)
                const firstname = $("<p></p>").text(comment.firstname)
                const lastname = $("<p></p>").text(comment.lastname)


                //J'ajoute les données a ma classe
                productBox.append(date_comment, content, lastname, firstname, restaurant_name);
                //J'ajoute la classe a mon contenaire
                productContainer.append(productBox);
            });
        }



    }
});



// Au clic de la div "Ajouter un comment"
$(".btn_com").click(() => {
    // Je redirige vers la page du formulaire
    window.location.replace("manage_comment_user/manage_comment_user.html");
});