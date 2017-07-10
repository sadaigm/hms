<?php
if(!isset($_SESSION))
{
  session_start();
  if(!($_SESSION['email'] && $_SESSION['email_key'] &&$_SESSION['loginMode']) )
  {
    session_destroy();
      header("Location: login.php");//redirect to login page to secure the welcome page without login access.
  }
  
}
?><!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Add Location</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
   #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
      .address_header {
        padding:  1px 7px 10px 7px;
        font-weight: bold;
        color: #984304;
      }
      .marker_header{
        background-color: #dd4814;
        padding: 5px;
        color: #ffffff;

      }
      .address_content{
          word-wrap: break-word;
    display: block;
    width: 150px;  
      }
      .address_body td{
    
        padding: 2px;
      }
    </style>

    <link rel="stylesheet" href="assets/css/tooltip.css">
  </head>
  <?php include "pagelayout/footer.php" ?>
    <?php include "pagelayout/navbar.php" ?>
    <script src="assets/js/jquery.validate.min.js"></script>
  <body>
     
                
     
          <input id="pac-input" class="controls" type="text" placeholder="Search Box">
         
        
    <div class="map-responsive" style="max-width: 100%;max-height: 600px;" id="map" ></div>
    
    
    <div id="form"  class="col-sm-12" style="display: none; width: 500px;">
     
        <h4 class="marker_header" >Add Doctor & Hospital <span><?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?></span> </h4>
        <div class="address_header" class="col-sm-12">

  </div>
    <div id="address_body" class="address_body col-sm-6">
        <form class="form-validate" id="add_address_app" name="add_address_app">
      <table>
      <tr>  </tr>
      <tr><td>Doctor Name :</td> <td><input type='text' name='loc_name'  id='name' value="<?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?>" required/> </td> </tr>
      <tr><td>Hospital :</td> <td><input type='text' name='loc_name'  id='name'  required/> </td> </tr>
      <tr><td>Consulting Hrs :</td> <td>
<div data-tip="7am-8am & use comma for separate 2 sections"><input type='text' name='consulting_hrs' id='consulting_hrs' placeholder="7-8,13-14,19-21" required /> 
 </div>
      </td> </tr>
      <tr><td>Phone :</td> <td> <input type='text'  name='phone'  id='phone' required/> </td> </tr>
      <tr><td>Type :</td> <td><select id='type' required> +
                 <option value='Hospital' SELECTED>Hospital</option>
                 <option value='Clinic'>Clinic</option>
                 </select> </td></tr>
      <tr><td></td><td><input type='button'  class="btn-xs btn-primary" id="Save_doc" value='Save' /></td></tr>
      </table>
      </form>
        </div>

        <div id="address_content" class="col-md-6">
            <strong>Location Details :</strong><br>
               <span name='address' id='address'></span> <br>
                <span name='latitude' id='latitude'></span> <br>
                 <span name='longitude' id='longitude'></span><br>
                
          </div>
      <!--   <div class="col-sm-6">
      <table>
      <tr><td>Name:</td> <td><input type='text' id='name'/> </td> </tr>
      <tr><td>latitude:</td> <td><input type='text' id='latitude'/> </td> </tr>
      <tr><td>longitude:</td> <td><input type='text' id='longitude'/> </td> </tr>
      <tr><td>Type:</td> <td><select id='type'> +
                 <option value='Hospital' SELECTED>Hospital</option>
                 <option value='Clinic'>Clinic</option>
                 </select> </td></tr>
                 <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
      </table>
        </div> -->
    
    </div>
    <div id="message"  style="display: none">Location saved <a href="search_view_address.php">view address</a></div>
     


    <script>
      var map;
      var marker;
      var infowindow;
      var messagewindow;
       var geocoder;
    //var 

          function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      draggable: true ,
      map: map
    });
  }
  placeMarkerDetails(marker);
}
function placeMarkerDetails(marker)
{
  geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {

var span = document.getElementById('address');
if(span!=null)
{
 while( span.firstChild ) {
        span.removeChild( span.firstChild );
    }
    span.appendChild( document.createTextNode(results[0].formatted_address) );
}

var latitude = document.getElementById('latitude');
if(latitude!=null)
{
 while( latitude.firstChild ) {
        latitude.removeChild( latitude.firstChild );
    }
    latitude.appendChild( document.createTextNode("lat : "+marker.getPosition().lat()) );
}
var longitude = document.getElementById('longitude');
if(longitude!=null)
{
 while( longitude.firstChild ) {
        longitude.removeChild( longitude.firstChild );
    }
    longitude.appendChild( document.createTextNode("lng : "+marker.getPosition().lng()) );
}

/*$('#latitude').val(marker.getPosition().lat());*/
/*$('#longitude').val(marker.getPosition().lng());*/
infowindow.content.style.cssText="display:block";
infowindow.open(map, marker);
}
}
});
}

      function initMap() {
        geocoder = new google.maps.Geocoder();

        var chennai = {lat: 13.0826802, lng: 80.2707184};
        map = new google.maps.Map(document.getElementById('map'), {
          center: chennai,
          zoom: 13

        });
        // start autom complete
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

           /* // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));*/
             // Create a marker for each place.
            markers.push(
               placeMarker(place.geometry.location)

              );
          
           google.maps.event.addListener(marker, 'click', function() {
            /* infowindow.content.style.cssText="display:block";
            infowindow.open(map, marker);*/

            placeMarkerDetails(marker);
            console.log(event.latLng);
          });
               google.maps.event.addListener(marker, 'dragend', function() {
             placeMarkerDetails(marker);
});
 

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

















        // end of autom complete





        infowindow = new google.maps.InfoWindow({
          content: document.getElementById('form')
         });

        messagewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });

        google.maps.event.addListener(map, 'click', function(event) {
          /*marker = new google.maps.Marker({
            position: event.latLng,
            map: map
          });*/
           placeMarker(event.latLng);
            placeMarkerDetails(marker);
           console.log(event.latLng);
           google.maps.event.addListener(marker, 'click', function() {
            /* infowindow.content.style.cssText="display:block";
            infowindow.open(map, marker);*/

            placeMarkerDetails(marker);
            console.log(event.latLng);
          });


          

          google.maps.event.addListener(marker, 'dragend', function() {
 console.log(marker);
/*geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
$('#address').val(results[0].formatted_address);
$('#latitude').val(marker.getPosition().lat());
$('#longitude').val(marker.getPosition().lng());
infowindow.content.style.cssText="display:block";
infowindow.open(map, marker);
}
}
});*/

placeMarkerDetails(marker);
});
           });
       
      }
      $(document).ready(function() {
           $("#add_address_app").validate({
       rules: {   
         loc_name: {
            required: true,
           } 
        },
         messages: {
            loc_name: "Please specify location name"

        }
      
    });  
$('#Save_doc').click(function() {
        
         if ($("#add_address_app").valid()) {
             console.log("hello");
             saveData();
        }
       
    });
    });

      function saveData() {

        var name = escape(document.getElementById('name').value);
        var consulting_hrs =  escape(document.getElementById('consulting_hrs').value);
        var phone =  escape(document.getElementById('phone').value);
        var address = escape($('#address').text());
        var type = document.getElementById('type').value;
        var latlng = marker.getPosition();
        var url = 'location_addrow.php?name=' + name + '&address=' + address +
                  '&type=' + type + '&lat=' + latlng.lat() + '&lng=' + latlng.lng() +
                  '&consulting_hrs=' + consulting_hrs + '&phone=' + phone;

        downloadUrl(url, function(data, responseCode) {
            console.log(responseCode);
            console.log(data);
          if (responseCode == 200 && data.length <= 1) {
            infowindow.close();
            messagewindow.content.style.cssText="display:block";
            messagewindow.open(map, marker);
          }
        });
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
          }
        };

        request.open('GET', url , true);
        request.send(null);
        alert("saved");
      // window.location.href='view_address.php';
      }

      function doNothing () {
      }

    </script>
    <!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCphOSKQQie7vS98SET868Ljvx-lAJ-gTY&callback=initMap">
    </script> -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCphOSKQQie7vS98SET868Ljvx-lAJ-gTY&libraries=places&callback=initMap"
         async defer></script>
   
  </body>
</html>