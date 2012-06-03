<?php
	session_start();
	 
	include "config.inc.php";
	try {
	  $dbconn = new PDO('mysql:host=localhost;dbname='.$config['db'], $config['user'], $config['pass']);
	}
	catch (Exception $e) {
	  echo "Error: " . $e->getMessage();
	}

	function curPageURL() {
		 $pageURL = 'http';
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}

	//add event
	if(isset($_GET['addEvent']) && $_GET['addEvent'] == "add"){
		if (!empty($_GET['event_name']) && !empty($_GET['date']) && !empty($_GET['venue']) && !empty($_GET['address']) && !empty($_GET['description']) && !empty($_GET['lat']) && !empty($_GET['lng'])){
			if ($_SESSION['username'] != null && $_SESSION['type'] == "admin"){
				$q = $dbconn->query("SELECT * FROM events");
				$doIt = true;
				foreach($q as $row){
					if ($_GET['event_name'] == $row['name']){
						$doIt = false;
					}
				}

				if ($doIt){
					if ($sql = $dbconn->prepare("INSERT INTO `events` (`name`, `date`, `address`, `venue`, `description`, `lat`, `lng` ) VALUES ('{$_GET['event_name']}', '{$_GET['date']}', '{$_GET['address']}', '{$_GET['venue']}', '{$_GET['description']}', '{$_GET['lat']}', '{$_GET['lng']}')")){
						$sql->execute();
						echo "success";
					}
					else{
						echo "database error";
					}
				}
				else {
					echo "dupe";
				}
			}
			else{
				echo "not admin";
			}
		}
		else {
			echo "please fill the whole thing out";
			echo curPageURL();
		}
	}
?>








