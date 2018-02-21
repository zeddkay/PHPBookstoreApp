<?php
ob_start();
require_once ("header.php");
?>

<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
  <title>Zukhruf's Bookstore - Logoff</title>
   <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
  Goodbye 
  <?php 
    if(isset($_SESSION['username'])) { 
		echo $_SESSION['username']; 
		session_unset(); 
		session_destroy(); 
	}
	?>
	... see you soon!
	<br>
	
    <a href="index.php">Back To Homepage</a>
	<br><br><br>

	<br><br><br>
	 <script>      var dt=new Date(document.lastModified);      
      document.write("<mark> This page was last modified on " +                        
                     dt.toLocaleString() + "</mark>"); </script> 
  
  </div>
  </body>
</html>