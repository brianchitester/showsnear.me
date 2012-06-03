<?php

session_start();
 
include "config.inc.php";
try {
  $dbconn = new PDO('mysql:host=localhost;dbname='.$config['db'], $config['user'], $config['pass']);
}
catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>showsnear.me</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="find local events">
    <meta name="author" content="Brian Chitester, Dan Gilligan, Jeff Farrell, Jeongming Lee, Kurt Waltoc">
	
	<!-- check for mobile -->
	<script type="text/javascript">
	if (screen.width <= 767) {
		document.location = "mobile.html";
	}
	</script>
	
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>

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
	<script type="text/javascript" src="js/event.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>


  <body onload="main()">

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" >ShowsNear.me</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> Username
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#">Profile</a></li>
              <li class="divider"></li>
              <li><a href="#">Sign Out</a></li>
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="#about">Events</a></li>
              <li><a href="#about">Genre</a></li>
              <li><a href="#contact">Artists</a></li>              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Event Around You</li>
              <li class="active">
              <a href="#">Kottonmouth Kings</a></li>
              <li><a href="#">Event1</a></li>
              <li><a href="#">Event2 blah~~</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
<!--           <div class="hero-unit">
            <h1>Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div> -->          
          <div class="row-fluid">
            <div class="span9">
              <h1>Norah's Friday Evening</h1>
              <hr>
	          <p><img border="0" src="sample/concert.jpg"></p>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
              Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. 
              Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. 
              Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
	   	
              <p><a class="btn" href="#">Buy Ticket &raquo;</a></p>
		      <p>&nbsp;</p>

              <h2>Artist<i class='icon-user'></i></h2>
              <hr class="undertitle"r>
              <div class="row-fluid">
	              <span class="span3">
	              	<p><br><img src="sample/norajones.png" border="0"/></p>
	              </span>
	              <span class="span8">
	              	<p><h3>Norah Jones</h3></p>
			      	<p>She was born Geetali Norah Jones Shankar to legendary Indian musician, Ravi Shankar, and Sue Jones in New York City. Fittingly, her birth name, Geetali, carries the meaning of "song" or "melodious", and was bestowed on her by her father. No one could have possibly imagined how fully she would embody that name, even while circumstances removed her from the influences of her father's musical gifts.</p>              	
	              </span>
              </div>
		      <p>&nbsp;</p>

              
              <h2>Time<i class='icon-time'></i></h2>
              <hr class="undertitle"r>
		      <p>Tue, 24 Apr 2012<br>
		    	  <a><small>Add to calandar</small></a>
		      </p>
		      
		      <p>&nbsp;</p>
		      
		      <h2>Place<i class='icon-road'></i></h2>
		      <hr class="undertitle"r>
		                    <p><div id="mapcanvas">loading google map</div></p>              

			  <p><h4>Northern Lights in Clifton Park</h4><br>
				<address> 1208 Route 146<br>
				Clifton Park NY 12065<br>
				United States</address> 
			  </p>
		      <p>&nbsp;</p>
			  
			  <h2>Contacts<i class='icon-question-sign'></i></h2>
			  <hr class="undertitle">
			  <p>
				  Tel: 518-334-1385<br>
				  <a>http://www.krugsmith.com</a>
			  </p>
 		      <p>&nbsp;</p>
             
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->

    <!-- javascript - Placed at the end of the document so the pages load faster -->
    <!-- jQuery via Google + local fallback, see h5bp.com -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>

	<!-- Bootstrap jQuery Plugins, compiled and minified -->
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>



	<!-- PrettyPrint for debugging, should remove from official release -->
	<script src="js/prettyprint.js"></script>

  </body>
</html>