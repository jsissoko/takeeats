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
            // const row = $("<div>").addClass("row"); // Créez une rangée pour les éléments // Sélectionnez le conteneur une seule fois
            //Je parcours "restaurants" pour affecter les differentes de données que je veux exploiter 
            //restaurants contient le tableau des restaurants récupérés du serveur

            res.restaurants.forEach(restaurant => {
                // Créez un conteneur pour les cartes avec les classes flexbox
                const cardContainer = $("<div>").addClass("d-flex flex-wrap");

                // Enveloppez chaque carte dans un élément div avec la classe d-inline-block
                const card = $("<div>").addClass("card d-inline-block mb-4");
                const imagectn = $("<img>").addClass("card-img-top").attr("src", "../assets/" + restaurant.image);
                const cardBody = $("<div>").addClass("card-body");
                const name = $("<h5>").addClass("card-title").text(restaurant.name);
                const postal_code = $("<p>").addClass("card-text").text(restaurant.postal_code);
                const street_name = $("<p>").addClass("card-text").text(restaurant.street_name);
                const street_number = $("<p>").addClass("card-text").text(restaurant.street_number);
                const description = $("<p>").addClass("card-text").text(restaurant.description);
                const reservationbtn = $("<button>").addClass("btn btn-primary").text("Réserver");
                // const voirplus = $("<button>").addClass("btn btn-primary").text("");


                // Ajoutez les éléments au cadre Bootstrap
                cardBody.append(name, postal_code, street_name, street_number, description, reservationbtn);
                card.append(imagectn, cardBody);

                // Ajoutez chaque carte au conteneur de cartes
                cardContainer.append(card);

                // Ajoutez le conteneur de cartes à votre conteneur principal
                productContainer.append(cardContainer);

                reservationbtn.click(() => {
                    // Je redirige vers la page du formulaire
                    window.location.replace("manage_resto_user/manage_resto_user.php?id_restaurant=" + restaurant.id_restaurant);
                });
            });
        }



    }
});





console.log("================================");