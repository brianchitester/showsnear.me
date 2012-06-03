<?php

	session_start();
	 
	include "config.inc.php";
	try {
	  $dbconn = new PDO('mysql:host=localhost;dbname='.$config['db'], $config['user'], $config['pass']);
	}
	catch (Exception $e) {
	  echo "Error: " . $e->getMessage();
	}

	//not admin, get outta here!
	if(!isset($_SESSION['type']) || $_SESSION['type'] != 'admin'){
		header( 'Location: index.php' ) ;
	}

/*
			var id = markers[i].getAttribute('eid');
        	var name = markers[i].getAttribute('name');
        	var date = markers[i].getAttribute('date');        	
        	var venue = markers[i].getAttribute('venue');
        	var address = markers[i].getAttribute('address');
        	var distance = parseFloat(markers[i].getAttribute('distance'));
        	var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
                                 parseFloat(markers[i].getAttribute('lng')));
*/

	//add event
	if(isset($_GET['addEvent']) && $_GET['addEvent'] == "add"){
		if (!empty($_GET['event_name']) && !empty($_GET['date']) && !empty($_GET['venue']) && !empty($_GET['address']) && !empty($_GET['description']) && !empty($_GET['lat']) && !empty($_GET['lon'])){
			if ($_SESSION['username'] != null && $_SESSION['type'] == "admin"){
				if ($sql = $dbconn->prepare("INSERT INTO `events` (`name`, `date`, `address`, `venue`, `description`, `lat`, `lon` ) VALUES ('{$_GET['event_name']}', '{$_GET['date']}', '{$_GET['address']}', '{$_GET['venue']}', '{$_GET['description']}', '{$_GET['lat']}', '{$_GET['lon']}')")){
					$sql->execute();
					header( 'Location: admin.php' ) ;
				}
			}
		}
		else {
			echo "please fill the whole thing out";
		}
	}

	//add artist
	if(isset($_GET['addArtist']) && $_GET['addArtist'] == "add"){
		if(!empty($_GET['artist_name']) && !empty($_GET['genre']) && !empty($_GET['link'])){
			if ($_SESSION['username'] != null && $_SESSION['type'] == "admin"){
				if ($sql = $dbconn->prepare("INSERT INTO `artists` (`name`, `genre_id`, `link` ) VALUES ('{$_GET['artist_name']}', '{$_GET['genre']}', '{$_GET['link']}')")){
					$sql->execute();
					header( 'Location: admin.php' ) ;
				}
				else{
					echo "ERROR: could not add to database";
					
				}
			}
			else{
				echo "ERROR: not admin";
			}
		}
		else{
			echo "ERROR: please fill the whole thing out";
		}
	}

	//add user
	if(isset($_GET['addUser']) && $_GET['addUser'] == "add"){
		if(!empty($_GET['name']) && !empty($_GET['username']) && !empty($_GET['password']) && !empty($_GET['accountType'])){
			if ($sql = $dbconn->prepare("INSERT INTO `users` (`name`, `username`, `password`, `type`  ) VALUES ('{$_GET['name']}', '{$_GET['username']}', '{$_GET['password']}', '{$_GET['accountType']}')")){
				$sql->execute();
				header( 'Location: admin.php' ) ;
			}
			else{
				echo "ERROR: could not add to database";
			}
		}
		else{
			echo "ERROR: please fill out the whole thing";
		}
	}

	//delete user
	if(isset($_GET['deleteUser']) && $_GET['deleteUser'] == "delete"){
		if(!empty($_GET['username'])){
			if ($sql = $dbconn->prepare("DELETE FROM users WHERE username=?")){
				$sql->execute(array($_GET['username']));
				header( 'Location: admin.php' ) ;
			}
			else{
				echo "ERROR: could not remove from database";
			}
		}
		else{
			echo "ERROR: please fill out the whole thing";
		}
	}
	
	//delete event
	if(isset($_GET['deleteEvent']) && $_GET['deleteEvent'] == "delete"){
		if(!empty($_GET['event'])){
			if ($sql = $dbconn->prepare("DELETE FROM events WHERE name=?")){
				$sql->execute(array($_GET['event']));
				header( 'Location: admin.php' ) ;
			}
			else{
				echo "ERROR: could not remove from database";
			}
		}
		else{
			echo "ERROR: please fill out the whole thing";
		}
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
              <li><a href="index.php">Home</a></li>
			  <li class="active"><a href="admin.php">Admin</a></li>
			  <li><a href='index.php?logout=1'>Logout</a></li></ul>      
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    	<div class="row">
    		<p id="status"> </p>
    	</div>
    	<div class="row">
			<div class="span12">
    			<h1>Admin<h1>
			</div>
    	</div>
		<div class="row">
			<div class="span4">
				<form method="get" class="form-horizontal">
				  <fieldset>
					<legend>Add Event</legend>

					<div class="control-group">
					  <label class="control-label" for="event_name">Name</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="event_name">
					  </div>
					</div>
				
					<div class="control-group">
					  <label class="control-label" for="date">Date</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="date">
					  </div>
					</div>
	
					<div class="control-group">
					  <label class="control-label" for="venue">Venue</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="venue">
					  </div>
					</div>

					<div class="control-group">
					  <label class="control-label" for="address">Address</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="address">
					  </div>
					</div>

					<div class="control-group">
					  <label class="control-label" for="description">Description</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="description">
					  </div>
					</div>
			
					<div class="control-group">
					  <label class="control-label" for="lat">Latitude</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="lat">
					  </div>
					</div>
	
					<div class="control-group">
					  <label class="control-label" for="lon">Longitude</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="lon">
					  </div>
					</div>

					<button type="submit" name="addEvent" class="btn pull-right" value="add">Add Event</button>
				  </fieldset>
				</form>
			</div>
			<div class="span3">
				<form method="get" class="form-horizontal">
				  <fieldset>
					<legend>Delete Event</legend>
					<div class="control-group">
					  <label class="control-label" for="event">Event Name</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="event">
					  </div>
					</div>
					<button class="btn pull-right" name="deleteEvent" type="submit" value="delete">Delete</button>
				</form>
			</div>
			
			<div class="span8">
				<legend>Event List</legend>
				<ul id="eventlist">
				<?php
					$s = $dbconn->query("SELECT * FROM events");
					foreach ($s as $row){
						echo "<li>{$row['name']} - {$row['venue']} - {$row['address']} ";
					}
				?>
			</div>
		</div>
		<div class="row">
			<div class="span4">
				<form method='get' class="form-horizontal">
				<fieldset>
				<legend>Add User</legend>
					<div class="control-group">
  					  <label class="control-label" for="name">Name</label>
					  <div class="controls">
						<input name="name" type="text" class="input-medium"> </input>
					  </div>
					</div>
					<div class="control-group">
  					  <label class="control-label" for="username">Username</label>
					  <div class="controls">
						<input name="username" type="text" class="input-medium"> </input>
					  </div>
					</div>
					<div class="control-group">
  					  <label class="control-label" for="password">Password</label>
					  <div class="controls">
						<input name="password" type="text" class="input-medium"> </input>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label" for="admin">Account Type</label>
					  <div class="controls">
						  <input type="radio" name="accountType" value="admin" /> Admin
						  <input type="radio" name="accountType" value="general" /> General
					  </div>
					</div>
					<button class="btn pull-right" name="addUser" type="submit" value="add">Add User</button>
					</fieldset>
				</form>
			</div>
			<div class="span4">
				<form method="get" class="form-horizontal">
				  <fieldset>
					<legend>Delete User</legend>
					<div class="control-group">
					  <label class="control-label" for="username">Username</label>
					  <div class="controls">
						<input type="text" class="input-medium" name="username">
					  </div>
					</div>
					<button class="btn pull-right" name="deleteUser" type="submit" value="delete">Delete</button>
				</form>
			</div>
			
			<div class="span4">
				<legend>User List</legend>
				<ul id="users">
				<?php
					$s = $dbconn->query("SELECT * FROM users");
					foreach ($s as $row) {
						echo "<li>{$row['username']} - account type: {$row['type']}</li>";
					}
				?>
				</ul>
			</div>
		</div>
		

    </div> <!-- /container -->

    <!-- javascript - Placed at the end of the document so the pages load faster -->
    <!-- jQuery via Google + local fallback, see h5bp.com -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>

	<!-- Bootstrap jQuery Plugins, compiled and minified -->
	<script src="js/bootstrap.min.js"></script>

	<!-- PrettyPrint for debugging, should remove from official release -->
	<script src="js/prettyprint.js"></script>
    
  </body>
</html>
