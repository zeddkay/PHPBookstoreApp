<?php
echo "Zukhruf's Bookstore";
echo "<br>";
if(isset($_SESSION['username'])) { 
	echo "Welcome ". $_SESSION['username']. "!"; 
}
echo "<br><br>";
?>