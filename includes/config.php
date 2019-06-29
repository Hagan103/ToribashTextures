<?php
	
	$dbUsername= $_ENV["USER"];
	$dbPassword= $_ENV["PASSWORD"];
	
	try {
		$conn = new PDO("mysql:host=toribashtexturescom.ipagemysql.com;dbname=database", $dbUsername, $dbPassword);
		
	}
	catch(PDOException $e)
    {
		echo $e->getMessage();
		die();
		
	}
?> 