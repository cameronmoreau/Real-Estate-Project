<?php
	header("content-type: json");
	require("inc.php");

	if(isset($_GET["address"])) {
		//Sanitize this
		$address = str_replace(" ", "+", $_GET["address"]);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address.
			"&key=".$api_keys["google"];

		$results = file_get_contents($url);
		echo $results;
	} else  {
		echo json_encode(array("results" => "error"));
	}
?>