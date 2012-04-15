/* Create a cache object */
var cache = new LastFMCache();

/* Create a LastFM object */
var lastfm = new LastFM({
	apiKey    : 'cd5262530fe8d0810408c648703e01a5',
	apiSecret : '8b7876fba38960fad13a22e04fc96a88',
	cache     : cache
});

function main(){

	/*Geolocation allowed*/
	function success(position) {

		/*get lat and lon*/
		var lat = position.coords.latitude;
		var lon = position.coords.longitude;
		
		/*map options*/
		var myOptions = {
		        center: new google.maps.LatLng(lat, lon),
		        zoom: 8,
		        mapTypeId: google.maps.MapTypeId.ROADMAP
		      };

		/*draw the map*/
		var map = new google.maps.Map(document.getElementById("mapcanvas"),myOptions);

		/*do last.fm stuff*/
		lastfm.geo.getEvents({lat: lat, long: lon}, {success: function(data){
			/*clear placeholder content*/
			$('#mainContent').html(" ");

			/* Use data. */
			// this for loop displays information for the first 10 events returned by lastfm.geo.getEvents
			// default listing is by date
			for (var i = 0; i < 10; i++){
				$('#mainContent').append( 
					"<h3>" + data.events.event[i].title + "</h3>" +
 					"<p>" + data.events.event[i].startDate + "</p>" +
					"<p>" + data.events.event[i].venue.name + "</p>" +
					"<p>" + data.events.event[i].venue.location.city + "</p>"
				);
			}

			/*printing some extra data can be helpful*/
			$('#dump').html(prettyPrint(data.events.event[0]));


		}, error: function(code, message){
			/* Show error message. */
			alert("ERROR: last.fm api failure");
		}});
		

	}
  /*Geolocation denied*/
	function error(msg) {
		var s = document.querySelector('#status');
		s.innerHTML = typeof msg == 'string' ? msg : "failed";
		s.className = 'fail';
	}

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(success, error);
	} else {
		error('not supported');
	}

}
