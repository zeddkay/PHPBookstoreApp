<?php
include 'lib.php';
ob_start();
session_start();
?>

<?php
include ("header.php");
?>

<?php
$username = $password = "";
$errorMessage = "";

if (isset($_POST["submit"])){
	$rememberLogin = isset($_POST['rememberLogin']);
	$forgetLogin = isset($_POST['forgetLogin']);
	if (isPresent($_POST['username'])) {
		$username = trim($_POST['username']);
	}
	if (isPresent($_POST['password'])) {
		$password = $_POST['password'];
	}
				if ($rememberLogin){
					setcookie("username", $username, time() + 60*60*24*7, "/", "zenit.senecac.on.ca", 0);
					setcookie("password", $password, time() + 60*60*24*7, "/", "zenit.senecac.on.ca", 0);
				}
  
				if ($forgetLogin){
					setcookie ("username", "", time() - 3600 , '/', "zenit.senecac.on.ca", 0);
					setcookie ("password", "", time() - 3600 , '/', "zenit.senecac.on.ca", 0);
				}
  
	if (isPresent($username) && isPresent($password)) {
		//$errorMessage = "Registration is valid!";
		$connection= connect();
		if (!mysqli_connect_errno()){
			$password = md5($password);
			//$query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
			$query = "SELECT * FROM users WHERE userName='$username' AND password='$password'";
			$result = mysqli_query($connection, $query);
			if (mysqli_num_rows($result) >0) {
				
				
				
				//die ("Query successful!");
				$errorMessage = "Found login!";
				$_SESSION['username'] = $username;
				header("Location: menu.php");
			} else {
				$errorMessage="Login credentials not found!!";
			}
		} else {
			die("Database connection failed: ".mysqli_connect_error()." ( ". mysqli_connect_errno(). " )");
		}
	} else {
		$errorMessage = "Please enter a valid username and password!";	
	}
  
  

}
?>

<!DOCTYPE HTML>
<html>
<head>
  <title>Zukhruf's Bookstore - Login</title>
   <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
<h1>Welcome to Zukhruf's bookstore</h1> 
<br>


<form name="lab6" method="POST" action="login.php">

Username:<input type="text" name="username"
value="<?php if(isset($_COOKIE['username'])) { echo $_COOKIE['username'];} ?>">
<br>

Password:<input type="password" name="password"
value="<?php if (isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>">
<br>

<input type="submit" value="Login" name="submit">
<br><br>

Remember Me? <input type="checkbox" name="rememberLogin"> 
<br>

Forget Me? <input type="checkbox" name="forgetLogin">
<br><br>

<br><br>

<span style="color:red"><?php echo $errorMessage;?></span>

</form>
<br><br><br>
<a href="index.php">Home</a> 
<br><br><br>

 <script>      var dt=new Date(document.lastModified);      
      document.write("<mark> This page was last modified on " +                        
                     dt.toLocaleString() + "</mark>"); </script> 
</div>
</body>
</html>
<?php ob_end_flush();?>

