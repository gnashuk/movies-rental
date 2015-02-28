<?php
	if(isset($_POST['submit'])) {
		session_start();
		$name = $_SESSION['movie'];
		include "DBadapter.php";
		$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
		$db->connect();
		$result = $db->getData("SELECT id_movie FROM movies WHERE title='$name'");
		$movie_id = mysql_result($result, 0, 0);
		$author = $_SESSION['user'];
		$today = date("Y-m-j");
		$text = stripslashes($_POST['comment']);
		$db->insertData("INSERT INTO reviews(id_movie, author, review_date, review_text) VALUES('$movie_id','$author','$today','$text')");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
	}
?>