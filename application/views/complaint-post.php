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
                <input type="hidden" name="latitude" value=""/>
                <input type="hidden" name="longitude" value=""/>
                <input type="hidden" name="location" value=""/>
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
        map.setOptions({draggableCursor: 'crosshair'});

        // add click listenser
        google.maps.event.addListener(map, 'click', function (event) {
            var latitude = event.latLng.lat();
            var longitude = event.latLng.lng();
            var point = new google.maps.LatLng(latitude, longitude);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'location': point}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var address = results[0].formatted_address;
                        if (isInMandaueCity(results)) {
                            $('input[name=latitude]').val(latitude);
                            $('input[name=longitude]').val(longitude);
                            $('input[name=location]').val(address);
                            placeMarker(event.latLng, address);
                        } else {
                            window.alert('Location not in Mandaue City');
                        }
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        });

        function placeMarker(location, address) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            clearOverlays();
            markersArray.push(marker);
            var infowindow = new google.maps.InfoWindow({
                content: address
            });
            infowindow.open(map, marker);
        }

        function clearOverlays() {
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
        }

        function isInMandaueCity(results) {
            for (i = 0; i < results.length; i++) {
                var result = results[i].formatted_address.split(",");
                for (j = 0; j < result.length; j++) {
                    if (result[j] == "Mandaue City") {
                        return true;
                    }
                }
            }
            return false;
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