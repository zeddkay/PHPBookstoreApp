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
require_once ("lib.php");
if (isset($_POST["submit"])){
	$search = $_POST["searchbox"];
	if (isPresent($search)) {
		$connection = connect();
		if (!mysqli_connect_errno()){
			$query = "SELECT * FROM book WHERE title LIKE '%$search%' order by rating desc";
			$result = mysqli_query($connection, $query);
			if (!$result)
			{
				die ("Book not found!");
			}
		} else {
			die("Database connection failed: ".mysqli_connect_error()." ( ". mysqli_connect_errno(). " )");
		}
	} else {
		die("Please enter a title to search for.");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Zukhruf's Bookstore - Search Results </title>
	 <link href="css/a2.css" rel="stylesheet" type="text/css">
  <style>
    table, th, td{border: solid 3px blue;}
  </style>
</head>
<div id="page-wrap">
    <pre>
    <?php
	echo "<br>";
	echo "<table> ";
	echo "<caption> Book Information </caption>";
	echo "<tr>";
		echo "<th> Book Title </th>";
		echo "<th> Book Author </th>";
		echo "<th> Publish Date </th>";
		echo "<th> View Book Details </th>";
	echo "</tr>";
	
	$pk = 0;
	
	 while ($row = mysqli_fetch_array($result)) {
		$pk = $row["bookID"];
		echo "<tr>";
			echo "<td>".$row["title"]."</td>";
			echo "<td>".$row["author"]."</td>";
			echo "<td>".$row["publishDate"]."</td>";
			echo "<td>"."<a href=viewDetails.php?bookID=$pk>View Details</a>"."</td>";
		echo "</tr>";
	}
	echo "</tr>";
	echo "</table>";
   ?>
   </pre>
   
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

<?php
require_once ("footer.php");
?>