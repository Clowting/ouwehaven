$(document).ready(function ($) {

    requestShips();

    $('button').click(function(e) {
        e.preventDefault();
        requestShips();
    });

    function requestShips() {
        var postData = {
            naam: $('#naam').val(),
            minLengte: $('#minLengte').val(),
            maxLengte: $('#maxLengte').val(),
            naamEigenaar: $('#naamEigenaar').val()

        };

        $.ajax({
            type: "post",
            url: "searchShip.php",
            data: postData,
            success: function(data) {
                data = $.parseJSON(data);
                console.log(data);
                var toAppend = "";

                for(var i = 0; i < 50 && i < data.length; i++) {
                    toAppend +=
                        '<tr>' +
                        '<td>' + data[i]['Naam'] + '</td>' +
                        '<td>' + data[i]['Lengte'] + '</td>' +
                        '<td>' + data[i]['Voornaam'] + '</td>' +
                        '<td><a href="ships-details.php?id=' + data[i]['ID'] + '"><i class="fa fa-arrow-right"></i></a></td>' +
                        '</tr>';
                }
                $("#ship-content").html(toAppend);

                $('#page-selection').bootpag({
                    total: Math.ceil(data.length/50),
                    page: 1,
                    maxVisible: 5
                }).on('page', function(event, num) {
                    toAppend = "";

                    for(var i = num*50-50; i < num*50 && i < data.length; i++) {
                        toAppend +=
                            '<tr>' +
                            '<td>' + data[i]['Naam'] + '</td>' +
                            '<td>' + data[i]['Lengte'] + '</td>' +
                            '<td>' + data[i]['Voornaam'] + '</td>' +
                            '<td><a href="ships-details.php?id=' + data[i]['ID'] + '"><i class="fa fa-arrow-right"></i></a></td>' +
                            '</tr>';
                    }

                    $("#ship-content").html(toAppend);

                });
            }
        });
    }



});