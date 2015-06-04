$(document).ready(function ($) {

    var pageCount;

    $('button').click(function(e) {
        e.preventDefault();
        $('#pagination').remove();
        $('#page-selection').html('<ul id="pagination"></ul>');
        searchShips();
    });

    function searchShips() {
        loadShips(1);
        $(document).ajaxStop(function() {
            $('#pagination').twbsPagination({
                totalPages: pageCount,
                visiblePages: 5,
                first: 'Begin',
                prev: '<',
                next: '>',
                last: 'Eind',
                onPageClick: function (event, page) {
                    loadShips(page);
                }
            });
        });
    }

    function loadShips(page) {
        $("#ship-content").html('<tr><td colspan="4">Schepen worden geladen...</td></tr>');
        var postData = {
            naam: $('#naam').val(),
            minLengte: $('#minLengte').val(),
            maxLengte: $('#maxLengte').val(),
            naamEigenaar: $('#naamEigenaar').val(),
            page: page
        };

        $.ajax({
            type: "post",
            url: "searchShip.php",
            data: postData,
            success: function (data) {
                data = $.parseJSON(data);
                var toAppend = "";
                pageCount = Math.ceil(data['totalCount']/50);

                $.each(data['items'], function (index, value) {
                    var eigenaar = generateName(value['Voornaam'], value['Tussenvoegsel'], value['Achternaam']);
                    toAppend +=
                        '<tr>' +
                        '<td>' + value['Naam'] + '</td>' +
                        '<td>' + value['Lengte'] + '</td>' +
                        '<td>' + eigenaar + '</td>' +
                        '<td><a href="ships-details.php?id=' + value['ID'] + '"><i class="fa fa-arrow-right"></i></a></td>' +
                        '</tr>';
                });

                $("#ship-content").html(toAppend);

            }
        });
    }

    function generateName(voornaam, tussenvoegel, achternaam) {
        if(tussenvoegel != "") {
            return voornaam + ' ' + tussenvoegel + ' ' + achternaam;
        } else {
            return voornaam + ' ' + achternaam;
        }
    }

});