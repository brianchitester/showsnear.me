<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps AJAX + MySQL/PHP Example</title>
    <script src="https://maps.google.com/maps?file=api&v=2&key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxTPZYElJSBeBUeMSX5xXgq6lLjHthSAk20WnZ_iuuzhMt60X_ukms-AUg"
            type="text/javascript"></script>

    <script type="text/javascript">
    //<![CDATA[
    var map;
    var geocoder;

    function load() {
      if (GBrowserIsCompatible()) {
        geocoder = new GClientGeocoder();
        map = new GMap2(document.getElementById('map'));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(40, -100), 4);
      }
    }

   function searchLocations() {
     var address = document.getElementById('addressInput').value;
     geocoder.getLatLng(address, function(latlng) {
       if (!latlng) {
         alert(address + ' not found');
       } else {
         searchLocationsNear(latlng);
       }
     });
   }

   function searchLocationsNear(center) {
     var radius = document.getElementById('radiusSelect').value;
     var searchUrl = 'google_genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     GDownloadUrl(searchUrl, function(data) {
       var xml = GXml.parse(data);
       var markers = xml.documentElement.getElementsByTagName('marker');
       map.clearOverlays();

       var sidebar = document.getElementById('sidebar');
       sidebar.innerHTML = '';
       if (markers.length == 0) {
         sidebar.innerHTML = 'No results found.';
         map.setCenter(new GLatLng(40, -100), 4);
         return;
       }

       var bounds = new GLatLngBounds();
       for (var i = 0; i < markers.length; i++) {
         var name = markers[i].getAttribute('name');
         var venue = markers[i].getAttribute('venue');
         var address = markers[i].getAttribute('address');
         var distance = parseFloat(markers[i].getAttribute('distance'));
         var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
                                 parseFloat(markers[i].getAttribute('lng')));
         
         var marker = createMarker(point, name, venue, address);
         map.addOverlay(marker);
         var sidebarEntry = createSidebarEntry(marker, name, venue, address, distance);
         sidebar.appendChild(sidebarEntry);
         bounds.extend(point);
       }
       map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
     });
   }

    function createMarker(point, name, venue, address) {
      var marker = new GMarker(point);
      var html = '<b>' + name + '</b> <br/>' + venue + address;
      GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(html);
      });
      return marker;
    }

    function createSidebarEntry(marker, name, venue, address, distance) {
      var div = document.createElement('div');
      var html = '<b>' + name + '</b> (' + distance.toFixed(1) + ')<br/>' + venue + '<br/>'+ address;
      div.innerHTML = html;
      div.style.cursor = 'pointer';
      div.style.marginBottom = '5px'; 
      GEvent.addDomListener(div, 'click', function() {
        GEvent.trigger(marker, 'click');
      });
      GEvent.addDomListener(div, 'mouseover', function() {
        div.style.backgroundColor = '#eee';
      });
      GEvent.addDomListener(div, 'mouseout', function() {
        div.style.backgroundColor = '#fff';
      });
      return div;
    }
    //]]>

  </script>
  </head>

  <body onload="load()" onunload="GUnload()">
    Address: <input type="text" id="addressInput"/>
     

    Radius: <select id="radiusSelect">

      <option value="25" selected>25</option>
      <option value="100">100</option>

      <option value="200">200</option>

    </select>

    <input type="button" onclick="searchLocations()" value="Search Locations"/>
    <br/>    
    <br/>
<div style="width:800px; font-family:Arial, 
sans-serif; font-size:11px; border:1px solid black">
  <table> 
    <tbody> 
      <tr id="cm_mapTR">

        <td width="200" valign="top"> <div id="sidebar" style="overflow: auto; height: 500px; font-size: 11px; color: #000"></div>

        </td>
        <td> <div id="map" style="overflow: hidden; width:700px; height:500px"></div> </td>

      </tr> 
    </tbody>
  </table>
</div>    
  </body>
</html>
