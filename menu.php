<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
	session_unset(); 
	session_destroy(); 
}
?>
<?php
include ("header.php");
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Zukhruf's Bookstore - Menu</title>
   <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
  <br>
  <h3> Menu: </h3>
  <br>
  <a href="addBook.php">Add a Book</a>
  <br><br>
  <a href="viewBooks.php">View Books</a>
  <br><br>
  
 <form name="search" method="POST" action="search.php">
  Search by book title:
  <br>
  <input type = "text" name="searchbox"> &nbsp;
  <input type="submit" name="submit" value="Search">
  </form>
  
  <br>
  <div align ="center">
	<a href="index.php">Home</a> &nbsp;&nbsp;&nbsp;
	
	<a href="logoff.php">Logoff</a>
	</div>
  <br>
</div>
</body>
</html>

