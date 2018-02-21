<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
	session_unset(); 
	session_destroy(); 
}
?>

<?php
require_once ("header.php");
?>

<?php 
	require_once("lib.php");
	$connection = connect();
	if (mysqli_connect_errno()) {
		die("Database connection failed: ".mysqli_connect_error().
			" ( ". mysqli_connect_errno(). " )");
	} else {
		$pk = $_GET["bookID"];

		$update_query = "UPDATE book set rating = (Select avg(rating) from rating where bookID = '$pk') Where bookID = '$pk';";
		$update = mysqli_query($connection, $update_query);
		//mysqli_free_result($update);
		
		$query = "SELECT * FROM book WHERE bookID = $pk;";
		$result = mysqli_query($connection, $query);
	}
		if (!$result) {
			die ("Database query failed!");
		} 
		
			if (isset($_POST["submit"])){
				$rating = $_POST["rating"];
				$bookID = $pk;
				$username = $_SESSION['username'];
				//mysqli_free_result($result);
				$uquery = "UPDATE rating set rating='$rating' WHERE bookID='$bookID' ";
				$uquery.= "AND userName='$username'";
				$uresult = mysqli_query($connection, $uquery);
				$iquery = " ";
				
					//mysqli_free_result($uresult);
					$iquery = "INSERT INTO rating (userName, bookID, rating) VALUES ";
					$iquery .= "('$username', '$bookID', '$rating')";
					$iresult = mysqli_query($connection, $iquery);
					if (!$iresult) {
						echo "Rating wasn't inserted!";
					} else {
						echo "Rating inserted!";
						//mysqli_free_result($iresult);
					}
			} 
		
		
?>

<!DOCTYPE html>
<html>
<head>
<title> View Book Details </title>
 <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
	<h1>Book Details: </h1>
	<br>
	<pre>
    <?php
	 while ($row = mysqli_fetch_array($result)) {
		echo "<p>BookID: ".$row["bookID"]."</p>";
		echo "<p>Title: ".$row["title"]."</p>";
		echo "<p>Author: ".$row["author"]."</p>";
		echo "<p>Publish Date: ".$row["publishDate"]."</p>";
		echo "<p>ISBN: ".$row["isbn"]."</p>";
		echo "<p>Category: ".$row["category"]."</p>";
		echo "<p>Price($): ".$row["price"]."</p>";
		echo "<p>Status: ".$row["status"]."</p>";
		echo "<p>Rating: ".$row["rating"]."</p>";
		echo "<p>Note: ".$row["note"]."</p>";
	}
   ?>
	</pre>
	
	<form name="rating" method ="POST" >
	Rating: <select name="rating">
		  <option value="0">0</option>
		  <option value="1" selected="selected">1</option>
		  <option value="2">2</option>
          <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5">5</option>
		  </select><br><br>
	<input type="submit" name="submit" value="Submit rating">
	</form>
	
   <?php 
	mysqli_free_result($result);
   ?>
   
  <br><br>
	<div align ="center">
	<a href="index.php">Home</a> &nbsp;&nbsp;&nbsp;
	<a href="menu.php">Menu</a> &nbsp;&nbsp;&nbsp;
	<a href="logoff.php">Logoff</a>
	</div>
	<br>
  </div>
</body>
</html>

<?php 
	mysqli_close($connection);
?>

