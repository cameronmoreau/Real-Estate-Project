<?php
	header("content-type: json");

	if(isset($_GET["street"]) && isset($_GET["number"])) {
		#SANITIZE
		$street = strtoupper($_GET["street"]);
		$street_number = $_GET["number"];
		$account = "";

		require("../inc/db.php");
		mysql_select_db("real_estate_webscrape");
		$query = mysql_query("SELECT * FROM dallas_county_accounts WHERE street_number='$street_number' AND street LIKE '$street'");
		while($row = mysql_fetch_assoc($query)) {
			//print_r($row);
			$account = $row["account_id"];
		}

		$values = array();
		$ch = curl_init("http://www.dallascad.org/AcctDetailRes.aspx?ID=".$account);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$site = curl_exec($ch);

		$dom  = new DOMDocument();
		@$dom->loadHTML($site);
		$xpath = new DOMXpath($dom);

		$values["account_number"] = explode(' ', $dom->getElementById("lblPageTitle")->nodeValue)[2];
		$values["address"] = $dom->getElementById("PropAddr1_lblPropAddr")->nodeValue;
		$values["value_improvement"] = $dom->getElementById("ValueSummary1_lblImpVal")->nodeValue;
		$values["value_land"] = $dom->getElementById("ValueSummary1_pnlValue_lblLandVal")->nodeValue;
		$values["value_total"] = $dom->getElementById("ValueSummary1_pnlValue_lblTotalVal")->nodeValue;

		$owner = $xpath->query("//span[@id='lblOwner']")->item(0)->parentNode;
		$owner_html = get_inner_html($owner);
		$s1 = "<span id=\"lblOwner\" class=\"DtlSectionHdr\">Owner (Current 2015)</span>";
		$s2 = "<a name=\"MultiOwner\"/>";
		$mid = middle_trim($owner_html, $s1, $s2);

		$mid_explode = explode("<br/>", $mid);
		$mid_explode[1] = str_replace("&amp;", "", $mid_explode[1]);
		$mid_explode[2] = trim($mid_explode[2]);
		$mid_explode[2] = substr($mid_explode[2], 0, strlen($mid_explode[2]) - 15);
		$values["owner"] = $mid_explode[0];
		$values["owner_address"] = $mid_explode[1]." ".$mid_explode[2];
		echo json_encode($values);
	} else {
		echo json_encode(array("results" => "error"));
	}

	function get_inner_html( $node ) {
	    $innerHTML= '';
	    $children = $node->childNodes;
	    foreach ($children as $child) {
	        $innerHTML .= $child->ownerDocument->saveXML( $child );
	    }

	    return $innerHTML;
	}

	function middle_trim($full, $start, $stop) {
		$start_pos = strpos($full, $start) + strlen($start);
		$end_pos = strpos($full, $stop);
		$new = substr($full, $start_pos, $end_pos - $start_pos);

		return $new;
	}
?>