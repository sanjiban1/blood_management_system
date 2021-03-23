<?php
if(!empty($_GET['brand_id'])) {
	if($_GET['brand_id'] == 'All Brands') {
		$a_brand = '';
		$b_brand = '';
	} else {
		$a_brand = '&brand_id=';
		$b_brand = $_GET['brand_id'];
	}	
} else {
	$a_brand = '';
	$b_brand = '';
}

if(!empty($_GET['model_id'])) {
	if($_GET['model_id'] == 'All Models') {
		$a_model = '';
		$b_model = '';	
	} else {
		if($_GET['brand_id'] == 'All Brands') {
			$a_model = '';
			$b_model = '';
		} else {
			$a_model = '&model_id=';
			$b_model = $_GET['model_id'];
		}
	}
	
} else {
	$a_model = '';
	$b_model = '';
}

if(!empty($_GET['car_condition'])) {
	if($_GET['car_condition'] == 'All Cars') {
		$a_car_condition = '';
		$b_car_condition = '';
	} else {
		$a_car_condition = '&car_condition=';
		$b_car_condition = $_GET['car_condition'];
	}	
} else {
	$a_car_condition = '';
	$b_car_condition = '';
}

if(!empty($_GET['price_range'])) {
	if($_GET['price_range'] == 'All Prices') {
		$a_price_range = '';
		$b_price_range = '';
	} else {
		$a_price_range = '&price_range=';
		$b_price_range = $_GET['price_range'];
	}
} else {
	$a_price_range = '';
	$b_price_range = '';
}

if(!empty($_GET['car_category_id'])) {
	if($_GET['car_category_id'] == 'All Categories') {
		$a_car_category_id = '';
		$b_car_category_id = '';
	} else {
		$a_car_category_id = '&car_category_id=';
		$b_car_category_id = $_GET['car_category_id'];
	}
} else {
	$a_car_category_id = '';
	$b_car_category_id = '';
}

if(!empty($_GET['body_type_id'])) {
	if($_GET['body_type_id'] == 'Not Specified') {
		$a_body_type_id = '';
		$b_body_type_id = '';
	} else {
		$a_body_type_id = '&body_type_id=';
		$b_body_type_id = $_GET['body_type_id'];
	}
} else {
	$a_body_type_id = '';
	$b_body_type_id = '';
}

if(!empty($_GET['fuel_type_id'])) {
	if($_GET['fuel_type_id'] == 'Not Specified') {
		$a_fuel_type_id = '';
		$b_fuel_type_id = '';
	} else {
		$a_fuel_type_id = '&fuel_type_id=';
		$b_fuel_type_id = $_GET['fuel_type_id'];
	}
} else {
	$a_fuel_type_id = '';
	$b_fuel_type_id = '';
}

if(!empty($_GET['transmission_type_id'])) {
	if($_GET['transmission_type_id'] == 'Not Specified') {
		$a_transmission_type_id = '';
		$b_transmission_type_id = '';
	} else {
		$a_transmission_type_id = '&transmission_type_id=';
		$b_transmission_type_id = $_GET['transmission_type_id'];
	}
} else {
	$a_transmission_type_id = '';
	$b_transmission_type_id = '';
}

if(!empty($_GET['year'])) {
	if($_GET['year'] == 'Not Specified') {
		$a_year = '';
		$b_year = '';
	} else {
		$a_year = '&year=';
		$b_year = $_GET['year'];
	}
} else {
	$a_year = '';
	$b_year = '';
}


if(!empty($_GET['mileage_start'])) {
	if($_GET['mileage_start'] == '') {
		$a_mileage_start = '';
		$b_mileage_start = '';
	} else {
		$a_mileage_start = '&mileage_start=';
		$b_mileage_start = $_GET['mileage_start'];
	}
} else {
	$a_mileage_start = '';
	$b_mileage_start = '';
}

if(!empty($_GET['mileage_end'])) {
	if($_GET['mileage_end'] == '') {
		$a_mileage_end = '';
		$b_mileage_end = '';
	} else {
		$a_mileage_end = '&mileage_end=';
		$b_mileage_end = $_GET['mileage_end'];
	}
} else {
	$a_mileage_end = '';
	$b_mileage_end = '';
}


if(!empty($_GET['country'])) {
	$a_country = '&country=';
	$b_country = $_GET['country'];
} else {
	$a_country = '';
	$b_country = '';
}

if(!empty($_GET['state'])) {
	$a_state = '&state=';
	$b_state = $_GET['state'];
} else {
	$a_state = '';
	$b_state = '';
}


if(!empty($_GET['city'])) {
	$a_city = '&city=';
	$b_city = $_GET['city'];
} else {
	$a_city = '';
	$b_city = '';
}



$all_gets = '';
$all_gets = $a_brand.$b_brand.$a_model.$b_model.$a_car_condition.$b_car_condition.$a_price_range.$b_price_range.$a_car_category_id.$b_car_category_id.$a_body_type_id.$b_body_type_id.$a_fuel_type_id.$b_fuel_type_id.$a_transmission_type_id.$b_transmission_type_id.$a_year.$b_year.$a_mileage_start.$b_mileage_start.$a_mileage_end.$b_mileage_end.$a_country.$b_country.$a_state.$b_state.$a_city.$b_city;

if($all_gets != '') {
	$location = 'search.php?'.$all_gets;
	$arr = explode('?',$location);
	$part1 = $arr[0];
	$part2 = substr($arr[1],1,(strlen($arr[1])-1));
	$final_location = $part1.'?'.$part2;	
} else {
	$final_location = 'search.php';
}

header('location: '.$final_location);