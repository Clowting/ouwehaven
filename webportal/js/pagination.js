$(document).ready(function ($) {

    var shipData;

    $('button').click(function(e) {
        e.preventDefault();
        loadShips();

    });

    function loadShips() {
        var $form = $('#searchShipForm'),
            url = $form.attr('action');

        var postData = {
            naam: $('#naam').val(),
            minLengte: $('#minLengte').val(),
            maxLengte: $('#maxLengte').val(),
            naamEigenaar: $('#naamEigenaar').val()

        };

        $.ajax({
            type: "post",
            url: url,
            data: postData,
            success: function(data) {
                shipData = $.parseJSON(data);
            }
        })
    }

    var pageCount = Math.ceil(shipData.length/50);

    $('#page-selection').bootpag({
        total: pageCount,
        page: 1,
        maxVisible: 5
    }).on('page', function(event, num) {

        $("#ship-content").html(
            "Page " + num
        );
    });

});