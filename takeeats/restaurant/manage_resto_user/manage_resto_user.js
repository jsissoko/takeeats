const urlParams = new URLSearchParams(window.location.search);
const id_restaurant = urlParams.get("id_restaurant");


$.ajax({
    url: "../../php/reservation.php",
    type: "POST",
    dataType: "json",
    data: {
        choice: "select_id"
    },
    contentType: false,
    processData: false,
    cache: false,

});




function insertReservation(fd) {
    fd.append("choice", "insert");

    $.ajax({
        url: "../../php/restaurant.php",
        type: "POST",
        dataType: "json",
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        // success: (res) => {
        //     if (res.success) window.location.replace("../../reservation/reservation.html");

        // }

    });
}

$('#submit').click(() => {
    const fd = new FormData();
    fd.append("name_reservation", $("#name_reservation").val());
    fd.append("date_reservation", $("#date_reservation").val());
    fd.append("number_of_People", $("#number_of_People").val());
    fd.append("id_restaurant", id_restaurant); // Ajoutez l'ID du restaurant au FormData

    insertReservation(fd);
});

console.log('================================')