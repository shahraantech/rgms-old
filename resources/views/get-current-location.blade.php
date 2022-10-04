
	<input type="text" name="latitude" id="latitude">
	<input type="text" name="longitude" id="longitude">
	<div id="x"></div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" ></script>

<script type="text/javascript" defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAB6y4kRx41p5krahkuc_dT2n5HJJwQP7w&amp"></script>



<script type="text/javascript">
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (p) {
            var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);

            document.getElementById('x').innerHTML = "Latitude: "+p.coords.latitude+"<br>Longitude: "+p.coords.longitude;
            document.getElementById('latitude').value = p.coords.latitude;
            document.getElementById('longitude').value = p.coords.longitude;

            var mapOptions = {
                center: LatLng,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
            var marker = new google.maps.Marker({
                position: LatLng,
                map: map,
                title: "<div style = 'height:60px;width:200px'><b>Your location:</b><br />Latitude: " + p.coords.latitude + "<br />Longitude: " + p.coords.longitude
            });
            google.maps.event.addListener(marker, "click", function (e) {
                var infoWindow = new google.maps.InfoWindow();
                infoWindow.setContent(marker.title);
                infoWindow.open(map, marker);
            });
        });
    } else {
        alert('Geo Location feature is not supported in this browser.');
    }
</script>
<div id="dvMap" style="width: 500px; height: 500px">





