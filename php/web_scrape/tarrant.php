<?php
	header("content-type: json");

	if(isset($_GET["account"])) {
		#SANITIZE
		$account = $_GET["account"];

		$values = array();

		$ch = curl_init("http://www.tad.org/property-data-sheet-residential?keyword=".$account);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$site = curl_exec($ch);

		$dom  = new DOMDocument();
		@$dom->loadHTML($site);
		$xPath = new DOMXpath($dom);
		//get account number from the path
		$values["account_number"] = mb_convert_encoding($xPath->query("//div[@class='item-page']/div[1]/table/tr[1]/td[2]")->item(0)->textContent,'HTML-ENTITIES','UTF-8');
		$values["account_number"] = trim($values["account_number"], "&nbsp; \t\n\r\0\x0B");
		printf($values["account_number"]);printf("\n");
		//get the property address
		$address_info = mb_convert_encoding($xPath->query("//div[@class='item-page']/div[1]/table/tr[3]/td[2]")->item(0)->textContent,'HTML-ENTITIES','UTF-8');
		$address_info = trim($address_info,"&nbsp; \t\n\r\0\x0B");
		print_r($address_info);printf("\n");
		$values["account_address"] = $address_info;
		//gets all the values
		$values["value_improvement"] = mb_convert_encoding($xPath->query("//div[@class='item-page']/div[1]/div/table/tr[3]/td[3]")->item(0)->textContent,'HTML-ENTITIES','UTF-8');
		print_r($values["value_improvement"]);printf("\n");
		
		$values["value_land"] = mb_convert_encoding($xPath->query("//div[@class='item-page']/div[1]/div/table/tr[3]/td[2]")->item(0)->textContent,'HTML-ENTITIES','UTF-8');
		print_r($values["value_land"]);printf("\n");
		
		$values["value_total"] = mb_convert_encoding($xPath->query("//div[@class='item-page']/div[1]/div/table/tr[3]/td[4]")->item(0)->textContent,'HTML-ENTITIES','UTF-8');
		print_r($values["value_total"]);printf("\n");
		
		//getting owner information for mailing purposes
		$owner_info = mb_convert_encoding($xPath->query("//div[@class='item-page']/div[1]/table/tr[4]/td[2]")->item(0)->textContent,'HTML-ENTITIES','UTF-8');
		$owner_info = trim($owner_info, "&nbsp; \t\n\r\0\x0B");
		$owner_explode = explode("                                          &nbsp;&nbsp;&nbsp;", $owner_info);
		$owner_address = "";
		$owner_name = "";
		//function to check if there are more than one owner
		if(sizeof($owner_explode) > 3){
			$number_of_elements = sizeof($owner_explode);
			$owner_name = trim($owner_explode[0]);
			for( $i = 1; $i < $number_of_elements -2 ; $i++){
				$owner_name = $owner_name. ", " . trim($owner_explode[$i]);
			}
			$owner_address = trim($owner_explode[$number_of_elements- 2]). " ".trim($owner_explode[$number_of_elements - 1]); 
		}else{
			// for the case of just one owner
			$owner_name = trim($owner_explode[0]);
			$owner_address = trim($owner_explode[1])." " . trim($owner_explode[2]);
		}
		printf($owner_name);printf("\n");
		printf($owner_address);printf("\n");
		
		$values["owner"] = $owner_name;
		$values["owner_address"] = $owner_address; 
		echo json_encode($values);
		
	} else {
		echo json_encode(array("results" => "error"));
	}
	

?>