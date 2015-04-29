$(document).ready(function ($) {
    var mapCanvas = $('#map-canvas');
    var trackingID = mapCanvas.attr('data-trackingid');

    if(trackingID != null) {
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

                generateMap(cleanCoords[0], cleanCoords[1], 13);
            }
        });
    }

});

function generateMap(x, y, zoom) {
    function initialize() {

        var myLatlng =  new google.maps.LatLng(x, y);

        var mapOptions = {
            zoom: zoom,
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