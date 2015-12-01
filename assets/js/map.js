var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 10.340082451588499, lng: 123.94118785858154},
        zoom: 15
    });

    google.maps.event.addListener(map, 'click', function (event) {
        var lat = event.latLng.lat(),
                lng = event.latLng.lng();
        console.log(lat + ' ' + lng);
    });
}