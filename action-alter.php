<?php
$con=mysqli_connect("localhost","root","","weathermamba");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

echo "hi" .$_POST['hazard'];
$hazard = $_POST["hazard"];
$sday = $_POST['sday'];
$smonth = $_POST['smonth'];
$syear = $_POST['syear'];
$eday = $_POST['eday'];
$emonth = $_POST['emonth'];
$eyear = $_POST['eyear'];
$sdate = ($syear*100+$smonth)*100+$sday;
$edate = ($eyear*100+$emonth)*100+$eday;
$sql = "SELECT * FROM mvs WHERE date>=$sdate && date <=$edate&& mvs.event = '$hazard'";
$result = mysqli_query($con,$sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
//echo "xyz".$row;
///echo "city/location \t hazard event \t dateymd\n";

?>

<html>
<head>
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" 
href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
<script type="text/javascript" 
src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" 
src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!--<script src="bootbox.js"></script>--->
</head>
<div class="table-responsive" style ="width: 73%;margin-left: 100px">
<table id="myTable" class="display table" >  
        <thead style= "background: #7B68EE	">  
          <tr>  
            <th>Event</th>  
            <th>Date</th>  
            <th>Location</th>  
            <th>State</th>  
          </tr>  
        </thead>  

    <tbody>
<?php
$a[]=0;
$i=0;
while($row1 = mysqli_fetch_array($result))
{
$a[$i]=$row1["city"];
$i=$i+1;
	echo "<tr>";
	echo "<td>".$row1["event"];
	echo"<td>".  $row1["date"];
	echo"<td>". $row1["city"];
	echo"<td>" .$row1["state"];
	echo"</tr>";
	
	//echo $row1['city']."\t" .$row1['event']. " \t".$row1['date']. "\n"  ; 
}
echo json_encode($a);?>
<html>
<!--/**
	 * ...
	 * @author katemamba
	 */-->
  <head>
    <style type="text/css">
      html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?address=<?php echo $a;?>&key=AIzaSyCCvqSh7C-MX47gYYUvDWApUhuSL1LfqgM&libraries=drawing">
    </script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
  <script>
  $(function() {
    $( "#slider" ).slider();
  });
  </script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script type="text/javascript">
      function initialize() {
        /*var mapOptions = {
          center: { lat: 40.7127, lng: -100.0059},
          zoom: 4
        };*/
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(40.727, -100.0059);
		var mapOptions = {
		  zoom: 4,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		}
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
		var locations = <?php echo json_encode($a); ?>;
		var i;
		///alert (locations);
		for(i=0;i<locations.length;i++){
			geocoder.geocode( { 'address': locations[i]}, function(results, status) {

			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat;
				var longitude = results[0].geometry.location.lng;
				var p = results[0].geometry.location;
				var latlng = new google.maps.LatLng(p.lat, p.lng);
				createMarker(locations[i],p.lat,p.lng);
				new google.maps.Marker({
					position: latlng,
					map: map
				});

			}
		});
		}
		
			/////alert(latitude);
		
				
		
		}
	  
	  
	  /*
	  for(i=0,location;location=locations[i];i++){
		var searchBox = new google.maps.places.SearchBox((location));
	  }
	  var markers = [];
	//  ######################################
   google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
});
*/
	  //######################################
	  
  google.maps.event.addDomListener(window, 'load', initialize);
	
    </script>
  </head>
  <body>
<div id="map-canvas"></div>
<div id ="slider"></div>
  </body>
</html>

<?php

mysqli_close($con);
?>