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
	$errTitle = $errAuthor = $errPublishDate = $errIsbn = $errPrice = ' ';
	$valid = false;
	//$count = 0;
	if (isset($_POST["submit"])) {
		$title = trim($_POST["title"]);
		$author = trim($_POST["author"]);
		$publishDate = trim($_POST["publishDate"]);
		$isbn = trim($_POST["isbn"]);
		$category = $_POST["category"];
		$price = trim($_POST["price"]);
		$status = $_POST["status"];
		$rating = $_POST["rating"];
		$note = htmlspecialchars($_POST['note']);
		$valid = true;
		
		
		if (!isPresent($title)) {
			$errTitle = 'Error: Input title.';
			$valid = false;
		}
		
		if (!isPresent($author)) {
			$errAuthor = "Error: Input author.";
			$valid = false;
		}
		
		if (!isPresent($publishDate)) {
			$errPublishDate = "Error: Input publish date in format mm/dd/yyyy.";
			$valid = false;
		}
		if (isPresent($publishDate)) {
			if (!isValidDate($publishDate)) {
				$errPublishDate = "Error: Input publish date in format mm/dd/yyyy.";
				$valid = false;
			}
		}	
		
		if (!isPresent($isbn)) {
			$errIsbn = "Error: Input ISBN.";
			$valid = false;
		}
		
		if (isPresent($isbn)) {
			if (!isValidISBN($isbn)) {
				$errIsbn = "Error: ISBN ".$isbn." already exists.";
				$valid = false;
			} 
		}
		
		// no need to check if category is set, because it has been set by default and cannot be unset by user
		
		if (!isValidPrice($price)) {
			$errPrice = "Error: Input a numeric value for price.";
			$valid = false;
		}
		
		
	} 
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Zukhruf's Bookstore</title>
	 <link href="css/a2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-wrap">
	<br>
	
	<form name = "lab4" method = "post" action="addBook.php">
	Title: <input type="text" name="title"
	value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
		<span class="error" style="color:red"  > <?php echo $errTitle; ?> </span>
	<br><br>
	
	Author: <input type="text" name="author"
	value="<?php if (isset($_POST['author'])) echo $_POST['author']; ?>"> 
		<span class="error" style="color:red"  > <?php echo $errAuthor; ?> </span>
	<br><br>
	
	Publish Date: <input type="text" name="publishDate" 
	value="<?php if (isset($_POST['publishDate'])) echo $_POST['publishDate']; ?>"> 
		<span class="error" style="color:red"  > <?php echo $errPublishDate; ?> </span>
	<br><br>
	
	ISBN: <input type="text" name="isbn"
	value="<?php if (isset($_POST['isbn'])) echo $_POST['isbn']; ?>"> 
		<span class="error" style="color:red"  > <?php echo $errIsbn; ?> </span>
	
	<br><br>
	
	Category: <input type="radio" name="category" value="Hardcover" checked="checked">Hardcover
			  <input type="radio" name="category" value="Paperback">Paperback
		      <input type="radio" name="category" value="eBook">eBook<br><br>
	
	Price($): <input type="text" name="price"
	value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>"> 
	<span class="error" style="color:red"  > <?php echo $errPrice; ?> </span>
	<br><br>
	
	Status: <select name="status">
		  <option value="in stock" selected="selected">in stock</option>
		  <option value="out of stock">outofstock</option>
		  <option value="pre-order">preorder</option>
		  <option value="N/A">N/A</option>
		  </select> <br><br>
	
	Rating: <select name="rating">
		  <option value="0">0</option>
		  <option value="1" selected="selected">1</option>
		  <option value="2">2</option>
          <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5">5</option>
		  </select><br><br>
	
	Note: <textarea name="note" value = "note" rows="4" cols="50"></textarea>
	<br><br>
	
	<input type = "submit" value = "Add Book" name="submit"/>
	
	<br><br>
	<div align ="center">
	<a href="index.php">Home</a> &nbsp;&nbsp;&nbsp;
	<a href="menu.php">Menu</a> &nbsp;&nbsp;&nbsp;
	<a href="logoff.php">Logoff</a>
	</div>
	<br>
	
	</form>
	
	
	<?php
	if ($valid == true ) {
		$added = 0;
		$connectDB = connect();
		$query = "INSERT INTO book ";
		$query .= "(title, author, publishDate, isbn, category, price, status, note) VALUES ";
		$query .= "('$title', '$author', '$publishDate', '$isbn' , '$category', '$price' ,'$status', '$note')";
				
		$result = mysqli_query($connectDB, $query);
		if (!$result) {
			die ("Data insert failed: ".mysqli_error($connection)."(".mysqli_errno($connection). ")");
		} else {
			echo "Book added!";
			$added++;
		}
		
		$username = $_SESSION['username'];
		//$bookID =  mysqli_insert_id($connectDB);
		if ($added > 0) {
			$queryID = "SELECT MAX(bookID) As max_id from book";
			$resultID = mysqli_query($connectDB, $queryID);
			$row = mysqli_fetch_array($resultID);
			$bookID = $row["max_id"];
			$query2 = "INSERT INTO rating (userName, bookID, rating) VALUES ";
			$query2 .= "('$username', '$bookID', '$rating')";
		
			$result2 = mysqli_query($connectDB, $query2);
			if (!$result2) {
				die ("Data insert failed: ".mysqli_error($connection)."(".mysqli_errno($connection). ")");
			} else {
				echo "<br>";
				echo "Rating added!";
			}
		}
	}
	?>
	
	<br><br>

	</div>
</body>
</html>

