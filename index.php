<?php

	//change location
	if (isset($_GET['location'])){
		echo "<div id='locationChange' class='hidden'>";
		$location = str_replace(" ", "+", $_GET['location']);
		$jsonurl =  "http://maps.googleapis.com/maps/api/geocode/json?address=".$location."&sensor=false";
		$json = file_get_contents($jsonurl,0,null,null);
		$results = json_decode($json, true);
		echo "<div id='lat'>".$results['results'][0]['geometry']['location']['lat']."</div>";
		echo "<div id='lng'>".$results['results'][0]['geometry']['location']['lng']."</div>";
		echo "</div>";
	}
	

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>showsnear.me</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="find local events">
    <meta name="author" content="Brian Chitester, Dan Gilligan, Jeff Farrell, Jeongming Lee, Kurt Walton">
	
    <!-- styles -->
    <link href="css/bootstrap.css" rel="stylesheet">  <!-- twitter bootstrap - http://twitter.github.com/bootstrap/ -->
    <link href="css/style.css" rel="stylesheet">

	<!-- last.fm api -->
	<script type="text/javascript" src="js/last.fm-api/lastfm.api.md5.js"></script>
	<script type="text/javascript" src="js/last.fm-api/lastfm.api.js"></script>
	<script type="text/javascript" src="js/last.fm-api/lastfm.api.cache.js"></script>
    
    <!-- google maps api -->
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBbwfuP3d2nlHSMX0N3KtofN5MeHttWB4c&sensor=false"></script>
	

	<!-- Our script -->
	<script type="text/javascript"src="js/script.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body onload="main()">

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" >showsnear.me</a>
          <div id="tagline" class="brand">local shows and events</div>
          <div class="nav-collapse">
            <ul class="nav pull-right">
            	<li><a data-toggle="modal" href="#changeLoc">Change Location</a></li>
              <li class="active"><a href="index.php">Home</a></li>
            </ul>
							  
							<!-- only shown for admin --> 
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    	<div class="row">
    		<p id="status"> </p>
    	</div>
    	<div class="row">
    		<div class="span7">
    			<div id="mapcanvas">
    			</div>
    		</div>
    		<div class="span5">
    			<h1 id="near">Upcoming shows near...</h1> <!--must change-->
    			<p id="mainContent">Getting local shows and events...</p> <!--placeholder for event info -->
    		</div>
    	</div>
		<footer>
			<div class="row">
				<div class="span3">
					<h3>Powered By</h3>
					<a href="http://last.fm"><img id="last" src="img/lastfmlogo.png"></a>
				</div>
				<div class="span3">
					<h3>Contact</h3>
					<p>For help, info, or advertising opportunities please <a href="mailto:yagoogaly@gmail.com">contacts us</a> 
				</div>
				<div class="span3">
					<h3>About Us</h3>
					<p><a href="#">showsnear.me</a> is your source for upcoming events in your area.  Local events are pulled from all over the web and mapped out for your convenience.</p>
				</div>
				<div class="span3">
					<h3>Team</h3>
					<ul>
						<li><a href="http://brianchitester.com">Brian Chitester</a></li>
						<li>Dan Gilligan</li>
						<li>Jeff Farrell</li>
						<li>Jeongming Lee</li> 
						<li>Kurt Walton</li>
					</ul>
				</div>
			</div>
		</footer>

    </div> <!-- /container -->
	<!-- modal for location change -->
	<div class="modal" id="changeLoc">
		 <div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>Change Location</h3>
		  </div>
		  <div class="modal-body">
			<form name="locform" class="form-search" method="get">
			  <input name="location" id="location" type="text" class="input-medium search-query" placeholder="Where to?">
			  <button type="submit" class="btn">Search</button>
			</form>
		  </div>
	</div>
	
	<div class="modal" id="register">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>Register</h3>
		</div>
		<div class="modal-body">
			<form action='index.php' method='post' >
				<h2> Account Information: </h2>
				<input name= "username" type="text" placeholder="Username"> </input> <br>
				<input name= "password"  type="password" placeholder="Password"></input> <br>
				<input name= "passwordconf"  type="password" placeholder="Confirm Password"></input> <br>
				<h2> Contact Information: </h2>
				<input name= "firstname" type="text" placeholder="First Name"></input> <br>
				<input name="lastname" type="text" placeholder="Last Name"></input> <br>
				<input name="email" type="text" placeholder="Email Address"></input> <br>
				<button class="btn btn-success" type="submit">Register</button>
				<?php $_SESSION['registering']=True; ?>
			</form>
		</div>
	</div>

    <!-- javascript - Placed at the end of the document so the pages load faster -->
    <!-- jQuery via Google + local fallback, see h5bp.com -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>
	<script>
		$('#changeLoc').hide();
		$('#register').hide();
		//check for mobile http://stackoverflow.com/questions/4068559/removing-address-bar-from-browser-to-view-on-android
		$(document).ready(function() {
		  if (navigator.userAgent.match(/Mobile/i)) {
			window.scrollTo(0,0); // reset in case prev not scrolled  
			var nPageH = $(document).height();
			var nViewH = window.outerHeight;
			if (nViewH > nPageH) {
			  nViewH -= 250;
			  $('BODY').css('height',nViewH + 'px');
			}
			window.scrollTo(0,1);
		  }

		});
	</script>

	<!-- Bootstrap jQuery Plugins, compiled and minified -->
	<script src="js/bootstrap.min.js"></script>

	<!-- PrettyPrint for debugging, should remove from official release -->
	<script src="js/prettyprint.js"></script>

	
    
  </body>
</html>
