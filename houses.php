<?php
	function find($location){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://api.zoopla.co.uk/api/v1/property_listings.json?area=" . $location . "&api_key=c88442waawanw44ygzem2ee2");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: text/json'));
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  		$json = curl_exec($ch);
  		curl_close($ch);      
  
  		$data = json_decode($json);
  		//var_dump($data);

  		$listData = array();
  		if (isset($data->error_code)){
  			echo "
  				<h3>Sorry but this location is unavailable</h3>";		
  		}
  		else{
	  		foreach ($data->listing as $item) { 
	  			$listData[] = array(
	  				'numBedrooms' => $item->num_bedrooms,
	  				'area'=> $data->area_name,
	  				'price'=> $item->price,
	  				'description'=> $item->description,
	  				'county' => $item->county,
	  				'propertyType' => $item->property_type,
	  				'address' => $item->displayable_address
	  			);
	  		}
			//var_dump($listData);
			return $listData;
		}
	}
	$results = find($_POST['location']);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/stylesheet.css">
	<title></title>
</head>
<body>
	<?php if(count($results) > 0 ): ?>
		<?php foreach($results as $result): ?>
			<h5>Area: <?= $result['area']?></h5>
			<h6>County: <?= $result['county']?></h6>
			<p>Address: <?= $result['address']?></p>
			<p>Property Type: <?= $result['propertyType']?></p>		
			<p>Number of Bedrooms: <?= $result['numBedrooms']?></p>
			<p>Price: £<?= $result['price']?></p>
			<p>Description: <?= $result['description']?></p>
		<?php endforeach; ?>
	<?php endif; ?>
</body>
</html>



