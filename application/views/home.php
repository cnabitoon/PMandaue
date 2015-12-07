<style type="text/css">
    body { height: 100%; margin: 0; padding: 0; }
</style>
<div id="map"></div>
<br/>
<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">Hotlines</div>
        <table class="table table-striped">
            <tbody>
                <?php foreach ($hotlines as $h): ?>
                    <tr>
                        <td><?= $h['title'] ?></td>
                        <td><?= $h['number'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">Announcements</div>
        <div class="list-group">
            <?php foreach ($announcements as $a): ?>
            <li class="list-group-item">
                <h4 class="list-group-item-heading"><?= $a['title']?></h4>
                <p class="list-group-item-text"><?= $a['description']?></p>
            </li>
            <?php endforeach; ?>
        </div>
    </div>
    <script type="text/javascript">
        var locations = <?php echo json_encode($placemarkers); ?>;
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 10.340082451588499, lng: 123.94118785858154},
                zoom: 15
            });

            map.setMapTypeId(google.maps.MapTypeId.HYBRID);

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            var image = {
                url: 'assets/image/ongoing.svg',
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']),
                    map: map,
                    //icon: image
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBg2S57mj5G0l5y23rVpJsG9uMm_xjwZA&callback=initMap"></script>