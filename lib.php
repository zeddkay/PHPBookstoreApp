<?php

function connect() { 

ob_start();
$dbhost = "localhost";
$dbname = "";
$dbpass = "";
$dbuser = "";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        
	if (mysqli_connect_errno()) {
		die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect+errno.")");
	} 
//$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
return $connection;
}	

function isPresent($value) {
	return isset($value) && !empty($value);
}

function isValidDate($value) {
	return ((strlen($value)==10) && (substr_count($value, "/")==2));
}

function isValidISBN($value) {
	$sql = "SELECT * FROM book where isbn=$value";
	//if no rows in result set, meaning no matching isbn
	return mysqli_query(connect(), $sql);
}

function isValidPrice($value) {
	return (($value > 0) && (is_numeric($value)) && (isset($value)) && (!empty($value)));
}

function sqlquery($query) {
	$result = mysqli_query(connect(), $query);
	return $result;
}

function protect($value){
	$value = filter_var($value, FILTER_SANITIZE_STRING);
     return trim(strip_tags($value));
}


//}
?>