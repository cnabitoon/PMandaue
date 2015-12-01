<div id="map"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="page-header">
                <h1>Environmental Issues</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="page-header">
                <h1>Public Disturbance</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="page-header">
                <h1>Traffic Issues</h1>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 10.340082451588499, lng: 123.94118785858154},
            zoom: 15
        });
    }



</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBg2S57mj5G0l5y23rVpJsG9uMm_xjwZA&callback=initMap"></script>