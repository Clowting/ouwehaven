$(document).ready(function ($) {
    var mapCanvas = $('#map-canvas');
    var trackingID = mapCanvas.attr('data-trackingid');

    $.ajax({
        url: 'http://www.marinetraffic.com/en/ais/details/ships/shipid:' + trackingID,
        type: 'GET',
        success: function(res) {
            var location = $(res.responseText).find("span:contains('Latitude / Longitude:')").next().text();
            var coords =  location.split(' / ');
            var cleanCoords = [];

            $.each(coords, function(index, coord) {
                cleanCoords.push(coord.replace(/[^0-9\.]/g, ''));
            });

            console.log(cleanCoords);

            generateMap(cleanCoords[0], cleanCoords[1]);
        }
    });
});

function generateMap(x, y) {
    function initialize() {

        var myLatlng =  new google.maps.LatLng(x, y);

        var mapOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng
        });
;
        marker.setMap(map);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
}