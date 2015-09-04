<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/stylesheet.css">
	<title></title>
</head>
<body>
<div id="img">
<img src="assets/images/logo.jpeg"/>
</div>
<div class="main">

<?php
	function getCrime($lat, $lng){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://data.police.uk/api/crimes-at-location?lng=" . $lng . "&lat=" . $lat . "");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: text/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($json);
	//	return count($data);
		echo count($data);
	}
	function find($location){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://api.zoopla.co.uk/api/v1/property_listings.json?area=" . $location . "&api_key=c88442waawanw44ygzem2ee2");
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  		$json = curl_exec($ch);
  		curl_close($ch);      
  
  		$data = json_decode($json);
  		//var_dump($data);

  		$listData = array();
  		if (isset($data->error_code)){
  			echo "
  				<h3 style='text-align:center'>Sorry but this location is unavailable</h3>";		
  		}
  		else{
	  		foreach ($data->listing as $item) { 
	  			$listData[] = array(
	  				'numBedrooms' => $item->num_bedrooms,
	  				'price'=> $item->price,
	  				'description'=> $item->description,
	  				'county' => $item->county,
	  				'propertyType' => $item->property_type,
	  				'address' => $item->displayable_address,
	  				'lng' => $item->longitude,
	  				'lat' => $item->latitude
	  			);
	  		}
			//var_dump($listData);
			return $listData;
		}
	}
	$results = find($_POST['location']);
?>

	<?php if(count($results) > 0 ): ?>
		<?php foreach($results as $result): ?>
			<h5>Area: <?= $result['county']?></h5>
			<p>Address: <?= $result['address']?></p>
			<p>Property Type: <?= $result['propertyType']?></p>		
			<p>Number of Bedrooms: <?= $result['numBedrooms']?></p>
			<p>Price: £<?= $result['price']?></p>
			<p>Description: <?= $result['description']?></p><br><br>
			<p>Crime Count: <?= getCrime($result['lat'], $result['lng']);?></p>
			<p>_________________________________________________________________________________________________________________</p>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
</body>
</html>



