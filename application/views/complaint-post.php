<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 ">
            <div id="map" style="height:500px"></div>
        </div>
        <div class="col-sm-6 form-container">
            <div class="page-header"><h1>Post Complaint</h1></div>
            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li> <?= implode($errors, '</li><li>') ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('complaint/post') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="latitude"/>
                <input type="hidden" name="longitude"/>
                <div class="form-group">
                    <label class="control-label col-sm-3">Category</label>
                    <div class="col-sm-7">
                        <?= form_dropdown('category', ['e' => 'Environmental', 't' => 'Traffic', 'p' => 'Public Disturbance'], set_value('category'), 'class="form-control"') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Title</label>
                    <div class="col-sm-7">
                        <input type="text" name="title" value="<?php echo set_value('title'); ?>"class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Description</label>
                    <div class="col-sm-7">
                        <textarea name="description" class="form-control" rows="4" style="resize: none"><?php echo set_value('description'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Latitude</label>
                    <div class="col-sm-7">
                        <input type="text" name="latitude" readonly="" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Longitude</label>
                    <div class="col-sm-7">
                        <input type="text" name="longitude" readonly="" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Location</label>
                    <div class="col-sm-7">
                        <input type="text" name="location" readonly="" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-7 col-sm-offset-3">
                        <div class="checkbox">
                            <label><input type="checkbox" name="is_anonymous"/> Post as anonymous</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Upload</label>
                    <div class="col-sm-7">
                        <input type="file" name="image" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-10 text-right">
                        <a class="btn btn-default">Go back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var initialLocation,
            browserSupportFlag = new Boolean(),
            mandaue,
            map;
    var markersArray = [];

    function initMap() {
        $('#map').css({height: function () {
                return $('.form-container').outerHeight(true);
            }})

        // set mandaue coordinate
        mandaue = new google.maps.LatLng(10.340082451588499, 123.94118785858154);

        // initialize google maps
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15
        });
        map.setMapTypeId(google.maps.MapTypeId.HYBRID);

        // add click listenser
        google.maps.event.addListener(map, 'click', function (event) {
            $('input[name=latitude]').val(event.latLng.lat());
            $('input[name=longitude]').val(event.latLng.lng());
            placeMarker(event.latLng);
            var point = new GlatLng(event.latLng.lat(), event.latLng.lng());
            var geocoder = new GClientGeocoder();
            geocoder.getLocations(point, function (result) {
                // access the address from the placemarks object
                //alert(result.address);
                alert (result.address);
            });
        });

        function placeMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            clearOverlays();
            markersArray.push(marker);
        }

        function clearOverlays() {
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
        }


        // Try W3C Geolocation (Preferred)
        if (navigator.geolocation) {
            browserSupportFlag = true;
            navigator.geolocation.getCurrentPosition(function (position) {
                map.setCenter(mandaue)
                // map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
            }, function () {
                handleNoGeolocation(browserSupportFlag);
            });
        }
        // Browser doesn't support Geolocation
        else {
            browserSupportFlag = false;
            handleNoGeolocation(browserSupportFlag);
        }
    }



    function handleNoGeolocation(errorFlag) {
        if (!errorFlag) {
            alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
        }
        initialLocation = mandaue;
        map.setCenter(initialLocation);
    }



</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBg2S57mj5G0l5y23rVpJsG9uMm_xjwZA&callback=initMap"></script>