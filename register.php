<?php 
ob_start();
session_start();
require_once ("header.php");
require_once("lib.php");
$errorMessage = " ";
if (isset($_POST["submit"])){
	$username = trim($_POST['username']);
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	if (isPresent($username) && isPresent($password) && isPresent($confirmPassword)) {	
		if ($password != $confirmPassword) {
			$errorMessage = "REGISTRATION FAILED: Please enter two matching passwords!";
		} else {
			$errorMessage = "Registration is valid!";
			$connection= connect();
			if (!mysqli_connect_errno()){
				$username = protect($username);
				$password = protect($password);
				$password = md5($password);
				$query = "INSERT into users VALUES ('$username', '$password')";
				$result = mysqli_query($connection, $query);
				if ($result) {
					//die ("Query successful!");
					$_SESSION['username'] = $username;
					header("Location: menu.php");
				} else {
					die ("Database query failed!");
				}
			} else {
				die("Database connection failed: ".mysqli_connect_error()." ( ". mysqli_connect_errno(). " )");
			}
		}
	} else {
		$errorMessage = "Please enter a username and two passwords that match!";	
	}
}

	
?>


<!DOCTYPE HTML>
<html>
<head>
  <title>Zukhruf's Bookstore - Register</title>
   <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
<h3>Register an Account</h3> 
<br><br>

<form name="register" method="POST" action="register.php">

Username:<input type="text" name="username" value="">
<br><br>

Password:<input type="password" name="password" value="">
<br><br>

Confirm Password:<input type="password" name="confirmPassword" value="">
<br><br>

<span style="color:red"><?php echo $errorMessage;?></span>
<br><br>

<input type="submit" value="Register" name="submit">
<br><br>

<a href="index.php">Home</a>
<br><br>



</form>
<br><br><br>

 <script>      var dt=new Date(document.lastModified);      
      document.write("<mark> This page was last modified on " +                        
                     dt.toLocaleString() + "</mark>"); </script> 
</div>
</body>
</html>

