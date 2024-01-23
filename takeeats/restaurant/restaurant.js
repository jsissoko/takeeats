$.ajax({
    url: "../php/restaurant.php",
    type: "GET",
    dataType: "json",
    data: {
        choice: "select"
    },
    success: (res) => {
        if (res.success) {
            const productContainer = $(".product-container"); // Sélectionnez le conteneur une seule fois
            //Je parcours "restaurants" pour affecter les differentes de données que je veux exploiter 
            //restaurants contient le tableau des restaurants récupérés du serveur

            res.restaurants.forEach(restaurant => {
                //restaurant pour parcourir chaque élément du tableau ce qui permet de travailler avec les données de chaque restaurant individuellement à l'intérieur de la boucle
                const productBox = $("<div>").addClass("product-box");
                const name = $("<h2>").text(restaurant.name);

                const imagectn = $("<td></td>"); // Je crée une case pour l'image
                let img = "Aucune image"; // Par défaut il n'y a aucune image
                //? S'il y a une image alors je crée un élement img et je lui affecte la source
                if (restaurant.image) img = $("<img>").attr("src", "../assets/" + restaurant.image);

                imagectn.append(img); // J'ajoute mon image à mon td
                const postal_code = $("<p></p>").text(restaurant.postal_code)
                const street_number = $("<p></p>").text(restaurant.street_number)
                const street_name = $("<p></p>").text(restaurant.street_name)
                const description = $("<p></p>").text(restaurant.description)

                const reservationbtn = $("<button>").text("Réserver");

                reservationbtn.click(() => {
                    // Je redirige vers la page du formulaire
                    window.location.replace("manage_resto_user/manage_resto_user.html?id_restaurant=" + restaurant.id_restaurant);
                });

                productBox.append(imagectn, name, postal_code, street_name, street_number, description, reservationbtn);
                productContainer.append(productBox);
            });
        }



    }
});





console.log("================================");