<?php
session_start();
session_unset(); 
session_destroy();
?>
<?php
include ("header.php");
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Zukhruf's Bookstore - Home</title>
  <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
  <br>
  
  <a href="register.php">Register</a>
  <br><br>
  <a href="login.php">Login</a>
  <br><br><br>
  <p> Note: you have to login to use this site. </p> <br>
  <p> Please register first. </p> <br>
</div>
</body>
</html>

