<?php 
		require_once("lib.php");
		$connection = connect();
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		} 
		/*
		$result = $connection->query("SHOW DATABASES LIKE 'Bookstore'");
		$row = mysqli_fetch_row($result);
		if ($row[0]) {
			$connection->query("drop DATABASE Bookstore");
			echo("Dropping Database<br>");
		}
		$connection->query("CREATE DATABASE Bookstore");
		$connection->query("use Bookstore");
        */
        
        $connection->query("Create table book (bookID int(8) not null AUTO_INCREMENT DEFAULT null, title varchar(50) not null, author varchar(60) not null, publishDate char(11) not null, category varchar(12) not null, price float(7, 2) not null, status varchar(13) not null, rating float(3, 2) null default null, note text null default null, isbn char(14) not null, primary key (bookID));");
        $connection->query("create table users (userName varchar(30) not null, password varchar(32) not null, primary key (userName));");
        $connection->query("create table rating (userName varchar(30) not null, bookID int(10) not null, rating decimal (5, 2) null default null, primary key (userName, bookID), foreign key (userName) REFERENCES users(userName), FOREIGN key (bookID) references book(bookID));");
		
		
?>