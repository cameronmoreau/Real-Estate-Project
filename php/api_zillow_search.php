<?php
	header("content-type: json");
	require("api_inc.php");

	

	if(isset($_GET["address"]) && isset($_GET["zip"])) {
		//THIS DATA NEEDS TO BE SANITIZED. Security (:
		$address = $_GET["address"];
		$zip = $_GET["zip"];

		//Basic search url
		$url = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=".$api_keys["zillow"]."&address=".$address."&citystatezip=".$zip;

		$results = simplexml_load_file($url);
		$results = json_encode($results);
		echo $results;
	} else {
		echo json_encode(array("request" => "Error"));
	}
?>